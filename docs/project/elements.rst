Elements
========

Elements are the working bees of LivingMarkup.

Elements are instantiated DOMElements. Much of how an DOMElement is processed
is determined by the class_name defined to process them.

Args
-------------------
During the Element's construction, the ``Engine`` sends arguments that were found
in both the DOMElement's attributes and child ``arg`` DOMElements.

Element Development
-------------------

It is simple to make new Elements.

1. Create a class that extends the abstract class ``\LivingMarkup\Element\AbstractElement``.
2. Add an ``Element`` to the ``Processor``.
3. Run the Processor with Markup containing the ``DOMElement``

Hello World Example
~~~~~~~~~~~~~~~~~~~

.. code:: php

    <?php

    namespace Ouxsoft\LivingMarkup\Elements;

    class HelloWorld extends Ouxsoft\LivingMarkup\Element
    {
        public function onRender()
        {
            return 'Hello, World';
        }
    }


Bootstrap 4 Alert Example
~~~~~~~~~~~~~~~~~~~~~~~~~

.. code:: php

    <?php
    namespace Partial;

    class Alert extends Ouxsoft\LivingMarkup\Element\AbstractElement
    {
        public function onRender()
        {
            switch($this->getArgByName('type')){
                case 'success':
                    $class = 'alert-success';
                    break;
                case 'warning':
                    $class = 'alert-warning';
                    break;
                default:
                    $class = 'alert-info';
                    break;
            }
            return "<div class=\"alert {$class}\" role=\"alert\">{$this->innerText()}</div>";
        }
    }

LHTML Elements
--------------
To allow for library reuse LivingMarkup comes packaged with only LHTML ``Elements`` used for test.
For additional Elements, see:
 * [Hoopless](https://github.com/ouxsoft/hoopless)