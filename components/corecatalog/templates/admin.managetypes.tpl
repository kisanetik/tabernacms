{strip}
{if isset($action)}
    {if $action eq 'getjs'}
        {include file="$_CURRENT_LOAD_PATH/admin.managetypes/js/getjs.mootree.tpl"}
    {elseif $action eq 'editnode'}
        {include file="$_CURRENT_LOAD_PATH/admin.managetypes/edit.tpl"}
    {elseif $action eq 'showlist'}
        {include file="$_CURRENT_LOAD_PATH/admin.managetypes/list.tpl"}
    {elseif $action eq 'gettreetypeaction'}
        {include file="$_CURRENT_LOAD_PATH/admin.managetypes/js/TreeTypeAction.tpl"}
    {elseif $action eq 'addfieldform'}
        {include file="$_CURRENT_LOAD_PATH/admin.managetypes/addfield.tpl"}
    {/if}
{else}
<div class="w100">
    <div class="kord_right_col">
        {include file="$_CURRENT_LOAD_PATH/admin.managetypes/tree.tpl"}
    </div>
</div>
{/if}
{/strip}