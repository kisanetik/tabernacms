{strip}
{if isset($recommendProducts) and !empty($recommendProducts)}
    <div class="new-arrivals">
    <h4>{lang code="recommendproducts.catalog.title" ucf=true}</h4>
    <ul>
        {foreach from=$recommendProducts item="item"}
            <li>
                <a href="{url href="alias=product&p=`$item->cat_id`"}">
                    <div class="image">
                        {if !empty($item->images_link)}
                            {foreach from=$item->images_link item="img"}
                                {if $img->img_main eq 1}
                                    <img src="{const SITE_URL}image.php?w=150&h=150&m=catalog&f={$img->img_filename}" alt="{$item->cat_name|replace:'"':'&quot;'}" />
                                {/if}
                            {/foreach}  
                        {else} 
                             <img src="{const SITE_URL}img/des/default/No_image_available.png"  width="150" height="150" />
                        {/if}                        
                    </div>
                    <span>
                        {$item->cat_name}
                    </span>
                    <p>
                        {currency cost="`$item->cat_cost`" curid="`$item->cat_currency_id`"} {currency get="ind"}
                    </p>
                </a>
            </li>
        {/foreach}
    </ul>
    </div>
{/if}
{/strip}