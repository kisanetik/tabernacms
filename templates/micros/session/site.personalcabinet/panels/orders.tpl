{strip}
{url type="js" file="alias=SITE_ALIASXML&action=getjs"}
<script type="text/javascript">
$('#orders').addClass('act');
$('#orders').removeAttr('href');
</script>
{if isset($orderInfo)}
<h1>{lang code='order.order.title' ucf=true} # {$orderInfo->order_num}</h1>
<a href="{url href='alias=personalcabinet&action=orders'}" class="proc" >&larr; {lang code='backtoorders.order.title' ucf=true}</a>
<div class="rpart" id="basket_content_list">
    <div class="basket">
        <div class="upbst">
            <div class="col1 col"><span>{lang code='nameproduct.basket.title' ucf=true}</span></div>{*Наименование*}
            <div class="col2 col"><span>{lang code='count.basket.title' ucf=true}</span><span class="fwnrml"></span></div>{*Кол-во*}
            <div class="col3 col"><span>{lang code='summproduct.basket.title' ucf=true}</span></div>
        </div>
{foreach $orderInfo->order_positions as $op name=products}
        <div class="field_goods{if $smarty.foreach.products.last} bordnn{/if}">
            <div class="col1 col">
                <div class="product">
                    <img src="{if $op->photo neq ''}{const SITE_URL}image.php?f={$op->photo}&amp;w=27&amp;h=45&amp;m=catalog{else}{const SITE_URL}img/des/default/No_image_available.png{/if}" width="27" height="45" alt="{$op->orp_name}" />
                    <a href="{url href="alias=product&p=`$op->orp_catid`"}" target="_blank">{$op->orp_name}</a><br/>
                    <span class="spnprice">{$op->orp_cost} {$orderInfo->order_currency}</span>
                </div>
            </div>
            <div class="col2 col">{$op->orp_count|string_format:"%d"} шт.</div>
            <div class="col3 col"><span>{$op->orp_cost * $op->orp_count} {$orderInfo->order_currency}</span></div>
        </div>
{/foreach}
        <div class="underbst"><h2>{lang code='finnalysumm.order.title' ucf=true} <span>{$orderInfo->order_summ} {$orderInfo->order_currency}</span></h2></div>
    </div>
</div>
{else}
	<div id="basket_content_list" class="rpart">
    <div class="basket"  id="list_orders">
        <div class="upbst">
            <div class="col1 col"><span>{lang code='date.order.title' ucf=true}</span></div>{*Дата*}
            <div class="col2 col"><span>{lang code='code.order.title' ucf=true}</span><span class="fwnrml"></span></div>{*Код заказа*}
            <div class="col3 col"><span>{lang code='summ.order.title' ucf=true}</span></div>{*Сумма*}
        </div>
	{if isset($userOrders)}
		{foreach $userOrders as $order}
        <div class="field_goods">{* bordnn *}
            <div class="col1 col">{$order->order_dt}</div>
            <div class="col2 col">
                <a href="{url href="alias=personalcabinet&action=orders&order_id=`$order->order_id`"}">{$order->order_num}</a><br/>
{lang code="state.order.text" ucf=true}: {if count($types)}
{foreach from=$types item=type}{if $type->tre_id == $order->order_status}{$type->tre_name}{/if}{/foreach}
{else}{lang code='notypes.orders.error' ucf=true}{/if}
            </div>
            <div class="col3 col">{$order->order_summ} {$order->order_currency}</div>
        </div>
		{/foreach}
	{else}
        <div class="field_goods bordnn">{* bordnn *}
            <div>{lang code="-empty" ucf=true}</div>
        </div>
	{/if}

        <div class="underbst"><h2>{lang code="orderstotal.catalog.title" ucf=true}: <span>{$userOrders|@count}</span></h2></div>
    </div>
</div>
{/if}
{/strip}