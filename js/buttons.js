$(document).ready(function () {
  // Klick-Event-Handler für den 'addAuthor' Button
  $("#addAuthor").click(function () {
    // Klonen der 'authorGroup' und Entfernen der ID, weil ID einzigartig sein sollte
    var newAuthorGroup = $("#authorGroup").children().first().clone().removeAttr("id");

    // Zurücksetzen der Werte im geklonten Element
    $(newAuthorGroup).find("input").val("");
    $(newAuthorGroup).find("select").val("");

    // Hinzufügen eines Löschbuttons für jede neue Autorengruppe
    var removeBtn = $("<button/>", {
      text: "-",
      type: "button",
      class: "btn btn-danger removeAuthor",
      click: function () {
        $(this).closest(".row").remove();
      },
    }).css("width", "36px");

    $(newAuthorGroup).find(".addAuthor").replaceWith(removeBtn);

    // Hinzufügen der neuen Autorengruppe zum DOM
    $("#authorGroup").append(newAuthorGroup);
  });
});
