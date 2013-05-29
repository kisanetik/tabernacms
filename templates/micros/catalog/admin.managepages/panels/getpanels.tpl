{strip}
{url type="js" file="jscss/components/mootree/mootree.js"}
{url type="css" file="jscss/components/mootree/mootree.css"}
{url type="js" file="alias=SITE_ALIASXML&action=getjs"}
<h1 id="manageUsersTitle">{lang code="managepages.catalog.title" ucf=true}</h1>
<table cellpadding="0" cellspacing="0" border="0" class="tb_two_column" style="height:auto;width:100%;">
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
                                        <div class="block_header_title">{lang code='pagesgroups.system.title' ucf=true}</div>
                                    </td>
                                    <td>
                                        <div class="block_header_title" style="text-align: right;color:red;"><div class="red_color" id="PagesTreeMessage"></div></div>
                                    </td>
                                </tr>
                                </table>
                                <div class="tb_line_ico">
                                    <table class="item_ico">
                                        <tr>
                                            <td>
                                                <a href="javascript:RADPagesTree.addClick();">
                                                    <img src="{const SITE_URL}img/backend/add.png" width="30" height="30" border="0" alt="{lang code='-add'}" title="{lang code='-add'}" />
                                                    <span class="text" style="width:50px;">{lang code='-add'}</span>
                                                </a>
                                            </td>
                                        </tr>
                                    </table>
                                    <table class="item_ico">
                                        <tr>
                                            <td>
                                                <a href="javascript:RADPagesTree.editClick();">
                                                    <img src="{const SITE_URL}img/backend/pencil.png" width="30" height="30" border="0" alt="{lang code='-edit'}" title="{lang code='-edit'}" />
                                                    <span class="text" style="width:80px;">{lang code='-edit'}</span>
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
                    <td align="left" id="pages_tree">
                        <div style="position:relative;overflow:auto;height:250px;width:400px;" class="tree">
                            <div id="rad_mtree" style="position:relative;"></div>
                        </div>
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
            <table cellpadding="0" cellspacing="0" border="0" class="tb_cont_block" style="height:auto;width:500px;visibility:hidden;" id="editPagesTreeBlock">
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
                                        <div class="block_header_title">{lang code='editpagestree.catalog.title' ucf=true}</div>
                                    </td>
                                    <td>
                                        <div class="block_header_title" style="text-align: right;"><span class="red_color" id="pagesInfoMessage"></span></div>
                                    </td>
                                </tr>
                                </table>
                                <div class="tb_line_ico">
                                    <table class="item_ico">
                                        <tr>
                                            <td>
                                                <a href="javascript:RADPagesTree.cancelEdit();">
                                                    <img class="img" src="{const SITE_URL}img/backend/arrow_undo.png" width="30" height="30" border="0" alt="{lang code='-cancel'}" title="{lang code='-cancel'}" />
                                                    <span class="text" style="width:50px;">{lang code='-cancel' ucf=true}</span>
                                                </a>
                                            </td>
                                        </tr>
                                    </table>
									<table class="item_ico">
                                        <tr>
                                            <td>
                                                <a href="javascript:RADPagesTree.deleteNode();">
                                                    <img src="{const SITE_URL}img/backend/icons/ico_delete.gif" width="30" height="30" border="0" alt="{lang code='-delete'}" title="{lang code='-delete'}" />
                                                    <span class="text" style="width:50px;">{lang code='-delete' ucf=true}</span>
                                                </a>
                                            </td>
                                        </tr>
                                    </table>
                                    <table class="item_ico">
                                        <tr>
                                            <td>
                                                <a href="javascript:RADPagesTree.saveEdit();">
                                                    <img src="{const SITE_URL}img/backend/disk.png" width="30" height="30" border="0" alt="{lang code='-save'}" title="{lang code='-save'}" />
                                                    <span class="text" style="width:50px;">{lang code='-save' ucf=true}</span>
                                                </a>
                                            </td>
                                        </tr>
                                    </table>
									<table class="item_ico">
                                        <tr>
                                            <td>
                                                <a href="javascript:RADPagesTree.editDetailClick();">
                                                    <img class="img" src="{const SITE_URL}img/backend/draw_points.png" alt="" width="30" height="30" border="0" alt="{lang code='editdetail.menus.button'}" title="{lang code='editdetail.menus.button'}" />
                                                    <span class="text" style="width:50px;">{lang code='editdetail.menus.button' ucf=true}</span>
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
                    <td align="left" id="editPagesTreeNode" class="panel_main"></td>
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
    <tr>
        <td colspan="2">
            <table id="pageslist_block" cellpadding="0" cellspacing="0" border="0" class="tb_cont_block" style="height:auto;width:100%;display:none;">
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
                                        <div class="block_header_title">{lang code='pageslist.system.title' ucf=true}</div>
                                    </td>
                                    <td>
                                        <div class="block_header_title" style="text-align: right;"><span class="red_color" id="PagesListMessage"></span></div>
                                    </td>
                                </tr>
                                </table>
                                <div class="tb_line_ico">
                                    <table class="item_ico">
                                        <tr>
                                            <td>
                                                <a href="javascript:RADPages.addClick();">
                                                    <img src="{const SITE_URL}img/backend/add.png" width="30" height="30" border="0" alt="{lang code='-add'}" title="{lang code='-add'}" />
                                                    <span class="text" style="width:50px;">{lang code='-add'}</span>
                                                </a>
                                            </td>
                                        </tr>
                                    </table>
                                    
                                    <table class="item_ico" align="left" style="float:left;margin-top:10px;">
                                       <tr>
                                           <td height="100%" valign="bottom" nowrap="nowrap" width="250">
                                                <form method="post" id="searchPagesForm" action="{const SITE_URL}{const SITE_ALIAS}/action/search/" onsubmit="return false;">
                                                    <div>
                                                        <div style="float:left;">{lang code='-search.title'}
															<br />
															<input type="text" name="search" id="searchpagesword" value="{if isset($searchword)}{$searchword}{/if}" onKeyPress="RADPages.searchKeyPress(event);" />
														</div>
                                                        <div style="float:left;margin-top:15px;">
															<a><input type="image" src="{const SITE_URL}img/backend/zoom.png" alt="{lang code='-submit'}" title="{lang code='-submit'}"  onclick="RADPages.searchClick();" /></a>
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
                    <td align="left" id="panel_pageslist">
                        
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