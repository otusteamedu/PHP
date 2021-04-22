SELECT m.name, SUM(s.price * st.price_coefficient) AS total
FROM movies m
JOIN SESSION s ON s.movie_id = m.id
JOIN orders o ON o.session_id = s.id
JOIN hall_seats hs ON hs.id = o.seat_id
JOIN seat_type st ON st.id = hs.type_id
GROUP BY m.id
LIMIT 1;