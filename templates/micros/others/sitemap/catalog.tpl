{strip}
{if !empty($catalog)}
    <ul class="catalog">
        {foreach from=$catalog item="cat"}
            <li>
                <a href="{url href="alias=catalog&cat=`$cat->tre_id`"}">
                    {$cat->tre_name}
                </a>
                {if !empty($cat->child)}
                    {include file="$_CURRENT_LOAD_PATH/sitemap/catalog.tpl" catalog=$cat->child}
                {/if}
                {if !empty($cat->products)}
                    <ul class="products">
                        {foreach from=$cat->products item="product"}
                            <li>
                                <a href="{url href="alias=product&p=`$product->cat_id`"}">
                                    {if !empty($product->img_filename)}
                                        <img src="{const SITE_URL}image.php?m=catalog&w=32&h=32&f={$product->img_filename}" alt="{$product->cat_name|replace:'"':'&quot;'}" />
                                    {/if}
                                    {$product->cat_name}&nbsp;<strong style="color:#000;">{currency cost="`$product->cat_cost`" curid="`$product->cat_currency_id`"} {currency get="ind"}.</strong>
                                </a>
                            </li>
                        {/foreach}
                    </ul>
                {/if}
            </li>
        {/foreach}
    </ul>
{/if}
{/strip}