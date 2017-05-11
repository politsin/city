<?php

namespace Drupal\city\Entity;

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
    $header['id'] = $this->t('ID');
    $header['name'] = $this->t('Name');
    $header['namein'] = $this->t('Name In');
    $header['citypath'] = $this->t('City Path');
    $header['phone'] = $this->t('Phone');
    $header['address'] = $this->t('Address');
    $header['count'] = $this->t('Count');
    return $header + parent::buildHeader();
  }

  /**
   * {@inheritdoc}
   */
  public function buildRow(EntityInterface $entity) {
    /* @var $entity \Drupal\city\Entity\CityEntity */
    $row['id'] = $entity->id();
    $row['name'] = $this->l($entity->label(),
      new Url('entity.city.edit_form', ['city' => $entity->id()])
    );
    $row['namein'] = $entity->namein->value;
    $row['citypath'] = $entity->citypath->value;
    $row['phone'] = $entity->phone->value;
    $row['address'] = $entity->address->value;
    $row['count'] = $entity->count->value;
    return $row + parent::buildRow($entity);
  }

}
