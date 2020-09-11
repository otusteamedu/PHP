CREATE TABLE movieattrvalues (
	id serial NOT NULL,
	id_attr int NULL,
	id_movie int NULL,
	val_int int NULL,
	val_date date NULL,
	val_text varchar NULL,
	val_num numeric(10,2) NULL,
	CONSTRAINT m_a_v_pkey PRIMARY KEY (id)
);
CREATE INDEX movieattrvalues_id_attr_idx ON movieattrvalues USING btree (id_attr);
CREATE INDEX movieattrvalues_id_movie_idx ON movieattrvalues USING btree (id_movie);


CREATE TABLE movieattrtype (
	id serial NOT NULL,
	"name" varchar(256) NULL,
	"comment" varchar NULL,
	CONSTRAINT m_a_t_pkey PRIMARY KEY (id)
);

CREATE TABLE movieattr (
	id serial NOT NULL,
	"name" varchar(256) NULL,
	"type" int NULL,
	CONSTRAINT m_a_pkey PRIMARY KEY (id)
);
CREATE INDEX movieattr_type_idx ON movieattr USING btree (type);


CREATE TABLE movie (
	id serial NOT NULL,
	title varchar(512) NULL,
	status int2 NULL,
	created_at timestamp NULL,
	CONSTRAINT movie_pkey PRIMARY KEY (id)
);

