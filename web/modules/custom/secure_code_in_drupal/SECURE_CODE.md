# Writing Secure code in Drupal

## Why is security an important aspect to take care of?
## What are some of the major security issues that have happended because of small code mistakes?
## What makes sites vulnerable to attacks like - XSS, CSRF, SQl Injection?

## Use Twig templates

- The Twig theme engine now auto escapes everything by default. That means, every string printed from a Twig template (e.g. anything between {{ }}) gets automatically sanitized if no filters are used.

- When rendering attributes in Twig, make sure that you wrap them with double or single quotes. For example, class="{{ class }}" is safe, class={{ class }} is not safe.

- In order to take advantage of Twig’s automatic escaping (and avoid safe markup being escaped) ideally all HTML should be outputted from Twig templates.

## Output with placeholders

- We can leverage the Translation API to build sanitized, translatable strings that are suitable for front end output.

- @variable: When the placeholder replacement value is a string or a MarkupInterface object
- %variable: When the placeholder replacement value is to be wrapped in em tags.
- :variable: When the placeholder replacement value is a URL to be used in the "href" attribute


## Using API Methods 

- Use t() and \Drupal::translation()->formatPlural() with @ or % placeholders to construct safe, translatable strings. See Code text translation API in Drupal 8 for more details.
- Use Html::escape() for plain text.
- Use Xss::filter() for text that should allow some HTML tags.
- Use Xss::filterAdmin() for text entered by admin users that should allow most HTML.
- Use UrlHelper::stripDangerousProtocols() or UrlHelper::filterBadProtocol() for checking URLs - the former can be used in conjunction with SafeMarkup::format().

## Javascript (jQuery) and Drupal.checkPlain()

### Incorrect Way - 
  var rawInputText = $('#form-input').text();
### Correct Way - 
  var rawInputText     = $('#form-input').text();
  var escapedInputText = Drupal.checkPlain(rawInputText);

## Use the database abstraction layer to avoid SQL injection attacks

### Incorrect Way -
 
 ```php
 \Database::getConnection()->query('SELECT foo FROM {table} t WHERE t.name = '. $_GET['user']);
 ```

### Correct Way - 

 ```php
 \Database::getConnection()->query('SELECT foo FROM {table} t WHERE t.name = :name', [':name' => $_GET['user']]);
 ```

 OR 

 ---

 ```php
 $users = ['joe', 'poe', $_GET['user']];
\Database::getConnection()->query('SELECT f.bar FROM {foo} f WHERE f.bar IN (:users[])',  [':users[]' => $users]);
 ```

## Avoid cross-site request forgeries (CSRF) for routing

CSRF Stands for - Cross-Site Request Forgery

### What is CSRF attack?

- Cross-Site Request Forgery (CSRF) is an attack that forces authenticated users to submit a request to a Web application against which they are currently authenticated.

- In drupal, CSRF (Cross-Site Request Forgery) protection is now integrated into the routing access system and should be used for any URLs that perform actions or operations that do not use a form callback.

- Example - 

```yaml
# example.routing.yml

example:
  path: '/example'
  defaults:
    _controller: '\Drupal\example\Controller\ExampleController::content'
  requirements:
    _csrf_token: 'TRUE'
```
---
```php
$url = Url::fromRoute(
  'node_test.report',
  ['node' => $entity->id()],
  ['query' => [
    'token' => \Drupal::getContainer()->get('csrf_token')->get("node/{$entity->id()}/report")
  ]]);
```

- Validate the token

```php
// Validate $token from GET parameter.
\Drupal::getContainer()->get('csrf_token')->validate($token, "node/{$entity->id()}/report");
```

Reference - https://www.drupal.org/docs/8/api/routing-system/access-checking-on-routes/csrf-access-checking 

## File permissions

- The [Security Review](https://www.drupal.org/project/security_review) module can check your file permissions (and much else besides).

```shell
sudo chown -R MYUSER:www-data *
sudo find . -type d -exec chmod 755 {} \;
sudo find . -type f -exec chmod 640 {} \;
sudo find sites/default/files/config* -type f -exec chmod 664 {} \;
```

## Site Builder Security Configurations

- Prevent site visitors from creating their own accounts. This will mean that only site administrators can create accounts.
- Secure the user with UID=1. This first account on the site has special privileges, at the time of writing, but is rarely required. Most administrative tasks that this account can do, are possible using another account with the relevant permissions, or through Drush.
- Check roles have no more permissions than they require. You can do this infrequently, not just when the site is first installed. Under People > Permissions, ensure that the "authenticated user" and "anonymous user" roles only have the permissions you would like them to have.
- Keep the site up to date. To subscribe to security announcements through your preferred notification service (email, RSS, Twitter etc.) see the sidebar on the Security advisories page. 
- Disable, or don't enable the Testing (simpletest) module.. If some users have permission to run tests, they could maliciously run them over and over. Also, make sure Composer-based dev tools are not installed, using composer install --no-dev.
- Further security advice is available, especially if you have access to the server your site is running on.