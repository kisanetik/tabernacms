{strip}
{if !empty($referals_orders)}
<div class="upbst">
    <div class="col1 col">
        <span>{lang code="date.system.title" ucf=true}</span>
    </div>
    <div class="col2 col">
        <span>{lang code="count.session.title" ucf=true}\{lang code="orders.session.title" ucf=true}</span>
    </div>
    <div class="col3 col">
        <span>{lang code="ordersumm.catalog.title" ucf=true}\{lang code="orders.session.title" ucf=true}\{lang code="profit.session.title" ucf=true}</span>
    </div>
</div>
{assign var="totalRefCount" value=0}
{assign var="totalRefOrder" value=0}
{assign var="totalRefSum" value=0}
{assign var="totalRefVOrder" value=0}
{assign var="totalRefProfit" value=0}
{foreach from=$referals_orders item="item" key="refDate"}
<div class="field_goods">
    <div class="col1 col">
        {$refDate|date:'date'}
    </div>
    <div class="col2 col">
        {capture name="refCount" assign="refCount"}{$item.referals|@count|default:0}{/capture}
        {capture name="refOrder" assign="refOrder"}{$item.orders|@count|default:0}{/capture}
        {$refCount}\{$refOrder}
        {math equation="x+y" x=$totalRefCount y=$refCount assign="totalRefCount"}
        {math equation="x+y" x=$totalRefOrder y=$refOrder assign="totalRefOrder"}
    </div>
    <div class="col3 col">
        {assign var="refSum" value=0}
        {assign var="refOrder" value=0}
        {if !empty($item.orders)}
            {foreach from=$item.orders item="order"}
                {capture name="orderSum" assign="orderSum"}{currency cost="`$order->rro_order_sum`" curid="`$order->rro_currency_id`"}{/capture}
                {math equation="x+y" x=$refSum y=$orderSum assign="refSum"}
                {if $order->order_status eq $referals_closed_order}
                    {math equation="x+y" x=$refOrder y=$orderSum assign="refOrder"}
                {/if}
            {/foreach}
        {/if}
        {capture name="refProfit" assign="refProfit"}{math equation="x/100*y" x=$refOrder y=$partner_percent}{/capture}
        {$refSum|@round:$currency_precision}\{$refOrder|@round:$currency_precision}\{$refProfit|@round:$currency_precision}&nbsp;{currency get="ind"}
        {math equation="x+y" x=$totalRefSum y=$refSum assign="totalRefSum"}
        {math equation="x+y" x=$totalRefVOrder y=$refOrder assign="totalRefVOrder"}
        {math equation="x+y" x=$totalRefProfit y=$refProfit assign="totalRefProfit"}
    </div>
</div>
{/foreach}
<div class="underbst">
    <h2>
        {lang code="-total" ucf=true}:
        <span class="col3">
            {$totalRefSum|@round:$currency_precision}
            \{$totalRefVOrder|@round:$currency_precision}
            \{$totalRefProfit|@round:$currency_precision}
            &nbsp;{currency get="ind"}
        </span> 
        <span class="col2">{$totalRefCount}\{$totalRefOrder}</span> 
    </h2>
</div>
{/if}
{/strip}