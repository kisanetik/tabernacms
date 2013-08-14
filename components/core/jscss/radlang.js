/**
 * @depend on MooTools
 */
var RADLanguagesPanel = {
    'deselect': function() {
        $$('.element').removeClass('active');
        /* update language in the "statusbar" */
        $$('.statusbar .element span.language').set('html', this.get('lng_name'));
        /* Update right panel with properties */
        if (RADLangPropertiesPanel.isOpened()) {
            RADLangPropertiesPanel.clearData();
            RADLangPropertiesPanel.setPanelState(RADLangPropertiesPanel.STATE_OFF);
        }
        $('translates_table').set('html', '<tr class="preloader"><td>' + STR_SELECT + '</td></tr>');
    },
    'select': function(element, event) {
        $$('.element').removeClass('active');
        /* makes current element selected */
        element.addClass('active');
        /* stop event bubbling */
        if (typeof event != 'undefined') {
            event.stopPropagation();
        }
        /* update language in the "statusbar" */
        $$('.statusbar .element span.language').set('html', this.get('lng_name'));

        /* Update right panel with properties */
        if (RADLangPropertiesPanel.isOpened()) {
            if (RADLangPropertiesPanel.getPanelState() != RADLangPropertiesPanel.STATE_EDIT) {
                RADLangPropertiesPanel.setPanelState(RADLangPropertiesPanel.STATE_EDIT);
            }
            RADLangPropertiesPanel.setValues({
                lng_id:     this.get('lng_id'),
                lng_img:    this.get('lng_img'),
                lng_active: this.get('lng_active'),
                lng_name:   this.get('lng_name'),
                lng_code:   this.get('lng_code'),
                lng_position:   this.get('lng_position'),
            });
        }
        RADTranslationsPanel.refresh();
    },
    'panelAddLanguage': function(details) {
        var html =  '<div class="flag">';
        var link = '';
        if (details.lng_img.length > 0) {
            link = SITE_URL + '/image.php?m=core&p=language&th=~~~THEMENAME~~~&f=lang/' + details.lng_img;
        }
        html += '    <img border="0" src="' + link + '"/>';
        html += '</div>';
        html += '<div class="title">'+details.lng_name+'</div>';
        html += '<div class="parameters">';
         html += '    <div class="lng_id">'+details.lng_id+'</div>';
         html += '    <div class="lng_name">'+details.lng_name+'</div>';
         html += '    <div class="lng_code">'+details.lng_code+'</div>';
         html += '    <div class="lng_active">'+details.lng_active+'</div>';
         html += '    <div class="lng_position">'+details.lng_position+'</div>';
         html += '    <div class="lng_img">'+details.lng_img+'</div>';
         html += '    <div class="lng_mainsite">'+details.lng_mainsite+'</div>';
         html += '    <div class="lng_mainadmin">'+details.lng_mainadmin+'</div>';
         html += '    <div class="lng_maincontent">'+details.lng_maincontent+'</div>';
         html += '</div>';
         html += '<div class="default"';
         if (details.lng_active == 0) {
             html += ' style="display:none"';
         }
         html += '></div>';
        var element = new Element('div', {
            'class': 'element',
            'html': html,
            'onclick': 'RADLanguagesPanel.select(this, event)'
        });
        /* insert jyst created language to tle lang panel */
        element.inject( $('lang_tree').getElement('.clear'), 'before' );
        /* update statusbar counter */
        $$('.statusbar .element span.translations').set('html', $('lang_tree').getElements('.element').length);
    },
    'panelDeleteLanguage': function(lang_id) {
        var elements = $('lang_tree').getElements('.element');
        for (var i=0; i<elements.length; i++) {
            var element = elements[i];
            if (element.getElement('.parameters').getElement('.lng_id').get('html') == lang_id) {
                this.deselect();
                element.dispose();
                return true;
            }
        }
        return false;
    },
    
    'isSelected': function() {
        return $('lang_tree').getElement('.active') != null;
    },

    /**
     * Get specified property for currently selected language
     * 
     * @param String key. Supported keys are:
     *    `lng_id`
     *    `lng_name`
     *    `lng_code`
     *    `lng_img`
     *    `lng_position`
     *    `lng_active`
     *    `lng_mainsite`
     *    `lng_mainadmin`
     *    `lng_maincontent`
     *    @return String Value of the key as it is in the rad_lang table.
     *    
     */
    'get': function(key) {
        /* if language in the panel is selected. */
        if (this.isSelected()) {
            return $('lang_tree').getElement('.active').getElement('.parameters').getElement('.'+key).get('html');
        }
        return '';
    },

    'setFlag': function(image) {
        if (this.isSelected()) {
            $('lang_tree').getElement('.active').getElement('img').set('src', SITE_URL+'/image.php?m=core&p=language&th=~~~THEMENAME~~~&f=lang/'+image);
        } else {
            var parameters = $('lang_tree').getElements('.parameters');
            for (var i=0; i<parameters.length; i++) {
                var element = parameters[i];
                if (element.getElement('.lng_active').get('html') > 0) {
                    element.getElement('img').set('src', SITE_URL + '/image.php?m=core&p=language&th=~~~THEMENAME~~~&f=lang/'+image);
                    return;
                }
            }
        }
    },
    'deleteLanguage': function() {
        this.showPreloader();
        if (RADLangPropertiesPanel.isOpened()) {
            RADLangPropertiesPanel.showPreloader();
        }
        var lang_id = RADLanguagesPanel.get('lng_id');
        if (lang_id > 0) {
            var parent = this
                myRequest = new Request.JSON({
                method: 'post',
                data: {
                    action: 'delete',
                    lang_id: lang_id,
                },
                url: POST_LANG_URL,
                onSuccess: function(data)
                {
                    if (data == true) {
                        if (RADLangPropertiesPanel.isOpened()) {
                            RADLangPropertiesPanel.setPanelState(RADLangPropertiesPanel.STATE_OFF);
                        }
                        RADLangPropertiesPanel.clearData();
                        RADLangPropertiesPanel.setPanelState(RADLangPropertiesPanel.STATE_OFF);
                        parent.panelDeleteLanguage(lang_id);
                        /* update statusbar counter to the new decreased value */
                        $$('.statusbar .element span.translations').set('html', $('lang_tree').getElements('.element').length);

                    }
                    parent.hidePreloader();
                },
                onFailure: function()
                {
                    alert('Failure');
                    parent.hidePreloader();
                }
            }).send();
        }
    },
    'showPreloader': function() {},
    'hidePreloader': function() {},
};

