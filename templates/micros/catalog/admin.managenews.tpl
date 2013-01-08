{strip}
{if !isset($action)}
<div class="w100">
    <div class="kord_right_col">
        {include file="$_CURRENT_LOAD_PATH/admin.managenews/panels/getpanels.tpl"}
    </div>
</div>
{else}
    {if $action eq 'getjs'}
        {include file="$_CURRENT_LOAD_PATH/admin.managenews/js/getjs.tpl"}
    {elseif $action eq 'getjs_editform'}
        {include file="$_CURRENT_LOAD_PATH/admin.managenews/js/getjs_editform.tpl"}
    {elseif $action eq 'edit'}
        {include file="$_CURRENT_LOAD_PATH/admin.managenews/panels/edit.tpl"}
    {elseif $action eq 'getnews'}
        {include file="$_CURRENT_LOAD_PATH/admin.managenews/panels/getnews.tpl"}
    {elseif $action eq 'editform'}
<div class="w100">
    <div class="kord_right_col">
        {include file="$_CURRENT_LOAD_PATH/admin.managenews/panels/editform.tpl"}
    </div>
</div>
    {elseif $action eq 'addnews' or $action eq 'editnews'}
        {include file="$_CURRENT_LOAD_PATH/admin.managenews/panels/addnewsform.tpl"}
    {/if}
{/if}
{/strip}