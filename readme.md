Для запуска проекта требуется выполнить следующие действия:

* Склонировать проект в любое место на диске
* Заполнить config/database.php данными для подключения к BD (PostgresSQL/MySQL)
* Выполнить в базе данных запрос на создание таблицы

``` sql
CREATE TABLE links (
	id serial NOT NULL PRIMARY KEY,
	url varchar(191) NOT NULL,
	short varchar(100) NOT NULL   
);
```

* Выполнить в корне проекта composer update
* Запустить локальный PHP сервер php -S localhost:8080

