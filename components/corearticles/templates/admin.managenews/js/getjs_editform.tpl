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
RADEditNews = {
    checkForm: function()
    {
        if($('nw_title').value.length==0){
            alert(ENTER_TITTLE_PLEASE);
            $('nw_title').focus();
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
window.addEvent('load', function() {
    new DatePicker('.demo_vista', { inputOutputFormat: 'd-m-Y', 
                                    pickerClass: 'datepicker_vista', {/literal}
                                    days: ["{lang code='-sunday' htmlchars=true}", "{lang code='-january' htmlchars=true}", "{lang code='-tuesday' htmlchars=true}", "{lang code='-wednesday' htmlchars=true}", "{lang code='-thursday' htmlchars=true}", "{lang code='-friday' htmlchars=true}", "{lang code='-saturday' htmlchars=true}"],
                                    months: ["{lang code='-january' htmlchars=true}", "{lang code='-february' htmlchars=true}", "{lang code='-march' htmlchars=true}", "{lang code='-april' htmlchars=true}", "{lang code='-may' htmlchars=true}", "{lang code='-june' htmlchars=true}", "{lang code='-july' htmlchars=true}", "{lang code='-august' htmlchars=true}", "{lang code='-September' htmlchars=true}", "{lang code='-October' htmlchars=true}", "{lang code='-November' htmlchars=true}", "{lang code='-December' htmlchars=true}"] {literal}}
                   );
});
{/literal}
{*
window.addEvent('domready', function() {
    myCal = new Calendar({ nw_datenews: 'd-m-Y' });
    {/literal}
    myCal.options.months = ['{lang code="-january" ucf=true}', '{lang code="-february"}', '{lang code="-March"}', '{lang code="-April"}', '{lang code="-May"}', '{lang code="-June"}', '{lang code="-July"}', '{lang code="-August"}', '{lang code="-September"}', '{lang code="-October"}', '{lang code="-November"}', '{lang code="-December"}'];
    myCal.options.days = ['{lang code="-Sunday"}', '{lang code="-Monday"}', '{lang code="-Tuesday"}', '{lang code="-Wednesday"}', '{lang code="-Thursday"}', '{lang code="-Friday"}', '{lang code="-Saturday"}']
    {literal}
});

window.addEvent('domready', function() {
    myCal = new Calendar({ nw_showstart: 'd-m-Y' });
    {/literal}
    myCal.options.months = ['{lang code="-january" ucf=true}', '{lang code="-february"}', '{lang code="-March"}', '{lang code="-April"}', '{lang code="-May"}', '{lang code="-June"}', '{lang code="-July"}', '{lang code="-August"}', '{lang code="-September"}', '{lang code="-October"}', '{lang code="-November"}', '{lang code="-December"}'];
    myCal.options.days = ['{lang code="-Sunday"}', '{lang code="-Monday"}', '{lang code="-Tuesday"}', '{lang code="-Wednesday"}', '{lang code="-Thursday"}', '{lang code="-Friday"}', '{lang code="-Saturday"}']
    {literal}
});
window.addEvent('domready', function() {
    myCal = new Calendar({ nw_showend: 'd-m-Y' });
    {/literal}
    myCal.options.months = ['{lang code="-january" ucf=true}', '{lang code="-february"}', '{lang code="-March"}', '{lang code="-April"}', '{lang code="-May"}', '{lang code="-June"}', '{lang code="-July"}', '{lang code="-August"}', '{lang code="-September"}', '{lang code="-October"}', '{lang code="-November"}', '{lang code="-December"}'];
    myCal.options.days = ['{lang code="-Sunday"}', '{lang code="-Monday"}', '{lang code="-Tuesday"}', '{lang code="-Wednesday"}', '{lang code="-Thursday"}', '{lang code="-Friday"}', '{lang code="-Saturday"}']
    {literal}
});
*}