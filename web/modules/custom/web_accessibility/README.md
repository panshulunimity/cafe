## Purpose

The module helps to learn how web accessibility announce feature can be implemented using Javascript.

## Installation & Setup

1. Install site with any desired profile (Standard or minimal) 
2. Enable the module using drush `drush en web_accessibility` or through Drupal UI.
3. For testing, you will be required to install the Screen reader chrome plugin - https://chrome.google.com/webstore/detail/screen-reader/kgejglhpjiefppelpmljglcjbhoiplfn?hl=en (This is the default chrome plugin, also known as chromeVox).
4. Install the plugin & enable it.
5. Head back to Drupal frontpage of the site & notice that screen reader announces the front page of the site.

## How does it work?

1. Once the module is installed, head over to browser & inspect the page to view source (html) of the page.
2. Search for `aria-live` element on the page.
3. The text passed to Drupal.announce function is appended in this `aria-live` element.
ex. 
`<div id="drupal-live-announce" class="visually-hidden" aria-live="polite" aria-busy="false">This is the front page. Tray "Administration menu" opened.</div>`

## TODO

Constrain tabbing

For some interactions, you may want to guide a non-visual user to the most important elements on the page. For example, the Contextual module constrains tabbing to the contextual links when the global edit mode is enabled.

These modules achieve this constrained tabbing with the Drupal.tabbingManager JavaScript feature. To constrain tabbing on the page, invoke the tabbing manager feature like this.

`var tabbingContext = Drupal.tabbingManager.constrain($('.contextual-toolbar-tab, .contextual'));`

## Resources

Drupal Docs - https://www.drupal.org/docs/drupal-apis/javascript-api/accessibility-tools-for-javascript-in-drupal-8

About the aria-live element - https://www.w3.org/TR/wai-aria-1.1/#aria-live