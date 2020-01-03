\connect cinema

CREATE INDEX movie_year ON movie (year);

CREATE INDEX movie_rating_index ON movie (rating_id);

CREATE INDEX hall_vip ON hall (is_vip) WHERE is_vip = true;

CREATE INDEX movie_session_date ON session (date(date), movie_id);

CREATE INDEX hall_seats ON seat (hall_id);
CREATE INDEX session_category_prices ON session_category_price (session_id, category_id);
