<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400"></a></p>

<p align="center">
<a href="https://travis-ci.org/laravel/framework"><img src="https://travis-ci.org/laravel/framework.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## Kata Assignment

To run the project run.

```
cp .env.example .env
./vendor/bin/sail up -d
./vendor/bin/sail shell
php artisan migrate
php artisan db:seed
```

and visit
<a href="http://127.0.0.1">Localhost Link</a>

## TODO/Skipped List

-   Error validation on frontend
-   Front end Testing using Chai, Mocha
-   Detailed backend testing - Unit Feature
-   Vuex not incorporated
-   Setting up separate databases for Prod and testing
-   Timezone for schedule is in ETC/UTC so provide time accordingly
