{assign var="nt" value=1}
{strip}
{if $params->cs_type eq 1}
    {if count($products)}
        <div class="note {$params->cssclass}">
        <h4>{lang code='productnew.catalog.text'}</h4>
            {foreach $products as $product}
                <div class="nam">
                    <div class="smallpic">
                        {if !empty($product->img_filename)}
                            <a href="{url href="alias=product&p=`$product->cat_id`"}">
                                <img src="{url module="corecatalog" file="`$product->img_filename`" type="image" preset="product_tiny"}" />
                            </a>
                        {/if}
                    </div>
                    <a href="{url href="alias=product&p=`$product->cat_id`"}">{$product->cat_name}</a>
                    <span>{$product->cat_cost} {currency get="shortname"} </span>
                </div>
            {/foreach}
        </div>
    {/if}
{/if}
{if $params->cs_type eq 2}
    {if count($products)}
        <div class="note {$params->cssclass}">
            <h4>{lang code="productsp.catalog.text"}</h4>
            {foreach $products as $product}
                <div class="nam">
                    <div class="smallpic">
                        {if !empty($product->img_filename)}
                            <a href="{url href="alias=product&p=`$product->cat_id`"}">
                                <img src="{url module="corecatalog" file="`$product->img_filename`" type="image" preset="product_tiny"}" />
                            </a>
                        {/if}
                    </div>
                    <a href="{url href="alias=product&p=`$product->cat_id`"}">{$product->cat_name}</a>
                    <span>{$product->cat_cost} {currency get="shortname"} </span>
                </div>
            {/foreach}
        </div>
    {/if}
{/if}
{if $params->cs_type eq 3}
    {if count($products)}
        <div class="note {$params->cssclass}">
            <h4>{lang code='productspoffer.catalog.text'}</h4>
            {foreach $products as $product}
                <div class="nam">
                    <div class="smallpic">
                        {if !empty($product->img_filename)}
                            <a href="{url href="alias=product&p=`$product->cat_id`"}">
                                <img src="{url module="corecatalog" file="`$product->img_filename`" type="image" preset="product_tiny"}" />
                            </a>
                        {/if}
                    </div>
                    <a href="{url href="alias=product&p=`$product->cat_id`"}">{$product->cat_name}</a>
                    <span>{$product->cat_cost} {currency get="shortname"} </span>
                </div>
            {/foreach}
        </div>
    {/if}
{/if}
{if $params->cs_type eq 4}
    {if count($products)}
        <div class="note {$params->cssclass}">
            <h4>{lang code='productsphit.catalog.text'}</h4>
            {foreach $products as $product}
                <div class="nam">
                    <div class="smallpic">
                        {if !empty($product->img_filename)}
                            <a href="{url href="alias=product&p=`$product->cat_id`"}">
                                <img src="{url module="corecatalog" file="`$product->img_filename`" type="image" preset="product_tiny"}" />
                            </a>
                        {/if}
                    </div>
                    <a href="{url href="alias=product&p=`$product->cat_id`"}">{$product->cat_name}</a>
                    <span>{$product->cat_cost} {currency get="shortname"} </span>
                </div>
            {/foreach}
        </div>
    {/if}
{/if}
{/strip}