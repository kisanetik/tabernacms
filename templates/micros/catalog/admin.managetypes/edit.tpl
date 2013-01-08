{strip}
<form method="post" id="editNodeForm">
<input type="hidden" name="hash" value="{$hash|default:''}" />
{if isset($id)}
<input type="hidden" name="tre_id" value="{$id}" />
	{if isset($item) and $item->tre_pid}
	    <input type="hidden" name="tre_pid" value="{$item->tre_pid}">
	{/if}
{/if}
<table cellpadding="0" cellspacing="3" border="0" width="100%" height="100%">
    <tr>
        <td>
            {lang code='nodename.catalog.text' ucf=true}
        </td>
        <td>
            <input type="text" name="tre_name" id="nodename" value="{$item->tre_name}">
        </td>
    </tr>
    <tr>
        <td>
            {lang code='nodeposition.catalog.text' ucf=true}
        </td>
        <td>
            <input type="text" id="nodeposition" name="tre_position" value="{$item->tre_position}">
        </td>
    </tr>
    <tr>
        <td>
            {lang code='-active' ucf=true}
        </td>
        <td align="left">
        	<input type="radio" name="tre_active" value="1" id="nodeactive_yes" {if $item->tre_active} checked="ckecked"{/if} />
			<label for="nodeactive_yes">
                {lang code='-yes' ucf=true}
            </label>&nbsp;
			<input type="radio" name="tre_active" id="nodeactive_no" value="0" {if !$item->tre_active} checked="ckecked"{/if} />
			<label for="nodeactive_no">
				{lang code='-no' ucf=true}
			</label>
        </td>
    </tr>
    <tr>
        <td>
            {lang code='parent.catalog.text' ucf=true}
        </td>
        <td align="left">
            <select id="tre_pid" name="tre_pid">
                {*<option value="{$pid}">{lang code="rootnode.catalog.text" ucf=true}</option>*}
                {include file="$_CURRENT_LOAD_PATH/admin.managetypes/edit_recursy.tpl" elements=$nodes nbsp_count=0 selected=$item->tre_pid selected_id=$item->tre_id}
            </select>
        </td>
    </tr>
</table>
</form>
{/strip}