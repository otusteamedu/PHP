select c."name", SUM(tp.price) as total  from tickets_price tp
join tickets t on (t.id = tp.id)
join seance s on (s.id = t.id_seance)
join "content" c on (c.id = s.id_content)
group by c."name" 
order by total desc 
limit 1
