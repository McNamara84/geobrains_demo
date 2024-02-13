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








setupAutocomplete("#inputAuthorAffiliation", "#hiddenAuthorRorId");