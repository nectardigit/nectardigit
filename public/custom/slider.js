$(function() {
    // Initialize form validation on the registration form.
    // It has the name attribute "registration"
    $("form[name='slider_form']").validate({
        // Specify validation rules
        rules: {
            title: "required",
            description: "required",
            slider_type: "required",
            publish_status: "required",
        },
        // Specify validation error messages
        messages: {
            title: "Please enter title",
            description: "Please enter description",
            slider_type: "Please enter slider type",
            publish_status: "Please enter publish status",
        },
        submitHandler: function(form) {
            form.submit();
        }
    });
});
