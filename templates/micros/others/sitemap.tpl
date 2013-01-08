{strip}
    <div class="sitemap">
        <h1>{lang code='sitemap.others.title' ucf=true}</h1><br />
        {if !empty($pages)}
            <h2>{lang code="pages.others.title" ucf=true}: </h2>
            {include file="$_CURRENT_LOAD_PATH/sitemap/pages.tpl" pages=$pages}
        {/if}
        {if !empty($articles)}
            <h2>{lang code="articles.others.title" ucf=true}: </h2>
            {include file="$_CURRENT_LOAD_PATH/sitemap/articles.tpl" articles=$articles}
        {/if}
        {if !empty($news)}
            <h2>{lang code="news.others.title" ucf=true}: </h2>
            {include file="$_CURRENT_LOAD_PATH/sitemap/news.tpl" news=$news}
        {/if}
        {if !empty($catalog)}
            <h2>{lang code="catalog.others.title" ucf=true}: </h2>
            {include file="$_CURRENT_LOAD_PATH/sitemap/catalog.tpl" catalog=$catalog}
        {/if}
    </div>
{/strip}
