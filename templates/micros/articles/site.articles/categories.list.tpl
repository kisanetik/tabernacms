{strip}
    <div class="staticpage">
		<div class="catalog_categories">					
			{foreach from=$categories item=tre name=cats_a}
					{if strlen($tre->tre_image)}
						<div class="category_item">
							<a href="{url href="c=$treid"}">
								<img src="{const SITE_URL}image.php?f={$tre->tre_image}&m=menu&w=180&h=120" alt="{$tre->tre_name|replace:'"':'&quot;'}" title="{$tre->tre_name|replace:'"':'&quot;'}" border="0" class="imageborder"/>
							</a>
						</div>
					{/if}
					<div class="category_item">
						<h3><a href="{url href="c=`$tre->tre_id`"}">{$tre->tre_name}</a></h3>
					</div>
				
			{/foreach}
		 </div>
    </div>
{/strip}