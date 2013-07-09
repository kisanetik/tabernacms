{strip}
    {if isset($item)}
        <div class="article">
            <h1 class="title">
                {$item->art_title}
            </h1>
{if strlen($item->art_img)}
            <div class="categories_image">
                <img src="{url module="corearticles" file="articles/`$item->art_img`" type="image" preset="article_large"}" alt="{$item->art_title}" title="{$item->art_title}" border="0" class="imageborder" />
            </div>
{/if}
            <div class="centerpage">
                {if strlen($item->art_fulldesc) > 0}
                    {$item->art_fulldesc}
                {/if}
            </div>
        </div>
    {else}
        {if count($categories)}
            {include file="$_CURRENT_LOAD_PATH/site.articles/categories.list.tpl"}
        {/if}

        {if count($items)}
            {include file="$_CURRENT_LOAD_PATH/site.articles/articles.list.tpl"}
        {/if}
    {/if}
{/strip}