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
								<img src="{const SITE_URL}image.php?f={$tre->tre_image}&m=menu&w=180&h=120" alt="{$tre->tre_name}" title="{$tre->tre_name}" border="0" class="imageborder"/>
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
        <img src="{const SITE_URL}image.php?f={$item->nw_img}&m=menu&w=150&h=100&m=news" alt="{$item->nw_title}" title="{$item->nw_title}" border="0" class="imageborder" />
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
{/if}
</div>

{/strip}