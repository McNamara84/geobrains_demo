$(document).ready(function () {
    $('#inputRole').select2({
        //width: $( this ).data( 'width' ) ? $( this ).data( 'width' ) : $( this ).hasClass( 'w-100' ) ? '100%' : 'style',
        placeholder: 'Choose Role...',
        theme: 'bootstrap-5',
        //dropdownParent: $('.multiple-select').parent(),
    });
});