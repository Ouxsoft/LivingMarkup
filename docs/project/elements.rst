Elements
========

Elements are the working bees of LivingMarkup. They are objects that
process DOMElements. How they process the DOMElement is determined by
their class. During the object's construction, the element receives
arguments that were found in both the DOMElement's attributes and child
``arg`` DOMElements from ``Engine``.

Element Development
-------------------

New elements are easy to make. Simply create a class that extends the
abstract class ``\LivingMarkup\Element\AbstractElement``.

Make sure to and it to the ``Configuration`` make it work.

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

