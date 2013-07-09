{strip}
{if !isset($action) or $action eq 'send'}
    {include file="$_CURRENT_LOAD_PATH/admin.managesubscribes/panels/getpanels.tpl"}
{else}
    {if $action eq 'getjs'}
        {include file="$_CURRENT_LOAD_PATH/admin.managesubscribes/js/getjs.tpl"}
    {/if}
{/if}
{/strip}

