# How to install the project

* PHP recommended version `8.0`

1. Clone the project
2. Run `composer install` to install composer dependencies
3. Run `cp .env.example .env` to create the environment file
4. Run `php artisan key:generate` to generate the app secret key
5. Restart your editor to update file imports in the code
6. Create and set the database information to the `.env` file
7. Run `php artisan migrate:fresh --seed` to create and seed the database tables
8. Import the `insomnia/insomnia.json` file to insomnia
9. Run `php artisan serve` to start the server

## Generate the Docs

1. Export the insonia workspace as `insomnia.json` to the `insomnia` folder 
2. Run `npm run docs:generate`
## Update the docs
1. Just export insomnia workspace as `insomnia.json` to the `insomnia` folder again and it will update

## Open the docs
* Run `npm run docs:start` then paste the link to the browser