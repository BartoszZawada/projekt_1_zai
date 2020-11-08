/*
Created: 2020-11-02
Modified: 2020-11-08
Model: MySQL 8.0
Database: MySQL 8.0
*/

-- Create tables section -------------------------------------------------

-- Table User

CREATE TABLE `User`
(
  `user_id` Int NOT NULL AUTO_INCREMENT,
  `username` Varchar(256) NOT NULL,
  `password` Varchar(256) NOT NULL,
  `email` Varchar(256) NOT NULL,
  PRIMARY KEY (`user_id`)
)
;

-- Table Music

CREATE TABLE `Music`
(
  `music_id` Int NOT NULL AUTO_INCREMENT,
  `file_name` Varchar(256) NOT NULL,
  `title` Varchar(256) NOT NULL,
  `ISRC` Varchar(256) NOT NULL,
  `composer` Varchar(256) NOT NULL,
  `author` Varchar(256) NOT NULL,
  `author_2` Varchar(256) NOT NULL,
  `time` Int NOT NULL,
  PRIMARY KEY (`music_id`)
)
;

-- Table Raport

CREATE TABLE `Raport`
(
  `raport_id` Int NOT NULL AUTO_INCREMENT,
  `name` Varchar(256) NOT NULL,
  `month` Int NOT NULL,
  `year` Int NOT NULL,
  PRIMARY KEY (`raport_id`)
)
;

ALTER TABLE `Raport` ADD UNIQUE `name` (`name`)
;

-- Table Music_raport

CREATE TABLE `Music_raport`
(
  `id` Int NOT NULL AUTO_INCREMENT,
  `music_id` Int NOT NULL,
  `raport_id` Int NOT NULL,
  `count` Int NOT NULL,
  PRIMARY KEY (`id`)
)
;

-- Create foreign keys (relationships) section -------------------------------------------------

ALTER TABLE `Music_raport` ADD CONSTRAINT `Muzyka wchodzi w skład` FOREIGN KEY (`music_id`) REFERENCES `Music` (`music_id`) ON DELETE RESTRICT ON UPDATE RESTRICT
;

ALTER TABLE `Music_raport` ADD CONSTRAINT `Raport zawiera` FOREIGN KEY (`raport_id`) REFERENCES `Raport` (`raport_id`) ON DELETE RESTRICT ON UPDATE RESTRICT
;






INSERT INTO `Music` (`music_id`, `file_name`, `title`, `ISRC`, `composer`, `author`, `author_2`, `time`) VALUES
(1, 'Pierwszy rekord', 'Piosenka 001', 'ASADSADSADSADSAD', 'Bartosz Zawada', 'Bartosz Zawada', 'Brak', 250),
(2, 'Drugi rekord', 'Song 002', 'ISRC02ISRC02ISRC02ISRC02', 'Karolina Karolina', 'Mozart', 'Brak', 780),
(3, 'Trzeci rekord', 'Melodia 003', 'ISRC03ISRC03ISRC03ISRC03ISRC03', 'Piotr Piotrowski', 'Van Beethoven', 'Brak', 150),
(4, 'Czwarty rekord', 'Uwertura 004', 'ISRC04ISRC04ISRC04ISRC04ISRC04', 'Kamil Kowalski', 'Czajkowski', 'Brak', 300);

INSERT INTO `User` (`user_id`, `username`, `password`, `email`) VALUES
(1, 'Bartek', '$2y$10$2IqtH2uZLP1oL7OkZcBLz.NqoAlc89EcPrnCaDm/BIAYur2bFpsoq', 'bartek@gmail.com'),
(2, 'Karolina', '$2y$10$2pjuK8BqQPPiZ3VEYnQitOo/36D1g0NztXMRrB7wqpLhgfeJzhCz6', 'karolina123@gmail.com');
