{strip}
<form id="editComment" method="post" onsubmit="return RADComments.saveComment();">
<input type="hidden" name="i" value="{$item->rcm_id}" />
<input type="hidden" name="hash" value="{$hash}" />
<table cellpadding="0" cellspacing="0" border="0" width="100%">
    <tr>
        <td width="10%" nowrap="nowrap">
            {lang code="user.resource.text" ucf=true}:
        </td>
        <td>
            {$item->rcm_nickname}
        </td>
    </tr>
    <tr>
        <td width="10%" nowrap="nowrap">
            {lang code="textcomment.resource.text" ucf=true}:
        </td>
        <td>
            <textarea id="c_txt" name="c_txt" style="width:95%;height:200px;">{$item->rcm_text}</textarea>
        </td>
    </tr>
    <tr>
        <td>
            {lang code="-active" ucf=true}
        </td>
        <td>
            <input type="radio" value="1" name="active" id="active"{if $item->rcm_active} checked="checked"{/if} />{lang code="-yes" ucf=true}
            &nbsp;
            <input type="radio" value="0" name="active" id="active"{if !$item->rcm_active} checked="checked"{/if} />{lang code="-no" ucf=true}
        </td>
    </tr>
    <tr>
        <td colspan="2" align="center">
            <input type="submit" value="{lang code="-save" ucf=true}" />&nbsp;
            <input type="button" value="{lang code="-cancel" ucf=true}" onClick="RADComments.cancelSaveCommentClick();" />
        </td>
    </tr>
</table>
{/strip}