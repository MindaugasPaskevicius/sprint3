CREATE DATABASE  IF NOT EXISTS `project_manager`;
USE `project_manager`;


CREATE TABLE `employees` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) DEFAULT NULL,
  `project_id` int(20) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `project_id_id1` (`project_id`),
  CONSTRAINT `project_id` FOREIGN KEY (`project_id`) REFERENCES `projects` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8mb4;


INSERT INTO `employees` VALUES (1,'Vytautas',1),(2,'Algirdas',7),(3,'Gediminas',6),(4,'Kestutis',6),(5,'Algimantas',5),(6,'Alfredas',3),(7,'Rokas',1),(8,'Rimvydas',3),(9,'Mindaugas',5);

CREATE TABLE `projects` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) CHARACTER SET utf8mb4 NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=latin1;

INSERT INTO `projects` VALUES (1,'PHP'),(2,'Java'),(3,'Phyton'),(5,'React'),(6,'Laravel'),(7,'MySQL');
