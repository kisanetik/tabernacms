{strip}
{if isset($action) and ($action eq 'deleteone' or $action eq 'editone' or $action eq 'applysave')}{/if}
{if isset($action) and $action eq 'getjs'}{include file="$_CURRENT_LOAD_PATH/admin.managecurrency/js/getjs.tpl"}{/if}
{if isset($action) and $action eq 'getList'}{include file="$_CURRENT_LOAD_PATH/admin.managecurrency/panels/list.tpl"}{/if}
{if isset($action) and ($action eq 'addwindow' or $action eq 'editone')}{include file="$_CURRENT_LOAD_PATH/admin.managecurrency/panels/addwindow.tpl"}{/if}
{if !isset($action)}
{url type="js" file="alias=SITE_ALIASXML&action=getjs"}
<div class="w100">
    <div class="kord_right_col">
        

        <table cellpadding="0" cellspacing="0" border="0" class="tb_cont_block" style="height:auto;" >
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
                                        <div class="block_header_title">{lang code='managecurrency.catalog.title' ucf=true}</div>
                                    </td>
                                    <td>
                                        <div class="block_header_title" style="text-align: right;color:red;"><div class="red_color" id="ManageCurrencyMessage"></div></div>
                                    </td>
                                </tr>
                                </table>
                                            
                                <div class="tb_line_ico">
                                    <table class="item_ico">
                                        <tr>
                                            <td>
                                                <a href="javascript:RADCurrency.applyClick();">
                                                    <img src="{const SITE_URL}img/backend/accept.png" alt="" width="30" height="30" border="0" alt="{lang code='-add'}" title="{lang code='-add'}" />
                                                    <span class="text" style="width:50px;">{lang code='-apply'}</span>
                                                </a>
                                            </td>
                                        </tr>
                                    </table>
                                    <table class="item_ico">
                                        <tr>
                                            <td>
                                                <a href="javascript:RADCurrency.add();">
                                                    <img src="{const SITE_URL}img/backend/add.png" alt="" width="30" height="30" border="0" alt="{lang code='-add'}" title="{lang code='-add'}" />
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
                    <td class="left_border"></td>
                    <td align="center" id="currency_list">
                        {lang code='-loading' ucf=true}
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
        
    </div>
</div>
{/if}
{/strip}