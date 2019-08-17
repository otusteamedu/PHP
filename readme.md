### hmw10 cinema db

get best income moview

`SELECT MAX(`income`)
 FROM (SELECT SUM(`price`) as `income` FROM `ticket` GROUP BY `session`) as t`