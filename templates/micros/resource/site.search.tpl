{strip}
<style>
	#menu_itc{
		font-size:0.85em;
		height:3.2em;
		color:#000;
		text-align:center;
		border-bottom:1px solid #DDDDDD;
		padding:0 0 10px;
	}

	#menu_itc div{
		width:44em;
		margin:auto;
	}

	#menu_itc span{
		float:left;
		padding:10px 18px;
		border-bottom:4px solid #f00;
	}

	#menu_itc a{
		display:block;
		float:left;
		text-align:center;
		padding:10px 18px;
		text-decoration:none;
	}

	#menu_itc a:hover{
		border-bottom:4px solid #e8e8e8;
	}

	.search_results{
		padding-top:5px;
		padding-bottom:20px;
	}

	.underhead_link{
		color:#003399;
		padding-top:2px;
	}

	.underhead_type{
		color:#009933;
		padding-top:2px;
	}

	.search_short_text{
		padding-top:2px;
	}

	span.number{
		position:relative;
		left:0;
		top:0;
	}

	span.number span{
		position:absolute;
		right:10px;
		top:15px;
		text-align::right;
	}

	ol#search_list{
		margin-left:50px;
		width:600px;
		margin-bottom:15px;
		list-style-type:none;
	}

	ol#search_list li{
		clear:both;
		padding-top:10px;
	}

</style>

<!--div id="menu_itc">
    <div>
        <span>Все результаты</span>
        <a href="{url href="alias=search&s=`$search`"}">Продукция</a>
        <a href="#">Новости</a>
        <a href="#">Статьи</a>
        <a href="#">Страницы</a>  
    </div>
</div-->
	{if isset($error_message) && !empty($error_message)}
	<div class="error">{$error_message}</div>
		{else}
	<div class="search_results">
		{if count($search_results)}
			{assign var="num" value="`$page*10-10`"}
			<div style="text-align: center; font-weight: bold;">{lang code="search_result.search.text" ucf=true} "{$search_str}":</div>
			<ol id="search_list">
				{foreach $search_results as $item}
					{assign var="num" value="`$num+1`"}
					<li><span class="number"><span>{$num}.</span></span>

						<div class="s_res">
							<h3><a target="_blank" href="
                    {if isset($item.entety_type)}
                    	{switch $item.entety_type}
                            {case 'catalog'}
                                {url href="alias=product&p=`$item.id`"}
                            {/case}
                            {case 'news'}
                                {url href="alias=news&nid=`$item.id`"}
                            {/case}
                            {case 'pages'}
                                {url href="alias=page&pgid=`$item.id`"}
                            {/case}
                            {case 'articles'}
                                {url href="alias=articles&a=`$item.id`"}
                            {/case}
                        {/switch}
                    {elseif isset($item.url)}
                        {$item.url}
                    {/if}
                    ">{$item.title}</a></h3>
							{if isset($item.entety_type)}
								<div class="underhead_type">{lang code="-type" ucf=true}:
									{switch $item.entety_type}
										{case 'catalog'}
											{lang code="-catalog.title"}
										{/case}
										{case 'news'}
											{lang code="-news.title"}
										{/case}
										{case 'pages'}
											{lang code="-page.title"}
										{/case}
										{case 'articles'}
											{lang code="-article.title"}
										{/case}
									{/switch}
								</div>
							{/if}
							<span class="search_short_text">
                    {if isset($item.image) and !empty($item.image)}
						<img width="50px" height="50px" align="left"
							 src="{const SITE_URL}image.php?f={$item.image}&w=155&h=300&m={$item.entety_type}"/>
					{/if}
								{$item.shortdesc}
                </span>
						</div>
					</li>
				{/foreach}
			</ol>
			<div style="text-align: center">
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
					<span class="total">{$pages_count-1}&nbsp;{lang code="pages.catalog.text"}</span>
				{/if}
			</div>
			{else}
			<div style="text-align: center; font-weight: bold;">{lang code="emptypart1.search.message" ucf=true} "{$search_str}" {lang code="emptypart2.search.message"}</div>
		{/if}
	</div>
	{/if}
{/strip}