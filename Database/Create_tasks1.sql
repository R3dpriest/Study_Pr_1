USE NGO_Foodbank;

DELIMITER $$

DROP PROCEDURE IF EXISTS AddUpcomingWeeks$$

CREATE PROCEDURE AddUpcomingWeeks()
BEGIN
    DECLARE current_date DATE;
    DECLARE target_date DATE;
    DECLARE d DATE;
    DECLARE week_val INT;
    DECLARE year_val INT;

    SET current_date = CURDATE();
    SET target_date = DATE_ADD(current_date, INTERVAL 6 MONTH);
    SET d = current_date;

    WHILE d <= target_date DO
        SET week_val = WEEK(d, 3);
        SET year_val = YEAR(DATE_ADD(d, INTERVAL (4 - WEEKDAY(d)) DAY));

        IF NOT EXISTS (
            SELECT 1 FROM WMS_Weeks WHERE week = week_val AND year = year_val
        ) THEN
            INSERT INTO WMS_Weeks (week, year, start_date, end_date)
            VALUES (
                week_val,
                year_val,
                DATE_SUB(d, INTERVAL WEEKDAY(d) DAY),
                DATE_ADD(DATE_SUB(d, INTERVAL WEEKDAY(d) DAY), INTERVAL 6 DAY)
            );
        END IF;

        SET d = DATE_ADD(d, INTERVAL 7 DAY);
    END WHILE;
END$$

DELIMITER ;