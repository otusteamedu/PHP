-- фильмы
create table if not exists films
(
    film_id   serial       not null,
    film_name varchar(200) not null,
    primary key (film_id)
);
-- Entity
create table if not exists entities
(
    entity_id   serial       not null,
    entity_name varchar(200) not null,
    primary key (entity_id)
);
-- Attribute
create type allow_types as enum ('string', 'date', 'float', 'boolean');
create table if not exists attrs
(
    attr_id        serial       not null,
    attr_entity_id int          not null references entities (entity_id),
    attr_name      varchar(200) not null,
    attr_type      allow_types,
    primary key (attr_id)
);
-- значения атрибутов (текст)
create table if not exists attr_values_string
(
    av_id           serial not null,
    av_film_id      int    not null references films (film_id),
    av_entity_id    int    not null references entities (entity_id),
    av_attribute_id int    not null references attrs (attr_id),
    av_attr_value   text,
    primary key (av_id)
);
-- значения атрибутов (дата)
create table if not exists attr_values_date
(
    av_id           serial not null,
    av_film_id      int    not null references films (film_id),
    av_entity_id    int    not null references entities (entity_id),
    av_attribute_id int    not null references attrs (attr_id),
    av_attr_value   date,
    primary key (av_id)
);
-- значения атрибутов (число)
create table if not exists attr_values_float
(
    av_id           serial not null,
    av_film_id      int    not null references films (film_id),
    av_entity_id    int    not null references entities (entity_id),
    av_attribute_id int    not null references attrs (attr_id),
    av_attr_value   decimal(10, 4),
    primary key (av_id)
);
-- значения атрибутов (логическое)
create table if not exists attr_values_boolean
(
    av_id           serial not null,
    av_film_id      int    not null references films (film_id),
    av_entity_id    int    not null references entities (entity_id),
    av_attribute_id int    not null references attrs (attr_id),
    av_attr_value   boolean,
    primary key (av_id)
);

-- тестовые данные
insert into films (film_name)
values ('Harry Potter');
insert into entities (entity_name)
values ('Рецензии'),
       ('Премия'),
       ('Важные даты'),
       ('Служебные даты');
insert into attrs (attr_entity_id, attr_name, attr_type)
VALUES (1, 'рецензии критиков', 'string'),
       (1, 'отзыв неизвестной киноакадемии', 'string');
insert into attrs (attr_entity_id, attr_name, attr_type)
VALUES (2, 'оскар', 'boolean'),
       (2, 'ника', 'boolean');
insert into attrs (attr_entity_id, attr_name, attr_type)
VALUES (3, 'мировая премьера', 'date'),
       (3, 'премьера в РФ', 'date');
insert into attrs (attr_entity_id, attr_name, attr_type)
VALUES (4, 'дата начала продажи билетов', 'date'),
       (3, 'когда запускать рекламу на ТВ', 'date');

insert into attr_values_string (av_film_id, av_entity_id, av_attribute_id, av_attr_value)
VALUES (1, 1, 1, 'Это рецензия очень неизвестного критика'),
       (1, 1, 2, 'Отзыв киноАкадемии');
insert into attr_values_boolean (av_film_id, av_entity_id, av_attribute_id, av_attr_value)
VALUES (1, 1, 3, true),
       (1, 1, 4, false);

CREATE OR REPLACE VIEW attr_values AS
(
select e.entity_id,
       e.entity_name,
       a.attr_id,
       a.attr_name,
       a.attr_type,
       COALESCE(avs.av_attr_value::text, avf.av_attr_value::text, avd.av_attr_value::text,
                avb.av_attr_value::text)                                        "attr_value",
       COALESCE(avs.av_film_id, avf.av_film_id, avd.av_film_id, avb.av_film_id) "film_id",
       COALESCE(avs.av_id, avf.av_id, avd.av_id, avb.av_id)                     "av_id"
from entities e
         left join attrs a on e.entity_id = a.attr_entity_id
         left join attr_values_boolean avb on a.attr_id = avb.av_attribute_id
         left join attr_values_date avd on a.attr_id = avd.av_attribute_id
         left join attr_values_float avf on a.attr_id = avf.av_attribute_id
         left join attr_values_string avs on a.attr_id = avs.av_attribute_id
    );

CREATE TRIGGER eavtrigger
    BEFORE INSERT OR UPDATE
    ON "attr_values"
    FOR EACH ROW
EXECUTE PROCEDURE eav_trigger();

CREATE OR REPLACE FUNCTION eav_trigger()
    RETURNS trigger AS
$BODY$
declare
    table_name varchar;
begin
    table_name := 'attr_values_' || NEW.attr_type;
    if NEW.score > 0 then
        if (TG_OP = 'INSERT') then
            INSERT INTO table_name (av_film_id, av_entity_id, av_attribute_id, av_attr_value)
            values (NEW.film_id, NEW.entity_id, NEW.attr_id, NEW.attr_value);
        end if;

        if (TG_OP = 'UPDATE') then
            if OLD.score <> NEW.score then
                UPDATE table_name
                set av_film_id=NEW.film_id,
                    av_entityid=NEW.entity_id,
                    av_attribute_id=NEW.attr_id,
                    av_attr_value=NEW.attr_value
                where av_id = OLD.av_id;
            end if;
        end if;
    end if;
    return new;
end;
$BODY$
    LANGUAGE plpgsql VOLATILE
