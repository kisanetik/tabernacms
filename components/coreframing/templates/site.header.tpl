{strip}
<div class="search"></div>
<div class="cont">
    <a href="{const SITE_URL}">
        <img src="{url module="core" file="des/logo.jpg" type="image" preset="original"}" width="144" height="40" title="TABERNA" class="site_logo"/>
    </a>

    <p class="logo">{$params->title}</p>
    <ul class="uplist">
        <li class="topic">{lang code="feedback.others.title" ucf=true}</li>
        {if !empty($phones)}
            {foreach from=$phones item="phone" key="key_phone"}
                <li>{$phone}</li>
            {/foreach}
        {/if}
    </ul>
    {if !empty($showcallback)}
        <script type="text/javascript">
            var URL_SHOWCAPTCHA = '{url href="alias=SYSXML&a=showCaptcha"}';
        </script>
        <div style="clear: both"></div>
        <span class="top-callback d-popup-open" data-dpopup="feedback">
            <span>{lang code='callback.framing.text' ucf=true|replace:'"':'&quot;'}</span>
        </span>
        <div class="b-d-popup b-d-popup-container">
            <a class="b-d-popup-close"></a>
            <div class="b-d-popup-wrapper">
                <div class="b-d-popup-container">
                    <div class="b-d-popup-drag"></div>
                    <div class="b-d-popup-content">
                        <div class="b-d-popup-item b-d-popup-gallery" style="display: none;">
                            <div class="b-d-popup-gallery-head c-c1"></div>
                        </div>
                        <div class="b-d-popup-item popup-item-callback" data-dpopup="feedback" style="display: block;">
                            <div id="callback" style="display: block;">
                                <div class="b-quest-form" style="">
                                    <p class="call-header">{lang code="callbackformtitle.framing.text" ucf=true}</p>
                                    <div class="b-d-popup-head-desc">{lang code="callbackformsubtitle.framing.text" ucf=true}</div>
                                    <form id="quest_form" name="quest_form" action="{url href="alias=contactsXML&action=callback"}" method="post">
                                        <input type="hidden" name="hash" value="{$hash}" />
                                        <div class="fieldwrapper">
                                            <label>{lang code="entervalidphone.framing.text" ucf=true|replace:'"':'&quot;'}</label>
                                            <input type="text" name="phone" value="" class="i1 phone-number-mask">
                                        </div>
                                        <div class="fieldwrapper">
                                            <label>{lang code="entercorrectfio.framing.text" ucf=true|replace:'"':'&quot;'}</label>
                                            <input id="inp1" type="text" name="sender_fio" value="" class="i1 fio">
                                        </div>
                                        <div class="fieldwrapper clearfix">
                                            <label>{lang code="entercapcha.session.text" ucf=true|replace:'"':'&quot;'}</label>
                                            <input type="text" name="captcha_text" maxlength="50" value="" class="i1 captcha-input" autocomplete="off">
                                            <input type="hidden" name="captcha_sid" value="8b4ea7ef6f38b5a933653f5f2d6b901d">
                                            <a href="javascript:void(0)" onclick="return RADCaptcha.renew('captcha_img', 'index.html')" class="captcha">
                                                <img src="{url href="alias=SYSXML&a=showCaptcha&page=index.html"}" id="captcha_img" alt="{lang code="entercapcha.session.text" ucf=true}" border="0" />
                                                <br />
                                                {lang code="dontseechars.system.link" ucf=true}
                                            </a>
                                        </div>
                                        <div class="fieldwrapper" style="margin-bottom: 0;">
                                            <div class="feedback-errors">
                                                <div class="feedback-errors-content">{lang code="errorinput.framing.text" ucf=true}</div>
                                            </div>
                                        </div>
                                        <div class="buttonsdiv fieldwrapper">
                                            <input class="button-v2" type="submit" value="{lang code="ordercall.framing.text" ucf=true}">
                                            <input class="button-v6 b-d-popup-close" type="reset" value="{lang code="cancelcall.framing.text" ucf=true}">             </div>
                                    </form>
                                </div>
                                <div class="b-callback-complete" style="display: none;">
                                    <h3>{lang code="callbackSuccesssTitle.framing.text" ucf=true}</h3>
                                    <p>{lang code="callbackSuccesssMessage.framing.text" ucf=true}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {url module="core" file="jquery/bpopup/jquery.bpopup.min.js" type="js"}
        {url module="core" file="jquery/maskedinput/jquery.maskedinput.min.js" type="js"}
        {url module="core" file="des/product.js" type="js"}
        <script type="text/javascript">
            submitURL = '{url href="alias=contactsXML&action=callback"}';
        </script>
    {/if}
{/strip}