$(function() {
    // Initialize form validation on the registration form.
    // It has the name attribute "registration"
    $("form[name='vehicletype_form']").validate({
        // Specify validation rules
        rules: {
            type: "required",
            status: "required",
            is_shareble: "required",
            commisson_status: "required",
        },
        // Specify validation error messages
        messages: {
            type: "Please enter name",
            status: "Please enter name",
            is_shareble: "Please enter name",
            commisson_status: "Please enter name",
        },
        submitHandler: function(form) {
            form.submit();
        }
    });
});
