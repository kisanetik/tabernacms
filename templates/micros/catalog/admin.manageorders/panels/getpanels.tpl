{url type="js" file="alias=SITE_ALIASXML&action=getjs_list"}
<h1 id="manageOrdersTitle">{lang code='manageorders.catalog.title' ucf=true}</h1>
            <table id="pageslist_block" cellpadding="0" cellspacing="0" border="0" class="tb_cont_block" style="height:auto;width:100%;">
                <tr>
                    <td class="corner_lt"></td>
                    <td class="header_top"></td>
                    <td class="corner_rt"></td>
                </tr>
                <tr>
                    <td class="left_border"></td>
                    <td class="header_bootom">
                        <div class="hb">
                            <div class="hb_inner">
                                <table border="0" cellpadding="0" cellspacing="0" width="100%">
                                <tr>
                                    <td>
                                        <div class="block_header_title">{lang code='orderslist.catalog.title' ucf=true}</div>
                                    </td>
                                    <td>
                                        <div class="block_header_title" style="text-align: right;"><span class="red_color" id="OrdersListMessage"></span></div>
                                    </td>
                                </tr>
                                </table>
                                <div class="tb_line_ico">
                                    <table class="item_ico">
                                        <tr>
                                            <td>
                                                <a href="javascript:RADOrdersList.refresh(RADOrdersList.st);">
                                                    <img src="{const SITE_URL}img/backend/arrow_rotate_clockwise.png" width="30" height="30" border="0" alt="{lang code='-refresh'|replace:'"':'&quot;'}" title="{lang code='-refresh'|replace:'"':'&quot;'}" />
                                                    <span class="text" style="width:50px;">{lang code='-refresh' ucf=true}</span>
                                                </a>
                                            </td>
                                        </tr>
                                    </table>
                                    <table class="item_ico" align="left" style="float:left;margin-top:10px;">
                                       <tr>
                                           <td height="100%" valign="bottom" nowrap="nowrap" width="250">
                                                <form method="post" id="searchPagesForm" action="{url href="action=search"}" onsubmit="return false;">
                                                    <div>
                                                        <div style="float:left;margin-top:5px;">
														    <div>
		                                                        <div style="float:left;">
		                                                        {lang code='ordersstate.catalog.title' ucf=true}<br />
		                                                        <select id="order_status" name="order_status" onchange="RADOrdersList.chFilters();">
		                                                        	<option value="-1">{lang code='-all' ucf=true}</option>
		                                                        {if count($types)}
		                                                          {foreach from=$types item=type}
		                                                          <option value="{$type->tre_id}"{if $params->typestartshow eq $type->tre_id} selected="selected"{/if}>{$type->tre_name}</option>
		                                                          {/foreach}
		                                                        {/if}
		                                                        </select>
		                                                        </div>
		                                                    </div>
														</div>
                                                    </div>
                                                </form>
                                           </td>
                                            <td height="100%" valign="bottom" nowrap="nowrap" width="250">
                                                <form method="post" id="searchPagesForm" action="{url href="action=search"}" onsubmit="return false;">
                                                        <div>
                                                            <div style="float:left;margin-top:5px;">
                                                                <div>
                                                                    <div style="float:left;">
                                                                        {lang code="ordersscheme.catalog.title" ucf=true}:<br />
                                                                        <select name="order_scheme" id="order_scheme" onchange="RADOrdersList.chFilters();">
                                                                        	<option value="-1">{lang code='-all' ucf=true}</option>
                                                                            <option value="3">{lang code="quickorder.catalog.select" ucf=true}</option>
                                                                            <option value="1">{lang code="registerorder.catalog.select" ucf=true}</option>
                                                                            <option value="2">{lang code="quickregisterorder.catalog.select" ucf=true}</option>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                </form>                                
                                            </td>
                                       </tr>
                                    </table>
                                    <div class="clear_rt"></div>
                                </div>
                            </div>
                        </div>
                    </td>
                    <td class="right_border"></td>
                </tr>
                <tr>
                    <td class="left_border" nowrap="nowrap" style="width:3px;"></td>
                    <td align="left" id="panel_orderslist">
                        {include file="$_CURRENT_LOAD_PATH/admin.manageorders/panels/orderslist.tpl"}
                    </td>
                    <td class="right_border" style="width:3px;" nowrap="nowrap"></td>
                </tr>
                <tr>
                    <td class="left_border"></td>
                    <td class="gray_line">

                    </td>
                    <td class="right_border"></td>
                </tr>
                <tr>
                    <td class="corner_lb"></td>
                    <td class="tb_bottom"></td>
                    <td class="corner_rb"></td>
                </tr>
            </table>