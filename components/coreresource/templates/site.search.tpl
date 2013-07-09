{strip}
    {if isset($action) && $action == 'autocomplete'}
        {$autocomplete_json}
    {else}
        {include file="$_CURRENT_LOAD_PATH/site.search/search_results.tpl"}
    {/if}
{/strip}