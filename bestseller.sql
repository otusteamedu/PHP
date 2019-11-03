SELECT f.film_id, SUM(price) AS sum FROM film AS f
  LEFT JOIN seance AS s ON s.film_id = f.film_id
  LEFT JOIN ticket AS t ON t.seance_id = s.seance_id
  GROUP BY f.film_id
  HAVING SUM(price) >= ALL(
    SELECT SUM(price) FROM film AS f
      LEFT JOIN seance AS s ON s.film_id = f.film_id
      LEFT JOIN ticket AS t ON t.seance_id = s.seance_id
      GROUP BY f.film_id
  );