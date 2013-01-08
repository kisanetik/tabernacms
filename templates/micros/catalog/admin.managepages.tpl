{strip}
{if !isset($action)}
<div class="w100">
    <div class="kord_right_col">
        {include file="$_CURRENT_LOAD_PATH/admin.managepages/panels/getpanels.tpl"}
    </div>
</div>
{else}
    {if $action eq 'getjs'}
        {include file="$_CURRENT_LOAD_PATH/admin.managepages/js/getjs.tpl"}
    {elseif $action eq 'getjs_editform'}
        {include file="$_CURRENT_LOAD_PATH/admin.managepages/js/getjs_editform.tpl"}
    {elseif $action eq 'edit'}
        {include file="$_CURRENT_LOAD_PATH/admin.managepages/panels/edit.tpl"}
    {elseif $action eq 'getpages'}
        {include file="$_CURRENT_LOAD_PATH/admin.managepages/panels/getpages.tpl"}
    {elseif $action eq 'editform'}
<div class="w100">
    <div class="kord_right_col">
        {include file="$_CURRENT_LOAD_PATH/admin.managepages/panels/editform.tpl"}
    </div>
</div>
    {elseif $action eq 'addpages' or $action eq 'editpages'}
        {include file="$_CURRENT_LOAD_PATH/admin.managepages/panels/addpagesform.tpl"}
    {/if}
{/if}
{/strip}