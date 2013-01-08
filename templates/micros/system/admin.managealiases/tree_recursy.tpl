{strip}
{if count($elements)}
{foreach from=$elements item="element"}
    {if isset($ml)}

        {if is_array( $values->_get( $item, $items->_default($item), $ml ) )}
           <option value="{$element->tre_id}"{if in_array($element->tre_id, $values->_get( $item, $items->_default($item), $ml ))} selected="selected"{/if}>
        {else}
           <option value="{$element->tre_id}"{if $element->tre_id eq $values->_get( $item, $items->_default($item), $ml )} selected="selected"{/if}>
        {/if}

    {else}

    <option value="{$element->tre_id}"{if $element->tre_id eq $values->_get( $item, $items->_default($item) )} selected="selected"{/if}>

    {/if}

        {section name=element_section loop=$nbsp_count start=1 step=1}&nbsp;{/section}
        {$element->tre_name}
    </option>
    {if is_array($element->child)}
       {include file="$_CURRENT_LOAD_PATH/admin.managealiases/tree_recursy.tpl" elements=$element->child nbsp_count=$nbsp_count+3}
    {/if}
{/foreach}
{/if}
{/strip}