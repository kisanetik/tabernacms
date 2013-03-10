<table class="tb_list" id="tb_list" width="100%">
	{if count($orders) }
	<tr class="header">
		<td>
			{lang code='dateorder.catalog.title' ucf=true}
		</td>
		<td>
            {lang code='codeorder.catalog.title' ucf=true}
        </td>   
		<td>
			{lang code='typeorder.catalog.title' ucf=true}
		</td>
		<td>
			{lang code='ordersumm.catalog.title' ucf=true}
		</td>
		<td>
			{lang code='orderstate.catalog.title' ucf=true}
		</td>
		<td>
			{lang code='-action' ucf=true}
		</td>
	</tr>
	{foreach from=$orders item=order}
	<tr>
		<td>
			{$order->order_dt}
		</td>
		<td>
            <a href="{url href="alias=CATManageOrders&action=edit&oid=`$order->order_id`"}">{$order->order_num}</a>
        </td>
        <td>
            {switch $order->order_type}
             {case 3}
                     {lang code='quickorder.catalog.select' ucf=true}
             {/case}
             {case 1}
                     {lang code='registerorder.catalog.select' ucf=true}
             {/case}
             {case 2}
                     {lang code='quickregisterorder.catalog.select' ucf=true}
             {/case}             
            {/switch}        
        </td>
		<td>
			{$order->order_summ} ({$order->order_currency})
		</td>
		<td>
			{if count($types)}
			    {foreach from=$types item=type}
				    {if $type->tre_id == $order->order_status}{$type->tre_name}{/if}
				{/foreach}
			{else}
			    {lang code='notypes.orders.error' ucf=true}
			{/if}
		</td>
		<td nowrap="nowrap">
			<a href="{url href="alias=CATManageOrders&action=edit&oid=`$order->order_id`"}">
			    <img src="{const SITE_URL}img/backend/billiard_marker.png" border="0" alt="{lang code='-edit'|replace:'"':'&quot;'}" title="{lang code='-edit'|replace:'"':'&quot;'}" />
			</a>&nbsp;
			<a href="javascript:RADOrdersList.deleteOrder({$order->order_id});">
			    <img src="{const SITE_URL}img/backend/icons/cross.png" border="0" alt="{lang code='-delete'|replace:'"':'&quot;'}" title="{lang code='-delete'|replace:'"':'&quot;'}" />
			</a>&nbsp;
		</td>
	</tr>
	{/foreach}
	<tr>
	{***  PAGING  ****}
	    <td colspan="5" align="left" style="text-align:left;" id="td_paging">
	    {if $pages_count!=$page}{lang code="page.system.link" ucf=true}:&nbsp;
	        {section name="paginator" start=1 loop=$pages_count step=1}
	            {if $smarty.section.paginator.index eq $page}
	                &nbsp;{$smarty.section.paginator.index}&nbsp;
	            {else}
	                <a href="javascript:RADOrdersList.paging({$smarty.section.paginator.index});"> {$smarty.section.paginator.index} </a>
	            {/if}
	        {/section}
	    {/if}
	    </td>
    	<td>{lang code="-total" ucf=true}:{$total_rows}</td>
    {***  END PAGING  ****}
	</tr>
	{else}
	<tr>
		<td width="100%" align="center">
			{lang code='norecords.catalog.text' ucf=true}
		</td>
	</tr>
	{/if}
</table>
