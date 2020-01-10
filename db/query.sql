SELECT movie FROM (
    SELECT movie_id as movie, profit, rank() OVER (ORDER BY profit DESC) AS range
    FROM (
        SELECT showtimes.movie_id, sum(bookings.price) as profit
        FROM showtimes
            INNER JOIN bookings ON showtimes.id = bookings.showtime_id
        WHERE bookings.status = 'sold'
        GROUP BY showtimes.movie_id
    ) AS profit_range
) AS movies_range
WHERE range = 1;
