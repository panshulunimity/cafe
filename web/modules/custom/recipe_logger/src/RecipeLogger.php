<?php

namespace Drupal\recipe_logger;

use Drupal\Core\Session\AccountInterface;

/**
 * Class RecipeLogger
 * @package Drupal\recipe_logger\Services
 */
class RecipeLogger {

  /**
   * @return \Drupal\Component\Render\MarkupInterface|string
   */
  public function logData() {
    $message = t('This is my first drupal log using service');
    \Drupal::logger('recipe_logger')->notice($message);
  }

}