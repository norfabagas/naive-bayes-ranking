<p align="center"><img src="https://res.cloudinary.com/dtfbvvkyp/image/upload/v1566331377/laravel-logolockup-cmyk-red.svg" width="400"></p>

<p align="center">
<a href="https://travis-ci.org/laravel/framework"><img src="https://travis-ci.org/laravel/framework.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/d/total.svg" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/v/stable.svg" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/license.svg" alt="License"></a>
</p>

## Local Development
- Make sure to your environments meet Laravel 6.x server requirements (https://laravel.com/docs/6.x#server-requirements)
- Clone this project to `git clone https://github.com/norfabagas/naive-bayes-ranking.git` or `git clone git@github.com:norfabagas/naive-bayes-ranking.git`
- Run `composer install` to install all framework's dependencies
- Create a database (MySQL or PostgreSQL or SQLite)
- Copy `.env.example` and paste it as `.env` and fill required environments [APP_NAME, DB_CONNECTION, DB_HOST, DB_DATABASE, DB_PORT, DB_USERNAME, DB_PASSWORD] based on your development environment
- Generate application key by running `php artisan key:generate`
- Run `php artisan setup` to run all required tasks
- Run `php artisan serve` and explore this projects

## Contribution
Found any bug(s) or not well-designed code(s) ? Don't hesitate to make pull request(s) or raise Issue(s)

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
