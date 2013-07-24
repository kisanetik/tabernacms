var SITE_URL = '{const SITE_URL}';
var SITE_ALIAS = '{const SITE_ALIAS}';
{capture assign="SA_PARENT"}{const SITE_ALIAS}{/capture}
{capture assign="SA_PARENT"}{$SA_PARENT|replace:'XML':''}{/capture}
var SITE_ALIAS_PARENT = '{$SA_PARENT}';
var BACK_URL = '{url href="alias=`$SA_PARENT`"}';

//MESSAGES
var ENTER_TITTLE_PLEASE = "{lang code='entertittle.articles.message' ucf=true htmlchars=true}";
var CONFIRM_DELETE = "{lang code="confirmdelete.catalog.message" htmlchars=true}";

{literal}
RADEditArticles = {
    checkForm: function()
    {
        if($('art_title').value.length==0){
            alert(ENTER_TITTLE_PLEASE);
            $('art_title').focus();
            return false;
        }
        return true;
    },
    applyClick: function()
    {
        if(this.checkForm()){
            $('returntorefferer').value='1';
            $('addedit_form').submit();
        }
    },
    saveClick: function()
    {
        if(this.checkForm()){
            $('returntorefferer').value='0';
            $('addedit_form').submit();
        }
    },
    deleteClick: function()
    {
        if(confirm(CONFIRM_DELETE)) {
            return true;
        }
        return false;
    },
    cancelClick: function(nid)
    {
        location = BACK_URL + '#nic/' + nid;
    }
}
RADTabs = {
    change: function(id)
    {
       $('TabsPanel').getElements('.vkladka').removeClass('activ');
       $(id).className += ' activ';
       $('TabsWrapper').getElements('div[id$=tabcenter]').setStyle('display', 'none');
       if($(id+'_tabcenter')){
           $(id+'_tabcenter').setStyle('display','block');
       }
    }
}
{/literal}