ConcreteFactory
===============

:Qualified name: ``Ouxsoft\LivingMarkup\Factory\ConcreteFactory``
:Implements: :interface:`AbstractFactoryInterface`

.. php:class:: ConcreteFactory

  .. php:method:: makeBuilder (Container & $container)

    :param Container $container:
    :returns: BuilderInterface

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

