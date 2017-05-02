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
 *   id = "RussiaCity",
 *   title = @Translation("RussiaCity"),
 *   description = @Translation("Parce City JSON")
 * )
 */
class RussiaCityParcer extends PluginBase implements ParserInterface {

  /**
   * {@inheritdoc}
   */
  public function parse(FeedInterface $feed, FetcherResultInterface $fetcher_result, StateInterface $state) {
    // Set time zone to GMT for parsing dates with strtotime().
    $result = new ParserResult();

    $json = trim($fetcher_result->getRaw());
    $raws  = Json::decode($json);
    if (!empty($raws['data'])) {
      foreach ($raws['data'] as $key => $raw) {
        $item = new DynamicItem();
        $item->set('guid', $raw['key']);
        $item->set('id', $raw['key']);
        $item->set('name', $raw['name']);
        $item->set('parent', $raw['parent']);
        $item->set('region', $raw['region']);
        $item->set('pid', $raw['pid']);
        $item->set('rid', $raw['rid']);
        $item->set('ru', $raw['ru']);
        $item->set('en', $raw['en']);
        $item->set('in', $raw['in']);
        $item->set('count', $raw['count']);
        $result->addItem($item);
      }
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
      'region' => ['label' => $this->t('region')],
      'pid'    => ['label' => $this->t('pid')],
      'rid'    => ['label' => $this->t('rid')],
      'in'     => ['label' => $this->t('in')],
      'ru'     => ['label' => $this->t('ru')],
      'en'     => ['label' => $this->t('en')],
      'count'  => ['label' => $this->t('count')],
    ];
  }

}
