-- ��������� ��������� ������
insert into attribute_type (name) values ('text'),('int'),('float'),('date'),('bool');
insert into attribute_type_prop (name, value, attribute_type_id) values ('author', '������� ������', 1),('author', '����������� ������', 1),('CountAfterDot', 2, 3),('CountBeforeDot', 4, 3);
insert into "attribute" (id, name, showname, attribute_type_id) values (1,'review', '��������', 1),(2,'prize','������', 1),(3,'date_of_premier', '���� ��������', 4),(4,'date_of_strart_sale_tickets', '������ ������ �������', 4),(5,'3D', '������ 3D', 5),(6,'task','������',1);

insert into attribute_value (attribute_id, movie_id, value_text) values (1,1, '��� ������� �������� �� �����');
insert into attribute_value (attribute_id, movie_id, value_text) values (1,1,'"����������� �������� �� �����');
insert into attribute_value (attribute_id, movie_id, value_date) values (3,1,'2020-04-21 21:00');
insert into attribute_value (attribute_id, movie_id, value_date) values (4,1,'2020-04-21 11:00');
insert into attribute_value (attribute_id, movie_id, value_bool) values (5,1,'true');
insert into attribute_value (attribute_id, movie_id, value_text, value_bool) values (1,1,'�������������� �������','true');
insert into attribute_value (attribute_id, movie_id, value_text) values (2,1, '�����');
insert into attribute_value (attribute_id, movie_id, value_text, value_date) values (6,1, '�������� ����������� � ���', '2021-04-01');
insert into attribute_value (attribute_id, movie_id, value_text, value_date) values (6,1, '�������� ��������� �������� ������', '2021-04-21');
