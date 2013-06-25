{strip}{*done*}
{if !empty($items)}
<div class="news_vitrina">
    <h2><a href="{url href="alias=news"}">{lang code="news.menu.title" ucf=true}</a></h2>
    <div class="news-list">
        {foreach from=$items item=item name="left_news"}
        <div class="news-item">
            <span class="news-date-time">{$item->nw_datenews|date_format:"%e.%m.%Y"}</span>
                <h4>
                    <a href="{url href="alias=news&nid=`$item->nw_id`&t=`$item->nw_title|@urlencode`"}" >
                        {$item->nw_title}
                    </a>
                </h4>
                <em>{$item->nw_shortdesc}</em>
        </div>
        {/foreach}
    </div>
</div>
{/if}
{/strip}


