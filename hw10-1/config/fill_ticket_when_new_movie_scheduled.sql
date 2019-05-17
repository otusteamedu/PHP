-- this INSERT can be automated by moving to trigger for "INSERT INTO schedule"
-- by default, column `cinema`.`ticket`.`ticket_status_id` will have value = 0 which means that ticket is not bought yet
-- <new_schedule_id> - this is new shedule_id for which new tickets must be added into `cinema`.`ticket`
INSERT INTO `cinema`.`ticket`
(`schedule_id`,`seat_id`)
select sc.schedule_id, se.seat_id 
from `schedule` sc
join seat se on sc.hall_id = se.hall_id and sc.schedule_id = <new_schedule_id>;