<?php

namespace Drupal\city\Theme;

/**
 * @file
 * Contains \Drupal\city\Theme\CityNegotiator.
 */

use Drupal\Core\Routing\RouteMatchInterface;
use Drupal\Core\Theme\ThemeNegotiatorInterface;
use Drupal\city\Controller\GetCity;

/**
 * ThemeswitcherNegotiator.
 */
class CityNegotiator implements ThemeNegotiatorInterface {

  /**
   * Applies - чего бы это не значило.
   */
  public function applies(RouteMatchInterface $route_match) {
    $applies = TRUE;
    return $applies;
  }

  /**
   * {@inheritdoc}
   */
  public function determineActiveTheme(RouteMatchInterface $route_match) {
    $city = GetCity::get();
    if (isset($city['info']['theme']) && $city['info']['theme']) {
      return $city['info']['theme'];
    }
  }

}
