var FAILED_REQUEST = '{lang code="requestisfiled.catalog.text" ucf=true}';
var SITE_URL = '{const SITE_URL}';
var SITE_ALIAS = '{const SITE_ALIAS}';
var SAVE_SETTINGS_URL = '{url href="action=ss"}';
var SAVE_ITEM_URL = '{url href="action=si"}';
var EDIT_ITEM_URL = '{url href="action=ei"}';
var DELETE_ITEM_URL = '{url href="action=di"}';
var REFRESH_ITEMS_URL = '{url href="action=ri"}';

var LOADING = '{lang code="-loading" ucf=true}';
var FINISH = '{lang code="-done" ucf=true}';
var TEXT_SAVED = '{lang code="-saved" ucf=true}';
var TEXT_EDITCOMMENT = '{lang code="editcomment.resource.text" ucf=true}';
var TEXT_DEL_COMMENT = '{lang code="delcomment.resource.query" ucf=true}';
var HASH = '{$hash}';

{literal}
RADComments = {
    'change': function(item_id)
    {
        RADComments.message(LOADING);
        var req = new Request({
            url: EDIT_ITEM_URL+'i/'+item_id+'/',
            onSuccess: function(res){
               if($('editCommentWindow')){
                   $('editCommentWindow').destroy();
               }
               if(!$('editBannerWindow')){
                  var wheight = Window.getHeight();
                  if(wheight>350){
                      wheight = 350;
                  }
                  wheight = wheight-50;
                  var wnd = new dWindow({
                      id:'editCommentWindow',
                      content: res,
                      width: 500,
                      height: wheight,
                      minWidth: 180,
                      minHeight: 160,
                      left: 250,
                      top: 120,
                      title: TEXT_EDITCOMMENT
                  }).open($(document.body));
                  RADComments.message(FINISH);
               }
            },
            onFailure: function(){
                alert(FAILED_REQUEST);
                RADComments.message(FAILED_REQUEST);
            }
        }).send();
    },
    'saveComment': function()
    {
        var req = new Request({
            url: SAVE_ITEM_URL,
            method: 'post',
            data: $('editComment'),
            onSuccess: function(res){
                RADComments.message(TEXT_SAVED);
                RADComments.refreshItems();
            },
            onFailure: function(){
                alert(FAILED_REQUEST);
                RADComments.message(FAILED_REQUEST);
            }
        }).send();
        if($('editCommentWindow')){
            $('editCommentWindow').destroy();
        }
        return false;
    },
    'cancelSaveCommentClick': function()
    {
        if($('editCommentWindow')) {
            $('editCommentWindow').destroy();
        }
    },
    'refreshItems': function()
    {
        RADComments.message(LOADING);
        var req = new Request({
            url: REFRESH_ITEMS_URL,
            onSuccess: function(res){
                $('panel_itemslist').set('html', res);
                RADComments.message(FINISH);
            },
            onFailure: function(){
                alert(FAILED_REQUEST);
                RADComments.message(FAILED_REQUEST);
            }
        }).send();
    },
    'delItem': function(item_id)
    {
        if(confirm(TEXT_DEL_COMMENT)) {
            RADComments.message(LOADING);
            var req = new Request({
                url: DELETE_ITEM_URL+'i/'+item_id+'/',
                data:{hash:HASH},
                onSuccess: function(res){
                    RADComments.message(FINISH);
                    RADComments.refreshItems();
                },
                onFailure: function(){
                    alert(FAILED_REQUEST);
                    RADComments.message(FAILED_REQUEST);
                }
            }).send();
        }
    },
    'message': function(message)
    {
        $('listMessage').set('html', message);
        setTimeout("$('listMessage').set('html','');",5000);
    }
}
function initHref()
{
    if(document.location.hash.length) {
        RADComments.change(document.location.hash.replace('#',''));
    }
}
window.onload=function(){initHref();};
{/literal}