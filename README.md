## Sourcemod Server Management System

The Sourcemod Server Management System is a PHP based web application designed to ease the never-ending battle of managing your Sourcemod servers on either Windows or Linux based machines.  SSMS authenticates using your Steam account and provides full access control to all of your users.

This tool is based on Snelvuurs original [SSMS](https://github.com/Snelvuur/SSMS).

*This tool is still in development*

### Installation

#### Server Requirements

Your server/environment must have the following installed:

- [Git](http://git-scm.com/)
- [Composer](https://getcomposer.org/download/)

> If you do not have CLI access, please look at the packaged installation method.

Your web server must have the following minimum requirements:

- PHP Version >= 5.4
- MCrypt PHP Extension
- OpenSSL PHP Extension
- cURL PHP Extension
- Apache mod_rewrite installed/enabled
- Database (SQL, SQLite)

##### CLI Installation via Git

Start off by cloning the repository into your web directory:

`git clone https://github.com/Ehesp/Sourcemod-Server-Manager-System.git`

In the root of your cloned directory, run the following Composer command to install the tools dependancies:

`composer install`

Ensure your storage directory is readable, writeable and executable:
> This applies to Unix/Linux based machines only.

`chmod -R 777 app/storage`

##### Packaged Installation

Upload via FTP

#### Environment & Database Configuration

##### Environment Setup

This tool provides a simple way to setup different working environments. By default the application is set to `local` development, and thus any configuration options within `app/config/local` override the defaults within `app/confg`.

To set the environment into `production` mode (if on a live webserver), you need to set a PHP environment variable named `ENV` to `production`. This can either be done via the virtual host or in the `public/.htaccess` ???

##### Database Setup

First, ensure you have a database setup with connected user privilages and details to hand.

To prevent your database details from being hardcoded into the application, the application looks for a file named `.env.*.php` based on the current environment. For example, to setup your database in `local` a local environment, create a file named `.env.local.php` in the root of your install, with the following:

~~~
<?php

	return array(
	    'database.host' => 'localhost',
	    'database.name' => 'ssms',
	    'database.user' => 'root',
	    'database.password' => 'mypassword',
	);

?>
~~~

For production environment, this file will be called `.env.production.php` using the same format.

###### Database Migrations via CLI

The application allows for a quick installer using the command line. In the root of the application, input the command:

`php artisan ssms:install`

Follow the instructions to setup your database.

###### Database Migrations via SQL

If you're unable to setup your database via the artisan CLI, run the following SQL file in your database to create the tables needed for the application:

TO DO: Setup raw SQL

### Credits

- [Laravel 4 Framework](https://github.com/laravel/laravel)
- [Steam Condenser](https://github.com/koraktor/steam-condenser)