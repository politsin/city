<?php

namespace Drupal\city;

use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Entity\EntityListBuilder;
use Drupal\Core\Routing\LinkGeneratorTrait;
use Drupal\Core\Url;

/**
 * Defines a class to build a listing of City entities.
 *
 * @ingroup city
 */
class CityEntityListBuilder extends EntityListBuilder {

  use LinkGeneratorTrait;

  /**
   * {@inheritdoc}
   */
  public function buildHeader() {
    $header['id'] = $this->t('City ID');
    $header['name'] = $this->t('Name');
    $header['title_ru'] = $this->t('Title RU');
    $header['path_ru'] = $this->t('path_ru');
    $header['phone'] = $this->t('phone');
    $header['address'] = $this->t('address');
    $header['count'] = $this->t('count');
    return $header + parent::buildHeader();
  }

  /**
   * {@inheritdoc}
   */
  public function buildRow(EntityInterface $entity) {
    /* @var $entity \Drupal\city\Entity\CityEntity */
    $row['id'] = $entity->id();
    $row['name'] = $this->l(
      $entity->label(),
      new Url(
        'entity.city.edit_form', array(
          'city' => $entity->id(),
        )
      )
    );
    $row['title_ru'] = $entity->title_ru->value;
    $row['path_ru'] = $entity->path_ru->value;
    $row['phone'] = $entity->phone->value;
    $row['address'] = $entity->address->value;
    $row['count'] = $entity->count->value;

    return $row + parent::buildRow($entity);
  }

}
