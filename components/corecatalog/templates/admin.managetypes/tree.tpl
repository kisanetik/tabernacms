{strip}
{url type="js" module="core" file="mootree/mootree.js"}
{url href="alias=SITE_ALIASXML&action=getjs" type="js"}
{url type="css" module="core" file="mootree/mootree.css"}
<h1 id="manageLanguagesTitle">{lang code='managecatalogtypes.catalog.title' ucf=true}</h1>
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
                                        <div class="block_header_title">{lang code='catalogtypestree.catalog.title' ucf=true}</div>
                                    </td>
                                    <td>
                                        <div class="block_header_title" style="text-align: right;color:red;"><div class="red_color" id="CatalogTypesMessage"></div></div>
                                    </td>
                                </tr>
                                </table>
                                <div class="tb_line_ico">
                                    <table class="item_ico">
                                        <tr>
                                            <td>
                                                <a href="javascript:RADCatTypesAction.addNewNode();">
                                                    <img src="{url type="image" module="core" preset="original" file="backend/add.png"}" width="30" height="30" border="0" alt="{lang code="-add" ucf=true htmlchars=true}" title="{lang code="-add" ucf=true htmlchars=true}" />
                                                    <span class="text" style="width:50px;">{lang code='-add' ucf=true}</span>
                                                </a>
                                            </td>
                                        </tr>
                                    </table>
                                    <table class="item_ico">
                                        <tr>
                                            <td>
                                                <a href="javascript:RADCatTypesAction.showSEditForm(RADMooTree.tree.selected.id);">
                                                    <img src="{url type="image" module="core" preset="original" file="backend/pencil.png"}" width="30" height="30" border="0" alt="{lang code='-edit' ucf=true htmlchars=true}" title="{lang code='-edit' ucf=true htmlchars=true}" />
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
                    <td align="left" id="catalog_tree" class="tree">
                        <div style="position:relative;overflow:auto;height:250px;width:400px;">
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
            <table cellpadding="0" cellspacing="0" border="0" class="tb_cont_block" style="height:auto;width:350px;visibility:hidden;" id="editCatTreeBlock">
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
                                        <div class="block_header_title">{lang code='nodeaddedit.catalog.title'}</div>
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
                                                <a href="javascript:RADCatTypesAction.cancelSEditForm();">
                                                    <img class="img" src="{url type="image" module="core" preset="original" file="backend/arrow_undo.png"}" width="30" height="30" border="0" alt="{lang code='-cancel' ucf=true htmlchars=true}" title="{lang code='-cancel' ucf=true htmlchars=true}" />
                                                    <span class="text" style="width:50px;">{lang code='-cancel' ucf=true}</span>
                                                </a>
                                            </td>
                                        </tr>
                                    </table>
                                    <table class="item_ico">
                                        <tr>
                                            <td>
                                                <a href="javascript:RADCatTypesAction.deleteSEditForm();">
                                                    <img src="{url type="image" module="core" preset="original" file="backend/icons/ico_delete.gif"}" width="30" height="30" border="0" alt="{lang code='-delete' ucf=true htmlchars=true}" title="{lang code='-delete' ucf=true htmlchars=true}" />
                                                    <span class="text" style="width:50px;">{lang code='-delete' ucf=true}</span>
                                                </a>
                                            </td>
                                        </tr>
                                    </table>
                                    <table class="item_ico">
                                        <tr>
                                            <td>
                                                <a href="javascript:RADCatTypesAction.saveSEditForm(RADMooTree.tree.selected.id);">
                                                    <img src="{url type="image" module="core" preset="original" file="backend/disk.png"}" width="30" height="30" border="0" alt="{lang code='-save' ucf=true htmlchars=true}" title="{lang code='-save' ucf=true htmlchars=true}" />
                                                    <span class="text" style="width:50px;">{lang code='-save' ucf=true}</span>
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
                    <td align="left" id="editCatNode" class="panel_main">
                        
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
            <table id="list_block" cellpadding="0" cellspacing="0" border="0" class="tb_cont_block" style="height:auto;width:100%;visibility:hidden;">
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
                                        <div class="block_header_title">{lang code='catalogtypeslist.catalog.title' ucf=true}</div>
                                    </td>
                                    <td>
                                        <div class="block_header_title" style="text-align: right;"><span class="red_color" id="CatalogTypesMessage"></span></div>
                                    </td>
                                </tr>
                                </table>
                                <div class="tb_line_ico">
                                    <table class="item_ico">
                                        <tr>
                                            <td>
                                                <a href="javascript:RADCatTypesAction.addNewTypeClick();">
                                                    <img src="{url type="image" module="core" preset="original" file="backend/add.png"}" width="30" height="30" border="0" alt="{lang code='-add' ucf=true htmlchars=true}" title="{lang code='-add' ucf=true htmlchars=true}" />
                                                    <span class="text" style="width:50px;">{lang code='-add'}</span>
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
                    <td align="left" id="listCatNode">
                        
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