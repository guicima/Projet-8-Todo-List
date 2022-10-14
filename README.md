# ToDoList
ToDoList is a project to manage a list of tasks to be done

[![Codacy Badge](https://app.codacy.com/project/badge/Grade/3fa4fae5d73942168292a3b406047873)](https://www.codacy.com/gh/guicima/Projet-8-Todo-List/dashboard?utm_source=github.com&amp;utm_medium=referral&amp;utm_content=guicima/Projet-8-Todo-List&amp;utm_campaign=Badge_Grade)

[![Quality Gate Status](https://sonarcloud.io/api/project_badges/measure?project=guicima_Projet-8-Todo-List&metric=alert_status)](https://sonarcloud.io/summary/new_code?id=guicima_Projet-8-Todo-List)

## Set up the environnement
### Install dependencies

Install Composer
[Get Composer](https://getcomposer.org/)

### Start the project

Install composer dependencies
```sh
composer install
```

Load database
```sh
php bin/console doctrine:migrations:migrate
php bin/console doctrine:fixtures:load -n
```

Start project in local
```sh
symfony serve
```