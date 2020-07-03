# Workstation should have
- Laravel Framework 7.17.2
- PHP 7.4.2 
- MySql

# Database configuration
`Must create database first named file_panda`
 - DB_CONNECTION=mysql
 - DB_DATABASE=file_panda 

`Use your workstation DB credentials if different (file name .env)`
 - DB_USERNAME=root
 - DB_PASSWORD=

#Commands before you start
 - composer dump-autoload
 - composer install
 - php artisan migrate
 - php artisan db:seed --class=FileTypeSeeder

 - php artisan serve