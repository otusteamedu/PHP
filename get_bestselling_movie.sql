SELECT m.id         AS "movie_id",
       m.title      AS "movie_title",
       m.duration   AS "duration",
       sum(t.price)/100 AS "cache_box",
       count(t.id)  AS "tickets_count"
FROM movies m
         INNER JOIN sessions s ON m.id = s.movie_id
         INNER JOIN tickets t on s.id = t.session_id
GROUP BY m.id
ORDER BY cache_box DESC
LIMIT 1;