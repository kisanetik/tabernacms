{strip}
{capture name="mesaurements_items"}
    {if !empty($items)}
    <table cellpadding="0" cellspacing="0" border="0" width="0"  class="tb_list" id="tb_list" width="100%" style="width:100%;">
        <tr class="header">
            <td>ID</td>
            <td>{lang code='measurementname.catalog.text' ucf=true}</td>
            <td>{lang code='measurementposition.catalog.text' ucf=true}</td>
            <td>{lang code='-action' ucf=true}</td>
        </tr>
        {foreach from=$items item=item}
            <tr>
                <td>{$item->ms_id}</td>
                <td id="ms_val_{$item->ms_id}">{$item->ms_value}</td>
                <td>{$item->ms_position}</td>
                <td>
                    <a href="javascript:RADMeasuremant.editClick({$item->ms_id});">
                        <img src="{url type="image" module="core" preset="original" file="backend/billiard_marker.png"}" alt="{lang code='-edit' htmlchars=true}" title="{lang code='-edit' htmlchars=true}" border="0" />
                    </a>
                    <a href="javascript:RADMeasuremant.deleteMS({$item->ms_id});">
                        <img src="{url type="image" module="core" preset="original" file="backend/icons/cross.png"}" alt="{lang code='-delete' htmlchars=true}" title="{lang code='-delete' htmlchars=true}" border="0" />
                    </a>
                </td>
            </tr>
        {/foreach}
    </table>
    {/if}
{/capture}
{if empty($action)}
<div class="w100">
    <div class="kord_right_col">
{url href="alias=SITE_ALIASXML&a=getjs" type="js"}
    <h1>{lang code="managemeasurements.catalog.title" ucf=true}</h1>
    <table cellpadding="0" cellspacing="0" border="0" class="tb_two_column" style="height:auto;width:100%;">
        <tr>
            <td>
                <table id="itemslist_block" cellpadding="0" cellspacing="0" border="0" class="tb_cont_block" style="height:auto;width:100%;">
                    <tr>
                        <td class="corner_lt"></td>
                        <td class="header_top"></td>
                        <td class="corner_rt"></td>
                    </tr>
                    <tr>
                        <td class="left_border"></td>
                        <td class="header_bootom">
                            <div class="hb">
                                <div class="hb_inner">
                                    <table border="0" cellpadding="0" cellspacing="0" width="100%">
                                    <tr>
                                        <td>
                                            <div class="block_header_title">{lang code="measurementslist.catalog.title" ucf=true}</div>
                                        </td>
                                        <td>
                                            <div class="block_header_title" style="text-align: right;"><span class="red_color" id="ListMessage"></span></div>
                                        </td>
                                    </tr>
                                    </table>
                                    <div class="tb_line_ico">
                                        <table class="item_ico">
                                            <tr>
                                                <td>
                                                    <a href="javascript:RADMeasuremant.addClick();">
                                                        <img src="{url type="image" module="core" preset="original" file="backend/add.png"}" width="30" height="30" border="0" alt="{lang code='-add' htmlchars=true}" title="{lang code='-add' htmlchars=true}" />
                                                        <span class="text" style="width:50px;">{lang code='-add'}</span>
                                                    </a>
                                                </td>
                                            </tr>
                                        </table>
                                        <table class="item_ico">
                                            <tr>
                                                <td>
                                                    <a href="javascript:RADMeasuremant.refreshItems();">
                                                        <img src="{url type="image" module="core" preset="original" file="backend/arrow_rotate_clockwise.png"}" width="30" height="30" border="0" alt="{lang code='-refresh' htmlchars=true}" title="{lang code='-refresh' htmlchars=true}" />
                                                        <span class="text" style="width:50px;">{lang code='-refresh'}</span>
                                                    </a>
                                                </td>
                                            </tr>
                                        </table>
                                        <div class="clear_rt"></div>
                                    </div>
                                </div>
                            </div>
                        </td>
                        <td class="right_border"></td>
                    </tr>
                    <tr>
                        <td class="left_border" nowrap="nowrap" style="width:3px;"></td>
                        <td align="left" id="panel_itemslist">
                            {$smarty.capture.mesaurements_items}
                        </td>
                        <td class="right_border" style="width:3px;" nowrap="nowrap"></td>
                    </tr>
                    <tr>
                        <td class="left_border"></td>
                        <td class="gray_line">

                        </td>
                        <td class="right_border"></td>
                    </tr>
                    <tr>
                        <td class="corner_lb"></td>
                        <td class="tb_bottom"></td>
                        <td class="corner_rb"></td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
 </div>
</div>
{else}
    {if $action eq 'getjs'}
