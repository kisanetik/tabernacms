{strip}
{if !isset($action)}
<div class="w100">
    <div class="kord_right_col">
        {include file="$_CURRENT_LOAD_PATH/admin.managedelivery/panels/getpanels.tpl"}
    </div>
</div>
{else}
    {if $action eq 'getjs'}
        {include file="$_CURRENT_LOAD_PATH/admin.managedelivery/js/getjs.tpl"}
    {elseif $action eq 'addedit'}
        {include file="$_CURRENT_LOAD_PATH/admin.managedelivery/panels/addwindow.tpl"}
    {elseif $action eq 'getitems'}
        {include file="$_CURRENT_LOAD_PATH/admin.managedelivery/panels/itemslist.tpl"}
    {/if}
{/if}
{/strip}