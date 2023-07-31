$(function() {
    // Initialize form validation on the registration form.
    // It has the name attribute "registration"
    $("form[name='rider_form']").validate({
        // Specify validation rules
        rules: {
            // The key name on the left side is the name attribute
            // of an input field. Validation rules are defined
            // on the right side

            name: "required",
            //   lastname: "required",
            email: {
                required: true,
                // Specify that email should be validated
                // by the built-in "email" rule
                email: true
            },
            password: {
                required: true,
                minlength: 8
            },
            pan_number: {
                required: true,
                minlength: 1
            },
            mobile: {
                required: true,
                minlength: 10,
                maxlength: 10
            },
            license_number: {
                required: true,
                minlength: 1
            },
            citizenship_no: {
                required: true,
            },
            model: {
                required: true,
            },
            year: {
                required: true,
            },
            registration_number: {
                required: true,
            },
            vehicle_type: {
                required: true,
            },
            owners_name: {
                required: true,
            },
            owners_contact_no: {
                required: true,
                minlength: 10,
                maxlength: 10
            },
            owners_address: {
                required: true,
            },
            date_of_birth_np: {
                required: true,

            }
        },
        // Specify validation error messages
        messages: {
            name: "Please enter rider's full name",
            lastname: "Please enter your lastname",
            password: {
                required: "Please provide a password",
                minlength: "Your password must be at least 5 characters long",
            },
            email: "Please enter a valid email address",
            pan_number: {
                required: "Please enter PAN number",
                minlength: "PAN number must be at lest 5 characters long."
            },
            mobile: {
                required: "Mobile number is required.",

            },
            license_number: {
                required: "License Number is required",
                minlength: "License number must be at least 5 characters long"
            },
            model: {
                required: "Vehicle Model is required."
            },
            year: {
                required: "Vehicle manufactured Year is required.",

            },
            citizenship_no: {
                required: "Rider's citizenship No. required."
            },
            owners_name: {
                required: "Vehicle onwer's full name is required"
            },
            owners_contact_no: {
                required: "Vehicle onwer's contact number is required"
            },
            owners_address: {
                required: "Vehicle onwer's address is required"
            },
            date_of_birth_np: {
                required: "Rider's date of birth is required"
            }

        },

        // Make sure the form is submitted to the destination defined
        // in the "action" attribute of the form when valid
        submitHandler: function(form) {
            form.submit();
        }
    });
});
$(document).ready(function() {
    // $('.motor,.bicycle').hide();
    $('#vehicle_type').select2({
        placeholder: "Vehicle Type",
    });
    $('#districtId').select2({
        placeholder: "District",
    });
    $('#gender').select2({
        placeholder: "Gender",
    });

    // $(document).off('change', '#vehicle_type').on('change', '#vehicle_type', function(e) {
    //     e.preventDefault()
    //     var type = $(this).val();
    //     if (type == 1 || type == 2) {
    //         $('.motor').show();
    //         $('.bicycle').hide();
    //     } else {
    //         $('.motor').hide();
    //         $('.bicycle').show();
    //     }
    // })
    // $('#vehicle_type').trigger('change');
});
$(document).on('click', '#change_password', function() {
    // alert($(this).prop('checked'));
    var checked = $(this).prop("checked");
    if (checked) {
        $(".password_change").removeClass('d-none');
    } else {
        $(".password_change").addClass('d-none');
    }
})


function uploadLicense(input) {
    if (input.files && input.files[0]) {
        let reader = new FileReader();
        reader.onload = function(e) {
            $('#license_image_view').attr('src', e.target.result).fadeIn(1000);
            $('#license_image_view').removeClass('d-none');
            $('#img_edit').addClass('d-none');
        }
        reader.readAsDataURL(input.files[0]);
    }
}
$('#license').change(function() {
    // alert('hello');
    var input = this;
    if (input.files && input.files[0]) {
        let reader = new FileReader();
        reader.onload = function(e) {
            $('#license_image_view').attr('src', e.target.result).fadeIn(1000);
            $('#license_image_view').removeClass('d-none');
            // $('#img_edit').addClass('d-none');
        }
        reader.readAsDataURL(input.files[0]);
    }
})

$('#citizenship_image').change(function() {
    // alert('hello');
    var input = this;
    if (input.files && input.files[0]) {
        let reader = new FileReader();
        reader.onload = function(e) {
            $('#citizenship_image_view').attr('src', e.target.result).fadeIn(1000);
            $('#citizenship_image_view').removeClass('d-none');
            // $('#img_edit').addClass('d-none');
        }
        reader.readAsDataURL(input.files[0]);
    }
})
$('#billbook').change(function() {
    // alert('hello');
    var input = this;
    if (input.files && input.files[0]) {
        let reader = new FileReader();
        reader.onload = function(e) {
            $('#billbook_image_view').attr('src', e.target.result).fadeIn(1000);
            $('#billbook_image_view').removeClass('d-none');
            // $('#img_edit').addClass('d-none');
        }
        reader.readAsDataURL(input.files[0]);
    }
})

$('#national_id_card').change(function() {
    // alert('hello');
    var input = this;
    if (input.files && input.files[0]) {
        let reader = new FileReader();
        reader.onload = function(e) {
            $('#national_id_card_image_view').attr('src', e.target.result).fadeIn(1000);
            $('#national_id_card_image_view').removeClass('d-none');
            // $('#img_edit').addClass('d-none');
        }
        reader.readAsDataURL(input.files[0]);
    }
})


// $("#logo").change(function () {
//     readURL(this);
// });
$(document).ready(function() {
    var mainInput = document.getElementById("nepali-datepicker");

    /* Initialize Datepicker with options */
    // mainInput.nepaliDatePicker();
    mainInput.nepaliDatePicker({
        dateFormat: "YYYY-MM-DD",
        dateString: "2067-12-25"
    });

})