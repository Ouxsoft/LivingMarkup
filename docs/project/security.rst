Security
========

Escaping HTML and XSS
---------------------

It is the responsibility of the library client to escape HTML to avoid XSS.
This library itself will not alter its input.

Disable Entity Loader
---------------------

You may want to choose to disable external entities.

.. code:: php

    libxml_disable_entity_loader(true);

For more information, see `PHP Security Injection
Attacks <https://phpsecurity.readthedocs.io/en/latest/Injection-Attacks.html#xml-injection>`__
