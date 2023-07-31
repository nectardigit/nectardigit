var options = {
    filebrowserImageBrowseUrl: '/filemanager?type=Images',
    filebrowserImageUploadUrl: '/filemanager/upload?type=Images&_token=',
    filebrowserBrowseUrl: '/filemanager?type=Files',
    filebrowserUploadUrl: '/filemanager/upload?type=Files&_token='
};
// CKEDITOR.config.height = 250;
function ckeditor(id, height) {
    CKEDITOR.replace(id, options);
    CKEDITOR.config.height = height;
};
// CKEDITOR.replace('description', options);


CKEDITOR.config.colorButton_colors = 'CF5D4E,454545,FFF,CCC,DDD,CCEAEE,66AB16';
CKEDITOR.config.colorButton_enableMore = true;
CKEDITOR.config.extraPlugins = 'html5audio';
CKEDITOR.config.floatpanel = true;
CKEDITOR.config.floatpanel = true;
CKEDITOR.config.extraPlugins = 'image2';
CKEDITOR.config.removeButtons = 'Save,NewPage,Preview,Print,Templates,PasteFromWord,Scayt,Form,Checkbox,Radio,TextField,Textarea,Select,Button,ImageButton,HiddenField,CopyFormatting,RemoveFormat,Outdent,Indent,CreateDiv,BidiLtr,BidiRtl,PageBreak,ShowBlocks,About';