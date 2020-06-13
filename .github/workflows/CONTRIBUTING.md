# Contributing to LivingMarkup

* Please bare that in mind when contributing LivingMarkup is built to adhere to the Unix philosophy. It is designed to be used in other applications; not to be a monolithic solution.

## Workflow

*  Fork the project.
*  Make your code edit.
*  Update or add tests to avoid the change breaking in future releases.
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
