@extends('layouts.admin')
@section('title', 'media library')
@push('styles')
    <style>
        iframe {
    height: 100vh;
}
    </style>
@endpush
{{-- @push('scripts')
        @include('admin.section.ckeditor')
        <script src="/vendor/laravel-filemanager/js/stand-alone-button.js"></script>
        <script>
            $('#lfm').filemanager('image');

        </script>
        <script>
            jQuery(function(){
               jQuery('#lfm').click();
               $('button').hide();
            });
            </script>

@endpush --}}
@section('content')
<iframe width="100%" src="{{asset('')}}filemanager?type=image&field_id=fieldID4'&fldr="  >
</iframe>
{{-- <iframe src="http://127.0.0.1:8000/filemanager?type=image" frameborder="0" width="100%" height="100vh"></iframe> --}}
{{-- <button class="md-trigger" id="lfm" data-modal="lfm" type="hidden">Choose</button> --}}
@endsection

    
