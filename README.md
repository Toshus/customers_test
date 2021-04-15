# Customers API
This is the test app.

### Install
1. clone project
2. `composer install`
3. set up database credentials in `.env` file, set up test database credentials in `.env.test`
4. If database not exists `php bin/console doctrine:database:create`
5. `php bin/console doctrine:migrations:migrate`
6. configure nginx

    ```
    server {
        listen 80;
        server_name cust.loc;
        root /var/www/customers_test/public;
        
        location / {
            # try to serve file directly, fallback to index.php
            try_files $uri /index.php$is_args$args;
        }

        location ~ ^/index\.php(/|$) {
            fastcgi_pass unix:/var/run/php/php7.4-fpm.sock;
            fastcgi_split_path_info ^(.+\.php)(/.*)$;
            include fastcgi_params;

            fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
            fastcgi_param DOCUMENT_ROOT $realpath_root;
            internal;
        }

        error_log /var/log/nginx/customers_test_error.log;
        access_log /var/log/nginx/customers_test_access.log;
    }
    ```
7. Configure `hosts` file if necessary

### Usage

1. Get list of customers. Supports pagination and takes two optional parameters `limit` (default value 10) and `offset` (default value 0) 

   `/customer/?limit=10&offset=0`

2. Get customer.

   `/customer/{id}`

3. Console command for loading customer's data from outer API. Supports two optional parameters `results` (dafault value 100) and `nat` (nationality, deafult value 'AU')

   `php bin/console app:customers:load`   
   
### Run tests

##### Run all tests

`make tests` 

##### Run unit tests

`make unit` 

##### Run functional tests

`make functional` 
