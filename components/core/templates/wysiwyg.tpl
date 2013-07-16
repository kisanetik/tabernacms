{strip}
{if isset($action)}
    {if $action eq 'getjs'}
        {include file="$_CURRENT_LOAD_PATH/wysiwyg/getjs.tpl"}
    {elseif $action eq 'browse'}
        {include file="$_CURRENT_LOAD_PATH/wysiwyg/browser.tpl"}
    {elseif $action eq 'frmupload'}
        {include file="$_CURRENT_LOAD_PATH/wysiwyg/frmupload.tpl"}
    {elseif $action eq 'frmresourcetype'}
        {include file="$_CURRENT_LOAD_PATH/wysiwyg/frmresourcetype.tpl"}
    {elseif $action eq 'frmfolders'}
        {include file="$_CURRENT_LOAD_PATH/wysiwyg/frmfolders.tpl"}
    {elseif $action eq 'frmactualfolder'}
        {include file="$_CURRENT_LOAD_PATH/wysiwyg/frmactualfolder.tpl"}
    {elseif $action eq 'frmresourceslist'}
        {include file="$_CURRENT_LOAD_PATH/wysiwyg/frmresourceslist.tpl"}
    {elseif $action eq 'frmcreatefolder'}
        {include file="$_CURRENT_LOAD_PATH/wysiwyg/frmcreatefolder.tpl"}
    {/if}
{/if}
{/strip}