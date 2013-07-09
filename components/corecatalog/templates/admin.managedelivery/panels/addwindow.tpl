{strip}
<form id="addwform" method="POST" onsubmit="return RADDelivery.addEditSubmit()">
    <input type="hidden" name="hash" id="hash" value="{$hash|default:''}" />
    {if !empty($item->rdl_id)}
        <input type="hidden" name="action_sub" id="action_sub" value="edit" />
        <input type="hidden" name="rdl_id" value="{$item->rdl_id}" />
    {else}
        <input type="hidden" name="action_sub" id="action_sub" value="add" />
    {/if}
    <table cellspacing="0" cellpadding="0" border="0" width="100%">
        <tr>
            <td>{lang code='deliveryname.catalog.title'}</td>
            <td>
                <input type="text" name="rdl_name" maxlength="125" id="rdl_name" value="{$item->rdl_name|replace:'"':'&quot;'}" />
            </td>
        </tr>
        <tr>
            <td>{lang code='deliverydescription.catalog.title'}</td>
            <td>
                <textarea id="rdl_description" name="rdl_description" style="width:98%" rows="5">{$item->rdl_description}</textarea>
            </td>
        </tr>
        <tr>
            <td>{lang code='deliverycurrency.catalog.title'}</td>
            <td>
                {if !empty($currency)}
                <select name="rdl_currency" id="rdl_currency">
                    {foreach from=$currency item="cur"}
                       <option value="{$cur->cur_id}"{if $item->rdl_currency eq $cur->cur_id} selected="true"{/if}>{$cur->cur_name}</option>
                    {/foreach}
                </select>
                {/if}
            </td>
        </tr>
        <tr>
            <td>{lang code='deliverycost.catalog.title'}</td>
            <td><input type="text" name="rdl_cost" id="rdl_cost" value="{$item->rdl_cost}" /></td>
        </tr>
        <tr>
            <td>{lang code='-active' ucf=true}</td>
            <td>
                <input type="checkbox" name="rdl_active" id="rdl_active" {if $item->rdl_active} checked="true"{/if}/>
            </td>
        </tr>
        <tr>
            <td colspan="2" align="center">
                <input type="submit" value="{lang code='-submit' ucf=true}" />&nbsp;
                <input type="button" onclick="RADDelivery.cancelWClick()" value="{lang code='-cancel' ucf='true'}" />
            </td>
        </tr>
    </table>
</form>
{/strip}