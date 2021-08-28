# How to install the project

* PHP recommended version `8.0`

1. Clone the project
```
	git clone https://github.com/guilhermehccruz/laravel-api-template.git
```

2. Install composer dependencies
```
    composer install
```

3. Create the environment file
```
	cp .env.example .env
```

4. Generate the app secret key
```
	php artisan key:generate
```

5. Create and set the database information to the `.env` file

6. Create and seed the database tables
```
	php artisan migrate:fresh --seed
```

7. Start the server at `http://127.0.0.1:8000/`
```
	php artisan serve
```

Restart your editor if it doesn't recognize imported classes in the code


## Docs and Requests (Optional)

### Importing the insomnia workspace

* Import the `insomnia/insomnia.json` file to insomnia
### Generating the Docs

1. Export the insonia workspace as `insomnia.json` to the `insomnia` folder 
2. Run `npm run docs:generate`
```
	npm run docs:generate
```

### Updating the docs
* Export insomnia workspace as `insomnia.json` to the `insomnia` folder

### Opening the docs
* Run `npm run docs:start` then paste the link to the browser
```
	npm run docs:start
```