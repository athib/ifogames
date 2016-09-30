$(function() {
    checkboxControlDisplay();

    $('input[type="checkbox"][name="sameAsBilling"]').on('change', function() {
        checkboxControlDisplay();
    });
});


function checkboxControlDisplay() {
    var checkboxMailing = $('input[type="checkbox"][name="sameAsBilling"]');
    var thisFieldset = checkboxMailing.closest('fieldset');

    if (checkboxMailing.is(':checked')) {
        checkboxMailing.attr('value', '1');
        $('.hidden-if-checked').hide();
    } else {
        checkboxMailing.attr('value', '0');
        //emptyMailingData();
        $('.hidden-if-checked').show();
    }
}

function emptyMailingData()
{
    $('input[name="mailingStreet"]').val('');
    $('input[name="mailingCity"]').val('');
    $('input[name="mailingPostalCode"]').val('');
}