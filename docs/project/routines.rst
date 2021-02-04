Routines
========

Routines are methods that are automatically called by the processor during run time.

During a routine call all instantiated elements featuring the routine's method
are called.

Prefix
^^^^^^

It is recommended to establish a naming convention for routines
that distinguish them from other methods.

Often packages choose to prefix Routine methods with the word ``before``,
``on``, or ``after`` followed by an explanation of the stage of execute.

For example:

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