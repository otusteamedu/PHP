INSERT INTO movieattr ("name","type") VALUES 
('Продолжительность',1)
,('Мировая премьера',3)
,('Бюджет',1)
,('Режиссер',2)
,('Сборы в мире',1)
,('Запустить рекламу в директе',3)
,('Запустить рекламу на радио',3)
,('Начать показывать в большом зале',3)
,('Мин. цена билета',4)
;

INSERT INTO movie (title,status,created_at) VALUES
('Всегда никогда никому',0,'2001-09-28 01:00:00.000')
,('Джентельмены удачи',0,'2001-09-28 01:00:00.000')
,('Операция мы',0,'2001-09-28 01:00:00.000')
;

INSERT INTO movieattrvalues (id_attr,id_movie,val_int,val_date,val_text,val_num) VALUES
(1,1,5456,NULL,NULL,NULL)
,(3,1,65778686,NULL,NULL,NULL)
,(5,1,765757,NULL,NULL,NULL)
,(1,2,5557,NULL,NULL,NULL)
,(3,2,4566656,NULL,NULL,NULL)
,(5,2,56446546,NULL,NULL,NULL)
,(4,1,NULL,NULL,'Георгий Пронин',NULL)
,(4,2,NULL,NULL,'Прон Георгиев',NULL)
,(6,1,NULL,'2020-05-10',NULL,NULL)
,(2,1,NULL,'2020-04-10',NULL,NULL)
;
INSERT INTO movieattrvalues (id_attr,id_movie,val_int,val_date,val_text,val_num) VALUES
(7,1,NULL,'2020-04-15',NULL,NULL)
,(8,2,NULL,'2020-04-13',NULL,NULL)
,(6,2,NULL,'2020-04-15',NULL,NULL)
,(2,2,NULL,'2020-06-15',NULL,NULL)
,(7,2,NULL,'2020-03-14',NULL,NULL)
,(9,1,NULL,NULL,NULL,120.50)
,(9,2,NULL,NULL,NULL,200.50)
,(8,1,NULL,'2020-04-06',NULL,NULL)
;

INSERT INTO movieattrtype ("name","comment") VALUES
('Целое число',NULL)
,('Текст',NULL)
,('Дата',NULL)
,('Дробное число',NULL)
;
