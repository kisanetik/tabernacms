{strip}
{if !empty($items)}
<ul class="b-menu">
    {foreach from=$items item=item}
        {if $item->tre_active}
            <li{if $item == $items[count($items)-1]} class="last"{/if}>
                <a href="{url href="`$item->tre_url`"}">{$item->tre_name}</a>
                <span class="separator"></span>
            </li>
        {/if}
    {/foreach}
</ul>
<div style="clear: both;"></div>
{/if}
{/strip}




