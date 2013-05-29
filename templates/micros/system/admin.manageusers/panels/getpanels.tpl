{strip}
{url type="js" file="jscss/components/mootree/mootree.js"}
{url type="css" file="jscss/components/mootree/mootree.css"}
{url type="js" file="alias=SITE_ALIASXML&action=getjs"}
<h1 id="manageUsersTitle">{lang code="manageusers.system.title" ucf=true}</h1>
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
                                        <div class="block_header_title">{lang code="usersgroups.system.title" ucf=true}</div>
                                    </td>
                                    <td>
                                        <div class="block_header_title" style="text-align: right;color:red;"><div class="red_color" id="UsersTreeMessage"></div></div>
                                    </td>
                                </tr>
                                </table>
                                <div class="tb_line_ico">
                                    <table class="item_ico">
                                        <tr>
                                            <td>
                                                <a href="javascript:RADUsersTree.addClick();">
                                                    <img src="{const SITE_URL}img/backend/add.png" alt="{lang code="-add" ucf=true|replace:'"':'&quot;'}" width="30" height="30" border="0" alt="{lang code='-add'}" title="{lang code='-add'}" />
                                                    <span class="text" style="width:50px;">{lang code='-add' ucf=true}</span>
                                                </a>
                                            </td>
                                        </tr>
                                    </table>
                                    <table class="item_ico">
                                        <tr>
                                            <td>
                                                <a href="javascript:RADUsersTree.editClick();">
                                                    <img src="{const SITE_URL}img/backend/pencil.png" alt="{lang code="-edit" ucf=true|replace:'"':'&quot;'}" width="30" height="30" border="0" alt="{lang code='-edit'}" title="{lang code='-edit'}" />
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
            <table cellpadding="0" cellspacing="0" border="0" class="tb_cont_block" style="height:auto;width:300px;visibility:hidden;" id="editUsersTreeBlock">
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
                                        <div class="block_header_title">{lang code="edituserstree.system.title" ucf=true}</div>
                                    </td>
                                    <td>
                                        <div class="block_header_title" style="text-align: right;"><span class="red_color" id="usersInfoMessage"></span></div>
                                    </td>
                                </tr>
                                </table>
                                <div class="tb_line_ico">
                                    <table class="item_ico">
                                        <tr>
                                            <td>
                                                <a href="javascript:RADUsersTree.cancelEdit();">
                                                    <img class="img" src="{const SITE_URL}img/backend/arrow_undo.png" alt="{lang code="-cancel" ucf=true|replace:'"':'&quot;'}" width="30" height="30" border="0" alt="{lang code='-cancel'}" title="{lang code='-cancel'}" />
                                                    <span class="text" style="width:50px;">{lang code="-cancel" ucf=true}</span>
                                                </a>
                                            </td>
                                        </tr>
                                    </table>
                                    <table class="item_ico">
                                        <tr>
                                            <td>
                                                <a href="javascript:RADUsersTree.deleteNode();">
                                                    <img src="{const SITE_URL}img/backend/icons/ico_delete.gif" alt="{lang code="-delete" ucf=true|replace:'"':'&quot;'}" width="30" height="30" border="0" alt="{lang code='-delete'}" title="{lang code='-delete'}" />
                                                    <span class="text" style="width:50px;">{lang code="-delete" ucf=true}</span>
                                                </a>
                                            </td>
                                        </tr>
                                    </table>
                                    <table class="item_ico">
                                        <tr>
                                            <td>
                                                <a href="javascript:RADUsersTree.saveEdit();">
                                                    <img src="{const SITE_URL}img/backend/disk.png" alt="{lang code="-save" ucf=true|replace:'"':'&quot;'}" width="30" height="30" border="0" alt="{lang code='-save'}" title="{lang code='-save'}" />
                                                    <span class="text" style="width:50px;">{lang code="-save" ucf=true}</span>
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
                    <td align="left" id="editUsersTreeNode" class="panel_main"></td>
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
            <table id="userslist_block" cellpadding="0" cellspacing="0" border="0" class="tb_cont_block" style="height:auto;width:100%;display:none;">
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
                                        <div class="block_header_title">{lang code="userslist.system.title" ucf=true}</div>
                                    </td>
                                    <td>
                                        <div class="block_header_title" style="text-align: right;"><span class="red_color" id="UsersListMessage"></span></div>
                                    </td>
                                </tr>
                                </table>
                                <div class="tb_line_ico">
                                    <table class="item_ico">
                                        <tr>
                                            <td>
                                                <a href="javascript:RADUsers.addClick();">
                                                    <img src="{const SITE_URL}img/backend/add.png" width="30" height="30" border="0" alt="{lang code='-add' ucf=true|replace:'"':'&quot;'}" title="{lang code='-add' ucf=true|replace:'"':'&quot;'}" />
                                                    <span class="text" style="width:50px;">{lang code='-add' ucf=true}</span>
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
                    <td align="left" id="panel_userslist">

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
    {if $params->_get('ishaveregistration',false)}
    <tr>
        <td colspan="2">
            <table id="settings_block" cellpadding="0" cellspacing="0" border="0" class="tb_cont_block" style="height:auto;width:100%;">
                <tr>
                    <td class="corner_lt"></td>
                    <td class="header_top"></td>
                    <td class="corner_rt"></td>
                </tr>
                <tr>
                    <td class="left_border"></td>
                    <td class="header_bootom">
                        <div class="hb">
                            <div class="hb_inner" id="mail_opt_block">
                                <table border="0" cellpadding="0" cellspacing="0" width="100%">
                                <tr>
                                    <td>
                                        <div class="block_header_title">{lang code='registrationsettings.others.title' ucf=true}</div>
                                    </td>
                                    <td>
                                        <div class="block_header_title" style="text-align: right;"><span class="red_color" id="RegistrationSettingsMessage"></span></div>
                                    </td>
                                </tr>
                                </table>
                                <div class="tb_line_ico">
                                    <table class="item_ico">
                                        <tr>
                                            <td>
                                                <a href="javascript:RADRegSettings.applyClick();">
                                                    <img src="{const SITE_URL}img/backend/accept.png" alt="{lang code="-apply" ucf=true|replace:'"':'&quot;'}" width="30" height="30" border="0" alt="{lang code='-apply'}" title="{lang code='-apply'}" />
                                                    <span class="text" style="width:50px;">{lang code='-apply' ucf=true|replace:'"':'&quot;'}</span>
                                                </a>
                                            </td>
                                        </tr>
                                    </table>
                                    <table class="item_ico">
                                        <tr>
                                            <td>
                                                <a href="javascript:RADRegSettings.toggle();"  id="toggleSubscribeOprions">
                                                    <img src="{const SITE_URL}img/backend/icons/refresh.gif" alt="{lang code="-showhide" ucf=true|replace:'"':'&quot;'}" width="30" height="30" border="0" alt="{lang code='-showhide'}" title="{lang code='-showhide'}" />
                                                    <span class="text" style="width:50px;">{lang code='-showhide' ucf=true|replace:'"':'&quot;'}</span>
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
                <tr id="content_tr">
                    <td class="left_border" nowrap="nowrap" style="width:3px;"></td>
                    <td align="left" id="panel_registersettings" style="display:none;">
                        {include file="$_CURRENT_LOAD_PATH/admin.manageusers/panels/registersettings.tpl"}
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
    {/if}
</table>
{/strip}