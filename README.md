# Topolaravel

## Introduction

## Prerequisite

- Install xampp
- move .env.example .env
- modify xampp/apache/conf/httpd.conf
    - change http port
    ```
    #
    # Listen: Allows you to bind Apache to specific IP addresses and/or
    # ports, instead of the default. See also the <VirtualHost>
    # directive.
    #
    # Change this to Listen on specific IP addresses as shown below to 
    # prevent Apache from glomming onto all bound IP addresses.
    #
    #Listen 12.34.56.78:80
    Listen 81
    ```
    - change document root to laravel public 
    ```
    #
    # Note that from this point forward you must specifically allow
    # particular features to be enabled - so if something's not working as
    # you might expect, make sure that you have specifically enabled it
    # below.
    #

    #
    # DocumentRoot: The directory out of which you will serve your
    # documents. By default, all requests are taken from this directory, but
    # symbolic links and aliases may be used to point to other locations.
    #
    DocumentRoot "D:/xampp/htdocs"
    <Directory "D:/xampp/htdocs">
    ```
    
## Todo

- using database to manage data
