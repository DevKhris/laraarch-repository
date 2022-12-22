# **LaraArchRepository"**
LaraArchRepository is a laravel package for implementation of the Repository Design Pattern for abstracting the Models logic, usefull when you need more flexibility
and want to preserve the "fat model, skinny controller" approach in order to achieve more code decoupling and scalability

## **Installation**

### Install package with composer
```bash
$ composer require devkhris/laraarch-repository
```

### Publish config with provider
```bash
$ @php artisan vendor:publish --provider="DevKhris\LaraArchRepository\Providers\RepositoryServiceProvider" --tag="config"
```

## **Usage**
For creating a repository from a model just type the make command in the artisan console with the model name

E.g:
```bash
$ php artisan make:repository User
```
## **Features**
- Fast implementation of Repositories for Models with the artisan command
- Support for string-based identifiers (UUIDs) and integers
- Eloquent-based

## **Contributing and Issues**
