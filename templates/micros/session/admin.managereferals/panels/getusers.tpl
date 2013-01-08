{strip}
{if !empty($items)}
<table cellpadding="0" cellspacing="0" border="0" width="100%" id="tb_list" class="tb_list">
    <tr class="header">
        <td>{lang code="fio.session.text"}</td>
        <td>{lang code="email.session.text" ucf=true}</td>
        <td>{lang code="count.session.title" ucf=true}</td>
        <td>{lang code="orders.session.title" ucf=true}</td>
    </tr>
    {foreach from=$items item="item"}
    <tr>
        <td>
            <a href="javascript://" id="u_fio" u_id="{$item.u_id}">{$item.u_fio|default:'UNDEFINED'}</a>
        </td>
        <td>
            <a href="javascript://" id="u_email" u_id="{$item.u_id}">{$item.u_email|default:'UNDEFINED'}</a>
        </td>
        <td>
            {$item.refCount}
        </td>
        <td>
            {$item.ordersCount}
        </td>
    </tr>
    {/foreach}
</table>
{else}
    <center>{lang code='norecords.catalog.text' ucf=true}</center>
{/if}
{/strip}