{strip}
{url type="js" module="core" file="mootree/mootree.js"}
{url type="css" module="core" file="mootree/mootree.css"}
{url href="alias=SITE_ALIASXML&action=getjs" type="js"}
<h1 id="manageUsersTitle">{lang code='managenews.catalog.title' ucf=true}</h1>
<table cellpadding="0" cellspacing="0" border="0" class="tb_two_column" style="height:auto;width:100%;">
{if $params->hassubcats}
    <tr>
        <td>
            <table cellpadding="0" cellspacing="0" border="0" class="tb_cont_block" style="width:408px;height:auto;" >
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
                                        <div class="block_header_title">{lang code='newsgroups.system.title' ucf=true}</div>
                                    </td>
                                    <td>
                                        <div class="block_header_title" style="text-align: right;color:red;"><div class="red_color" id="NewsTreeMessage"></div></div>
                                    </td>
                                </tr>
                                </table>
                                <div class="tb_line_ico">
                                    <table class="item_ico">
                                        <tr>
                                            <td>
                                                <a href="javascript:RADNewsTree.addClick();">
                                                    <img src="{url type="image" module="core" preset="original" file="backend/add.png"}" width="30" height="30" border="0" alt="{lang code="-add"}" title="{lang code="-add"}" />
                                                    <span class="text" style="width:50px;">{lang code="-add"}</span>
                                                </a>
                                            </td>
                                        </tr>
                                    </table>
                                    <table class="item_ico">
                                        <tr>
                                            <td id="edit-pages-tree">
                                                <a href="javascript:RADNewsTree.editClick();">
                                                    <img src="{url type="image" module="core" preset="original" file="backend/pencil.png"}" width="30" height="30" border="0" alt="{lang code="-edit"}" title="{lang code="-edit"}" />
                                                    <span class="text" style="width:80px;">{lang code="-edit"}</span>
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
                    <td class="left_border"></td>
                    <td align="left" id="news_tree">
                        <div id="rad_mtree" style="position:relative;overflow:auto;width:400px;height:250px;" class="tree"></div>
                    </td>
                    <td class="right_border"></td>
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
        <td align="left" style="width:100%;">
            <table cellpadding="0" cellspacing="0" border="0" class="tb_cont_block" style="height:auto;width:450px;{if $params->hassubcats}visibility:hidden;{/if}" id="editNewsTreeBlock">
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
                                        <div class="block_header_title">{lang code='editnewstree.system.title'}</div>
                                    </td>
                                    <td>
                                        <div class="block_header_title" style="text-align: right;"><span class="red_color" id="newsInfoMessage"></span></div>
                                    </td>
                                </tr>
                                </table>
                                <div class="tb_line_ico">
                                    <table class="item_ico">
                                        <tr>
                                            <td>
                                                <a href="javascript:RADNewsTree.cancelEdit();">
                                                    <img class="img" src="{url type="image" module="core" preset="original" file="backend/arrow_undo.png"}" width="30" height="30" border="0" alt="{lang code="-cancel"}" title="{lang code="-cancel"}" />
                                                    <span class="text" style="width:50px;">{lang code="-cancel" ucf=true}</span>
                                                </a>
                                            </td>
                                        </tr>
                                    </table>
                                    <table class="item_ico">
                                        <tr>
                                            <td>
                                                <a href="javascript:RADNewsTree.deleteNode();">
                                                    <img src="{url type="image" module="core" preset="original" file="backend/icons/ico_delete.gif"}" width="30" height="30" border="0" alt="{lang code="-delete"}" title="{lang code="-delete"}" />
                                                    <span class="text" style="width:50px;">{lang code="-delete" ucf=true}</span>
                                                </a>
                                            </td>
                                        </tr>
                                    </table>
                                    <table class="item_ico">
                                        <tr>
                                            <td>
                                                <a href="javascript:RADNewsTree.saveEdit();">
                                                    <img src="{url type="image" module="core" preset="original" file="backend/disk.png"}" width="30" height="30" border="0" alt="{lang code="-save"}" title="{lang code="-save"}" />
                                                    <span class="text" style="width:50px;">{lang code="-save" ucf=true}</span>
                                                </a>
                                            </td>
                                        </tr>
                                    </table>
                                    <table class="item_ico">
                                        <tr>
                                            <td>
                                                <a href="javascript:RADNewsTree.editDetailClick();">
                                                    <img class="img" src="{url type="image" module="core" preset="original" file="backend/draw_points.png"}" width="30" height="30" border="0" alt="{lang code="editdetail.menus.button"}" title="{lang code="editdetail.menus.button"}" />
                                                    <span class="text" style="width:50px;">{lang code="editdetail.menus.button"}</span>
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
                    <td class="left_border"></td>
                    <td align="left" id="editNewsTreeNode" class="panel_main"></td>
                    <td class="right_border"></td>
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
{/if}
    <tr>
        <td colspan="2">
            <table id="newslist_block" cellpadding="0" cellspacing="0" border="0" class="tb_cont_block" style="height:auto;width:100%;display:none;">
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
                                        <div class="block_header_title">{lang code='itemslist.catalog.title' ucf=true}</div>
                                    </td>
                                    <td>
                                        <div class="block_header_title" style="text-align: right;"><span class="red_color" id="NewsListMessage"></span></div>
                                    </td>
                                </tr>
                                </table>
                                <div class="tb_line_ico">
                                    <table class="item_ico">
                                        <tr>
                                            <td>
                                                <a href="javascript:RADNews.addClick();">
                                                    <img src="{url type="image" module="core" preset="original" file="backend/add.png"}" width="30" height="30" border="0" alt="{lang code="-add"}" title="{lang code="-add"}" />
                                                    <span class="text" style="width:50px;">{lang code="-add"}</span>
                                                </a>
                                            </td>
                                        </tr>
                                    </table>
                                    {*
                                    <table class="item_ico" align="left" align="left;" style="float:left;margin-top:10px;">
                                       <tr>
                                           <td height="100%" valign="bottom" nowrap="nowrap" width="250">
                                                <form method="post" id="searchNewsForm" action="{const SITE_URL}{const SITE_ALIAS}/action/search/" onsubmit="return false;">
                                                    <div>
                                                        <div style="float:left;">{$lang->_('-search.title')}<br />   <input type="text" name="search" id="searchusersword" value="{if isset($searchword)}{$searchword}{/if}" onKeyPress="RADNews.searchKeyPress(event);" /></div>
                                                        <div style="float:left;margin-top:5px;"><a><input type="image" src="{url type="image" module="core" preset="original" file="backend/zoom.png"}" alt="{$lang->_('submit')}" title="{$lang->_('submit')}"  onclick="RADNews.searchClick();" /></a></div>
                                                    </div>
                                                </form>
                                           </td>
                                       </tr>
                                    </table>
                                    *}
                                    <div class="clear_rt"></div>
                                </div>
                            </div>
                        </div>
                    </td>
                    <td class="right_border"></td>
                </tr>
                <tr>
                    <td class="left_border" nowrap="nowrap" style="width:3px;"></td>
                    <td align="left" id="panel_newslist">

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