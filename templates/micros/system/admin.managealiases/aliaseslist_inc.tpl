{strip}
{if isset($items)}
<table cellpadding="0" cellspacing="0" border="0" id="tb_list" width="100%;" class="tb_list">
    <tr class="header">
        <td width="30">
            ID
        </td>
        <td width="100%" style="text-align:left;">
        {lang code='aliasname.system.title' ucf=true}
    </td>
    <td nowrap="nowrap">
        {lang code='filenametemplate.system.title' ucf=true}
    </td>
    <td width="80" nowrap="nowrap">
        {lang code='-action' ucf=true}
    </td>
</tr>
{foreach from=$items item=id}
<tr>
    <td>
        {$id->id}
    </td>
    <td style="text-align:left;">
        {$id->alias}
    </td>
    <td>
        {$id->filename}
    </td>
    <td nowrap="nowrap">
        <a href="{url href="alias=SYSmanageAliases&action=edit&id=`$id->id`"}"><img src="{const SITE_URL}img/backend/billiard_marker.png" border="0" alt="{lang code='-edit'}" title="{lang code='-edit'}" /></a>
        <a href="{url href="alias=SYSmanageAliases&action=delete&id=`$id->id`&hash=`$hash`"}" onclick="return confirm('{lang code='confirmdeletealias.system.link' ucf=true}'+String.fromCharCode(10)+String.fromCharCode(13)+'{$id->alias}');"><img src="{const SITE_URL}img/backend/icons/cross.png" border="0" alt="{lang code='-delete'}" title="{lang code='-delete'}" /></a>
    </td>
</tr>
{foreachelse}
<tr>
   <td colspan="4">
   	   {lang code='norecords.system.text' ucf=true}
   </td>
</tr>
{/foreach}
</table>
{/if}
{/strip}