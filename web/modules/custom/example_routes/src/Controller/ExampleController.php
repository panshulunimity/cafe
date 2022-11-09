<?php

namespace Drupal\example_routes\Controller;


/**
 * @file
 * Contains \Drupal\example_routes\Controller\ExampleController.
 */

use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Access\AccessResult;
use Drupal\Core\Session\AccountInterface;
use Drupal\node\NodeInterface;

class ExampleController extends ControllerBase {
  public function content() {
    return array(
      '#type' => 'markup',
      '#markup' => t('This is my first controller using routes.'),
    );
  }

  public function access() {
    // Check permissions and combine that with any custom access checking needed. Pass forward
    // parameters from the route and/or request as needed.
    if ($role == 'content_editor') {
      if ($active_since == 3) {
        return AccessResult::allowedIf($account->hasPermission('access content'));
      }
    }
    else {
      return AccessResult::forbidden($account);
    }
  }

  public function contentWithParameters(NodeInterface $node1, NodeInterface $node2) { // actual implementation
    // process the custom logic here.
  }

  public function contentWithUserParameters(AccountInterface $user) {
    // process the custom logic here.
  }

  public function report($issue_type) {
    // process the custom logic here.
    // If issue type is 'support-request' then perform some operation
    // If issue type is 'bug' raise an alert in the system.
    // Is issue type is 'feature' fire an email for administrator.
  }

  public function contentWithNameValidation($name) {
    // Perform logic without any extra validation.
  }

}