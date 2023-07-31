$(function() {
    // Initialize form validation on the registration form.
    // It has the name attribute "registration"
    $("form[name='information_form']").validate({
        // Specify validation rules
        rules: {
            title: "required",
            description: "required",
            publish_status: "required",
        },
        // Specify validation error messages
        messages: {
            title: "Please enter title",
            description: "Short Title is required",
            publish_status: "Publish Status is required",
        },
        submitHandler: function(form) {
            form.submit();
        }
    });
});
