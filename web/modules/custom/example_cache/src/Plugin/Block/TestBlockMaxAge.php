<?php

namespace Drupal\example_cache\Plugin\Block;

use Drupal\Core\Block\BlockBase;

/**
 * Provides a 'Test block' Block.
 *
 * @Block(
 *   id = "test_block_max_age",
 *   admin_label = @Translation("Test block Max Age"),
 *   category = @Translation("Test block max age"),
 * )
 */
class TestBlockMaxAge extends BlockBase {

  public function build() {
    // don't cache the block at all!!
    // place the block on frontend.
    // head to the page.
    // inspect the page.
    // network tab
    // response headers.
    // max-age = 0
    return [
      '#markup' => $this->t('Time is: ') . time(),
      '#cache' => [
        'max-age' => 0,
      ]
    ];
  }

}