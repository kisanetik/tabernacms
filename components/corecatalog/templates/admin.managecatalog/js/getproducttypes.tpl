{strip}
{if count($items)}
<table cellpadding="0" cellspacing="3" border="0">
    {foreach from=$items item=item}
    <tr>
        <td width="15%">
            {$item->vl_name}
        </td>
        <td width="75%">
            {* Maybe I can write plugin to Smarty for that?! some like {plugin name=CAT value=$item->vl_type_in} function=getHTML param=$item
            or
            {PLUG_STATIC param=$item->"::getHTML("+$item+")"}
            *}
            {*{CAT_EXT_IN_TEXT::getHTML($item)};*}
            {$item->getHTML}
        </td>
        <td align="left" width="10%">
            &nbsp;{$item->ms_value->ms_value}
        </td>
    </tr>
    {/foreach}
</table>
{else}
{lang code='norecords.catalog.text' ucf=true}
{/if}
{/strip}