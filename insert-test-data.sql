delete from movies."attributes";
delete from movies."types";
delete from movies."films";
delete from movies."values";


do
$$
    declare
        textId          integer;
        dateId          integer;
        intId           integer;
        floatId         integer;
        boolId          integer;
        serviceDateId   integer;
        scheduledDateId integer;
        worldPremierId  integer;
        ruPremierId     integer;
        startSalesId    integer;
        startReclamId   integer;
        endReclamId     integer;
        premiaId        integer;
        descriptionId   integer;
        reviewId        integer;
        recensId        integer;
        sloganId        integer;
        countryId       integer;
        ratingId        integer;
        durationId      integer;
        yearId          integer;
        shownId         integer;
        filmId          integer;

    begin
        insert into movies."types" ("name", data_type) values ('Текст', 'text') returning id into textId;
        insert into movies."types" ("name", data_type) values ('Дата', 'date') returning id into dateId;
        insert into movies."types" ("name", data_type) values ('Целое число', 'int4') returning id into intId;
        insert into movies."types" ("name", data_type) values ('Дробное число', 'numeric') returning id into floatId;
        insert into movies."types" ("name", data_type) values ('Логический тип', 'bool') returning id into boolId;
        insert into movies."types" ("name", data_type) values ('Важные даты', 'date') returning id into serviceDateId;
        insert into movies."types" ("name", data_type)
        values ('Служебные даты', 'date')
        returning id into scheduledDateId;


        insert into movies."attributes" ("name", type_id)
        values ('Мировая премьера', serviceDateId)
        returning id into worldPremierId;
        insert into movies."attributes" ("name", type_id)
        values ('Премьера в РФ', serviceDateId)
        returning id into ruPremierId;
        insert into movies."attributes" ("name", type_id)
        values ('Начало продаж', scheduledDateId)
        returning id into startSalesId;
        insert into movies."attributes" ("name", type_id)
        values ('Начало рекламной компании', scheduledDateId)
        returning id into startReclamId;
        insert into movies."attributes" ("name", type_id)
        values ('Конец рекламной компании', scheduledDateId)
        returning id into endReclamId;
        insert into movies."attributes" ("name", type_id) values ('Премия', textId) returning id into premiaId;
        insert into movies."attributes" ("name", type_id) values ('Описание', textId) returning id into descriptionId;
        insert into movies."attributes" ("name", type_id) values ('Отзывы', textId) returning id into reviewId;
        insert into movies."attributes" ("name", type_id) values ('Рецензия', textId) returning id into recensId;
        insert into movies."attributes" ("name", type_id) values ('Слоган', textId) returning id into sloganId;
        insert into movies."attributes" ("name", type_id) values ('Страна', textId) returning id into countryId;
        insert into movies."attributes" ("name", type_id) values ('Рейтинг', floatId) returning id into ratingId;
        insert into movies."attributes" ("name", type_id)
        values ('Длительность (мин)', intId)
        returning id into durationId;
        insert into movies."attributes" ("name", type_id) values ('Год создания', intId) returning id into yearId;
        insert into movies."attributes" ("name", type_id) values ('Был в прокате', boolId) returning id into shownId;

        --
----	Побег из Шоушенка
        insert into movies.films (title) values ('Побег из Шоушенка') returning id into filmId;

        insert into movies."values" (film_id, attr_id, val_text)
        values (filmId, premiaId, 'Oscar'),
               (filmId, premiaId, 'Венецианский фестиваль'),
               (filmId, sloganId, 'Страх - это кандалы. Надежда - это свобода');

        insert into movies."values" (film_id, attr_id, val_date)
        values (filmId, startSalesId, (now() + interval '20 days')::date),
               (filmId, startReclamId, current_date),
               (filmId, ruPremierId, '2019-12-12'),
               (filmId, worldPremierId, '2019-10-24');

        insert into movies."values" (film_id, attr_id, val_int)
        values (filmId, yearId, 1994),
               (filmId, durationId, 142);

        insert into movies."values" (film_id, attr_id, val_float)
        values (filmId, ratingId, 16.5);

        insert into movies."values" (film_id, attr_id, val_bool)
        values (filmId, shownId, 'yes');


        --
----	Леон
        insert into movies.films (title) values ('Леон') returning id into filmId;

        insert into movies."values" (film_id, attr_id, val_text)
        values (filmId, premiaId, 'Oscar'),
               (filmId, descriptionId, 'Профессиональный убийца Леон неожиданно для себя самого решает помочь 11-летней соседке Матильде,
								семью которой убили коррумпированные полицейские.'),
               (filmId, sloganId, 'Вы не можете остановить того, кого не видно');

        insert into movies."values" (film_id, attr_id, val_date)
        values (filmId, startSalesId, (now() + interval '20 days')::date),
               (filmId, startReclamId, current_date),
               (filmId, ruPremierId, '2020-12-12'),
               (filmId, worldPremierId, '1994-09-14');

        insert into movies."values" (film_id, attr_id, val_int)
        values (filmId, yearId, 1993),
               (filmId, durationId, 133);

        insert into movies."values" (film_id, attr_id, val_float)
        values (filmId, ratingId, 25.26);

        insert into movies."values" (film_id, attr_id, val_bool)
        values (filmId, shownId, 'no');


        --
----	Бойцовский клуб
        insert into movies.films (title) values ('Бойцовский клуб') returning id into filmId;

        insert into movies."values" (film_id, attr_id, val_text)
        values (filmId, countryId, 'США'),
               (filmId, recensId,
                'Лавочка, с помощью которой Рассказчик пытался разбить стекло, исчезает, когда он входит в здание на Franklin str.'),
               (filmId, sloganId, 'Интриги. Хаос. Мыло');

        insert into movies."values" (film_id, attr_id, val_date)
        values (filmId, startReclamId, (now() + interval '20 days')::date),
               (filmId, ruPremierId, '2000-01-13'),
               (filmId, worldPremierId, '1999-09-10');

        insert into movies."values" (film_id, attr_id, val_int)
        values (filmId, yearId, 1999),
               (filmId, durationId, 139);

        insert into movies."values" (film_id, attr_id, val_float)
        values (filmId, ratingId, 19.56);

        insert into movies."values" (film_id, attr_id, val_bool)
        values (filmId, shownId, 'no');

    end
$$;













