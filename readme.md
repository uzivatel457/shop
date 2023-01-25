Shop Nette Web Project
=================

This is a testing code for web application - office orders. 
For testing purposes only! Project is not finished.

Requirements
------------

- Web Project for Nette 3.1 requires PHP 7.2


Installation
------------

## Download or clone repository
Run `git clone https://github.com/uzivatel457/shop.git`.

## Prepare database
Create database and run query in `db/init.log`, which will create tables and basic data.

## Prepare configuration
Create file `config/local.neon` with the same structure as in template file `config/local.template.neon` and configure access to database.

## Download dependencies
Run `composer install`.

Make directories `temp/` and `log/` writable.


Web Server Setup
----------------

The simplest way to get started is to start the built-in PHP server in the root directory of your project:
    cd path/to/install
	php -S localhost:8000 -t www

Then visit `http://localhost:8000` in your browser to see the welcome page.

API
---

## Fetch order details
Call `GET http://localhost:8000/api/orders/15`

## Mark order as processed
Call `POST http://localhost:8000/api/orders/<id>/set-processed`.
- also get method is enabled for demonstration purposes