{strip}
{if !isset($selected)}
<ul>
	{foreach from=$element item=item}
	   <li><a name="{$item->tre_id}" href="{const SITE_URL}{$item->tre_url}" target="_blank" >{$item->tre_name}</a>{if is_array($item->child)}
	       {include file="`$_CURRENT_LOAD_PATH`/../menus/admin.managetree/tree_recursy.tpl" element=$item->child}
	   {/if}
	   </li>
	{/foreach}
</ul>
{else}
    {foreach from=$element item=el}
        <option value="{$el->tre_id}"
            {if $selected eq $el->tre_id} selected="selected"{/if}
            {if isset($selected_id) and $el->tre_id eq $selected_id} disabled="disabled"{/if}>
                {section name=element_section loop=$nbsp start=1 step=1}&nbsp;{/section}{$el->tre_name}
        </option>
        {if is_array($el->child) and count($el->child)}
            {include file="`$_CURRENT_LOAD_PATH`/../menus/admin.managetree/tree_recursy.tpl" element=$el->child selected=$selected nbsp=$nbsp+3}
        {/if}
    {/foreach}
{/if}
{/strip}