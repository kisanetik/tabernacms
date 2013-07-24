{strip}
<form onsubmit="return false;">
<textarea id="xmlfullparams_text_{$include.inc_id}" style="width:100%; height:480px;">{$xmlstring}</textarea>
<center>
    <input id="saveXMLFButton_{$include.inc_id}" type="button" value="{lang code='-submit' ucf=true}" onclick="RADInstallTree.saveDetailClick({$include.inc_id});" />
    &nbsp;
    <input type="button" value="{lang code='-cancel' ucf=true htmlchars=true}" onclick="$('editXMLFParamsWindow_{$include.inc_id}').destroy();" />
</center>
</form>
{/strip}