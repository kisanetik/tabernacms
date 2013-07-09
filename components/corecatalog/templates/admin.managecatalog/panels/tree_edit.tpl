{strip}
<form method="post" id="editNodeForm">
    <input type="hidden" id="node_id" name="node_id" value="{$tree->tre_id}">
    <input type="hidden" id="node_lang" name="tre_lang" value="{$tree->tre_lang}" />
    <input type="hidden" id="node_islast" name="tre_islast" value="{$tree->tre_islast}" />
    <input type="hidden" id="hash" name="hash" value="{$hash|default:''}" />
    <table cellpadding="0" cellspacing="0" border="0" width="100%">
        <tr>
            <td>
                {lang code='treename.catalog.text' ucf=true}
            </td>
            <td>
                <input type="text" id="node_name" name="tre_name" value="{$tree->tre_name|replace:'"':'&quot;'}" style="width:95%;" x-webkit-speech="" speech="" onwebkitspeechchange="return void(0);" />
            </td>
        </tr>
        <tr>
            <td>
                {lang code='treposition.catalog.text' ucf=true}
            </td>
            <td>
                <input type="text" id="node_position" name="tre_position" value="{$tree->tre_position}"  style="width:95%;" />
            </td>
        </tr>
        <tr>
            <td>
                {lang code='-active' ucf=true}
            </td>
            <td>
                <input type="radio" id="node_active_yes" name="tre_active" value="1"{if $tree->tre_active} checked="checked"{/if} /><label for="node_active_yes">{lang code='-yes' ucf=true}</label>
                <input type="radio" id="node_active_no" name="tre_active" value="0" {if !$tree->tre_active} checked="checked"{/if} /><label for="node_active_no">{lang code='-no' ucf=true}</label>
            </td>
        </tr>
        {if $tree->tre_id!=$pid}
        <tr>
            <td>
                {lang code='treparent.catalog.text' ucf=true}
            </td>
            <td>
                <select id="node_parent" name="tre_pid">
                    {include file="$_CURRENT_LOAD_PATH/admin.managecatalog/panels/tree_edit_recursy.tpl" elements=$trees nbsp_count=0 selected_item=$tree}
                </select>
            </td>
        </tr>
        {/if}
        <tr>
            <td>
                {lang code='-access' ucf=true}
            </td>
            <td>
                <input type="text" id="node_access" name="tre_access" value="{$tree->tre_access}" maxlength="5" />
            </td>
        </tr>
    </table>
</form>
{/strip}
