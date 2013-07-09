{strip}
{if $item->tre_id neq 0}
<div align="center">
<form id="editTreeForm" method="post">
<input type="hidden" name="tre_pid" id="tre_pid" value="{$item->tre_pid}">
<input type="hidden" name="hash" id="hash" value="{$hash|default:''}">
<table cellpadding="0" cellspacing="3" border="0" width="100%">
    <tr>
        <td>ID</td>
        <td>{$item->tre_id}</td>
    </tr>
    <tr>
        <td width="10%" nowrap="nowrap">
            {lang code='treename.menus.text'}
        </td>
        <td align="left">
            <input type="text" id="treename" name="tre_name" value="{$item->tre_name}" />
        </td>
    </tr>
    <tr>
        <td nowrap="nowrap">
            {lang code='treeurl.menus.text'}
        </td>
        <td align="left">
            <input type="text" id="treeurl" name="tre_url" value="{$item->tre_url}" />
        </td>
    </tr>
    <tr>
        <td nowrap="nowrap">
            {lang code='treeposition.menus.text'}
        </td>
        <td align="left">
            <input type="text" id="treeposition" name="tre_position" value="{$item->tre_position}" />
        </td>
    </tr>
    <tr>
        <td nowrap="nowrap">
            {lang code='treeimage.menus.text'}
        </td>
        <td align="left">
            <div id="img_container">
                {if strlen($item->tre_image)}
                <img id="tree_img" src="{url module="coremenus" file="`$item->tre_image`" type="image" preset="tree_square"}" border="0" /><br />
                <input type="checkbox" id="tre_image" name="deleteimage" />
                <label for="tre_image">{lang code='deleteimage.menus.text'}</label>
                <br />
                <a href="javascript: RADTree.showTreeUploadFrame();">{lang code='changeimage.menus.link'}</a>
                {else}
                <a href="javascript: RADTree.showTreeUploadFrame();" id="addimg_link">{lang code='addimage.menus.link'}</a>
                {/if}
            </div>
            <div id="tree_divformimage" style="display:none;">
                <iframe id="iframe_treefile" src="{url href="action=showuploadform&id=`$item->tre_id`"}" width="100%" height="50px;" align="left" frameborder="no" scrolling="no">
                </iframe>
            </div>
        </td>
    </tr>
    <tr>
        <td nowrap="nowrap">
            {lang code='-active'}
        </td>
        <td align="left">
            <input type="radio" name="tre_active" id="treeactive_yes" value="1"{if $item->tre_active} checked="checked"{/if} /><label for="treeactive_yes">{lang code='-yes'}</label>
            <input type="radio" name="tre_active" id="treeactive_no" value="0"{if !$item->tre_active} checked="checked"{/if} /><label for="treeactive_no">{lang code='-no'}</label>
        </td>
    </tr>
    <tr>
        <td>
            {lang code='parent.menus.text'}
        </td>
        <td align="left">
            <select id="tre_pid" name="tre_pid">
                {if isset($parents) and count($parents)}
                    {radinclude module="coremenus" file="admin.managetree/tree_recursy.tpl" element=$parents selected=$item->tre_pid nbsp=0 selected_id=$item->tre_id}
                {/if}
            </select>
        </td>
    </tr>
    <tr>
        <td>
            {lang code='-access'}
        </td>
        <td align="left">
            <input type="text" name="tre_access" value="{$item->tre_access}" id="tre_access" />
        </td>
    </tr>
</table>
</form>
</div>
{else}
    {lang code='rootelement.menus.text' ucf=true}
{/if}
{/strip}