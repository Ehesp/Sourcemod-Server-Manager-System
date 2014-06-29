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

TO DO: Instructions on FTP zip upload

#### Environment & Database Configuration

##### Environment Setup

This tool provides a simple way to setup different working environments. By default the application is set to `local` development, and thus any configuration options within `app/config/local` override the defaults within `app/config`.

To set the environment into `production` mode (if on a live webserver), you need to set a PHP environment variable named `ENV` to `production`. This can either be done via the virtual host or in the `public/.htaccess` <- TO DO: instructions on .htaccess env vars

##### Database Setup

First, ensure you have a database setup with connected user privilages and details to hand.

To keep your sensitive details out of the application (incase you push your own version to a git based service), the database details are loaded from an environment file, which git ignores. These files are located in the root of your application, with the naming convention of `.env.*.php`. For example in local environment, the file will be named `.env.local.php`.

> In production, the file is named `.env.php`.

There are two ways to configure this file; the advised way by running the `php artisan ssms:dbconfig` command, or manually creating the file yourself with the following content:

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

###### Database Migrations via CLI

The application allows for a quick installer using the command line. In the root of the application, input the command:

`php artisan ssms:install`

Follow the instructions to setup your database migrations and seed data.

###### Database Migrations via SQL

If you're unable to setup your database via the artisan CLI, run the following SQL file in your database to create the tables needed for the application:

TO DO: Setup raw SQL commands

### Credits

- [Laravel 4 Framework](https://github.com/laravel/laravel)
- [Steam Condenser](https://github.com/koraktor/steam-condenser)