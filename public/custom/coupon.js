$(function() {
    // Initialize form validation on the registration form.
    // It has the name attribute "registration"
    $("form[name='coupon_form']").validate({
        // Specify validation rules
        rules: {
            title: "required",
            vehicleType_id: "required",
            city_id: "required",
            start_date: "required",
            end_date: "required",
            start_time: "required",
            end_time: "required",
            code: {
                required: true,
            },
            price: {
                digits: true,
            },
            description: "required",
            publish_status: "required",

        },
        // Specify validation error messages
        messages: {
            title: "Please enter coupon name",
            vehicleType_id: "Vehicle type is required",
            city_id: "City type is required",
            start_date: "Start Date is required",
            end_date: "End Date is required",
            start_time: "Start Time is required",
            end_time: "End Time is required",
            code: {
                required: "Coupon Code is required",
            },
            price: {
                digits: "Price must be in digits",
            },
            description: "Description is required",
            publish_status: "Publish Status is required",
        },
        submitHandler: function(form) {
            form.submit();
        }
    });
});
