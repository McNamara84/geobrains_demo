//Echtzeit Validierung aller Felder.
//1.Validierung aller Eingabe felder
//1.A. Validierung alle Felder in Resource Information
//1.A.1 Validierung das Feld "Doi"
$(document).ready(function () {
    function validateDoi(doi) {
        var isValidDoi = /^10\.[0-9]{0,4}\/GFZ\.[0-9]{1}.[0-9]{1}.[0-9]{4}.[0-9]{3}$/.test(doi) ||  doi === "";
        if (isValidDoi) {
            $('#inputDOI').css("background-color", "#ffffff");
        }
        else {
            $('#inputDOI').css("background-color", "#c73439");
        }
    }
    $("#inputDOI").on("input", function () {
        var doi =  $(this).val();
        validateDoi(doi);
    });
});

//1.A.2 Validierung das Feld "Title"



//1.A.3 Validierung das Feld "Resource Type"
//1.A.4 Validierung das Feld "Publication Year"
//1.A.5 Validierung das Feld "Version"
//1.A.6 Validierung das Feld "Language of dataset"


//1.B. Validierung alle Felder in Licence and Rights
//1.B.1 Validierung das Feld "Licence Title"

//1.C. Validierung alle Felder in Authors
//1.C.1 Validierung das Feld "Lastname"
//1.C.2 Validierung das Feld "Firstname"
//1.C.3 Validierung das Feld "Role"
//1.C.4 Validierung das Feld "Author ORCID"
//1.C.5 Validierung das Feld "Affiliation"

