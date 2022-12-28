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