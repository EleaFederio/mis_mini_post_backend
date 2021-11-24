# MIS-203 Simple POS
###### Just a Project in MIS-203 Business Systems

![DB Schema](https://raw.githubusercontent.com/EleaFederio/mis_mini_post_backend/main/MIS_POS-DB-Schema.PNG?token=AGKYLM7LIG4Z32BIEFEOT7LBRKKBC)

### System  Requirements
* PHP 8^
* Apache 2
* Laravel 8^
* Composer
* Node JS
* Mysql
* Git

### Installation
###### Make sure you already installed git, apache, php & composer before doing this
1. Clone the source code to your machine
```
git clone https://github.com/EleaFederio/mis_mini_post_backend.git
```
2. go to project directory
```
cd mis_mini_post_backend
```
3. install dependencies using composer
```
composer install
```
4. create .env file
```
copy .env.example .env
```
5. generate app key
```
php artisan key:generate
```
5. create a table name `barangay` in your database.
6. in you .env file find `DB_DATABASE` and set it to "barangay". DB_TABLE need to be same as the database you create in  step 5
```
DB_DATABASE=barangay
```
7. generate migration (Make sure your database running)
```
php artisan migrate
```
8. seed a data (this is data for branches and categories)
```
php artisan db:seed
```
9. run the system
```
php artisan serve
```
10. if there is no conflict with you network you can find the API running at [localhost:8000]('localhost:8000')
11. <button onclick="window.location.href='https://github.com/EleaFederio/mis_mini_pos';">Install the Front End</button>
