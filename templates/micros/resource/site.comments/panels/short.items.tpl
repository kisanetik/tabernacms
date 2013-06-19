{strip}
{url type="js" file="jscss/components/radcomments.js"}
{wysiwyg}
<div class="commentsWrapper">
    <div id="comments_loader">
        <img src="{const SITE_URL}jscss/components/mootree/mootree_loader.gif" alt="{lang code="-loading" ucf=true}" title="{lang code="-loading" ucf=true}" border="0" />
    </div>
    <div id="commentsItems">
        {include file="$_CURRENT_LOAD_PATH/site.comments/panels/items.tpl"}
    </div>
</div>
{if !$onlyregistered or !empty($user->u_id)}
    <form id="f_addComment" onSumbit="return false;">
        <div class="news" id="formComment">
            <div class="newsfon" style="width:100%;"></div>
            <h4>{lang code="addcomment.resource.title" ucf=true}</h4>
            <div class="comments">
                <textarea id="text_comments" style="width:98%;height:100px;"></textarea>
            </div>
            {if empty($user->u_id)}
<script language="JavaScript" type="text/javascript">
var FDO_ENTER_CAPTCHA = "{lang code="entercapcha.session.text" ucf=true|replace:'"':'&quot;'}";
var REQUIRED_FIELD      = '{lang code="requiredfield.session.message" ucf=true}';
var qo = {if (empty($qo))} false {else} true {/if};
var URL_SHOWCAPTCHA = '{url href="alias=SYSXML&a=showCaptcha"}';
var COMMENTS_ISEMPTY = '{lang code="commentisempty.resource.error"}';
</script>
                <p class="input_symbols">
                    {lang code="entercapcha.session.text" ucf=true}
                    <span class="red_text">*</span>
                </p>
                <div class="capcha_pic">
                    <input id="captcha_text" class="user smll" type="text" style="width:148px;" maxlength="8" />
                    <a href="javascript:void(0);" onclick="return RADCaptcha.renew('captcha_img', SITE_ALIAS);">
                        <img id="captcha_img" border="0" src="{url href="alias=SYSXML&a=showCaptcha&page=SITE_ALIAS"}" alt="{lang code="entercapcha.session.text" ucf=true}" />
                        <br />
                        {lang code="dontseechars.system.link" ucf=true}
                    </a>
                </div>
                <input class="btnorge  treb wt order feedbackbt" type="submit" value="{lang code="-submit" ucf=true}" />
            {else}
                <div style="text-align:center;width:100%;">
                    <input class="btnblue ltgrbt tx blc subsbt" type="submit" value="{lang code="-submit" ucf=true}" />
                </div>
            {/if}
        </div>
    </form>
    <script type="text/javascript">
        var ADD_COMMENT_URL = '{url href="alias=commentsXML&comments_action=a&fromSA=SITE_ALIAS"}';
        var HASH = '{$hash}';
        var ITEM_ID = '{$item_id}';
        var ITEM_TYPE = '{$typ}';
        {literal}
            $(function() {tcomments.init_short(ITEM_ID, ITEM_TYPE);});
        {/literal}
    </script>
{/if}
{/strip}