{strip}

<div class="staticpage">
{if isset($categories)}
    {if count($categories)}
        <h2>{lang code="newsgroups.catalog.title" ucf=true}</h2>
        <ul class="news">
            {foreach from=$categories item=tre name=cats_a}
                <li>
                    {if strlen($tre->tre_image)}
                        <div class="categories_image">
                            <a href="{url href="t=`$tre->tre_name|@urlencode`&cat_n=`$tre->tre_id`"}">
                                <img src="{url module="coremenus" file="`$tre->tre_image`" type="image" preset="tree_xlarge"}" alt="{$tre->tre_name}" title="{$tre->tre_name}" border="0" class="imageborder"/>
                            </a>
                        </div>
                    {/if}
                    <div class="catalog_item_title">
                        <a href="{url href="t=`$tre->tre_name|@urlencode`&cat_n=`$tre->tre_id`"}">{$tre->tre_name}</a>
                    </div>
                </li>
            {/foreach}
         </ul>
   
    {/if}
{/if}
{if isset($item)}
<div class="fullnews">

        <h1 class="title">{$item->nw_title}</h1>

    <div class="date date_news">
        {$item->nw_datenews|date:'date'}
    </div>
{if strlen($item->nw_img)}
    <div class="categories_image">
        <img src="{url module="corearticles" file="news/`$item->nw_img`" type="image" preset="news_large"}" alt="{$item->nw_title}" title="{$item->nw_title}" border="0" class="imageborder" />
    </div>
{/if}
    <div class="fulldesc">
        {$item->nw_fulldesc}
    </div>
</div>
{/if}
{if isset($items)}
        {foreach from=$items item=item name="left_news"}
            <div class="list_news">
                <h3>
                    <a href="{url href="alias=news&nid=`$item->nw_id`&t=`$item->nw_title|@urlencode`"}">{$item->nw_title}</a>
                </h3>
                <div class="date">
                       {$item->nw_datenews|date_format:"%e.%m.%Y"}
                   </div>
                   <p>
                       {$item->nw_shortdesc}
                   </p>
                   <p>
                       <a href="{url href="alias=news&nid=`$item->nw_id`&t=`$item->nw_title|@urlencode`"}">{lang code="newsdetail.menu.link"}</a>
                   </p>
                                <div class="b1 fclear"></div>
            </div>
        {/foreach}
        {if $title_category}
            <div class="paginator" id="paginator">
                {assign var=gp value=""}
                {if isset($cur_category_id)}{assign var=gp value="`$gp`?t=$title_category&cat_n=$cur_category_id"}{/if}
                {if isset($itemsPerPage)}{assign var=gp value="$gp&i=$itemsPerPage"}{/if}
                <div class="paging">
                    {paginator from=0 
                               to=$pages_count 
                               curpage=$page-1 
                               GET="$gp" 
                               prev_title_text='<' 
                               first_title_text='<<' 
                               next_title_text='>' 
                               last_title_text='>>'
                               showsteps=false
                               showfirst=false
                               showlast=false
                               maxshow=100000}
                </div>
                {if $pages_count > 2}
                    <span class="total">{$pages_count-1}&nbsp;{lang code="newsgroups.catalog.title"}</span>
                {/if}
            </div>
        {/if}
{/if}
</div>

{/strip}