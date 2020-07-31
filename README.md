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

## Integrations

For outside API Integration, I selected Amazon S3. You will be able to upload files to a single bucket on my S3 account. 
This is Policy locked via a custom account control. All uploads will be applied with public ACL and you will receive the 
URL. 