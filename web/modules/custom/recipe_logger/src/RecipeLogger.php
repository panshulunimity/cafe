<?php

namespace Drupal\recipe_logger;

/**
 * Class RecipeLogger
 * @package Drupal\recipe_logger\Services
 */
class RecipeLogger {

  /**
   * @return \Drupal\Component\Render\MarkupInterface|string
   */
  public function logData() {
    $message = t('This is my first drupal log using services');
    \Drupal::logger('recipe_logger')->notice($message);
  }

}
