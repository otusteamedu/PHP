база данных данных test доступна по логину db_test паролю DBTest по адресу small.crmit.ru

CREATE TABLE public.users (
	id serial NOT NULL,
	"name" varchar(255) NOT NULL,
	email varchar(255) NOT NULL,
	"password" varchar(255) NOT NULL,
	"token" varchar(255) NULL,
	CONSTRAINT users_pkey PRIMARY KEY (id)
);


CREATE TABLE public.roles (
	role_id serial NOT NULL,
	user_id int4 NOT NULL,
	role_name varchar(255) NOT NULL,
	CONSTRAINT roles_pkey PRIMARY KEY (role_id)
);


INSERT INTO public.users ("name",email,"password","token") VALUES ('rudin','rudinandrey@yandex.ru','12345678',NULL);
INSERT INTO public.roles (user_id,role_name) VALUES (3,'admin');

запускать файл app.php который возвращает пользователя, через DataMapper и используется LazyLoad для загрузки ролей пользователя.



>>>> print_r($user->getFullData());
>>Не надо так делать в коде. Это нарушение PSR
>>Понятно, что это для теста, но лучше научите приложение по команде выводить данные.
да, не досмотрел, спасибо. думал просто тестовое приложение, сделать один из паттернов доступа к данным.

>>То же самое с несколькими файлами вызова. Должен быть один входной файл. Всё остальное - через команды.
не думал об этом, согласен. Так действительно лучше!!!

>>if(trim($user->getUser()["name"]) == "") throw new \Exception("Имя пользователя пустое", 1);
>>if(trim($user->getUser()["email"]) == "") throw new \Exception("Пустой email", 1);
>>if(trim($user->getUser()["password"]) == "") throw new \Exception("Пустой пароль", 1);
>>Не проще ли один раз написать метод валидации полей?

спасибо! согласен. Реализовано.

>>return new \PDO("pgsql:dbname=test;host=small.crmit.ru", "db_test", "DBTest");
>>Хардкод

согласен, но опять же думал тестовое приложение, можно и похардкодить :) реализовал через ini-файл с получением через static метод класса Config
который можно будет заменить в итоге на что угодно, хоть с системных переменных тянуть данные, хоть откуда.

>>class Role
>>У Вас там доступно по факту только одно поле.

да, это попытка реализовать Lazy Load для отложенной загрузки связанных записей, не больше не меньше. сам паттерн.

>>vendor/
>>Эта директория не должна быть в репозитории

недосмотрел :) согласен, убираю всегда, а тут как то просочился ))

