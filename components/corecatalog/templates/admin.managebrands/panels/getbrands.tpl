{strip}
{if count($items)}
<table cellpadding="0" cellspacing="0" border="0" class="tb_list" id="tb_list" width="100%">
    <tr class="header">
        <td>ID</td>
        <td>{lang code='brandtitle.catalog.title' ucf=true}</td>
        <td>{lang code='-active'}</td>
        <td>{lang code='-action'}</td>
    </tr>
    {foreach from=$items item=item}
    <tr style="height:42px;">
        <td>{$item->rcb_id}</td>
        <td>{$item->rcb_name}</td>
        <td>{if $item->rcb_active}{lang code='-yes' ucf=true}{else}{lang code='-no' ucf=true}{/if}</td>
        <td>
            <a href="javascript:RADBrand.editRow({$item->rcb_id});">
                <img src="{url type="image" module="core" preset="original" file="backend/billiard_marker.png"}" alt="{lang code='-edit' ucf=true htmlchars=true}" title="{lang code='-edit' ucf=true htmlchars=true}" border="0" />
            </a>
            <a href="javascript:RADBrand.deleteRow({$item->rcb_id});">
                <img src="{url type="image" module="core" preset="original" file="backend/icons/cross.png"}" alt="{lang code='-delete' ucf=true htmlchars=true}" title="{lang code='-delete' ucf=true htmlchars=true}" border="0" />
            </a>
        </td>
    </tr>
    {/foreach}
    <tr>
    {***  PAGING  ****}
    <td colspan="3" align="left" style="text-align:left;" id="td_paging">
        {lang code='page.system.link'}:&nbsp;
        {section name=paginator loop=$pages_count start=1 step=1}
            {if $smarty.section.paginator.index eq $page}
                &nbsp;{$smarty.section.paginator.index}&nbsp;
            {else}
                <a href="javascript:RADBrandTree.paging({$smarty.section.paginator.index});"> {$smarty.section.paginator.index} </a>
            {/if}
        {/section}
    </td>
    <td>{lang code='-total'}:{$total_rows}</td>
    {***  END PAGING  ****}
    </tr>
</table>
{else}
<div align="center">{lang code='norecords.catalog.text' cuf=true}</div>
{/if}
{/strip}