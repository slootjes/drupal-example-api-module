# Drupal Example API Module

An *example* module on how to use controller annotations, controllers as services, fractal and Symfony For
to create custom API endpoints in Drupal similar like it can be done in Symfony Framework.

## Requirements

- **PHP >= 7.1.0**
- **Drupal >= 8.5**

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

Although everything should be production ready this module is created for educational and research purposes only. 
I cannot be held responsible for any issues that occur from you using this repository.
