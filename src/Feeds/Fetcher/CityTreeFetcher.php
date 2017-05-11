<?php

namespace Drupal\city\Feeds\Fetcher;

use Drupal\feeds\Exception\EmptyFeedException;
use Drupal\feeds\FeedInterface;
use Drupal\feeds\Plugin\Type\Fetcher\FetcherInterface;
use Drupal\feeds\Plugin\Type\PluginBase;
use Drupal\feeds\StateInterface;
use Drupal\city\Feeds\FetcherResult;

/**
 * Defines a CML fetcher.
 *
 * @FeedsFetcher(
 *   id = "citytree",
 *   title = @Translation("CityTree"),
 * )
 */
class CityTreeFetcher extends PluginBase implements FetcherInterface {

  /**
   * {@inheritdoc}
   */
  public function fetch(FeedInterface $feed, StateInterface $state) {
    $data = FALSE;
    $path = __DIR__ . "/Data/tree.json";
    $data = file_get_contents($path);
    if ($data) {
      return new FetcherResult($data);
    }
    else {
      throw new \RuntimeException('target is empty');
    }

    throw new EmptyFeedException();
  }

}
