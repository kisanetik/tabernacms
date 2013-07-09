{strip}
    <h1>{lang code='basket.basket.title' ucf=true ucf=true}</h1>
    <a href="{url href='alias=catalog'}" class="proc" >&larr; {lang code='continueshopping.basket.title' ucf=true}</a>
    <div class="basket">
        <div class="upbst">
            <div class="col1 col"><span>{lang code='nameproduct.basket.title' ucf=true}</span>
            </div>
            <div class="col2 col"><span>{lang code='countproduct.basket.title' ucf=true}</span><span class="fwnrml"> ({lang code="pcs.catalog.title"})</span>
            </div>
            <div class="col3 col"><span style="margin-right: 30px">{lang code='summproduct.basket.title' ucf=true}</span>
            </div>
        </div>
        {if !empty($items)}
            {foreach $items as $item}
                {if $item@last}
                    <div class="field_goods bordnn">
                {else}
                    <div class="field_goods">
                {/if}
                    <div class="col1 col">
                        <div class="product">
                            {if $item->img_filename}
                            <img src="{url module="corecatalog" file="`$item->img_filename`" type="image" preset="product_tiny2"}" alt="{$item->cat_name|replace:'"':'&quot;'}"/>
                                 {else}
                                 <img src="{url module="core" file="des/No_image_available.png" type="image" preset="original"}" alt="{$item->cat_name|replace:'"':'&quot;'}" width="27" height="45"  />
                                 {/if}
                                 <a href="{url href="alias=product&p=`$item->cat_id`"}" class="lnkgoods">{$item->cat_name}</a><br/>
                            <span class="spnprice">{$item->cat_cost|string_format:"%.2f"} {currency get="shortname"}</span>
                        </div>
                        <a href="javascript:RADBIN.deleteFromBin({$item->bp_id});" ><img src="{url module="core" file="des/del.png" type="image" preset="original"}" width="9" height="9" title="del" ></a>
                    </div>
                    <div class="col2 col">
                        <input type="button"  name="minus"  class="tx txdigit digit" value="&minus;" onclick="javascript:RADBIN.changeCount({$item->bp_id},'-1');" />
                        <input type="text" class="amount" id="count_bp{$item->bp_id}" value="{$item->cat_count|string_format:"%.0f"}" onblur="javascript:RADBIN.setCount({$item->bp_id}, this.value);" />
                        <input type="button"  name="plus"  class="tx txdigit digit" value="+" onclick="javascript:RADBIN.changeCount({$item->bp_id},'+1');" />
                    </div>
                    <div class="col3 col">
                        <span>{$item->cat_cost*$item->cat_count|string_format:"%.2f"} {currency get="shortname"}</span>
                    </div>
                </div>
            {/foreach}
        <div class="underbst">
            <h2>{lang code="-total" ucf=true} <span><span id="total_costs">{$total_costs|string_format:"%.2f"}</span> {if $total_costs}{currency get="shortname"}{/if}</span></h2>
        </div>
        {else}
            <center>{lang code="emptybin.catalog.text" utf=true}</center>
            <script language="JavaScript" type="text/javascript">
                $('#basket_order_data').hide();
            </script>
        {/if}
    </div>
{/strip}