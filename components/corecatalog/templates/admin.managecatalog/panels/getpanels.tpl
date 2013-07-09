{strip}
{url href="alias=SITE_ALIASXML&action=getjs" type="js"}
<h1 id="manageLanguagesTitle">{lang code='managecatalog.catalog.title' ucf=true}</h1>
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
                                        <div class="block_header_title">{lang code='catalogtree.catalog.title' ucf=true}</div>
                                    </td>
                                    <td>
                                        <div class="block_header_title" style="text-align: right;color:red;"><div class="red_color" id="CatalogTreeMessage"></div></div>
                                    </td>
                                </tr>
                                </table>
                                <div class="tb_line_ico">
                                    <table class="item_ico">
                                        <tr>
                                            <td>
                                                <a href="javascript:RADCatalogTree.add();">
                                                    <img src="{url type="image" module="core" preset="original" file="backend/add.png"}" width="30" height="30" border="0" alt="{lang code='-add' ucf=true|replace:'"':'&quot;'}" title="{lang code='-add' ucf=true|replace:'"':'&quot;'}" />
                                                    <span class="text" style="width:50px;">{lang code='-add' ucf=true}</span>
                                                </a>
                                            </td>
                                        </tr>
                                    </table>
                                    <table class="item_ico">
                                        <tr>
                                            <td>
                                                <a href="javascript:RADCatalogTree.editSelected();">
                                                    <img src="{url type="image" module="core" preset="original" file="backend/pencil.png"}" width="30" height="30" border="0" alt="{lang code='-edit' ucf=true|replace:'"':'&quot;'}" title="{lang code='-edit' ucf=true|replace:'"':'&quot;'}" />
                                                    <span class="text" style="width:80px;">{lang code='-edit' ucf=true}</span>
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
                    <td align="left" id="catalog_tree">
                        {include file="$_CURRENT_LOAD_PATH/admin.managecatalog/panels/tree.tpl"}
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
            <table cellpadding="0" cellspacing="0" border="0" class="tb_cont_block" style="height:auto;display:none;" id="editCatTreeBlock">
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
                                        <div class="block_header_title">{lang code='editcattree.system.title' ucf=true}</div>
                                    </td>
                                    <td>
                                        <div class="block_header_title" style="text-align: right;"><span class="red_color" id="catalogInfoMessage"></span></div>
                                    </td>
                                </tr>
                                </table>
                                <div class="tb_line_ico">
                                    <table class="item_ico">
                                        <tr>
                                            <td>
                                                <a href="javascript:RADCatalogTree.cancelEdit();">
                                                    <img class="img" src="{url type="image" module="core" preset="original" file="backend/arrow_undo.png"}" width="30" height="30" border="0" alt="{lang code='-cancel'}" title="{lang code='-cancel' ucf=true|replace:'"':'&quot;'}" />
                                                    <span class="text" style="width:50px;">{lang code='-cancel' ucf=true}</span>
                                                </a>
                                            </td>
                                        </tr>
                                    </table>
                                    <table class="item_ico">
                                        <tr>
                                            <td>
                                                <a href="javascript:RADCatalogTree.deleteNode();">
                                                    <img src="{url type="image" module="core" preset="original" file="backend/icons/ico_delete.gif"}" width="30" height="30" border="0" alt="{lang code='-delete'}" title="{lang code='-delete' ucf=true|replace:'"':'&quot;'}" />
                                                    <span class="text" style="width:50px;">{lang code='-delete' ucf=true}</span>
                                                </a>
                                            </td>
                                        </tr>
                                    </table>
                                    <table class="item_ico">
                                        <tr>
                                            <td>
                                                <a href="javascript:RADCatalogTree.applyEdit();">
                                                    <img src="{url type="image" module="core" preset="original" file="backend/accept.png"}" width="30" height="30" border="0" alt="{lang code='-apply'}" title="{lang code='-apply' ucf=true|replace:'"':'&quot;'}" />
                                                    <span class="text" style="width:50px;">{lang code='-apply' ucf=true}</span>
                                                </a>
                                            </td>
                                        </tr>
                                    </table>
                                    <table class="item_ico">
                                        <tr>
                                            <td>
                                                <a href="javascript:RADCatalogTree.submitEdit();">
                                                    <img src="{url type="image" module="core" preset="original" file="backend/disk.png"}" width="30" height="30" border="0" alt="{lang code='-save'}" title="{lang code='-save' ucf=true|replace:'"':'&quot;'}" />
                                                    <span class="text" style="width:50px;">{lang code='-save' ucf=true}</span>
                                                </a>
                                            </td>
                                        </tr>
                                    </table>
                                    <table class="item_ico">
                                        <tr>
                                            <td>
                                                <a href="javascript:RADCatalogTree.editDetailClick();">
                                                    <img class="img" src="{url type="image" module="core" preset="original" file="backend/draw_points.png"}" width="30" height="30" border="0" alt="{lang code='editdetail.menus.button'}" title="{lang code='editdetail.menus.button' ucf=true|replace:'"':'&quot;'}" />
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
                    <td align="left" id="editCatalogNode" class="panel_main">

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
    </tr>
    <tr>
        <td colspan="2">
            <table id="lnv_block" cellpadding="0" cellspacing="0" border="0" class="tb_cont_block" style="height:auto;width:100%;display:none;">
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
                                        <div class="block_header_title">{lang code='productslist.catalog.title' ucf=true}</div>
                                    </td>
                                    <td>
                                        <div class="block_header_title" style="text-align: right;"><span class="red_color" id="CatalogListMessage"></span></div>
                                    </td>
                                </tr>
                                </table>
                                <div class="tb_line_ico">
                                    <table class="item_ico">
                                        <tr>
                                            <td>
                                                <a href="javascript:RADCatalogList.add(0);">
                                                    <img src="{url type="image" module="core" preset="original" file="backend/add.png"}" width="30" height="30" border="0" alt="{lang code='-add'}" title="{lang code='-add' ucf=true|replace:'"':'&quot;'}" />
                                                    <span class="text" style="width:50px;">{lang code='-add' ucf=true}</span>
                                                </a>
                                            </td>
                                        </tr>
                                    </table>
                                    <table class="item_ico">
                                        <tr>
                                            <td>
                                                <a href="javascript:RADCatalogList.refresh();">
                                                    <img src="{url type="image" module="core" preset="original" file="backend/arrow_rotate_clockwise.png"}" alt="{lang code='-refresh' ucf=true|replace:'"':'&quot;'}" title="{lang code='-refresh' ucf=true|replace:'"':'&quot;'}" width="30" height="30" border="0">
                                                    <span class="text" style="width:50px;">{lang code='-refresh' ucf=true}</span>
                                                </a>
                                            </td>
                                        </tr>
                                    </table>
                                    <table class="item_ico" align="left" align="left;" style="float:left;margin-top:10px;">
                                       <tr>
                                           <td height="100%" valign="bottom" nowrap="nowrap" width="250">
                                                <form method="post" id="searchProductsForm" action="{url href="action=search"}" onsubmit="return false;">
                                                    <div>
                                                        <div style="float:left;">{lang code='-search.title' ucf=true}
                                                            <br />
                                                            <input type="text" name="searchword" id="searchword" value="{$searchword}" onKeyPress="RADCatalogList.addKeyPress(event);" x-webkit-speech="" speech="" onwebkitspeechchange="RADCatalogList.search();" />
                                                        </div>
                                                        <div style="float:left;margin-top:14px;">
                                                            <a>
                                                                <input type="image" src="{url type="image" module="core" preset="original" file="backend/zoom.png"}" alt="{lang code='-submit' ucf=true|replace:'"':'&quot;'}" title="{lang code='-submit' ucf=true|replace:'"':'&quot;'}"  onclick="RADCatalogList.search();" />
                                                            </a>
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
                    <td align="left" id="panel_cataloglist">
                        {include file="$_CURRENT_LOAD_PATH/admin.managecatalog/panels/productslist.tpl"}
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