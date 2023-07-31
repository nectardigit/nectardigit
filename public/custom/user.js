$(function() {
    // Initialize form validation on the registration form.
    // It has the name attribute "registration"
    $("form[name='user_form']").validate({
        // Specify validation rules
        rules: {
            name: "required",
            mobile: {
                required: true,
                digits: true,
                minlength: 10,
                maxlength: 10,
            },
            email: {
                required: true,
                email: true,
            },
            roles: "required",
            status: "required",

        },
        // Specify validation error messages
        messages: {
            name: "Please enter name",
            mobile: {
                required: "Phone number is required",
                digits: "Phone number should be digits only",
                minlength: "Phone number should be of 10 digits",
                maxlength: "Phone number should be of 10 digits only",
            },
            email: {
                required: "Please enter email address",
                email: "Value entered should be email",
            },
            roles: "Please add role",
            status: "Please add status",

        },
        submitHandler: function(form) {
            form.submit();
        }
    });
});
