<p> Clone and cd into pet-shop-api</p>

#### Install composer dependencies

composer install

#### Create a database by the name 'pet-shop-api' in your php localhost

### Copy environment file and ensure correct environment credentials

cp .env.example .env

#### Migrate and seed the database

php artisan migrate:fresh --seed

#### Start your server and access the project from the link provided

php artisan serve

#### Access the site through the link provided by the above command.

#### Default routes:

Home link: http://127.0.0.1:8000
Swagger link: http://127.0.0.1:8000/swagger/index.html
