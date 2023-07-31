function readBannerImage(image_path, ImageName) {
    // var path = reader.result;
    $("#image_cropper")
        .find("#js-load-cropping-image")
        .html(
            '<img src="' +
            image_path +
            '" id="cover-image" style="width:100%;">'
        );
    $('#ImageName').val(ImageName);

    $("#image_cropper")
        .find("#crop-image-button")
        .addClass("crop-image");
    setTimeout(function() {
        CropBannerImage();
    }, 500);

    $("#image_cropper").modal("show");
    // if (input.files && input.files[0]) {
    //     var file_name = input.files[0].name;
    //     var reader = new FileReader();
    //     reader.onload = function() {
    //         // $("#js-new-crop-modal").find(".js-new-crop-wrapper").show();
    //     }
    //     // reader.readAsDataURL(input.files[0]);
    // }
}

function uploadImage(input) {
    var formData = new FormData();
    formData.append("image", input.files[0]);
    formData.append("_token", config.token);
    // reader.readAsDataURL(input.files[0]);
    $('.ajax__loader').removeClass('d-none');
    $.ajax({
        url: config.routes.ajaxImageUpload,
        method: "POST",
        data: formData,
        dataType: "JSON",
        contentType: false,
        cache: false,
        processData: false,
        success: response => {

            if (response.status == true) {
                console.log(response);
                readBannerImage(response.path, response.image_main_name);
                $('.ajax__loader').addClass('d-none');
            } else if (response.response == false) {
                $('.ajax__loader').addClass('d-none');
            }
        }
    });
}
// $(document).on('change', '.cropImage', function(input) {
// })

function CropBannerImage() {
    var image = document.getElementById("cover-image");
    var cropBoxData;
    var canvasData;
    var cropInit;

    var minCroppedWidth = 320;
    var minCroppedHeight = 160;
    var maxCroppedWidth = 640;
    var maxCroppedHeight = 320;

    if (config.fix_size == false) {
        cropInit = new Cropper(image, {
            autoCropArea: 1,

            built: function(data) {
                // Strict mode: set crop box data first
                cropInit.setCropBoxData(cropBoxData).setCanvasData(canvasData);
                // cropInit.setData({
                //     width: minCroppedWidth,
                //     height: maxCroppedHeight,
                // });
            },

            crop: function(event) {
                var width = event.detail.width;
                var height = event.detail.height;
                data.textContent = JSON.stringify(cropper.getData(true));
            },

        });

    } else {

        cropInit = new Cropper(image, {
            autoCropArea: 1,
            aspectRatio: config.image_width / config.image_height,
            built: function(data) {
                // Strict mode: set crop box data first
                cropInit.setCropBoxData(cropBoxData).setCanvasData(canvasData);

            },
            // crop:function(data){
            //     console.log(data);
            // }

        });
    }

    cropper = cropInit;
}

$(document).on("click", "#crop-image-button", function(e) {
    var croppedCanvas;
    croppedCanvas = cropper.getCroppedCanvas();
    var imagedata = cropper.getData(true);

    console.log(imagedata);
    var Imagewidth = imagedata.width;
    var Imageheight = imagedata.height;
    var ImageX = imagedata.x;
    var ImageY = imagedata.y;


    var ImageName = $('#ImageName').val();
    $('.ajax__loader').removeClass('d-none');
    $.ajax({
        type: "POST",
        cache: false,
        url: config.routes.uploadCropImage,
        data: {
            Imagewidth: Imagewidth,
            Imageheight: Imageheight,
            ImageX: ImageX,
            ImageY: ImageY,
            ImageName: ImageName,
            path: "news",
            _token: config.token
        },
        dataType: 'JSON',
        success: response => {
            console.log(response);

            $('.ajax__loader').addClass('d-none');
            if (response.status == true) {
                var path = IMAGE_PATH + "/temp/banner__" + response.image;
                $("#thumbnail").attr("src", path);
                // $("#js-uploaded-cover").html(
                //     "<img src='" +
                //     path +
                //     "' class='uploaded-background' style='max-height: 315px;'>"
                // );
                $('#image_name').val(response.image);
                $("#image_cropper").modal("hide");

            } else {
                alert('sorry there is something wrong')
            }
            cropper.destroy();
        }
    });
});




function showThumbnail(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
    }
    reader.onload = function(e) {
        $("#thumbnail").attr("src", e.target.result);
    };
    reader.readAsDataURL(input.files[0]);
}

function showOtherImage(input) {
    if (input.files && input.files.length) {
        var filesAmount = input.files.length;
        var moreImage = '';
        for (i = 0; i < filesAmount; i++) {
            var reader = new FileReader();
            reader.onload = function(event) {
                // console.log($.parseHTML('<img>'));
                // console.log($.parseHTML('<img>')).attr('src', event.target.result);
                $('.other__image_list').append("<div class='col-sm-3'> <img src='" + event.target.result + "'></div>");
                // $($.parseHTML('<img>')).attr('src', event.target.result).appendTo($('.other__image_list'));
            }
            reader.readAsDataURL(input.files[i]);
        }
    }
}