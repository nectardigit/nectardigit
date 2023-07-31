$(function() {
    // Initialize form validation on the registration form.
    // It has the name attribute "registration"
    $("form[name='content_form']").validate({
        // Specify validation rules
        rules: {
            title: "required",
            publish_status: "required",
            content_type: "required",
            description: "required",

        },
        // Specify validation error messages
        messages: {
            title: "Please enter title",
            publish_status: "Publish Status is required",
            content_type: "Content Type is required",
            description: "Description is required",

        },
        submitHandler: function(form) {
            form.submit();
        }
    });
});
