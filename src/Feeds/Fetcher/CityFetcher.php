<?php

namespace Drupal\city\Feeds\Fetcher;

use Drupal\feeds\Exception\EmptyFeedException;
use Drupal\feeds\FeedInterface;
use Drupal\feeds\Plugin\Type\Fetcher\FetcherInterface;
use Drupal\feeds\Plugin\Type\PluginBase;
use Drupal\feeds\StateInterface;
use Drupal\city\Feeds\FetcherResult;
use Drupal\city\Feeds\Fetcher\Data\CsvParcer;

/**
 * Defines a CML fetcher.
 *
 * @FeedsFetcher(
 *   id = "citydata",
 *   title = @Translation("CityFetcher"),
 *   description = @Translation("import.xml & offers.xml from entity"),
 *   form = {
 *     "configuration" = "Drupal\city\Feeds\Fetcher\Form\CityFetcherForm",
 *     "feed" = "\Drupal\city\Feeds\Fetcher\Form\CityFeedForm",
 *   },
 * )
 */
class CityFetcher extends PluginBase implements FetcherInterface {

  /**
   * {@inheritdoc}
   */
  public function fetch(FeedInterface $feed, StateInterface $state) {
    $data = FALSE;
    $source = $feed->getSource();
    $count = $this->configuration['count'];
    $type = $this->configuration['type'];

    if ($type == 'ru-yandex') {
      $data = CsvParcer::get($count);
    }

    if ($data) {
      return new FetcherResult($data);
    }
    else {
      throw new \RuntimeException('target is empty');
    }

    throw new EmptyFeedException();
  }

  /**
   * {@inheritdoc}
   */
  public function defaultFeedConfiguration() {
    return ['source' => ''];
  }

  /**
   * {@inheritdoc}
   */
  public function defaultConfiguration() {
    return [
      'count' => FALSE,
      'type' => ['ru-yandex'],
    ];
  }

}
