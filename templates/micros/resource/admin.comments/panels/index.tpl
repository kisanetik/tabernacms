{strip}
{url type="js" file="alias=SITE_ALIASXML&action=getjs"}
<h1 id="manageUsersTitle">{lang code="managecomments.resource.title" ucf=true}</h1>
<table id="messageslist_block" cellpadding="0" cellspacing="0" border="0" class="tb_cont_block" style="height:auto;width:100%;">
    <tr>
        <td class="corner_lt"></td>
        <td class="header_top"></td>
        <td class="corner_rt"></td>
    </tr>
    <tr>
        <td class="left_border"></td>
        <td class="header_bootom" style="height: 28px;" id="header_bootom_id">
            <div class="hb">
                <div class="hb_inner" id="mes_title_block">
                    <table border="0" cellpadding="0" cellspacing="0" width="100%">
                    <tr>
                        <td>
                            <div class="block_header_title" id="block_header_title">{lang code="commentslist.resource.title" ucf=true}</div>
                        </td>
                        <td>
                            <div class="block_header_title" style="text-align: right;">
                                <span class="red_color" id="listMessage"></span>
                            </div>
                        </td>
                    </tr>
                    </table>
                </div>
            </div>
        </td>
        <td class="right_border"></td>
    </tr>
    <tr id="content_tr">
        <td class="left_border" nowrap="nowrap" style="width:3px;"></td>
        <td align="left" id="panel_itemslist">
            {include file="$_CURRENT_LOAD_PATH/admin.comments/panels/itemslist.tpl"}
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
{/strip}