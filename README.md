## Empty docker containers for new or existing projects

This is all file needed for docker to jenkins deploy.
```sh
├── data
│     └── mysql ( db data container local )
├── docker-compose.yml ( local development )
├── dump ( dump db )
├── etc
│   ├── nginx
│   │   ├── default.conf
│   │   └── default.template.conf
│   ├── php
│   │   └── php.ini
│   ├── mysql
│   │   └── my.cnf
│   └── ssl
├── web ( php site holder )
│   ├── migration ( sql scripts )
│   ├── mysql-build ( Dockerfile custom compile )
│   ├── mysql-migrates ( DB migrations )
│   ├── nginx-build ( Dockerfile custom compile )

```


1. Start the application :

    ```
    sudo docker-compose up -d
    ```

    **Please wait this might take a several minutes...**

    ```
    sudo docker-compose logs -f # Follow log output
    ```
    
    
#### Creating a Database 

```
source .env && sudo docker exec -i $(sudo docker-compose ps -q mysqldb) mysql -u"$MYSQL_ROOT_USER" -p"$MYSQL_ROOT_PASSWORD" -e "create database exampledb"; 
```

#### Restore Local DB 

 ```
source .env && sudo docker exec -i $(sudo docker-compose ps -q mysqldb) mysql -u"$MYSQL_ROOT_USER" -p"$MYSQL_ROOT_PASSWORD"  exampledb < "dump/exampledb.sql"
 ```



4. Stop and clear services

```
sudo docker-compose stop
```

## Use Tunel to access docker from outside network 

### Start start tunel with random url 

```
sh tunel.sh
```

````
Do you wish to start cron process (y/n)? 
````
By default cron services not working. 

````
Do you wish to start tunel with random url (y/n)? 
````






mysql-migrates
======================

Version control your database with tiny one migration script.

Handles migrating your MySQL database schema upwards. Easy to use in different environments: multiple developers, staging, production. Just run migrate and it will move the database schema to the latest version. Will detect conflicts and print out errors.

How to use
======================

 

To add a new migration:

    php mysql-migrate/migrate.php make [name-without-spaces]

To migrate to the latest version:

    php mysql-migrate/migrate.php run

The migrate script will create a ".version" file in the directory from which it is run. For this reason, I recommend running the migration script from one level up. Do not checkin the version file since it needs to be local!

When you add a new migration, a new script file will be created under the "migrations/" folder and this folder should be checked into the code repository. This way other environments can migrate the database using them.

More info
======================

To setup your database information, make sure to run:

    cp config.php.sample config.php
    nano config.php

The database version is tracked locally using file ".version".