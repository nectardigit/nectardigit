$(function() {
    // Initialize form validation on the registration form.
    // It has the name attribute "registration"
    $("form[name='testimonial_form']").validate({
        // Specify validation rules
        rules: {
            title: "required",
            designation: "required",
            description: "required",
            publish_status: "required",
        },
        // Specify validation error messages
        messages: {
            title: "Please enter title",
            designation: "Please enter designation",
            description: "Please enter description",
            publish_status: "Please enter publish status",
        },
        submitHandler: function(form) {
            form.submit();
        }
    });
});
