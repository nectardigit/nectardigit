$(function() {
    // Initialize form validation on the registration form.
    // It has the name attribute "registration"
    $("#riderform").validate({
        // Specify validation rules
        rules: {
            name: "required",
            vehicletype: "required",
            password: {
                required: true,
                equalTo: "#confirmpassword",
            },
            mobile: {
                required: true,
                digits: true,
                minlength: 10,
                maxlength: 10,
            },
            vehicleno: {
                required: true,
                maxlength: 3,
                maxlength: 15,
            },
            licenseno: {
                required: true,
                maxlength: 30,
            },

        },
        // Specify validation error messages
        messages: {
            name: "Please Enter Rider's Name",
            vehicletype: "Please Select Vehicle Type",
            password: {
                required: "Please Enter Password",
                equalTo: "Both passwords are not equal",
            },
            mobile: {
                required: "Phone Number is required",
                digits: "Phone number should be digits only",
                minlength: "Phone number should be of 10 digits",
                maxlength: "Phone number should be of 10 digits only",
            },
            vehicleno: {
                required: "Vehicle Number is Required",
                minlength: "Vehicle number should be of 3 digits",
                maxlength: "Vehicle number should be of 15 digits only",
            },
            licenseno: {
                required: "License Number is Required",
                maxlength: "License number should be of 30 digits only",
            },
        },
        // submitHandler: function(form) {
        //     console.log(form);
        //     return false;
        //     form.submit();
        // }
    });
});
