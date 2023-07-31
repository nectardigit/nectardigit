
<script src="{{ asset('/ckeditor/ckeditor.js') }}"></script>
<!-- <script src="{{ asset('/ckeditor/plugins/image2/image2/plugins.js') }}"></script> -->
{{-- <script src="{{ asset('/ckeditor/plugins/embedmedia/plugin.js') }}"></script> --}}
{{-- http://example.com/ckeditor/plugins/embed --}}
<script type="text/javascript" src="{{ asset('/assets/image_upload/js/laravel-file-manager-ck-editor-user.js') }}"></script>
<script>
    if($("#np_short_description").length){
        ckeditor('np_short_description', 400);
    }
    if($("#en_short_description").length){
        ckeditor('en_short_description', 400);
    }
    if($("#en_description").length){
        ckeditor('en_description', 400);
    }
    if($("#np_description").length){
        ckeditor('np_description', 400);
    }
    if($("#embed").length){
        ckeditor('embed', 400);
    }
    // CKEDITOR.replace('my-editor', {
    //     filebrowserUploadUrl: "{{route('ckeditor.upload', ['_token' => csrf_token() ])}}",
    //     filebrowserUploadMethod: 'form'
    // });

    // CKEDITOR.replace('my-editor1', {
    //     filebrowserUploadUrl: "{{route('ckeditor.upload', ['_token' => csrf_token() ])}}",
    //     filebrowserUploadMethod: 'form'
    // });

</script>
@if(request()->route()->getName() == 'news.edit' ||request()->route()->getName()== 'news.create')
<script>
    if($("#np_short_description").length){
        ckeditor('np_short_description', 500);
    }
    if($("#en_short_description").length){
        ckeditor('en_short_description', 500);
    }
    if($("#en_description").length){
        ckeditor('en_description', 500);
    }
    if($("#np_description").length){
        ckeditor('np_description', 500);
    }
    if($("#embed").length){
        ckeditor('embed', 500);
    }


</script>
 @endif
<style>
    /* .cke_browser_webkit {
        width: 80%;
    } */
</style>


<script>


// 	var options = {
//     filebrowserImageBrowseUrl: '/laravel-filemanager?type=Images',
//     filebrowserImageUploadUrl: '/laravel-filemanager/upload?type=Images&_token=',
//     filebrowserBrowseUrl: '/laravel-filemanager?type=Files',
//     filebrowserUploadUrl: '/laravel-filemanager/upload?type=Files&_token='
//   };
//     CKEDITOR.replace('description', options);
//     CKEDITOR.config.height = 200;
//     CKEDITOR.config.extraPlugins = 'html5audio';
//     CKEDITOR.config.colorButton_colors = 'CF5D4E,454545,FFF,CCC,DDD,CCEAEE,66AB16';
//     CKEDITOR.config.colorButton_enableMore = true;
//     CKEDITOR.config.floatpanel = true;
//     CKEDITOR.config.panel = true;
//     CKEDITOR.config.extraPlugins = 'image2';
//     CKEDITOR.config.removeButtons = 'Save,NewPage,Preview,Print,Templates,Cut,Copy,Paste,PasteText,PasteFromWord,Undo,Redo,Scayt,Form,Checkbox,Radio,TextField,Textarea,Select,Button,ImageButton,HiddenField,CopyFormatting,RemoveFormat,Outdent,Indent,CreateDiv,BidiLtr,BidiRtl,Language,PageBreak,Font,Styles,Format,ShowBlocks,About';


</script>

