{strip}
{foreach from=$elements item="element"}
    <option value="{$element->tre_id}"
        {if !isset($noselected) and $element->tre_id eq $tree->tre_pid} selected="selected"{/if}
        {if (!empty($selected_item) and $element->tre_id eq $selected_item->tre_id) or (isset($is_eneabled) and $is_eneabled eq false)} disabled="disabled"{/if}>
        {section name=element_section loop=$nbsp_count start=1 step=1}&nbsp;{/section}
        {$element->tre_name}
    </option>
    {if is_array($element->child)}
       {if (!empty($selected_item) and $element->tre_id eq $selected_item->tre_id) or (isset($is_eneabled) and $is_eneabled eq false)}
           {include file="$_CURRENT_LOAD_PATH/admin.managecatalog/panels/tree_edit_recursy.tpl" elements=$element->child nbsp_count=$nbsp_count+3 is_eneabled=false}
       {else}
           {include file="$_CURRENT_LOAD_PATH/admin.managecatalog/panels/tree_edit_recursy.tpl" elements=$element->child nbsp_count=$nbsp_count+3 is_eneabled=true}
       {/if}
    {/if}
{/foreach}
{/strip}