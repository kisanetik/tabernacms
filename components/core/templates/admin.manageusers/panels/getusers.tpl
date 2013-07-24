{strip}
{if count($items)}
<table cellpadding="0" cellspacing="0" border="0" class="tb_list" id="tb_list" width="100%">
    <tr class="header">
        <td>ID</td>
        <td>{lang code='email.system.title'}</td>
        <td>{lang code='access.system.title'}</td>
        <td>{lang code='-active'}</td>
        <td>{lang code='isadmin.system.title'}</td>
        <td>{lang code='-action'}</td>
    </tr>
    {foreach from=$items item=item}
    <tr>
        <td>{$item->u_id}</td>
        <td>{$item->u_email}</td>
        <td>{$item->u_access}</td>
        <td>{if $item->u_active eq '0'}{lang code='-no'}{else}{lang code='-yes'}{/if}</td>
        <td>{if $item->is_admin eq '0'}{lang code='-no'}{else}{lang code='-yes'}{/if}</td>
        <td>
            <a href="javascript:RADUsers.editRow({$item->u_id});">
                <img src="{url type="image" module="core" preset="original" file="backend/billiard_marker.png"}" alt="{lang code='-edit' ucf=true htmlchars=true}" title="{lang code='-edit' ucf=true htmlchars=true}" border="0" />
            </a>
            <a href="javascript:RADUsers.deleteRow({$item->u_id});">
                <img src="{url type="image" module="core" preset="original" file="backend/icons/cross.png"}" alt="{lang code='-delete' ucf=true htmlchars=true}" title="{lang code='-delete' ucf=true htmlchars=true}" border="0" />
            </a>
        </td>
    </tr>
    {/foreach}
</table>
{else}
<div align="center">{lang code='norecords.system.text' ucf=true}</div>
{/if}
{/strip}