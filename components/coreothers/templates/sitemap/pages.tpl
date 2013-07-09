{strip}
    {if !empty($pagesTree)}
        <ul class="pages">
        {foreach from=$pagesTree item="tree"}
            <li>
                {if isset($tree->tre_id) and $tree->tre_id > 0}
                    <a href="{url href="alias=page&cp=`$tree->tre_id`"}">{$tree->tre_name}</a>
                    {if !empty($tree->pages) and count($tree->pages)}
                        <ul class="page-items">
                            {foreach from=$tree->pages item="pitem"}
                                <li>
                                    <a href="{url href="alias=page&pgid=`$pitem->pg_id`"}">{$pitem->pg_title}</a>
                                </li>
                            {/foreach}
                        </ul>
                    {/if}
                    {if !empty($tree->child)}
                        {include file="$_CURRENT_LOAD_PATH/sitemap/pages.tpl" pagesTree=$tree->child}
                    {/if}
                {/if}
            </li>
        {/foreach}
    </ul>
{/if}
{/strip}