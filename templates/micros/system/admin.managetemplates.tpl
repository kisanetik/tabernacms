{if isset($action)}
    {if $action eq 'getjs'}
        {include file="$_CURRENT_LOAD_PATH/admin.managetemplates/js/getjs.tpl"}
    {elseif $action eq 'editnode'}
        {include file="$_CURRENT_LOAD_PATH/admin.managetemplates/panels/edit_folder.tpl"}
    {elseif $action eq 'editfile'}
        {include file="$_CURRENT_LOAD_PATH/admin.managetemplates/panels/edit_file.tpl"}
    {/if}
{else}
    {include file="$_CURRENT_LOAD_PATH/admin.managetemplates/panels/getpanels.tpl"}
{/if}