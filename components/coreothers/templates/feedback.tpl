{strip}
    {if isset($action)}
        {switch $action}
        {case 'callback'}
            {include file="$_CURRENT_LOAD_PATH/feedback/callback.tpl"}
        {/case}
        {default}
            {include file="$_CURRENT_LOAD_PATH/feedback/feedback.tpl"}
        {/switch}
    {else}
        {include file="$_CURRENT_LOAD_PATH/feedback/feedback.tpl"}
    {/if}
{/strip}