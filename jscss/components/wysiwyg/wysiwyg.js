/**
 * Interface for CKEDITOR
 */

var WYSIWYG = {
	language: '',
	languages: {
		'ukr': 'uk',
		'ch': 'zh-cn'
	},

	create: function(id, toolbar_set) {
		this.initialize();
		if (!toolbar_set) {
			toolbar_set = false;
		}
		CKEDITOR.replace(id, this.getConfig(id, toolbar_set));
	},

	initialize: function() {
		if (!this.language) {
			this.language = this.languages[ URL_LANGID ] ? this.languages[ URL_LANGID ] : URL_LANGID;

			CKEDITOR.config.language = this.language;
			CKEDITOR.config.filebrowserUploadUrl = SITE_URL + 'jscss/components/wysiwyg/upload.php';
			CKEDITOR.config.filebrowserBrowseUrl = SITE_URL + 'jscss/components/wysiwyg/browser.php';
		}
	},

	getConfig: function(id, toolbar_set) {
		var height = 250;
		if (document.getElementById(id)) {
			height = document.getElementById(id).offsetHeight;
		}

		var config = {
			height: height+'px'
		};
		if (toolbar_set == "basic") {
			config.toolbar = [
				{ name: 'basicstyles', groups: [ 'basicstyles', 'cleanup' ], items: [ 'Bold', 'Italic', '-', 'RemoveFormat' ] },
				{ name: 'paragraph', groups: [ 'list' ], items: [ 'NumberedList', 'BulletedList' ] }
			];
			config.removePlugins = 'elementspath';
		}
		else if (toolbar_set == "mini") {
			config.toolbar = [
				{ name: 'document', groups: [ 'mode' ], items: [ 'Source' ] },
				{ name: 'clipboard', groups: [ 'clipboard', 'undo' ], items: [ 'Cut', 'Copy', 'Paste', 'PasteText', 'PasteFromWord', '-', 'Undo', 'Redo' ] },
				{ name: 'basicstyles', groups: [ 'basicstyles', 'cleanup' ], items: [ 'Bold', 'Italic', 'Underline', 'Strike', '-', 'RemoveFormat' ] },
				{ name: 'paragraph', groups: [ 'align' ], items: [ 'JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock' ] },
				{ name: 'insert', items: [ 'Image', 'SpecialChar' ] },
				'/',
				{ name: 'styles', items: [ 'Format', 'Font', 'FontSize' ] },
				{ name: 'colors', items: [ 'TextColor', 'BGColor' ] },
				{ name: 'tools', items: [ 'Maximize' ] }
			];
		}
		else { // Default
			config.toolbar = [
				{ name: 'document', groups: [ 'mode', 'document', 'doctools' ], items: [ 'Source', '-', /*'Save', 'NewPage', 'Preview', 'Print', '-',*/ 'Templates' ] },
				{ name: 'clipboard', groups: [ 'clipboard', 'undo' ], items: [ 'Cut', 'Copy', 'Paste', 'PasteText', 'PasteFromWord', '-', 'Undo', 'Redo' ] },
				{ name: 'editing', groups: [ 'find', 'selection'/*, 'spellchecker'*/ ], items: [ 'Find', 'Replace', '-', 'SelectAll'/*, '-', 'Scayt'*/ ] },
				//{ name: 'forms', items: [ 'Form', 'Checkbox', 'Radio', 'TextField', 'Textarea', 'Select', 'Button', 'ImageButton', 'HiddenField' ] },
				{ name: 'basicstyles', groups: [ 'basicstyles', 'cleanup' ], items: [ 'Bold', 'Italic', 'Underline', 'Strike', 'Subscript', 'Superscript', '-', 'RemoveFormat' ] },
				{ name: 'links', items: [ 'Link', 'Unlink', 'Anchor' ] },
				{ name: 'insert', items: [ 'Image', 'Table', 'HorizontalRule', 'Smiley', 'SpecialChar' ] },
				{ name: 'paragraph', groups: [ 'list', 'indent', 'blocks', 'align', 'bidi' ], items: [ 'JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock', '-', 'NumberedList', 'BulletedList', '-', 'Outdent', 'Indent', '-', 'Blockquote', 'CreateDiv' ] },
				//'/',
				{ name: 'styles', items: [ 'Styles', 'Format', 'Font', 'FontSize' ] },
				{ name: 'colors', items: [ 'TextColor', 'BGColor' ] },
				{ name: 'tools', items: [ 'ShowBlocks', 'Maximize' ] }
			];
		}
		return config;
	},

	getEditor: function(id) {
		if (CKEDITOR.instances[id]) {
			return CKEDITOR.instances[id];
		}
		return null;
	},

	setContents: function(id, value) {
		var editor = this.getEditor(id);
		if (editor) {
			editor.setData(value);
		}
	},

	getContents: function(id) {
		var editor = this.getEditor(id);
		if (editor) {
			return editor.getData();
		}
		return '';
	},

	/**
	 * Return TRUE, if the current editing mode is WYSIWYG
	 * @param id
	 * @return bool
	 */
	isWYSIWYGMode: function(id) {
		var editor = this.getEditor(id);
		if (editor) {
			return (editor.mode != 'source');
		}
		return false;
	},

	/**
	 * Set focus
	 * @param id
	 */
	focus: function(id) {
		var editor = this.getEditor(id);
		if (editor) {
			return editor.focus();
		}
		return false;
	}
}