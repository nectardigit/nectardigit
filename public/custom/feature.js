$(function() {
    // Initialize form validation on the registration form.
    // It has the name attribute "registration"
    $("form[name='feature_form']").validate({
        // Specify validation rules
        rules: {
            title: "required",
            full_description: "required",
            publish_status: "required",

        },
        // Specify validation error messages
        messages: {
            title: "Please enter title",
            full_description: "Full Description is required",
            publish_status: "Publish Status is required",

        },
        submitHandler: function(form) {
            form.submit();
        }
    });
});
