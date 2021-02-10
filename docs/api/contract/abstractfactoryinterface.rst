AbstractFactoryInterface
========================

:Qualified name: ``Ouxsoft\LivingMarkup\Contract\AbstractFactoryInterface``

.. php:interface:: AbstractFactoryInterface

  .. php:method:: makeBuilder (Container & $container) -> BuilderInterface

    :param Container $container:
    :returns: :class:`BuilderInterface` -- 

  .. php:method:: makeConfig (Container & $container)

    :param Container $container:
    :returns: Configuration

  .. php:method:: makeDocument (Container & $container)

    :param Container $container:
    :returns: Document

  .. php:method:: makeElementPool ()

    :returns: ElementPool

  .. php:method:: makeEngine (Container & $container)

    :param Container $container:
    :returns: Engine

  .. php:method:: makeKernel (Container & $container)

    :param Container $container:
    :returns: Kernel

