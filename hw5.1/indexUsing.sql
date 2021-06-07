SELECT * FROM pg_stat_user_indexes ORDER BY idx_scan DESC LIMIT 5;
SELECT * FROM pg_stat_user_indexes ORDER BY idx_scan ASC LIMIT 5;