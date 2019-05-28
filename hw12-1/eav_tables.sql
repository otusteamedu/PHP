-- movie
CREATE TABLE public.movie (
	movie_id serial NOT NULL,
	"name" varchar(50) NULL,
	CONSTRAINT movie_pkey PRIMARY KEY (movie_id)
);

-- movie_attribute
CREATE TABLE public.movie_attribute (
	attribute_id serial NOT NULL,
	attribute_name varchar(50) NULL,
	attribute_class_id int4 NULL,
	attribute_type_id int4 NULL,
	CONSTRAINT movie_attribute_pkey PRIMARY KEY (attribute_id),
	CONSTRAINT "fk_movie_attribute-movie_attribute_class-attribute_class_id" FOREIGN KEY (attribute_type_id) REFERENCES movie_attribute_type(attribute_type_id),
	CONSTRAINT "fk_movie_attribute-movie_attribute_type-attribute_type_id" FOREIGN KEY (attribute_class_id) REFERENCES movie_attribute_class(attribute_class_id)
);

-- movie_attribute_class
CREATE TABLE public.movie_attribute_class (
	attribute_class_id serial NOT NULL,
	attribute_class_name varchar(50) NULL,
	CONSTRAINT movie_attribute_class_pk PRIMARY KEY (attribute_class_id)
);

-- movie_attribute_type
CREATE TABLE public.movie_attribute_type (
	attribute_type_id serial NOT NULL,
	attribute_type_name varchar(50) NULL,
	attribute_type varchar(50) NULL,
	CONSTRAINT movie_attribute_type_pkey PRIMARY KEY (attribute_type_id)
);

-- movie_attribute_value
CREATE TABLE public.movie_attribute_value (
	attribute_value_id serial NOT NULL,
	movie_id int4 NULL,
	attribute_id int4 NULL,
	text_value text NULL,
	date_value timestamp NULL,
	bool_value bool NULL,
	CONSTRAINT movie_attribute_value_pkey PRIMARY KEY (attribute_value_id),
	CONSTRAINT "fk_movie_attribute_value-movie-movie_id" FOREIGN KEY (movie_id) REFERENCES movie(movie_id),
	CONSTRAINT "fk_movie_attribute_value-movie_attribute-attribute_id" FOREIGN KEY (attribute_id) REFERENCES movie_attribute(attribute_id)
);