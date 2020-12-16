CREATE TABLE public."content" (
	id bigserial NOT NULL,
	name varchar(255) NOT NULL,
	id_genre int2 NOT NULL,
	age_limit int4 NOT NULL,
	movie_length int4 NOT NULL,
	CONSTRAINT content_pk PRIMARY KEY (id),
	CONSTRAINT content_un UNIQUE (name),
	CONSTRAINT content_fk FOREIGN KEY (id_genre) REFERENCES genre(id)
);

CREATE TABLE public."contentAttr" (
	id int4 NOT NULL DEFAULT nextval('contentattr_id_seq'::regclass),
	"name" varchar(255) NOT NULL,
	"type" int4 NOT NULL,
	CONSTRAINT contentattr_pk PRIMARY KEY (id),
	CONSTRAINT contentattr_un UNIQUE (name),
	CONSTRAINT contentattr_fk FOREIGN KEY (type) REFERENCES "contentAttrType"(id)
);

CREATE TABLE public."contentAttrType" (
	id int4 NOT NULL DEFAULT nextval('contentattrtype_id_seq'::regclass),
	"name" varchar(255) NOT NULL,
	"comment" varchar(255) NULL,
	CONSTRAINT contentattrtype_pk PRIMARY KEY (id),
	CONSTRAINT contentattrtype_un UNIQUE (name)
);

CREATE TABLE public."contentAttrValues" (
	id int4 NOT NULL DEFAULT nextval('contentattrvalues_id_seq'::regclass),
	"idContent" int4 NOT NULL,
	val_text varchar NULL,
	idfield int4 NOT NULL,
	val_date date NULL,
	val_boolean bool NULL,
	val_money money NULL,
	CONSTRAINT contentattrvalues_pk PRIMARY KEY (id),
	CONSTRAINT contentattrvalues_un UNIQUE ("idContent", idfield),
	CONSTRAINT contentattrvalues_fk FOREIGN KEY ("idContent") REFERENCES content(id),
	CONSTRAINT contentattrvalues_fk_1 FOREIGN KEY (idfield) REFERENCES "contentFields"(id)
);

CREATE TABLE public."contentFields" (
	id int4 NOT NULL DEFAULT nextval('contentfields_id_seq'::regclass),
	"name" varchar(255) NOT NULL,
	"idAttr" int4 NOT NULL DEFAULT nextval('contentfields_idattr_seq'::regclass),
	CONSTRAINT contentfields_pk PRIMARY KEY (id),
	CONSTRAINT contentfields_un UNIQUE (name),
	CONSTRAINT contentfields_fk FOREIGN KEY ("idAttr") REFERENCES "contentAttr"(id)
);
