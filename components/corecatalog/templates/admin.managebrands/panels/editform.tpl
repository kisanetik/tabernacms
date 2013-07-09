{strip}
<div>
<h1>{lang code='managebrand.catalog.title' ucf=true}</h1>
<form enctype="multipart/form-data" id="addedit_form" method="post">
<input type="hidden" name="returntorefferer" id="returntorefferer" value="0" />
<input type="hidden" name="hash" id="hash" value="{$hash|default:''}" />
{if isset($item) && $item->rcb_id}
<input type="hidden" name="rcb_id" value="{$item->rcb_id}" />
<input type="hidden" name="action_sub" id="action_sub" value="edit" />
{else}
<input type="hidden" name="action_sub" id="action_sub" value="add" />
    {if isset($selected_category) && $selected_category}
        <input type="hidden" name="selected_category" value="{$selected_category}" id="selected_category" />
    {/if}
{/if}
<table cellpadding="0" cellspacing="0" border="0">
    <tr>
        <td class="left_column">{lang code='brandtitle.catalog.title' ucf=true}:</td>
        <td><input type="text" class="long_text" name="rcb_name" id="rcb_name" value="{$item->rcb_name|replace:'"':'&quot;'}" style="width:370px;" /></td>
    </tr>
    {if $params->_get('hassubcats',false)}
    <tr>
        <td class="left_column">
           {lang code='brandcategory.catalog.text' ucf=true}:
        </td>
        <td>
            <select class="long_text" name="nw_tre_id" id="nw_tre_id">
                {radinclude module="coremenus" file="admin.managetree/tree_recursy.tpl" element=$categories selected=$selected_category nbsp=0}
            </select>
        </td>
    </tr>
    {else}
    <input type="hidden" name="nw_tre_id" value="{$selected_category}" />
    {/if}
    <tr>
        <td class="left_column">{lang code='-active' ucf=true}:</td>
        <td>
            <input type="checkbox" name="rcb_active" id="rcb_active"{if $item->rcb_active} checked="checked"{/if} />
        </td>
    </tr>
    <tr>
        <td colspan="2">
            <input type="button" name="cancel" value="{lang code='-submit' ucf=true|replace:'"':'&quot;'}" onclick="javascript:RADBrand.applyClick();">
    &nbsp;<input type="button" name="cancel" value="{lang code='-cancel' ucf=true|replace:'"':'&quot;'}" onclick="javascript:RADBrand.cancelClick();">
        </td>
    </tr>
</table>
</form>
</div>
{/strip}