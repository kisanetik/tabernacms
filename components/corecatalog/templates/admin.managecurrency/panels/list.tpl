{strip}
<form method="post" id="CurrencyListForm">
<input type="hidden" name="hash" id="hash" value="{$hash|default:''}">
<table cellpadding="0" cellspacing="0" border="0" width="100%" id="tb_list" class="tb_list">
{if count($items)}
<tr class="header">
    <td>
        {lang code='currencyname.catalog.text' ucf=true}
    </td>
    <td>
        {lang code='currencyshortname.catalog.text' ucf=true}
    </td>
    <td>
        {lang code='currencyindicator.catalog.text' ucf=true}
    </td>
    <td>
        {lang code='currencycost.catalog.text' ucf=true}
    </td>
    <td>
        {lang code='currencyposition.catalog.text' ucf=true}
    </td>
    <td>
        {lang code='currencyshowcurs.catalog.text' ucf=true}
    </td>
    <td>
        {lang code='currencyshowsite.catalog.text' ucf=true}
    </td>
    <td>
        {lang code='currencydefaultsite.catalog.text' ucf=true}
    </td>
    <td>
        {lang code='currencydefaultadmin.catalog.text' ucf=true}
    </td>
    <td>
        {lang code='-action' ucf=true}
    </td>
</tr>
{foreach from=$items item=item}
    {if !is_array( $item->cur_name )}
        {assign var=curname value="`$item->cur_name`"}
    {else}
        {assign var=curname value=""}
    {/if}

<tr>
    <td>
        {$curname}
    </td>
    <td>
        {$item->cur_shortname}
    </td>
    <td>
        {$item->cur_ind}
    </td>
    <td>
        <input type="text" name="cur_cost[{$item->cur_id}]" value="{$item->cur_cost}" style="width:50px;" />
    </td>
    <td>
        <input type="text" name="cur_position[{$item->cur_id}]" value="{$item->cur_position}" style="width:40px;" />
    </td>
    <td>
        <input type="checkbox" name="cur_showcurs[{$item->cur_id}]"{if $item->cur_showcurs} checked="checked"{/if} />
    </td>
    <td>
        <input type="checkbox" name="cur_show_site[{$item->cur_id}]"{if $item->cur_show_site} checked="checked"{/if} />
    </td>
    <td>
        <input type="radio" value="{$item->cur_id}" name="default_site"{if $item->cur_default_site} checked="checked"{/if} />
    </td>
    <td>
        <input type="radio" value="{$item->cur_id}" name="default_admin"{if $item->cur_default_admin} checked="checked"{/if} />
    </td>
    <td>
        <a href="javascript:RADCurrency.editClick({$item->cur_id})">
            <img src="{url type="image" module="core" preset="original" file="backend/billiard_marker.png"}" border="0" alt="{lang code='-edit' ucf=true htmlchars=true} {$curname}" title="{lang code='-edit' ucf=true htmlchars=true} {$curname}" />
        </a>
        {if count($items) > 1}
        &nbsp;&nbsp;
        <a href="javascript:RADCurrency.deleteClick({$item->cur_id},'{$item->cur_name}')">
            <img src="{url type="image" module="core" preset="original" file="backend/icons/cross.png"}" border="0" alt="{lang code='-delete' ucf=true htmlchars=true} {$curname}" title="{lang code='-delete' ucf=true htmlchars=true} {$curname}" />
        </a>
        {/if}
    </td>
</tr>
{/foreach}
{else}
<tr>
    <td align="center">
        {lang code='norecords.catalog.text' ucf=true}
    </td>
</tr>
{/if}
</table>
</form>
{/strip}