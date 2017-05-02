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
      self::redirects($host);

      if ($cache = \Drupal::cache()->get($cache_key)) {
        $data = $cache->data;
      }
      else {
        $data = self::detect($host);
        \Drupal::cache()->set($cache_key, $data);
      }
    }

    return $data;
  }

  /**
   * AJAX Responce.
   */
  public static function redirects($host) {
    $subdomain = strstr($host, '.', TRUE);
    $path = \Drupal::request()->getRequestUri();
    $domains = [
      'synapse-studio.ru' => 'synapse-studio',
      'synapse-uk.com' => 'synapse-uk',
      'synapse-dc.com' => 'synapse-dc',
    ];
    // drupal_set_message($host);
    if (in_array($subdomain, $domains)) {
      $response = new RedirectResponse("https://www.{$host}{$path}");
      $response->send();
    }
    elseif ($subdomain == 'lp' && \Drupal::service('path.matcher')->isFrontPage()) {
      $response = new RedirectResponse('/node/955');
      $response->send();
    }
  }

  /**
   * AJAX Responce.
   */
  public static function detect($host) {
    $idn = new IdnaConvert();
    $domain = $idn->decode($_SERVER['HTTP_HOST']);
    $subdomain = strstr($domain, '.', TRUE);
    $frontpage = \Drupal::service('path.matcher')->isFrontPage();

    $error = FALSE;
    $city['promo'] = FALSE;

    $allow = [
      '',
      'synapse-studio',
      'synapse-uk',
      'synapse-dc',
      '238-synapse',
      'www',
      'new',
      '10let',
      'lp',
    ];
    if (!in_array($subdomain, $allow)) {
      $id = self::query($subdomain);
      $city = [];
      if (is_numeric($id)) {
        $config = \Drupal::config('city.settings');
        $storage = \Drupal::entityManager()->getStorage('city');
        $entity = $storage->load($id);

        // Vars.
        $phone = $entity->phone->value;
        $name = $entity->name->value;
        $address = $entity->address->value;
        $city = [
          'city'  => ($name != 'Промо') ? $name : '',
          'city2' => $entity->title_ru->value,
          'phone' => $phone ? $phone : $config->get('phone') ,
          'address' => $address ? $address : $config->get('address'),
        ];

        if ($frontpage) {
          $city['promo'] = TRUE;
        }
        elseif ($node = \Drupal::request()->attributes->get('node')) {
          if ($node->getType() === 'promo') {
            $city['promo'] = TRUE;
          }
          else {
            $error = 'Неправильный тип материала, можно только "promo"';
          }
        }
        else {
          $error = 'Это не главная и не "node_promo"';
        }
      }
      else {
        // Если не нашли город.
        $error = 'Не нашли подходящий город "' . $subdomain . '"';
        $city['city'] = 'www';
      }

      if ($error) {
        $city['promo'] = NULL;
      }
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
