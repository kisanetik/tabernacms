{strip}
<script language="JavaScript" type="text/javascript">
  var URL_SOC_LOGIN = '{url href="alias=login.html&action=soc_login"}';
  var SOC_LOGIN_TITLE = '{lang code ="soctitle.session.title" ucf=true}';
</script>
{url module="coresession" file="radsocials.js" type="js"}
{if !empty($user->u_id)}
    <div class="contauthor">
        <h6>{lang code="loginas.session.text" ucf=true}</h6>
        <a href="{url href="alias=personalcabinet"}">{lang code ="personalcabinet.session.title" ucf=true}</a>
        <p class="tx">{$user->u_login|default:$user->u_fio}</p>
        <input id="logout_btn" type="button"  name="on"  class="onbt" value="" />
        <script>
           var URL_LOGOUT = '{url href="alias=login.html&logout=true&fromsite=true"}';
        </script>
    </div>
    {else}
    <input id="login_btn" type="button"  name="author"  class="author author_{$_CURR_LANG_OBJ}" value="" />
    <a href="{url href="alias=register"}" class="registration">
        {lang code ="registration.session.title" ucf=true}
    </a>
{/if}
{if !empty($langs) and count($langs) > 1}
    <div class="lang-flags">
    {foreach from=$langs item="lang"}
        {if $lang->lng_id neq $currentLangId and $lang->lng_active}
            <div class="lang-flag">
                <a href="{url href="alias=chlang&lang=`$lang->lng_code`&fromsite=true"}">
                    <img src="{url module="core" file="lang/`$lang->lng_img`" type="image" preset="language_medium"}" alt="{$lang->lng_name}" border="0" />
                </a>
            </div>
        {/if}
    {/foreach}
    </div>
{/if}

    {url module="" file="jquery/ui/jquery-ui.css" type="css"}
    {url module="coresession" file="select/themes/jquery.ui.selectmenu.css" type="css"}
    {url module="coresession" file="select/select.css" type="css"}
    {url module="" file="jquery/ui/jquery-ui.js" type="js"}
    {url module="" file="jquery/ui/jquery.ui.selectmenu.js" type="js"}
    {url module="coresession" file="select/select.js" type="js"}
    
    {if !empty($currency)}
    <div id='select'>
        <fieldset>
            <select name="peopleB" id="peopleB">
                {foreach from=$currency item="cur"}
                    <option value="{$cur->cur_id}" class="css-avatar"{if $cur->cur_id eq $currentCurrency} selected="selected"{/if} {if $cur->cur_image}style="background-image:url({url module="core" file="currency/`$cur->cur_image`" type="image" preset="original"});"{/if}>{$cur->cur_name|replace:' ':'&nbsp;'}{if $cur->cur_showcurs}&nbsp;({$cur->cur_cost}){/if}</option>
                {/foreach}
            </select>
        </fieldset>
    </div>
    {/if}

<div id="loginpanel_wrapper" style="position:relative;">
    {if !empty($params->is_facebook) or !empty($params->is_twitter)}
        <div class="loginpanel_socials" id="loginpanel_socials">
    {else}
        <div class="loginpanel" id="loginpanel">
    {/if}
        <form id="loginform" method="post" action="{url href='alias=login.html'}">
            <input type="hidden" name="hash" value="{$hash}" />
                {if !empty($params->is_facebook) or !empty($params->is_twitter)}
                    <div class="entry_socials">
                {else}
                    <div class="entry">
                {/if}
                        <input type="text"  name="login"  class="user" id="lp_login" value="{lang code="-email"}" onfocus="if (this.value=='{lang code="-email"}') this.value='';" onblur="if (this.value==''){literal}{{/literal}this.value='{lang code="-email"}'{literal}}{/literal}"/>
                        <input type="password"  name="pass"  class="user" id="lp_password" value="{lang code="password.session.text"}" onfocus="if (this.value=='{lang code="password.session.text"}') this.value='';" onblur="if (this.value==''){literal}{{/literal}this.value='{lang code="password.session.text"}'{literal}}{/literal}"/>
                        <a href="{url href="alias=rempass.html"}">{lang code ="recoverpassword.sesion.title" ucf=true}</a>
                        <input id="login" type="submit" name="enter" class="btnblue tx wt enter" value="{lang code ="enter.session.title" ucf=true}" {if isset($params->is_socials) and $params->is_socials eq true}style="margin:12px 12px -8px 12px;"{/if} />
                    {if !empty($params->is_facebook) or !empty($params->is_twitter)}
                        <br/>
                        <span style="font-size:14px;">
                            <p align="center">
                                {lang code ="authsocials.session.title" ucf=true}
                            </p>
                        </span>
                        <div style="padding-top:10px;">
                        {if $params->is_facebook}
                            <a href="javascript:RADSocials.socLogin('facebook');"><img src="{url module="core" file="des/socials/FaceBook_24x24.png" type="image" preset="original"}" border="0" align="middle"/> <span style="font-size:13px;">Facebook</span></a>
                            <br/>
                        {/if}
                        {if $params->is_twitter}                            
                            <a href="javascript:RADSocials.socLogin('twitter');"><img src="{url module="core" file="des/socials/Twitter_24x24.png" type="image" preset="original"}" border="0" align="middle"/> <span style="font-size:13px;">Twitter</span></a>
                        {/if}                            
                        </div>
                    {/if}
                </div>
        </form>
    </div>
</div>

{/strip}