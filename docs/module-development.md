# Module Development
In LHTML5, Modules are classes that elements are instantiated as. Fortunately, they're as simple to make as any other class.

## PHP Module Class
To make a new module you must first make a class. New modules can be loaded anywhere within a composer autoload accessible namespace. For ease of use the packaged modules are located inside the `/modules` directory. And modules defined using the `{name}` in their  `modules:types:*:class_name` are isolated to it's own sub folder within that directory. Here's the basic syntax of a module class.

***The module is required to extend the abstract class `\LivingMarkup\Module`.***
 
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

## Method Names
Module methods are not required to follow any pattern. But if the name is the same as a `module:method` defined in the `Configuration` than the method will automatically be called during runtime. 

#### Prefix
It is best practice to use a standard for prefixing automated method calls to distinguish them from other methods. In LivingMarkup, the packaged method calls are prefixed with `on` and are structured to explain when during runtime they are executed, such as `onRender` and `onLoad`.

## Configuring New Module
To add a new module the module must be added to the runtime configuration. The `Configuration` defines the location of each modules based on namespace. For more information, see [configuration](configuration.md).