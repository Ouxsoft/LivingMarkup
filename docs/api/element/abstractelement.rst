AbstractElement
===============

:Qualified name: ``Ouxsoft\LivingMarkup\Element\AbstractElement``

.. php:class:: AbstractElement

  .. php:method:: public __construct ([])

    Element constructor

    :param ArgumentArray $args:
      Default: ``null``

  .. php:method:: public __invoke (string $method) -> bool

    Invoke wrapper call to method if exists

    :param string $method:
    :returns: bool -- 

  .. php:method:: public __toString () -> string

    Call onRender if exists on echo / output

    :returns: string -- 

  .. php:method:: public getArgByName (string $name)

    Get arg by name

    :param string $name:
    :returns: mixed|null

  .. php:method:: public getArgs () -> ArgumentArray

    Get all args

    :returns: :class:`ArgumentArray` -- 

  .. php:method:: public getId ()

    Gets the ID of the Element, useful for :class:`ElementPool`

    :returns: int|string

  .. php:method:: public innerText ()

    Get innerText

    :returns: string|null

  .. php:method:: public onRender () -> mixed

    Abstract output method called by magic method The extending class must define this method

    :returns: mixed -- 

