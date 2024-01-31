<?php

include_once("dbconnect.php");
$sql = "SELECT resource_name FROM resource_type;";
$result = mysqli_query($connation, $sql);
$optionresourcentype = "";
if ($result->num_rows > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $optionresourcentype .= "<option value='" . $row['resource_name'] . "'>" . $row['resource_name'] . "</option>";
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

$sql = "SELECT text FROM licence;";
$result = mysqli_query($connation, $sql);
$optionlicence = "";
if ($result->num_rows > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $optionlicence .= "<option value='" . $row['text'] . "'>" . $row['text'] . "</option>";

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
    $version = $_POST["version"];
    $title = $_POST["title"];
    $sql = "INSERT INTO resource (`doi`, `year`, `version`, `title`) VALUES ('$doi', '$year', '$version', '$title');";

    $lastname = $_POST["lastname"];
    $firstname = $_POST["firstname"];
    $orcid = $_POST["orcid"];
    $sql = "INSERT INTO author (`lastname`, `firstname`, `orcid`) VALUES  ('$lastname', '$firstname', '$orcid');";

    mysqli_query($connation, $sql);

}

























































?>