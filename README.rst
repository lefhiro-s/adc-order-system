Test Services Order System Dashboard

Overview
Test with PHP Codeigniter 4

Goals
As a ervices data with PHP Codeigniter 4 we are trying to address following goals:

Requirements
PHP (3.7.5)
Ci4 (4.0)
MySQL (5.1+)

#   Running the app

$ git clone https://github.com/lefhiro-s/adc-order-system.git

#   Configure database settings
    configure the database with .env file

$ php spark migrate
$ php migrate
$ php spark db:seed ConfigurationSeeder
$ php spark db:seed OfficeSeeder
$ php spark db:seed UserSeeder (optional: create three test users)


# Run to start the server
$ php spark serve
Browse to http://localhost:8080
