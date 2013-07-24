var SITE_URL = '{const SITE_URL}';
var SITE_ALIAS = '{const SITE_ALIAS}';
{capture assign="SA_PARENT"}{const SITE_ALIAS}{/capture}
{capture assign="SA_PARENT"}{$SA_PARENT|replace:'XML':''}{/capture}
var SITE_ALIAS_PARENT = '{$SA_PARENT}';
var BACK_URL = '{url href="alias=`$SA_PARENT`"}';

//MESSAGES
var ENTER_TITTLE_PLEASE = "{lang code="entertittle.catalog.message" htmlchars=true}";
var CONFIRM_DELETE = "{lang code="confirmdelete.catalog.message" htmlchars=true}";

{literal}
RADEditPages = {
    checkForm: function()
    {
        if($('pg_title').value.length==0){
            alert(ENTER_TITTLE_PLEASE);
            $('pg_title').focus();
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
{*
window.addEvent('domready', function() {
    myCal = new Calendar({ nw_datenews: 'd-m-Y' });
    {/literal}
    myCal.options.months = ['{lang code="-january" ucf=true}', '{lang code="-february" ucf=true}', '{lang code="-march" ucf=true}', '{lang code="-april" ucf=true}', '{lang code="-may" ucf=true}', '{lang code="-june" ucf=true}', '{lang code="-july" ucf=true}', '{lang code="-august" ucf=true}', '{lang code="-september" ucf=true}', '{lang code="-october" ucf=true}', '{lang code="-november" ucf=true}', '{lang code="-december"}'];
    myCal.options.days = ['{lang code="-sunday" ucf=true}', '{lang code="-monday" ucf=true}', '{lang code="-tuesday" ucf=true}', '{lang code="-wednesday" ucf=true}', '{lang code="-thursday" ucf=true}', '{lang code="-friday" ucf=true}', '{lang code="-saturday" ucf=true}']
    {literal}
});
*}