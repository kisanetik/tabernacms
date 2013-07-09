{strip}
{if !isset($action)}
<div class="w100">
    <div class="kord_right_col">
        {include file="$_CURRENT_LOAD_PATH/admin.manageusers/panels/getpanels.tpl"}
    </div>
</div>
{else}
    {if $action eq 'saveparam'}{elseif $action eq 'getjs'}
        {include file="$_CURRENT_LOAD_PATH/admin.manageusers/js/getjs.tpl"}
    {elseif $action=='add' or $action=='edit'}
        {include file="$_CURRENT_LOAD_PATH/admin.manageusers/edit.tpl"}
    {elseif $action eq 'getusers'}
        {include file="$_CURRENT_LOAD_PATH/admin.manageusers/panels/getusers.tpl"}
    {elseif $action eq 'editform'}
        {include file="$_CURRENT_LOAD_PATH/admin.manageusers/panels/editform.tpl"}
    {elseif $action eq 'adduser' or $action eq 'edituser'}
        {include file="$_CURRENT_LOAD_PATH/admin.manageusers/panels/adduserform.tpl"}
    {/if}
{/if}
{/strip}