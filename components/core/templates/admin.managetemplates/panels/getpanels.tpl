{strip}
<div class="w100">
    <div class="kord_right_col">
        <form method="post" id="hiddenform">
            <input type="hidden" id="hidden_data" name="dpath" value="" />
        </form>
        {url module="core" file="mootree/mootree.js" type="js"}
        {url module="" file="editarea/edit_area_full.js" type="js"}
        {url module="" file="editarea/edit_area.css" type="css"}
        {url module="core" file="mootree/mootree.css" type="css"}
        {url href="alias=SITE_ALIASXML&action=getjs" type="js"}
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
                                                            <img src="{url module="core" preset="original" type="image" file="backend/pencil.png"}" width="30" height="30" border="0" alt="{lang code='-edit' ucf=true htmlchars=true}" title="{lang code='-edit' ucf=true htmlchars=true}" />
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
                                    </div>{radinclude module="core" file="admin.managetemplates/panels/tree_recursy.tpl" elements=$items href=''}
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
                                                            <img class="img" src="{url module="core" preset="original" type="image" file="backend/arrow_undo.png"}" alt="{lang code="-cancel" ucf=true htmlchars=true}" width="30" height="30" border="0" alt="{lang code='-cancel' htmlchars=true}" title="{lang code='-cancel' htmlchars=true}" />
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
                                                            <img src="{url module="core" preset="original" type="image" file="backend/icons/ico_delete.gif"}" alt="" width="30" height="30" border="0" alt="{lang code='-delete'}" title="{lang code='-delete'}" />
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
                                                            <img src="{url module="core" preset="original" type="image" file="backend/disk.png"}" alt="" width="30" height="30" border="0" alt="{lang code='-save' htmlchars=true}" title="{lang code='-save' htmlchars=true}" />
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
                                                            <img src="{url module="core" preset="original" type="image" file="backend/add.png"}" alt="{lang code="-add" htmlchars=true}" width="30" height="30" border="0" alt="{lang code='-add' ucf=true htmlchars=true}" title="{lang code='-add' ucf=true htmlchars=true}" />
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
                                                                <div style="float:left;margin-top:5px;"><a><input type="image" src="{url module="core" preset="original" type="image" file="backend/zoom.png"}" alt="{$lang->_('submit')}" title="{$lang->_('submit')}"  onclick="RADUsers.searchClick();" /></a></div>
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