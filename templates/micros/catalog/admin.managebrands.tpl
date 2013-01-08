{strip}
{if !isset($action)}
<div class="w100">
    <div class="kord_right_col">
        {include file="$_CURRENT_LOAD_PATH/admin.managebrands/panels/getpanels.tpl"}
    </div>
</div>
{else}
    {if $action eq 'getjs'}
        {include file="$_CURRENT_LOAD_PATH/admin.managebrands/js/getjs.tpl"}
    {elseif $action eq 'edit'}
        {include file="$_CURRENT_LOAD_PATH/admin.managebrands/panels/edit.tpl"}
    {elseif $action eq 'getbrands'}
        <div id="brandList">
		{include file="$_CURRENT_LOAD_PATH/admin.managebrands/panels/getbrands.tpl"}
		</div>
    {elseif $action eq 'editform'}
<div class="w100">
    <div class="kord_right_col">
        {include file="$_CURRENT_LOAD_PATH/admin.managebrands/panels/editform.tpl"}
    </div>
</div>
    {elseif $action eq 'addbrand' or $action eq 'editbrand'}
        {include file="$_CURRENT_LOAD_PATH/admin.managebrands/panels/addbrandform.tpl"}
    {/if}
{/if}
{/strip}