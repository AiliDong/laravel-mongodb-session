Laravel MongoDB Session
=======================

A MongoDB session driver for Laravel 5.

Installation
------------

Make sure you have [jenssegers\mongodb](https://github.com/jenssegers/Laravel-MongoDB) installed before you continue.

Install using composer:

    composer require ailidong/laravel-mongodb-session

Add the session service provider in `app/config/app.php`:

    'Purpleobject\Mongodb\Session\SessionServiceProvider',

Change the session driver in `app/config/session.php` to mongodb:

    'driver' => 'mongodb',

*Optional*: change the connection to a connection using the mongodb driver from `app/config/database.php`:

	'connection' => 'mongodb',
