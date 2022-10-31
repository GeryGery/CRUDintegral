# CRUDintegral

This was a project done for a technical test on an interview, the test is specified in the file: 'Enunciado.pdf' (Only in spanish, sorry!)

## Introduction

This CRUD features 3 main tables: Categories, Subcategories and Documents

As the test stated, Documents depend on Subcategories and Categories alike, but since all Subcategories depend on only one Category (1-*), the Category associated with the Document would become redundant information at the database. So this is my UML proposed and accepted:

![image](https://user-images.githubusercontent.com/46798662/198999360-ec8a954b-fa92-4edd-8922-2dc136c3858f.png)

The whole project was done rendering a php page that outputs php, js and mysql queries on the fly, and the final look of it is 3 pages navigated with a navbar on top that displays all info of the table and allows for edit and delete (according to the test, only documents can be deleted but this project is prepared to allow categories and subcategories to be deleted)

## Webpage view

### Categories

(Image placeholder)

Categories only feature a name that can be edited
The delete functionality is purely visual, as the test asked for the documents to be deletable

### Subcategories

(Image placeholder)

Subcategories feature a name for the subcategory and a select for the category associated
The delete functionality is purely visual, as the test asked for the documents to be deletable

### Documents

(Image placeholder)

Documents feature a name for the document two selects for the category and subcategory associated, a description (text) for the document and internally a 'deleted' state, since logically deleting information is way better for restoring unwanted deleting actions than permanently deleting
The delete functionality is purely visual, as the test asked for the documents to be deletable

## Database details

![image](https://user-images.githubusercontent.com/46798662/199012254-3dc7cfe8-22bb-48c2-a68d-13eb6566dd9f.png)

The database consists only on these 3 tables (no pivot tables) and as you can see, there are some 'check' clauses to prevent less than minimum length on the fields that require a minimum, (maximum is already specified at the very varchar declaration).
Primary, Unique and Foreign keys were introduced following the requirements at the test statement.

As a side note I included 'ON UPDATE' clause on the foreign keys but not 'ON DELETE', since the test didn't require for the Category and Subcategory to have the capability to be deleted this wasn't necessary. As an improvement this clause should be altered into 'ON UPDATE ... ON DELETE ...' to include deletion of Categories and Subcategories

## How to use/test
The whole program was implemented at a Raspberry Pi 4B connected 24/7 at my home (homepage: gerard.onthewifi.com) with apache server. To implement the repository you must download the data, config and launch:

### Download



### Config

In order to use this CRUD you must download & install Apache server, MySQL/MariaDB and download and config the very same CRUD repository

#### Apache

(Placeholder apache installation steps)

#### MySQL/MariaDB

(Placeholder mariadb installation steps)

#### CRUD config

At the file config.php (inside configs folder) there are 4 empty variables ready to be filled with parameters to connect to the MySQL server:
- Host: Specify host hosting the MySQL/MariaDB server
- User: User at the server
- Pass: Password for the user
- DB: name of the DB at the server


### Launch and test

If everything is configured correctly you can now test this CRUD. Enjoy! ;)
