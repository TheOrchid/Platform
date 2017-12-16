
<h1 align="center">
  <br>
  <a href="https://orchid.software/"><img src="https://orchid.software/img/orchid.svg" alt="ORCHID" width="250"></a>
  <br>
  <br>
</h1>

<h4 align="center">Powerful platform for building a business application using the  <a href="https://laravel.com" target="_blank">Laravel</a> framework.</h4>

<p align="center">
<a href="https://travis-ci.org/orchidsoftware/platform/"><img src="https://travis-ci.org/orchidsoftware/platform.svg?branch=master"></a>
<a href="https://styleci.io/repos/73781385"><img src="https://styleci.io/repos/73781385/shield?branch=master"/></a>
<a href="https://packagist.org/packages/orchid/platform"><img src="https://poser.pugx.org/orchid/platform/v/stable"/></a>
<a href="https://packagist.org/packages/orchid/platform"><img src="https://poser.pugx.org/orchid/platform/downloads"/></a>
<a href="https://packagist.org/packages/orchid/platform"><img src="https://poser.pugx.org/orchid/platform/license"/></a>
</p>

![screenshot](https://user-images.githubusercontent.com/5102591/32980416-22ad653e-cc77-11e7-9fb9-4747b241270f.png)

## Introduction

ORCHID is a flexible, business application development tool to quickly create web business applications. 
With timesaving tools and templates, and an intuitive development environment, using the Laravel framework helps speed the development and reduces the complexity of everything from UI design to deploy. 
Now  it is finally practical to build affordable, scalable custom software solutions that bridge the gaps between existing systems and provide comprehensive, user-friendly views of your business data.

The platform is provided as a package for the Laravel framework, you can easily integrate it as a third-party component using Composer

    
**Are there any additional system requirements from Laravel?**

Yes, you need a PHP extension for image processing and support for json type your database.

**How much does it cost?**

ORCHID is free, but we appreciate donations.


## Official Documentation

Documentation can be found at [ORCHID website](http://orchid.software).


## System requirements

Make sure your server meets the following requirements.

- Apache 2.2+ or nginx
- MySQL Server 5.7.8+ or PostgreSQL
- PHP Version 7.0+


## Installation

Firstly, download the Laravel installer using Composer:
```php
$ composer require orchid/platform
```

Extend your user model using the `Orchid\Core\Models\User as BaseUser` alias:

```php
namespace App;

use Orchid\Platform\Core\Models\User as BaseUser;

class User extends BaseUser
{

}

```

Publish ORCHID's vendor files

```php
php artisan vendor:publish --provider="Orchid\Platform\Providers\FoundationServiceProvider"
php artisan vendor:publish --all
```

Run your database migration
```php
php artisan migrate
```

Make available css/js/etc files
```php
php artisan storage:link
php artisan orchid:link
```

Create your admin user
```php
php artisan make:admin admin admin@admin.com password
```


#### Usage

To view ORCHID's dashboard go to:
```php
http://your.app/dashboard
```


## Security

If you discover security related issues, please email  [Alexandr Chernyaev](mailto:bliz48rus@gmail.com) instead of using the issue tracker.


## Contributing

1. Fork it!
2. Create your feature branch: `git checkout -b my-new-feature`
3. Commit your changes: `git commit -am 'Add some feature'`
4. Push to the branch: `git push origin my-new-feature`
5. Submit a pull request :D


## Change log

See [CHANGELOG](CHANGELOG.md).

## Credits

- [Alexandr Chernyaev](https://github.com/tabuna)
- [All Contributors](../../contributors)


## License

The MIT License (MIT). Please see [License File](LICENSE) for more information.
