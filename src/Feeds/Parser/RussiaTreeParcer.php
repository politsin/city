<?php

namespace Drupal\city\Feeds\Parser;

/**
 * @file
 * Contains \Drupal\cmlparser\Feeds\Parser\CmlProductParser.
 */

use Drupal\feeds\FeedInterface;
use Drupal\feeds\Feeds\Item\DynamicItem;
use Drupal\feeds\Plugin\Type\PluginBase;
use Drupal\feeds\Plugin\Type\Parser\ParserInterface;
use Drupal\feeds\Result\FetcherResultInterface;
use Drupal\feeds\Result\ParserResult;
use Drupal\feeds\StateInterface;
use Drupal\Component\Serialization\Json;

/**
 * Defines a CmlProductParser feed parser.
 *
 * @FeedsParser(
 *   id = "RussiaTree",
 *   title = @Translation("RussiaTree"),
 *   description = @Translation("Parce Pussina JSON")
 * )
 */
class RussiaTreeParcer extends PluginBase implements ParserInterface {

  /**
   * {@inheritdoc}
   */
  public function parse(FeedInterface $feed, FetcherResultInterface $fetcher_result, StateInterface $state) {
    // Set time zone to GMT for parsing dates with strtotime().
    $result = new ParserResult();
    $json = trim($fetcher_result->getRaw());
    $raws  = Json::decode($json);
    $i = 1;
    foreach ($raws as $key => $raw) {
      $item = new DynamicItem();
      $item->set('guid', $key);
      $item->set('id', $key);
      $item->set('name', $raw['name']);
      $item->set('parent', [$raw['parent']]);
      $item->set('pid', [$raw['pid']]);
      $item->set('weight', $i++);
      if (!$raw['parent']) {
        $item->set('parent', FALSE);
      }
      $result->addItem($item);
    }

    return $result;
  }

  /**
   * {@inheritdoc}
   */
  public function getMappingSources() {
    return [
      'guid'   => ['label' => $this->t('guid')],
      'id'     => ['label' => $this->t('id')],
      'name'   => ['label' => $this->t('name')],
      'parent' => ['label' => $this->t('parent')],
      'pid'    => ['label' => $this->t('pid')],
      'weight' => ['label' => $this->t('weight')],
    ];
  }

}
