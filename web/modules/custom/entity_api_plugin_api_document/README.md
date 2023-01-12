# Entity API & Plugin API in Drupal


## What will we learn as part of Entity API?

- Basics of Entity API
- Content vs Configuration Entities
- Working with Entity API (entity load, save, edit etc..)
- Custom Content Entity - Why do we create it? Example of the Custom Content Entity.
- Entity translation API Overview
- Creating Custom fields programmatically - Field Widgets, Field Formatters, Field Types.

## What will we learn as part of Plugin API?

- Plugin API Overview
- Why do we need plugins in Drupal?
- Drupal Plugin Discover & Discovery methods
- Annotation based plugins in Drupal
- Plugin Definitions, Plugin Contexts and Plugin Derivatives

## Plugin API

### What is a Plugin? And What is a Plugin in Drupal?

- Plugin can be defined as a piece of functionality that can be instantiated or uninstantiated (or plugged in / plugged out) as and when required.

- Can we call a module in drupal a plugin?

- Plugin API or plugin system in Drupal 
  - Plugin in drupal allows a module or a subsytem to provide a functionality in Object Oriented Way.
  - Plugins that perform similar functionality are of the same plugin type.
  -  Module developers write plugins to extend various systems like blocks, field widgets, and image effects

Ex. 
```text
Drupal contains many different plugins, of different types. For example, 'Field widget' is a plugin type, and each different field widget type is a plugin.
```

### Plugin Types, Plugin Discovery & Plugin Factory

---

#### Plugin Type 

The plugin type is the central controlling class that defines how the plugins of this type will be discovered and instantiated. The type will describe the central purpose of all plugins of that type, e.g., cache backends, image actions, blocks, etc.

---

#### Plugin Discovery

Plugin Discovery is the process of finding plugins within the available code base that qualify for use within this particular plugin type's use case.

---

#### Plugin Factory

The Factory is responsible for instantiating the specific plugin(s) chosen for a given use case.

---

### But, Why do we need plugins in Drupal?

- Plugins in Drupal are a great way to build or extend a functionality based upon the requirement in the Object oriented way.

- Plugins are more like PHP interfaces (we create interfaces in PHP and then extend those interfaces by adding the logic or functionality in the implementing classes).

- Plugin Factory in Drupal stores & maintains all the plugins in the system.

### Plugin vs. Services 

- Use plugins if a behavior needs to be selected and/or configured by the user. If there's no need for user interaction, use tagged services.

- Consider this example from the drupal documentation of plugin system - 

```text
For example, think of image transformations (for example scale, crop, and desaturate). Each transformation type acts in the same way on the same data: It accepts an image file, performs a transformation, and returns an altered image. However, each effect is very different.
```

### Drupal Plugin Discovery & Discovery Methods

Plugin discovery is the process by which Drupal finds plugins of a given type. A discovery method must be set for every plugin type 

There are four different core discovery types.

---
1. StaticDiscovery - StaticDiscovery allows for direct registration of plugins within the discovery class itself.
---
2. HookDiscovery - The HookDiscovery class allows Drupal's hook_component_info()/hook_component_info_alter() pattern to be used for plugin discovery.
---
3. AnnotatedClassDiscovery - The AnnotatedClassDiscovery class uses name of the annotations that contains the plugin definition, e.g., @Plugin, @EntityType, in plugin docblocks to discover plugins, minimizing memory usage during the discovery phase.
---
4. YamlDiscovery - YamlDiscovery allows plugins to be defined in yaml files. Drupal core uses this for local tasks and local actions.
---

### Annotations-based plugins

Most of the plugins in Drupal 8 will use annotations to register themselves and describe their metadata. Some of the plugin types provided by the core are:

- Blocks (see */src/Plugin/Block/* for many examples)
- Field formatters, Field widgets (see */src/Plugin/Field/* for many examples)
- All Views plugins (see */src/Plugin/views/* for many examples)
- Conditions (used for Block visibility in the core)
- Migrate source, process & destination plugins


## Entity API

The Entity System is the API for entities manipulation (CRUD: create, read, update, delete)

### What is Entity in Drupal?

- Entity in drupal can be defined as the object that stores information and can be processed using CRUD operations mentioned above.

- In Drupal Entity can be categorized into - Node, Taxonomy, User, Block etc..

- Entities in Drupal are of two types 
  - Content Entity 
  - Configuration Entity

- To be more specific, the Entity API in drupal helps break down an entity (could be Node, taxonomy etc..) into it's components and this helps us understand - 
  - How an Entity in Drupal is formed?
  - What does an Entity comprise of?
  - How do we build our own entity in Drupal?
  - What operations are performed (or needs to be taken care of) when we are building our own entity.

In contrast to other discovery mechanisms, the annotation metadata lives in the same file and is an integral part of the class that implements the plugin. This makes it easier to find and easier to create a new custom plugin by simply copying an existing one.

Annotations allow for complex structured data, and you can indicate that certain strings are to be translated. In many cases, plugins have an associated custom annotation class that can be used to both document and set default values for the metadata.

In addition, there is a performance bonus as it makes Drupal use less memory when discovering plugins. The original implementation had a getInfo() method on each class, similar to Drupal 7 test classes. This meant each class had to be loaded into memory to get its information and the memory was not freed until the end of the request, thus greatly increasing the peak memory requirement for PHP. Instead, the implementation used by Drupal to parse the annotation simply tokenizes the text of the file without including it as a PHP file, so memory use is minimized.

### The annotation syntax ( and example)

```php
/**
 * @Plugin(
 *
 * )
 */
```

Example - 

---
```php
/**
 * Checks if a user name is unique on the site.
 *
 * @Constraint(
 *   id = "UserNameUnique",
 *   label = @Translation("User name unique", context = "Validation"),
 * )
 */
class UserNameUnique extends Constraint {
...
}
```

### Content vs. Configuration Entities in Drupal

#### Configuration Entity

Used by the Configuration System. Supports translations and can provide custom defaults for installations. Configuration entities are stored within the common `config` database table as rows.

#### Content Entity

Consist of configurable and base fields, and can have revisions and support translations. Content entities are stored within a custom database table as rows. The table name is the same as the content entity "id", and the columns are defined by the entity's "baseFieldDefinitions" method.

