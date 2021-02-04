Routines
========

Automated methods are element methods that are automatically called by
some ``Builders``. When a automated method is called all instantiated
elements with method are called.

Prefix
^^^^^^

It is recommended to establish a naming convention for automated methods
that distinguish them from other methods. In LivingMarkup, all the
packaged automated methods are prefixed with the word ``on`` followed by
an explanation of the stage of execute.

Parameters
^^^^^^^^^^

The default automated methods are defined in the default
`config.dist.yml <configuration.md>`__.

+--------------------+------------------------------------+
| Parameter          | Comments                           |
+====================+====================================+
| ``beforeLoad``     | Execute before object data load    |
+--------------------+------------------------------------+
| ``onLoad``         | Execute during object data load    |
+--------------------+------------------------------------+
| ``afterLoad``      | Execute after object data loaded   |
+--------------------+------------------------------------+
| ``beforeRender``   | Execute before object render       |
+--------------------+------------------------------------+
| ``onRender``       | Execute during object render       |
+--------------------+------------------------------------+
| ``afterRender``    | Execute after object rendered      |
+--------------------+------------------------------------+

