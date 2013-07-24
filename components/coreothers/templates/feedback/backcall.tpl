{strip} {* needs internationalization *}
<script language="JavaScript" type="text/javascript">
    var CALLBACK_POPUP_TITLE     = '{lang code="callbackform.callback.text" ucf=true}';
    var CALLBACK_POPUP_SUBTITLE = '{lang code="callbackform.callback.text" ucf=true}';
    var CALLBACK_POPUP_MESSAGE = '{lang code="callbackform.callback.text" ucf=true}';
    var CALLBACK_POPUP_DONE = '{lang code="callbackform.callback.text" ucf=true}';
    var FDO_ENTER_PHONE = "{lang code="entervalidphone.callback.error" ucf=true htmlchars=true}";
    var FDO_ENTER_FIO = "{lang code="entercorrectfio.callback.error" ucf=true htmlchars=true}";
    var FDO_ENTER_CAPTCHA = "{lang code="entercapcha.session.text" ucf=true htmlchars=true}";
    var REQUIRED_FIELD      = '{lang code="requiredfield.session.message" ucf=true}';
    var PHONE_INCORRECT     = '{lang code="emailincorrect.session.error" ucf=true}';
    var ORDER_CALL = '{lang code="ordercall.callback.text" ucf=true}';
    var CANCEL_CALL = '{lang code="cancelcall.callback.text" ucf=true}';
    var qo = {if (empty($qo))} false {else} true {/if};
    var URL_SHOWCAPTCHA = '{url href="alias=SYSXML&a=showCaptcha"}';
</script>
<div>
<span class="top-callback d-popup-open" data-dpopup="feedback">
    <span>"{lang code='callback.callback.text' ucf=true htmlchars=true}"</span>
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
                            <p class="call-header">{lang code="callbackform.callback.title" ucf=true}</p>
                            <div class="b-d-popup-head-desc">{lang code="callbackform.callback.subtitle" ucf=true}</div>
                            <div class="b-d-popup-head-desc-itemcard">{lang code="callbackform.callback.message" ucf=true}</div>
                            <form id="quest_form" name="quest_form" action="{url href="alias=contacts.htmlXML&action=send"}" method="post">
                                <input type="hidden" name="text" value="">
                                <div class="fieldwrapper">
                                    <label>{lang code="entervalidphone.callback.error" ucf=true htmlchars=true}</label>
                                    <input type="text" name="phone" value="" class="i1 phone-number-mask">
                                </div>
                                <div class="fieldwrapper">
                                    <label>{lang code="entercorrectfio.callback.error" ucf=true htmlchars=true}</label>
                                    <input id="inp1" type="text" name="name" value="" class="i1 fio">
                                </div>
                                <input type="hidden" name="text" value="" class="callback-text">
                                <div class="fieldwrapper clearfix">
                                    <label>{lang code="entercapcha.session.text" ucf=true htmlchars=true}</label>
                                    <input type="text" name="captcha_text" maxlength="50" value="" class="i1 captcha-input" autocomplete="off">
                                    <input type="hidden" name="captcha_sid" value="8b4ea7ef6f38b5a933653f5f2d6b901d">
                                    <a href="javascript:void(0)" onclick="return RADCaptcha.renew('captcha_img', SITE_ALIAS)">
                                        <img src="{url href="alias=SYSXML&a=showCaptcha&page=SITE_ALIAS"}" id="captcha_img" alt="{lang code="entercapcha.session.text" ucf=true}" border="0" />
                                        <br />
                                        {lang code="dontseechars.system.link" ucf=true}
                                    </a>
                                </div>
                                <div class="fieldwrapper" style="margin-bottom: 0;">
                                    <div class="feedback-errors">
                                        <div class="feedback-errors-content" style="display: none;">Пожалуйста, заполните все обязательные поля. </div>
                                    </div>
                                </div>
                                <div class="buttonsdiv fieldwrapper">
                                    <input class="button-v2" type="submit" value="{lang code="ordercall.callback.text" ucf=true}">
                                    <input class="button-v6 b-d-popup-close" type="reset" value="{lang code="cancelcall.callback.text" ucf=true}">             </div>
                            </form>
                        </div>
                </div>
                </div>
        </div>
    </div>
</div>
</div>
{/strip}
{url module="" file="jquery/bpopup/jquery.bpopup.min.js" type="js"}
{url module="" file="jquery/maskedinput/jquery.maskedinput.min.js" type="js"}
{url module="" file="jquery/caret/jquery.caret.js" type="js"}
{literal}
    <script type="text/javascript">
        $(function(){
            $('.d-popup-open').on('click', function(e){
                $('.b-d-popup').bPopup({
                    fadeSpeed: 'slow',
                    followSpeed: 1500,
                    positionStyle: 'absolute',
                    position: [300, 180],
                    modalClose: false,
                    closeClass: "b-d-popup-close",
                    onClose: function(){
                        $('.b-d-popup-container .fieldwrapper input[type="text"]').each(function(){
                            $(this).val('');
                        });
                    }

                });
            });
            $('.b-d-popup-container .phone-number-mask').mask("+7(999)999-99-99").caret('3');
            $('.b-d-popup-container #quest_form').submit(function(){

                var phone_regexp = new RegExp('^[+]7[(]\\d{3}[)]\\d{3}-\\d{2}-\\d{2}$');
                var is_errors = false;
                var $error_msg = $('.b-d-popup-container .feedback-errors-content');
                if (!phone_regexp.test($('.b-d-popup-container input.phone-number-mask').val()))
                    is_errors = true;
                if ($('.b-d-popup-container input.fio').val().length < 3)
                    is_errors = true;
                if (false) //captcha
                    is_errors = true;
                if (is_errors)
                    $error_msg.show();
                else
                    $error_msg.hide();
                return false;
            });
        });
    </script>
{/literal}



