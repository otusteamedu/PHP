CREATE OR REPLACE VIEW public.marketing
AS select
       f."name" ,
       at2.attr_type ,
       a.attr_name ,
       av.attr_value
   from films f
            join attr_values av ON av.film = f.id
            join attrs a on a.id  = av.attr
            join attr_types at2 on at2.id = a.attr_type;
COMMENT ON  VIEW public.marketing IS 'Данные для маркетинга';
