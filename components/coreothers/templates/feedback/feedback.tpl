{strip}
<script language="JavaScript" type="text/javascript">
    var FDO_ENTER_MAIL = "{lang code="entervalidemail.feedback.error" ucf=true htmlchars=true}";
    var FDO_ENTER_FIO = "{lang code="entercorrectfio.feedback.error" ucf=true htmlchars=true}";
    var FDO_ENTER_TITLE = "{lang code="entercorrecttitle.feedback.error" ucf=true htmlchars=true}";
    var FDO_ENTER_BODY = "{lang code="entercorrectbody.feedback.error" ucf=true htmlchars=true}";
    var FDO_ENTER_CAPTCHA = "{lang code="entercapcha.session.text" ucf=true htmlchars=true}";
    var REQUIRED_FIELD      = '{lang code="requiredfield.session.message" ucf=true}';
    var EMPTY_EMAIL_FIELD   = '{lang code="emptyemailfield.session.message" ucf=true}';
    var EMAIL_INCORRECT     = '{lang code="emailincorrect.session.message" ucf=true}';
    var qo = {if (empty($qo))} false {else} true {/if};
    var URL_SHOWCAPTCHA = '{url href="alias=SYSXML&a=showCaptcha"}';
</script>
<span class="feedback">
{if empty($action) or !empty($error_message)}
    {if isset($error_message)}
        <div style="width: 100%;text-align:center;" class="red_text">{$error_message}</div>
    {/if}
    <div id="basket_order_data" class="rpart">

        <div class="reg_form">
            <p class="formfeedback">{lang code="feedbackform.feedback.title" ucf=true}</p>
            <p class="formfeedback nm">{lang code="markedfieldsrequired.others.text" ucf=true}</p>
        </div>
        <form method="post" id="feedbackForm" action="{url href="alias=contacts.html"}" class="feedback">
            <input type="hidden" name="hash" value="{$hash}" />
            <input type="hidden" name="action" value="send" />
            {if !empty($qo)}
                <input type="hidden" name="qo" value="1" />
            {/if}
            {if !empty($referer)}
                <input type="hidden" name="referer" value="{$referer}" />
            {/if}
            <table width="100%" cellspacing="0" cellpadding="0" border="0" bgcolor="#eff5fa" class="formfeedback"><tbody>
                <tr>
                    <td style="padding-bottom:10px;" colspan="2">

                    </td>
                </tr>
                <tr>
                    <td width="25%" align="right" nowrap="nowrap">
                        <span id="span_fio">{lang code="fio.session.text"}</span>&nbsp;<span style="color: red;">*</span>
                    </td>
                    <td width="100%" align="left">
                        <div class="element">
                            <input type="text" id="sender_fio" name="sender_fio" value="{if isset($sender_fio)}{$sender_fio}{/if}" maxlength="100" class="user lng" x-webkit-speech="" speech="" onwebkitspeechchange="return void(0);" />
                        </div>
                    </td>
                </tr>
                {if empty($qo)}
                <tr>
                    <td align="right" nowrap="nowrap"><span id="span_contact_phone">E-mail</span>&nbsp;<span class="red_text">*</span>
                    </td>
                    <td width="100%" align="left">
                        <div class="element">
                            <input type="text" id="sender_email" name="sender_email" value="{if isset($sender_email)}{$sender_email}{/if}" maxlength="100" class="user lng" />
                        </div>
                    </td>
                </tr>
                <tr>
                    <td align="right" nowrap="nowrap" valign="top" style="padding-top: 15px;">
                        <span>{lang code="textbody.others.text" ucf=true}</span>&nbsp;<span class="red_text">*</span>
                    </td>
                    <td width="100%" align="left" style="padding-bottom: 15px;">
                        <div class="element">
                            <textarea name="message_body" id="message_body" rows="5" class="user">{if isset($message_body)}{$message_body}{/if}</textarea>
                        </div>
                    </td>
                </tr></tbody>
            </table>
            {/if}
            <div class="reg_form_bottom">
                <p class="input_symbols">
                    {lang code="entercapcha.session.text" ucf=true}
                    <span class="red_text">*</span>
                </p>
                <div class="capcha_pic">
                    <input type="text" id="captcha_text"  maxlength="8" name="captcha_text" class="user smll" style="width: 148px; margin: 3px;">
                    <a href="javascript:void(0)" onclick="return RADCaptcha.renew('captcha_img', SITE_ALIAS)">
                        <img src="{url href="alias=SYSXML&a=showCaptcha&page=SITE_ALIAS"}" id="captcha_img" alt="{lang code="entercapcha.session.text" ucf=true}" border="0" />
                        <br />
                        {lang code="dontseechars.system.link" ucf=true}
                    </a>
                    &nbsp;
                </div>
                <input type="button" name="send_feedback" onclick="if(RADFeedbackForm.validate()) $('#feedbackForm').submit();" value="{lang code='-submit'}" class="btnorge  treb wt order feedbackbt" /></div>
        </form>
    </div>
{else}
    <h2 style="padding: 0;text-align: center;padding-left:50px;margin-left:-50px;background:#FFFFFF;position:absolute;top:70px;">{lang code="thainksfeedback.others.text" ucf=true}</h2>
    <a href='{url href="alias=index.html"}' style="display: block; text-align: center;">{lang code="gohomepage.others.text" ucf=true}</a>
{/if}
</span>
{/strip}