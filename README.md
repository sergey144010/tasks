git clone sergey144010/tasks
composer install

Заполнить настройки подключения к базе
task/db/config.php

Схема базы данных в файле db/create_tables.ini
Создать таблицы базы данных или вручную или
запустить скрипт
php db/createTables.php

Запустить встроенный веб сервер
php -S localhost:8000 -t web/