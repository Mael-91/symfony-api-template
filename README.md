# Symfony API Template

- Synfony version : 5.1.2

## Table of content

- Getting started
- Configuration
    - Doctrine
    - unit tests
    - PHPStan
    - JWT Configuration
- First Functional test
- Contributing
- License
    
## Getting Started

Requirements :
- `PHP 7.2.5`
- `ext-ctype`
- `ext-iconv`
- `ext-json`

First create a new project with composer

```shell script
$ composer create-project mael/symfony-api-template
```

In the composer.json file, change the name of the project by yours as well as the description and the license.

## Configuration

Before you can start your project, you need to do some basic configuration

### Doctrine

In the `.env` file, modify the `DATABASE_URL` by filling in your identifiers (see the Symfony documentation)

### Unit tests

Our template provides you with a lot of tools for unit testing, you'll have to configure some things to suit your project

First, in the files `WebTestCase.php` and `ApiTestCase.php` you need to modify the login information that will be used to log in to a user.

You need to fill in the following variables `$username`, `$password` and `$route`

Ex : 
```php
public function login(string $username = 'test', string $password = 'test', string $route = '/api/login')
```

### PHPStan

We also added PHPStan which allows you to detect errors in your code, you can change the level of detection in the `phpstan.neon` file.

You will find PHPStan's documentation via this link [https://phpstan.org/](https://phpstan.org/)

### JWT Configuration

We assume that your api will use the `LexikJWTAuthenticationBundle`. You will find the configuration in `config/packages`

First, in the `.env` file, modify `JWT_PASSPHRAS`E by a string that you will choose

When you do the following two commands, it will ask you to enter the passphrase you previously selected

For JWT authentication to work, you need to generate two : 

```shell script
$ openssl genpkey -out config/jwt/private.pem -aes256 -algorithm rsa -pkeyopt rsa_keygen_bits:4096
$ openssl pkey -in config/jwt/private.pem -out config/jwt/public.pem -pubout
```

We have also added a bundle to refresh the JWT token, you will find the documentation here [https://github.com/markitosgv/JWTRefreshTokenBundle#readme](https://github.com/markitosgv/JWTRefreshTokenBundle#readme)

You can also configure the route in the `config/route.yaml` file.

Be careful, you have to configure the authentication system yourself via JWT, in the security.yaml file (see the bundle documentation [https://github.com/lexik/LexikJWTAuthenticationBundle/blob/master/Resources/doc/index.md](https://github.com/lexik/LexikJWTAuthenticationBundle/blob/master/Resources/doc/index.md)).

## First Functional test

During your first functional tests you will have to generate the sqlite database using the command

```shell script
$ php bin/console doctrine:database:create --env test
```

## Contributing

If you want to contribute to the improvement of the template, you can :

- Fork this repo
- Make your change
- Create pull request

## License

This repository is under MIT License