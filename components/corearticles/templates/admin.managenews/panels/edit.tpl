{strip}
<form id="editnode_form" method="post">
<input type="hidden" name="tre_id" id="tre_id" value="{$item->tre_id}" />
<input type="hidden" name="tre_access" id="tre_access" value="{$item->tre_access}" />
<input type="hidden" name="hash" id="hash" value="{$hash|default:''}" />
<table cellpadding="3" cellspacing="0" border="0" width="100%">
    <tr>
        <td width="10%" nowrap="nowrap">{lang code="treename.catalog.text" ucf=true}</td>
        <td align="left"><input type="text" name="tre_name" id="tre_name" value="{$item->tre_name}" /></td>
    </tr>
    <tr>
        <td nowrap="nowrap">
            {lang code="treeposition.catalog.text" ucf=true}
        </td>
        <td align="left"><input type="text" name="tre_position" id="tre_position" value="{$item->tre_position}" /></td>
    </tr>
    <tr>
        <td nowrap="nowrap">
            {lang code="-active" ucf=true}
        </td>
        <td align="left">
            <input type="radio" name="tre_active" value="1" id="tre_active_yes"{if $item->tre_active} checked="checked"{/if} /><label for="tre_active_yes">{lang code="-yes"}</label><input type="radio" name="tre_active" value="0" id="tre_active_no"{if !$item->tre_active} checked="checked"{/if} /><label for="tre_active_no">{lang code="-no"}</label>
        </td>
    </tr>
    <tr>
        <td>
            {lang code="parent.menus.text" ucf=true}
        </td>
        <td align="left">
            <select id="tre_pid" name="tre_pid">
                {if isset($parents) and count($parents)}
                    {radinclude module="coremenus" file="admin.managetree/tree_recursy.tpl" element=$parents selected=$item->tre_pid nbsp=0 selected_id=$item->tre_id}
                {/if}
            </select>
        </td>
    </tr>
</table>
</form>
{/strip}