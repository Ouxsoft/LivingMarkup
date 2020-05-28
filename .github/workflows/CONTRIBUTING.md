# Contributing to LivingMarkup

* LivingMarkup is designed to be used in other applications; it is not a monolithic solution but rather follow the
Unix philosophy. Please bare that in mind when contributing. 

## Workflow

*  Fork the project.
*  Make your code edit.
*  Update or add test for to avoid change breaking in future releases.
*  Run `composer update` to update composer packages and commit new composer.lock.
*  Run `composer build` and ensure PSR Standards are adhered to.
*  Test your changes using `composer test`.
*  Send a pull request.

## Coding Guidelines

*  LivingMarkup uses Laminas Framework (formally Zend Framework).
*  LivingMarkup implements a builder design pattern.
*  LivingMarkup use PHPDocs blocks.
*  Classes use S.O.L.I.D. Design Principle.
*  Work to improve Code Score on [Codacy](https://app.codacy.com/manual/hxtree/LivingMarkup).

## Using LivingMarkup from a Git checkout

The following commands can be used to perform the initial checkout of LivingMarkup:

```bash
git clone git://github.com/ouxsoft/livingMarkup.git

cd livingMarkup
```

## Reporting issues

Please report issue and open new tickets:

*  [Report Issues](https://github.com/ouxsoft/livingMarkup/issues)