{strip}
<form method="post" id="includesinaliases">
	<input type="hidden" name="returnURL" id="returnURL" value="" />
	<input type="hidden" name="id" id="alilas_id" value="{$item->id}" />
	<input type="hidden" name="hash" id="hash" value="{$hash|default:''}" />
	
	
	<table cellpadding="0" cellspacing="0" border="0" width="100%">
		<tr>
			<td colspan="3" id="incs_header">
				<div style="border:1px solid blue;">
						<div style="width:100%;color:black;background:#cccccc;">
						HEADER
					</div>
					<div style="width:100%;">
							{foreach from=$item->includes item=id}
							   {if $id->rp_id eq 1}
								 {include file="$_CURRENT_LOAD_PATH/admin.managealiases/inc.incl_list.tpl" id=$id positions=$positions}
							   {/if}
							{/foreach}
					</div>
				</div>
			</td>
		</tr>
		<tr>
			<td colspan="3" id="incs_top">
				<div style="border:1px solid blue;">
						<div style="width:100%;color:black;background:#cccccc;">
						TOP
					</div>
					<div style="width:100%;">
							{foreach from=$item->includes item=id}
							   {if $id->rp_id eq 5}
								 {include file="$_CURRENT_LOAD_PATH/admin.managealiases/inc.incl_list.tpl" id=$id positions=$positions}
							   {/if}
							{/foreach}
					</div>
				</div>
			</td>
			<tr>
				<td id="incs_left">
					<div style="border:1px solid blue;">
						<div style="width:100%;color:black;background:#cccccc;">
							LEFT
						</div>
						<div style="width:100%;">
								{foreach from=$item->includes item=id}
								   {if $id->rp_id eq 4}
									   {include file="$_CURRENT_LOAD_PATH/admin.managealiases/inc.incl_list.tpl" id=$id positions=$positions}
								   {/if}
								{/foreach}
						</div>
					</div>
				</td>
				<td id="incs_center">
					<div style="border:1px solid blue;">
						<div style="width:100%;color:black;background:#cccccc;">
							CENTER
						</div>
						<div style="width:100%;">
								{foreach from=$item->includes item=id}
								   {if $id->rp_id eq 2}
									   {include file="$_CURRENT_LOAD_PATH/admin.managealiases/inc.incl_list.tpl" id=$id positions=$positions}
								   {/if}
								{/foreach}
						</div>
					</div>
				</td>
				<td id="incs_right">
					<div style="border:1px solid blue;">
						<div style="width:100%;color:black;background:#cccccc;">
							RIGHT
						</div>
						<div style="width:100%;">
								{foreach from=$item->includes item=id}
								   {if $id->rp_id eq 6}
									   {include file="$_CURRENT_LOAD_PATH/admin.managealiases/inc.incl_list.tpl" id=$id positions=$positions}
								   {/if}
								{/foreach}
						</div>
					</div>
				</td>
			</tr>
			<tr>
				<td colspan="3" id="incs_top">
					<div style="border:1px solid blue;">
						<div style="width:100%;color:black;background:#cccccc;">
							BOTTOM
						</div>
						<div style="width:100%;">
								{foreach from=$item->includes item=id}
								   {if $id->rp_id eq 7}
										{include file="$_CURRENT_LOAD_PATH/admin.managealiases/inc.incl_list.tpl" id=$id positions=$positions}
								   {/if}
								{/foreach}
						</div>
					</div>
				</td>
			</tr>
			<tr>
				<td colspan="3" id="incs_top">
					<div style="border:1px solid blue;">
						<div style="width:100%;color:black;background:#cccccc;">
							FOOTER
						</div>
						<div style="width:100%;">
								{foreach from=$item->includes item=id}
								   {if $id->rp_id eq 3}
										{include file="$_CURRENT_LOAD_PATH/admin.managealiases/inc.incl_list.tpl" id=$id positions=$positions}
								   {/if}
								{/foreach}
						</div>
					</div>
				</td>
			</tr>
	</table>                                    										
</form>
{/strip}