var RADLangPropertiesPanel = {

    STATE_OFF: 'off',
    STATE_ADD: 'add',
    STATE_EDIT: 'edit',
    'clearPreviewFlagImage': function() {
        $('language_details_preview_flag').set('src', '');
    },
    'setPreviewFlagImage': function(url) {
        $('language_details_preview_flag').set('src', '');
    },
    'editLanguage': function() {
        if (RADLanguagesPanel.isSelected()) {
            this.setPanelState(RADLangPropertiesPanel.STATE_EDIT);
        }
        this.setValues({
            lng_id:     RADLanguagesPanel.get('lng_id'),
            lng_img:    RADLanguagesPanel.get('lng_img'),
            lng_active: RADLanguagesPanel.get('lng_active'),
            lng_mainsite: RADLanguagesPanel.get('lng_mainsite'),
            lng_mainadmin: RADLanguagesPanel.get('lng_mainadmin'),
            lng_maincontent: RADLanguagesPanel.get('lng_maincontent'),
            lng_name:   RADLanguagesPanel.get('lng_name'),
            lng_code:   RADLanguagesPanel.get('lng_code'),
            lng_position:   RADLanguagesPanel.get('lng_position'),
        });
    },
    'addLanguage': function() {
        RADLanguagesPanel.deselect();
        this.clearData();
        this.setPanelState(RADLangPropertiesPanel.STATE_ADD);
    },
    'applyLanguage': function() {
        if (this.validate()) {
            this.save();
        }
    },
    'saveLanguage': function() {
        if (this.validate()) {
            this.save();
            this.setPanelState(RADLangPropertiesPanel.STATE_OFF);
        }
    },
    'cancelLanguage': function() {
        this.setPanelState(RADLangPropertiesPanel.STATE_OFF);
    },
    'clickDownloadTranslations': function() {
        this.showPreloader();
        var parent = this,
            downloadMode = $('download_owerwrite').checked == true ? 'overwrite' : 'skip';
            myRequest = new Request.JSON({
                method: 'post',
                data: {
                    action  : 'translations_download',
                    lang_id : RADLanguagesPanel.get('lng_id'),
                    mode    : downloadMode,
                },
                url: POST_LANG_URL,
                onSuccess: function(rowsAffected) {
                    parent.hidePreloader();
                    if (rowsAffected > 0) {
                        alert('Загружено ' + rowsAffected + ' новых переводов');
                    } else {
                        alert('Новых переводов на сервере нет');
                    }
                },
                onFailure: function() {
                    parent.hidePreloader();
                    console.log('Failure');
                }
            }).send();
    },
    'showPreloader': function() {
        $('language_details_pane').style.display = 'none';            
        $('language_details_preloader').style.display = '';
    },
    'hidePreloader': function() {
        $('language_details_preloader').style.display = 'none';
        $('language_details_pane').style.display = '';
    },

    'setPanelState': function(state) {
        switch (state) {
            case RADLangPropertiesPanel.STATE_ADD: /* add new language form (without download/upload features) */
                $('editCatTreeBlock').style.display = '';
                $('editCatTreeBlock').getElement('.block_header_title').set('html', TITLE_ADD_LANG);
                $('upload_image_pane').style.display = 'none';
                $('language_properties_apply_button').style.display = 'none';
                break;
            case RADLangPropertiesPanel.STATE_EDIT: /* edit existing language form (includes download/upload features) */
                $('editCatTreeBlock').style.display = '';
                $('editCatTreeBlock').getElement('.block_header_title').set('html', TITLE_EDIT_LANG);
                $('upload_image_pane').style.display = '';
                $('language_properties_apply_button').style.display = '';
                break;
            case RADLangPropertiesPanel.STATE_OFF: /* hide panel at all */
            default:
                this.hidePreloader();
                $('editCatTreeBlock').style.display = 'none';
        }
    },
    'getPanelState': function(state) {
        if ($('editCatTreeBlock').style.display == 'none') {
            return RADLangPropertiesPanel.STATE_OFF;
        }
        if ($('upload_image_pane').style.display == 'none') {
            return RADLangPropertiesPanel.STATE_ADD;
        }
        return RADLangPropertiesPanel.STATE_EDIT;
    },

    'isOpened': function() {
        return $('editCatTreeBlock').style.display != 'none';
    },

    'clearData': function() {
        this.setImage('');
        $('active_no').checked  = '';
        $('active_yes').checked = '';
        $('def_site_no').checked  = '';
        $('def_site_yes').checked = '';
        $('def_admin_no').checked  = '';
        $('def_admin_yes').checked = '';
        $('def_content_no').checked  = '';
        $('def_content_yes').checked = '';
        $('lang_lang').value = '';
        $('lang_code').value = '';
        $('lang_position').value = '';
    },
    'setImage': function(image) {
        if (image.length > 0) {
            image = SITE_URL + '/image.php?m=core&p=language&th=~~~THEMENAME~~~&f=lang/'+image;
            $('language_details_preview_clear').style.display = '';
        } else {
            $('language_details_preview_clear').style.display = 'none';
        }
        $('language_details_preview_flag').set('src', image);
    },
    'setValues': function(values) {
        this.setImage(values.lng_img);
        this.setActive(values.lng_active);
        this.setMainSite(values.lng_mainsite);
        this.setMainContent(values.lng_maincontent);
        this.setMainAdmin(values.lng_mainadmin);
        $('lang_lang').set('value', values.lng_name);
        $('lang_code').set('value', values.lng_code);
        $('lang_position').set('value', values.lng_position);
        /* update language flag in the upload panel */
        window.frames['iframe_upload_image'].document.getElementById('lng_id').value = values.lng_id;

    },
    'setActive': function(state) {
        if (state == 1) {
            $('active_no').checked  = '';
            $('active_yes').checked = 'checked';
        } else {
            $('active_yes').checked = '';
            $('active_no').checked  = 'checked';
        }
    },
    'setMainSite': function(state) {
        if (state == 1) {
            $('def_site_no').checked  = '';
            $('def_site_yes').checked = 'checked';
        } else {
            $('def_site_yes').checked = '';
            $('def_site_no').checked  = 'checked';
        }
    },
    'setMainContent': function(state) {
        if (state == 1) {
            $('def_content_no').checked  = '';
            $('def_content_yes').checked = 'checked';
        } else {
            $('def_content_yes').checked = '';
            $('def_content_no').checked  = 'checked';
        }
    },
    'setMainAdmin': function(state) {
        if (state == 1) {
            $('def_admin_no').checked  = '';
            $('def_admin_yes').checked = 'checked';
        } else {
            $('def_admin_yes').checked = '';
            $('def_admin_no').checked  = 'checked';
        }
    },

    /**
     * Submit lang propetries form
     */
    'save': function() {
        this.showPreloader();
        var parent = this;
        is_active = $('active_yes').checked == true ? 1 : 0;
        is_def_site = $('def_site_yes').checked == true ? 1 : 0;
        is_def_admin = $('def_admin_yes').checked == true ? 1 : 0;
        is_def_content = $('def_content_yes').checked == true ? 1 : 0;
            lang_code  = $('lang_code').value,
            lang_position = $('lang_position').value,
            lang_name  = $('lang_lang').value,
            myRequest = new Request.JSON({
                method: 'post',
                data: {
                    action: 'save',
                    lng_id: RADLanguagesPanel.get('lng_id'),
                    lng_code: lang_code,
                    lng_position: lang_position,
                    lng_name: lang_name,
                    lng_active: is_active,
                    lng_mainsite: is_def_site,
                    lng_mainadmin: is_def_admin,
                    lng_maincontent: is_def_content,
                },
                url: POST_LANG_URL,
                onSuccess: function(data) {
                    parent.hidePreloader();
                    if (data > 0) {

                        /* update statusbar counter to the new increased value */
                        $$('.statusbar .element span.translations').set('html', $('lang_tree').getElements('.element').length);
                        /* Ann new language to the panel */
                        RADLanguagesPanel.panelAddLanguage({
                            lng_id:               data,
                            lng_name:             lang_name,
                            lng_code:             lang_code,
                            lng_img:              '',
                            lng_active:           is_active,
                            lng_position:         0,
                            lng_mainsite:         is_def_site,
                            lng_mainadmin:        is_def_admin,
                            lng_maincontent:      is_def_content,
                        });
                    }
                },
                onFailure: function() {
                    alert('Failure');
                }
            }).send();
    },
    'validate': function() {
        var is_correct = true;
        if ($('lang_code').value.length > 0) {
            $('lang_code').style.border = '1px solid #CCC';
        } else {
            $('lang_code').style.border = '1px solid #F00';
            is_correct = false;
        }
        if ($('lang_lang').value.length > 0) {
            $('lang_lang').style.border = '1px solid #CCC';
        } else {
            $('lang_lang').style.border = '1px solid #F00';
            is_correct = false;
        }
        return is_correct;
    },
    'switchUploadFrame': function() {
        if ($('imageUpload_block').style.display=='block') {
            $('imageUpload_block').style.display='none';
        } else {
            $('imageUpload_block').style.display='block';
        }
    }
};

