# User App
A simple user registration and management webapp


## Introduction

User can login, register and view own details. If user registers as 'admin', then user can view user list and can make changes.

I used Laravel for backend and Vue.js for frontend. Mysql for db, but this is optional for Laravel can handle many types of databases. :)


## Requirements

 - Server :

	PHP - see [Laravel, https://laravel.com/docs/5.8/installation#server-requirements]

    Vue & SCSS - Project repo contains already processed js/css files. If you wish to make changes, see [Vue CLI, https://cli.vuejs.org/guide/] for details on updating scripts or [Javascript and Css] part of this document for brief summary.


## Installation

For more info on Laravel app setup, please see [https://laravel.com/docs/5.8/installation#installation]

 - Clone app repo: `git clone https://github.com/windigo00/userApp.git`

 - Create database and db user or use existing.

	`CREATE DATABASE 'user_app';`

	`CREATE USER 'user_app'@'localhost' IDENTIFIED BY 'user_password';`

	`GRANT ALL PRIVILEGES ON user_app.* TO 'user_app'@'localhost';`

	`FLUSH PRIVILEGES;`

 - Copy template config file `.env.example` into `.env`.

 - Update `.env` configuration. Chiefly `DB_*` for database connection. Use db name and credentials from db setup step. (see Laravel env setup for more [https://laravel.com/docs/5.8/configuration#environment-configuration])

 - Install vendor packages with composer

	`composer install`

 - Generate security key

	`php artisan key:generate`

 - Run migrations (creates db tables)

	`php artisan migrate`
    
 - Form more information on Laravel `artisan`, please visit [https://laravel.com/docs/5.8/artisan]


### Javascript and Css (optional)

Repo already contains processed js and css for dev environment. This step is for development and production.

 - Install packages

	`npm install`

 - Update compiled scripts for dev: `npm run dev`

 - Update compiled scripts for production: `npm run build`

## Server

 - You can run `php artisan serve` for local server or setup standard hosting. mod_rewrite is optional. 
