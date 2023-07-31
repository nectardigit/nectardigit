$(function() {
    // Initialize form validation on the registration form.
    // It has the name attribute "registration"
    $("form[name='menu_form']").validate({
        // Specify validation rules
        rules: {
            title: "required",
            slug: "required",
            publish_status: "required",

        },
        // Specify validation error messages
        messages: {
            title: "Please enter title",
            slug: "Slug is required",
            publish_status: "Status is required",

        },
        submitHandler: function(form) {
            form.submit();
        }
    });
});


$(document).ready(function() {
    $('#show_on').select2();
});


