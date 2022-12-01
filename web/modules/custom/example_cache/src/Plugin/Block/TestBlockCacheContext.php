<?php

namespace Drupal\example_cache\Plugin\Block;

use Drupal\Core\Block\BlockBase;

/**
 * Provides a 'Test block Cache Context' Block.
 *
 * @Block(
 *   id = "test_block_cache_context",
 *   admin_label = @Translation("Test block Cache Context"),
 *   category = @Translation("Test block Cache Context"),
 * )
 */
class TestBlockCacheContext extends BlockBase {

  public function build() {
    $email = \Drupal::currentUser()->getEmail();

    return [
      '#markup' => $this->t('Your email is: ') . $email,
      '#cache' => [
        'contexts' => [
          'user',
        ],
      ]
    ];
  }

}