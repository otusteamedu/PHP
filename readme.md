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
