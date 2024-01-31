<?php

include("dbconnect.php");
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



























































?>