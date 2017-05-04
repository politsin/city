<?php

namespace Drupal\city\Controller;

/**
 * @file
 * Contains \Drupal\app\Controller\AjaxResult.
 */

use Drupal\Core\Controller\ControllerBase;
use Drupal\city\Idn\IdnaConvert;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;

/**
 * Controller routines for page example routes.
 */
class GetCity extends ControllerBase {

  /**
   * AJAX Responce.
   */
  public static function get() {
    $data = &drupal_static('GetCity::get()');
    if (!isset($data)) {
      $host = \Drupal::request()->getHost();
      $lang = \Drupal::languageManager()->getCurrentLanguage()->getId();
      $cache_key = 'city:' . $host . ':' . $lang;

      if ($cache = \Drupal::cache()->get($cache_key)) {
        $data = $cache->data;
      }
      else {
        $data = self::detect($host);
        \Drupal::cache()->set($cache_key, $data);
      }
      self::redirects($host, $data);
    }

    return $data;
  }

  /**
   * AJAX Responce.
   */
  public static function redirects($host, &$data) {

    $domen = substr(strstr($host, '.'), 1);
    $subdomain = strstr($host, '.', TRUE);

    // 1. Редирект на www для базовых сайтов.
    $domains = ['synapse-studio.ru', 'synapse-uk.com', 'synapse-dc.com'];
    if (in_array($host, $domains)) {
      $path = \Drupal::request()->getRequestUri();
      $response = new RedirectResponse("https://www.{$host}{$path}");
      $response->send();
    }

    // 2. Рердирект с неправильного SUB на корневой домен.
    if ($subdomain != 'www' && $domen != $data['info']['domen']) {
      $response = new RedirectResponse("https://www.{$domen}");
      $response->send();
    }

    // 3. Доступ к страницам некорневых доменов.
    if ($subdomain != 'www') {
      $frontpage = \Drupal::service('path.matcher')->isFrontPage();
      $node = \Drupal::request()->attributes->get('node');
      if ($domen == 'synapse-studio.ru') {
        // Доступ для главной и node_promo.
        if ($frontpage || (is_object($node) && $node->getType() == 'promo')) {
          $data['info']['theme'] = 'promo';
        }
        else {
          $data['info']['theme'] = 'blank';
        }
      }
      if ($domen == 'synapse-dc.com' || $domen == 'synapse-uk.com') {
        // Доступ к главной.
        if ($frontpage) {
          $data['info']['theme'] = 'promo';
        }

      }

    }

  }

  /**
   * AJAX Responce.
   */
  public static function detect($host) {
    $idn = new IdnaConvert();
    $domain = $idn->decode($host);
    $subdomain = strstr($domain, '.', TRUE);
    $domen = substr(strstr($domain, '.'), 1);

    $city = ['info' => ['theme' => 'blank', 'error' => FALSE]];

    // Досук к корневому доступу только по www.
    if ($subdomain == 'www') {
      // Базовый сайт.
      if ($host == 'www.synapse-studio.ru') {
        $city['info']['theme'] = FALSE;
      }
    }
    else {
      $city = self::getCity($subdomain);
      if ($domen == $city['info']['domen']) {

      }
      // Запрет доступа с неправильного SUB.
      else {
        $city['info']['theme'] = 'blank';
      }
    }
    return $city;
  }

  /**
   * Get City.
   */
  public static function getCity($subdomain) {
    $id = self::query($subdomain);
    $config = \Drupal::config('city.settings');
    $info = [
      'domen' => FALSE,
      'theme' => 'blank',
      'phone' => $config->get('phone'),
      'address' => $config->get('address'),
    ];
    $city['info'] = $info;

    if (is_numeric($id)) {
      $storage = \Drupal::entityManager()->getStorage('city');
      $entity = $storage->load($id);

      $tid = $entity->field_tx_world->entity->id();
      if ($tid) {
        $terms_storage = \Drupal::service('entity_type.manager')->getStorage("taxonomy_term");
        $parents = $terms_storage->loadAllParents($tid);
        foreach ($parents as $tid => $term) {
          if ($term->field_world_domen->value) {
            $info = [
              'id' => $tid,
              'domen' => $term->field_world_domen->value,
              'theme' => $term->field_world_theme->value,
              'phone' => $term->field_world_phone->value,
              'address' => $term->field_world_address->value,
            ];
          }
        }
      }

      // Vars.
      $phone = $entity->phone->value;
      $name = $entity->name->value;
      $address = $entity->address->value;
      $city = [
        'city'  => ($name != 'Промо') ? $name : '',
        'city2' => $entity->title_ru->value,
        'phone' => $phone ? $phone : $info['phone'] ,
        'address' => $address ? $address : $info['address'],
        'info' => $info,
      ];
    }
    return $city;
  }

  /**
   * AJAX Responce.
   */
  public static function query($subdomain) {
    $query = \Drupal::entityQuery('city')
      ->condition('path_ru', $subdomain);
    $ids = $query->execute();
    $id = array_shift($ids);
    return $id;
  }

}
