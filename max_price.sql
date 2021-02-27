SELECT movies.name, SUM(seats_price.price) as total_price
FROM movies
LEFT JOIN seances ON seances.movie_id = movies.id
LEFT JOIN tickets ON tickets.seance_id = seances.id
LEFT JOIN seats ON seats.id = tickets.seat_id
LEFT JOIN seats_price ON seats_price.seat_type_id = seats.type_id AND seats_price.seance_id = seances.id
GROUP BY movies.id
ORDER BY total_price DESC LIMIT 1