var RADTranslationsPanel = {
    'tab': function(tabName) {
        switch (tabName) {
            case 'translated':
                $('tab_untranslated').removeClass('activ');
                $('tab_translated').addClass('activ');
                $('addBtn').style.display = '';
                break;
            case 'untranslated':
            default:
                $('tab_untranslated').addClass('activ');
                $('tab_translated').removeClass('activ');
                $('addBtn').style.display = 'none';
        }
        this.refresh();
    },
    'clickAddTranslation': function(event) {

        /* hide save translation button */
        $('translation_new_save').style.display = 'none';
        /* toggle panels visibility */
        if ( RADTranslationAdd.isOpened() ) {
            RADTranslationAdd.hide();
        } else {
            RADTranslationAdd.show();
        }
    },
    'clickSaveAll': function() {
        var modified = $('translates_table').getElements('.modified');
        for (var i=0; i< modified.length; i++) {
            var button_save = modified[i].getParent().getParent().getElement('.save');
            var evt = {currentTarget: button_save};
            RADTranslationLine.clickSave(evt);
        }
    },
    'clickRefresh': function() {
        this.refresh();
    },

    'refresh': function() {
        if (RADLanguagesPanel.isSelected()) {
            this.showPreloader();
            var search_string = this.getFilterText(),
                parent = this,
                myRequest = new Request.JSON({
                    method: 'post',
                    data: {
                        action: 'filter',
                        code: search_string,
                        lang: RADLanguagesPanel.get('lng_id'),
                        type: this.getTranslationsType(),
                    },
                    url: POST_LANG_URL,
                    onSuccess: function(responce)
                    {
                        parent.buildTranslationsTable(responce, search_string);
                        parent.hidePreloader();
                    },
                    onFailure: function()
                    {
                        alert('Failure');
                    }
                }).send();

        }
    },
    'filter': function(event) {
        /* is Enter key pressed */
        if (event.charCode == 0 && event.keyCode == 13) {
            this.filterApply();
        }
    },

    'filterApply': function() {
        var str = $('translate_search').value;
        if ( str.length > 0 ) {
            this.refresh();
        }
    },

    'buildTranslationsTable': function(data, highlight) {
        $('translates_table').empty();
        if (data.length > 0) {
            if(this.getTranslationsType()=='untranslated') {

            } else {
                for (var i in data) {
                    var code = data[i].lnv_code;
                    if (typeof code == 'undefined') continue;
                    if (typeof highlight == 'string' && highlight.length > 0) {
                        code = code.split(highlight).join(highlight);
                    }
                    var row = new Element('tr'),
                        td1 = new Element('td', {
                            html: code,
                            class: 'code',
                            width: '25%'
                        }).inject(row),
                        td2 = new Element('td', {
                            html: '<input type="text" value="'+data[i].lnv_value+'"  title="'+data[i].lnv_value+'" onkeyup="RADTranslationLine.onKeyUp(event)" />',
                            width: '68%'
                        }).inject(row),
                        td3 = new Element('td', {
                            html: '<div class="actions">'
                                 +'<img class="undo" src="~~~URL~~type=image~~module=core~~preset=original~~file=backend/icons/arrow_undo.png~~~" width="16" height="16" border="0" alt="' + STR_DELETE + '" title="' + STR_DELETE + '" style="display: none" onclick="RADTranslationLine.clickUndo(event)"/>'
                                 +'<img class="save" src="~~~URL~~type=image~~module=core~~preset=original~~file=backend/icons/disk.png~~~" width="16" height="16" border="0" alt="' + STR_DELETE + '" title="' + STR_DELETE + '" style="display: none" onclick="RADTranslationLine.clickSave(event)"/>'
                                 +'<img class="delete" src="~~~URL~~type=image~~module=core~~preset=original~~file=backend/icons/cross.png~~~" width="16" height="16" border="0" alt="' + STR_DELETE + '" title="' + STR_DELETE + '" onclick="RADTranslationLine.clickDelete(event)"/>'
                                 +'</div>',
                            style: 'text-align: center',
                            width: '7%'
                        }).inject(row);
                    row.inject($('translates_table'));
                }
            }
        } else {
            $('translates_table').set('html', '<tr class="preloader"><td>' + STR_NODATA + '</td></tr>');
        }
    },    
    'getFilterText': function() {
        return $('translate_search').value; 
    },
    'getTranslationsType': function() {
        return $('tab_untranslated').hasClass('activ') ? 'untranslated' : 'translated'; 
    },
    'showPreloader': function() {
        $('list_translation').getElement('.preloader').style.display = '';
        $('translates_table').style.display = 'none';
    },
    'hidePreloader': function() {
        $('list_translation').getElement('.preloader').style.display = 'none';
        $('translates_table').style.display = '';
    },
};

