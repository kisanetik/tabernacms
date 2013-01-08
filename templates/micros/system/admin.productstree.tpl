{strip}
{if isset($action) and ($action eq 'openProductsTree')}
    {include file="$_CURRENT_LOAD_PATH/admin.productstree/tree.tpl"}
{/if}
{/strip}