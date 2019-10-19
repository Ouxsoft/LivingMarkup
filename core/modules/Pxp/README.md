PXP transformations are simple enough to understand but complex enough for the web. They are easier and more powerful than XSLT. 

Here's how it works:

\index.php

```php
$pxp_doc = new \Pxp\Document();
$pxp_doc->loadXML('
<body>
    <widget name="Test">
        <arg name="heading">Hello World</arg>
    </widget>
</body>
');
$pxp_doc->tagHandlerAdd('//widget','Widgets\{name}');
echo $pxp_doc;
```

\sites\Widgets\Test.php

```php
namespace Widgets;
class Test extends \Pxp\Element
{
    public function view(){
        $out = '<h1>' . $this->args['heading'] . '</h1>';
    }
}
```

Outputs the following

```HTML
<body>
    <h1>Hello World</h1>
</body>
```