var RADTranslationAdd = {
    'validate': function() {
        var is_correct = true;
        if ($('translation_new_code').value.length > 0) {
            $('translation_new_code').style.border = '1px solid #ccc';
        } else {
            $('translation_new_code').style.border = '1px solid #f00';
            is_correct = false;
        }
        if ($('translation_new_value').value.length > 0) {
            $('translation_new_value').style.border = '1px solid #ccc';
        } else {
            $('translation_new_value').style.border = '1px solid #f00';
            is_correct = false;
        }
        return is_correct;
    },
    'onKeyUp': function(event) {
        if ( this.validate() ) {
            $('translation_new_save').style.display = '';
        } else {
            $('translation_new_save').style.display = 'none';
        }
    },
    'clickSave': function(event) {
        if ( this.validate() ) {
            var parent = this
                myRequest = new Request.JSON({
                method: 'post',
                data: {
                    action:  'save_code',
                    code:    $('translation_new_code').value,
                    value:   $('translation_new_value').value,
                    lang_id: RADLanguagesPanel.get('lng_id'),
                },
                url: POST_LANG_URL,
                onSuccess: function(data)
                {
                    parent.hide();
                    RADTranslationsPanel.refresh();
                },
                onFailure: function()
                {
                    alert('Failure');
                    parent.hide();
                }
            }).send();
        }
    },
    'show': function() {
        $('list_translation').getElement('.translation_new').style.display = '';
        $('translation_new_code').value = '';
        $('translation_new_value').value = '';
        RADTranslationAdd.validate();
        $('translation_new_code').focus();
    },
    'hide': function() {
        $('list_translation').getElement('.translation_new').style.display = 'none';
    },
    'isOpened': function() {
        return $('list_translation').getElement('.translation_new').style.display != 'none';
    },
};

