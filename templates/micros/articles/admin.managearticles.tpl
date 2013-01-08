{strip}
{if !isset($action)}
<div class="w100">
    <div class="kord_right_col">
        {include file="$_CURRENT_LOAD_PATH/admin.managearticles/panels/getpanels.tpl"}
    </div>
</div>
{else}
    {if $action eq 'getjs'}
        {include file="$_CURRENT_LOAD_PATH/admin.managearticles/js/getjs.tpl"}
    {elseif $action eq 'getjs_editform'}
        {include file="$_CURRENT_LOAD_PATH/admin.managearticles/js/getjs_editform.tpl"}
    {elseif $action eq 'edit'}
        {include file="$_CURRENT_LOAD_PATH/admin.managearticles/panels/edit.tpl"}
    {elseif $action eq 'getarticles'}
        {include file="$_CURRENT_LOAD_PATH/admin.managearticles/panels/getarticles.tpl"}
    {elseif $action eq 'editform'}
<div class="w100">
    <div class="kord_right_col">
        {include file="$_CURRENT_LOAD_PATH/admin.managearticles/panels/editform.tpl"}
    </div>
</div>
    {elseif $action eq 'addpages' or $action eq 'editpages'}
        {*include file="$_CURRENT_LOAD_PATH/admin.managearticles/panels/addarticleform.tpl"*}
    {/if}
{/if}
{/strip}