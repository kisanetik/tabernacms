{strip}
{if !empty($referals_orders)}
    <table class="tb_list" width="100%">
        <tr class="header">
            <td>{lang code="date.system.title" ucf=true}</td>
            <td>{lang code="count.session.title" ucf=true}\{lang code="orders.session.title" ucf=true}</td>
            <td>{lang code="ordersumm.catalog.title" ucf=true}\{lang code="orders.session.title" ucf=true}\{lang code="profit.session.title" ucf=true}</td>
        </tr>
        {assign var="totalRefCount" value=0}
        {assign var="totalRefOrder" value=0}
        {assign var="totalRefSum" value=0}
        {assign var="totalRefVOrder" value=0}
        {assign var="totalRefProfit" value=0}
        {foreach from=$referals_orders item="item" key="refDate"}
            <tr>
                <td>{$refDate|date:'date'}</td>
                <td>
                    {capture name="refCount" assign="refCount"}{$item.referals|@count|default:0}{/capture}
                    {capture name="refOrder" assign="refOrder"}{$item.orders|@count|default:0}{/capture}
                    {$refCount}\{$refOrder}
                    {math equation="x+y" x=$totalRefCount y=$refCount assign="totalRefCount"}
                    {math equation="x+y" x=$totalRefOrder y=$refOrder assign="totalRefOrder"}
                </td>
                <td>
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
                </td>
            </tr>
        {/foreach}
        <tr class="header footer" style="height:auto;">
            <td>
                {lang code="-total" ucf=true}:
            </td>
            <td>
                {$totalRefCount}\{$totalRefOrder}
            </td>
            <td>
                {$totalRefSum|@round:$currency_precision}
                \{$totalRefVOrder|@round:$currency_precision}
                \{$totalRefProfit|@round:$currency_precision}
                &nbsp;{currency get="ind"}
            </td>
        </tr>
    </table>
{else}
    <center><strong>{lang code="norecords.system.text" ucf=true}</strong></center>
{/if}
{/strip}