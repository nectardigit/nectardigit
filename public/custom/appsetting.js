$(document).ready(function(e) {



    $('#logo').change(function() {
        var input = this;
        if (input.files && input.files[0]) {
            let reader = new FileReader();
            reader.onload = function(e) {
                $('#logo').attr('src', e.target.result).fadeIn(1000);
                $('#logo').removeClass('d-none');
                // $('#img_edit').addClass('d-none');
            }
            reader.readAsDataURL(input.files[0]);
        }
    })
});
$("input[name=is_meta]").change(function(e) {
    var is_meta = $(this).val();
    UpdateMeta(is_meta);
});

function UpdateMeta(is_meta) {
    if (is_meta == "NO") {
        $("div#metatag-details").hide();
    }
    if (is_meta == "YES") {
        $("div#metatag-details").show();
    }
}

$("input[name=vat_status]").change(function(e) {
    var vat_status = $(this).val();
    UpdateVAT(vat_status);
});

function UpdateVAT(vat_status) {
    if (vat_status == "0") {
        $("#vatstatus-details").hide();
    }
    if (vat_status == "1") {
        $("#vatstatus-details").show();
    }
}
$("input[name=is_startup_ad]").change(function(e) {
    var is_startup_ad = $(this).val();
    UpdateStartAd(is_startup_ad);
});

function UpdateStartAd(is_startup_ad) {
    if (is_startup_ad == "NO") {
        $("div#startUpAdNumber").hide();
    }
    if (is_startup_ad == "YES") {
        $("div#startUpAdNumber").show();
    }
}

$("input[name=is_favicon]").change(function(e) {
    var is_favicon = $(this).val();
    UpdateFavOg(is_favicon);
});

function UpdateFavOg(is_favicon) {
    if (is_favicon == "NO") {
        $("div#fav_icon-details").hide();
    }
    if (is_favicon == "YES") {
        $("div#fav_icon-details").show();
    }
}

function readURL(input) {
    if (input.files && input.files[0]) {
        let reader = new FileReader();
        reader.onload = function(e) {
            $('#image_view').attr('src', e.target.result).fadeIn(1000);
            $('#image_view').removeClass('d-none');
            $('#img_edit').addClass('d-none');
        }
        reader.readAsDataURL(input.files[0]);
    }
}
$('#app_image').change(function() {
    // alert('hello');
    var input = this;
    if (input.files && input.files[0]) {
        let reader = new FileReader();
        reader.onload = function(e) {
            $('#app_image_view').attr('src', e.target.result).fadeIn(1000);
            $('#app_image_view').removeClass('d-none');
            // $('#img_edit').addClass('d-none');
        }
        reader.readAsDataURL(input.files[0]);
    }
})
$('#customer_app_image').change(function() {
    // alert('hello');
    var input = this;
    if (input.files && input.files[0]) {
        let reader = new FileReader();
        reader.onload = function(e) {
            $('#customer_app_image_view').attr('src', e.target.result).fadeIn(1000);
            $('#customer_app_image_view').removeClass('d-none');
            // $('#img_edit').addClass('d-none');
        }
        reader.readAsDataURL(input.files[0]);
    }
})

// $('#favicon').change(function() {
//     var input = this;
//     if (input.files && input.files[0]) {
//         let reader = new FileReader();
//         reader.onload = function(e) {
//             $('#favicon_view').attr('src', e.target.result).fadeIn(1000);
//             $('#favicon_view').removeClass('d-none');
//             // $('#img_edit').addClass('d-none');
//         }
//         reader.readAsDataURL(input.files[0]);
//     }
// })

// $('#og_image').change(function() {
//     // alert('hello');
//     var input = this;
//     if (input.files && input.files[0]) {
//         let reader = new FileReader();
//         reader.onload = function(e) {
//             $('#og_image_view').attr('src', e.target.result).fadeIn(1000);
//             $('#og_image_view').removeClass('d-none');
//             // $('#img_edit').addClass('d-none');
//         }
//         reader.readAsDataURL(input.files[0]);
//     }
// })

$("#logo").change(function() {
    readURL(this);
});
$(function() {
    // Initialize form validation on the registration form.
    // It has the name attribute "registration"
    $("form[name='appsetting_form']").validate({
        // Specify validation rules
        rules: {
            // name: "required",
            // address: "required",
            email: {
                // required: true,
                email: true,
            },
            phone: {
                // required: true,
                digits: true,
                minlength: 10,
                maxlength: 10,
            },
            vat: {
                number: true,
            },
            commission: {
                required: true,
                number: true,
            },
            // front_feature_description: "required",
            // front_counter_description: "required",
            // front_testimonial_description: "required",
            otp_expire: {
                required: true,
                number: true,
            },

        },
        // Specify validation error messages
        messages: {
            name: "Please enter company name",
            address: "Please enter address",
            email: {
                required: "Please enter email address",
                email: "Value entered should be email",
            },
            phone: {
                required: "Phone number is required",
                digits: "Phone number should be digits only",
                minlength: "Phone number should be of 10 digits",
                maxlength: "Phone number should be of 10 digits only",
            },
            commission: {
                required: "Commission is required",
                digits: "Commission should be in numbers only",
            },
            vat: {
                number: "The value should be numeric",
            },
            front_feature_description: "Please enter front feature description",
            front_counter_description: "Please enter front counter description",
            front_testimonial_description: "Please enter front testimonial description",
            otp_expire: {
                required: "OTP expire time is required",
                digits: "Please enter the value in minutes",
            },

        },
        submitHandler: function(form) {
            form.submit();
        }
    });
});