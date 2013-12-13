{strip}
{if !empty($catalog)}
    {foreach from=$catalog item="cat"}
        {if !empty($cat->child)}
            {include file="$_CURRENT_LOAD_PATH/sitemap.export/yandex.products.tpl" catalog=$cat->child}
        {/if}
        {if !empty($cat->products)}
            {foreach from=$cat->products item="product"}
                <offer id="{$product->cat_id}" available="{if $product->cat_availability}true{else}false{/if}">
                    <url>{{url href="alias=product&p=`$product->cat_id`" canonical=true}|escape:'html'}</url>
                    <price>{currency cost="`$product->cat_cost`" curid="`$product->cat_currency_id`"}</price>
                    <currencyId>{currency get="ind"}</currencyId>
                    <categoryId>{$cat->tre_id}</categoryId>
                    {if !empty($product->images_link)}
                        {foreach from=$product->images_link item="img"}
                            <picture>{url module="corecatalog" file="`$img->img_filename`" type="image" preset="product_thumb"}</picture>
                        {/foreach}
                    {/if}
                    <name>{$product->cat_name|htmlspecialchars}</name>
                    {if !empty($product->cat_code)}
                        <vendorCode>{$product->cat_code}</vendorCode>
                    {/if}
                    {if !empty($product->cat_shortdesc)}
                        <description>{$product->cat_shortdesc|htmlspecialchars}</description>
                    {/if}
                    {if !empty($product->cat_article)}
                        <barcode>{$product->cat_article}</barcode>
                    {/if}
                    {if count($product->type_vl_link)}
                        {foreach from=$product->type_vl_link item=item_l name="type_vl"}
                            {if count($item_l->vv_values)}
                                <param name="{$item_l->vl_name}" {if !empty($item_l->ms_value)}unit="{$item_l->ms_value}"{/if}>
                                    {foreach from=$item_l->vv_values item="vv" name="vv"}
                                        {if !empty($vv->vv_value)}
                                             {$vv->vv_value|htmlspecialchars}
                                        {/if}
                                    {/foreach}
                                </param>
                            {/if}
                        {/foreach}
                    {/if}
                </offer>
            {/foreach}
        {/if}
    {/foreach}
{/if}
{/strip}