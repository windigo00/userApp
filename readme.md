# User App
simple user registration and management  webapp

## Introduction

User can login, register and view own details. If user registers as 'admin', then user can view user list and make changes.

I used Laravel for backend and Vue.js for frontend. Mysql for db, but this is optional for Laravel can handle many types of databases. :)

## Requirements

 - Server : 

	PHP - see [Laravel, https://laravel.com/docs/5.8/installation#installation]

    Vue & SCSS - see [Laravel, https://laravel.com/docs/5.8/installation#installation]



## Installation

clone app repo: `git clone https://github.com/windigo00/userApp.git`

Create or use existing database.

Copy `.env.example` into `.env`

Update `.env` configuration

Run migrations

### Javascript and Css (optional)

 - win:

`npm install --global cross-env`

`npm install`

 - linux:

`sudo npm install --global cross-env`

`npm install`

for dev: `npm run dev`

for production: `npm run build`