var RADTranslationLine = {
    'onKeyUp': function(event) {
        var element       = event.currentTarget,
            value_new     = element.value,
            value_default = element.get('title');
        if (value_default != value_new) {
            /* the value was changed */
            element.className = 'modified';
            element.getParent().getParent().getElement('img.undo').style.display = '';
            element.getParent().getParent().getElement('img.save').style.display = '';
            element.getParent().getParent().getElement('img.delete').style.display = 'none';
        } else {
            /* the value wasn't changed */
            element.className = '';
            element.getParent().getParent().getElement('img.undo').style.display = 'none';
            element.getParent().getParent().getElement('img.save').style.display = 'none';
            element.getParent().getParent().getElement('img.delete').style.display = '';
        }
    },
    'clickUndo': function(event) {
        var element_input = event.currentTarget.getParent().getParent().getParent().getElement('input');
        element_input.value = element_input.get('title');
        element_input.className = '';
        event.currentTarget.style.display = 'none';
        event.currentTarget.getParent().getElement('img.save').style.display = 'none';
        event.currentTarget.getParent().getElement('img.delete').style.display = '';
    },
    'clickSave': function(event) {
        var button_save   = event.currentTarget,
            element_input = event.currentTarget.getParent().getParent().getParent().getElement('input'),
            parent = this,
            myRequest = new Request.JSON({
                method: 'post',
                data: {
                    action: 'save_code',
                    code: button_save.getParent().getParent().getParent().getElement('td.code').get('html'),
                    value: element_input.value,
                    lang_id: RADLanguagesPanel.get('lng_id'),
                },
                url: POST_LANG_URL,
                onSuccess: function(responce) {
                    element_input.className = '';
                    button_save.style.display = 'none';
                    button_save.getParent().getParent().getElement('img.undo').style.display = 'none';
                    button_save.getParent().getParent().getElement('img.delete').style.display = '';
                },
                onFailure: function() {
                    element_input.className = 'error';
                }
            }).send();

    },
    'clickDelete': function(event) {
        if ( confirm('Вы действительно хотите удалить переаод?') ) {
            var button_delete   = event.currentTarget,
                element_input   = event.currentTarget.getParent().getParent().getParent().getElement('input'),
                myRequest       = new Request.JSON({
                    method: 'post',
                    data: {
                        action: 'delete_code',
                        code: button_delete.getParent().getParent().getParent().getElement('td.code').get('html'),
                        lang_id: RADLanguagesPanel.get('lng_id'),
                    },
                    url: POST_LANG_URL,
                    onSuccess: function(responce) {
                        var row = button_delete.getParent().getParent().getParent();
                        row.dispose();
                    },
                    onFailure: function() {
                        element_input.className = 'error';
                    }
                }).send();
        }

     },

};
window.addEvent('load', function() {
    RADTranslationsPanel.refresh();
});