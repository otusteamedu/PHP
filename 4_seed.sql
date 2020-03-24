insert into movie (name)
values ('бэтмен'), ('бэтмен и робин'), ('бэтмен возвращается');

insert into movie_attr_type (name)
values ('date'), ('bool'), ('text'), ('numeric');

call movie_attr_add('review', 'text');
call movie_attr_add('award_oskar', 'bool');
call movie_attr_add('award_nika', 'bool');
call movie_attr_add('premiere_world', 'date');
call movie_attr_add('premiere_russia', 'date');
call movie_attr_add('sales_start', 'date');
call movie_attr_add('advert_start', 'date');
call movie_attr_add('advert_budget', 'numeric');

call movie_set_attr(1, 'award_oskar', true);
call movie_set_attr(1, 'review', 'abralenvlnvek'::varchar);
call movie_set_attr(1, 'advert_start', '2020-06-12 14:00'::timestamp);
call movie_set_attr(1, 'advert_budget', 1000000);

call movie_set_attr(2, 'advert_start', current_date + interval '2 hour');
call movie_set_attr(2, 'sales_start', current_date + interval '10 hour');

call movie_set_attr(3, 'advert_start', current_date + interval '2 hour');
call movie_set_attr(3, 'sales_start', current_date + interval '10 day 2 hour' );

