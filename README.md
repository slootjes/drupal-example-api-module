# Drupal Example API Module

An *example* module which demonstrates on how to create custom API endpoints with the use of:

- [Controller Annotations](https://github.com/mediamonks/drupal-controller-annotations)
- [MediaMonks Rest API](https://github.com/mediamonks/php-rest-api)
- [Fractal](http://fractal.thephpleague.com)
- [Symfony Form](https://symfony.com/doc/current/components/form.html)
- [Symfony Validator](https://symfony.com/doc/current/components/validator.html)
- [Controllers as Services](https://symfony.com/doc/current/controller/service.html)
- [Service Autowiring](https://symfony.com/doc/current/service_container/autowiring.html)

## Requirements

- PHP  7.2+
- Drupal 8.6+

## Installation

Add the following repository to your composer.json file under *repositories*:

```
{
    "type": "vcs",
    "url": "https://github.com/slootjes/drupal-example-api-module"
}
```

and then add the module with composer:

```
composer require drupal/example-api
```

Then enable the module *Controller Annotations* and *Example API* module like you're used to and you're good to go.

## Disclaimer

This module is created for *educational and research purposes*. Most examples are not following Drupal security best practices and thus are not meant to be used as-is. I cannot be held responsible for any issues that occur from you using these examples.
