ConcreteFactory
===============

:Qualified name: ``Ouxsoft\LivingMarkup\Factory\ConcreteFactory``
:Implements: :interface:`AbstractFactoryInterface`

.. php:class:: ConcreteFactory

  .. php:method:: public makeBuilder (Container & $container)

    :param Container & $container:
    :returns: BuilderInterface

  .. php:method:: public makeConfig (Container & $container) -> Configuration

    :param Container & $container:
    :returns: :class:`Configuration` -- 

  .. php:method:: public makeDocument (Container & $container) -> Document

    :param Container & $container:
    :returns: :class:`Document` -- 

  .. php:method:: public makeElementPool ()

    :returns: ElementPool

  .. php:method:: public makeEngine (Container & $container) -> Engine

    :param Container & $container:
    :returns: :class:`Engine` -- 

  .. php:method:: public makeKernel (Container & $container) -> Kernel

    :param Container & $container:
    :returns: :class:`Kernel` -- 

