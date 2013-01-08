{strip}
<div style="position:absolute; width:100%; height:100%; text-align:center; background:#cccccc; opacity:0.6; filter:alpha(opacity=60); z-index: 10000;">
<div class="magic"></div>
        <div class="formInner">
            <table id="loginform_block" cellpadding="0" cellspacing="0" border="0" class="tb_cont_block" style="height:auto;width:100%;margin-top:15px;background:#ffffff;">
                <tr>
                    <td class="corner_lt"></td>
                    <td class="header_top"></td>
                    <td class="corner_rt"></td>
                </tr>
                <tr>
                    <td class="left_border"></td>
                    <td class="header_bootom" style="height: 28px;" id="header_bootom_id">
                        <div class="hb">
                            <div class="hb_inner" id="mes_title_block">
                                <table border="0" cellpadding="0" cellspacing="0" width="100%">
                                <tr>
                                    <td>
                                        <div class="block_header_title" id="block_header_title">{lang code='loginform.system.title' ucf=true}</div>
                                    </td>
                                    <td>
                                        <div class="block_header_title" style="text-align: right;"><span class="red_color" id="LoginFormMessage">{if isset($message)}{$message}{/if}</span></div>
                                    </td>
                                </tr>
                                </table>
                            </div>
                        </div>
                    </td>
                    <td class="right_border"></td>
                </tr>
                <tr id="content_tr">
                    <td class="left_border" nowrap="nowrap" style="width:3px;"></td>
                    <td align="left" id="panel_fedbacklist">


                        {* LOGIN FORM HERE!  *}
                        <form method="POST" action="{url href="alias=`$alias_loginform`"}">
                            {if !empty($referer)}
                                <input type="hidden" name="referer" value="{$referer}" />
                            {/if}
                            <table cellpadding="0" cellspacing="0" border="0" width="100%" style="mergin:5px 5px 0px 5px;">
                               {if !empty($message_error)}
                                <tr>
                                    <td colspan="2" align="center"><span style="color:red;">{$message_error}</span></td>
                                </tr>
                               {/if}                                
                                <tr>
                                    <td width="5%" nowrap="nowrap" valign="middle">
                                        <font size="2">{lang code='login.session.text'}:</font>
                                    </td>
                                    <td>
                                        <input type="text" name="login" id="login" value="" style="width:95%" />
                                    </td>
                                </tr>
                                <tr>
                                    <td nowrap="nowrap" valign="middle">
                                        <font size="2">{lang code='password.session.text'}:</font>
                                    </td>
                                    <td>
                                        <input type="password" name="pass" value="" style="width:95%" />
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2" align="center">
                                        <input type="hidden" name="hash" value="{$hash}"/>
                                        <input type="submit" value="{lang code='-submit' ucf=true}">
                                    </td>
                                </tr>
                            </table>
                        </form>



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
        </div>
</div>
<script type="text/javascript">
    $('login').focus();
</script>
{/strip}