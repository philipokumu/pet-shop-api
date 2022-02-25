<p>Clone repo and cd into pet-shop-api</p>

There are two ways to setup this project:

<ul>
<li>1. Docker Installation</li>
<li>2. Manual Installation</li>
</ul>

## 1. Docker installation

<ul>
<li>Run: docker-compose up -d --build</li>
<li>Run: docker-compose exec php php artisan migrate --seed</li>
<li>Run: docker-compose exec php php artisan jwt:secret</li>
</ul>

#### Access site

<ul>
<li>Home link: http://127.0.0.1:8084</li>
<li>Swagger link: http://127.0.0.1:8084/swagger/index.html</li>
</ul>

#### Run tests

Run: docker-compose vendor/bin/phpunit

## 2. Manual installation

#### Install composer dependencies

composer install

#### Create a database by the name 'pet_shop_api' in your php localhost

### Copy environment file and ensure correct environment credentials and variables.

<ul>
<li>cp .env.example .env</li>
<li>php artisan key:generate</li>
</ul>

#### Migrate and seed the database and set jwt secret

<ul>
<li>php artisan migrate:fresh --seed</li>
<li>php artisan jwt:secret</li>
</ul>

#### Start your server and access the project from the link provided

php artisan serve

#### Access the site through the link provided by the above command.

#### Default routes:

<ul>
<li>Home link: http://127.0.0.1:8000</li>
<li>Swagger link: http://127.0.0.1:8000/swagger/index.html</li>
</ul>

#### Run php unit tests

vendor/bin/phpunit
