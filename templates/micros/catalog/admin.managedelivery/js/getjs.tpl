var SITE_URL = '{const SITE_URL}';
var SITE_ALIAS = '{const SITE_ALIAS}';

{*URLS*}
var ADDEDIT_WINDOW_URL = '{url href="alias=`$smarty.const.SITE_ALIAS`&action=addedit"}';
var GET_ITEMS_URL = '{url href="action=getitems"}';
var DELETE_ITEM_URL = '{url href="action=deleteitem"}';
var SET_ACTIVE_URL = '{url href="action=setactive"}';

{*TEXTAND MESSAGES*}
var LOADING_TEXT = "{lang code="-loading" ucf=true|replace:'"':'&quot;'}";
var ADD_TITLE_WINDOW = "{lang code="adddelivery.catalog.title" ucf=true|replace:'"':'&quot;'}";
var EDIT_TITLE_WINDOW = "{lang code="editdelivery.catalog.title" ucf=true|replace:'"':'&quot;'}";
var DONE_TEXT = "{lang code="-done" ucf=true|replace:'"':'&quot;'}";
var WANTTODELETE_TEXT = "{lang code="deletedelivery.catalog.query" ucf=true|replace:'"':'&quot;'}";

var HASH = '{$hash}';

{literal}
RADDelivery = {
    init: function()
    {
        alert('inited');
    },
    'addClick': function()
    {
        $("ListMessage").set("html",LOADING_TEXT);
        var req = new Request({
            url: ADDEDIT_WINDOW_URL,
            onSuccess: function(txt) {
		        RADDelivery.cancelWClick();
                if(!$('addDeliveryWindow')){
                   var wheight = Window.getHeight();
                   if(wheight>400){
                       wheight = 400;
                   }
                   wheight = wheight-50;
                   var wnd = new dWindow({
                       id:'addDeliveryWindow',
                       content: txt,
                       width: 600,
                       height: wheight,
                       minWidth: 180,
                       minHeight: 160,
                       left: 250,
                       top: 100,
                       title: ADD_TITLE_WINDOW
                   }).open($(document.body));
                   $('rdl_name').focus();
                   RADDelivery.message(DONE_TEXT);
            	}
            }
        }).send();
        return false;
    },
    'editRow': function(id)
    {
        $("ListMessage").set("html",LOADING_TEXT);
        var req = new Request({
            url: ADDEDIT_WINDOW_URL+'i/'+id,
            onSuccess: function(txt){
		    RADDelivery.cancelWClick();
                if(!$('addDeliveryWindow')){
                   var wheight = Window.getHeight();
                   if(wheight>400){
                       wheight = 400;
                   }
                   wheight = wheight-50;
                   var wnd = new dWindow({
                       id:'addDeliveryWindow',
                       content: txt,
                       width: 600,
                       height: wheight,
                       minWidth: 180,
                       minHeight: 160,
                       left: 250,
                       top: 100,
                       title: EDIT_TITLE_WINDOW
                   }).open($(document.body));
                   $('rdl_name').focus();
                   RADDelivery.message(DONE_TEXT);
            	}
            }
        }).send();
        return false;
    },
    'deleteRow': function(id)
    {
        if(confirm(WANTTODELETE_TEXT)) {
            $("ListMessage").set("html",LOADING_TEXT);
            var req = new Request({
                url: DELETE_ITEM_URL+'i/'+id+'/',
                data:{hash:HASH},
                onSuccess: function(txt) {
                    eval(txt);
                }
            }).send();
        }
        return false;
    },
    'addEditSubmit': function()
    {
        if($('rdl_id')) {
            var i = 'i/'+$('rdl_id').value;
        } else {
            var i = '';
        }
        var req = new Request({
            url: ADDEDIT_WINDOW_URL+i,
            data: $('addwform').toQueryString(),
            onSuccess: function(txt) {
                eval(txt);
            }
        }).send();
        return false;
    },
    'cancelWClick': function()
    {
        if($('addDeliveryWindow')){
            $('addDeliveryWindow').destroy();
        }
    },
    'refresh': function()
    {
        $("ListMessage").set("html",LOADING_TEXT);
        var req = new Request({
            url: GET_ITEMS_URL,
            onSuccess: function(txt) {
                $('panel_itemslist').set('html', txt);
                RADDelivery.message(DONE_TEXT);
            }
        }).send();
        return false;
    },
    setActive: function(active,pid)
    {
         var req = new Request({
             url:SET_ACTIVE_URL+'v/'+active+'/c/'+pid+'/',
             onSuccess: function(txt){
                eval(txt);
             },
             onFailure: function(){
                RADDelivery.message(FAILED_REQUEST);
             }
         }).send();
     },
    'changeContntLang': function(lngid,lngcode) 
    {
        this.refresh();
    },
    'message': function(txt, timeout)
    {
        timeout = timeout || 5000;
        $("ListMessage").set("html",txt);
        setTimeout('$("ListMessage").set("html","")', timeout);
    }
}
RADCHLangs.addContainer('RADDelivery.changeContntLang');
{/literal}