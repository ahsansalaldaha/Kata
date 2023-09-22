<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400"></a></p>

<p align="center">
<a href="https://travis-ci.org/laravel/framework"><img src="https://travis-ci.org/laravel/framework.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## Kata Assignment

Ali and Abdullah are shopkeepers in a little town in Pakistan. They would like to display a
simple program that satisfies their requirements:

- The opening days and hours of the shop need to be configured. The opening hours
are spread throughout the week. Their store is open on Monday, Wednesday, and
Friday from 08:00 till 06:00 hours, They are closed during lunchtime (12:00 - 14:45).
- Every other week they are open on Saturdays as well.
- Ali wants the website of their shop to display whether it is opened or closed at the
moment.
- Ali and Abdullah would love to add a datepicker so website visitors can check if the
shop is opened on a selected day.
Make use of OOP, write code SOLID, and VueJS/ReactJS, Apply the code standards, and
aim for clean self-explanatory code.
- A widget to see if the store is open or closed at the moment.
- If closed, then display the nearest date when the ship is open.
- A widget where a visitor can select a date and in return see if the shop is opened or
not.
- Bonus: if the store is closed show when it will open in a humanly readable format (eg.
1 day from now instead of the date)


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
