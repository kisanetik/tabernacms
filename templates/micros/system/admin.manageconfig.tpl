{strip}
{if isset($action)}
    {if $action eq 'getjs'} 
        {include file="$_CURRENT_LOAD_PATH/admin.manageconfig/js/getjs.tpl"}
    {elseif $action eq 'save'}
        {include file="$_CURRENT_LOAD_PATH/admin.manageconfig/panels/getpanels.tpl"}
    {/if}
{else}
    {include file="$_CURRENT_LOAD_PATH/admin.manageconfig/panels/getpanels.tpl"}     
{/if}
{/strip}