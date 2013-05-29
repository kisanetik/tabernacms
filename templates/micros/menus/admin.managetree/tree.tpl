{strip}
{url type="js" file="jscss/components/mootree/mootree.js"}
{url type="css" file="jscss/components/mootree/mootree.css"}
{url type="js" file="alias=SITE_ALIASXML&action=getjs"}
<h1 id="manageTreeTitle">{lang code='managetrees.system.title' ucf=true}</h1>
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
                                        <div class="block_header_title">{lang code='tree.system.title' ucf=true}</div>
                                    </td>
                                    <td>
                                        <div class="block_header_title" style="text-align: right;color:red;"><div class="red_color" id="TreeMessage"></div></div>
                                    </td>
                                </tr>
                                </table>

                                <!--  <div class="block_header_title">{lang code='aliases.system.title' ucf=true}</div>-->
                                <div class="tb_line_ico">
                                    <table class="item_ico">
                                        <tr>
                                            <td>
                                                <a href="javascript:RADTree.addClick();">
                                                    <img src="{const SITE_URL}img/backend/add.png" alt="" width="30" height="30" border="0" alt="{lang code='-add'}" title="{lang code='-add'}" />
                                                    <span class="text" style="width:50px;">{lang code='-add'}</span>
                                                </a>
                                            </td>
                                        </tr>
                                    </table>
                                    <table class="item_ico">
                                        <tr>
                                            <td>
                                                <a href="javascript:RADTree.editClick();">
                                                    <img src="{const SITE_URL}img/backend/pencil.png" alt="" width="30" height="30" border="0" alt="{lang code='-edit'}" title="{lang code='-edit'}" />
                                                    <span class="text" style="width:50px;">{lang code='-edit'}</span>
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
                    <td align="left" id="panel_tree">
                    	<div id="rad_mtree" style="position:relative;overflow:auto;width:400px;height:350px;" class="tree"></div>
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
            <table cellpadding="0" cellspacing="0" border="0" class="tb_cont_block" style="height:auto;width:550px;visibility:hidden;" id="editTreeBlock">
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
                                        <div class="block_header_title">{lang code='editnode.menus.title' ucf=true}</div>
                                    </td>
                                    <td>
                                        <div class="block_header_title" style="text-align: right;"><span class="red_color" id="editTreeMessage"></span></div>
                                    </td>
                                </tr>
                                </table>
                                <div class="tb_line_ico">
                                    <table class="item_ico">
                                        <tr>
                                            <td>
                                                <a href="javascript:RADTree.cancelClick();">
                                                    <img class="img" src="{const SITE_URL}img/backend/arrow_undo.png" alt="" width="30" height="30" border="0" alt="{lang code='-cancel' ucf=true}" title="{lang code='-cancel' ucf=true}" />
                                                    <span class="text" style="width:50px;">{lang code='-cancel'}</span>
                                                </a>
                                            </td>
                                        </tr>
                                    </table>
									<table class="item_ico">
                                        <tr>
                                            <td>
                                                <a href="javascript:RADTree.deleteClick();">
                                                    <img src="{const SITE_URL}img/backend/icons/ico_delete.gif" alt="" width="30" height="30" border="0" alt="{lang code='-delete'}" title="{lang code='-delete'}" />
                                                    <span class="text" style="width:50px;">{lang code='-delete'}</span>
                                                </a>
                                            </td>
                                        </tr>
                                    </table>
                                    <table class="item_ico">
                                        <tr>
                                            <td>
                                                <a href="javascript:RADTree.saveClick();">
                                                    <img src="{const SITE_URL}img/backend/disk.png" alt="" width="30" height="30" border="0" alt="{lang code='-save' ucf=true}" title="{lang code='-save' ucf=true}" />
                                                    <span class="text" style="width:50px;">{lang code='-save' ucf=true}</span>
                                                </a>
                                            </td>
                                        </tr>
                                    </table>
									{if isset($params) and ($params->showdetailedit)}
									<table class="item_ico">
                                        <tr>
                                            <td>
                                                <a href="javascript:RADTree.editDetailClick();">
                                                    <img class="img" src="{const SITE_URL}img/backend/draw_points.png" alt="" width="30" height="30" border="0" alt="{lang code='editdetail.menus.button'}" title="{lang code='editdetail.menus.button'}" />
                                                    <span class="text" style="width:50px;">{lang code='editdetail.menus.button'}</span>
                                                </a>
                                            </td>
                                        </tr>
                                    </table>
									{/if}
                                    <div class="clear_rt"></div>
                                </div>
                            </div>
                        </div>
                    </td>
                    <td class="right_border"></td>
                </tr>
                <tr>
                    <td class="left_border"></td>
                    <td align="left" id="editTreeNode" class="panel_main">
                        
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
</table>
{/strip}