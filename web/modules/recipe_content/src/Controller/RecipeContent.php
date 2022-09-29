<?php

namespace Drupal\recipe_content\Controller;

use Drupal\Core\Controller\ControllerBase;

/**
 * File for the RecipeContent Creation.
 */
class RecipeContent extends ControllerBase{  

  public function showMessage() {
    return [
      '#markup' => 'This is the custom message'
    ];
  }
  
}