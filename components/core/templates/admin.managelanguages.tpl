{strip}
{if isset($action)}
    {if $action eq 'getjs'} 
        {include file="$_CURRENT_LOAD_PATH/admin.managelanguages/js/getjs.tpl"}
    {/if}
    {if $action eq 'showEditNode'}
        {include file="$_CURRENT_LOAD_PATH/admin.managelanguages/panels/tree_edit.tpl"}
    {/if}
    {if $action eq 'addNode'}
    {include file="$_CURRENT_LOAD_PATH/admin.managelanguages/panels/tree_add.tpl"}
        {/if}
    {if $action eq 'editlang'}
        {include file="$_CURRENT_LOAD_PATH/admin.managelanguages/langedit.tpl"}
        {/if}
   {if $action eq 'showlistlang'}
        {include file="$_CURRENT_LOAD_PATH/admin.managelanguages/langlist.tpl"}
    {/if}
    {if $action eq 'showLang' or $action eq 'searchlang'}
        {include file="$_CURRENT_LOAD_PATH/admin.managelanguages/panels/langsvalue.tpl"}    {* value list lang code *}
    {/if}
    {if $action eq 'addLangForm' or $action eq 'editLangForm'}
    {include file="$_CURRENT_LOAD_PATH/admin.managelanguages/panels/addoreditLangForm.tpl"} {* form add lang value *}
    {/if}
    {if $action eq 'uploadform'}
        {include file="$_CURRENT_LOAD_PATH/admin.managelanguages/upload.tpl"}
    {/if}
{else}
<div class="w100">
    <div class="kord_right_col">
      {include file="$_CURRENT_LOAD_PATH/admin.managelanguages/panels/getpanels.tpl"}
    </div>
</div>
{/if}
{/strip}