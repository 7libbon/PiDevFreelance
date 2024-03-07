$(document).ready(function() {
    // Initially hide the placeholder text
    $('.form-control').children('option:first').hide();

    // Show placeholder text when dropdown is not focused
    $('.form-control').focusout(function() {
        $(this).children('option:first').hide();
    });

    // Hide placeholder text when dropdown is focused
    $('.form-control').focusin(function() {
        $(this).children('option:first').show();
    });

    // Hide placeholder text when an option is selected
    $('.form-control').change(function() {
        $(this).children('option:first').hide();
    });
});