<?php

include_once("dbconnect.php"); //Hier wird  die Verbindung zur DB hergestellt.
$sql = "SELECT resource_name_id, resource_name FROM resource_type;"; //Hier werden die Daten resource_name_id und resource_name von der Tabelle resource_type abgefragt.
$result = mysqli_query($connation, $sql); //Hier wird die SQL-abfrage an mySQL-DB gesendet.
$optionresourcentype = ""; // Leere Variable.
if ($result->num_rows > 0) { //  Wenn es in der Datenbank mindestens eine Zeile gibt, wird diese ausgeführt. 
    while ($row = mysqli_fetch_assoc($result)) { // weiter ausfühen, solange es noch Zeilen gibt. 
        $optionresourcentype .= "<option value='" . $row['resource_name_id'] . "'>" . $row['resource_name'] . "</option>"; // Hier werden Options fü die Dropdown Menu erstellt.
    }
}

$sql = "SELECT language_id, name FROM language;"; //Hier wird language_id und von der Tabelle language abgefragt.
$result = mysqli_query($connation, $sql);
$optionlanguage = "";
if ($result->num_rows > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $optionlanguage .= "<option value='" . $row['language_id'] . "'>" . $row['name'] . "</option>";

    }
}

$sql = "SELECT licence_id, text FROM licence;"; //Hier wird licence_id von der Tabelle licence abgefragt.
$result = mysqli_query($connation, $sql);
$optionlicence = "";
if ($result->num_rows > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $optionlicence .= "<option value='" . $row['licence_id'] . "'>" . $row['text'] . "</option>";

    }
}

$sql = "SELECT role_id, name FROM role;"; //Hier wird role_id von der Tabelle role abgefragt.
$result = mysqli_query($connation, $sql);
$optionrole = "";
if ($result->num_rows > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $optionrole .= "<option value='" . $row["role_id"] . "'>" . $row["name"] . "</option>";

    }
}


include("index.html"); // Hier wird der HTML-index gezeigt.


if ($_SERVER['REQUEST_METHOD'] === 'POST') {  // hier  wird überprüft ob ein Formular abgesendet wurde.
    include_once("dbconnect.php"); //Hier wird  die Verbindung zur DB hergestellt.
    //  Hier werden die Post-Werte in Variablen gespeichert. 
    $doi = $_POST["doi"]; 
    $year = $_POST["year"];
    $resourcetype = (int)$_POST["resourcetype"];
    $version = $_POST["version"];
    $title = $_POST["title"];
    $licence = (int)$_POST["licence"];
    $language =  (int)$_POST["language"];

    // Hier werden die Spalten mit den eingegebenen  Werten gefüllt.
    $sql = "INSERT INTO resource (`doi`, `year`, `version`, `title`, `Resource_Type_resource_name_id`, `Licence_licence_id`, `Language_language_id`) VALUES ('$doi', '$year', '$version', '$title', '$resourcetype', '$licence', '$language');";

    mysqli_query($connation, $sql); //  Hier wird die SQL-Anfrage ausgeführt.
    
    $lastname = $_POST["lastname"];
    $firstname = $_POST["firstname"];
    $orcid = $_POST["orcid"];
    $affiliation = $_POST["affiliation"];
    $sql = "INSERT INTO author (`lastname`, `firstname`, `orcid`, `affiliation`) VALUES  ('$lastname', '$firstname', '$orcid', '$affiliation');";

    mysqli_query($connation, $sql);
    $author = mysqli_insert_id($connation); // Hier  wird der Autor-ID geholt und in eine Variable gespeichert.
    $role = (int)$_POST["role"];
    echo $author;
    $sql = "INSERT INTO author_has_role (`Role_role_id`, `Author_author_id`) VALUES ('$role', '$author');";
    mysqli_query($connation, $sql);
    
}

























































?>