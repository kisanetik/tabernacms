{strip}
{if !empty($catalog)}
    {foreach from=$catalog item="cat"}
        <category id="{$cat->tre_id}" {if $cat->tre_pid}parentId="{$cat->tre_pid}"{/if}>
            {$cat->tre_name|htmlspecialchars}
        </category>
        {if !empty($cat->child)}
            {include file="$_CURRENT_LOAD_PATH/sitemap.export/yandex.categories.tpl" catalog=$cat->child}
        {/if}
    {/foreach}
{/if}
{/strip}