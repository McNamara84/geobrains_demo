<?php

include_once("dbconnect.php");
$sql = "SELECT resource_name_id, resource_name FROM resource_type;";
$result = mysqli_query($connation, $sql);
$optionresourcentype = "";
if ($result->num_rows > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $optionresourcentype .= "<option value='" . $row['resource_name_id'] . "'>" . $row['resource_name'] . "</option>";
    }
}

$sql = "SELECT language_id, name FROM language;";
$result = mysqli_query($connation, $sql);
$optionlanguage = "";
if ($result->num_rows > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $optionlanguage .= "<option value='" . $row['language_id'] . "'>" . $row['name'] . "</option>";

    }
}

$sql = "SELECT licence_id, text FROM licence;";
$result = mysqli_query($connation, $sql);
$optionlicence = "";
if ($result->num_rows > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $optionlicence .= "<option value='" . $row['licence_id'] . "'>" . $row['text'] . "</option>";

    }
}

$sql = "SELECT role_id, name FROM role;";
$result = mysqli_query($connation, $sql);
$optionrole = "";
if ($result->num_rows > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $optionrole .= "<option value='" . $row["role_id"] . "'>" . $row["name"] . "</option>";

    }
}


include("index.html");


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    include_once("dbconnect.php");
    $doi = $_POST["doi"];
    $year = $_POST["year"];
    $resourcetype = (int)$_POST["resourcetype"];
    $version = $_POST["version"];
    $title = $_POST["title"];
    $licence = (int)$_POST["licence"];
    $language =  (int)$_POST["language"];
    //echo $resourcetype;
    $sql = "INSERT INTO resource (`doi`, `year`, `version`, `title`, `Resource_Type_resource_name_id`, `Licence_licence_id`, `Language_language_id`) VALUES ('$doi', '$year', '$version', '$title', '$resourcetype', '$licence', '$language');";

    mysqli_query($connation, $sql);
    
    $lastname = $_POST["lastname"];
    $firstname = $_POST["firstname"];
    $orcid = $_POST["orcid"];
    $affiliation = $_POST["affiliation"];
    $sql = "INSERT INTO author (`lastname`, `firstname`, `orcid`, `affiliation`) VALUES  ('$lastname', '$firstname', '$orcid', '$affiliation');";

    mysqli_query($connation, $sql);
    $author = mysqli_insert_id($connation);
    $role = (int)$_POST["role"];
    echo $author;
    $sql = "INSERT INTO author_has_role (`Role_role_id`, `Author_author_id`) VALUES ('$role', '$author');";
    mysqli_query($connation, $sql);
    
}

























































?>