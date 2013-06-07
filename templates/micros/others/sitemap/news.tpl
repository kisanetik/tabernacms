{strip}
{if !empty($newsTree)}
    <ul class="news">
        {foreach from=$newsTree item="tree"}
            <li>
                {if isset($tree->tre_id) and $tree->tre_id > 0}
                    <a href="{url href="alias=news&t=`$tree->tre_name|@urlencode`&cat_n=`$tree->tre_id`"}">{$tree->tre_name}</a>
                    {if !empty($tree->news)}
                        <ul class="news-items">
                            {foreach from=$tree->news item="nw"}
                                <li>
                                    <strong style="padding-right:5px;color:grey;font-size:60%;">{$nw->nw_datenews|date:'date'}</strong>
                                    <a href="{url href="alias=news&nid=`$nw->nw_id`"}">
                                        {$nw->nw_title}
                                    </a>
                                </li>
                            {/foreach}
                        </ul>
                    {/if}
                    {if !empty($tree->child) and count($tree->child)}
                        {include file="$_CURRENT_LOAD_PATH/sitemap/news.tpl" newsTree=$tree->child}
                    {/if}                    
                {/if}
            </li>
        {/foreach}
    </ul>
{/if}
{/strip}