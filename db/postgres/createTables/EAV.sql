CREATE TABLE IF NOT EXISTS "attribute_type" (
  id smallserial not null primary key,
  name varchar(55) null
);
CREATE UNIQUE INDEX attribute_type_id_UNIQUE ON attribute_type(id);

CREATE TABLE IF NOT EXISTS "attribute_type_prop" (
  id smallserial not null primary key,
  name varchar(55) null,
  value varchar(55) null,
  attribute_type_id int2 references attribute_type(id)
);
CREATE UNIQUE INDEX attribute_type_prop_id_UNIQUE ON attribute_type_prop(id);
CREATE INDEX attribute_type_prop_attribute_type_id_idx ON attribute_type_prop(attribute_type_id);

CREATE TABLE IF NOT EXISTS "attribute" (
  id smallserial not null primary key,
  name VARCHAR(125) null,
  showname VARCHAR(125) null,
  attribute_type_id int2 references attribute_type(id) 
  );
comment on column "attribute".name is '������������ ��������';
CREATE UNIQUE INDEX attribute_id_UNIQUE ON "attribute"(id);
CREATE INDEX attribute_attribute_type_id_idx ON "attribute"(attribute_type_id);

CREATE TABLE IF NOT EXISTS "attribute_value" (
  id smallserial not null primary key,
  value_text text null,
  value_int int4 null,
  value_float float null,
  value_date timestamp null,
  value_bool bool null,
  attribute_id int2 references "attribute"(id),
  movie_id int4 references movie(id) 
);
CREATE UNIQUE INDEX attribute_value_id_UNIQUE ON attribute_value(id);
CREATE INDEX attribute_value_attribute_id_idx ON attribute_value(attribute_id);
CREATE INDEX attribute_value_movie_id_idx ON attribute_value(movie_id);

