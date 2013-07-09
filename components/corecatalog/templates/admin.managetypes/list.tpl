{strip}
{if !isset($items) or !count($items)}
    {lang code='hasnotypevalues.catalog.text'}
{else}
     <table cellpadding="0" cellspacing="0" border="0" width="0"  class="tb_list" id="tb_list" width="100%" style="width:100%;">
        <tr class="header">
            <td width="35%">
                {lang code='fieldname.catalog.text' ucf=true}
            </td>
            <td width="15%">
                {lang code='measurement.catalog.text' ucf=true}
            </td>
            <td width="20%">
                {lang code='inputtype.catalog.text' ucf=true}
            </td>
            <td width="20%">
                {lang code='outputtype.catalog.text' ucf=true}
            </td>
            <td width="10%">
                {lang code='-action' ucf=true}
            </td>
        </tr>
     {foreach from=$items item=item}
        <tr>
            <td>
                {$item->vl_name}
            </td>
            <td>
                {assign var="ms_value" value=$item->ms_value}
                {$ms_value->ms_value}
            </td>
            <td>
                {assign var="vl_type_in" value=$item->vl_type_in}
                {lang code="$vl_type_in.catalog.text"}
            </td>
            <td>
                {assign var="vl_type_print" value=$item->vl_type_print}
                {lang code="$vl_type_print.catalog.text"}
            </td>
            <td>
                <a href="javascript:RADCatTypesAction.addEditNewType('{$item->vl_tre_id}','{$item->vl_id}');"><img src="{url type="image" module="core" preset="original" file="backend/billiard_marker.png"}" alt="{lang code='-edit'}" title="{lang code='-edit'}" border="0" /></a><a href="javascript:RADCatTypesAction.delType('{$item->vl_id}','{$item->vl_tre_id}','{$item->vl_name}');"><img src="{url type="image" module="core" preset="original" file="backend/icons/cross.png"}" alt="{lang code='-delete' ucf=true}" title="{lang code='-delete' ucf=true}" border="0" /></a>
            </td>
        </tr>
     {/foreach}
     </table>
{/if}
{/strip}