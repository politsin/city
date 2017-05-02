<?php

namespace Drupal\city\Entity;

use Drupal\Core\Entity\ContentEntityInterface;
use Drupal\Core\Entity\EntityChangedInterface;
use Drupal\user\EntityOwnerInterface;

/**
 * Provides an interface for defining City entities.
 *
 * @ingroup city
 */
interface CityEntityInterface extends  ContentEntityInterface, EntityChangedInterface, EntityOwnerInterface {

  // Add get/set methods for your configuration properties here.

  /**
   * Gets the City name.
   *
   * @return string
   *   Name of the City.
   */
  public function getName();

  /**
   * Sets the City name.
   *
   * @param string $name
   *   The City name.
   *
   * @return \Drupal\city\Entity\CityEntityInterface
   *   The called City entity.
   */
  public function setName($name);

  /**
   * Gets the City creation timestamp.
   *
   * @return int
   *   Creation timestamp of the City.
   */
  public function getCreatedTime();

  /**
   * Sets the City creation timestamp.
   *
   * @param int $timestamp
   *   The City creation timestamp.
   *
   * @return \Drupal\city\Entity\CityEntityInterface
   *   The called City entity.
   */
  public function setCreatedTime($timestamp);

  /**
   * Returns the City published status indicator.
   *
   * Unpublished City are only visible to restricted users.
   *
   * @return bool
   *   TRUE if the City is published.
   */
  public function isPublished();

  /**
   * Sets the published status of a City.
   *
   * @param bool $published
   *   TRUE to set this City to published, FALSE to set it to unpublished.
   *
   * @return \Drupal\city\Entity\CityEntityInterface
   *   The called City entity.
   */
  public function setPublished($published);

}
