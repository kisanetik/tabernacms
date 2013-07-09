{strip}
<form method="post" id="addCurrencyForm">
<input type="hidden" name="hash" id="hash" value="{$hash|default:''}">
{if isset($item) and $item->cur_id}
<input type="hidden" name="edit" value="1" />
<input type="hidden" name="cur_id" value="{$item->cur_id}" />
{/if}
<table cellpadding="0" cellspacing="0" border="0">
    {if !isset($langs)}
        <tr>
            <td width="10%" nowrap="nowrap">
                &nbsp;*{lang code='currencyname.catalog.text'}
            </td>
            <td width="90%" align="left">
                <input type="text" name="cur_name" value="{$item->cur_name|replace:'"':'&quot;'}" />
            </td>
        </tr>
        <tr>
            <td nowrap="nowrap">
                &nbsp;*{lang code='currencyshortname.catalog.text'}
            </td>
            <td align="left">
                <input type="text" name="cur_shortname" value="{$item->cur_shortname|replace:'"':'&quot;'}" />
            </td>
        </tr>
    {/if}
    <tr>
        <td nowrap="nowrap">
            &nbsp;*{lang code='currencyindicator.catalog.text'}
        </td>
        <td align="left">
            <input type="text" name="cur_ind" value="{$item->cur_ind}" />
        </td>
    </tr>
    <tr>
        <td nowrap="nowrap">
            &nbsp;*{lang code='currencycost.catalog.text'}
        </td>
        <td align="left">
            <input type="text" name="cur_cost" value="{$item->cur_cost}" />
        </td>
    </tr>
    <tr>
        <td nowrap="nowrap">
            &nbsp;*{lang code='currencyposition.catalog.text'}
        </td>
        <td>
            <input type="text" name="cur_position" value="{$item->cur_position}" />
        </td>
    </tr>
    <tr>
        <td nowrap="nowrap">
            <label for="cur_showcurs">{lang code='currencyshowcurs.catalog.text'}</label>
        </td>
        <td align="left">
            <input type="checkbox" name="cur_showcurs" id="cur_showcurs"{if $item->cur_showcurs} checked="checked"{/if} />
        </td>
    </tr>
    <tr>
        <td nowrap="nowrap">
            <label for="cur_show_site">{lang code='currencyshowsite.catalog.text'}</label>
        </td>
        <td align="left">
            <input type="checkbox" name="cur_show_site" id="cur_show_site"{if $item->cur_show_site} checked="checked"{/if} />
        </td>
    </tr>
    <tr>
        <td nowrap="nowrap">
            <label for="cur_default_site">{lang code='currencydefaultsite.catalog.text'}</label>
        </td>
        <td align="left">
            <input type="checkbox" name="cur_default_site" id="cur_default_site"{if $item->cur_default_site} checked="checked"{/if} />
        </td>
    </tr>
    <tr>
        <td nowrap="nowrap">
            <label for="cur_default_admin">{lang code='currencydefaultadmin.catalog.text'}</label>
        </td>
        <td align="left">
            <input type="checkbox" name="cur_default_admin" id="cur_default_admin"{if $item->cur_default_admin} checked="checked"{/if} />
        </td>
    </tr>
    <tr>
        <td colspan="2" align="center">
            <input type="button" value="{lang code='-submit' ucf=true|replace:'"':'&quot;'}" onclick="RADCurrency.submitnewclick();" />&nbsp;
            <input type="button" value="{lang code='-cancel' ucf=true|replace:'"':'&quot;'}" onclick="RADCurrency.cancelnewclick();" />
        </td>
    </tr>
</table>
</form>
{/strip}