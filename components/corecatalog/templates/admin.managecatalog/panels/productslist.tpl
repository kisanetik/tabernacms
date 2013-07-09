{strip}
<table cellpadding="0" cellspacing="0" border="0" width="100%" id="tb_list" class="tb_list">
{if !empty($items)}
<tr class="header">
    <td>
        A
    </td>
    {if $params->showimages}
    <td>
        {lang code='image.catalog.title' ucf=true}
    </td>
    {/if}
    <td width="100%">
        {lang code='productname.catalog.title' ucf=true}
    </td>
    <td>
        {lang code='cost.catalog.title' ucf=true}
    </td>
    <td>
        {lang code='currencyonename.catalog.text' ucf=true}
    </td>
    <td>
        {lang code='producttype.catalog.title' ucf=true}
    </td>
    <td>
        {lang code='productordering.catalog.title' ucf=true}
    </td>
    <td nowrap="nowrap">
        {lang code='-action' ucf=true}
    </td>
</tr>
{foreach from=$items item=item}
<tr>
    <td>
        <a id="active_cat_link_{$item->cat_id}_1" href="javascript:RADCatalogList.setActive(0,{$item->cat_id});" {if !$item->cat_active} style="display:none;"{/if}><img id="img_active_cat_{$item->cat_id}" src="{url type="image" module="core" preset="original" file="actions/activeround.gif"}" border="0" alt="{lang code='-turnoff' ucf=true|replace:'"':'&quot;'}" title="{lang code='-turnoff' ucf=true|replace:'"':'&quot;'}" /></a>
        <a id="active_cat_link_{$item->cat_id}_0" href="javascript:RADCatalogList.setActive(1,{$item->cat_id});" {if $item->cat_active} style="display:none;"{/if}><img id="img_active_cat_{$item->cat_id}" src="{url type="image" module="core" preset="original" file="actions/notactiveround.gif"}" border="0" alt="{lang code='-turnon' ucf=true|replace:'"':'&quot;'}" title="{lang code='-turnon' ucf=true|replace:'"':'&quot;'}" /></a>
    </td>
{if $params->showimages}
    <td>
        {if !empty($item->img_filename)}
        <a href="{url module="corecatalog" file="`$item->img_filename`" type="image" preset="box_large"}" target="_blank"><img src="{url module="corecatalog" file="`$item->img_filename`" type="image" preset="thumb_v"}" border="0" alt="{$item->cat_name|replace:'"':'&quot;'}" title="{$item->cat_name|replace:'"':'&quot;'}" /></a>
        {else}
            {lang code="-no"}
        {/if}
    </td>
{/if}
    <td>
        {$item->cat_name}
    </td>
    <td nowrap="nowrap">
        <input type="text" style="width:60px;" onblur="RADCatalogList.changeCost({$item->cat_id});" id="cat_cost_{$item->cat_id}" value="{$item->cat_cost}" />
    </td>
    <td nowrap="nowrap">
        <select name="currency_cat_{$item->cat_id}" id="currency_cat_{$item->cat_id}" onchange="RADCatalogList.changeCurrency({$item->cat_id});">
            {foreach from=$currencys item=currency}
                <option value="{$currency->cur_id}"{if $currency->cur_id eq $item->cat_currency_id} selected="selected" {/if}>{$currency->cur_name}</option>
            {/foreach}
        </select>
    </td>
    <td nowrap="nowrap">
        {$item->cat_ct_name}
    </td>
    <td>
        <input style="width:30px;" type="text" id="cat_position_{$item->cat_id}" value="{$item->cat_position}" onblur="RADCatalogList.changeOrder({$item->cat_id});" />
    </td>
    <td nowrap="nowrap">
        {* //TODO replace aliasname to dynamicly aliasname *}
        <a href="{url href="alias=CATmanageCatalog&action=editform&cat_id=`$item->cat_id`"}">
            <img src="{url type="image" module="core" preset="original" file="backend/billiard_marker.png"}" alt="{lang code='-edit' ucf=true}" title="{lang code='-edit' ucf=true}" border="0" />
        </a>
        <a href="javascript:RADCatalogList.deleteRow({$item->cat_id})">
            <img src="{url type="image" module="core" preset="original" file="backend/icons/cross.png"}" alt="{lang code='-delete' ucf=true}" title="{lang code='-delete' ucf=true}" border="0" />
        </a>
    </td>
</tr>
{/foreach}
{else}
<tr><td align="center" width="100%">
{lang code='norecords.catalog.text' ucf=true}
</td></tr>
{/if}
</table>
{/strip}