# Modules
Modules are the working bees of LivingMarkup. They are objects that process DOMElements. How they process the DOMElement is determined by their class. During the object's construction, the module receives arguments that were found in both the DOMElement's attributes and child `arg` DOMElements from `Engine`. 

## Module Development
Modules are easy to make. Simply create a subclass that extends the abstract class `\LivingMarkup\Module` and add it to the `Configuration`. 

### Example
The basic syntax of a module class is shown below.
```php
<?php

namespace LivingMarkup\Modules;

class HelloWorld extends \LivingMarkup\Module
{
    public function onRender()
    {
        return 'Hello, World';
    }
}
```
### File Path
For ease of use the packaged modules are located inside the `/modules` directory. Modules defined using the variable `{name}` in their  `modules:types:*:class_name` are isolated a sub folder within the `/modules` directory. In order to use an alternative path is for modules the path must be added to composer's autoload section. 

## Automated Method
Automated methods are module methods that are automatically called by some `Builders`. When a automated method is called all instantiated modules with method are called. 

#### Prefix
It is recommended to establish a naming convention for automated methods that distinguish them from other methods. In LivingMarkup, all the packaged automated methods are prefixed with the word `on` followed by an explanation of the stage of execute.

#### Parameters
The default automated methods are defined in the default [config.dist.yml](configuration.md).

| Parameter | Comments |
|---- |---- |
| `beforeLoad` | Execute before object data load |
| `onLoad` | Execute during object data load |
| `afterLoad` | Execute after object data loaded  |
| `beforeRender` | Execute before object render |
| `onRender` | Execute during object render |
| `afterRender` | Execute after object rendered |
