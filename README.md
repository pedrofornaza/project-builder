Project Builder PHP
===================

A project builder for PHP. Creates a folder structure and an empty Application class with namespace. He alsos downloads the composer.phar e generate a composer.json config file.

Usage
-----

The usage is simple. We have two params:

* project-name = The name of your project. Will be the name of the root folder and the principal namespace;
* destiny-folder = Where project-builder will place your project (Optional);

You can run Project Builder with this command:

`php bin/project-builder.php [project-name] [destiny-folder]`

Description
-----------

The root folder will receive the name of your project. The folder structure looks like this:

* bin
* public
* src
* tests

### Bin folder

Here we have the composer.phar downloaded from the official website.

### Public folder

An index.php file and a .htaccess is placed here.

### Src folder

A folder with the name of your project is here with an Application class inner.

### Tests folder

This folder have the same of the src folder, expcets that the Application class is a Test class.


