INSERT INTO movies (id, title, duration)
    VALUES  (1, 'Гарри Поттер 1',100),
            (2, 'Гарри Поттер 2',120),
            (3, 'Гарри Поттер 3',130),
            (4, 'Гарри Поттер 4',125),
            (5, 'Гарри Поттер 5',135),
            (6, 'Гарри Поттер 6',120),
            (7, 'Гарри Поттер 7.1',120),
            (8, 'Гарри Поттер 7.2',125);

INSERT INTO halls (id, title) 
            VALUES  (1, 'Зал 1'),
                    (2, 'Зал 2'),
                    (3, 'Зал 3');

INSERT INTO seats (id, number, hall_id) 
        VALUES  (1, 1, 1),
                (2, 2, 1),
                (3, 3, 1),
                (4, 4, 1),
                (5, 5, 1),
                (6, 6, 1),
                (7, 7, 1),
                (8, 8, 1),
                (9, 9, 1),
                (10, 10, 1),
                (11, 1, 2),
                (12, 2, 2),
                (13, 3, 2),
                (14, 4, 2),
                (15, 5, 2),
                (16, 6, 2),
                (17, 7, 2),
                (18, 8, 2),
                (19, 1, 3),
                (20, 2, 3),
                (21, 3, 3),
                (22, 4, 3);

INSERT INTO sessions (id, movie_id, hall_id, start_time, price) 
            VALUES  (1, 1, 1, '2021-01-06 09:00', 250),
                    (2, 2, 1, '2021-01-06 11:00', 300),
                    (3, 3, 1, '2021-01-06 13:15', 350),
                    (4, 4, 1, '2021-01-06 15:35', 350),
                    (5, 5, 1, '2021-01-06 18:00', 400),
                    (6, 6, 2, '2021-01-06 11:00', 350),
                    (7, 7, 2, '2021-01-06 13:20', 350),
                    (8, 8, 2, '2021-01-06 15:50', 350),
                    (9, 6, 3, '2021-01-06 11:00', 450),
                    (10, 7, 3, '2021-01-06 13:20', 450),
                    (11, 8, 3, '2021-01-06 15:50', 450),
                    (12, 1, 1, '2021-01-07 09:00', 250),
                    (13, 2, 1, '2021-01-07 11:00', 300),
                    (14, 3, 1, '2021-01-07 13:15', 350),
                    (15, 4, 1, '2021-01-07 15:35', 350),
                    (16, 5, 1, '2021-01-07 18:00', 400),
                    (17, 3, 2, '2021-01-07 13:15', 350),
                    (18, 4, 2, '2021-01-07 15:35', 350),
                    (19, 5, 2, '2021-01-07 18:00', 350),
                    (20, 1, 3, '2021-01-07 11:00', 450),
                    (21, 2, 3, '2021-01-07 13:20', 450),
                    (22, 3, 3, '2021-01-07 15:50', 450);

INSERT INTO users (id, name, password,email, created_on, last_login)
VALUES (1, 'ivanov', 'password1', 'ivanov@gmail.com', '2021-01-03', '2021-01-05'),
       (2, 'petrov', 'password2', 'petrov@gmail.com', '2021-01-04', '2021-01-05'),
       (3, 'sidorov', 'password3', 'sidorov@gmail.com', '2021-01-05', '2021-01-05'),
       (4, 'ivanovI', 'password4', 'ivanovI@gmail.com', '2021-01-05', '2021-01-05'),
       (5, 'petrovP', 'password5', 'petrovP@gmail.com', '2021-01-05', '2021-01-05'),
       (6, 'sidorovS', 'password6', 'sidorovS@gmail.com', '2021-01-05', '2021-01-05')
       ;

INSERT INTO orders (id, session_id, seat_id, user_id, date_time)
    VALUES (1, 1, 1, 1, '2020-01-05 13:00'),
           (2, 1, 2, 2, '2020-01-05 13:00'),
           (3, 1, 3, 3, '2020-01-05 13:00'),
           (4, 1, 4, 4, '2020-01-05 13:00'),
           (5, 1, 5, 5, '2020-01-05 13:00'),
           (6, 1, 6, 6, '2020-01-05 13:00'),
           (7, 2, 1, 1, '2020-01-05 13:00'),
           (8, 2, 2, 2, '2020-01-05 13:00'),
           (9, 2, 3, 3, '2020-01-05 13:00'),
           (10, 2, 4, 4, '2020-01-05 13:00'),
           (11, 6, 11, 5, '2020-01-05 13:00'),
           (12, 9, 19, 6, '2020-01-05 13:00'),
           (13, 3, 1, 1, '2020-01-05 13:00'),
           (14, 3, 2, 2, '2020-01-05 13:00'),
           (15, 3, 3, 3, '2020-01-05 13:00'),
           (16, 3, 4, 4, '2020-01-05 13:00'),
           (17, 7, 11, 5, '2020-01-05 13:00'),
           (18, 10, 19, 6, '2020-01-05 13:00'),
           (19, 4, 1, 1, '2020-01-05 13:00'),
           (20, 4, 2, 2, '2020-01-05 13:00'),
           (21, 4, 3, 3, '2020-01-05 13:00'),
           (22, 4, 4, 4, '2020-01-05 13:00'),
           (23, 8, 11, 5, '2020-01-05 13:00'),
           (24, 11, 19, 6, '2020-01-05 13:00'),
           (25, 5, 1, 1, '2020-01-05 13:00'),
           (26, 5, 2, 2, '2020-01-05 13:00'),
           (27, 5, 3, 3, '2020-01-05 13:00'),
           (28, 5, 4, 4, '2020-01-05 13:00'),
           (29, 20, 19, 1, '2020-01-05 13:00'),
           (30, 20, 20, 2, '2020-01-05 13:00'),
           (31, 20, 21, 3, '2020-01-05 13:00'),
           (32, 20, 22, 4, '2020-01-05 13:00'),
           (33, 21, 19, 1, '2020-01-05 13:00'),
           (34, 21, 20, 2, '2020-01-05 13:00'),
           (35, 21, 21, 3, '2020-01-05 13:00'),
           (36, 21, 22, 4, '2020-01-05 13:00'),
           (37, 22, 19, 1, '2020-01-05 13:00'),
           (38, 22, 20, 2, '2020-01-05 13:00'),
           (39, 22, 21, 3, '2020-01-05 13:00'),
           (40, 22, 22, 4, '2020-01-05 13:00'),
           (41, 13, 9, 5, '2020-01-05 13:00'),
           (42, 13, 10, 6, '2020-01-05 13:00'),
           (43, 17, 17, 5, '2020-01-05 13:00'),
           (44, 17, 18, 6, '2020-01-05 13:00'),
           (45, 18, 17, 5, '2020-01-05 13:00'),
           (46, 18, 18, 6, '2020-01-05 13:00'),
           (47, 19, 17, 5, '2020-01-05 13:00'),
           (48, 19, 18, 6, '2020-01-05 13:00')
           ;