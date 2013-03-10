{strip}
<script type="text/javascript" src="{const SITE_URL}jscss/components/mootree/mootree.js"></script>
<link rel="stylesheet" href="{const SITE_URL}jscss/components/mootree/mootree.css" type="text/css" media="screen" />
<script src="{const SITE_URL}jscss/components/editarea/edit_area/edit_area_full.js" type="text/javascript"></script>
<script type="text/javascript" src="{url href="alias=SITE_ALIASXML&action=getjs&ma=`$action`"}"></script>
<div class="w100"><div class="kord_right_col">
<h1 id="componentTitle">{lang code='manageInstall.system.title' ucf=true}</h1>
<table cellpadding="0" cellspacing="0" border="0" class="tb_two_column" style="height:auto;width:100%;">
    <tr>
        <td>
            <table cellpadding="0" cellspacing="0" border="0" class="tb_cont_block" style="width:410px;height:auto;" >
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
                                        <div class="block_header_title">{lang code='groups.system.title' ucf=true}</div>
                                    </td>
                                    <td>
                                        <div class="block_header_title" style="text-align: right;color:red;"><div class="red_color" id="ComponentTreeMessage"></div></div>
                                    </td>
                                </tr>
                                </table>
                                <div class="tb_line_ico">
                                    {*
                                    <table class="item_ico">
                                        <tr>
                                            <td>
                                                <a href="javascript:RADInstallTree.addClick();">
                                                    <img src="{const SITE_URL}img/backend/add.png" width="30" height="30" border="0" alt="{lang code='-add' ucf=true|replace:'"':'&quot;'}" title="{lang code='-add' ucf=true|replace:'"':'&quot;'}" />
                                                    <span class="text" style="width:50px;">{lang code='-add' ucf=true}</span>
                                                </a>
                                            </td>
                                        </tr>
                                    </table>
                                    *}
                                    <table class="item_ico">
                                        <tr>
                                            <td>
                                                <a href="javascript:RADInstallTree.editClick();">
                                                    <img src="{const SITE_URL}img/backend/pencil.png" width="30" height="30" border="0" alt="{lang code='-edit' ucf=true|replace:'"':'&quot;'}" title="{lang code='-edit' ucf=true|replace:'"':'&quot;'}" />
                                                    <span class="text" style="width:50px;margin-right:25px;">{lang code='-edit' ucf=true}</span>
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
                    <td align="left" id="component_tree">
                        <div id="rad_mtree" style="position:relative;overflow:auto;width:400px;height:400px;" class="tree"></div>
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
            <table cellpadding="2" cellspacing="0" border="0" class="tb_cont_block" style="padding-right:10px;height:auto;width:550px;visibility:hidden;" id="editComponentTreeBlock">
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
                                        <div class="block_header_title">{lang code='editinstallgroup.system.title' ucf=true}</div>
                                    </td>
                                    <td>
                                        <div class="block_header_title" style="text-align: right;"><span class="red_color" id="componentInfoMessage"></span></div>
                                    </td>
                                </tr>
                                </table>
                                <div class="tb_line_ico">
                                    <table class="item_ico">
                                        <tr>
                                            <td>
                                                <a href="javascript:RADInstallTree.cancelEdit();">
                                                    <img class="img" src="{const SITE_URL}img/backend/arrow_undo.png" width="30" height="30" border="0" alt="{lang code='-cancel' ucf=true|replace:'"':'&quot;'}" title="{lang code='-cancel' ucf=true|replace:'"':'&quot;'}" />
                                                    <span class="text" style="width:50px;">{lang code='-cancel' ucf=true}</span>
                                                </a>
                                            </td>
                                        </tr>
                                    </table>
                                    
                                    <table class="item_ico" id="ico_delDetail">
                                        <tr>
                                            <td>
                                                <a href="javascript:RADInstallTree.deleteComponent();">
                                                    <img src="{const SITE_URL}img/backend/icons/ico_delete.gif" width="30" height="30" border="0" alt="{lang code='-delete' ucf=true|replace:'"':'&quot;'}" title="{lang code="-delete" ucf=true|replace:'"':'&quot;'}" />
                                                    <span class="text" style="width:50px;">{lang code='-delete' ucf=true}</span>
                                                </a>
                                            </td>
                                        </tr>
                                    </table>
                                    
                                    <table class="item_ico" id="ico_saveDetail">
                                        <tr>
                                            <td>
                                                <a href="javascript:RADInstallTree.saveEdit();">
                                                    <img src="{const SITE_URL}img/backend/disk.png" width="30" height="30" border="0" alt="{lang code="-save" ucf=true|replace:'"':'&quot;'}" title="{lang code="-save"|replace:'"':'&quot;'}" />
                                                    <span class="text" style="width:50px;">{lang code="-save" ucf=true}</span>
                                                </a>
                                            </td>
                                        </tr>
                                    </table>
                                    <table class="item_ico" id="ico_editDetail">
                                        <tr>
                                            <td>
                                                <a href="javascript:RADInstallTree.editDetailClick();">
                                                    <img class="img" src="{const SITE_URL}img/backend/draw_points.png" width="30" height="30" border="0" alt="{lang code="editdetail.menus.button" ucf=true|replace:'"':'&quot;'}" title="{lang code="editdetail.menus.button" ucf=true|replace:'"':'&quot;'}" />
                                                    <span class="text" style="width:50px;">{lang code="editdetail.menus.button" ucf=true}</span>
                                                </a>
                                            </td>
                                        </tr>
                                    </table>
									
                                    <table class="item_ico" id="ico_editConfig">
                                        <tr>
                                            <td>
											
                                                <a href="javascript:RADInstallTree.editConfigClick();">
                                                    <img class="img" src="{const SITE_URL}img/backend/setting_tools.png" width="30" height="30" border="0" alt="{lang code="componentsparams.menus.button" ucf=true|replace:'"':'&quot;'}" title="{lang code="componentsparams.menus.button" ucf=true|replace:'"':'&quot;'}" />
                                                    <span class="text" style="width:50px;">{lang code="componentsparams.menus.button" ucf=true}</span>
                                                </a>
												
                                            </td>
                                        </tr>
                                    </table>
									
                                    <table class="item_ico" id="ico_editXMLParams">
                                        <tr>
                                            <td>
                                                <a href="javascript:RADInstallTree.editXMLParamsClick();">
                                                    <img class="img" src="{const SITE_URL}img/backend/document_editing.png" width="30" height="30" border="0" alt="{lang code="componentxmlparams.menus.button" ucf=true|replace:'"':'&quot;'}" title="{lang code="componentxmlparams.menus.button" ucf=true|replace:'"':'&quot;'}" />
                                                    <span class="text" style="width:50px;white-space:nowrap;">{lang code="componentxmlparams.menus.button" ucf=true}</span>
                                                </a>
                                            </td>
                                        </tr>
                                    </table>
                                    <table class="item_ico" id="ico_Install">
                                        <tr>
                                            <td>
                                                <a href="javascript:RADInstallTree.saveEdit();">
                                                    <img src="{const SITE_URL}img/backend/icons/ico_install.gif" width="30" height="30" border="0" alt="{lang code="-install" ucf=true|replace:'"':'&quot;'}" title="{lang code="-install"|replace:'"':'&quot;'}" />
                                                    <span class="text" style="width:50px;">{lang code="-install" ucf=true}</span>
                                                </a>
                                            </td>
                                        </tr>
                                    </table>
                                    
                                    <table class="item_ico" id="ico_Install_XML">
                                        <tr>
                                            <td>
                                                <a href="javascript:RADInstallTree.installXML();">
                                                    <img src="{const SITE_URL}img/backend/icons/ico_install.gif" width="30" height="30" border="0" alt="{lang code="-installofXML" ucf=true|replace:'"':'&quot;'}" title="{lang code="-installofXML"|replace:'"':'&quot;'}" />
                                                    <span class="text" style="width:50px;">{lang code="-installofXML" ucf=true}</span>
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
                    <td align="left" id="editComponentTreeNode" class="panel_main"></td>
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
</div></div>
{/strip}