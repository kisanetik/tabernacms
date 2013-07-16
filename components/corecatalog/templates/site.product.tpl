{if $action eq 'comment_add' or $action eq 'comments_get'}{strip}
    {include file="$_CURRENT_LOAD_PATH/site.product/comments.tpl" comment=$item->comments}
        <tr>
            <td colspan="2" class="paginator_items">
                {if $paginator} 
                    {foreach from=$paginator->getPages() item=page}
                        {if $page->isCurrentPage}
                            <b>
                        {else}
                            <a href="{url href="alias=product&p=`$item->cat_id`&tab=comments&page=`$page->pageNumber()`"}" onclick="javascript:product.comment.page('{$page->pageNumber()}'); return false">
                        {/if}
                        {$page->text()}
                        {if $page->isCurrentPage}
                            </b>
                        {else}
                            </a>
                        {/if}&nbsp;
                    {/foreach}
                {/if}
            </td>
        </tr>
{/strip}{elseif !empty($item->cat_id)}
<script type="text/javascript">
{* CONST URL'S FOR RAD_BIN FUNCTIONS *}
var URL_BINXML = '{url href="alias=binXML&action=addtobin"}';
var URL_REFRESHBIN = '{url href="alias=binMenuXML&action=refreshbin"}';
var URL_CHANGEBINCOUNT = '{url href="alias=binXML&action=changebincount"}';
var URL_DELFROMBIN = '{url href="alias=binXML&action=delfrombin"}';
var URL_ORDER = '{url href="alias=order.html"}';
var URL_ADDTOBIN = '{url href="alias=binXML&action=addtobin"}';
var URL_SHOWBINWINDOW = '{url href="alias=binMenuXML&action=showbinwindow"}';
{* COMMENTS *}
var URL_ADDCOMMENT = '{url href="alias=productXML&action=comment_add"}';
var URL_GETCOMMENTS = '{url href="alias=productXML&action=comments_get"}';
var URL_SHOWCAPTCHA = '{url href="alias=SYSXML&a=showCaptcha"}';
</script>
{url module="core" file="jquery/lightbox/jquery.lightbox-0.5.css" type="css"}
{url module="corecatalog" file="radcaptcha.js" type="js"}
{url module="core" file="jquery/lightbox/jquery.lightbox-0.5.pack.js" type="js"}
<script type="text/javascript">
var RAD_CATALOG_TRANSLATIONS = {
    'image': '{lang code="image.catalog.text" ucf=true}',
    'of':'{lang code="of.catalog.text" ucf=false}',
    'captcha':'{lang code="captchaIsRequired.catalog.text" ucf=false}',
    'comment':'{lang code="commentIsRequired.catalog.text" ucf=false}',
    'nickname':'{lang code="nicknameIsRequired.catalog.text" ucf=false}'
}
var premoderation = '{$premoderation}';

/* Initialize the product object. Pass product_id to it. */
var CAT_ID = {$item->cat_id};
var product;

$(function(){
    $('.3dbin-dialog').dialog({
        autoOpen: false,
        width: 600
    });
});

</script>
{strip}

{capture name="model3d" assign="model3d"}
    {if !empty($item->models_3d)}
        {foreach from=$item->models_3d item="model"}
            {if $model->img_main neq 0}
                <div style="clear: both"></div>
                <div class="image-3d-model" id="image-3d-model" style="margin-left: 15px">
                    <a href="#" onclick="product.image_3d_click();return false;">
                        <img src="{url module="core" file="des/3d-bin-icon.png" type="image"}">&nbsp;{lang code="3dview.catalog.link" ucf=true}
                    </a>
                </div>
                <div class="3dbin-dialog">
                    <div class="3ditem">
                        <object type="application/x-shockwave-flash" data="{const SITE_URL}dfiles/3dbin/{$model->img_filename}" width="530" height="400" id="intro_swf_example" style="visibility: visible; "></object>
                    </div>
                </div>
            {/if}
        {/foreach}
    {/if}
{/capture}

{if !empty($item->images_link)}
    {foreach from=$item->images_link item="img"}
        {if $img->img_main neq 0}
            <div class="pointer" style="float : left;">
                <img onclick="product.image_click()" src="{url module="corecatalog" file="`$img->img_filename`" type="image" preset="product_xlarge"}" class="goods_pic big" alt="{$item->cat_name|replace:'"':'&quot;'}" title="{$item->cat_name|replace:'"':'&quot;'}" alt="{$item->cat_name|replace:'"':'&quot;'}" />
                {$model3d}
            </div>
        {/if}
    {/foreach}  
{else} 
     <img src="{url module="core" file="des/no_image_available.png" type="image" preset="original"}"  width="155" height="300" />
{/if}

<div class="productpage">
    <h1>{$item->cat_name}</h1>
    {if !empty($item->cat_article)}
        <p class="goodscode">{lang code="article.catalog.text" ucf=true}: {$item->cat_article}</p>
    {/if}
    {if !empty($item->cat_code)}
        <p class="goodscode">{lang code="code.catalog.text" ucf=true}: {$item->cat_code}</p>
    {/if}
    <div class="servfon goodsprice">
        <div class="price1">{lang code="cost.catalog.text"}</div>
        <div class="price">{currency cost="`$item->cat_cost`" curid="`$item->cat_currency_id`"} {currency get="shortname"}</div>

        <input type="button"{if !$item->cat_availability} disabled="disabled"{/if} class="btnblue tx wt fright buyBtn" value="{lang code="buy.catalog.title"}" onclick="javascript:RADBIN.addToBin({$item->cat_id},this);">
    </div>
    {if !$item->cat_availability}
        <strong class="required">{lang code="noavilability.catalog.text"}</strong><br />
    {/if}
    <ul class="delivery">
        {lang code="delivery.catalog.text"}
    </ul>
    <ul class="delivery d2">
        {lang code="payment.catalog.text"}
    </ul>
    {if $comments_show}
        <a id="product_comments_count_link" href="{url href="alias=product&p=`$item->cat_id`&tab=comments"}" >
            <span class="comments_total">{$comments_total}</span> отзывов
        </a>
    {/if}
    <p class="description">{$item->cat_fulldesc}</p>
</div>
<div class="contlnk">
    <a href="{url href="alias=product&p=`$item->cat_id`&tab=spec"}" id="spec" class="lnkbt tx {if $tab eq 'spec' or $tab eq 1}wt{else}grbt{/if}" >{lang code="specifications.catalog.title"}</a>
    {if !empty($item->images_link) and count($item->images_link) > 1}
        <a href="{url href="alias=product&p=`$item->cat_id`&tab=photo"}" id="photo" class="lnkbt tx {if $tab eq 'photo' or $tab eq 2}wt{else}grbt{/if}" >{lang code="photo.catalog.title"} ({$item->images_link|@count})</a>
    {/if}
    {if $comments_show}<a href="{url href="alias=product&p=`$item->cat_id`&tab=comments"}" id="comments" class="lnkbt tx {if $tab eq 'comments' or $tab eq 3}wt{else}grbt{/if}" >{lang code="reviews.catalog.title"} (<span class="comments_total">{$comments_total}</span>)</a>{/if}
    {if !empty($item->download_files)}
        <a href="{url href="alias=product&p=`$item->cat_id`&tab=files"}" id="files" class="lnkbt tx {if $tab eq 'files' or $tab eq 4}wt{else}grbt{/if}" >{lang code="files.catalog.title" ucf=true}</a>
    {/if}
</div>
<div  class="contable">
    {capture name="valvalues"}
    {if count($item->type_vl_link)}
    <div class="tab {if $tab neq 'spec' and $tab neq 1}hide{/if}" id="tab_spec">
        <table class="specifications">
            <caption>{lang code="tech.charact.catalog.text"} {$item->cat_name}</caption>
            <col id="spec1" /><col id="spec2" />
            {foreach from=$item->type_vl_link item=item_l name="type_vl"}
                {if count($item_l->vv_values)}
                    {if !$smarty.foreach.type_vl.last}
                        <tr>
                            <td>
                                {$item_l->vl_name}
                            </td>
                            <td class="vl_value">
                                {foreach from=$item_l->vv_values item="vv" name="vv"}
                                    {if !empty($vv->vv_value)}
                                        {$vv->vv_value} {$item_l->ms_value}
                                        {if !$smarty.foreach.vv.last}<br />{/if}
                                    {/if}
                                {/foreach}
                            </td>
                        </tr>
                    {else}
                        <tr class="brdnn">
                            <td>
                                {$item_l->vl_name} 
                            </td>
                            <td class="vl_value">
                                {foreach from=$item_l->vv_values item="vv" name="vv"}
                                    {if !empty($vv->vv_value)}
                                        {$vv->vv_value} {$item_l->ms_value}
                                    {/if}
                                {/foreach}
                            </td>
                        </tr>
                    {/if}
                {/if}
            {/foreach}
        </table>
    </div>
    {/if}
    {/capture}
    {$smarty.capture.valvalues}
    {if !empty($item->images_link)}
        <div class="tab {if $tab neq 'photo' and $tab neq 2}hide{/if}" id="tab_photo">
            <h5>{lang code="photoreview.catalog.title"} {$item->cat_name}</h5>
            {foreach from=$item->images_link item="img"}
                <div class="contfoto">
                    <div class="vertcentr">
                        <a class="lightbox" title="{$item->cat_name|@htmlspecialchars}" href="{url module="corecatalog" file="`$img->img_filename`" type="image" preset="box_medium"}">
                            <img src="{url module="corecatalog" file="`$img->img_filename`" type="image" preset="product_thumb"}" title="{$item->cat_name|@htmlspecialchars}" alt="{$item->cat_name|replace:'"':'&quot;'}" />
                        </a>
                    </div>
                </div>
            {/foreach}
        </div>
    {/if}
{if $comments_show}
    <div class="tab comment {if $tab neq 'comments' and $tab neq 3}hide{/if}" id="tab_comments">
        <table>
            <caption>{lang code='reviews_about.product.text' ucf=true} {$item->cat_name}&nbsp;<span><span class="title_comments_counter">(<span class="comments_total">{$comments_total}</span>)</span></span>
            {if $allowComments}
                <input type="button" class="btnblue tx wt fright addComment" value="{lang code='add_responce.product.text' ucf=true}" onclick="product.comment.form_toggle()" />
            {/if}
            </caption>
            <col class="spec1" width="200" /><col class="spec2" />
            {if $allowComments}
            <tr class="last">
                <td class="brdnn" colspan="2">&nbsp;
                    <div id="comment_preloader" style="display: none">
                        <div class="background"></div>
                        <div class="canvas">
                            <img src="{url type="image" preset="original" module="core" file="mootree/mootree_loader.gif"}" width="16" height="16"/>
                        </div>
                    </div>
                    <div id="product_comment_form" style="display: none">
                        <h2>{lang code="add_responce.product.text" ucf=true}</h2>
                        <div class="caption">
                            {lang code="entercomment.resource.text" ucf=true}
                            <div class="required">*</div>:
                        </div>
                        <textarea id="product_comment_text" name="product_comment_text"></textarea>
                        {if empty($user->u_id)}
                            <div class="caption">
                                {lang code="enternickname.product.text" ucf=true}
                                <div class="required">*</div>:
                            </div>
                            <input type="text" class="user" id="product_comment_nickname" value="" />
                            <a href="javascript:void(0)" onclick="return RADCaptcha.renew('captcha_img', SITE_ALIAS)">
                                <img id="captcha_img" src="{url href='alias=SYSXML&a=showCaptcha&page=SITE_ALIAS'}" alt="{lang code="entercaptcha.session.text" ucf=true}" />
                                <br/>
                                {lang code="dontseechars.system.link" ucf=true}
                            </a>
                            <div class="caption">
                                {lang code="entercaptcha.session.text" ucf=true}
                                <div class="required">*</div>:
                            </div>
                            <input type="text" class="user" maxlengrh="8" id="product_comment_captcha" value="" />
                        {/if}
                        <input type="hidden" id="product_comment_hash" value="{$hash}" />&nbsp;
                        <input type="hidden" id="parent_id"  />&nbsp;
                        <input type="button" onclick="product.comment.add()" value="{lang code='-submit' ucf=true}" />&nbsp;
                    </div>
                </td>
            </tr>
            {/if}
        </table>
        <div class="specifications comment">
            {include file="$_CURRENT_LOAD_PATH/site.product/comments.tpl" comment=$item->comments}
            {if $paginator}{strip}<tr>
                <td colspan="2" class="paginator_items">
                    {foreach from=$paginator->getPages() item=page}
                        {if $page->isCurrentPage}
                            <b>
                        {else}
                            <a href="{url href="alias=product&p=`$item->cat_id`&tab=comments&page=`$page->pageNumber()`"}" onclick="javascript:product.comment.page('{$page->pageNumber()}'); return false">
                        {/if}
                        {$page->text()}
                        {if $page->isCurrentPage}
                            </b>
                        {else}
                            </a>
                        {/if}&nbsp;
                    {/foreach}
                </td>
            </tr>{/strip}{/if}
        </div>
    </div>
{/if}
{if !empty($item->download_files)}
    <div class="tab files {if $tab neq 'files' and $tab neq 3}hide{/if}" id="tab_files">
        <h5>{lang code="fileslist.catalog.title" ucf=true}</h5>
        <ul style="padding-left:25px;padding-top:10px;">
        {foreach from=$item->download_files item="file_item" name="download_files"}
            <li>
                <a href="{url file=$file_item}">{$file_item->rcf_name}</a>
            </li>
        {/foreach}
        </ul>
    </div>
{/if}
</div> 
{/strip}
{else}
    <center>{lang code="productnotexists.catalog.message" ucf=true}</center>
{/if}