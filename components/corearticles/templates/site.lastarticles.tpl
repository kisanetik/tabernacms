{strip}
{if !empty($items) and !empty($categories)}
<div class="news">
    <div class="newsfon"></div>
    <div class="pic1"></div>
    <h4>{lang code="articles.menu.title" ucf=true}</h4>
    {if $params->menumode eq 1}
        {foreach from=$items item=item name="left_news"}
            <h6>{$item->art_datecreated|date_format:"%e.%m.%Y"}</h6>
            <a href="{url href="alias=articles&a=`$item->art_id`"}">
                {$item->art_title}
            </a>
        {/foreach}
    {/if}
    {if $params->menumode eq 2}
        {foreach from=$categories item=item name="left_news"}
            <a href="{url href="alias=articles&c=`$item->tre_id`"}">{$item->tre_name}</a>
        {/foreach}
    {/if}
    <a href="{url href="alias=articles"}" class="all-news">
        <input type="button"  name="news"  class="btnblue grbt tx btgr allnews" value="{lang code="allarticles.catalog.link" ucf=true}" />
    </a>
</div>
{/if}
{/strip}