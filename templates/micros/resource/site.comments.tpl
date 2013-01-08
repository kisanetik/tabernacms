{if empty($comments_action)}
    {if !empty($item_id)}
        {include file="$_CURRENT_LOAD_PATH/site.comments/panels/short.items.tpl"}
    {/if}
{else}
    {switch $comments_action}
        {case 'getjs'}
            {include file="$_CURRENT_LOAD_PATH/site.comments/js/getjs.tpl"}
        {/case}
        {case 'a'}{* Add the comment *}
        {case 'items'}{* LOAD ITEMS *}
            {include file="$_CURRENT_LOAD_PATH/site.comments/panels/items.tpl"}
        {/case}
        {case 'f'}{* Full comments *}
        {case 'af'}{* Add comment and show Full comments *}
            {include file="$_CURRENT_LOAD_PATH/site.comments/panels/full.items.tpl"}
        {/case}
        {case 'i'}{*Show one comment*}
            {include file="$_CURRENT_LOAD_PATH/site.comments/panels/item.tpl"}
        {/case}
    {/switch}
{/if}