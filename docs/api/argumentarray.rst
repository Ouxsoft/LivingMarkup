ArgumentArray
=============

:Qualified name: ``Ouxsoft\LivingMarkup\ArgumentArray``

.. php:class:: ArgumentArray

  .. php:method:: public count () -> int

    Returns count of containers

    :returns: int -- 

  .. php:method:: public current () -> mixed

    :returns: mixed -- 

  .. php:method:: public get () -> array

    Return container property

    :returns: array -- 

  .. php:method:: public key ()

    :returns: bool|float|int|mixed|string|null

  .. php:method:: public merge ($array)

    Merge array passed with container property

    :param $array:

  .. php:method:: public next ()

    :returns: bool|mixed|void

  .. php:method:: public offsetExists ($offset) -> bool

    Check if item exists inside container

    :param $offset:
    :returns: bool -- 

  .. php:method:: public offsetGet ($offset) -> mixed

    Get item from container

    :param $offset:
    :returns: mixed -- 

  .. php:method:: public offsetSet ($offset, $value)

    Adds new item to array, if only one item in array then it will be a string

    :param $offset:
    :param $value:

  .. php:method:: public offsetUnset ($offset)

    Remove item from container

    :param $offset:

  .. php:method:: public rewind ()


  .. php:method:: public valid () -> bool

    :returns: bool -- 

