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

ALTER TABLE `bsg-hotels`.`reservations` ADD COLUMN `CANCELED` BOOLEAN NOT NULL DEFAULT 0;

