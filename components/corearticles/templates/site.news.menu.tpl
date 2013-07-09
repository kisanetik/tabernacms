{strip}
{if !empty($items)}
<div class="news">
    <div class="newsfon"></div>
    <div class="pic1"></div>
    <h4>{lang code="news.menu.title" ucf=true}</h4>
    {foreach from=$items item=item name="left_news"}
        <h6>{$item->nw_datenews|date_format:"%e.%m.%Y"}</h6>
        <a href="{url href="alias=news&nid=`$item->nw_id`&t=`$item->nw_title|@urlencode`"}" >
            {$item->nw_title}
        </a>
    {/foreach}
    <a href="{url href="alias=news"}" class="all-news">
        <input type="button"  name="news"  class="btnblue grbt tx btgr allnews" value="{lang code="allnews.catalog.link" ucf=true}" />
    </a>
</div>
{/if}
{/strip}