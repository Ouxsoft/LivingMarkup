ElementPool
===========

:Qualified name: ``Ouxsoft\LivingMarkup\Element\ElementPool``
:Implements: :interface:`ElementPoolInterface`

.. php:class:: ElementPool

  .. php:method:: public add (AbstractElement`  $element)

    Add new element to pool

    :param AbstractElement`  $element:

  .. php:method:: public callRoutine (string $routine)

    Invoke a method if present in each element

    :param string $routine:

  .. php:method:: public count () -> int

    Returns a count of number of elements in collection

    :returns: int -- 

  .. php:method:: public getById ([])

    Get Element by placeholder id

    :param ?string $element_id:
      Default: ``null``
    :returns: AbstractElement|null

  .. php:method:: public getIterator ()

    Iterator to go through element pool

    :returns: ArrayIterator

  .. php:method:: public getPropertiesById (string $element_id) -> array

    Get the public properties of a element using the elements ID

    :param string $element_id:
    :returns: array -- 

