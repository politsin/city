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
    $current_path = \Drupal::service('path.current')->getPath();
    $frontpage = \Drupal::service('path.matcher')->isFrontPage();
    $city = GetCity::get();
    if ($city['promo'] == TRUE) {
      return 'promo';
    }
    elseif ($city['promo'] === NULL) {
      return 'blank';
    }
  }

}
