{strip}
{foreach from=$elements item=node}
   {if $node->tre_id ne $selected_id}   
    <option value="{$node->tre_id}" {if $node->tre_id eq $selected} selected="selected"{/if}>
        {section name=element_section loop=$nbsp_count start=1 step=1}&nbsp;{/section}{$node->tre_name}
    </option>
    {if isset($node->child) and is_array($node->child) and count($node->child)}
        {include file="$_CURRENT_LOAD_PATH/admin.managetypes/edit_recursy.tpl" elements=$node->child nbsp_count=$nbsp_count+3 selected=$selected}
    {/if}
   {/if}
{/foreach}
{/strip}