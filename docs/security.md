# Security

## Escaping HTML and XSS
Escaping the HTML to avoid XSS is the responsibility of the library client.
This library itself will not alter its input.

# Disable Entity Loader
You may want to disable external entities.
                    
```php

libxml_disable_entity_loader(true);

```

For more information, see [PHP Security Injection Attacks](https://phpsecurity.readthedocs.io/en/latest/Injection-Attacks.html#xml-injection)
