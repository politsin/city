<?php

namespace Drupal\city\Feeds;

use Drupal\feeds\Result\FetcherResultInterface;

/**
 * The default fetcher result object.
 */
class FetcherResult implements FetcherResultInterface {

  /**
   * The filepath of the fetched item.
   *
   * @var string
   */
  protected $data;

  /**
   * Constructs a new FetcherResult object.
   */
  public function __construct($data) {
    $this->data = $data;
  }

  /**
   * {@inheritdoc}
   */
  public function getRaw() {
    return $this->data;
  }

  /**
   * {@inheritdoc}
   */
  public function getFilePath() {
    return "";
  }

}
