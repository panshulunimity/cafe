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

### Content vs. Configuration Entities in Drupal

#### Content Entity

Consist of configurable and base fields, and can have revisions and support translations. Content entities are stored within a custom database table as rows. The table name is the same as the content entity "id", and the columns are defined by the entity's "baseFieldDefinitions" method.

#### Configuration Entity

Used by the Configuration System. Supports translations and can provide custom defaults for installations. Configuration entities are stored within the common `config` database table as rows.

##### Differences compared to Content Entity

- Integrates with CMI API for exportability.
- Doesn't have fields but uses properties instead.
- Schema file (Content Entity uses hook_schema())

### Bundles

- Bundles are different variants of an entity type. For example, with the node entity type, the bundles are the different node types, such as 'article' and 'page'.

- Typically, a bundle is represented by a Configuration Entity, though other models exist in contrib modules. So in the node example, the 'article' node type is itself a configuration entity.

### Annotations

- When creating a new entity type, you'll need to use the annotations system built into core. 

- Annotations look like docblock comments above the class, but are parsed and cached by Drupal core.

- Example Syntax - 

```php
/**
 * @ContentEntityType(
 *   id = "my_entity_type_id",
 *   label = @Translation("My entity type label"),
 *   example_pair = "this_examples_value",
 *   example_array = {
 *     "array_key" = "array_value",
 *     "some_other_key" = "some_other_value",
 *   },
 * )
 */
```

### Handlers

- Handlers are defined in the entity annotation as an array. They support the entity by mapping certain parts of its execution to other PHP classes. Those classes will "handle" the assigned parts of the entity's execution.

```php
handlers = {
  "view_builder" = "Drupal\Core\Entity\EntityViewBuilder",
  "list_builder" = "Drupal\Core\Entity\EntityListBuilder",
  "access" = "Drupal\Core\Entity\EntityAccessControlHandler",
  "views_data" = "Drupal\views\EntityViewsData",
  "storage" = "Drupal\Core\Entity\Sql\SqlContentEntityStorage",
  "storage_schema" = "Drupal\Core\Entity\Sql\SqlContentEntityStorageSchema",
  "translation" = "Drupal\content_translation\ContentTranslationHandler",
  "form" = {
    "default" = "Drupal\Core\Entity\ContentEntityForm",
    "add" = "Drupal\Core\Entity\ContentEntityForm",
    "edit" = "Drupal\Core\Entity\ContentEntityForm",
    "delete" = "Drupal\Core\Entity\ContentEntityDeleteForm",
  },
  "route_provider" = {
    "html" = "Drupal\Core\Entity\Routing\AdminHtmlRouteProvider",
  },
},
```

### Links

- Links are defined in the entity annotation with the array syntax. Links have a specific set of keys whose value are URIs where the entity type or single entities of that type can be managed.

```php
id = "node",
handlers = {
  "route_provider" = {
    "html" = "Drupal\Core\Entity\Routing\AdminHtmlRouteProvider"
  }
},
links = {
  "canonical" = "/node/{node}",
  "add-page" = "/node/add",
  "add-form" = "/node/add/{node_type}",
  "edit-form" = "/node/{node}/edit",
  "delete-form" = "/node/{node}/delete",
  "collection" = "/admin/content",
},
```

### Working with Entity Types
---
#### Generic Entity API Methods - 

```php
Entity::create()
Entity::load()
Entity::save()
Entity::id()
Entity::bundle()
Entity::isNew()
Entity::label()
```
---
#### How to check whether the object that is bein loaded is of type entity

```php
// Make sure that an object is an entity.
if ($entity instanceof \Drupal\Core\Entity\EntityInterface) {
}

// Make sure it's a content entity.
if ($entity instanceof \Drupal\Core\Entity\ContentEntityInterface) {
}
// or:
if ($entity->getEntityType()->getGroup() == 'content') {
}

// Get the entity type or the entity type ID.
$entity->getEntityType();
$entity->getEntityTypeId();

// Make sure it's a node.
if ($entity instanceof \Drupal\node\NodeInterface) {
}

// Using entityType() works better when the needed entity type is dynamic.
$needed_type = 'node';
if ($entity->getEntityTypeId() == $needed_type) {
}
```
---

