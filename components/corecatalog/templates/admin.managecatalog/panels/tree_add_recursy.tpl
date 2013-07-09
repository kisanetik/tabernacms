{strip}
{foreach from=$elements item="element"}
    <option value="{$element->tre_id}"
        {if !empty($selected_tree) and $element->tre_id|in_array:$selected_tree} selected="selected"{/if}>
        {section name=element_section loop=$nbsp_count start=1 step=1}&nbsp;{/section}
        {$element->tre_name}
    </option>
    {if is_array($element->child)}
       {include file="$_CURRENT_LOAD_PATH/admin.managecatalog/panels/tree_add_recursy.tpl" elements=$element->child nbsp_count=$nbsp_count+3}
    {/if}
{/foreach}
{/strip}