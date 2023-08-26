<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400"></a></p>

<p align="center">
<a href="https://travis-ci.org/laravel/framework"><img src="https://travis-ci.org/laravel/framework.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

## Para rodar este projeto
```bash
$ git clone https://github.com/Mateussj/laravel-api.git
$ cd laravel-api
$ composer install
$ cp .env.example .env
$ php artisan key:generate
$ php artisan migrate #antes de rodar este comando verifique sua configuracao com banco em .env e a criação dos bancos necessarios
$ php artisan serve
$ php artisan db:seed #para gerar os seeders, dados de teste
```
Acesssar pela url: http://localhost:8000

## Pré-requisitos
- PHP >= 7.4
- MySql

### Artisan
- Executar o aplicativo Laravel:
```bash
$ php artisan
```
- Executar testes:
```bash
$ php artisan test
```
- Lembrando que para que os testes executem corretamente, preencha as configurações de testes no .env da aplicação nas seguintes chaves:

```bash
$ DB_CONNECTION_TESTE=
DB_HOST_TESTE=
DB_PORT_TESTE=
DB_DATABASE_TESTE=
DB_USERNAME_TESTE=
DB_PASSWORD_TESTE=
```

## Rotas

- A aplicação conta com as seguintes rotas:

- Crud de usuarios
```bash
GET - /crud/users
GET - /crud/users/{id}
POST - /crud/users
PUT - /crud/users/{id}
DELETE - /crud/users/{id}
```
- Rota que retorna varias ou uma postagem apartir de uma api externa
```bash
GET - /api/posts
GET - /api/posts/{id}
```
- Rota que organiza um menu com uma função recursiva
```bash
GET - /matriz
```
- Rota que aciona uma tarefa que cria um quantidade massiva de usuarios com dados fake
```bash
GET - /fake
```
