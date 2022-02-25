<p> Clone and cd into pet-shop-api</p>
There are two ways to setup this project:
<li>1. Docker Installation</li>
<li>2. Manual Installation</li>
<ul>

## 1. Docker installation

<ul>
<li>Run: docker compose up -d --build</li>
<li>Run: docker-compose exec php php artisan migrate --seed</li>
<li>Run: docker-compose exec php php artisan jwt:secret</li>
</ul>

#### Access site

Home link: http://127.0.0.1:8084
Swagger link: http://127.0.0.1:8084/swagger/index.html

#### Run tests

Run: docker-compose vendor/bin/phpunit

## 2. Manual installation

#### Install composer dependencies

composer install

#### Create a database by the name 'pet-shop-api' in your php localhost

### Copy environment file and ensure correct environment credentials and variables

cp .env.example .env
php artisan key:generate

#### Migrate and seed the database and set jwt secret

php artisan migrate:fresh --seed
php artisan jwt:secret

#### Start your server and access the project from the link provided

php artisan serve

#### Access the site through the link provided by the above command.

#### Default routes:

Home link: http://127.0.0.1:8000
Swagger link: http://127.0.0.1:8000/swagger/index.html

#### Run php unit tests

vendor/bin/phpunit
