# horoscopes
A simple project of laravel 8 with fullcalendar 5.9.0

Functionalities are:
1.  Generates horoscopes for all 12 Zodiac signs for a given year. Each sign can have from 1 - really shitty day to 10 - super amazing day. Day scores are generated randomly for each day and stored in the database.
2.  Shows a calendar for a given year and Zodiac sign. Days should be colored from #ff0000 (really shitty) to #00ff00 (super amazing).
3.  Shows the best month on average (by score) for a Zodiac sign in a given year.
4.  Shows which Zodiac sign has the best year (by score).

Major Steps are:
1. Install Laravel using Composer. 
```
composer create-project laravel/laravel horoscopes
```
3. Configure Database in the .env file.
4. Create Authentication using Laravel Breeze.
 ```
  composer require laravel/breeze --dev
  php artisan breeze:install
  npm install
  npm run dev
  php artisan migrate
 ```
4. Create Horoscopes model, database migration and controller
        php artisan make:model Horoscopes -mc
5. Edit model and migration as per project need
6. Add following functions in the horoscopesController
 - public function index()
 - public function generate()
 - public function store()
 - public function calendar()
 - private function get_color_code()
 - public function best_month_calendar()
 - public function best_of_year()
7. Create/edit following blade files
 - generate-horoscopes
 - welcome
8. Add routes in routes/web.php file
9. Add Fullcalendar 5.9.0. just download the package zip. Add main.js and main.css to the project. Add some script to the welcome blade.

##Installation
1. Install Laravel 8
2. Configure Database
3. Create Laravel Auth
4. copy 
```
app/Http/Controllers/HoroscopesController.php
app/Models/Horoscopes.php
app/Models/Zodiac_signs.php
database/migrations/2021_07_27_063533_create_zodiac_signs_table.php
database/migrations/2021_07_27_065319_create_horoscopes_table.php

public/css/main.css
public/js/main.js

resources/views/dashboard.blade.php
resources/views/generate-horoscopes.blade.php
resources/views/welcome.blade.php

routes/web.php
```
5. Run migration

Thats it!
There may some design issue as I did not work much with design part of this project. I focused on the functionality only.
Feel free to contact me if you have query in your mind.
Thanks
