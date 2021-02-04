Elements
========

Elements are the working bees of LivingMarkup.

Elements are objects that process DOMElements.

Much of how an DOMElement is processed is deteremined by
their class.

During the object's construction, the element receives
arguments that were found in both the DOMElement's attributes and child
``arg`` DOMElements from ``Engine``.

Element Development
-------------------

New elements are easy to make. Simply create a class that extends the
abstract class ``\LivingMarkup\Element\AbstractElement``.

Make sure to add it to the ``Configuration`` to active the element.

Example
~~~~~~~

The basic syntax of a element class is shown below.

.. code:: php

    <?php

    namespace LivingMarkup\Elements;

    class HelloWorld extends \LivingMarkup\Element
    {
        public function onRender()
        {
            return 'Hello, World';
        }
    }

