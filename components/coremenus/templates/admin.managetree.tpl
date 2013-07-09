{strip}
{if !isset($action) or ( isset($action) and $action=='list') }
<div class="w100">
    <div class="kord_right_col">
        {include file="$_CURRENT_LOAD_PATH/admin.managetree/tree.tpl"}
    </div>
</div>
{elseif isset($action)}
    {if $action eq 'editform' or $action eq 'addform'}
        {include file="$_CURRENT_LOAD_PATH/admin.managetree/treeedit.tpl"}
    {elseif $action eq 'edit'}
        {include file="$_CURRENT_LOAD_PATH/admin.managetree/treeedit.tpl"}
    {elseif $action eq 'showuploadform' or $action eq 'uploadfile'}
        {include file="$_CURRENT_LOAD_PATH/admin.managetree/treeupload.tpl"}
    {elseif $action eq 'getjs'}
        {include file="$_CURRENT_LOAD_PATH/admin.managetree/getjs.tpl"}
    {elseif $action eq 'detailedit'}
       {include file="$_CURRENT_LOAD_PATH/admin.managetree/detail_edit.tpl"}
    {elseif $action eq 'getjs_detail'}
       {include file="$_CURRENT_LOAD_PATH/admin.managetree/detail_js.tpl"}
    {/if}
{else}
{/if}
{/strip}