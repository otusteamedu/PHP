CREATE TABLE "available_film" (
	"film_id" integer NOT NULL,
	"name" character varying(300) NOT NULL,
	"description" TEXT,
	"date_start" DATE NOT NULL,
	"date_stop" DATE,
	"long" TIME NOT NULL
) WITH (
  OIDS=FALSE
);



CREATE TABLE "available_hall" (
	"hall_id" integer NOT NULL,
	"hall_number" smallint NOT NULL,
	"seats" smallint NOT NULL
) WITH (
  OIDS=FALSE
);



CREATE TABLE "clients" (
	"client_id" bigint NOT NULL,
	"name" character varying(300) NOT NULL,
	"surname" character varying(300) NOT NULL,
	"patronymic" character varying(300),
	"registration_date" DATE NOT NULL,
	"phone" character varying(40) NOT NULL,
	"email" character varying(300) NOT NULL
) WITH (
  OIDS=FALSE
);



CREATE TABLE "order" (
	"order_id" bigint NOT NULL,
	"client_id" integer NOT NULL,
	"seance_id" bigint NOT NULL,
	"date_order" TIMESTAMP NOT NULL,
	"payment_id" smallint,
	"seat_number" smallint NOT NULL
) WITH (
  OIDS=FALSE
);



CREATE TABLE "payment_data" (
	"payment_id" bigint NOT NULL,
	"client_id" bigint NOT NULL,
	"payment_status" character varying(150) NOT NULL,
	"date_transaction" TIMESTAMP NOT NULL,
	"sum" money,
	"payment_type_id" integer,
	"seat_number" smallint NOT NULL
) WITH (
  OIDS=FALSE
);



CREATE TABLE "payment_type" (
	"payment_type_id" integer NOT NULL,
	"name" character varying(300) NOT NULL,
	"token" character varying(500),
	"description" TEXT
) WITH (
  OIDS=FALSE
);



CREATE TABLE "schedule" (
	"seance_id" integer NOT NULL,
	"film_id" integer NOT NULL,
	"price" money NOT NULL,
	"date_start" TIMESTAMP NOT NULL,
	"date_end" TIMESTAMP NOT NULL,
	"hall_id" smallint NOT NULL
) WITH (
  OIDS=FALSE
);



CREATE TABLE "workers" (
	"worker_id" integer NOT NULL,
	"name" character varying(300) NOT NULL,
	"surname" character varying(300) NOT NULL,
	"patronymic" character varying(300),
	"date_start" DATE NOT NULL,
	"date_dismissals" DATE
) WITH (
  OIDS=FALSE
);
