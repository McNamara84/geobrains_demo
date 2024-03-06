$(document).ready(function () {
  // Event-Handler für das Hinzufügen neuer Autorenzeilen
  $("#addAuthor").click(function () {
    var authorGroup = $("#authorGroup"); // Der Container, in dem die Autorenzeilen liegen
    var firstAuthorLine = authorGroup.children().first(); // Die erste Autorenzeile, die als Vorlage dient
    var newAuthorLine = firstAuthorLine.clone(); // Klonen der Vorlage

    // Zurücksetzen der Werte und Validierungsfeedbacks im geklonten Element
    newAuthorLine.find("input").val("").removeClass("is-invalid is-valid");
    newAuthorLine.find("select").val("").removeClass("is-invalid is-valid");
    newAuthorLine.find(".invalid-feedback, .valid-feedback").hide();

    // Ersetzen des "Hinzufügen"-Buttons durch einen "Entfernen"-Button im geklonten Element
    var removeBtnHtml = '<button type="button" class="btn btn-danger removeAuthor" style="width: 36px">-</button>';
    newAuthorLine.find(".addAuthor").replaceWith(removeBtnHtml);

    // Hinzufügen der neuen Autorenzeile zum DOM
    authorGroup.append(newAuthorLine);

    // Event-Handler für den "Entfernen"-Button der neuen Autorenzeile hinzufügen
    newAuthorLine.on("click", ".removeAuthor", function () {
      $(this).closest(".row").remove();
    });
  });

  // Optionen aus dem ersten Select-Element für die Titelzeile kopieren
  var optionTitleTypeHTML = $("#titleType").html();

  $("#addTitle").click(function () {
    // Vorbereitung der neuen Titelzeile durch Klonen und Zurücksetzen der Eingabefelder
    var newTitleRow = $(this).closest(".row").clone();

    $(newTitleRow).find("input").val("");
    $(newTitleRow).find("select").html(optionTitleTypeHTML).val("");

    // Hinzufügen eines Löschbuttons für jede neue Titelzeile
    var removeBtn = $("<button/>", {
      text: "-",
      type: "button",
      class: "btn btn-danger removeTitle",
      click: function () {
        $(this).closest(".row").remove();
      },
    }).css("width", "36px");

    // Ersetzen des Hinzufügen-Buttons durch den Löschbutton im geklonten Element
    $(newTitleRow).find(".addTitle").replaceWith(removeBtn);

    // Hinzufügen der neuen Titelzeile zum DOM
    $(this).closest(".row").parent().append(newTitleRow);
  });
});
