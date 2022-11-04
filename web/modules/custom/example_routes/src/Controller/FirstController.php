<?php

namespace Drupal\example_routes\Controller;

/**
 * @file
 * Contains \Drupal\example_routes\Controller\FirstController.
 */

use Drupal\Core\Controller\ControllerBase;

class FirstController extends ControllerBase {
  public function content() {
    return array(
      '#type' => 'markup',
      '#markup' => t('This is my first controller using routes.'),
    );
  }
}