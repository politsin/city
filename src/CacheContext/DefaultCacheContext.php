<?php

namespace Drupal\city\CacheContext;

use Drupal\Core\Cache\Context\CacheContextInterface;

/**
 * Class DefaultCacheContext.
 */
class DefaultCacheContext implements CacheContextInterface {

  /**
   * Constructor.
   */
  public function __construct() {
    drupal_set_message('City');
  }

  /**
   * {@inheritdoc}
   */
  static function getLabel() {
    drupal_set_message('Lable of City cache context');
  }

  /**
   * {@inheritdoc}
   */
  public function getContext() {
    // Actual logic of context variation will lie here.
  }

  /**
   * {@inheritdoc}
   */
  public function getCacheableMetadata() {
    // The buble cache metadata.
  }

}
