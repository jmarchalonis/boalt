<p align="center"><img src="https://res.cloudinary.com/dtfbvvkyp/image/upload/v1566331377/laravel-logolockup-cmyk-red.svg" width="400"></p>

<p align="center">
<a href="https://travis-ci.org/laravel/framework"><img src="https://travis-ci.org/laravel/framework.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/d/total.svg" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/v/stable.svg" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/license.svg" alt="License"></a>
</p>

## About Boalt Assessment

Based on the request requirements, this test laravel REST API will serve as documentation, thought process, and code. 

## Commands

"clear:notifications { force_delete }"

When creating the notifcations, i opted to included soft delete to retain historical data on when notifications were read 
by the user. As a result, there is a option flag that if passed, you are able to permanently delete the records.

command: php artisan clear:notifications true

## Integrations

For outside API Integration, I selected Amazon S3. You will be able to upload files to a single bucket on my S3 account. 
This is Policy locked via a custom account control. All uploads will be applied with public ACL and you will receive the 
URL. 

I choose to user S3, because it is something that is very practical and useful. As more and more company look to IOT and 
the cloud, we need to work closer with platforms like AWS/Azure/GoogleCloud. And while the integration is simple, it 
shows that the ability to work with AWS in various areas.  

## Deployment 

Please follow the following steps to deploy the environment and package: 

1. Run git clone https://github.com/jmarchalonis/boalt.git
2. Run composer install
3. Create/Move/Copy the .env and services.php files; cp/mv/nano .env and config/services.php. These are not included in the git repo for security reasons.
4. Modify and Set the database credentials in .env 
5. Modify and Set the AWS S3 credentials in services.php. ( Create a IAM User, User ACL Roles and Bucket in S3)
6. Set the correct read permissions on storage folders
7. Run Key Generation: php artisan key:generate 
8. Run DB Migration: php artisan migrate
9. Run DB Seed ( optional ); php artisan db:seed
10. Run Passport Install: php artisan passport:install
11. You can you use the service at this point or you can deploy your server, virtual hosts, ssl, etc. 


Services.php AWS Config Format
```
    'aws' => [
        'name' => 'publicaccess',
        'key' => '',
        'secret' => '',
        's3' => [
            'location' => 's3.amazonaws.com',
            'bucket' => ' ',
        ],
    ]
```
