# How to install the project

* PHP minimun version `7.3`
* PHP recommended version `8.0`

1. Clone the project
2. Run `composer install` to install the dependencies
3. Run `cp .env.example .env` to create the environment file
4. Run `php artisan key:generate` to generate the app secret key
5. Restart your editor to update file imports in the code
6. Create and set the database information to the `.env` file
7. Run `php artisan migrate:fresh --seed` to create and seed the database tables
8. Import the insomnia workspace file `insomnia-workspace.json` using the `uuSync Plugin`
9. Run `php artisan serve` to start the server