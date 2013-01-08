{strip}
{if count($items)}
<table cellpadding="0" cellspacing="0" border="0" class="tb_list" id="tb_list" width="100%">
    <tr class="header">
        <td>A</td>
        <td>ID</td>
        <td>{lang code="pagestitle.catalog.title" ucf=true}</td>
        <td>{lang code="pagesimage.catalog.title" ucf=true}</td>
        <td>{lang code="pagesdate.catalog.title" ucf=true}</td>
        <td>{lang code="pagesshowinlist.catalog.title" ucf=true}</td>
        <td>{lang code="-action" ucf=true}</td>
    </tr>
    {foreach from=$items item=item}
    <tr>
        <td>
            <a id="active_pages_link_{$item->pg_id}_1" href="javascript:RADPages.setActive(0,{$item->pg_id});" {if !$item->pg_active} style="display:none;"{/if}><img id="img_active_pages_{$item->pg_id}" src="{const SITE_URL}img/actions/activeround.gif" border="0" alt="{lang code='-turnoff' ucf=true}" title="{lang code='-turnoff' ucf=true}" /></a>
            <a id="active_pages_link_{$item->pg_id}_0" href="javascript:RADPages.setActive(1,{$item->pg_id});" {if $item->pg_active} style="display:none;"{/if}><img id="img_active_pages_{$item->pg_id}" src="{const SITE_URL}img/actions/notactiveround.gif" border="0" alt="{lang code='-turnon' ucf=true}" title="{lang code='-turnon' ucf=true}" /></a>
        </td>
        <td>{$item->pg_id}</td>
        <td>{$item->pg_title}</td>
        <td>{if strlen($item->pg_img)}<img src="{const SITE_URL}image.php?f={$item->pg_img}&w=60&h=30&m=pages" alt="{$item->pg_title}" title="{$item->pg_title}" border="0" />{else}{lang code="-no" ucf=true}{/if}</td>
        <td>{$item->pg_datecreated}</td>
        <td>{if $item->pg_showlist}{lang code="-yes" ucf=true}{else}{lang code="-no" ucf=true}{/if}</td>
        <td><a href="javascript:RADPages.editRow({$item->pg_id});"><img src="{const SITE_URL}img/backend/billiard_marker.png" alt="{lang code='-edit' ucf=true}" title="{lang code='-edit' ucf=true}" border="0" /></a><a href="javascript:RADPages.deleteRow({$item->pg_id});"><img src="{const SITE_URL}img/backend/icons/cross.png" alt="{lang code="-delete"}" title="{lang code="-delete"}" border="0" /></a></td>
    </tr>
    {/foreach}
</table>
{else}
<div align="center">{lang code="norecords.catalog.text"}</div>
{/if}
{/strip}