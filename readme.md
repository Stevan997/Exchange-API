# Laravel/Lumen Docker Scaffold

### **Description**

This will create a dockerized stack for a Laravel/Lumen application, consisted of the following containers:
-  **app**, your PHP application container

        Nginx, PHP7.4 PHP7.4-fpm, Composer
    
-  **mysql**, MySQL database container ([mysql](https://hub.docker.com/_/mysql/) official Docker image)

#### **Directory Structure**
```
+-- src <project root>
+-- resources
|   +-- default
|   +-- nginx.conf
|   +-- supervisord.conf
|   +-- www.conf
+-- .gitignore
+-- Dockerfile
+-- docker-compose.yml
+-- readme.md <this file>
```

### **Setup instructions**

**Prerequisites:** 

* Depending on your OS, the appropriate version of Docker Community Edition has to be installed on your machine.  ([Download Docker Community Edition](https://hub.docker.com/search/?type=edition&offering=community))

**Installation steps:** 

1. Create a new directory in which your OS user has full read/write access and clone this repository inside.

2. Open a new terminal/CMD, navigate to this repository root (where `docker-compose.yml` exists) and execute the following command:

    ```
    $ docker-compose up -d
    ```

    This will download/build all the required images and start the stack containers. It usually takes a bit of time, so grab a cup of coffee.

3. After the whole stack is up, enter the app container and run Lumen setup:

    ```
    $ docker exec -it app_exchange_api bash
    $ composer install
    $ nano .env
    $ php artisan migrate --seed
    ```

4. Setup `.env` file. You can see how it should look like in `.env.example` file

5. Log in to docker instance with following command `docker exec -it app_exchange_api /bin/bash`

6. Then run `composer install`

7. If there are issues with permissions for storage files run `chmod 777 -R storage/` inside docker container