<?php
// 1. Funktion zum Anlegen der Datenbankstruktur erstellen

// 1.A. Erstellung der Serververbindung

function connectDb() {
    $host = "localhost";
    $username = "ali";
    $password = "ali";
    $database = "geobrains";
    $conn = new mysqli($host, $username, $password, $database);
    return $conn;
}
$connation = connectDb();
// 1.B. Tabellen erstellen

// 1.B.1. Haupttabellen erstellen:
// 1.B.1.A Resource Tabelle erstellen
$sqlTabelleResource = "CREATE TABLE IF NOT EXISTS `Resource` (
    `resource_id` INT NOT NULL AUTO_INCREMENT,
    `doi` VARCHAR(100) NULL,
    `title` VARCHAR(256) NOT NULL,
    `version` INT NULL,
    `year` YEAR(4) NOT NULL,
    `Licence_licence_id` INT NOT NULL,
    `Resouce Type_resource_name_id` INT NOT NULL,
    `Language_language_id` INT NOT NULL,
    PRIMARY KEY (`resource_id`));";
  mysqli_query($connation,$sqlTabelleResource);

// 1.B.1.B Resource Type Tabelle erstellen
$sqlTabelleResourceType = "CREATE TABLE IF NOT EXISTS `Resouce Type` (
  `resource_name_id` INT NOT NULL AUTO_INCREMENT,
  `description` TEXT(1000) NOT NULL,
  `resource_name` VARCHAR(20) NULL,
  PRIMARY KEY (`resource_name_id`));";
  mysqli_query($connation,$sqlTabelleResourceType);

// 1.B.1.C Licence Tabelle erstellen
$sqlTabelleLicence = "CREATE TABLE IF NOT EXISTS `Licence` (
  `licence_id` INT NOT NULL AUTO_INCREMENT,
  `text` VARCHAR(45) NOT NULL,
  `code` VARCHAR(10) NULL,
  PRIMARY KEY (`licence_id`));";
  mysqli_query($connation,$sqlTabelleLicence);

// 1.B.1.D Language Tabelle erstellen
$sqlTabelleLanguage = "CREATE TABLE IF NOT EXISTS `Language` (
  `language_id` INT NOT NULL AUTO_INCREMENT,
  `code` VARCHAR(10) NULL,
  `name` VARCHAR(20) NOT NULL,
  PRIMARY KEY (`language_id`));";
  mysqli_query($connation,$sqlTabelleLanguage);

// 1.B.1.E Author Tabelle erstellen
$sqlTabelleAuthor = "CREATE TABLE IF NOT EXISTS `Author` (
  `author_id` INT NOT NULL AUTO_INCREMENT,
  `lastname` TEXT(666) NOT NULL,
  `firstname` TEXT(746) NOT NULL,
  `orcid` VARCHAR(19) NOT NULL,
  `affiliation` VARCHAR(9) NULL,
  PRIMARY KEY (`author_id`));";
  mysqli_query($connation,$sqlTabelleAuthor);

// 1.B.1.F Role Tabelle erstellen
$sqlTabelleRole = "CREATE TABLE IF NOT EXISTS `Role` (
  `role_id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(20) NOT NULL,
  `description` TEXT(1000) NULL,
  PRIMARY KEY (`role_id`));";
  mysqli_query($connation,$sqlTabelleRole);

// 1.B.2. Hilfstabellen erstellen:
// 1.B.2.A Resource_has_Author Tabelle erstellen
$sqlTabelleResource_has_Author = "CREATE TABLE IF NOT EXISTS `Resource_has_Author` (
  `Resource_has_Author_id` INT NOT NULL,
  `Resource_resource_id` INT NOT NULL,
  `Author_author_id` INT NOT NULL,
  PRIMARY KEY (`Resource_has_Author_id`),
  INDEX `fk_Resource_has_Author_Author1_idx` (`Author_author_id` ASC) VISIBLE,
  INDEX `fk_Resource_has_Author_Resource_idx` (`Resource_resource_id` ASC) VISIBLE,
  CONSTRAINT `fk_Resource_has_Author_Resource`
    FOREIGN KEY (`Resource_resource_id`)
    REFERENCES `mydb`.`Resource` (`resource_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Resource_has_Author_Author1`
    FOREIGN KEY (`Author_author_id`)
    REFERENCES `mydb`.`Author` (`author_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION);";
  mysqli_query($connation,$sqlTabelleResource_has_Author);

// 1.B.2.B Role_has_Author Tabelle erstellen

// 1.C. Trennen der Verbindung


// 2. Funktion zum Import von mindestens 3 Testdatensätzen erstellen





























?>