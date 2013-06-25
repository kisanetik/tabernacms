{assign var="nt" value=1}
{strip}
    <div class="div_products_carousel same">
        {if $params->cs_type eq 1}
        <img src="/img/des/modern/best-choise.png" class="tovar_nedeli" alt="">
        {/if}
        <div class="jcarousel-container jcarousel-container-horizontal">
                <div data-jcarousel="true" data-wrap="both" class="carousel jcarousel-clip jcarousel-clip-horizontal">
                    <ul class="jcarousel-list products_carousel jcarousel-list-horizontal inlinestyle">
                        {foreach $products as $product}
                        <li class="jcarousel-item jcarousel-item-horizontal inlinestyle">
                            <div data-article="{$product->cat_id}" class="b-minicard">
                                <div class="b-minicard-inner">
                                    <div class="b-minicard-content">
                                        <div class="bm-photo">
                                            {if !empty($product->img_filename)}
                                                <a title="{$product->cat_name}"
                                                   href="{url href="alias=product&p=`$product->cat_id`"}">
                                                    <img class="lazy" title="{$product->cat_name}"
                                                         alt="{$product->cat_name}"
                                                         src="{const SITE_URL}image.php?w=100&h=200&m=catalog&f={$product->img_filename}"
                                                         data-original="{const SITE_URL}image.php?w=50&h=65&m=catalog&f={$product->img_filename}"
                                                    >
                                                </a>
                                            {/if}
                                        </div>
                                        <div class="bm-name">
                                            <a href="{url href="alias=product&p=`$product->cat_id`"}">{$product->cat_name}</a>
                                        </div>
                                        <div class="bm-manufacturer"><a href="/brand/NatureS/">NatureS</a></div>
                                        <div class="bm-price">
                                            <span class="js-price">{$product->cat_cost}</span> <span
                                                    class="currency">{$product->currency_indicate}</span>
                                        </div>
                                    </div>
                                    <div class="bm-hide-info select-group">
                                        <noindex>
                                            <span class="button-v2 add2Cart" data-article="{$product->cat_id}"
                                                  active="no" data-count="1">{lang code="buy.catalog.text"}</span>
                                        </noindex>
                                    </div>
                                    <i class="bm-top-left-border"></i>
                                </div>
                            </div>
                        </li>
                        {/foreach}
                    </ul>
                </div>
            <a href="#" data-jcarousel-control="true" data-target="+=1" class="jcarousel-next jcarousel-next-horizontal" ></a>
            <a href="#" data-jcarousel-control="true" data-target="-=1" class="jcarousel-prev jcarousel-prev-horizontal" ></a>

        </div>
    </div>
{/strip}
{url file="jscss/components/jquery/jcarousel/dist/jquery.jcarousel.min.js" type="js"}
{url file="jscss/components/jquery/jcarousel/dist/jquery.jcarousel-control.min.js" type="js"}
<script type="text/javascript">
    (function($) {
        $(function() {
            $('[data-jcarousel]').each(function() {
                var el = $(this);
                el.jcarousel(el.data());
            });
            $('.jcarousel-next').jcarouselControl({
                target: '+=1'
            });
            $('.jcarousel-prev').jcarouselControl({
                target: '-=1'
            });
        });
    })(jQuery);
</script>