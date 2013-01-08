var SITE_URL = '{const SITE_URL}';
var SITE_ALIAS = '{const SITE_ALIAS}';
{capture assign="SA_PARENT"}{const SITE_ALIAS}{/capture}
{capture assign="SA_PARENT"}{$SA_PARENT|replace:'XML':''}{/capture}
var SITE_ALIAS_PARENT = '{$SA_PARENT}';
var BACK_URL = '{url href="alias=`$SA_PARENT`"}';
{if isset($ref)}
var REF = '{$ref}';
{else}
var REF = false;
{/if}
{literal}
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

RADDTree = {
    cancelClick: function()
	{
	   if(REF){
	       location = SITE_URL+REF;
	   }else{
	       location = BACK_URL;
	   }
	},
	applyClick: function()
	{
	   $('returntorefferer').value = '1';
	   $('detail_edit_form').submit();
	},
	saveClick: function()
	{
	   $('returntorefferer').value = '0';
       $('detail_edit_form').submit();
	},
    message: function(message){
       document.getElementById('detailTreeMessage').innerHTML = message;
       setTimeout("document.getElementById('detailTreeMessage').innerHTML = '';",5000);
    }
}
{/literal}