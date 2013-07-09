var SITE_URL = '{const SITE_URL}';
var SITE_ALIAS = '{const SITE_ALIAS}';
var SEARCH_URL = '{url href="action=search"}';
var REFRESH_URL = '{url href="action=refreshlist"}';

var FAILED_REQUEST = "{lang code="requestisfiled.system.error" ucf=true|replace:'"':'&quot;'}";
var ENTER_SEARCH_WORD = "{lang code="entersearchword.system.message" ucf=true|replace:'"':'&quot;'}";
var LOADING_TEXT = "{lang code="-loading" ucf=true|replace:'"':'&quot;'}";

{literal}
RADAliasesList = {
    se_IE: false,
    refresh: function()
    {
       $('AliasesListMessage').set('html',LOADING_TEXT);
       var onlyadmin = 1;
       $('addBtn').href = $('addBtn').href.replace('ta/1/','');
       $('addBtn').href = $('addBtn').href.replace('oa/1/','');
       if($('onlyadmin_no').checked){
           onlyadmin = 0;
       }else if($('onlyadmin_templates').checked==false){
           $('addBtn').href+='oa/1/';
       }
       if($('onlyadmin_templates').checked){
           onlyadmin = 2;
           $('addBtn').href+='ta/1/';
       }
       var req = new Request({
           url: REFRESH_URL+'onlyadmin/'+onlyadmin+'/',
           onSuccess: function(txt){
              $('tb_list').parentNode.innerHTML = txt;
              $('AliasesListMessage').set('html','');
              if(Browser.Engine.trident) startList();
           },
           onFailure: function(){
              alert(FAILED_REQUEST);
           }
       }).send();
    },
    search: function()
    {
       var sw = $('search').value;
       var onlyadmin = 1;
       if($('onlyadmin_no').checked)
           onlyadmin = 0;
       $('AliasesListMessage').set('html',LOADING_TEXT);
       var req = new Request({
           url: SEARCH_URL+'word/'+sw+'/onlyadmin/'+onlyadmin+'/',
           onSuccess: function(txt){
              RADAliasesList.se_IE=false;
              $('tb_list').parentNode.innerHTML = txt;
              $('AliasesListMessage').set('html','');
              //eval(txt);
           },
           'onFailure': function(){
              alert(FAILED_REQUEST);
           }
       }).send();
    },
    addKeyPress: function(e)
    {
        var key;
        if(window.event)
        {
            this.se_IE = true;
            key=window.event.keyCode;     //IE
        }
        else
        {
            //key = e.which;     //firefox
            key = (e.keyCode ? e.keyCode : e.which);
        }

        if(key == 13)
        {
            if(!this.se_IE){
                this.se_IE = true;
            }
            this.search();
       }
    },
    filterApply: function(type)
    {
        $('alias_type').getElements('.vkladka').removeClass('activ');
        $(type).getParent().addClass('activ');
        $(type).checked = true;
        RADAliasesList.refresh();
    }
}
{/literal}
if(Browser.Engine.trident) startList();