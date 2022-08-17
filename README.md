# Car Service

Connect a database via .env file. You can copy .env.example as .env<br>
And you must run this command in terminal

    php artisan migrate && php artisan serve

If you want to run project with sample data, you can run with this command

    php artisan migrate && php artisan db:seed && php artisan serve

# Endpoints

## Authentication
`POST` /api/register

    {
        "name": "Özer Özdaş",
        "email": "ozer@ozdas.org",
        "password": "TestPass"
    }

`POST` /api/login

    {
        "email": "ozer@ozdas.org",
        "password": "TestPass"
    }

`GET` /api/logout

    {
        "token": "..."
    }

## Account
`POST` /api/v1/userBalance

    {
        "token": "...",
        "value": 700
    }

## Services
`GET` /api/v1/services

    {
        "token": "..."
    }
