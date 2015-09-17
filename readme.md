# Laravel Environment Configuration

## Description

It is often helpful to have different configuration values based on the environment the application is running in. For example, you may wish to use a different cache driver on your local development machine than on the production server. It is easy to accomplish this using environment based configuration.

## Installation

Add dependency to your composer.json

```
    "require": {
        "unnutz/laravel-environment-config": "~1.0"
    },
```
Open `bootstrap/app.php` and update code so it will look similar to this:

```php
<?php

// ...

$app->singleton(
    Illuminate\Contracts\Http\Kernel::class,
    App\Http\Kernel::class
);

$app->singleton(
    Illuminate\Contracts\Console\Kernel::class,
    App\Console\Kernel::class
);

$app->singleton(
    Illuminate\Contracts\Debug\ExceptionHandler::class,
    App\Exceptions\Handler::class
);

// TODO: INSERT THESE TWO LINES
if (class_exists('Unnutz\LaravelEnvironmentConfig\Listeners\LoadConfigurationEventListener'))
    app('events')->subscribe('Unnutz\LaravelEnvironmentConfig\Listeners\LoadConfigurationEventListener');
```

## Usage

Simply create a folder within the `config` directory that matches your environment name, such as `local`. Next, create the configuration files you wish to override and specify the options for that environment. For example, to load additional service provider for the local environment, you would create a `app.php` file in `config/local` with the following content:

```php
<?php

return [

    'providers' => append_config([
        
        // additional service providers can be loaded here
    ]),

];
```

Please note that in order to merge two configurations you have to use `append_config(array $config)`.
## License

This package is open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT)