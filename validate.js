//Echtzeitvalidierung aller Felder.
//1. Validierung alle Felder in Resource Information
//1.A. Validierung das Feld "Doi"
$(document).ready(function () {
    function validateDoi(doi) {
        var isValidDoi = /^10\.[0-9]{0,4}\/GFZ\.[0-9]{1}.[0-9]{1}.[0-9]{4}.[0-9]{3}$/.test(doi) || doi === "";
        if (isValidDoi) {
            $('#inputDOI').css("background-color", "#ffffff");
        }
        else {
            $('#inputDOI').css("background-color", "#FDD8DD");
        }
    }
    $("#inputDOI").on("input", function () {
        var doi = $(this).val();
        validateDoi(doi);
    });
    //1.B. Validierung das Feld "Publication Year"
    function validateYear(year) {
        var isValidYear = /^[0-9]{4}$/.test(year) || year === "";
        if (isValidYear) {
            $('#inputPublicationYear').css("background-color", "#ffffff");
        }
        else {
            $('#inputPublicationYear').css("background-color", "#FDD8DD");
        }
    }
    $('#inputPublicationYear').on("input", function () {
        var year = $(this).val();
        validateYear(year);
    });
    //1.C. Validierung das Feld "Version"
    function validateVersion(version) {
        var isValidVersion = /^[0-9]{1,2}(\.[0-9])?$/.test(version) || version === "";
        if (isValidVersion) {
            $('#inputVersion').css("background-color", "#ffffff");
        }
        else {
            $('#inputVersion').css("background-color", "#FDD8DD");
        }
    }
    $('#inputVersion').on("input", function () {
        var version = $(this).val();
        validateVersion(version);
    });
    //1.D. Validierung das Feld "Title"
    function validateTitle(title) {
        var isValidTitle = /^.*\b\w+\b.*$/.test(title) || title === "";
        if (isValidTitle) {
            $('#inputTitle').css("background-color", "#ffffff");
        }
        else {
            $('#inputTitle').css("background-color", "#FDD8DD");
        }
    }
    $('#inputTitle').on("input", function () {
        var Title = $(this).val();
        validateTitle(Title);
    });
    //2. Validierung alle Felder in Authors
    //2.A. Validierung das Feld "Lastname"
    function validateLastname(lastname) {
        var isValidLastname = /^[a-zA-ZäöüÄÖÜß]+$/.test(lastname) || lastname === "";
        if (isValidLastname) {
            $('#inputLastname').css("background-color", "#ffffff");
        }
        else {
            $('#inputLastname').css("background-color", "#FDD8DD");
        }
    }
    $('#inputLastname').on("input", function () {
        var Lastname = $(this).val();
        validateLastname(Lastname);
    });
    //2.B. Validierung das Feld "Firstname"
    function validateFirstname(firstname) {
        var isValidFirstname = /^[a-zA-ZäöüÄÖÜß]+$/.test(firstname) || firstname === "";
        if (isValidFirstname) {
            $('#inputFirstname').css("background-color", "#ffffff");
        }
        else {
            $('#inputFirstname').css("background-color", "#FDD8DD");
        }
    }
    $('#inputFirstname').on("input", function () {
        var Firstname = $(this).val();
        validateFirstname(Firstname);
    });
    //2.C. Validierung das Feld "Author ORCID"
    function validateORCID(orcid) {
        var isValidORCID = /^[0-9]{4}-[0-9]{4}-[0-9]{4}-([0-9]{4}|[0-9]{3}X)$/.test(orcid) || orcid === "";
        if (isValidORCID) {
            $('#inputAuthorORCID').css("background-color", "#ffffff");
        }
        else {
            $('#inputAuthorORCID').css("background-color", "#FDD8DD");
        }
    }
    $('#inputAuthorORCID').on("input", function () {
        var ORCID = $(this).val();
        validateORCID(ORCID);
    });
    //2.D. Validierung das Feld "Affiliation"
    function validateAffiliation(affiliation) {
        var isValidAffiliation = /^.*\b\w+\b.*$/.test(affiliation) || affiliation === "";
        if (isValidAffiliation) {
            $('#inputAuthorAffiliation').css("background-color", "#ffffff");
        }
        else {
            $('#inputAuthorAffiliation').css("background-color", "#FDD8DD");
        }
    }
    $('#inputAuthorAffiliation').on("input", function () {
        var Affiliation = $(this).val();
        validateAffiliation(Affiliation);
    });
    //Endvalidierung  der Formulareingaben:
    function validateSubmit() {
        var isValidSubmit = true;
        var requiredFields = ["#inputDOI", "#inputPublicationYear", "#inputTitle", "#inputLastname", "#inputFirstname", "#inputAuthorORCID", "#inputAuthorAffiliation"];
        $.each(requiredFields, function (index, value) {
            if ($(value).val().trim() === "") {
                isValidSubmit = false;
            }

        });
        $("#inputSubmit").prop("disabled", !isValidSubmit);
    }
    $("input, select").on("input change", function () {
        validateSubmit();

    });
});