<?php
// 1. Funktion zum Anlegen der Datenbankstruktur erstellen

// 1.A. Erstellung der Serververbindung

include("dbconnect.php");

// 1.B. Tabellen erstellen

// 1.B.1. Haupttabellen erstellen:
// Nur für Test!!!
$sql = "SET FOREIGN_KEY_CHECKS = 0;";
mysqli_query($connation, $sql);
$sql = "DROP TABLE IF EXISTS Resource;";
mysqli_query($connation, $sql);
$sql = "DROP TABLE IF EXISTS Resource_has_Author;";
mysqli_query($connation, $sql);
$sql = "DROP TABLE IF EXISTS Author_has_Role;";
mysqli_query($connation, $sql);
$sql = "DROP TABLE IF EXISTS Author;";
mysqli_query($connation, $sql);
$sql = "DROP TABLE IF EXISTS Resource_Type;";
mysqli_query($connation, $sql);
$sql = "DROP TABLE IF EXISTS Rights;";
mysqli_query($connation, $sql);
$sql = "DROP TABLE IF EXISTS Language";
mysqli_query($connation, $sql);
$sql = "DROP TABLE IF EXISTS Role;";
mysqli_query($connation, $sql);
$sql = "DROP TABLE IF EXISTS Title_Type;";
mysqli_query($connation, $sql);
$sql = "DROP TABLE IF EXISTS Title;";
mysqli_query($connation, $sql);
$sql = "SET FOREIGN_KEY_CHECKS = 1;";
mysqli_query($connation, $sql);

// 1.B.1.A Resource Tabelle erstellen
$sqlTabelleResource = "CREATE TABLE IF NOT EXISTS `Resource` (
    `resource_id` INT NOT NULL AUTO_INCREMENT,
    `doi` VARCHAR(100) NULL,
    `version` INT NULL,
    `year` YEAR(4) NOT NULL,
    `Rights_rights_id` INT NOT NULL,
    `Resource_Type_resource_name_id` INT NOT NULL,
    `Language_language_id` INT NOT NULL,
    PRIMARY KEY (`resource_id`));";
mysqli_query($connation, $sqlTabelleResource);

// 1.B.1.B Resource Type Tabelle erstellen
$sqlTabelleResourceType = "CREATE TABLE IF NOT EXISTS `Resource_Type` (
  `resource_name_id` INT NOT NULL AUTO_INCREMENT,
  `resource_type_general` VARCHAR(20) NULL,
  `description` TEXT(1000) NULL,
  PRIMARY KEY (`resource_name_id`));";
mysqli_query($connation, $sqlTabelleResourceType);

// 1.B.1.C Rights Tabelle erstellen
$sqlTabelleRights = "CREATE TABLE IF NOT EXISTS `Rights` (
  `rights_id` INT NOT NULL AUTO_INCREMENT,
  `text` VARCHAR(100) NOT NULL,
  `rightsIdentifier` VARCHAR(10) NULL,
  `rightsURI` VARCHAR(256) NULL,
  PRIMARY KEY (`rights_id`));";
mysqli_query($connation, $sqlTabelleRights);

// 1.B.1.D Language Tabelle erstellen
$sqlTabelleLanguage = "CREATE TABLE IF NOT EXISTS `Language` (
  `language_id` INT NOT NULL AUTO_INCREMENT,
  `code` VARCHAR(10) NULL,
  `name` VARCHAR(20) NOT NULL,
  PRIMARY KEY (`language_id`));";
mysqli_query($connation, $sqlTabelleLanguage);

// 1.B.1.E Author Tabelle erstellen
$sqlTabelleAuthor = "CREATE TABLE IF NOT EXISTS `Author` (
  `author_id` INT NOT NULL AUTO_INCREMENT,
  `familyname` TEXT(666) NOT NULL,
  `givenname` TEXT(746) NOT NULL,
  `orcid` VARCHAR(19) NOT NULL,
  PRIMARY KEY (`author_id`));";
mysqli_query($connation, $sqlTabelleAuthor);

// 1.B.1.F Role Tabelle erstellen
$sqlTabelleRole = "CREATE TABLE IF NOT EXISTS `Role` (
  `role_id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(20) NOT NULL,
  `description` TEXT(1000) NULL,
  PRIMARY KEY (`role_id`));";
mysqli_query($connation, $sqlTabelleRole);

// 1.B.1.G Affiliation Tabelle erstellen
$sqlTabelleAffiliation = "CREATE TABLE IF NOT EXISTS `Affiliation` (
  `affiliation_id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(265) NOT NULL,
  `city` VARCHAR(80) NULL,
  `country` VARCHAR(75) NULL,
  PRIMARY KEY (`affiliation_id`));";
