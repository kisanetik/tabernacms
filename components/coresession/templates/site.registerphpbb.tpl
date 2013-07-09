<script type="text/javascript">
    {strip}
       var REQUIRED_FIELD      = '{lang code="requiredfield.session.message" ucf=true}';
       var PASSWORDS_NOT_MATCH = '{lang code="passwordsnotmatch.session.message" ucf=true}';
       var PASSWORDS_IS_SHORT  = '{lang code="passwordishort.session.message" ucf=true}';
       var EMPTY_FIO_FIELD     = '{lang code="emptyfiofield.session.message" ucf=true}';
       var EMPTY_EMAIL_FIELD   = '{lang code="emptyemailfield.session.message" ucf=true}';
       var EMAIL_INCORRECT     = '{lang code="emailincorrect.session.message" ucf=true}';
       var EMAIL_CORRECT       = '{lang code="emailcorrect.session.message" ucf=true}';
       var EMAIL_EXSISTS       = '{lang code="mailexsists.session.message" ucf=true}';
       var LOST_PASSWORD       = '{lang code="forgetpass.session.link" ucf=true}';
       var URL_SHOWCAPTCHA = '{url href="alias=SYSXML&a=showCaptcha"}';
    {/strip}
</script>
{url module="coresession" type="js" file="radreg.js"}
<script type="text/javascript">
        $(document).ready(function() {
            $('input, textarea').bind('focus', function(element) {
                RADRegForm.clearError(this.id);
            });
        });
</script>
    <div class="reg_form">
        {if (!isset($onlymessage) or !$onlymessage) and !isset($action)}
            <form id="registration_form" method="post" action="{url href="a=r"}">
                <p class="formfeedback nm" style="padding-top: 10px;">
                    {lang code="reginfo.session.text"}
                </p>
                    {if isset($message)}
                        <br /><span style="color:red;">{$message}</span>
                    {/if}
    </div>
                <table cellpadding="0" cellspacing="0" border="0" width="400" class="tabreg" bgcolor="#eff5fa"><tbody>
                    <tr>
                    <td style="padding-bottom:10px;" colspan="2">
                        
                    </td>
                </tr>
                    <tr>
                        <td align="right" nowrap="nowrap" width="25%">
                            {lang code="email.session.text"}&nbsp;<span style="color:red;">*</span>&nbsp;
                        </td>
                        <td align="left" width="75%">
                            <div class='element'>
                                <input type="text" class="user " name="u_email" id="u_email" value="{$item->u_email}"  onblur="RADRegForm.checkEmail()" />
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td align="right" nowrap="nowrap">
                            {lang code="fio.session.text"}&nbsp;<span style="color:red;">*</span>&nbsp;
                        </td>
                        <td align="left" width="100%">
                            <div class='element'>
                                <input type="text" class="user" name="u_fio" id="u_fio" value="{$item->u_fio}"  />
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td align="right" nowrap="nowrap">
                            {lang code="nickname.session.text"}&nbsp;<span style="color:red;">*</span>&nbsp;
                        </td>
                        <td align="left" width="100%">
                            <div class='element'>
                                <input type="text" class="user" name="u_login" id="u_login" value="{$item->u_login}"  />
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td align="right" nowrap="nowrap">
                            {lang code="phone.session.text" ucf=true}&nbsp;
                        </td>
                        <td align="left" width="100%">
                            <div class='element'>
                                <input type="text" class="user" name="u_phone" id="u_phone" value="{$item->u_phone}" maxlength="16"  />
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td align="right" nowrap="nowrap">
                            {lang code="password.session.text"}&nbsp;<span style="color:red;">*</span>&nbsp;
                        </td>
                        <td align="left" width="100%">
                            <div class='element'>
                                <input type="password"  class="user" id="u_pass1" name="u_pass1" value=""  />
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td align="right" nowrap="nowrap"  >
                            {lang code="confirmnewpassword.session.text"}&nbsp;<span style="color:red;">*</span>&nbsp;
                        </td>
                        <td align="left" width="100%" style="padding-bottom: 20px;">
                            <div class='element'>
                                <input type="password" class="user" id="u_pass2" name="u_pass2" id="confirm_u_pass" value=""  />
                            </div>
                        </td>
                    </tr></tbody>
                </table>
                    <div class="reg_form_bottom">
                <p class="input_symbols">
                    {lang code="entercapcha.session.text" ucf=true}
                    <span class="red_text">*</span>
                </p>
                        <div class="capcha_pic">
                         <input type="text" class="user smll" style="width: 150px; margin: 4px;" maxlength="8" id="captcha" name="captcha" value="" />
                            <a href="javascript:void(0)" onclick="return RADCaptcha.renew('captcha_img', SITE_ALIAS)">
                                <img id="captcha_img"  src="{url href="alias=SYSXML&a=showCaptcha&page=SITE_ALIAS"}" alt="{lang code="entercaptcha.session.text" ucf=true}" />
                                <br/>
                                {lang code="dontseechars.system.link" ucf=true}
                            </a>
                        </div>
                            <input type="button" class="btnorge  treb wt order feedbackbt" value="{lang code="-submit" ucf=true}" onclick="if(RADRegForm.validate()) $('#registration_form').submit();"/>
                    </div>
            </form>
        {/if}
        {if isset($action)}
          {if $action eq 'c' or $action eq 'r' and !empty($message)}
            <center>{$message}</center>
          {/if}
          </div>
        {/if}