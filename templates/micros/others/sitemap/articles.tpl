{strip}
{if !empty($articles)}
    <ul class="articles">
        {foreach from=$articles item="article"}
            <li>
                {if isset($article->tre_id) and $article->tre_id > 0}
                    <a href="{url href="alias=articles&c=`$article->tre_id`"}">{$article->tre_name}</a>
                    {if !empty($article->articles)}
                        <ul class="articles-items">
                            {foreach from=$article->articles item="aitem"}
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
                {/if}
            </li>
        {/foreach}
    </ul>
{/if}
{/strip}