<?php

include_once ("dbconnect.php"); //Hier wird  die Verbindung zur DB hergestellt.
$sql = "SELECT resource_name_id, resource_type_general FROM resource_type;"; //Hier werden die Daten resource_name_id und resource_type_general von der Tabelle resource_type abgefragt.
$result = mysqli_query($connation, $sql); //Hier wird die SQL-abfrage an mySQL-DB gesendet.
$optionresourcentype = ""; // Leere Variable.
if ($result->num_rows > 0) { //  Wenn es in der Datenbank mindestens eine Zeile gibt, wird diese ausgeführt. 
    while ($row = mysqli_fetch_assoc($result)) { // weiter ausfühen, solange es noch Zeilen gibt. 
        $optionresourcentype .= "<option value='" . $row['resource_name_id'] . "'>" . $row['resource_type_general'] . "</option>"; // Hier werden Options fü die Dropdown Menu erstellt.
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

$sql = "SELECT rights_id, text, rightsIdentifier FROM Rights;"; //Hier wird rights_id von der Tabelle Rights abgefragt.
$result = mysqli_query($connation, $sql);
$optionrights = "";
if ($result->num_rows > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $optionrights .= "<option value='" . $row['rights_id'] . "'>" . $row['text'] . " (" . $row['rightsIdentifier'] . ")" . "</option>";

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

$sql = "SELECT title_type_id, name FROM Title_Type;"; //Hier wird title_type_id von der Tabelle Title abgefragt.
$result = mysqli_query($connation, $sql);
$optiontitle_type = "";
if ($result->num_rows > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $optiontitle_type .= "<option value='" . $row['title_type_id'] . "'>" . $row['name'] . "</option>";

    }
}

// Spracheinstellung des Browsers abfragen und passende Sprachdatei einbinden, falls vorhanden
if (isset($_GET['lang'])) {
    $userLanguage = $_GET['lang'];
    $languageFile = "lang/" . $userLanguage . '.php';
} else {
    $userLanguage = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2);
    $languageFile = "lang/" . $userLanguage . '.php';
    if (!file_exists($languageFile)) {
        $languageFile = 'lang/en.php'; // Standardsprache (Englisch)
    }
}

include $languageFile;

include ("index.html"); // HTML-Formular anzeigen

if ($_SERVER['REQUEST_METHOD'] === 'POST') {  // hier  wird überprüft ob ein Formular abgesendet wurde.
    include_once ("dbconnect.php"); //Hier wird  die Verbindung zur DB hergestellt.
    //  Hier werden die Post-Werte in Variablen gespeichert. 
    $doi = $_POST["doi"];
    $year = (int) $_POST["year"];
    $resourcetype = (int) $_POST["resourcetype"];
    $version = (int) $_POST["version"];
    $language = (int) $_POST["language"];
    $rights = (int) $_POST["Rights"];
    $sql = "INSERT INTO resource (`doi`, `year`, `version`, `Resource_Type_resource_name_id`, `Rights_rights_id`, `Language_language_id`) VALUES ('$doi', $year, $version, $resourcetype, $rights, $language);";
    mysqli_query($connation, $sql); //  Hier wird die SQL-Anfrage ausgeführt.
    $resource_id = mysqli_insert_id($connation); //

    // Speichern aller Titles und Title Type
    if (isset($_POST['title'], $_POST['titleType']) && is_array($_POST['title']) && is_array($_POST['titleType'])) {
        $titles = $_POST['title'];
        $titleTypes = $_POST['titleType'];

        // Durchlaufen der Titel und zugehörigen Title Types
        $len = count($titles);
        for ($i = 0; $i < $len; $i++) {
            $title = $titles[$i];
            $titleType = (int) $titleTypes[$i];

            //  $title und $titleType Datenbank speichern
            //  Variable erstellen $sql und darin SQL-Code schreiben, der die Daten in die Datenbank speichert
            $sql = "INSERT INTO title (`text`, `Title_Type_fk`, `Resource_resource_id`) VALUES ('$title', $titleType, $resource_id);";
            mysqli_query($connation, $sql);

        }
    }

    if (isset($_POST['familynames'], $_POST['givennames'], $_POST['orcids']) && is_array($_POST['familynames']) && is_array($_POST['givennames']) && is_array($_POST['orcids'])) {
        $familynames = $_POST['familynames'];
        $givennames = $_POST['givennames'];
        $orcids = $_POST['orcids'];
        $affiliations = $_POST['affiliation'];
        $roles = $_POST['roles'];

        $len = count($familynames);
        for ($i = 0; $i < $len; $i++) {
            $familyname = $familynames[$i];
            $givenname = $givennames[$i];
            $orcid = $orcids[$i];
            $affiliation = $affiliations[$i];
            $sql = " INSERT INTO author (`familyname`, `givenname`,`orcid`)  VALUES ('$familyname', '$givenname', '$orcid');";
            mysqli_query($connation, $sql);
            $author_id = mysqli_insert_id($connation);
            $sql = "INSERT INTO Resource_has_Author (`Resource_resource_id`, `Author_author_id`) VALUES ('$resource_id', '$author_id');";
            mysqli_query($connation, $sql);
            if ($affiliation != "") {
                $sql = "INSERT INTO Affiliation (`name`) VALUES ('$affiliation');";
                mysqli_query($connation, $sql);
                $affiliation_id = mysqli_insert_id($connation);
                $sql = "INSERT INTO Author_has_Affiliation (`Author_author_id`, `Affiliation_affiliation_id`) VALUES ($author_id, $affiliation_id);";
                mysqli_query($connation, $sql);
            }
            // if ($role != "") 
            $len = count($roles);
            for ($i = 0; $i < $len; $i++) {
                $role = $roles[$i];
                $sql = "INSERT INTO Author_has_Role (`Author_author_id`, `Role_role_id`) VALUES ($author_id, $role);";
                mysqli_query($connation, $sql);
            }

        }
    }


    //$titleType = (int)$_POST["titleType"];


    // Hier werden die Spalten mit den eingegebenen  Werten gefüllt. TODO: SQL-Injection verhindern
    // $sql = "INSERT INTO resource (`doi`, `year`, `version`, `title`, `Resource_Type_resource_name_id`, `Rights_rights_id`, `Language_language_id`) VALUES ('$doi', '$year', '$version', '$title', '$resourcetype', '$rights', '$language');";

    //mysqli_query($connation, $sql); //  Hier wird die SQL-Anfrage ausgeführt.

    //$familynames = $_POST["familyname"];
    //$givenname = $_POST["givenname"];
    //$orcid = $_POST["orcid"];
    //$affiliation = $_POST["affiliation"];
    //$sql = "INSERT INTO author (`familyname`, `givenname`, `orcid`, `affiliation`) VALUES  ('$familyname', '$givenname', '$orcid', '$affiliation');";

    //mysqli_query($connation, $sql);
    // Hier  wird der Autor-ID geholt und in eine Variable gespeichert.
    //$roles[] = (int)$_POST["roles[]"];   // TODO Array Empfangen
    //$sql = "INSERT INTO author_has_role (`Role_role_id`, `Author_author_id`) VALUES ('$role', '$author');";
    //mysqli_query($connation, $sql);

}

























































?>