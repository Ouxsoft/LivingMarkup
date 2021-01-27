ss# Elements
Elements are the working bees of LivingMarkup. They are objects that process DOMElements. How they process the DOMElement is determined by their class. During the object's construction, the element receives arguments that were found in both the DOMElement's attributes and child `arg` DOMElements from `Engine`. 

## Element Development
Elements are easy to make. Simply create a subclass that extends the abstract class `\LivingMarkup\Element` and add it to the `Configuration`. 

### Example
The basic syntax of a element class is shown below.
```php
<?php

namespace LivingMarkup\Elements;

class HelloWorld extends \LivingMarkup\Element
{
    public function onRender()
    {
        return 'Hello, World';
    }
}code
```
### File Path
For ease of use the packaged elements are located inside the `/elements` directory. Elements defined using the variable `{name}` in their  `elements:types:*:class_name` are isolated a sub folder within the `/elements` directory. In order to use an alternative path is for elements the path must be added to composer's autoload section. 

## Automated Method
Automated methods are element methods that are automatically called by some `Builders`. When a automated method is called all instantiated elements with method are called. 

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
