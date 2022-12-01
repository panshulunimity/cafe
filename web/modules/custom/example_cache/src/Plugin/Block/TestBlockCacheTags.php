<?php

namespace Drupal\example_cache\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\node\Entity\Node;

/**
 * Provides a 'Test block cache tags' Block.
 *
 * @Block(
 *   id = "test_block_cache_tags",
 *   admin_label = @Translation("Test block cache tags."),
 *   category = @Translation("Test block cache tags."),
 * )
 */
class TestBlockCacheTags extends BlockBase {

  public function build() {
    $node = Node::load(1);
    $node_title = $node->getTitle();

    return [
      '#markup' => $this->t('The title of node #1 is: ') . $node_title,
      '#cache' => [
        'tags' => ['node:1'],
      ]
    ];
  }

}