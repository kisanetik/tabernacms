{strip}
{if !empty($articlesTree)}
    <ul class="articles">
        {foreach from=$articlesTree item="tree"}
            <li>
                {if isset($tree->tre_id) and $tree->tre_id > 0}
                    <a href="{url href="alias=articles&c=`$tree->tre_id`"}">{$tree->tre_name}</a>
                    {if !empty($tree->articles)}
                        <ul class="articles-items">
                            {foreach from=$tree->articles item="aitem"}
                                <li>
                                    <a href="{url href="alias=articles&a=`$aitem->art_id`"}">
                                        {if !empty($aitem->art_img)}
                                            <img src="{const SITE_URL}image.php?w=32&h=32&m=articles&f={$aitem->art_img}" alt="{$aitem->art_title|replace:'"':"&quot;"}" />
                                        {/if}
                                        {$aitem->art_title}
                                    </a>
                                </li>
                            {/foreach}
                        </ul>
                    {/if}
                    {if !empty($tree->child) and count($tree->child)}
                        {include file="$_CURRENT_LOAD_PATH/sitemap/articles.tpl" articlesTree=$tree->child}
                    {/if}
                {/if}
            </li>
        {/foreach}
    </ul>
{/if}
{/strip}