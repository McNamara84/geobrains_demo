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

$sql = "SELECT name FROM language;";
$result = mysqli_query($connation, $sql);
$optionlanguage = "";
if ($result->num_rows > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $optionlanguage .= "<option value='" . $row['name'] . "'>" . $row['name'] . "</option>";

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

$sql = "SELECT name FROM role;";
$result = mysqli_query($connation, $sql);
$optionrole = "";
if ($result->num_rows > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $optionrole .= "<option value='" . $row["name"] . "'>" . $row["name"] . "</option>";

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
    //echo $resourcetype;
    $sql = "INSERT INTO resource (`doi`, `year`, `version`, `title`, `Resource_Type_resource_name_id`, `Licence_licence_id`) VALUES ('$doi', '$year', '$version', '$title', '$resourcetype', '$licence');";

    mysqli_query($connation, $sql);
    
    $lastname = $_POST["lastname"];
    $firstname = $_POST["firstname"];
    $orcid = $_POST["orcid"];
    $sql = "INSERT INTO author (`lastname`, `firstname`, `orcid`) VALUES  ('$lastname', '$firstname', '$orcid');";

    mysqli_query($connation, $sql);

}

























































?>