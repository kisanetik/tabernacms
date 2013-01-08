{strip}
<form method="post" id="addFieldForm" onsubmit="RADCatTypesAction.TypeAddFieldWindowSubmitClick();return false;">
<input type="hidden" name="vl_tre_id" value="{$id}" />
<input type="hidden" name="hash" value="{$hash|default:''}" />
{if isset($vl_id)}
<input type="hidden" name="vl_id" value="{$vl_id}" id="vl_save_type_vl_id">
{/if}
<table cellpadding="0" cellspacing="0" border="0" width="100%">
	<tr>
		<td>
			{lang code='fieldname.catalog.text'}
		</td>
		<td>
			<input type="text" id="vl_name" name="vl_name" value="{$item->vl_name|replace:'"':'&quot;'}">
		</td>
	</tr>
	<tr>
		<td>
			{lang code='measurement.catalog.text'}
		</td>
		<td>
			<select id="vl_measurement_id" name="vl_measurement_id">
				{foreach from=$measurements item=meas}
				    <option value="{$meas->ms_id}"{if $meas->ms_id eq $vl_measurement_id} selected="selected"{/if}>{$meas->ms_value}</option>
				{/foreach}
			</select>
		</td>
	</tr>
	<tr>
		<td>
			{lang code='fieldposition.catalog.text'}
		</td>
		<td>
			<input type="text" name="vl_position" id="vl_position" value="{$item->vl_position}" />
		</td>
	</tr>
	<tr>
		<td>
			{lang code="inputtype.catalog.text"}
		</td>
		<td>
			<select id="vl_type_in" name="vl_type_in">
				{foreach from=$inputTypes key=id item=typename}
				    <option value="{$typename}"{if $typename eq $item->vl_type_in} selected="selected"{/if}>{lang code="$typename.catalog.text"}</option>
				{/foreach}
			</select>
		</td>
	</tr>
	<tr>
        <td>
            {lang code="outputtype.catalog.text"}
        </td>
        <td>
            <select id="vl_type_print" name="vl_type_print">
                {foreach from=$outputTypes key=id item=typename}
                    <option value="{$typename}"{if $typename eq $item->vl_type_print} selected="selected"{/if}>{lang code="$typename.catalog.text"}</option>
                {/foreach}
            </select>
        </td>
    </tr>
    {if isset($types_show) and count($types_show)}
        {foreach from=$types_show key=tsk item=item_tsk}
            <tr>
                <td nowrap="nowrap">
                    {lang code=$item_tsk}
                </td>
                <td>
                    <input type="radio" value="1" name="CTshowing_{$item_tsk}" id="CTshowing_{$item_tsk}_yes"{if isset($ts_sh[$item_tsk])} checked="checked"{/if}><label for="CTshowing_{$item_tsk}_yes">{lang code='-yes'}</label>&nbsp;<input id="CTshowing_{$item_tsk}_no" type="radio" value="0" name="CTshowing_{$item_tsk}"{if !isset($ts_sh[$item_tsk])} checked="checked"{/if}><label for="CTshowing_{$item_tsk}_no">{lang code='-no'}</label>
                </td>
            </tr>
        {/foreach}
    {/if}
    <tr>
        <td nowrap="nowrap">
            {lang code='filter.catalog.option'}
        </td>
        <td>
            <label>
                <input type="radio" name="vl_filter" {if $item->vl_filter} checked="checked"{/if} value="1" />
                {lang code="-yes"}
            </label>
            <label>
                <input type="radio" name="vl_filter" {if !$item->vl_filter} checked="checked"{/if} value="0" />
                {lang code="-no"}
            </label>
        </td>
    </tr>
	<tr id="dependence_types_tr" style="dispaly:none;">
		<td colspan="2" id="dependence_types_td">
			
		</td>
	</tr>
	<tr>
		<td colspan="2" align="center">
			<input type="submit" value="{lang code='-submit'|replace:'"':'&quot;'}" />&nbsp;<input type="button" value="{lang code='-cancel'}" onclick="RADCatTypesAction.TypeAddFieldWindowCancelClick();" />
		</td>
	</tr>
</table>
</form>
{/strip}