<?php

namespace Drupal\chef_speciality\Plugin\Block;

use Drupal\Core\Block\BlockBase;

/**
 * Provides a 'Chef Speciality' Block.
 *
 * @Block(
 *   id = "chef_speciality",
 *   admin_label = @Translation("Chef Speciality"),
 *   category = @Translation("Chef Speciality"),
 * )
 */
class ChefSpeciality extends BlockBase {

  /**
   * {@inheritdoc}
   */
  public function build() {
    return [
      '#theme' => 'chef_speciality',
      '#dish_name' => ['dish' => 'Egg Fried Rice', 'Category' => 'Chinese'],
    ];
  }

}
