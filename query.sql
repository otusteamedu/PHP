SELECT SUM(t.price), m.title FROM ticket t
LEFT JOIN showtime st ON st.id = t.showtime_id
LEFT JOIN movie m ON m.id = st.movie_id
WHERE t.sold = true
GROUP BY st.movie_id, m.title
ORDER BY sum(t.price) DESC LIMIT 1;