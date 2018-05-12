# Установка, настройка, выполнение

1. `git clone https://github.com/sergey144010/tasks`
2. `cd tasks`
2. `composer install`
3. Заполнить настройки подключения к базе в файле
```php
db/config.php
```
4. Схема базы данных в файле db/create_tables.ini.
Создать таблицы базы данных или вручную или запустить скрипт
```php
php db/createTables.php
```
5. Запустить встроенный веб сервер
```php
php -S localhost:8000 -t web/
```

6. В браузере перейти на localhost:8000

### Dev enviroment

Mysql 5.6.22. Php 7.1.5
