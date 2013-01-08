{strip}
{if !empty($action) and $action eq 'showbinwindow'}
	<div class="binwindow_wrapper" style="position:relative;">
		<div class="binwindow">
			<input type="button" value="" class="close" onclick="javascript:$(this).parents('.binwindow').fadeOut(100).parent('binwindow_wrapper').remove();">
			{if !empty($items)}
				<div class="bin_goods_list">
					{foreach $items as $item}
						<div class="bin_field_good">
							<div class="right_side">{$item->cat_cost*$item->cat_count|string_format:"%.2f"} {$curr->cur_ind}</div>
							{$item->cat_name} <span>({$item->cat_cost|string_format:"%.2f"} &times; {$item->cat_count|string_format:"%.0f"})</span>
						</div>
					{/foreach}
					<div class="total_costs">{lang code="-total" ucf=true} <span>{$total_costs|string_format:"%.2f"} {if $total_costs}{currency get="ind"}{/if}</span></div>
				</div>
			{/if}
			<div class="bin_buttons">
				<a href="javascript:void(0);" onclick="javascript:$(this).parents('.binwindow').fadeOut(100).parent('binwindow_wrapper').remove();">{lang code='continueshopping.basket.title'}</a>
				<a href="{url href='alias=order.html'}">{lang code='order.basket.link'}</a>
			</div>
		</div>
	</div>
{else}
	<script language="JavaScript" type="text/javascript">
		var URL_ORDER = '{url href="alias=order.html"}';
	</script>
	{if empty($action) or $action neq 'refreshbin'}<div id="prebasket">{/if}
	<ul class="uplist upl2">
		<li class="topic">{lang code='yourbin.bin.title' ucf=true}</li>
	{if count($items)}
			{*
			{if empty($action) or $action neq 'refreshbin'}<li><ul class="menu_basket"{if !count($items)} style="display:none;"{/if}>{/if}
				<li class="title">
				  <span class="menu_title">{lang code='basket.catalog.title' ucf=true}</span>
				</li>
				<li>
				  <p class="small_text">{lang code='youchoosebasket.catalog.title' ucf=true}:</p>
				  {foreach from=$items item="item"}
					  <div class="basket_image">
					  {assign var="img_showed" value=false}
					  {if !empty($item->product->images_link)}
						  {foreach from=$item->product->images_link item="img"}
							  {if $img->img_main}
								  <img src="{const SITE_URL}image.php?w=44&h=44&m=catalog&f={$img->img_filename}" alt="{$item->product->cat_name}"/>
								  {assign var="img_showed" value=true}
							  {/if}
						  {/foreach}
					  {/if}
					  {if !$img_showed}
						  
					  {/if}
					  </div>
					  <div class="about_product">
						<a href="{url href="alias=product&p=`$item->product->cat_id`"}" class="prod_name">{$item->product->cat_name}</a>
						<br />
						{if !empty($item->product->tree_link[0]->tre_id)}
						  {lang code="category.catalog.text"}:<br />
						  <a href="{url href="alias=catalog.html&cat=`$item->product->tree_link[0]->tre_id`"}" class="kat_name">{$item->product->tree_link[0]->tre_name}</a>
						{else}
						  <a class="kat_name">&nbsp;</a>
						{/if}
					  </div>
				  {/foreach}
				</li>
				<li class="basket_order">
				  <a href="{url href="alias=order.html"}">{lang code='order.basket.link'}</a>
			{if empty($action) or $action neq 'refreshbin'}</ul></li>{/if}
			*}
				<li><a href="{url href="alias=order.html"}"><span>{$count|string_format:"%.0f"}</span> {lang code="productsintheamount.catalog.text"} <span>{$cost|string_format:"%.2f"}</span> {$curr->cur_ind}</a></li>
	{else}
		<li>
			<a href="{url href="alias=order.html"}"><span>{$count|string_format:"%.0f"}</span> {lang code="productsintheamount.catalog.text"} <span>{$cost|string_format:"%.2f"}</span> {$curr->cur_ind}</a>
		</li>     
	{/if}
	</ul>
	{if count($items)}
		<input type="button" name="pay" onclick="javascript:RADBIN.doOrder();" class="fright btnblue tx wt pay" value="{lang code="order.catalog.title" ucf=true}" />
	{/if}
	{if empty($action) or $action neq 'refreshbin'}</div>{/if}
{/if}
{/strip}