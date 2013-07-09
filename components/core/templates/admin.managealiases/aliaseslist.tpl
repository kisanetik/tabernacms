{strip}
{url href="alias=SITE_ALIASXML&action=getjs_aliaslist" type="js"}
<h1>{lang code='aliaseslist.system.title' ucf=true}</h1>
<table cellpadding="0" cellspacing="0" border="0" class="tb_two_column" style="width:100%;">
    <tr>
        <td>
            <table cellpadding="0" cellspacing="0" border="0" class="tb_cont_block" height="100%" width="100%">
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
                                        <div class="block_header_title">{lang code='aliases.system.title' ucf=true}</div>
                                    </td>
                                    <td>
                                        <div class="block_header_title" style="text-align: right;color:red;">
                                            <div class="red_color" id="AliasesListMessage"></div>
                                        </div>
                                    </td>
                                </tr>
                                </table>
                                {*<div class="block_header_title">{lang code='aliases.system.title' ucf=true}</div>*}
                                <div class="tb_line_ico">
                                    <table class="item_ico">
                                        <tr>
                                            <td>
                                                <a id="addBtn" href="{url href="action=add"}">
                                                    <img src="{url module="core" preset="original" type="image" file="backend/add.png"}" alt="{lang code='-add' ucf=true|replace:'"':'&quot;'}" title="{lang code='-add' ucf=true|replace:'"':'&quot;'}" width="30" height="30" border="0">
                                                    <span class="text" style="width:50px;">{lang code='-add' ucf=true}</span>
                                                </a>
                                            </td>
                                        </tr>
                                    </table>
                                    <table class="item_ico">
                                        <tr>
                                            <td>
                                                <a href="javascript:RADAliasesList.refresh();">
                                                    <img src="{url module="core" preset="original" type="image" file="backend/arrow_rotate_clockwise.png"}" alt="{lang code='-refresh' ucf=true|replace:'"':'&quot;'}" title="{lang code='-refresh' ucf=true|replace:'"':'&quot;'}" width="30" height="30" border="0">
                                                    <span class="text" style="width:50px;">{lang code='-refresh'}</span>
                                                </a>
                                            </td>
                                        </tr>
                                    </table>
                                    <table class="item_ico" align="left" align="left;" style="float:left;margin-top:10px;">
                                       <tr>
                                           <td height="100%" valign="bottom" nowrap="nowrap" width="250">
                                                <div>
                                                    <div style="float:left;">
                                                        <input type="text" name="search" id="search" onKeyPress="RADAliasesList.addKeyPress(event);" value="{$searchword}" />
                                                    </div>
                                                    <div style="float:left;">
                                                        <a>
                                                            <input type="image" src="{url module="core" preset="original" type="image" file="backend/zoom.png"}" alt="{lang code='-submit' ucf=true|replace:'"':'&quot;'}" title="{lang code='-search.title' ucf=true|replace:'"':'&quot;'}" onclick="RADAliasesList.search();" />
                                                        </a>
                                                    </div>
                                                </div>
                                           </td>
                                           <td valign="bottom" nowrap="nowrap">
                                               <div class="alias-sections" id="alias_type">
                                                    <div class="vkladka" onclick="RADAliasesList.filterApply('onlyadmin_yes')">
                                                        <input type="radio" value="1" name="onlyadmin" id="onlyadmin_yes" />&nbsp;{lang code='onlyadmin_yes.system.text'}
                                                    </div>
                                                    <div class="vkladka activ" onclick="RADAliasesList.filterApply('onlyadmin_no')">
                                                        <input type="radio" value="0" name="onlyadmin" id="onlyadmin_no" checked="checked" />&nbsp;{lang code='onlyadmin_no.system.text'}
                                                    </div>
                                                    <div class="vkladka" onclick="RADAliasesList.filterApply('onlyadmin_templates')">
                                                        <input type="radio" value="2" name="onlyadmin" id="onlyadmin_templates" />&nbsp;{lang code='aliasestemplates.system.text'}
                                                    </div>
                                               </div>
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
                    <td align="left">
                    {include file="$_CURRENT_LOAD_PATH/admin.managealiases/aliaseslist_inc.tpl"}
                    </td>
                    <td class="right_border"></td>
                </tr>
                <tr>
                    <td class="left_border"></td>
                    <td class="gray_line" align="right" id="total_items">
                          {*{lang code='-total'}: {$items|@count}*}
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
<script language="JavaScript" type="text/javascript">
    if(Browser.Engine.trident) startList();
</script>
{/strip}