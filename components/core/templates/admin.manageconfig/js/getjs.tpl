var SITE_URL = '{const SITE_URL}';
var SITE_ALIAS = '{const SITE_ALIAS}';

//URL'S
var SAVE_PARAMS_URL = '{url href="action=save"}';

//COSTANTS
var TREE_THEME = '{url type="image" module="core" preset="original" file="mootree/mootree.gif"}';
var LOADER_ICO = '{url type="image" module="core" preset="original" file="mootree/mootree_loader.gif"}';
//var ROOT_PID = '{$ROOT_PID}';
var LOADING_TEXT = '{lang code="-loading"}';
var CURR_LANG = '{$lang}';

//MESSAGES
var FIELD_IS_EMPTY = "{lang code="fieldisempty.system.query" ucf=true htmlchars=true}";
var WRONG_FIELD = "{lang code="wrongfield.system.query" ucf=true htmlchars=true}";
var WRONG_DECIMAL_SEPARATOR = "{lang code="currency_decimal_separator_wrong.core.error" ucf=true htmlchars=true}";
var WRONG_GROUP_SEPARATOR = "{lang code="currency_group_separator_wrong.core.error" ucf=true htmlchars=true}";

{literal}
RADConfig = {
    showReferealsPercent: function()
    {
        var selectBox = document.getElementById("referals__on");
        var selectedValue = selectBox.options[selectBox.selectedIndex].value;
        if($('refpercent')) {
            if(selectedValue == 1) {
                $('refpercent').style.display = 'block';
            } else {
                $('refpercent').style.display = 'none';
            }
        }
    },
    
    checkForm: function()
    {
        $('page__defaultTitle_error').style.display = 'none';
        $('page__defaultTitle_error').set('text','');
        $('admin__mail_error').style.display = 'none';
        $('admin__mail_error').set('text','');
        $('system__mail_error').style.display = 'none';
        $('system__mail_error').set('text','');
        $('referals__on_error').style.display = 'none';
        $('referals__on_error').set('text','');
        $('referals__percent_error').style.display = 'none';
        $('referals__percent_error').set('text','');
        $('lang__location_show_error').style.display = 'none';
        $('lang__location_show_error').set('text','');
        $('currency__decimal_separator_error').style.display = 'none';
        $('currency__decimal_separator_error').set('text','');
        $('currency__group_separator_error').style.display = 'none';
        $('currency__group_separator_error').set('text','');

        isError = false;
        if (/[0-9]/.test($('currency__group_separator').get('value'))) {
            $('currency__group_separator_error').style.display = 'block';
            $('currency__group_separator_error').set('text', WRONG_GROUP_SEPARATOR);
            isError = true;
        }

        if (/[0-9]/.test($('currency__decimal_separator').get('value'))) {
            $('currency__decimal_separator_error').style.display = 'block';
            $('currency__decimal_separator_error').set('text', WRONG_DECIMAL_SEPARATOR);
            isError = true;
        }

        if($('page__defaultTitle').get('value').length < 1) {
            $('page__defaultTitle_error').style.display = 'block';
            $('page__defaultTitle_error').set('text', FIELD_IS_EMPTY);
            isError = true;
        }
        
        if($('admin__mail').get('value').length < 1) {
            $('admin__mail_error').style.display = 'block';
            $('admin__mail_error').set('text', FIELD_IS_EMPTY);
            isError = true;
        } else if(/^([\S-\.]+@([\S-]+\.)+[\S-]{2,6})?$/.test($('admin__mail').get('value')) == false) {
            $('admin__mail_error').style.display = 'block';
            $('admin__mail_error').set('text', WRONG_FIELD);
            isError = true;
        }
        
        if($('system__mail').get('value').length < 1) {
            $('system__mail_error').style.display = 'block';
            $('system__mail_error').set('text', FIELD_IS_EMPTY);
            isError = true;
        } else if(/^([\S-\.]+@([\S-]+\.)+[\S-]{2,6})?$/.test($('system__mail').get('value')) == false) {
            $('system__mail_error').style.display = 'block';
            $('system__mail_error').set('text', WRONG_FIELD);
            isError = true;
        }
        
        var selectBox = document.getElementById("referals__on");
        var selectedValue = selectBox.options[selectBox.selectedIndex].value;
        if(selectedValue == 1) {
            if($('referals__percent').get('value').length < 1) {
                $('referals__percent_error').style.display = 'block';
                $('referals__percent_error').set('text', FIELD_IS_EMPTY);
                isError = true;
            } else if(isNaN($('referals__percent').get('value'))) {
                $('referals__percent_error').style.display = 'block';
                $('referals__percent_error').set('text', WRONG_FIELD);
                isError = true;
            }
        }

        return isError;
    },
    
    save : function()
    {
        if(this.checkForm()) {
            return false;
        } else {
            $('configForm').submit();
        }
    }
}
{/literal}