mysqli_query($connation, $sqlTabelleAffiliation);

// 1.B.1.H Title Type Tabelle erstellen
$sqlTabelleTitleType = "CREATE TABLE IF NOT EXISTS `Title_Type` (
  `title_type_id` INT NOT NULL AUTO_INCREMENT,
  `title` VARCHAR(25) NOT NULL,
  PRIMARY KEY (`title_type_id`));";
mysqli_query($connation, $sqlTabelleTitleType);

// 1.B.1.J Title Tabelle erstellen
$sqlTabelleTitle = "CREATE TABLE IF NOT EXISTS `Title` (
  `title_id` INT NOT NULL AUTO_INCREMENT,
  `text` VARCHAR(256) NOT NULL,
  `Title_Type_fk` INT NOT NULL,
  `Resource_resource_id` INT NOT NULL,
  PRIMARY KEY (`title_id`, `Title_Type_fk`, `Resource_resource_id`),
    FOREIGN KEY (`Title_Type_fk`)
    REFERENCES `Title_Type` (`title_type_id`),
    FOREIGN KEY (`Resource_resource_id`)
    REFERENCES `Resource` (`resource_id`));";
mysqli_query($connation, $sqlTabelleTitle);

// 1.B.2. Hilfstabellen erstellen:
// 1.B.2.A Resource_has_Author Tabelle erstellen
$sqlTabelleResource_has_Author = "CREATE TABLE IF NOT EXISTS `Resource_has_Author` (
  `Resource_has_Author_id` INT NOT NULL AUTO_INCREMENT,
  `Resource_resource_id` INT NOT NULL,
  `Author_author_id` INT NOT NULL,
  PRIMARY KEY (`Resource_has_Author_id`),
    FOREIGN KEY (`Resource_resource_id`)
    REFERENCES `Resource` (`resource_id`),
    FOREIGN KEY (`Author_author_id`)
    REFERENCES `Author` (`author_id`));";
mysqli_query($connation, $sqlTabelleResource_has_Author);

// 1.B.2.B Author_has_Role Tabelle erstellen
$sqlTabelleAuthor_has_Role = "CREATE TABLE IF NOT EXISTS `Author_has_Role` (
  `Author_has_Role_id` INT NOT NULL AUTO_INCREMENT,
  `Author_author_id` INT NOT NULL,
  `Role_role_id` INT NOT NULL,
  PRIMARY KEY (`Author_has_Role_id`),
    FOREIGN KEY (`Author_author_id`)
    REFERENCES `Author` (`author_id`),
    FOREIGN KEY (`Role_role_id`)
    REFERENCES `Role` (`role_id`));";
mysqli_query($connation, $sqlTabelleAuthor_has_Role);

// 1.B.2.c Author_has_Affiliation Tabelle erstellen
$sqlTabelleAuthor_has_Affiliation = "CREATE TABLE IF NOT EXISTS `Author_has_Affiliation` (
  `Author_has_Affiliation_id` INT NOT NULL AUTO_INCREMENT,
  `Author_author_id` INT NOT NULL,
  `Affiliation_affiliation_id` INT NOT NULL,
  PRIMARY KEY (`Author_has_Affiliation_id`),
    FOREIGN KEY (`Author_author_id`)
    REFERENCES `Author` (`author_id`),
    FOREIGN KEY (`Affiliation_affiliation_id`)
    REFERENCES `Affiliation` (`affiliation_id`));";
mysqli_query($connation, $sqlTabelleAuthor_has_Affiliation);


// 1.C. Trennen der Verbindung
echo "Die Tabellen wurden erfolgreich erstellt.";

// 2. Funktion zum Import von mindestens 3 Testdatensätzen erstellen.

