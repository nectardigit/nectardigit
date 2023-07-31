@include('admin.section.ckeditor')
@push('styles')
    <link href="{{ asset('/assets/image_upload/css/cropper.css') }}" rel="stylesheet" />
@endpush
@push('scripts')
    <script>
        var IMAGE_PATH = "{{ asset('/uploads') }}";
        var config = {
            routes: {
                ajaxImageUpload: "{{ route('ajaxImageUpload') }}",
                uploadCropImage: "{{ route('uploadCropImage') }}"
            },
            token: "{{ @csrf_token() }}",
            image_width: 1200,
            image_height: 920,
            fix_size: false,
        }

    </script>
    <script src="{{ asset('/assets/image_upload/js/moment.js') }}" type="text/javascript"></script>
    <script src="{{ asset('/assets/image_upload/js/cropper.js') }}"></script>
    <script src="{{ asset('/assets/image_upload/js/upload-image.js') }}"></script>
    <script src="{{ asset('/assets/image_upload/js/image-processing.js') }}"></script>

    {{-- <script>
    Ckeditor('description', 200);
    Ckeditor('curriculum', 200);
    Ckeditor('specifications', 200);
    Ckeditor('career_scope', 200);
    Ckeditor('expert_view', 200);
</script> --}}
@endpush
<div class="modal fade" id="image_cropper" tabindex="-1" data-backdrop="static" role="dialog"
    aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
        <form action="#" id="image_crop_form" enctype="multipart/form-data" method="post">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Crop Image</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div id="js-load-cropping-image">

                    </div>
                </div>
                <input type="hidden" name="ImageName" id="ImageName">
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="crop-image-button" onclick="cropImage()">Crop & Save</button>
                </div>
            </div>
        </form>
    </div>
</div>
