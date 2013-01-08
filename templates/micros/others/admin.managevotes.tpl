{if !isset($action)}
<div class="w100">
    <div class="kord_right_col">
      {include file="$_CURRENT_LOAD_PATH/admin.managevotes/panels/getpanels.tpl"}
    </div>
</div>
{else}
    {if $action eq 'getjs'}
        {include file="$_CURRENT_LOAD_PATH/admin.managevotes/js/getjs.tpl"}
    {elseif $action eq 'getjs_addedit'}
        {include file="$_CURRENT_LOAD_PATH/admin.managevotes/js/getjs_addedit.tpl"}
    {elseif $action eq 'getitems'}
        {include file="$_CURRENT_LOAD_PATH/admin.managevotes/panels/itemslist.tpl"}
    {elseif $action eq 'edittree'}
        {include file="$_CURRENT_LOAD_PATH/admin.managevotes/panels/edittree.tpl"}
    {elseif $action eq 'editrow' or $action eq 'additem'}
        {include file="$_CURRENT_LOAD_PATH/admin.managevotes/panels/addedit_form.tpl"}
    {elseif $action eq 'listquestions'}
        {include file="$_CURRENT_LOAD_PATH/admin.managevotes/panels/list_subitems.tpl"}
    {elseif $action eq 'editanswerform'}
        {include file="$_CURRENT_LOAD_PATH/admin.managevotes/panels/edit_subrecord.tpl"}
  {/if}
{/if}