{literal}<?xml version="1.0" encoding="utf-8"?>{/literal}
<rss version="2.0">
{if isset($RSSPage)}
  <channel>
    <title>{$RSSPage->title|default:'Taberna eCommerce CMS - RSS chanel component'}</title>
    <link>{$RSSPage->link|default:'http://tabernacms.com/'}</link>
    <description>{$RSSPage->description|default:'Default Taberna RSS chanel description text'}</description>
    {if !empty($RSSPage->language)}
    <language>{$RSSPage->language}</language>
    {/if}
    {if !empty($RSSPage->copyright)}
    <copyright>{$RSSPage->copyright}</copyright>
    {/if}
    {if !empty($RSSPage->managingEditor)}
    <managingEditor>{$RSSPage->managingEditor}</managingEditor>
    {/if}
    {if !empty($RSSPage->webMaster)}
    <webMaster>{$RSSPage->webMaster}</webMaster>
    {/if}
    {if !empty($RSSPage->pubDate)}
    <pubDate>{$RSSPage->pubDate}</pubDate>
    {/if}
    {if !empty($RSSPage->lastBuildDate)}
    <lastBuildDate>{$RSSPage->lastBuildDate}</lastBuildDate>
    {/if}
    {if !empty($RSSPage->category)}
    <category>{$RSSPage->category}</category>
    {/if}
    {if !empty($RSSPage->generator)}
    <generator>{$RSSPage->generator}</generator>
    {/if}    
    {if !empty($RSSPage->docs)}
    <docs>{$RSSPage->docs}</docs>
    {/if}
    {if !empty($RSSPage->ttl)}
    <ttl>{$RSSPage->ttl}</ttl>
    {/if}
    {if !empty($RSSPage->rating)}
    <rating>{$RSSPage->rating}</rating>
    {/if}    
    {if !empty($RSSPage->skipHours)}
    <skipHours>{$RSSPage->skipHours}</skipHours>
    {/if}
    {if !empty($RSSPage->skipDays)}
    <skipDays>{$RSSPage->skipDays}</skipDays>
    {/if}
    
    {if !empty($RSSPage->items)}
        {foreach from=$RSSPage->items item=item}
        <item>
            <title>{$item->title|default:''}</title>
            {if !empty($item->link)}
            <link>{$item->link}</link>
            {/if}
            <description>{$item->description|default:''}</description>
            {if !empty($item->author)}
            <author>{$item->author}</author>
            {/if}
            {if !empty($item->category)}
            <category>{$item->category}</category>
            {/if}
            {if !empty($item->comments)}
            <comments>{$item->comments}</comments>
            {/if}
            {if !empty($item->guid)}
            <guid>{$item->guid}</guid>
            {/if}
            {if !empty($item->pubDate)}
            <pubDate>{$item->pubDate}</pubDate>
            {/if}
        </item>            
        {/foreach}
    {/if}
  </channel>
{/if}
</rss>