{strip}
{if !isset($action)}
<div class="w100">
    <div class="kord_right_col">
        {include file="$_CURRENT_LOAD_PATH/admin.manageorders/panels/getpanels.tpl"}
    </div>
</div>
{else}
    {if $action eq 'changestate'}
    {elseif $action eq 'getjs'}
	   {include file="$_CURRENT_LOAD_PATH/admin.manageorders/js/getjs.tpl"}
	{elseif $action eq 'getjs_list'}
	   {include file="$_CURRENT_LOAD_PATH/admin.manageorders/js/getjs_list.tpl"}
	{elseif $action eq 'edit'}
	   {include file="$_CURRENT_LOAD_PATH/admin.manageorders/panels/editform.tpl"}
	{elseif $action eq 'show_order'}
	   {include file="$_CURRENT_LOAD_PATH/admin.manageorders/panels/showorder.tpl"}
	{elseif $action eq 'refresh'}
	   {include file="$_CURRENT_LOAD_PATH/admin.manageorders/panels/orderslist.tpl"}
	{/if}
{/if}
{/strip}