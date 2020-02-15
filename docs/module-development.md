# Module Development
Modules are classes that elements are instantiated as in LHTML5. They are simple to make and allow L.

The `Configuration` defines the location of modules based on namespace. The packaged modules can be found inside the `/modules` directory. Modules defined using the `{name}` in `class_name` should be withing their own sub folder.

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

# Method naming
Module methods do not necessarily need to follow any pattern. But if the name is the same as module method defined in the `Configuration` than the method will automatically be called during runtime. 

For this reason, it is best practice to use a standard for prefixing automated method calls. In LivingMarkup, the packaged method calls are prefixed with the word `on' and are structured to explain when during runtime they are executed.