// 2.A. Datensäze für Haupttabellen erstellen:
// 2.A.1. Datensäze für Rights Tabelle erstellen
$sqlDatenRights = "INSERT INTO Rights (`text`, `rightsIdentifier`, `rightsURI`) VALUES ('Creative Commons Attribution 4.0 International', 'CC-BY-4.0', 'https://creativecommons.org/licenses/by/4.0/legalcode'), ('Creative Commons Zero v1.0 Universal', 'CC0-1.0', 'https://creativecommons.org/publicdomain/zero/1.0/legalcode'), ('GNU General Public License v3.0 or later', 'GPL-3.0-or-later', 'https://www.gnu.org/licenses/gpl-3.0-standalone.html'), ('MIT License', 'MIT', 'https://opensource.org/license/mit/'), ('Apache License 2.0', 'Apache-2.0', 'https://www.apache.org/licenses/LICENSE-2.0'), ('European Union Public License 1.2', 'EUPL-1.2', 'https://joinup.ec.europa.eu/sites/default/files/custom-page/attachment/2020-03/EUPL-1.2%20EN.txt');";
mysqli_query($connation, $sqlDatenRights);
// 2.A.2. Datensäze für Resource Type erstellen
$sqlDatenResourceType = "INSERT INTO Resource_Type (`resource_type_general`, `description`) VALUES('Audiovisual', 'A series of visual representations imparting an impression of motion when shown in succession. May or may not include sound.'), ('Book', 'A medium for recording information in the form of writing or images, typically composed of many pages bound together and protected by a cover.'), ('BookChapter', 'One of the main divisions of a book.'), ('Collection', 'An aggregation of resources, which may encompass collections of one resourceType as well as those of mixed types. A collection is described as a group; its parts may also be separately described.'), ('ComputationalNotebook', 'A virtual notebook environment used for literate programming.'), ('ConferencePaper', 'Article that is written with the goal of being accepted to a conference.'), ('ConferenceProceeding', 'Collection of academic papers published in the context of an academic conference.'), ('DataPaper', 'A factual and objective publication with a focused intent to identify and describe specific data, sets of data, or data collections to facilitate discoverability.'), ('Dataset', 'Data encoded in a defined structure.'), ('Dissertation', 'A written essay, treatise, or thesis, especially one written by a candidate for the degree of Doctor of Philosophy.'), ('Event', 'A non-persistent, time-based occurrence.'), ('Image', 'A visual representation other than text.'), ('Instrument', 'A device, tool or apparatus used to obtain, measure and/or analyze data.'), ('InteractiveResource', 'A resource requiring interaction from the user to be understood, executed, or experienced.'), ('Journal', 'A scholarly publication consisting of articles that is published regularly throughout the year.'), ('JournalArticle', 'A written composition on a topic of interest, which forms a separate part of a journal.'), ('Model', 'An abstract, conceptual, graphical, mathematical or visualization model that represents empirical objects, phenomena, or physical processes.'), ('OutputManagementPlan', 'A formal document that outlines how research outputs are to be handled both during a research project and after the project is completed.'), ('PeerReview', 'Evaluation of scientific, academic, or professional work by others working in the same field.'), ('PhysicalObject', 'A physical object or substance.'), ('Preprint', 'A version of a scholarly or scientific paper that precedes formal peer review and publication in a peer-reviewed scholarly or scientific journal.'), ('Report', 'A document that presents information in an organized format for a specific audience and purpose.'), ('Service', 'An organized system of apparatus, appliances, staff, etc., for supplying some function(s) required by end users.'), ('Software', 'A computer program other than a computational notebook, in either source code (text) or compiled form. Use this type for general software components supporting scholarly research. Use the “ComputationalNotebook” value for virtual notebooks.'), ('Sound', 'A resource primarily intended to be heard.'), ('Standard', 'Something established by authority, custom, or general consent as a model, example, or point of reference.'), ('StudyRegistration', 'A detailed, time-stamped description of a research plan, often openly shared in a registry or published in a journal before the study is conducted to lend accountability and transparency in the hypothesis generating and testing process.'), ('Text', 'A resource consisting primarily of words for reading that is not covered by any other textual resource type in this list.'), ('Workflow', 'A structured series of steps which can be executed to produce a final outcome, allowing users a means to specify and enact their work in a more reproducible manner.'), ('Other', 'If selected, supply a value for ResourceType.');";
mysqli_query($connation, $sqlDatenResourceType);
// 2.A.3. Datensäze für Language Tabelle erstellen
$sqlDatenLanguage = "INSERT INTO Language (`code`, `name`) VALUES ('en',  'english'), ('de',  'german'), ('fr', 'french');";
mysqli_query($connation, $sqlDatenLanguage);
// 2.A.4. Datensäze für Resource Tabelle erstellen
$sqlDatenResource = "INSERT INTO Resource (`doi`, `version`, `year`, `Rights_rights_id`, `Resource_Type_resource_name_id`, `Language_language_id`) VALUES ('http://doi.org/10.1029/2023JB028411', 1, 2024, 1, 3, 1), ('https://doi.org/10.5880/GFZ.2.4.2024.001', 1, 2024, 1, 3, 1), ('http://doi.org/10.1038/s43247-024-01226-9', 1, 2024, 1, 3, 1);";
mysqli_query($connation, $sqlDatenResource);
// 2.A.5. Datensäze für Author Tabelle erstellen
$sqlDatenAuthor = "INSERT INTO Author (`familyName`, `givenname`, `orcid`) VALUES ('Grzegorz',  'Kwiatek', '0000-0003-1076-615X'), ('Goebel',  'Thomas', '0000-0003-1552-0861'), ('Wille',  'Christian', '0000-0003-0930-6527');";
mysqli_query($connation, $sqlDatenAuthor);
// 2.A.6. Datensäze für Role Tabelle erstellen
$sqlDatenRole = "INSERT INTO Role (`name`, `description`) VALUES ('Contact Person',  'Contact Person: Person with knowledge of how to access, troubleshoot, or otherwise field issues related to the resource; May also be \"Point of Contact\" in organization that controls access to the resource, if that organization is different from Publisher, Distributor, Data Manager.'), ('Data Collector',  'Data Collector: Person/institution responsible for finding, gathering/collecting data under the guidelines of the author(s) or Principal Investigator (PI); May also use when crediting survey conductors, interviewers, event or condition observers, person responsible for monitoring key instrument data.'), ('Data Curator', 'Data Curator: Person tasked with reviewing, enhancing, cleaning, or standardizing metadata and the associated data submitted for storage, use, and maintenance within a data center or repository; While the \"DataManager\" is concerned with digital maintenance, the DataCurator\'s role encompasses quality assurance focused on content and metadata. This includes checking whether the submitted dataset is complete, with all files and components as described by submitter, whether the metadata is standardized to appropriate systems and schema, whether specialized metadata is needed to add value and ensure access across disciplines, and determining how the metadata might map to search engines, database products, and automated feeds.'), ('Data Manager',  'Data Manager: Person (or organization with a staff of data managers, such as a data centre) responsible for maintaining the finished resource. The work done by this person or organization ensures that the resource is periodically \"refreshed\" in terms of software/hardware support, is kept available or is protected from unauthorized access, is stored in accordance with industry standards, and is handled in accordance with the records management requirements applicable to it.'), ('Distributor',  'Distributor: Institution tasked with responsibility to generate/disseminate copies of the resource in either electronic or print form. Works stored in more than one archive/repository may credit each as a distributor.'), ('Editor',  'Editor. A person who oversees the details related to the publication format of the resource. Note: if the Editor is to be credited in place of multiple authors, the Editor\'s name may be supplied as Author, with \"(Ed.)\" appended to the name.'), ('Hosting Institution',  'Hosting Institution: Typically, the organization allowing the resource to be available on the internet through the provision of its hardware/software/operating support. May also be used for an organization that stores the data offline. Often a data centre (if that data centre is not the'), ('Producer',  'Producer: Typically a person or organization responsible for the artistry and form of a media product. In the data industry, this may be a company'), ('Project Leader',  'Project Leader. Person officially designated as head of project team or sub-project team instrumental in the work necessary to development of the resource. The Project Leader is not'), ('Project Manager',  'Project Manager: Person officially designated as manager of a project. Project may on consist of one or many project teams and sub-teams. The manager of a project normally has more administrative responsibility than actual work involvement.'), ('Project Member',  'Project Member: Person on the membership list of a designated project/project team. This vocabulary may or may not indicate the quality, quantity, or substance of the person\'s involvement'), ('Registration Agency',  'Registration Agency: Institution/organization officially appointed by a Registration Authority to handle specific tasks within a defined area of responsibility. DataCite is a Registration Agency for the International DOI Foundation (IDF). One of Data Cite\'s tasks is to assign DOI prefixes to the allocating agents who then assign the full, specific character string to data clients, provide metadata back to the Data Cite registry, etc.'), ('Registration Authority',  'Registration Authority: A standards-setting body from which Registration Agencies obtain official recognition and guidance. The IDF serves as the Registration Authority for the International Standards Organization (ISO) in the area/domain of Digital Object Identifiers.'), ('Related Person',  'Related Person: A person without a specifically defined role in the development of the resource, but who is someone the author wishes to recognize. This person could be an author\'s intellectual mentor, a person providing intellectual leadership in the discipline or subject domain, etc.'), ('Researcher',  'Researcher: A person involved in analyzing data or the results of an experiment or formal study. May indicate an intern or assistant to one of the authors who helped with research but who was not so'), ('Research Group',  'Research Group: Typically refers to a group of individuals with a lab, department, or on division; the group has a particular, defined focus of activity. May operate at a narrower level of scope; may or may not hold less administrative responsibility than a project team.'), ('Rights Holder',  'Rights Holder: Person or institution owning or managing property rights, including intellectual property rights over the resource.'), ('Sponsor',  'Sponsor: Person or organization that issued a contract or under the auspices of which a work has been written, printed, published, developed, etc. Includes organizations that provide in-kind support, through donation, provision of people or a facility or instrumentation necessary for the development of the resource, etc.'), ('Supervisor',  'Supervisor: Designated administrator over one or more groups/teams working to produce a resource or over one or more steps of a development process.'), ('Workpackage Leader',  'Workpackage Leader: A Work Package is a recognized data product, not all of which is included in publication. The package, instead, may include notes, discarded documents, etc. The Work Package Leader is responsible for ensuring the comprehensive contents, versioning, and availability of the Work Package during the development of the resource.'), ('Other',  'Other: Any person or institution making a significant contribution to the development and/or maintenance of the resource, but whose contribution does not');";
mysqli_query($connation, $sqlDatenRole);
// 2.A.7. Datensäze für Affiliation Tabelle erstellen
$sqlDatenAffiliation = "INSERT INTO Affiliation (`name`, `city`, `country`) VALUES ('GFZ German Research Centre for Geosciences', 'Potsdam', 'Germany'), ('Department of Earth Sciences, Memphis Center for Earthquake Research and Information, University of Memphis', 'Memphis', 'United States'), ('University of Applied Sciences Potsdam', 'Potsdam', 'Germany');";
mysqli_query($connation, $sqlDatenAffiliation);
// 2.A.7. Datensäze für Title Type Tabelle erstellen
$sqlDatenTitleType = "INSERT INTO Title_Type (`title`) VALUES ('Main Title'), ('Alternative Title'), ('Subtitle'), ('Translated Title'), ('Other');";
mysqli_query($connation, $sqlDatenTitleType);
// 2.A.8. Datensäze für Title Tabelle erstellen
$sqlDatenTitle = "INSERT INTO Title (`text`, `Title_Type_fk`, `Resource_resource_id`) VALUES ('Acoustic Emission and Seismic moment tensor catalogs associated with triaxial stick-slip experiments performed on Westerly Granite samples', 1, 1), ('A decade of short-period earthquake rupture histories from multi-array back-projection', 1, 2), ('Long-term CO2 and CH4 flux measurements and associated environmental variables from a rewetted peatland', 1, 3);";
mysqli_query($connation, $sqlDatenTitle);

// 2.B. Datensäze für Hilfstabellen erstellen:
// 2.B.1. Datensäze für Resource_has_Author Tabelle erstellen
$sqlDatenResource_has_Author = "INSERT INTO Resource_has_Author (`Resource_resource_id`, `Author_author_id`) VALUES (3, 1), (2, 3), (1, 2);";
mysqli_query($connation, $sqlDatenResource_has_Author);
// 2.B.2. Datensäze für Author_has_Role Tabelle erstellen
$sqlDatenAuthor_has_Role = "INSERT INTO Author_has_Role (`Author_author_id`, `Role_role_id`) VALUES (1, 3), (2, 1), (3, 2);";
mysqli_query($connation, $sqlDatenAuthor_has_Role);
// 2.B.3. Datensäze für Author_has_Affiliation Tabelle erstellen
$sqlDatenAuthor_has_Affiliation = "INSERT INTO Author_has_Affiliation (`Author_author_id`, `Affiliation_affiliation_id`) VALUES (1, 2), (2, 1), (3, 3);";
mysqli_query($connation, $sqlDatenAuthor_has_Affiliation);

mysqli_close($connation);



























?>