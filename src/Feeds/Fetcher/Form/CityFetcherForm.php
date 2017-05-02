<?php

namespace Drupal\city\Feeds\Fetcher\Form;

use Drupal\Core\DependencyInjection\ContainerInjectionInterface;
use Drupal\Core\Form\FormStateInterface;
use Drupal\feeds\Plugin\Type\ExternalPluginFormBase;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Defines a directory fetcher.
 */
class CityFetcherForm extends ExternalPluginFormBase implements ContainerInjectionInterface {

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    return new static($container->get('stream_wrapper_manager'));
  }

  /**
   * {@inheritdoc}
   */
  public function buildConfigurationForm(array $form, FormStateInterface $form_state) {
    $form['count'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Min count'),
      '#default_value' => $this->plugin->getConfiguration('count'),
      '#description' => $this->t('Leave blank to use all'),
    ];
    $form['type'] = [
      '#type' => 'radios',
      '#title' => $this->t('File'),
      '#default_value' => $this->plugin->getConfiguration('type'),
      '#required' => TRUE,
      '#options' => [
        'ru-yandex' => 'RussiaYandex',
        'ru-custom' => 'RussiaCustom',
      ],
    ];
    return $form;
  }

}
