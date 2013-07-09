{strip}
    <div class="sitemap">
        <h1>{lang code='sitemap.others.title' ucf=true}</h1><br />
        {if !empty($pagesTree)}
            <h2>{lang code="pages.others.title" ucf=true}: </h2>
            {include file="$_CURRENT_LOAD_PATH/sitemap/pages.tpl" pagesTree=$pagesTree}
        {/if}
        {if !empty($articlesTree)}
            <h2>{lang code="articles.others.title" ucf=true}: </h2>
            {include file="$_CURRENT_LOAD_PATH/sitemap/articles.tpl" articlesTree=$articlesTree}
        {/if}
        {if !empty($newsTree)}
            <h2>{lang code="news.others.title" ucf=true}: </h2>
            {include file="$_CURRENT_LOAD_PATH/sitemap/news.tpl" newsTree=$newsTree}
        {/if}
        {if !empty($catalog)}
            <h2>{lang code="catalog.others.title" ucf=true}: </h2>
            {include file="$_CURRENT_LOAD_PATH/sitemap/catalog.tpl" catalog=$catalog}
        {/if}
    </div>
{/strip}
