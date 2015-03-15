#Trophy - PHP/MySQL Contest Framework
Trophy is a lightweight framework for creating contests and competitions built using PHP and MySQL.

###System Requirements

* PHP 5.3+
* MySQL 4.1+
* [Composer](https://getcomposer.org/)

###Installation

Clone or download and unzip Trophy to your projects root directory.

Install dependencies using Composer

```
    composer install
```

To use the provided skeleton application and get started set up a database and create a table called 'entries' using 
the following SQL: 

```sql
CREATE TABLE IF NOT EXISTS 'entries' (
    'entry_id' int(11) NOT NULL AUTO_INCREMENT,
    'first_name' varchar(50) NOT NULL,
    'last_name' varchar(50) NOT NULL,
    'email' varchar(255) NOT NULL,
    'street' varchar(50) NOT NULL,
    'suburb' varchar(50) NOT NULL,
    'state' varchar(4) NOT NULL,
    'postcode' smallint(4) NOT NULL,
    'terms' tinyint(1) unsigned NOT NULL DEFAULT '0',
    'date_time' datetime NOT NULL,
    PRIMARY KEY ('entry_id')
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;
```

Installation assumes application is installed to a web sites root directory and accessed directly via a domain
- i.e. www.mycontest.com

#### Installation to a sub folder
Note: It is possible to install the application to a sub folder - i.e. **www.mysite.com/mycontest**. To enable this add the 
sub folder name in the root index.php file. This feature is still experimental and will require you to manually update 
paths to scripts, css files, images etc..

###Getting Started
#####Configuration
Edit **app/config.php** to configure Trophy to your needs including database settings, form field validation, 
messages, etc...

#####Themes
Trophy uses themes stored in the themes directory, the default bootstrap theme is already available and selected in 
the **app/config.php** file. You can edit this theme or create a new one and select it via the config file.

#####Entry Form
Trophy will take form fields and match and save the data to the corresponding database column. i.e. form field with

```
name="first_name"
```

...will be mapped and saved to the database column **first_name**. The provided skeleton application, bootstrap theme and 
provided database schema should demonstrate.

#####Download
You can view or download entries using a URL like: www.mysite.com/export. You will be prompted for the username/password
set in the config file. THe default download is a CSV file. Use www.mysite.com/export/screen to dump output to screen.

###Roadmap
Not necessarily in order:
* Document code
* Plugin system and plugins
* Convert Database to PDO
* Separate framework from application
* Unit tests and other QA
* Fix front controller to use any controller
* Fix front controller to work with root folder or sub folder
* Form field generation system
* Database generation system
* Trophy CMS


