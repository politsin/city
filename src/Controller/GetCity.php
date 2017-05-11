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
   * Redirects.
   */
  public static function redirects($host, &$data) {
    // Disable for drush.
    if ($host != 'default') {
      $domen = substr(strstr($host, '.'), 1);
      $subdomain = strstr($host, '.', TRUE);
      $request = \Drupal::request();

      // 1. Редирект на www для базового домена.
      if (!strpos($domen, ".")) {
        $path = $request->getRequestUri();
        $response = new RedirectResponse("https://www.{$host}{$path}");
        $response->send();
      }
      // 2. Редирект на https для корневого домена.
      if ($subdomain == 'www' && $request->getScheme() != 'https') {
        $path = $request->getRequestUri();
        $response = new RedirectResponse("https://{$host}{$path}");
        $response->send();
      }
      // 3. Рердирект с неправильного SUB на корневой домен.
      if ($subdomain != 'www' && !$data['citypath']) {
        $response = new RedirectResponse("https://www.{$domen}");
        $response->send();
      }
    }
  }

  /**
   * Detect city.
   */
  public static function detect($host) {
    $idn = new IdnaConvert();
    $domain = $idn->decode($host);
    $subdomain = strstr($domain, '.', TRUE);
    $domen = substr(strstr($domain, '.'), 1);

    $city = ['info' => ['theme' => FALSE, 'domen' => FALSE]];

    // Досук к корневому доступу только по www.
    if ($subdomain == 'www') {
      // Базовый сайт.
      $city['info']['theme'] = FALSE;
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
      'citypath' => FALSE,
    ];
    $city['info'] = $info;

    if (is_numeric($id)) {
      $storage = \Drupal::entityManager()->getStorage('city');
      $entity = $storage->load($id);
      // Vars.
      $phone = $entity->phone->value;
      $name = $entity->name->value;
      $address = $entity->address->value;
      $city = [
        'city'  => ($name != 'Промо') ? $name : '',
        'city2' => $entity->namein->value,
        'phone' => $phone ? $phone : $info['phone'] ,
        'address' => $address ? $address : $info['address'],
        'citypath' => $entity->citypath->value,
        'info' => $info,
      ];
    }
    return $city;
  }

  /**
   * City query by ru-subdomain.
   */
  public static function query($subdomain) {
    $query = \Drupal::entityQuery('city');
    $query->condition('citypath', $subdomain);
    $ids = $query->execute();
    $id = array_shift($ids);
    return $id;
  }

}
