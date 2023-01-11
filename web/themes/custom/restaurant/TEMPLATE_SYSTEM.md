# Twig in Drupal

## What will we cover as part of this topic?

- Working with Twig Templates
- Debugging twig templates 
- How to create twig templates
- twig templates naming convention
- overriding twig templates
- filters in twig
- Macros in twig
- Twig best practices and preprocess functions
- Extending & Profiling twig templates

## Debugging twig templates

- You can enable Twig Debugging in sites/default/services.yml.
- Set the debug variable to true. And clear cache.

```yaml
parameters:
  twig.config:
    debug: true
```

- You can use [Twig Debugger](https://www.drupal.org/project/twig_debugger) module to enable twig debugging.
- For other debugging options - You can install the [Devel](https://www.drupal.org/project/devel) module & the [Kint](https://github.com/kint-php/kint) PHP library. You can use the following commands to install both the packages -
-- composer require drupal/devel
-- composer require kint-php/kint

## Discovering & inspecting variables in twig templates

- To debug the variables or inspect the content of the twig, you can use the following methods -

- dump - {{ dump() }} - This will give you all the variables of a twig template
- dump with only keys as output - {{ dump(_context|keys) }} - This will give you all the keys of the twig template (without the content of the key)
- Similarly you can use kint as well, for ex. {{ kint() }}
