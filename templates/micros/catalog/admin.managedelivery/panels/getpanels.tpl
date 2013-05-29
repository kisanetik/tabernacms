{strip}
{url type="js" file="alias=SITE_ALIASXML&action=getjs"}
<h1 id="manageUsersTitle">{lang code='managedelivery.catalog.title' ucf=true}</h1>
<table cellpadding="0" cellspacing="0" border="0" class="tb_two_column" style="height:auto;width:100%;">
    <tr>
        <td colspan="2">
            <table id="itemslist_block" cellpadding="0" cellspacing="0" border="0" class="tb_cont_block" style="height:auto;width:100%;">
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
                                        <div class="block_header_title">{lang code="itemslist.catalog.title" ucf=true}</div>
                                    </td>
                                    <td>
                                        <div class="block_header_title" style="text-align: right;"><span class="red_color" id="ListMessage"></span></div>
                                    </td>
                                </tr>
                                </table>
                                <div class="tb_line_ico">
                                    <table class="item_ico">
                                        <tr>
                                            <td>
                                                <a href="{lang code="-add" ucf='true'|replace:'"':'&quot;'}" onclick="return RADDelivery.addClick();">
                                                    <img src="{const SITE_URL}img/backend/add.png" width="30" height="30" border="0" alt="{lang code='-add' ucf=true|replace:'"':'&quot;'}" title="{lang code='-add' ucf=true|replace:'"':'&quot;'}" />
                                                    <span class="text" style="width:50px;">{lang code='-add' ucf=true}</span>
                                                </a>
                                            </td>
                                        </tr>
                                    </table>
                                    <table class="item_ico">
                                        <tr>
                                            <td>
                                                <a href="{lang code="-refresh" ucf='true'|replace:'"':'\\"'}" onclick="return RADDelivery.refresh();">
                                                    <img src="{const SITE_URL}img/backend/arrow_rotate_clockwise.png" alt="{lang code='-refresh' ucf=true|replace:'"':'&quot;'}" title="{lang code='-refresh' ucf=true|replace:'"':'&quot;'}" width="30" height="30" border="0">
                                                    <span class="text" style="width:50px;">{lang code='-refresh' ucf=true}</span>
                                                </a>
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
                    <td align="left" id="panel_itemslist">
                        {include file="$_CURRENT_LOAD_PATH/admin.managedelivery/panels/itemslist.tpl"}
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
        </td>
    </tr>
</table>
{/strip}