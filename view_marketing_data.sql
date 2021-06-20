CREATE VIEW marketing_data AS (
     SELECT movies.name AS movie, movies_attributes_types.name AS attribute_type, movies_attributes.name AS attribute,
     COALESCE(movies_attributes_values.date_value::TEXT, movies_attributes_values.text_value, movies_attributes_values.numeric_value::TEXT) AS value
     FROM movies_attributes_values
     INNER JOIN movies ON movies_attributes_values.movie_id = movies.id
     INNER JOIN movies_attributes ON movies_attributes_values.attribute_id = movies_attributes.id
     INNER JOIN movies_attributes_types ON movies_attributes.type = movies_attributes_types.id
     ORDER BY movies.id
);
