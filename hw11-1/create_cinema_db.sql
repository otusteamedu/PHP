create database cinema;
\connect cinema
create table hall (hall_id serial, name varchar(50), size int, primary key (hall_id));
create table movie (movie_id serial, name varchar(50), primary key(movie_id));
create table schedule (schedule_id serial, movie_id int, begin_time timestamp, hall_id int, price money, primary key(schedule_id));
create table seat (seat_id serial, hall_id int, num int, row int, primary key(seat_id));
create table ticket (ticket_id serial, ticket_status_id int, schedule_id int, seat_id int, primary key(ticket_id));
create table ticket_status (ticket_status_id int, ticket_status varchar(50), primary key(ticket_status_id));