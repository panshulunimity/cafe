
/**
 * @file
 * Contains client-side support code for Web Accessibility.
 */

(function ($, Drupal, drupalSettings, once) {
    Drupal.behaviors.webAccessibility = {
      attach: function (context, settings) {
        $('.path-frontpage', context).once('webAccessibility').each(function () {
          Drupal.announce(
            Drupal.t('This is the front page.'), 'assertive'
          );
        })
      }
    }
  } (jQuery, Drupal, drupalSettings, once));