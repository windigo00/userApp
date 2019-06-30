# User App
simple user registration and management  webapp


## Introduction

User can login, register and view own details. If user registers as 'admin', then user can view user list and can make changes.

I used Laravel for backend and Vue.js for frontend. Mysql for db, but this is optional for Laravel can handle many types of databases. :)


## Requirements

 - Server :

	PHP - see [Laravel, https://laravel.com/docs/5.8/installation#server-requirements]

    Vue & SCSS - Project repo contains already processed js/css files. If you wish to make changes, see [Vue CLI, https://cli.vuejs.org/guide/] for details on updating scripts or [Javascript and Css] part of this document for brief summary.


## Installation

clone app repo: `git clone https://github.com/windigo00/userApp.git`


Create database and db user or use existing.

`CREATE DATABASE 'user_app';`

`CREATE USER 'user_app'@'localhost' IDENTIFIED BY 'user_password';`

`GRANT ALL PRIVILEGES ON user_app.* TO 'user_app'@'localhost';`

`FLUSH PRIVILEGES;`


Copy template file `.env.example` into `.env`.


Update `.env` configuration. Chiefly DB_* for database connection. Use name and credentials from db setup step. (see Laravel env setup for more [https://laravel.com/docs/5.8/configuration#environment-configuration])

For more info on Laravel app setup, pleease see [https://laravel.com/docs/5.8/installation#installation]


Install vendor packages with composer

`composer install`


Generate security key

`php artisan key:generate`

Run migrations

`php artisan migrate`



### Javascript and Css (optional)

`npm install`

for dev: `npm run dev`

for production: `npm run build`

### Server preparation

 - you can run `php artisan serve` for local server or setup standard hosting. mod_rewrite is optional. 