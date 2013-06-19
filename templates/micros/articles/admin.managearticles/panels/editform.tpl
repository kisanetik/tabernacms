{strip}
{url type="js" file="alias=SITE_ALIASXML&action=getjs_editform"}
{*has options
   hasisweek
   hasshowonmain
   hasshortdesc
   hasshortdescfck
   hasfulldesc
   hasfulldescfck
   hasimage
   hasmetatags
*}
<div class="w100">
    <div class="kord_right_col">
        <h1>{lang code='manage.articles.title' ucf=true}</h1>
<form enctype="multipart/form-data" id="addedit_form" method="post">
<input type="hidden" name="returntorefferer" id="returntorefferer" value="0" />
<input type="hidden" name="hash" id="hash" value="{$hash|default:''}" />
{if isset($item) && $item->art_id}
    <input type="hidden" name="art_id" value="{$item->art_id}" />
    <input type="hidden" name="action_sub" id="action_sub" value="edit" />
{else}
    <input type="hidden" name="action_sub" id="action_sub" value="add" />
{if isset($selected_category) && $selected_category}<input type="hidden" name="selected_category" value="{$selected_category}" id="selected_category" />{/if}
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
                            <div class="block_header_title">{lang code='addedit.articles.title' ucf=true}</div>
                        </td>
                        <td>
                            <div class="block_header_title" style="text-align: right;"><span class="red_color" id="addArticlesMessage"></span></div>
                        </td>
                    </tr>
                    </table>

                    <div class="tb_line_ico">
                        <table class="item_ico">
                        <tr>
                            <td>
                            <a href="javascript:RADEditArticles.cancelClick({$selected_category});">
                                <img src="{const SITE_URL}img/backend/arrow_undo.png" alt="" width="33" height="33" border="0" class="img" alt="{lang code='-cancel'|replace:'"':'&quot;'}" title="{lang code='-cancel'|replace:'"':'&quot;'}" />
                                <span class="text">{lang code='-cancel' ucf=true}</span>
                            </a>
                            </td>
                        </tr>
                        </table>
                        {if isset($item) && $item->art_id}
                        <table class="item_ico">
                        <tr>
                            <td>
                            <a href="{url href="action=delarticlenojs&nid=`$selected_category`&id=`$item->art_id`&hash=`$hash`"}" onclick="return RADEditArticles.deleteClick();">
                                <img src="{const SITE_URL}img/backend/icons/ico_delete.gif" alt="" width="33" height="33" border="0" class="img" alt="{lang code='-delete'|replace:'"':'&quot;'}" title="{lang code='-delete'|replace:'"':'&quot;'}" />
                                <span class="text">{lang code='-delete' ucf=true}</span>
                            </a>
                            </td>
                        </tr>
                        </table>
                        {/if}
                        <table class="item_ico">
                        <tr>
                            <td>
                            <a href="javascript:RADEditArticles.applyClick();">
                                <img src="{const SITE_URL}img/backend/accept.png" alt="" width="33" height="33" border="0" class="img" alt="{lang code='-apply'|replace:'"':'&quot;'}" title="{lang code='-apply'|replace:'"':'&quot;'}" />
                                <span class="text">{lang code='-apply' ucf=true}</span>
                            </a>
                            </td>
                        </tr>
                        </table>
                        <table class="item_ico">
                        <tr>
                            <td>
                            <a href="javascript:RADEditArticles.saveClick();">
                                <img src="{const SITE_URL}img/backend/disk.png" alt="" width="33" height="33" border="0" class="img" alt="{lang code='-save'|replace:'"':'&quot;'}" title="{lang code='-save'|replace:'"':'&quot;'}" />
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
                                <td class="left_column">{lang code='title.articles.text' ucf=true}:</td>
                                <td><input type="text" class="long_text" name="art_title" id="art_title" value="{$item->art_title|replace:'"':'&quot;'}" /></td>
                            </tr>
                            {if $params->_get('have_tags',false)}
                            <tr>
                                <td class="left_column">
                                    {lang code="tags.articles.title" ucf=true}:
                                </td>
                                <td>
                                    <input type="text" class="long_text" name="articletags" value="{if !empty($item->tags)}{foreach from=$item->tags item=tag name=article_tags}{$tag->tag_string}{if !$smarty.foreach.article_tags.last},{/if}{/foreach}{/if}"/>
                                </td>
                            </tr>
                            {/if}
                            <tr>
                                <td class="left_column">{lang code='category.articles.text' ucf=true}:</td>
                                <td>
                                    <select class="long_text" name="art_treid" id="art_treid">
                                        {include file="`$_CURRENT_LOAD_PATH`/../menus/admin.managetree/tree_recursy.tpl" element=$categories selected=$selected_category nbsp=0}
                                    </select>
                                </td>
                            </tr>
                            {if $params->_get('hasisweek',false)}
                            <tr>
                                <td class="left_column">{lang code='isweek.articles.text' ucf=true}:</td>
                                <td><input type="checkbox" name="art_isweek" id="art_isweek"{if $item->art_isweek} checked="checked"{/if} /></td>
                            </tr>
                            {/if}
                            {if $params->_get('hasshowonmain',false)}
                            <tr>
                                <td class="left_column">{lang code='showonmain.articles.text' ucf=true}:</td>
                                <td><input type="checkbox" name="art_showonmain" id="art_showonmain"{if $item->art_showonmain} checked="checked"{/if} /></td>
                            </tr>
                            {/if}
                            <tr>
                                <td class="left_column">{lang code='-active' ucf=true}:</td>
                                <td><input type="checkbox" name="art_active" id="art_active"{if $item->art_active} checked="checked"{/if} /></td>
                            </tr>
                            </table>
                    </td>
                    <td width="99%">
                        <table class="tbl_w100_inn" style="margin-left:10px;">
                            <tr>
                                <td width="100%">
                                    <div class="kord_con_in_td">
                                        <div class="gr_cir_bl margin_bot_none">
                                            <div>
                                                <div>
                                                    <div>
                                                        <div>
                                                            <div>
                                                                <div>
                                                                    <div>
                                                                        <div class="main_cont">
                                                                            <div class="name_info">{lang code='-infoblock'}</div>
                                                                            <div>{lang code='added.articles.text' ucf=true}: {$item->art_datecreated}</div>
                                                                            <div>{lang code='ucreated.articles.text' ucf=true}: {if isset($item->created_user)}{$item->created_user->u_login}{/if}</div>
                                                                            <div>{lang code='updated.articles.text' ucf=true}: {$item->art_dateupdated}</div>
                                                                            <br><br><br>
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
                            </tr>
                        </table>

                    </td>
                </tr>
            </table>

            <div class="inn_components_out">
            <div class="inn_components">
                <div class="vkladki" id="TabsPanel">
                    {if $params->hasshortdesc or $params->hasfulldesc}
                    <div class="vkladka activ" id="descriptionTab" onclick="RADTabs.change('descriptionTab');">
                        <div>
                            <div>
                                <div>{lang code='description.articles.title' ucf=true}</div>
                            </div>
                        </div>
                    </div>
                    {/if}
                    {if $params->_get('hasimage',false)}
                    <div class="vkladka " id="imagesTab" onclick="RADTabs.change('imagesTab');">
                        <div>
                            <div>
                                <div>{lang code='image.articles.title' ucf=true}</div>
                            </div>
                        </div>
                    </div>
                    {/if}
                    {if $params->_get('hasmetatags',false)}
                    <div class="vkladka " id="metatagsTab" onclick="RADTabs.change('metatagsTab');">
                        <div>
                            <div>
                                <div>{lang code='-metatags'}</div>
                            </div>
                        </div>
                    </div>
                    {/if}
                    <div class="clear"></div>
                </div>
                <div class="und_vkladki">
                    <div class="wrap" id="TabsWrapper">
                        {if $params->_get('hasshortdesc',false) or $params->_get('hasfulldesc',false)}
                        <div class="lf_col tabcenter" id="descriptionTab_tabcenter" style="width:100%">
                            <div class="kord_lf_col">
                                {if $params->_get('hasshortdesc',false)}
                                <div class="group_box margin_bottom" >
                                    <span class="tit">{lang code='shortdescription.articles.title' ucf=true}</span>
                                    <div class="kord_cont">
                                        {wysiwyg name="FCKeditorShortDescription" value=$item->art_shortdesc style="width:100%;height:200px;" editor=$params->_get('hasshortdescfck',false) toolbar="mini"}
                                    </div>
                                </div>
                                {/if}
                                {if $params->_get('hasfulldesc',false)}
                                <div class="group_box">
                                    <span class="tit">{lang code='fulldescription.articles.title' ucf=true}</span>
                                    <div class="kord_cont">
	                                    {wysiwyg name="FCKeditorFullDescription" value=$item->art_fulldesc style="width:100%;height:400px;" editor=$params->_get('hasfulldescfck',false)}
                                    </div>
                                </div>
                                {/if}
                            </div>
                        </div>
                        {/if}
                        {if $params->_get('hasimage',false)}
                        <div class="lf_col tabcenter" id="imagesTab_tabcenter" style="{if $params->hasshortdesc or $params->hasfulldesc}display:none;{/if}width:100%;">
                            <div class="kord_lf_col">
                                <div class="group_box margin_bottom">
                                    <span class="tit">{lang code='image.articles.title' ucf=true}</span>
                                    <div class="kord_cont">
                                        <div id="tables_images">
                                            {if $item->art_img}
                                            <div id="img_cat">
                                                <img src="{const SITE_URL}image.php?f={$item->art_img}&w=100&h=100&m=articles" border="0" />
                                                <br />
                                                <label>
                                                    <input type="checkbox" id="del_img_" name="del_img" />&nbsp;
                                                    {lang code='-delete'}
                                                </label>
                                                <div style="width:100%;height:1px;border-bottom:1px solid #D9D9D9;"></div>
                                            </div>
                                            {/if}
                                            <div id="tabimage">
                                                  <input type="file" name="articles_image" id="articles_image" {if $params->showPreloadImages} onchange="RADCATImages.showPreloadImage(this);"{/if} />&nbsp;
                                                  <div id="tabimage_preview"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="alert_upload">{lang code='-reference' ucf=true}: {lang code='uploadsize.catalog.title' ucf=true}  {if $max_post < 1024}<b>{$max_post}</b> B{elseif $max_post < 1024 * 1024}<b>{math equation="s / 1024" s=$max_post format="%.2f"}</b> KB{elseif $max_post < 1024 * 1024 * 1024}<b>{math equation="size / 1024 / 1024" size=$max_post format="%.2f"}</b> MB{else}<b>{math equation="size / 1024 / 1024 / 1024" size=$max_post format="%.2f"}</b> Gb{/if}!</div>
                            </div>
                        </div>
                        {/if}
                        {if $params->_get('hasmetatags',false)}
                        <div class="lf_col tabcenter" id="metatagsTab_tabcenter" style="{if ($params->_get('hasshortdesc',false) or $params->_get('hasfulldesc',false)) or $params->_get('hasimage',false)}display:none;{/if}width:100%;">
                            <div class="kord_lf_col">
                                <div class="group_box margin_bottom">
                                    <span class="tit">{lang code='-metatags'}</span>
                                    <div class="kord_cont">
                                        <div>
                                            <table cellpadding="0" cellspacing="3" border="0">
                                                <tr>
                                                    <td width="10%" nowrap="nowrap">
                                                        {lang code='-metakeywords'}
                                                    </td>
                                                    <td width="90%" align="left">
                                                        <input type="text" name="art_metakeywords" id="meta_keywords" value="{$item->art_metakeywords}" style="width:95%;" />
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td nowrap="nowrap">
                                                        {lang code='-metatitle'}
                                                    </td>
                                                    <td align="left">
                                                        <input type="text" name="art_metatitle" id="meta_title" value="{$item->art_metatitle}" style="width:95%;" />
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td nowrap="nowrap">
                                                        {lang code='-metadescription'}
                                                    </td>
                                                    <td align="left">
                                                        <input type="text" name="art_metadescription" id="meta_description" value="{$item->art_metadescription}" style="width:95%;" />
                                                    </td>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        {/if}
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
    </div>
</div>
{/strip}