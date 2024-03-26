function setupAutocomplete(selector, hiddenSelector) {
  $(selector).autocomplete({
    source(request, response) {
      $.getJSON("https://api.ror.org/organizations", { query: request.term }, (data) => {
        response(
          data.items.map((item) => ({
            label: item.name,
            value: item.name,
            ror_id: item.id,
          }))
        );
      });
    },
    select(event, ui) {
      this.value = ui.item.label;
      $(hiddenSelector).val(ui.item.ror_id);
    },
  });
}

$(document).ready(function () {
  setupAutocomplete("#inputAuthorAffiliation", "#hiddenAuthorRorId");
  var allOptions = $("#inputRights option").clone();
  $("#inputResourceType").change(function () {
    var selectedResourceType = $("#inputResourceType option:selected").text();
    if (selectedResourceType === "Software") {
      $("#inputRights").empty();
      allOptions.each(function () {
        var optionText = $(this).text();
        if (optionText === "MIT License (MIT)" || optionText === "Apache License 2.0 (Apache-2.0)") {
          $("#inputRights").append($(this).clone());
        }
      });
    } else {
      $("#inputRights").empty().append(allOptions.clone());
    }
  });
});
