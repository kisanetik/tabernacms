{strip}
    {if !empty($items)}
        {if $params->type_show eq 'last'}
            <div class="new-arrivals">
            <h4>{lang code="newarrivals.catalog.title" ucf=true}</h4>
                <ul>
                    {foreach from=$items item="item"}
                        <li>
                            <a href="{url href="alias=product&p=`$item->cat_id`"}">
                                <div class="image">
                                    <img src="{const SITE_URL}image.php?w=150&h=150&m=catalog&f={$item->img_filename}" alt="{$item->cat_name|replace:'"':'&quot;'}" />
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
         {elseif $params->type_show eq 'showed'}
             <div class="new-arrivals">
             <h4>{lang code="mostshowed.catalog.title" ucf=true}</h4>
                <ul>
                    {foreach from=$items item="item"}
                        <li>
                            <a href="{url href="alias=product&p=`$item->cat_id`"}">
                                <div class="image">
                                    <img src="{const SITE_URL}image.php?w=150&h=150&m=catalog&f={$item->img_filename}" alt="{$item->cat_name|replace:'"':'&quot;'}" />
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
    {/if}
{/strip}