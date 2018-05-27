Cart lite
=========

## Notice: This is a technical demo - not for production purpose

> For a real world e-commerce project based on Symfony look at [Sylius](https://sylius.com/)!

Installation
------------

Once the project downloaded in your workspace cd into the project then
```
make setup
```
Edit the database settings according to your local database then
```
make install
```
To access the website locally you have to run the php and assets server
```
make server
```

Admin
-----

To access the admin space go to /admin
- login: *admin*
- password: *password*

API
---

A KISS API is available at /api - the products are listed on json format.

Data export
-----------

You can export as a .csv file the products stored on database simply run
```
make export
```

Tests
-----

To launch the tests suite run
```
make server
```

RTFM
----

For more informations on how to work with this project see the main vendors documentation:
- [Symfony](http://symfony.com/doc/current/index.html)
- [Doctrine](https://www.doctrine-project.org/projects/doctrine-orm/en/2.6/index.html)
- [Yarn](https://yarnpkg.com/en/docs)
- [Bootstrap](https://getbootstrap.com/docs/4.1/getting-started/introduction/)
