{strip}
    {if !empty($news)}
        <ul class="news">
            {foreach from=$news item="item"}
                <li>
                    <a href="{url href="alias=news&t=`$item->tre_name|@urlencode`&cat_n=`$item->tre_id`"}">{$item->tre_name}</a>
                    {if !empty($item->news)}
                        <ul class="news-items">
                            {foreach from=$item->news item="nw"}
                                <li>
                                    <strong style="padding-right:5px;color:grey;font-size:60%;">{$nw->nw_datenews|date:'date'}</strong>
                                    <a href="{url href="alias=news&nid=`$nw->nw_id`"}">
                                        {$nw->nw_title}
                                    </a>
                                </li>
                            {/foreach}
                        </ul>
                    {/if}
                </li>
            {/foreach}
        </ul>
    {/if}
{/strip}