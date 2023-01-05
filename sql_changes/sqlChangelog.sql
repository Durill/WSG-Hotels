CREATE DATABASE IF NOT EXISTS `bsg-hotels` /*!40100 DEFAULT CHARACTER SET utf8 COLLATE utf8_polish_ci */;
USE `bsg-hotels`;

-- tabela users -- 
CREATE TABLE IF NOT EXISTS `users` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `NAME` varchar(50) COLLATE utf8_polish_ci NOT NULL,
  `SURNAME` varchar(50) COLLATE utf8_polish_ci NOT NULL,
  `EMAIL` varchar(75) COLLATE utf8_polish_ci NOT NULL,
  `PASSWORD` varchar(255) COLLATE utf8_polish_ci NOT NULL,
  `ACC_ACTIVATED` tinyint(1) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=58 DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

/* zmiany w bazie rób jak zmiany w prawdziwej bazie a nie dodanie pól do tabeli ręcznie np.
        ALTER TABLE users ADD PESEL VARCHAR;
    zamiast wklejenie `PESEL` varchar(11) do CREATE TABLE która już istnieje
*/

-- Changes 30.12.2022 --
CREATE TABLE IF NOT EXISTS `bsg-hotels`.`admins` (
  `ID` INT NOT NULL AUTO_INCREMENT ,
  `USERNAME` VARCHAR(50) CHARACTER SET utf8 COLLATE utf8_polish_ci NOT NULL ,
  `EMAIL` VARCHAR(100) CHARACTER SET utf8 COLLATE utf8_polish_ci NOT NULL ,
  `PASSWORD` VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_polish_ci NOT NULL ,
  PRIMARY KEY (`ID`)) ENGINE = InnoDB;

-- Changes 04.01.2023 --
ALTER TABLE `bsg-hotels`.`users` AUTO_INCREMENT = 1;

CREATE TABLE IF NOT EXISTS `bsg-hotels`.`rooms` (
  `ID` INT NOT NULL AUTO_INCREMENT,
  `PLACES` TINYINT NOT NULL,
  `PRICE` DECIMAL(10, 2) NOT NULL,
  `ROOM_TYPE` ENUM('bronze', 'silver', 'gold'),
  PRIMARY KEY (`ID`)
) ENGINE = InnoDB;

CREATE TABLE IF NOT EXISTS `bsg-hotels`.`reservations` (
  `ID`        INT NOT NULL AUTO_INCREMENT,
  `ROOM_ID`   INT NOT NULL,
  `USER_ID`   INT NOT NULL,
  `FROM_DATE` DATE NOT NULL,
  `TO_DATE` DATE NOT NULL,
  PRIMARY KEY (`ID`),
  FOREIGN KEY (`ROOM_ID`) REFERENCES `bsg-hotels`.`rooms`(`ID`),
  FOREIGN KEY (`USER_ID`) REFERENCES `bsg-hotels`.`users`(`ID`)
) ENGINE = InnoDB;

-- Changes 05.01.2023 --

ALTER TABLE users convert TO CHARACTER SET utf8mb4 COLLATE utf8mb4_polish_ci;
ALTER TABLE admins convert TO CHARACTER SET utf8mb4 COLLATE utf8mb4_polish_ci;
ALTER TABLE rooms convert TO CHARACTER SET utf8mb4 COLLATE utf8mb4_polish_ci;
ALTER TABLE reservations convert TO CHARACTER SET utf8mb4 COLLATE utf8mb4_polish_ci;

DROP PROCEDURE IF EXISTS add_column;

-- Procedure for adding columns - it will be added only if column doesnt exist

DELIMITER //
CREATE PROCEDURE add_column(IN ts VARCHAR(100) , IN tn VARCHAR(100), cn VARCHAR(100), ct VARCHAR(100))
BEGIN
IF NOT EXISTS( SELECT table_schema FROM INFORMATION_SCHEMA.COLUMNS
           WHERE table_schema = ts COLLATE utf8mb4_polish_ci
             AND table_name = tn COLLATE utf8mb4_polish_ci
             AND column_name = cn COLLATE utf8mb4_polish_ci)  THEN
        SET @ddl = CONCAT('ALTER TABLE ', tn);
        SET @ddl = CONCAT(@ddl, ' ', 'ADD COLUMN');
        SET @ddl = CONCAT(@ddl, ' ', cn);
        SET @ddl = CONCAT(@ddl, ' ', ct);

        PREPARE stmt FROM @ddl;
        EXECUTE stmt;
        DEALLOCATE PREPARE stmt;

END IF;
END //
DELIMITER ;

CALL add_column('bsg-hotels', 'reservations', 'canceled', 'BOOLEAN NOT NULL DEFAULT 0');
CALL add_column('bsg-hotels', 'reservations', 'price', 'DECIMAL(10, 2) NOT NULL DEFAULT (0)');
CALL add_column('bsg-hotels', 'reservations', 'places', 'TINYINT NOT NULL DEFAULT (0)');
CALL add_column('bsg-hotels', 'reservations', 'room_type', 'ENUM("bronze", "silver", "gold") NOT NULL DEFAULT ("bronze")');
CALL add_column('bsg-hotels', 'rooms', 'deleted', 'BOOLEAN NOT NULL DEFAULT 0');

UPDATE reservations AS res 
LEFT JOIN rooms AS ro ON res.room_id = ro.id 
SET 
  res.price = (ro.price * (DATEDIFF(res.to_date, res.from_date) + 1)),
  res.room_type = ro.room_type,
  res.places = ro.places 
WHERE res.price = 0;

ALTER TABLE reservations 
  ALTER COLUMN price DROP DEFAULT,
  ALTER COLUMN places DROP DEFAULT,
  ALTER COLUMN room_type DROP DEFAULT;