#### Getting information from an entity

```php
// Get the ID.
$entity->id();

// Get the bundle.
$entity->bundle();

// Check if the entity is new.
$entity->isNew();

// Get the label of an entity. Replacement for entity_label().
$entity->label();

// Get the URL object for an entity.
$entity->toUrl();

// Get internal path, path alias if exists, for an entity.
$entity->toUrl()->toString();

// Create a duplicate that can be saved as a new entity.
$duplicate = $entity->createDuplicate();
```

---

#### Entity Create

```php
// Use the entity type manager (recommended).
$node = \Drupal::entityTypeManager()->getStorage('node')->create(['type' => 'article', 'title' => 'Another node']);


// You can use the static create() method if you know the entity class.
$node = Node::create([
  'type' => 'article',
  'title' => 'The node title',
]);
```
---
#### Entity Load

```php
// Using the storage controller (recommended).
$entity = \Drupal::entityTypeManager()->getStorage($entity_type)->load(1);

// Use the static method
$node = Node::load(1);

// Load multiple entities, also exists as entity_load_multiple().
$entities = \Drupal::entityTypeManager()->getStorage($entity_type)->loadMultiple([1, 2, 3]);

// Load entities by their property values.
$entities = \Drupal::entityTypeManager()->getStorage('node')->loadByProperties(['type' => 'article']);
```
---
#### Entity Save

```php
$node->nid->value = 5;
$node->enforceIsNew(TRUE);
$node->save();
```
---
#### Entity Query

```php
$nodeStorage = \Drupal::entityTypeManager()->getStorage('node');
    
$ids = $nodeStorage->getQuery()
  ->condition('status', 1)
  ->condition('type', 'article') // type = bundle id (machine name)
  //->sort('created', 'ASC') // sorted by time of creation
  //->pager(15) // limit 15 items
  ->execute();

$articles = $nodeStorage->loadMultiple($ids);
```
---
#### Entity Delete

```php
// Delete a single entity.
$entity = \Drupal::entityTypeManager()->getStorage('node')->load(1);
$entity->delete();

// Delete multiple entities at once.
\Drupal::entityTypeManager()->getStorage($entity_type)->delete([$id1 => $entity1, $id2 => $entity2]);
```
---
#### Entity Access Control

```php
// Check view access of an entity.
// This defaults to check access for the currently logged in user.
if ($entity->access('view')) {

}

// Check if a given user can delete an entity.
if ($entity->access('delete', $account)) {

}
```
---

### Creating a custom entity type

- From all the methods we discussed above and in additionally the concepts related to entity such as - Handlers, Bundle, Links etc.. we now understand what an entity is comprised of.

- Let's take an example of `node` entity type and let's look at the code of the node entity.

- The node entity is complex PHP class that is formed using several Entity API concepts (or components) working together.

- In some cases we have create our own entity programtically.

- We need to understand why custom entities are created - Sometimes we want to take the full control of all the CRUD operations of the entity (including the behaviour of content creation and storage). In this case where a lot of custom requirements are placed to build & use an entity, in that case we can opt for custom entities. These cases could be the following (but are not limited to) - 

  - The Content entity should have a different URL for creating & editing the content example - instead of /node/add URL, it should be /advertisement/create & instead of /node/123/edit, the edit URL should be - /advertisement/123/edit.
  - The content creation behaviour is different from normal content creation in drupal.
  - The content storage should be handled in a custom way instead of using default drupal storage mechanism.

### Example of Creating a custom entity.

- Example 1 - Bundle-less content entity type - https://www.drupal.org/docs/drupal-apis/entity-api/creating-a-custom-content-entity

- Example 2 - Fully customised entity like node - https://www.drupal.org/docs/drupal-apis/entity-api/creating-a-content-entity-type-in-drupal-8
