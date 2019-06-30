[![CircleCI](https://circleci.com/gh/botnetdobbs/Lumen-Job-Board.svg?style=svg)](https://circleci.com/gh/botnetdobbs/Lumen-Job-Board)
[![Maintainability](https://api.codeclimate.com/v1/badges/ce238ede6b96b7022b68/maintainability)](https://codeclimate.com/github/botnetdobbs/Lumen-Job-Board/maintainability)
[![Test Coverage](https://api.codeclimate.com/v1/badges/ce238ede6b96b7022b68/test_coverage)](https://codeclimate.com/github/botnetdobbs/Lumen-Job-Board/test_coverage)

## Setup

### Dependencies

* [PHP 7+](http://php.net/) - popular general-purpose scripting language suited to web development
* [Lumen 5.8](https://lumen.laravel.com/docs/5.8) - The stunningly fast micro-framework by Laravel

### Getting Started

Setting up project in development mode

* Ensure PHP 7.0+ is installed by running:
```
php -v
```

* Clone the repository to your machine and navigate into it:
```
git clone https://github.com/botnetdobbs/Lumen-Job-Board.git && cd Lumen-Job-Board
```
* Install application dependencies:
```
composer install
```
* Create a *.env* file and include the necessary environment variables. NB- copy from the *.env.example* and fill in the correct values

## Database setup
Create your database locally on your machine, i.e `lumen_job_board`cand add it as a value to the respective environment variable as below.
```
DB_DATABASE=lumen_job_board
```


## Running the application
Inside the project root folder, run the command below in your console
```
$ php artisan passport:install
```

```
$ php artisan migrate:fresh
```
```
$ php artisan db:seed
```
```
$ php -S localhost:8001 -t public
```


## Running the tests

```
- $ ./vendor/bin/phpunit
```


| Method | Endpoint | Params |
| ------ | ------ | ------- |
| POST | ```api/v1/auth/register``` | ```json {"first_name": "Imega", "last_name": "Crack", "email": "ctm@gmail.com", "role": "[applicant or employer]" "password": "xbt3y0b07d0tn3t"}``` |
| POST | ```api/v1/auth/login``` | ```json {"email": "ctm@gmail.com", "password": "xbt3y0b07d0tn3t"}``` |
| POST | ```api/v1/jobs``` | ```json { "title": "Software dev", "company": "test company", "location": "Nairobi" "job_description": "detailed description","application_email": "test@email.com" }``` |
| GET | ```api/v1/jobs```| ```?description=ruby+rails ,``` ```?search={job_title,}``` ```?sort=id_asc,``` ```?sort=title_desc,``` ```?limit=10&offset=8``` |
| GET | ```api/v1/jobs/{id}``` | N/A |
| PUT | ```api/v1/jobs/{id}``` |  Any of the fields ☝️ |
| DELETE | ```api/v1/jobs/{id}``` | N/A |
| POST | ```api/v1/jobs/{id}/applications``` | ```json { "subject": "interest", "cv_description": "experience" }``` |
| GET | ```api/v1/jobs/{id}/applications/``` |```?search={application_subject,}``` ```?sort=id_asc,``` ```?sort=subject_asc,``` ```?limit=10&offset=8``` |
| GET | ```api/v1/jobs/{id}/applications/{id}``` |N/A|
| PUT | ```api/v1/jobs/{id}/applications/{id}``` | Any of the fields ☝️ |
| DELETE | ```api/v1/jobs/{id}/applications/{id}``` | N/A |