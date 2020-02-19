# Modules
Modules are the working bees of LivingMarkup. They are objects that process DOMElements. How they process the DOMElement is determined by their class. During the objects construction, the module receives from `Engine` arguments that were found in both the DOMElement's attributes and child `arg` DOMElements. 

## Module Development
Modules are simple to make. Making a new modules involves creating a subclass that extends the abstract class `\LivingMarkup\Module` and adding that module to the `Configuration`. For ease of use the packaged modules are located inside the `/modules` directory and modules defined using the variable `{name}` in their  `modules:types:*:class_name` are isolated a sub folder within that directory. If a different path is used, the path must be added to composer's autoload section. 

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

## Automated Method
Automated methods are module methods that are automatically handled during run time. When an automated method is called each each instantiated module with that method is called.

#### Prefix
A naming convention to distinguish automated methods from other methods is recommend. In LivingMarkup, all the packaged method calls are prefixed with the word `on` and structure to explain when they are executed during in runtime.

#### Parameters
The default automated methods are defined in the default `Configuration`.

| Parameter | Comments |
|---- |---- |
| `beforeLoad` | Execute before object data load |
| `onLoad` | Execute during object data load |
| `afterLoad` | Execute after object data loaded  |
| `beforeRender` | Execute before object render |
| `onRender` | Execute during object render |
| `afterRender` | Execute after object rendered |
