# Miranda CMS Based On Yii2 PHP Framework

Installation
------------

### Installing the application.

  1. Initialize the installed application

     Run `composer global require "fxp/composer-asset-plugin:^1.2.0"`
     Run `composer install`
     And then Execute the `init` command and select `dev` or `prod` as environment


  2. Configurate your web server:

     For Apache config file could be the following:

     ```apacheconf
     <VirtualHost *:80>
       ServerName mysite.com
       ServerAlias www.mysite.com
       DocumentRoot "/var/www/mysite.com/"
       <Directory "/var/www/mysite.com/">
         allow from all
         Options Indexes FollowSymLinks
         AllowOverride All
         Require all granted
       </Directory>
     </VirtualHost>
     ```
     For Nginx config file could be the following:

     ```nginx
     server {
         charset      utf-8;
         client_max_body_size  200M;
         listen       80;

         server_name  mysite.com;
         root         /var/www/mysite.com;

         location / {
             root  /var/www/mysite.com/frontend/web;
             try_files  $uri /frontend/web/index.php?$args;

             # avoiding processing of calls to non-existing static files by Yii
             location ~ \.(js|css|png|jpg|gif|swf|ico|pdf|mov|fla|zip|rar)$ {
                 access_log  off;
                 expires  360d;
                 try_files  $uri =404;
             }
         }

        location /storage {
             alias  /var/www/mysite.com/storage;
             rewrite  ^(/storage)/$ $1 permanent;
        }
         
        location /api {
             alias  /var/www/mysite.com/api/web;
             rewrite  ^(/api)/$ $1 permanent;
             try_files  $uri /api/web/index.php?$args;
         }
         
        location /admin {
             alias  /var/www/mysite.com/backend/web;
             rewrite  ^(/admin)/$ $1 permanent;
             try_files  $uri /backend/web/index.php?$args;
        }

         # avoiding processing of calls to non-existing static files by Yii
         location ~ ^/admin/(.+\.(js|css|png|jpg|gif|swf|ico|pdf|mov|fla|zip|rar))$ {
             access_log  off;
             expires  360d;

             rewrite  ^/admin/(.+)$ /backend/web/$1 break;
             rewrite  ^/admin/(.+)/(.+)$ /backend/web/$1/$2 break;
             try_files  $uri =404;
         }

         location ~ \.php$ {
             include  fastcgi_params;
             # check your /etc/php5/fpm/pool.d/www.conf to see if PHP-FPM is listening on a socket or port
             fastcgi_pass  unix:/var/run/php5-fpm.sock; ## listen for socket
             #fastcgi_pass  127.0.0.1:9000; ## listen for port
             fastcgi_param  SCRIPT_FILENAME $document_root$fastcgi_script_name;
             try_files  $uri =404;
         }
         #error_page  404 /404.html;

         location = /requirements.php {
             deny all;
         }

         location ~ \.(ht|svn|git) {
             deny all;
         }
     }
     ```

  3. Create a new database and adjust the `components['db']` configuration in `common/config/main-local.php` accordingly.

  4. Apply all migrations with console command `php yii migrate`.

  5. Init root user with console command `php yii init-admin`.

  7. Configurate your mailer `['components']['mailer']` in `common/config/main-local.php`.
