AbstractFactoryInterface
========================

:Qualified name: ``Ouxsoft\LivingMarkup\Contract\AbstractFactoryInterface``

.. php:interface:: AbstractFactoryInterface

  .. php:method:: public makeBuilder (Container & $container) -> BuilderInterface

    :param Container & $container:
    :returns: :class:`BuilderInterface` -- 

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

