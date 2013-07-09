{strip}
<table cellpadding="2" cellspacing="0" border="0" width="100%">
    <tr width="10%">
        <td>ID</td>
        <td>{$item->m_id}</td>
    </tr>
    <tr>
        <td>
            {lang code="modulename.sustem.text" ucf=true}
        </td>
        <td>
            {$item->m_name}
        </td>
    </tr>
    <tr>
        <td>{lang code="fullpath.system.text" ucf=true}</td>
        <td>{const MICROSPATH}{$item->m_name}</td>
    </tr>
</table>
{/strip}