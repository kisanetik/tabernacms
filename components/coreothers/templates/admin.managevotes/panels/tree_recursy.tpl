{if is_array($elements) and isset($selected) and isset($nbsp)}
    {foreach from=$elements item=el}
        <option value="{$el->tre_id}"{if $el->tre_id eq $selected} selected="selected"{/if}>{section name=element_section loop=$nbsp start=1 step=1}&nbsp;{/section}{$el->tre_name}</option>
        {if is_array($el->child) and count($el->child)}
            {radinclude module="coreothers" file="admin.managevotes/panels/tree_recursy.tpl" elements=$el->child selected=$selected nbsp=$nbsp+3}
        {/if}
    {/foreach}
{/if}