{strip}
<table cellpadding="0" cellspacing="0" border="0" id="tb_list" class="tb_list" width="100%">
    <tr class="header">
        <td>
            {lang code='productarticle.catalog.title' ucf=true}
        </td>
        <td>
            {lang code='productcode.catalog.title' ucf=true}
        </td>
        <td>
            {lang code='nameproduct.order.title' ucf=true}
        </td>
        <td>
            {lang code='coustproduct.order.title' ucf=true}({$order->order_currency})
        </td>
        <td>
            {lang code='sizeproduct.order.title' ucf=true}
        </td>
        <td>
            {lang code='summproduct.order.title' ucf=true}({$order->order_currency})
        </td>
        <td width="50px">
            {lang code='-action' ucf=true}
        </td>
    </tr>
    {if count($order->order_positions)}
       {foreach from=$order->order_positions item=item}
       <tr>
           <td>
                <a href="{url href="alias=product&p=`$item->orp_catid`"}">
                    {$item->orp_article}
                </a>
           </td>
           <td>
                <a href="{url href="alias=product&p=`$item->orp_catid`"}">
                    {$item->orp_code}
                </a>
           </td>
              <td>
                     <a href="{url href="alias=product&p=`$item->orp_catid`"}">
                   {$item->orp_name}
               </a>
              </td>
           <td>
                  {$item->orp_cost}{*({$item->orp_currency})*}
           </td>
           <td>
                  <input type="text" name="p_count_{$item->orp_catid}" id="p_count_{$item->orp_catid}" value="{$item->orp_count}" style="width:60px;" onblur="RADOrders.changeCount({$item->orp_catid});" />
           </td>
           <td>
                  {$item->orp_count*$item->orp_cost}{*&nbsp;({$item->orp_currency})*}
           </td>
           <td nowrap="nowrap" align="center">
            <a href="javascript:RADOrders.deleteOrder({$item->orp_catid});">
                <img src="{url type="image" module="core" preset="original" file="backend/icons/cross.png"}" border="0" alt="{lang code='-delete'|replace:'"':'&quot;'}" title="{lang code='-delete'|replace:'"':'&quot;'}" />
            </a>
           </td>
       </tr>
       {/foreach}
       {if !empty($order->delivery)}
           <tr>
               <td colspan="2"></td>
               <td>
                   {lang code="deliveryposition.catalog.text" ucf=true}
               </td>
               <td colspan="3">{currency cost="`$order->delivery->rdl_cost`" curid="`$order->delivery->rdl_currency`"}<td>
           </tr>
       {/if}
    {/if}
    <tr class="header">
        <td colspan="4">{lang code='-Total'}</td>
        <td>
            {lang code='totalcount.order.text'}:&nbsp;
            {$total_count}
        </td>
        <td>
            {*{lang code='totalcost.order.text'}:&nbsp;{$total_cost}&nbsp;({currency get="shortname"})*}
            {$order->order_summ}&nbsp;({$order->order_currency})
        </td>
        <td>
          &nbsp;
        </td>
    </tr>
</table>
{/strip}