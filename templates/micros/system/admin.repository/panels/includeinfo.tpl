{strip}
<form id="editIncludeForm" onsubmit="RADInstallTree.saveEdit();return false;">
    <input type="hidden" name="hash" value="{$hash|default:''}" />
    {if $action eq 'getinc'}
    <input type="hidden" name="i" value="{$include.inc_id}" />
	<input type="hidden" name="method" value="save" />
    {elseif $action eq 'getfile'}
    <input type="hidden" name="folder" value="{$system->module->folder}" />
    <input type="hidden" name="filename" value="{$system->module->filename}" />
    {/if}
    <table cellpadding="2" cellspacing="0" border="0" width="100%">
        {if $action eq 'getfile'}
        <tr>
            <td>{lang code="filenameinclude.system.title" ucf=true}</td>
            <td>{const MICROSPATH}{$system->module->folder}{const DS}{$system->module->filename}</td>
        </tr>
        {/if}
        {if $action eq 'getinc'}
        <tr>
            <td>ID</td>
            <td>{$include.inc_id}</td>
        </tr>
        {/if}
        <tr>
            <td>{lang code="tmpl_name.system.xml" ucf=true}</td>
            <td><input type="text" name="inc_name" value="{if !empty($include)}{$include.inc_name}{/if}" /></td>
        </tr>
        <tr>
            <td>{lang code="tmpl_description.system.xml" ucf="true"}</td>
            <td>
                <textarea rows="3" name="names_description">{if !empty($names->description)}{$names->description}{/if}</textarea>
            </td>
        </tr>
        <tr>
            <td>{lang code="tmpl_author.system.xml" ucf=true}</td>
            <td><input type="text" name="names_author" value="{if isset($names->author)}{$names->author}{/if}" /></td>
        </tr>
        <tr>
            <td>{lang code="tmpl_url.system.xml" ucf=true}</td>
            <td><input type="text" id="names_url" name="names_url" value="{if isset($names->url)}{$names->url}{/if}" /></td>
        </tr>
        <tr>
            <td>{lang code="tmpl_ver.system.xml" ucf=true}</td>
            <td><input type="text" id="system_ver" name="system_ver" value="{if isset($system->template) and isset($system->template->lower) }{$system->template->lower}{/if}" /></td>
        </tr>
        <tr>
            <td>{lang code="sysver.system.xml" ucf=true}</td>
            <td><input type="text" id="system_name" name="system_name" value="{if isset($system->ver)}{$system->ver}{/if}" /></td>
        </tr>
        <tr>
            <td>{lang code="tmpl_prelogic.system.xml" ucf=true}</td>
            <td>
                <select MULTIPLE="MULTIPLE" id="system_prelogic" name="system_prelogic[]" style="height:45px;">
                    {if !empty($system->prelogic)}
                        {if count($system->prelogic->item)>1}
                            {foreach from=$system->prelogic->item item=item key=itemid}
                                {if strlen($item)}
                                    <option value="{$item}">{$item}</option>
                                {/if}
                            {/foreach}
                        {else}
                            {foreach from=$system->prelogic item=prelogic}
                                {if strlen($prelogic->item)}
                                    <option value="{$prelogic->item}">{$prelogic->item}</option> 
                                {/if}
                            {/foreach}
                        {/if}
                    {elseif isset($system->prelogic->item)}
                         <option value="{$system->prelogic->item}">{$system->prelogic->item}</option> 
                    {/if}
                </select>
			<input type="button" value="{lang code='-delete'}" onclick="{literal}if($('system_prelogic').selectedIndex>=0){$('system_prelogic').options[$('system_prelogic').selectedIndex] = null;}{/literal}" />
			<br />
                <input type="text" id="system_prelogic_item" value="" style="width:225px;float:left;" />
                <input type="button" style="width:34%;float:right;" value="{lang code='-add'}" onclick="addSel($('system_prelogic'),$('system_prelogic_item').value, $('system_prelogic_item').value);" />
            </td>
        </tr>
        <tr>
            <td>{lang code="tmpl_modulename.system.xml" ucf=true}</td>
            <td><input type="text" id="system_module_name" name="system_module_name" value="{if isset($system->module->name)}{$system->module->name}{/if}" /></td>
        </tr>
        <tr>
            <td>{lang code="tmpl_modulefolder.system.xml" ucf=true}</td>
            <td><input type="text" id="system_module_folder" name="system_module_folder" value="{if isset($system->module) and isset($system->module->folder)}{$system->module->folder}{/if}" /></td>
        </tr>
        <tr>
            <td>{lang code="tmpl_modulever.system.xml" ucf=true}</td>
            <td><input type="text" id="system_module_ver" name="system_module_ver" value="{if isset($system->module) and isset($system->module->ver)}{$system->module->ver}{/if}" /></td>
        </tr>
    </table>
</form>
<style type="text/css">
{literal}
#editIncludeForm input, #editIncludeForm select, #editIncludeForm textarea{
    width:98%;
}
{/literal}
</style>
{/strip}