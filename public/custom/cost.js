$(function() {
    // Initialize form validation on the registration form.
    // It has the name attribute "registration"
    $("form[name='cost_form']").validate({
        // Specify validation rules
        rules: {
            vehicle_type_id: "required",
            city: "required",
            base_distance: {
                required: true,
                digits: true,
            },
            base_cost: {
                required: true,
                digits: true,
            },
            unit_cost: {
                required: true,
                digits: true,
            },
            extra_time_cost: {
                digits: true,
            },
            extra_time_unit: {
                digits: true,
            },
            // waiting_cost: {
            //     digits: true,
            // },
            night_cost: {
                digits: true,
            },
            status: "required",

        },
        // Specify validation error messages
        messages: {
            vehicle_type_id: "Please enter vehicle type",
            city: "Please enter city",
            base_distance: {
                required: "Base Distance is required",
                digits: "Digits only accepted",
            },
            base_cost: {
                required: "Base Cost is required",
                digits: "Digits only accepted",
            },
            unit_cost: {
                required: "Unit Cost is required",
                digits: "Digits only accepted",
            },
            extra_time_cost: {
                digits: "Digits only accepted",
            },
            extra_time_unit: {
                digits: "Digits only accepted",
            },
            // waiting_cost: {
            //     digits: "Digits only accepted",
            // },
            night_cost: {
                digits: "Digits only accepted",
            },
            status: "Status is required",

        },
        submitHandler: function(form) {
            form.submit();
        }
    });
});
