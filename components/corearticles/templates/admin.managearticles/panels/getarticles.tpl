{strip}
{if count($items)}
<table cellpadding="0" cellspacing="0" border="0" class="tb_list" id="tb_list" width="100%">
    <tr class="header">
        <td>A</td>
        <td>{lang code='title.articles.text' ucf=true}</td>
        {if $params->_get('hasimage',false)}<td>{lang code='image.articles.title' ucf=true}</td>{/if}
        <td>{lang code='added.articles.text' ucf=true}</td>
        <td>{lang code='-action'}</td>
    </tr>
    {foreach from=$items item=item}
    <tr>
        <td>
            <a id="active_articles_link_{$item->art_id}_1" href="javascript:RADArticles.setActive(0,{$item->art_id});" {if !$item->art_active} style="display:none;"{/if}><img id="img_active_cat_{$item->art_id}" src="{url type="image" module="core" preset="original" file="actions/activeround.gif"}" border="0" alt="{lang code='-turnoff' htmlchars=true}" title="{lang code='-turnoff' htmlchars=true}" /></a>
            <a id="active_articles_link_{$item->art_id}_0" href="javascript:RADArticles.setActive(1,{$item->art_id});" {if $item->art_active} style="display:none;"{/if}><img id="img_active_cat_{$item->art_id}" src="{url type="image" module="core" preset="original" file="actions/notactiveround.gif"}" border="0" alt="{lang code='-turnon' htmlchars=true}" title="{lang code='-turnon' htmlchars=true}" /></a>
        </td>
        <td>{$item->art_title}</td>
        {if $params->_get('hasimage',false)}
        <td>
            {if isset($item->art_img) and strlen($item->art_img)}
                <img src="{url module="corearticles" file="articles/`$item->art_img`" type="image" preset="article_tiny"}" alt="{$item->art_title|replace:'"':'&quot;'}" title="{$item->art_title|replace:'"':'&quot;'}" border="0" />
            {else}
                &nbsp;
            {/if}
        </td>
        {/if}
        <td>{$item->art_datecreated}</td>
        <td>
            <a href="javascript:RADArticles.editRow({$item->art_id});">
                <img src="{url type="image" module="core" preset="original" file="backend/billiard_marker.png"}" alt="{lang code='-edit' htmlchars=true}" title="{lang code='-edit' htmlchars=true}" border="0" />
            </a>
            <a href="javascript:RADArticles.deleteRow({$item->art_id});">
                <img src="{url type="image" module="core" preset="original" file="backend/icons/cross.png"}" alt="{lang code='-delete' htmlchars=true}" title="{lang code='-delete' htmlchars=true}" border="0" />
            </a>
        </td>
    </tr>
    {/foreach}
</table>
{else}
<div align="center">{lang code='norecords.articles.text' ucf=true}</div>
{/if}
{/strip}