$(document).ready(function () {
  // Validierungsfunktionen, die die Klasse 'invalid' hinzufügen (wenn Einagbe korrekt) oder entfernt (wenn Eingabe falsch ist)
  function validateDoi(doi) {
    var isValidDoi = /^10\.[0-9]{0,4}\/GFZ\.[0-9]{1}.[0-9]{1}.[0-9]{4}.[0-9]{3}$/.test(doi) || doi === "";
    $("#inputDOI").toggleClass("invalid", !isValidDoi);
  }

  function validateYear(year) {
    var isValidYear = /^[0-9]{4}$/.test(year) || year === "";
    $("#inputPublicationYear").toggleClass("invalid", !isValidYear);
  }

  function validateVersion(version) {
    var isValidVersion = /^[0-9]{1,2}$/.test(version) || version === "";
    $("#inputVersion").toggleClass("invalid", !isValidVersion);
  }

  function validateTitle(title) {
    var isValidTitle = title.trim() !== "";
    $("#inputTitle").toggleClass("invalid", !isValidTitle);
  }

  function validateLastname(lastname) {
    var isValidLastname = /^[a-zA-ZäöüÄÖÜß]+$/.test(lastname) || lastname === "";
    $("#inputLastname").toggleClass("invalid", !isValidLastname);
  }

  function validateFirstname(firstname) {
    var isValidFirstname = /^[a-zA-ZäöüÄÖÜß]+$/.test(firstname) || firstname === "";
    $("#inputFirstname").toggleClass("invalid", !isValidFirstname);
  }

  function validateORCID(orcid) {
    var isValidORCID = /^[0-9]{4}-[0-9]{4}-[0-9]{4}-([0-9]{4}|[0-9]{3}X)$/.test(orcid) || orcid === "";
    $("#inputAuthorORCID").toggleClass("invalid", !isValidORCID);
  }

  function validateAffiliation(affiliation) {
    var isValidAffiliation = affiliation.trim() !== "";
    $("#inputAuthorAffiliation").toggleClass("invalid", !isValidAffiliation);
  }

  // Felder bei Eingabe validieren
  $("#inputDOI").on("input", function () {
    validateDoi(this.value);
  });
  $("#inputPublicationYear").on("input", function () {
    validateYear(this.value);
  });
  $("#inputVersion").on("input", function () {
    validateVersion(this.value);
  });
  $("#inputTitle").on("input", function () {
    validateTitle(this.value);
  });
  $("#inputLastname").on("input", function () {
    validateLastname(this.value);
  });
  $("#inputFirstname").on("input", function () {
    validateFirstname(this.value);
  });
  $("#inputAuthorORCID").on("input", function () {
    validateORCID(this.value);
  });
  $("#inputAuthorAffiliation").on("input", function () {
    validateAffiliation(this.value);
  });

  // Überprüfen, ob der Submit-Button aktiviert oder deaktiviert werden soll
  function checkFormValidity() {
    var allFieldsFilled = true;
    var requiredFields = [
      "#inputDOI",
      "#inputPublicationYear",
      "#inputVersion",
      "#inputTitle",
      "#inputLastname",
      "#inputFirstname",
      "#inputAuthorORCID",
      "#inputAuthorAffiliation",
    ];

    // Überprüfen, ob alle Pflichtfelder ausgefüllt sind
    requiredFields.forEach(function (selector) {
      if ($(selector).val().trim() === "") {
        allFieldsFilled = false;
      }
    });

    // Prüfen, ob das Formular valide ist (keine invaliden Felder und alle Pflichtfelder ausgefüllt)
    var isFormValid = allFieldsFilled && $(".invalid").length === 0;

    $("#submitButton").prop("disabled", !isFormValid);
  }

  // Überprüfung auslösen, wenn sich Eingabefelder ändern
  $("input").on("input", checkFormValidity);

  // Initialer Aufruf, um den Anfangszustand des Submit-Buttons zu setzen
  checkFormValidity();
});
