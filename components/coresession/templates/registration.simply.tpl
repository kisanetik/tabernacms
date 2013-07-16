<script type="text/javascript">
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
    var URL_SOC_LOGIN = '{url href="alias=login.html&action=soc_login"}';
    var SOC_LOGIN_TITLE = '{lang code ="soctitle.session.title" ucf=true}';
    var URL_CHECK_EMAIL = '{url href="alias=SYSXML&a=user_exists"}';
</script>
{url module="coresession" type="js" file="radreg.js" load="inplace"}
<script type="text/javascript">
        $(document).ready(function() {
            $('input, textarea').bind('focus', function(element) {
                RADRegForm.clearError(this.id);
            });
        });
</script>
    <div class="reg_form">
        {*<h2>{lang code='registration.session.title' ucf=true}</h2>*}
        {if (!isset($onlymessage) or !$onlymessage) and !isset($action)}
            <form id="registration_form" method="post" action="{url href="a=r"}">
                <p class="formfeedback nm" style="padding-top: 10px;">
                    {lang code="reginfo.session.text" ucf=true}
                </p>
                    {if isset($message)}
                        <div style="color:red;text-align:center;">{$message}</div>
                    {/if}
    </div>
                <table cellpadding="0" cellspacing="0" border="0" width="400" class="tabreg" bgcolor="#eff5fa"><tbody>
                    <tr>
                    <td style="padding-bottom:10px;" colspan="2">
                        
                    </td>
                </tr>
                    <tr>
                        <td align="right" nowrap="nowrap" width="25%">
                            {lang code="email.session.text" ucf=true}&nbsp;<span style="color:red;">*</span>&nbsp;
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
                            {lang code="password.session.text" ucf=true}&nbsp;<span style="color:red;">*</span>&nbsp;
                        </td>
                        <td align="left" width="100%">
                            <div class='element'>
                                <input type="password"  class="user" id="u_pass1" name="u_pass1" value=""  />
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td align="right" nowrap="nowrap"  >
                            {lang code="confirmnewpassword.session.text" ucf=true}&nbsp;<span style="color:red;">*</span>&nbsp;
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
                         <input type="text" class="user smll" style="width: 150px; margin: 4px;" maxlengrh="8" id="captcha" name="captcha" value="" />
                            <a href="#" onclick="return RADCaptcha.renew('capcha_img',SITE_ALIAS);">
                                <img id="capcha_img"  src="{url href="alias=SYSXML&a=showCaptcha&page=SITE_ALIAS"}" alt="{lang code="entercaptcha.session.text" ucf=true}" />
                                <br />
                                {lang code="dontseechars.system.link" ucf=true}
                           </a>
                        </div>
                        {if isset($captcha_error)}
                            <div style="width:250px;float:right;color:red;padding:0 30px;">{$captcha_error}</div>
                        {/if}
                        <br clear="all" />
                        <input type="button" class="btnorge  treb wt order feedbackbt" value="{lang code="-submit" ucf=true}" onclick="if(RADRegForm.validate()) $('#registration_form').submit();"/>
                    </div>
            </form>
        {/if}
        {if isset($action)}
            {if ($action eq 'c' or $action == 'success') and !empty($message)}
                <p align="center">{$message}</p>
                {if $action eq 'c' and !empty($message)}
            {literal}
                <script type="text/javascript">
                    setTimeout(function(){location="/";},3000);
                </script>
            {/literal}
                {/if}
            </div>
          {/if}
        {/if}

{if !empty($params->is_facebook) or !empty($params->is_twitter)}
    <table cellpadding="0" cellspacing="0" border="0" width="400" class="tabreg" bgcolor="#eff5fa">
    <tr>
        <td align="center">{lang code="regsocials.session.text" ucf=true}</td>
    </tr>
    <tr>
        <td><br/></td>
    </tr>
    <tr>
        <td align="center" style="padding-left:200px;">
        {if $params->is_facebook}
            <div style="float:left; padding-right:10px; width:150px;">
                <a href="javascript:RADSocials.socLogin('facebook');" style="text-decoration: none;"><img src="{url module="core" file="des/socials/FaceBook_48x48.png" type="image"}" border="0" align="middle"/> <span style="font-size:13px;">Facebook</span></a>
            </div>
        {/if}
        {if $params->is_twitter}            
            <div style="float:left; padding-right:10px; width:150px;">
                <a href="javascript:RADSocials.socLogin('twitter');" style="text-decoration: none;"><img src="{url module="core" file="des/socials/Twitter_48x48.png" type="image"}" border="0" align="middle"/> <span style="font-size:13px;">Twitter</span></a>
            </div>
        {/if}
        </td>
    </tr>       
    </table>
{/if}