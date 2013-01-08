{strip}
<form id="form_window_xmlparamsstring_{$include.inc_id}" onSubmit="return false;">
    <textarea id="wxmlparams_string_{$include.inc_id}" style="width:100%;height:380px;">{$params}</textarea>
    <center>
        <input type="button" value="{lang code='-submit' ucf=true|replace:'"':'&quot;'}" onclick="RADInstallTree.saveXMLStringParams({$include.inc_id});" />
        &nbsp;
        <input type="button" value="{lang code='-cancel' ucf=true|replace:'"':'&quot;'}" onclick="$('editXMLParamsWindow_{$include.inc_id}').destroy();" />
    </center>
</form>
{/strip}