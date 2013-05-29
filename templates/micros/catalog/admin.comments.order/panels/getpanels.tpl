{strip}
{if isset($getParamExists) and $getParamExists}
<div id="order-comments">
	<div class="comments-order">
	{url type="js" file="alias=CATcommentsXML&comments_action=getjs"}
	<table align="left" cellspacing="0" cellpadding="0" border="0" style="height:auto;width:auto;" class="tb_cont_block" id="detailClientBlock">
		<tr>
			<td class="corner_lt"></td>
			<td class="header_top"></td>
			<td class="corner_rt"></td>
		</tr>
		<tr>
			<td class="left_border"></td>
			<td style="height:28px;" class="header_bootom">
				<div class="hb">
					<div class="hb_inner">
						<table width="100%" cellspacing="0" cellpadding="0" border="0">
							<tr>
								<td>
									<div class="block_header_title">{lang code="ordercomments.catalog.title" ucf=true}</div>
								</td>
								<td>
									<div style="text-align: right;" class="block_header_title"></div>
								</td>
							</tr>
						</table>
					</div>
				</div>
			</td>
			<td class="right_border"></td>
		</tr>
		<tr>
			<td nowrap="nowrap" style="width:3px;" class="left_border"></td>
			<td align="left" id="panel_orderDetail">
				<table align="center" cellspacing="0" cellpadding="3" border="0" class="tb_list">
					<tr>
						<td style="padding:0px;">
							<form method="post" id="commentForm" style="margin:0px" onsubmit="RADAdminOrderComments.addComment({$item_id});return false;">
								<table cellspacing="0" cellpadding="0" border="0" width="100%">
									<tr>
										<td><input type="text" id="comment_text" name="comment_text" value="{lang code='commenttext.catalog.text'}" style="margin-bottom:0px" onfocus="if (this.value=='{lang code="commenttext.catalog.text"}') this.value='';" onblur="if (this.value==''){literal}{{/literal}this.value='{lang code="commenttext.catalog.text"}'{literal}}{/literal}"/></td>
										<td>
										  <input type="submit" value="{lang code='-submit' ucf=true}" style="margin-bottom:0px"/>
										  <input type="hidden" id="hash" name="hash" value="{$hash}"/>
										</td>
									</tr>
								</table>
							</form>
						</td>
					</tr>
					<tr>
						<td colspan="2">
							<div id="drag">
								{foreach $items as $item}
									<div class="inside drag"><span class="comuserdate">{$item->rcm_nickname} ({$item->rcm_datetime|date:'date'} {$item->rcm_datetime|date_format:'%H:%M:%S'}):</span> {$item->rcm_text}</div>
								{/foreach}
							</div>
						</td>
					</tr>
				</table>
			</td>
			<td nowrap="nowrap" style="width:3px;" class="right_border"></td>
		</tr>
		<tr>
			<td class="left_border"></td>
			<td class="gray_line"></td>
			<td class="right_border"></td>
		</tr>
		<tr>
			<td class="corner_lb"></td>
			<td class="tb_bottom"></td>
			<td class="corner_rb"></td>
		</tr>
	</table>
	</div>
</div>
{/if}
{/strip}