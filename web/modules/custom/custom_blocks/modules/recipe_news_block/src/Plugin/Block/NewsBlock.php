<?php

namespace Drupal\recipe_news_block\Plugin\Block;

use Drupal\Core\Block\BlockBase;

/**
 * Provides a 'Recipe News' Block.
 *
 * @Block(
 *   id = "recipe_news_block",
 *   admin_label = @Translation("Recipe News Block"),
 *   category = @Translation("Recipe News Block"),
 * )
 */
class NewsBlock extends BlockBase {

  /**
   * {@inheritdoc}
   */
  public function build() {
    return [
      '#markup' => $this->t('This is a news about a new recipe.'),
    ];
  }

}