var SITE_URL = '{const SITE_URL}';
var SITE_ALIAS = '{const SITE_ALIAS}';
var PAGE_URL = '{url href="alias=SITE_ALIAS"}';
var LOADING_TEXT = "{lang code="-loading" ucf=true htmlchars=true}";
var DONE_MESSAGE = "{lang code="-done" ucf=true htmlchars=true}";
var CONFIRM_DELETE_MS = "{lang code="askdeletemeasuremant.catalog.query" htmlchars=true}";
var HASH = '{$hash}';
var ADD_MEASUREMANT_TITLE = "{lang code="addmeasuremant.catalog.title" htmlchars=true}";
{literal}
RADMeasuremant = {
    'addClick': function(i)
    {
        $('ListMessage').set('html',LOADING_TEXT);
        var URL = PAGE_URL+'a/'+(i?'editw/':'addw/');
        var data = {};
        if(i)
            data.i = i;
        var req = new Request({
            url: URL,
            data: data,
            onSuccess: function(txt){
                if($('addMesWindow')){
                    $('addMesWindow').destroy();
                }
                if(!$('addMesWindow')){
                   var wheight = Window.getHeight();
                   if(wheight>250){
                       wheight = 250;
                   }
                   wheight = wheight-50;
                   var wnd = new dWindow({
                       id:'addMesWindow',
                       content: txt,
                       width: 350,
                       height: wheight,
                       minWidth: 180,
                       minHeight: 160,
                       left: 350,
                       top: 100,
                       title: ADD_MEASUREMANT_TITLE
                   }).open($(document.body));
                   $('ms_value').focus();
                }
                RADMeasuremant.message(DONE_MESSAGE);
            }
        }).send();;
    },
    'save': function()
    {
        var req = new Request({
            url: PAGE_URL+'a/addw/',
            data: $('addForm').toQueryString(),
            onSuccess: function(txt){
                if($('addMesWindow')){
                    $('addMesWindow').destroy();
                }
                RADMeasuremant.refreshItems();
            }
        }).send();
    },
    'deleteMS': function(i)
    {
        if( confirm(CONFIRM_DELETE_MS+' "'+$('ms_val_'+i).get('html')+'" ?') ){
            $('ListMessage').set('html',LOADING_TEXT);
            var req = new Request({
                url: PAGE_URL+'a/d/',
                data: {i:i,'hash':HASH},
                onSuccess: function(txt){
                    RADMeasuremant.refreshItems();
                    RADMeasuremant.message(DONE_MESSAGE);
                }
            }).send();
        }
    },
    'editClick': function(i)
    {
        RADMeasuremant.addClick(i);
    },
    'refreshItems': function()
    {
        $('ListMessage').set('html',LOADING_TEXT);
        var req = new Request({
            url: PAGE_URL+'a/l/',
            onSuccess: function(txt){
                $('panel_itemslist').set('html',txt);
                RADMeasuremant.message(DONE_MESSAGE);
            }
        }).send();
    },
    message: function(message)
    {
        $('ListMessage').set('html',message);
        setTimeout("$('ListMessage').set('html','');",5000);
    }
}
window.onload = function(){
    RADMeasuremant.refreshItems();
    RADCHLangs.addContainer('RADMeasuremant.refreshItems');
};
{/literal}
    {elseif ($action eq 'addw' or $action eq 'editw') and empty($showItems)}
        <form id="addForm" onSubmit="RADMeasuremant.save();return false;">
            {if $item->ms_id}
                <input type="hidden" name="i" value="{$item->ms_id}" />
            {else}
                <input type="hidden" name="adda" value="add" />
            {/if}
            <input type="hidden" name="hash" value="{$hash}" />
            <table cellpadding="0" cellspacing="0" border="0" width="100%">
                <tr>
                    <td>
                        {lang code='measurementname.catalog.text' ucf=true}
                    </td>
                    <td>
                        <input type="text" maxlength="100" value="{$item->ms_value|replace:'"':'&quot;'}" name="ms_value" id="ms_value" />
                    </td>
                </tr>
                <tr>
                    <td>
                        {lang code='measurementposition.catalog.text' ucf=true}
                    </td>
                    <td>
                        <input type="text" name="ms_position" value="{$item->ms_position}" />
                    </td>
                </tr>
                <tr>
                    <td colspan="2" align="center">
                        <input type="submit" value="{lang code='-submit' htmlchars=true}" />
                        &nbsp;
                        <input type="button" value="{lang code='-cancel' htmlchars=true}" onclick="{literal}if($('addMesWindow')){$('addMesWindow').destroy();}{/literal}" />
                    </td>
                </tr>
            </table>
        </form>
    {elseif ($action eq 'addw' and !empty($showItems)) or $action eq 'l'}
        {$smarty.capture.mesaurements_items}
    {/if}
{/if}
{/strip}