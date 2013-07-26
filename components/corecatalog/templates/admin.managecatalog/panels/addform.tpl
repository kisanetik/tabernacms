{strip}
{url href="alias=SITE_ALIASXML&action=getjs_product" type="js"}
<div class="w100">
    <div class="kord_right_col">
        <h1>{lang code='addeditproduct.catalog.title' ucf=true}</h1>

<form enctype="multipart/form-data" id="addedit_form" method="post">
<input type="hidden" name="returntorefferer" id="returntorefferer" value="0" />
{if $action eq 'addProductForm'}
<input type="hidden" id="action_sub" name="action_sub" value="add" />
{else}
<input type="hidden" name="action_sub" id="action_sub" value="edit" />
<input type="hidden" name="cat_id" value="{$cat_id}" id="cat_id" />
{/if}

<div style="margin: 20px 0px 0px 0px;">
    <table cellpadding="0" cellspacing="0" border="0" class="tb_cont_block" style="height: auto; width: 99%;">
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
                            <div class="block_header_title">{if $action eq 'addProductForm'}{lang code='addproduct.catalog.title' ucf=true}{else}{lang code='editproduct.catalog.title' ucf=true}{/if}</div>
                        </td>
                        <td>
                            <div class="block_header_title" style="text-align: right;"><span class="red_color" id="addeditproductMessage"></span></div>
                        </td>
                    </tr>
                    </table>
                    {if isset($errors)}
                        <div style="float:left;color:red;">{foreach from=$errors item=error}{$error}<br />{/foreach}</div>
                    {/if}
                    <div class="tb_line_ico">
                        <table class="item_ico">
                        <tr>
                            <td>
                            <a href="javascript:RADAddEditProduct.cancelClick();">
                                <img src="{url type="image" module="core" preset="original" file="backend/arrow_undo.png"}" width="33" height="33" border="0" class="img" alt="{lang code='-cancel' ucf=true htmlchars=true}" title="{lang code='-cancel' htmlchars=true}" />
                                <span class="text">{lang code='-cancel' ucf=true}</span>
                            </a>
                            </td>
                        </tr>
                        </table>
                        {if ($cat_id)}
                            {if $action eq 'editProductForm' OR $action eq 'editform'}
                            <table class="item_ico">
                            <tr>
                                <td>
                                <a href="{url href="action=deleteproductnojs&cat_id=`$cat_id`&hash=`$hash`"}" onclick="return RADAddEditProduct.deleteClick(this)">
                                    <img src="{url type="image" module="core" preset="original" file="backend/icons/ico_delete.gif"}" width="33" height="33" border="0" class="img" alt="{lang code="-delete" ucf=true htmlchars=true}" />
                                    <span class="text">{lang code="-delete" ucf=true}</span>
                                </a>
                                </td>
                            </tr>
                            </table>
                            {/if}
                        {/if}
                        <table class="item_ico">
                            <tr>
                                <td>
                                <a href="javascript:RADAddEditProduct.applyClick();">
                                    <img src="{url type="image" module="core" preset="original" file="backend/accept.png"}" width="33" height="33" border="0" class="img" alt="{lang code='-apply' htmlchars=true}" title="{lang code='-apply' htmlchars=true}" />
                                    <span class="text">{lang code='-apply' ucf=true}</span>
                                </a>
                                </td>
                            </tr>
                        </table>
                        <table class="item_ico">
                            <tr>
                                <td>
                                <a href="javascript:RADAddEditProduct.saveClick();">
                                    <img src="{url type="image" module="core" preset="original" file="backend/disk.png"}" width="33" height="33" border="0" class="img" alt="{lang code='-save' ucf=true htmlchars=true}" title="{lang code='-save' htmlchars=true}" />
                                    <span class="text">{lang code='-save' ucf=true}</span>
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
        <td>
            <table class="tbl_w100">
                <tr>
                    <td nowrap="nowrap">
                        <table cellpadding="0" cellspacing="0" border="0" class="tb_add">
                            <tr>
                                <td class="left_column">{lang code='productname.catalog.title' ucf=true}:</td>
                                <td><input type="text" class="long_text" name="productname" id="productname" value="{$product->cat_name|replace:'"':'&quot;'}" x-webkit-speech="" speech="" onwebkitspeechchange="return void(0);" /></td>
                            </tr>
                            <tr>
                                <td class="left_column">{lang code='productarticle.catalog.title' ucf=true}:</td>
                                <td><input type="text" class="long_text" name="productarticle" id="productarticle" value="{$product->cat_article}" /></td>
                            </tr>
                            <tr>
                                <td class="left_column">{lang code='productcode.catalog.title' ucf=true}:</td>
                                <td><input type="text" class="long_text" name="productcode" id="productcode" value="{$product->cat_code}" /></td>
                            </tr>
                            {if $cleanurl_enabled}
                            <tr>
                                <td class="left_column">{lang code='cleanurl.catalog.text'}</td>
                                <td><input type="text" name="url_alias" id="url_alias" value="{if isset($url_alias)}{$url_alias}{/if}" /></td>
                            </tr>
                            {/if}
                            <tr>
                                <td class="left_column">{lang code='productposition.catalog.title' ucf=true}:</td>
                                <td><input type="text" class="long_text" name="productposition" id="productposition" value="{if $product->cat_position}{$product->cat_position}{else}100{/if}" /></td>
                            </tr>
                            {if $have_tags}
                            <tr>
                                <td class="left_column">
                                    {lang code="tags.catalog.title" ucf=true}:
                                </td>
                                <td>
                                    <input type="text" class="long_text" name="producttags" value="{if isset($product->tags.error)}{$product->tags.req}{else}{if !empty($product->tags)}{foreach from=$product->tags item=tag name=product_tags}{$tag->tag_string}{if !$smarty.foreach.product_tags.last},{/if}{/foreach}{/if}{/if}"/>
                                </td>
                            </tr>
                            {/if}
                            {if $have_brands}
                            <tr>
                                <td class="left_column">{lang code='productbrand.catalog.title' ucf=true}:</td>
                                <td>
                                    <select class="centered" name="cat_brand_id" style="width:100%">
                                       <option value="0" {if $action eq 'addProductForm'}selected="selected"{/if}>Нет</option>
                                        {if isset($brands) and count($brands)}
                                            {foreach from=$brands item=brand}
                                            <option value="{$brand.rcb_id}" {if $brand.rcb_id eq $product->cat_brand_id}selected="selected"{/if}>
                                                {$brand.rcb_name}
                                            </option>
                                            {/foreach}
                                        {/if}
                                    </select>
                                </td>
                            </tr>
                            {/if}
                            <tr>
                                <td class="left_column">{lang code='-active' ucf=true}:</td>
                                <td><input type="checkbox" name="productactive" id="productactive"{if $action eq 'editform'}{if $product->cat_active} checked="checked"{/if}{else}{if $params->DefaultActive} checked="checked"{/if}{/if} /></td>
                            </tr>
                        </table>
                    </td>
                    <td width="99%">
                        <table class="tbl_w100_inn" style="margin-left:10px;">
                            <tr>
                                <td width="25%" align="left">
                                    <div class="cord_con_in_td">
                                        <div class="gr_cir_bl margin_bot_none">
                                            <div>
                                                <div>
                                                    <div>
                                                        <div>
                                                            <div>
                                                                <div>
                                                                    <div>
                                                                        <div class="main_cont">
                                                                            <div class="name_info">{lang code='productnodes.catalog.text' ucf=true}</div>
                                                                            {include file="$_CURRENT_LOAD_PATH/admin.managecatalog/panels/multiselect.tree.tpl"}
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td width="75%">
                                    <div class="kord_con_in_td">
                                        <div class="gr_cir_bl margin_bot_none">
                                            <div>
                                                <div>
                                                    <div>
                                                        <div>
                                                            <div>
                                                                <div>
                                                                    <div>
                                                                        {if $action neq 'addProductForm'}
                                                                        <div class="main_cont">
                                                                            <div class="name_info">{lang code='-infoblock' ucf=true}</div>
                                                                            <div>{lang code='productadded.catalog.text' ucf=true}: {$product->cat_datecreated}</div>
                                                                            <div>{lang code='productupdated.catalog.text' ucf=true}: {$product->cat_dateupdated}</div>
                                                                            <br><br><br>
                                                                        </div>
                                                                        {/if}
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        </table>

                    </td>
                </tr>
            </table>

            <div class="inn_components_out">
            <div class="inn_components">
                <div class="vkladki" id="TabsPanel">
                    <div class="vkladka activ" id="descriptionTab" onclick="RADTabs.change('descriptionTab');">
                        <div>
                            <div>
                                <div>{lang code='description.catalog.title' ucf=true}</div>
                            </div>
                        </div>
                    </div>
                    <div class="vkladka " id="propertiesTab" onclick="RADTabs.change('propertiesTab');">
                        <div>
                            <div>
                                <div>{lang code='properties.catalog.title' ucf=true}</div>
                            </div>
                        </div>
                    </div>
                    <div class="vkladka " id="imagesTab" onclick="RADTabs.change('imagesTab');">
                        <div>
                            <div>
                                <div>{lang code='images.catalog.title' ucf=true}</div>
                            </div>
                        </div>
                    </div>
                    {if $action neq 'addProductForm'}
                    <div class="vkladka " id="3dimagesTab" onclick="RADTabs.change('3dimagesTab');">
                        <div>
                            <div>
                                <div>{lang code='3dimages.catalog.title' ucf=true}</div>
                            </div>
                        </div>
                    </div>
                    {/if}
                    {if $have_downloads}
                    <div class="vkladka " id="downloadsTab" onclick="RADTabs.change('downloadsTab');">
                        <div>
                            <div>
                                <div>{lang code='downloads.catalog.title' ucf=true}</div>
                            </div>
                        </div>
                    </div>
                    {/if}
                    <div class="vkladka " id="metatagsTab" onclick="RADTabs.change('metatagsTab');">
                        <div>
                            <div>
                                <div>{lang code='-metatags' ucf=true}</div>
                            </div>
                        </div>
                    </div>
                    <div class="clear"></div>
                </div>
                <div class="und_vkladki">
                    <div class="wrap" id="TabsWrapper">
                        <div class="lf_col tabcenter" id="descriptionTab_tabcenter">
                            <div class="kord_lf_col">
                                <div class="group_box margin_bottom">
                                    <span class="tit">{lang code='shortdescription.catalog.title' ucf=true}</span>
                                    <div class="kord_cont">
                                        {wysiwyg name="FCKeditorShortDescription" value=$product->cat_shortdesc style="width:100%;height:200px;" toolbar="mini"}
                                    </div>
                                </div>
                                <div class="group_box">
                                    <span class="tit">{lang code='fulldescription.catalog.title' ucf=true}</span>
                                    <div class="kord_cont">
                                        {wysiwyg name="FCKeditorFullDescription" value=$product->cat_fulldesc style="width:100%;height:280px;"}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="lf_col tabcenter" id="propertiesTab_tabcenter" style="display:none;">
                            <div class="kord_lf_col">
                                <div class="group_box margin_bottom">
                                    <span class="tit">{lang code='typefields.catalog.title' ucf=true}</span>
                                    <div class="kord_cont">
                                        <div id="charachters">
                                        <table width="100%" cellpadding="0" cellspacing="3" border="0">
                                            <tr>
                                                <td width="15%">{lang code='typeproduct.catalog.text' ucf=true}</td>
                                                <td>
                                                    <select class="centered" name="typeproduct" id="typeproduct" onchange="RADAddEditProduct.changeType(this, {$product->cat_ct_id|default:0});">
                                                        {if !empty($producttypes)}
                                                            {include file="$_CURRENT_LOAD_PATH/admin.managecatalog/panels/tree_edit_recursy.tpl" elements=$producttypes nbsp_count=0 noselected=1}
                                                        {/if}
                                                        {if $product->cat_ct_id}
                                                        <script type="text/javascript">
                                                            PRODUCT_CT_ID = {$product->cat_ct_id};
                                                            {literal}
                                                            window.onload = function(){
                                                                selectSel($('typeproduct'),PRODUCT_CT_ID);
                                                                RADAddEditProduct.loadTypes($('typeproduct'));
                                                            }
                                                            {/literal}
                                                        </script>
                                                        {else}
                                                            <script type="text/javascript">
                                                            {literal}
                                                            window.onload = function(){
                                                                RADAddEditProduct.loadTypes($('typeproduct'));
                                                            }
                                                            {/literal}
                                                            </script>
                                                        {/if}
                                                    </select>
                                                </td>
                                            </tr>
                                        </table>
                                        </div>
                                        <div id="typesDiv">

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="lf_col tabcenter" id="imagesTab_tabcenter" style="display:none;">
                            <div class="kord_lf_col">
                                <div class="group_box margin_bottom">
                                    <span class="tit">{lang code='images.catalog.title' ucf=true}</span>
                                    <div class="kord_cont">
                                        <div id="tables_images">
                                            {assign var="checked_def_img" value="0"}
                                            {if count($product->images_link)}
                                                {foreach from=$product->images_link item=img_item}
                                                <div id="img_cat_{$img_item->img_id}">
                                                    <img src="{url module="corecatalog" file="`$img_item->img_filename`" type="image" preset="product_thumb"}" border="0" style="max-width:100%;" />&nbsp;
                                                    <br />
                                                    <label>
                                                        <input type="checkbox" id="del_img_{$img_item->img_id}" name="del_img[{$img_item->img_id}]" onchange="RADCATImages.findAndSetNextDefault({$img_item->img_id});" />&nbsp;
                                                        {lang code='deletethisimage.catalog.text' ucf=true}
                                                    </label>
                                                    <br />
                                                    <input type="radio" value="id_{$img_item->img_id}" id="default_image__ex_{$img_item->img_id}" name="default_image"{if $img_item->img_main} checked="checked"{assign var="checked_def_img" value="1"}{/if} /><label for="default_image_ex_{$img_item->img_id}">{lang code='defaultimage.catalog.text' ucf=true}</label>&nbsp;
                                                    <div style="width:100%;height:1px;border-bottom:1px solid #D9D9D9;"></div>
                                                </div>
                                                {/foreach}
                                            {/if}
                                            <div id="tabimage_0">
                                                  <input type="file" name="product_image[0]" id="preload_image_0" value=""{if $params->showPreloadImages} onchange="RADCATImages.showPreloadImage(this);"{/if} />&nbsp;
                                                  <input type="radio" value="0" id="default_image_0" name="default_image" {if $checked_def_img eq "0"}checked="checked"{/if} /><label for="default_image_0">{lang code='defaultimage.catalog.text' ucf=true}</label>&nbsp;
                                                  <a href="javascript:RADCATImages.deleteImage(0)">{lang code='deleteimage.catalog.link' ucf=true}</a>
                                                  <div id="tabimage_0_preview"></div>
                                            </div>
                                        </div>
                                        <a href="javascript:RADCATImages.addNewImage();">{lang code='addnewimage.catalog.link' ucf=true}</a>
                                        <br/><br/>
                                        {lang code='addnewimagebyurl.catalog.text' ucf=true}
                                        <br/>
                                        <input type="text" name="product_image_url" id="product_image_url" value="" style="width:75%;" placeholder="{lang code='enterurl.catalog.text' ucf=true}">
                                        &nbsp;&nbsp;
                                        <input type="button" value="{lang code='-load' ucf=true}" id="load_img" onclick="RADAddEditProduct.remoteImgPreview();" />
                                        <br/>
                                        <div id="remoteImgError" style="color:red; display:none;"></div>
                                        <br/>
                                        <div id="remote_imgages_preview"></div>
                                    </div>
                                </div>
                                <div class="alert_upload">{lang code='uploadsize.catalog.title' ucf=true}  {if $max_post < 1024}<b>{$max_post}</b> B{elseif ($max_post<1024*1024)}<b>{math equation="s / 1024" s=$max_post format="%.2f"}</b> KB{elseif $max_post < 1024 * 1024 * 1024}<b>{math equation="size / 1024 / 1024" size=$max_post format="%.2f"}</b> MB{else}<b>{math equation="size / 1024 / 1024 / 1024" size=$max_post format="%.2f"}</b> Gb{/if}!</div>
                            </div>
                        </div>
                        {if $action neq 'addProductForm'}
                        <div class="lf_col tabcenter" id="3dimagesTab_tabcenter" style="display:none;">
                            <div class="kord_lf_col">
                                <div class="group_box margin_bottom">
                                    <span class="tit">{lang code='3dimages.catalog.title' ucf=true}</span>
                                    <div class="kord_cont">
                                        {config get="partners.3dbin.license" assign="license_3dbin"}
                                        <script type="text/javascript">RADCATImages.treeLicense = {$license_3dbin|@intval};</script>
                                        <div id="authorize_3dbin">
                                            {lang code="authorize.taberna.html" ucf=true}
                                        </div>
                                        <div id="license_3dbin"style="display:none;">
                                            {lang code="readandacceptlicense.system.text" ucf=true}<br />
                                            <a href="#" onclick="return tabernalogin.readLicense('3dbin');">{lang code="license.catalog.link" ucf=true}</a>
                                        </div>
                                        <div id="tables_3dimages"{if !$license_3dbin} style="display:none;{/if}">
                                            <div id="load_3d_bar" style="position:absolute;z-index:1000;width:100%;height:100%;background:white;display:none;">
                                                <div style="position:absolute;left:45%;top:40%;">
                                                    <strong id="load_3d_text">{lang code="-loading" ucf=true}</strong><div id="load_3d_percent"></div><br />
                                                    <img id="load_3d_pb" src="{url type="image" preset="original" module="core" file="fileuploader/loader.gif"}" style="width:150px;"/>
                                                </div>
                                            </div>
                                            {url module="core" file="fileuploader/image_uploader.css" type="css"}
                                            {url module="core" file="fileuploader/moouploader.js" type="js"}
                                            {include file="$_CURRENT_LOAD_PATH/admin.managecatalog/panels/image_uploader.tpl"}
                                            <div id="advanced3dbinSlide">
                                                {lang code="productname.catalog.title"}&nbsp;<input type="text" id="tdParams_name" value="{$product->cat_name|replace:'"':'&quot;'}" /><br />
                                                {lang code="bigmaxsize_x.catalog.option" ucf=true}&nbsp;<input type="text" id="tdParams_width" value="{config get="partners.3dbin.width"}" style="width:150px;" /><br />
                                                {lang code="bigmaxsize_y.catalog.option" ucf=true}&nbsp;<input type="text" id="tdParams_height" value="{config get="partners.3dbin.height"}" style="width:150px;" /><br />
                                                {lang code="image3dlogo.catalog.title" ucf=true}&nbsp;<input type="text" id="tdParams_logo" value="{config get="partners.3dbin.logo"}" style="width:150px;" /><br />
                                                <label>
                                                    <input type="checkbox" id="tdParams_is360view" checked="checked" />&nbsp;
                                                    {lang code="is360view.catalog.text" ucf=true}
                                                </label>
                                                <br />
                                                <label>
                                                    <input type="checkbox" checked="checked" id="tdParams_autoalign" />&nbsp;
                                                    {lang code="autoalign.catalog.text" ucf=true}
                                                </lbael>
                                                <br />
                                                <label>
                                                    <input type="checkbox" checked="checked" id="tdParams_сrop" />&nbsp;
                                                    {lang code="сrop.catalog.text" ucf=true}
                                                </label>
                                            </div>
                                            <input type="button" id="submit3dButton" value="{lang code="-submit" ucf=true}" /><br />
                                            <a href="#" id="advanced_3dbin">{lang code="advanced.catalog.link" ucf=true}</a>
                                        </div>
                                        <div id="3dimages_done" style="position:relative;">
                                            {include file="$_CURRENT_LOAD_PATH/admin.managecatalog/panels/3dimages.tpl"}
                                        </div>
                                    </div>
                                </div>
                                <div class="alert_upload">
                                    <br />
                                    {lang code='uploadsizeeach.catalog.title' ucf=true}  {if $max_post < 1024}<b>{$max_post}</b> B{elseif ($max_post<1024*1024)}<b>{math equation="s / 1024" s=$max_post format="%.2f"}</b> KB{elseif $max_post < 1024 * 1024 * 1024}<b>{math equation="size / 1024 / 1024" size=$max_post format="%.2f"}</b> MB{else}<b>{math equation="size / 1024 / 1024 / 1024" size=$max_post format="%.2f"}</b> Gb{/if}!
                                </div>
                            </div>
                        </div>
                        {/if}
                        {if $have_downloads}
                        <div class="lf_col tabcenter" id="downloadsTab_tabcenter" style="display:none;">
                            <div class="kord_lf_col">
                                <div class="group_box margin_bottom">
                                    <span class="tit">{lang code='downloads.catalog.title' ucf=true}</span>
                                    <div class="kord_cont">
                                        <div id="tables_files">
                                            {assign var="checked_def_img" value="0"}
                                            {if !empty($product->download_files)}
                                                <ul>
                                                    {foreach from=$product->download_files item="file_item"}
                                                        <li>
                                                            <div id="file_cat_{$file_item->rfl_id}">
                                                                <a href="{url file=$file_item}">{$file_item->rcf_name}</a>
                                                                &nbsp;
                                                                <input type="checkbox" id="del_file_{$file_item->rcf_id}" name="del_file[{$file_item->rcf_id}]" /><label for="del_file_{$file_item->rcf_id}">{lang code='deletefile.catalog.link' ucf=true}</label>
                                                            </div>
                                                        </li>
                                                    {/foreach}
                                                <ul>
                                            {/if}
                                            <div id="tabfile_0">
                                                  <input type="file" name="product_file[0]" id="preload_file_0" value="" />&nbsp;
                                                  <a href="javascript:RADCATFiles.deleteFile(0)">{lang code='deletefile.catalog.link' ucf=true}</a>
                                            </div>
                                        </div>
                                        <a href="javascript:RADCATFiles.addNew();">{lang code='addnewfile.catalog.link' ucf=true}</a>
                                    </div>
                                </div>
                                <div class="alert_upload">{lang code='uploadsize.catalog.title' ucf=true}  {if $max_post < 1024}<b>{$max_post}</b> B{elseif $max_post < 1024 * 1024}<b>{math equation="s / 1024" s=$max_post format="%.2f"}</b> KB{elseif $max_post < 1024 * 1024 * 1024}<b>{math equation="size / 1024 / 1024" size=$max_post format="%.2f"}</b> MB{else}<b>{math equation="size / 1024 / 1024 / 1024" size=$max_post format="%.2f"}</b> Gb{/if}!</div>
                            </div>
                        </div>
                        {/if}
                        <div class="lf_col tabcenter" id="metatagsTab_tabcenter" style="display:none;">
                            <div class="kord_lf_col">
                                <div class="group_box margin_bottom">
                                    <span class="tit">{lang code='-metatags' ucf=true}</span>
                                    <div class="kord_cont">
                                        <div id="metaDiv">
                                            <table cellpadding="0" cellspacing="3" border="0" width="100%">
                                                <tr>
                                                    <td width="15%" nowrap="nowrap">
                                                        {lang code='-metakeywords'}
                                                    </td>
                                                    <td width="85%" align="left">
                                                        <input type="text" name="meta_keywords" id="meta_keywords" value="{$product->cat_keywords}" style="width:95%;" />
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td nowrap="nowrap">
                                                        {lang code='-metatitle'}
                                                    </td>
                                                    <td align="left">
                                                        <input type="text" name="meta_title" id="meta_title" value="{$product->cat_metatitle}" style="width:95%;" />
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td nowrap="nowrap">
                                                        {lang code='-metadescription'}
                                                    </td>
                                                    <td align="left">
                                                        <input type="text" name="meta_description" id="meta_description" value="{$product->cat_metatescription}" style="width:95%;" />
                                                    </td>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="rt_col">
                        <div class="kord_rt_col">
                            <div class="gr_cir_bl" style="width:235px;">
                                <div>
                                    <div>
                                        <div>
                                            <div>
                                                <div>
                                                    <div>
                                                        <div>
                                                            <div class="main_cont">
                                                                <div class="title_bl">
                                                                    <div class="wrap">
                                                                        <div class="name_block">{lang code='magazine.catalog.title' ucf=true}</div>
                                                                    </div>
                                                                    <div class="href">
                                                                        {literal}
                                                                        <div class="open_arr" onclick="if($('cont_visible').style.display!='none'){$('cont_visible').style.display='none';}else{$('cont_visible').style.display='block';}"></div>
                                                                        {/literal}
                                                                    </div>
                                                                    <div class="clear"></div>
                                                                </div>
                                                                <div id="cont_visible" class="cont visible">
                                                                    <div class="line_razd"></div>
                                                                    <table class="tbl_frm_opt">
                                                                    <tr>
                                                                        <td class="lf">{lang code='cost.catalog.text' ucf=true}:</td>
                                                                        <td class="rt">
                                                                            <input type="text" name="cost" id="cost" value="{$product->cat_cost|default:0}" style="width:50px;" />
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td class="lf" nowrap="nowrap">{lang code='buycost.catalog.text' ucf=true}:</td>
                                                                        <td class="rt">
                                                                            <input type="text" name="cat_buy_cost" id="cat_buy_cost" value="{$product->cat_buy_cost|default:0}" style="width:50px;" />
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td class="lf">
                                                                            {lang code='availability.catalog.text' ucf=true}:
                                                                        </td>
                                                                        <td class="rt">
                                                                            <input type="checkbox" class="checkbox" name="cat_availability" id="cat_availability"{if ($params->DefaultAvalibility and $action ne 'editform') or ($action eq 'editform' and $product->cat_availability) } checked="checked"{/if} /><label for="cat_availability">{lang code='-yes'}</label>
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td class="lf">
                                                                            {lang code='currencyonename.catalog.text' ucf=true}:
                                                                        </td>
                                                                        <td class="rt">
                                                                            <select name="currency_name">
                                                                                {foreach from=$currencys item=currency}
                                                                                <option value="{$currency->cur_id}"{if ($currency->cur_default_admin and $action ne 'editform') or ($action eq 'editform' and $currency->cur_id eq $product->cat_currency_id) } selected="selected" {/if}>{$currency->cur_name}</option>
                                                                                {/foreach}
                                                                            </select>
                                                                        </td>
                                                                    </tr>
                                                                    </table>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {if $have_spnews or $have_sp or $have_spoffer or $have_sphit}
                            <div class="gr_cir_bl" style="width:235px;">
                                <div>
                                    <div>
                                        <div>
                                            <div>
                                                <div>
                                                    <div>
                                                        <div>
                                                            <div class="main_cont">
                                                                <div class="title_bl">
                                                                    <div class="wrap">
                                                                        <div class="name_block">{lang code='special_offers.catalog.title' ucf=true}</div>
                                                                    </div>
                                                                    <div class="href">
                                                                        {literal}
                                                                        <div class="open_arr" onclick="if($('cont_visible_sp').style.display!='none'){$('cont_visible_sp').style.display='none';}else{$('cont_visible_sp').style.display='block';}"></div>
                                                                        {/literal}
                                                                    </div>
                                                                    <div class="clear"></div>
                                                                </div>
                                                                <div id="cont_visible_sp" class="cont visible">
                                                                    <div class="line_razd"></div>
                                                                    <table class="tbl_frm_opt">
                                                                    {if $have_spnews}
                                                                    <tr>
                                                                        <td class="lf">{lang code='productnew.catalog.text'}:</td>
                                                                        <td class="rt">
                                                                            <input type="checkbox" name="productnew" id="productnew"{if $product->cat_special_spnews} checked="checked"{/if} />
                                                                        </td>
                                                                    </tr>
                                                                    {/if}
                                                                    {if $have_sp}
                                                                    <tr>
                                                                        <td class="lf">{lang code='productsp.catalog.text'}:</td>
                                                                        <td class="rt">
                                                                            <input type="checkbox" name="productsp" id="productsp"{if $product->cat_special_sp} checked="checked"{/if} />
                                                                        </td>
                                                                    </tr>
                                                                    {/if}
                                                                    {if $have_spoffer}
                                                                    <tr>
                                                                        <td class="lf">{lang code='productspoffer.catalog.text'}:</td>
                                                                        <td class="rt">
                                                                            <input type="checkbox" name="productspoffer" id="productspoffer"{if $product->cat_special_spoffer} checked="checked"{/if} />
                                                                        </td>
                                                                    </tr>
                                                                    {/if}
                                                                    {if $have_sphit}
                                                                    <tr>
                                                                        <td class="lf">{lang code='productsphit.catalog.text'}:</td>
                                                                        <td class="rt">
                                                                            <input type="checkbox" name="productsphit" id="productsphit"{if $product->cat_special_sphit} checked="checked"{/if} />
                                                                        </td>
                                                                    </tr>
                                                                    {/if}
                                                                    </table>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            {/if}

                        </div>
                    </div>
                    <div class="clear"></div>
                </div>

            </div>
            </div>
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

</form>
    {include file="$_CURRENT_LOAD_PATH/admin.managecatalog/panels/widget.tpl"}
    </div>
</div>
{/strip}