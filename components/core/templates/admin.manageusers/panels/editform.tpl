{strip}
<div align="center">
<form id="editTreeForm" method="post">
<input type="hidden" name="tre_pid" id="tre_pid" value="{$item->tre_pid}">
<input type="hidden" name="hash" id="hash" value="{$hash|default:''}">
<table cellpadding="0" cellspacing="3" border="0" width="100%">
    <tr>
        <td width="10%" nowrap="nowrap">
            {lang code="treename.menus.text" ucf=true}
        </td>
        <td align="left">
            <input type="text" id="treename" name="tre_name" value="{$item->tre_name}" />
        </td>
    </tr>
    <tr>
        <td nowrap="nowrap">
            {lang code="treeurl.menus.text"}
        </td>
        <td align="left">
            <input type="text" id="treeurl" name="tre_url" value="{$item->tre_url}" />
        </td>
    </tr>
    <tr>
        <td nowrap="nowrap">
            {lang code="treeposition.menus.text" ucf=true}
        </td>
        <td align="left">
            <input type="text" id="treeposition" name="tre_position" value="{$item->tre_position}" />
        </td>
    </tr>
    <tr>
        <td nowrap="nowrap">
            {lang code="-active" ucf=true}
        </td>
        <td align="left">
            <input type="radio" name="tre_active" id="treeactive_yes" value="1"{if $item->tre_active} checked="checked"{/if} /><label for="treeactive_yes">{lang code="-yes"}</label>
            <input type="radio" name="tre_active" id="treeactive_no" value="0"{if !$item->tre_active} checked="checked"{/if} /><label for="treeactive_no">{lang code="-no"}</label>
        </td>
    </tr>
    <tr>
        <td>
            {lang code="parent.menus.text" ucf=true}
        </td>
        <td align="left">
            <select id="tre_pid" name="tre_pid">
                {if isset($parents) and count($parents)}
                    {radinclude module="coremenus" file="admin.managetree/tree_recursy.tpl" element=$parents selected=$item->tre_pid nbsp=0}
                {/if}
            </select>
        </td>
    </tr>
    <tr>
        <td>
            {lang code="-access" ucf=true}
        </td>
        <td align="left">
            <input type="text" name="tre_access" value="{$item->tre_access}" id="tre_access" />
        </td>
    </tr>
</table>
</form>
</div>
{/strip}