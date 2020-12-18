
==================================
Test Services Order System Dashboard
==================================

--------
Overview
--------

**Dashboard with PHP Codeigniter 4**

-----
Goals
-----

As a Services data with PHP Codeigniter 4 we are trying to address following goals:

1. Creating and editing users

2. User permission management

3. Management of offices associated with users

4. Product order creation

5. List of orders and edition of order status

6. Product search through api services

7. Sending orders through Apis


------------
Requirements
------------

1. PHP (5.4)
2. Ci4 (4.0)
3. MySQL (5.1+)


Running the app
^^^^^^^^^^^^^^^

$ git clone https://github.com/lefhiro-s/adc-order-system.git

	#   Configure database settings
    	configure the database with .env file

$ php spark migrate
$ php migrate
$ php spark db:seed ConfigurationSeeder
$ php spark db:seed OfficeSeeder
$ php spark db:seed UserSeeder (optional: create three test users)


Browse to http://localhost:8000

