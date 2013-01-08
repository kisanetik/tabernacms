{strip}
<form id="adduser_form" method="post">
<input type="hidden" id="hash" name="hash" value="{$hash|default:''}" />
{if $item->u_id}
<input type="hidden" name="u_id" value="{$item->u_id}" />
{/if}
<table cellpadding="3" cellspacing="0" border="0" width="100%">
    {if $item->u_id}
    <tr>
        <td width="5%">ID</td>
        <td align="left" width="95%">{$item->u_id}</td>
    </tr>
    {/if}
    <tr>
        <td width="5%">{lang code="login.session.text"}</td>
        <td align="left"><input name="u_login" id="u_login" value="{$item->u_login}" /></td>
    </tr>
    <tr>
        <td>{lang code="email.system.text"}({lang code="-login"})</td>
        <td align="left"><input type="text" name="u_email" id="u_email" value="{$item->u_email}" /></td>
    </tr>
    {if $item->u_id}
    <tr>
        <td colspan="2"><a href="javascript:RADUsers.changePass({$item->u_id});">{lang code="changepassword.system.link" ucf=true}</a></td>
    </tr>
    {else}
    <tr>
        <td>{lang code="password.system.text"}</td>
        <td align="left"><input type="password" name="u_pass" id="u_pass" /></td>
    </tr>
    <tr>
        <td>{lang code="password.system.text"}({lang code="-confirm"})</td>
        <td align="left"><input type="password" name="u_pass1" id="u_pass1" /></td>
    </tr>
    {/if}
    <tr>
        <td>{lang code="access.system.text"}</td>
        <td align="left"><input type="text" name="u_access" id="u_access" value="{$item->u_access}" /></td>
    </tr>
    <tr>
        <td>{lang code="-active"}</td>
        <td align="left" nowrap="nowrap"><input type="radio" name="u_active" id="u_active_yes" value="1"{if $item->u_active>0} checked="checked"{/if} /><label for="u_active_yes">{lang code="-yes"}</label>&nbsp;<input type="radio" name="u_active" id="u_active_no" value="0" {if $item->u_active=='0'}checked="checked" {/if}/><label for="u_active_no">{lang code="-no"}</label></td>
    </tr>
    <tr>
        <td>{lang code="isadmin.system.text"}</td>
        <td align="left"><input type="radio" name="is_admin" id="is_admin_yes" value="1"{if $item->is_admin>0} checked="checked"{/if} /><label for="is_admin_yes">{lang code="-yes"}</label>&nbsp;<input type="radio" name="is_admin" id="is_admin_no" value="0" {if $item->is_admin==0}checked="checked" {/if}/><label for="is_admin_no">{lang code="-no"}</label></td>
    </tr>
    <tr>
        <td>{lang code="usergroup.system.text"}</td>
        <td align="left">
            <select name="u_group" id="u_group">
                {include file="`$_CURRENT_LOAD_PATH`/../menus/admin.managetree/tree_recursy.tpl" element=$parents selected=$selected nbsp=0}
            </select>
        </td>
    </tr>
    <tr>
        <td align="center" colspan="2"><input type="button" value="{lang code='-submit'}" onclick="RADUsers.submitClick();" />&nbsp;<input type="button" value="{lang code='-cancel'}" onclick="RADUsers.cancelClick();" /></td>
    </tr>
</table>
</form>
{/strip}