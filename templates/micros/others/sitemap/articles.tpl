{strip}
{if !empty($articles)}
    <ul class="articles">
        {foreach from=$articles item="article"}
            <li>
                {if !empty($article->articles) and count($article->articles) > 1}
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
                {else}
                    {if !empty($article->tre_url)}
                        <a href="{url href="`$article->tre_url`"}">
                            {if !empty($article->articles[0]->art_img)}
                                <img src="{const SITE_URL}image.php?w=32&h=32&m=articles&f={$article->articles[0]->art_img}" alt="{$article->articles[0]->art_title|replace:'"':"&quot;"}" />
                            {/if}
                            {$article->tre_name}
                        </a>
                    {else}
                        <a href="{url href="alias=articles&a=`$article->articles[0]->art_id`"}">
                            {if !empty($article->articles[0]->art_img)}
                                <img src="{const SITE_URL}image.php?w=32&h=32&m=articles&f={$article->articles[0]->art_img}" alt="{$article->articles[0]->art_title|replace:'"':"&quot;"}" />
                            {/if}
                            {$article->articles[0]->art_title}
                        </a>
                    {/if}
                {/if}
            </li>
        {/foreach}
    </ul>
{/if}{* --ARTICLES-- *}
{/strip}