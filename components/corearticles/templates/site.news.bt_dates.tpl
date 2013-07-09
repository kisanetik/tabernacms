
<div class="news_pnmain_block">
    <div class="news_group">
        
        {foreach from=$bt_news item=li}
        <div class="news_item">
            <div>
                <div style="width:100%;">
                    <a href="{url href="alias=news&nid=`$li->nw_id`"}"><img src="{url module="corearticles" file="news/`$li->nw_img`" type="image" preset="news_xlarge"}" border="0" alt="{$li->nw_title}" title="{$li->nw_title}" /></a>
                </div>
                <div>
                    <a href="{url href="alias=news&nid=`$li->nw_id`"}">{$li->nw_title}</a>
                </div>
            </div>
        </div>
        {/foreach}
    </div>
    <div class="staticpage">
    <div class="news_group">
        
        {foreach from=$last_news item=li}
        <div class="list_news">
            <div class="date">{$li->nw_datenews|date:"date"}</div>
            <h3><a href="{url href="alias=news&nid=`$li->nw_id`"}">{$li->nw_title}</a></h3>
{if strlen($li->nw_img)}
    <div class="categories_image">
        <img src="{url module="corearticles" file="news/`$li->nw_img`" type="image" preset="news_large"}" alt="{$li->nw_title}" title="{$li->nw_title}" border="0" class="imageborder" />
    </div>
{/if}
            
            <p><span style="width:100%;">{$li->nw_shortdesc}</span><br /></p>
            
        </div>
        {/foreach}
    </div>
    </div>
    <div class="clear"></div>
    
</div>
