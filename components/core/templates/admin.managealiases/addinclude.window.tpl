{strip}
<form method="post" id="WForm" onsubmit="RADIncInAlAction.submitWClick();return false;">
<input type="hidden" name="alias_id" value="{$alias_id}" />
<input type="hidden" name="theme" value="{$theme}" />
<input type="hidden" name="hash" value="{$hash|default:''}" />
<table cellpadding="0" cellspacing="0" border="0" width="100%">
    <tr>
        <td>
            {lang code='nameinclude.system.title'}
        </td>
        <td align="left">
            <select name="include_id" id="include_id" style="width:98%;" onchange="RADIncInAlAction.InAddloadController(this);">
                <option value="0">{lang code='-choose' ucf=true|replace:'"':'&quot;'}</option>
                {foreach from=$modules item=module}
                    <optgroup label="{$module.m_name}">
                        {foreach from=$includes[$module.m_id] item=include}
                            <option{if (isset($include.is_theme)) and ($include.is_theme) } style="background:#e2eaed;"{/if} value="{$include.inc_id}">({$include.inc_name})&nbsp;{$module.m_name}/{$include.inc_filename}</option>
                        {/foreach}
                    </optgroup>
                {/foreach}
            </select>
        </td>
    </tr>
    <tr id="controller_tr" style="display:none;">
        <td>
            {lang code='controllerinclude.system.text' ucf=true}
        </td>
        <td align="left">
            <select name="controller" id="controller">

            </select>
        </td>
    </tr>
    <tr>
        <td>
            {lang code='positioninclude.system.text' ucf=true}
        </td>
        <td>
            <select name="position_id" id="position_id">
                {foreach from=$positions item=position}
                    <option value="{$position->rp_id}">({$position->rp_name})</option>
                {/foreach}
            </select>
        </td>
    </tr>
    <tr>
        <td>
            {lang code='ordersort.system.text' ucf=true}
        </td>
        <td>
            <input type="text" name="order_sort" id="order_sort" value="100" style="width:40px;" />
        </td>
    </tr>
    <tr>
        <td colspan="2" align="center">
            <input type="button" value="{lang code='-submit' ucf=true|replace:'"':'&quot;'}" id="submitW" onclick="RADIncInAlAction.submitWClick();" />&nbsp;
            <input type="button" value="{lang code='-cancel' ucf=true|replace:'"':'&quot;'}" onclick="RADIncInAlAction.cancelWClick();">
        </td>
    </tr>
</table>
</form>
{/strip}