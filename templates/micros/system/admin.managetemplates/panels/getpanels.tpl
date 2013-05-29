{strip}
<div class="w100">
    <div class="kord_right_col">
        <form method="post" id="hiddenform">
            <input type="hidden" id="hidden_data" name="dpath" value="" />
        </form>
        {url type="js" file="jscss/components/mootree/mootree.js"}
        {url type="js" file="jscss/components/editarea/edit_area/edit_area_full.js"}
        {url type="css" file="jscss/components/editarea/edit_area/edit_area.css"}
        {url type="css" file="jscss/components/mootree/mootree.css"}
        {url type="js" file="alias=SITE_ALIASXML&action=getjs"}
        <h1 id="manageTemplatesTitle">{lang code='managetemplates.system.title' ucf=true}</h1>
        <table cellpadding="0" cellspacing="0" border="0" class="tb_two_column" style="height:auto;width:100%;">
            <tr>
                <td>
                    <table cellpadding="0" cellspacing="0" border="0" class="tb_cont_block" style="width:600px;height:auto;" >
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
                                                <div class="block_header_title">{lang code='folders.system.title' ucf=true}</div>
                                            </td>
                                            <td>
                                                <div class="block_header_title" style="text-align: right;color:red;"><div class="red_color" id="FoldersTreeMessage"></div></div>
                                            </td>
                                        </tr>
                                        </table>
                                        <div class="tb_line_ico">
                                            <table class="item_ico">
                                                <tr>
                                                    <td>
                                                        <a href="javascript:RADFoldersTree.treeClick();">
                                                            <img src="{const SITE_URL}img/backend/pencil.png" width="30" height="30" border="0" alt="{lang code='-edit' ucf=true|replace:'"':'&qout;'}" title="{lang code='-edit' ucf=true|replace:'"':'&qout;'}" />
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
                            <td align="left" id="folder_tree">
                                <div style="position:relative;overflow:auto;height:350px;" class="tree">
                                    <div id="rad_mtree" style="position:relative;">
                                    </div>{include file="$_CURRENT_LOAD_PATH/admin.managetemplates/panels/tree_recursy.tpl" elements=$items href=''}
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
                    <table cellpadding="0" cellspacing="0" border="0" class="tb_cont_block" style="height:auto;width:300px;visibility:hidden;" id="editFoldersTreeBlock">
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
                                                <div class="block_header_title">{lang code='editfolderstree.system.title' ucf=true}</div>
                                            </td>
                                            <td>
                                                <div class="block_header_title" style="text-align: right;"><span class="red_color" id="FoldersInfoMessage"></span></div>
                                            </td>
                                        </tr>
                                        </table>
                                        <div class="tb_line_ico">
                                            <table class="item_ico">
                                                <tr>
                                                    <td>
                                                        <a href="javascript:RADFoldersTree.cancelEdit();">
                                                            <img class="img" src="{const SITE_URL}img/backend/arrow_undo.png" alt="{lang code="-cancel" ucf=true|replace:'"':'&qout;'}" width="30" height="30" border="0" alt="{lang code='-cancel'|replace:'"':'&qout;'}" title="{lang code='-cancel'|replace:'"':'&qout;'}" />
                                                            <span class="text" style="width:50px;">{lang code='-cancel'}</span>
                                                        </a>
                                                    </td>
                                                </tr>
                                            </table>
                                            {*
                                            <table class="item_ico">
                                                <tr>
                                                    <td>
                                                        <a href="javascript:RADUsersTree.deleteNode();">
                                                            <img src="{const SITE_URL}img/backend/icons/ico_delete.gif" alt="" width="30" height="30" border="0" alt="{lang code='-delete'}" title="{lang code='-delete'}" />
                                                            <span class="text" style="width:50px;">{lang code='-delete'}</span>
                                                        </a>
                                                    </td>
                                                </tr>
                                            </table>
                                            *}
                                            <table class="item_ico">
                                                <tr>
                                                    <td>
                                                        <a href="javascript:RADFoldersTree.saveEdit();">
                                                            <img src="{const SITE_URL}img/backend/disk.png" alt="" width="30" height="30" border="0" alt="{lang code='-save'|replace:'"':'&qout;'}" title="{lang code='-save'|replace:'"':'&qout;'}" />
                                                            <span class="text" style="width:50px;">{lang code='-save'}</span>
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
                            <td align="left" id="editFoldersTreeNode">

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
                    <table id="fileslist_block" cellpadding="0" cellspacing="0" border="0" class="tb_cont_block" style="height:auto;width:100%;display:none;">
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
                                                <div class="block_header_title">{lang code='fileslist.system.title' ucf=true}</div>
                                            </td>
                                            <td>
                                                <div class="block_header_title" style="text-align: right;"><span class="red_color" id="FilesListMessage"></span></div>
                                            </td>
                                        </tr>
                                        </table>
                                        <div class="tb_line_ico">
                                            {*
                                            <table class="item_ico">
                                                <tr>
                                                    <td>
                                                        <a href="javascript:RADUsers.addClick();">
                                                            <img src="{const SITE_URL}img/backend/add.png" alt="{lang code="-add"|replace:'"':'&qout;'}" width="30" height="30" border="0" alt="{lang code='-add' ucf=true|replace:'"':'&qout;'}" title="{lang code='-add' ucf=true|replace:'"':'&qout;'}" />
                                                            <span class="text" style="width:50px;">{lang code='-add'}</span>
                                                        </a>
                                                    </td>
                                                </tr>
                                            </table>
                                            <table class="item_ico" align="left" align="left;" style="float:left;margin-top:10px;">
                                               <tr>
                                                   <td height="100%" valign="bottom" nowrap="nowrap" width="250">
                                                        <form method="post" id="searchUsersForm" action="{const SITE_URL}{const SITE_ALIAS}/action/search/" onsubmit="return false;">
                                                            <div>
                                                                <div style="float:left;">{$lang->_('-search.title')}<br />   <input type="text" name="search" id="searchusersword" value="{if isset($searchword)}{$searchword}{/if}" onKeyPress="RADUsers.searchKeyPress(event);" /></div>
                                                                <div style="float:left;margin-top:5px;"><a><input type="image" src="{const SITE_URL}img/backend/zoom.png" alt="{$lang->_('submit')}" title="{$lang->_('submit')}"  onclick="RADUsers.searchClick();" /></a></div>
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
                            <td align="left" id="panel_folderslist">

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
    </div>
</div>
{/strip}