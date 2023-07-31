/**
 * @license Copyright (c) 2003-2019, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see https://ckeditor.com/legal/ckeditor-oss-license
 */

CKEDITOR.editorConfig = function (config) {
	config.toolbarGroups = [
		{ name: 'document', groups: ['mode', 'document', 'doctools'] },
		// { name: 'basicstyles', groups: ['basicstyles', 'cleanup'] },
		{ name: 'paragraph', groups: ['indent', 'blocks', 'align', 'list', 'bidi', 'paragraph'] },
		{ name: 'links', groups: ['links'] },
		{ name: 'insert', groups: ['insert'] },
		{ name: 'colors', groups: ['colors'] },
		// { name: 'tools', groups: ['tools'] },
		// { name: 'styles', groups: ['styles'] },
		// { name: 'others', groups: ['others'] },
		// { name: 'about', groups: ['about'] },
		// { name: 'forms', groups: ['forms'] },
		{ name: 'editing', groups: ['find', 'selection', 'spellchecker', 'editing'] },
		{ name: 'clipboard', groups: ['clipboard', 'undo'] },
		{ name: 'mediaembed'},
	];

	config.removeButtons = 'About,RemoveFormat,CopyFormatting,Save,NewPage,Preview,Print,Templates,Find,Replace,SelectAll,Scayt,Blockquote,CreateDiv,Form,Checkbox,Radio,TextField,Textarea,Select,Button,ImageButton,HiddenField,Cut,Copy,Paste,PasteText,PasteFromWord,Undo,Redo,Outdent,Indent,Language,BidiLtr,BidiRtl,ShowBlocks';

	config.extraPlugins = 'mediaembed';

	config.allowedContent = true;
};