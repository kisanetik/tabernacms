{strip}
<script type="text/javascript" src="{url href="alias=SITE_ALIASXML&action=getjs_editform"}"></script>
<script language="JavaScript" type="text/javascript" src="{const SITE_URL}jscss/fckeditor/fckeditor.js"></script>
<script language="JavaScript" type="text/javascript" src="{const SITE_URL}jscss/components/datepicker/datepicker.js"></script>
<link rel="stylesheet" type="text/css" href="{const SITE_URL}jscss/components/datepicker/datepicker.css" media="screen" />
<link rel="stylesheet" type="text/css" href="{const SITE_URL}jscss/components/datepicker/datepicker_vista.css" media="screen" />

<div class="w100">
    <div class="kord_right_col">
        <h1>{lang code='managenews.catalog.title' ucf=true}</h1>
<form enctype="multipart/form-data" id="addedit_form" method="post">
<input type="hidden" name="returntorefferer" id="returntorefferer" value="0" />
<input type="hidden" name="hash" id="hash" value="{$hash|default:''}" />
{if isset($item) && $item->nw_id}
<input type="hidden" name="nw_id" value="{$item->nw_id}" />
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
                            <div class="block_header_title">{if isset($item) && $item->nw_id}{lang code='editnews.catalog.tittle' ucf=true}{else}{lang code='addnews.catalog.tittle' ucf=true}{/if}</div>
                        </td>
                        <td>
                            <div class="block_header_title" style="text-align: right;"><span class="red_color" id="addNewsMessage"></span></div>
                        </td>
                    </tr>
                    </table>

                    <div class="tb_line_ico">
                        <table class="item_ico">
                        <tr>
                            <td>
                            <a href="javascript:RADEditNews.cancelClick({$selected_category});">
                                <img src="{const SITE_URL}img/backend/arrow_undo.png" alt="" width="33" height="33" border="0" class="img" alt="{lang code='-cancel'}" title="{lang code='-cancel'}" />
                                <span class="text">{lang code='-cancel' ucf=true}</span>
                            </a>
                            </td>
                        </tr>
                        </table>
                        {if isset($item) && $item->nw_id}
                        <table class="item_ico">
                        <tr>
                            <td>
                            <a href="javascript:;">
                            <a href="{url href="action=delnewsnojs&nid=`$selected_category`&id=`$item->nw_id`&hash=`$hash`"}" onclick="return RADEditNews.deleteClick();">
                                <img src="{const SITE_URL}img/backend/icons/ico_delete.gif" alt="" width="33" height="33" border="0" class="img" alt="{lang code='-delete'}" title="{lang code='-delete'}" />
                                <span class="text">{lang code='-delete' ucf=true}</span>
                            </a>
                            </td>
                        </tr>
                        </table>
                        {/if}
                        <table class="item_ico">
                        <tr>
                            <td>
                            <a href="javascript:RADEditNews.applyClick();">
                                <img src="{const SITE_URL}img/backend/accept.png" alt="" width="33" height="33" border="0" class="img" alt="{lang code='-apply'}" title="{lang code='-apply'}" />
                                <span class="text">{lang code='-apply' ucf=true}</span>
                            </a>
                            </td>
                        </tr>
                        </table>
                        <table class="item_ico">
                        <tr>
                            <td>
                            <a href="javascript:RADEditNews.saveClick();">
                                <img src="{const SITE_URL}img/backend/disk.png" alt="" width="33" height="33" border="0" class="img" alt="{lang code='-save'}" title="{lang code='-save'}" />
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
                                <td class="left_column">{lang code='newstitle.catalog.title' ucf=true}:</td>
                                <td><input type="text" class="long_text" name="nw_title" id="nw_title" value="{$item->nw_title|replace:'"':'&quot;'} " /></td>
                            </tr>
                            <tr>
                                <td class="left_column">{lang code='newsdate.catalog.title' ucf=true}:</td>
                                <td nowrap="nowrap">
                                    <input type="text" class="date demo_vista" name="nw_datenews" id="nw_datenews" value="{$item->nw_datenews|date:"datecal"}" style="float:left;margin-right:3px;" />
                                    {if $params->_get('ishavetime')}
                                    &nbsp;<input name="news_time" id="news_time" value="{$item->nw_datenews|date:"time"}" style="width:40px;" />
                                    {/if}
                                </td>
                            </tr>
                            {if $params->_get('ishaveperiods',false)}
                            <tr>
                                <td class="left_column">{lang code='newshowfrom.catalog.text'}:</td>
                                <td nowrap="nowrap">
                                    <table cellpadding="0" cellspacing="0" border="0" width="100%">
                                    <td width="5%">{lang code='shownewsfrom.catalog.text'}</td><td width="5%"><input type="text" class="date demo_vista" name="nw_datenews_from" id="nw_datenews_from" value="{$item->nw_datenews_from|date:"datecal"}" style="float:left;margin-right:3px;" /></td><td width="5%">{lang code='shownewsto.catalog.text'}</td><td width="5%"><input type="text" class="date demo_vista" name="nw_datenews_to" id="nw_datenews_to" value="{$item->nw_datenews_to|date:"datecal"}" style="float:left;margin-right:3px;" /></td><td>&nbsp;</td>
                                    </table>
                                </td>
                            </tr>
                            {/if}
                            {if $params->_get('have_tags',false)}
                            <tr>
                                <td class="left_column">
                                    {lang code="tags.catalog.title" ucf=true}:
                                </td>
                                <td>
                                    <input type="text" class="long_text" name="newstags" value="{if !empty($item->tags)}{foreach from=$item->tags item=tag name=item_tags}{$tag->tag_string}{if !$smarty.foreach.item_tags.last},{/if}{/foreach}{/if}"/>
                                </td>
                            </tr>
                            {/if}
                            {if $params->_get('hassubcats',false)}
                            <tr>
                                <td class="left_column">{lang code='newscategory.catalog.text'}:</td>
                                <td>
                                    <select class="long_text" name="nw_tre_id" id="nw_tre_id">
                                        {include file="`$_CURRENT_LOAD_PATH`/../menus/admin.managetree/tree_recursy.tpl" element=$categories selected=$selected_category nbsp=0}
                                    </select>
                                </td>
                            </tr>
                            {else}
                            <input type="hidden" name="nw_tre_id" value="{$selected_category}" />
                            {/if}
                            {if $params->_get('hassource',false)}
                            <tr>
                                <td class="left_column">{lang code='newssourceurl.catalog.text'}:</td>
                                <td>
                                    <input type="text" class="long_text" name="nw_source_url" value="{$item->nw_source_url}" />
                                </td>
                            </tr>
                            <tr>
                                <td class="left_column">{lang code='newssourcetext.catalog.text'}:</td>
                                <td>
                                    <input type="text" class="long_text" maxlength="100" name="nw_source_text" value="{$item->nw_source_text}" />
                                </td>
                            </tr>
                            {/if}
                            {if $params->_get('hasismain',false)}
                            <tr>
                                <td class="left_column">{lang code='newsismain.catalog.text' ucf=true}:</td>
                                <td><input type="checkbox" name="nw_ismain" id="nw_ismain"{if $item->nw_ismain} checked="checked"{/if} /></td>
                            </tr>
                            {/if}
                            {if $params->_get('hassubscribes',false)}
                            <tr>
                                <td class="left_column">{lang code='newssubscribe.catalog.text'}:</td>
                                <td><input type="checkbox" name="nw_subscribe" id="nw_subscribe"{if $item->nw_subscribe} checked="checked"{/if} /></td>
                            </tr>
                            {/if}
                            <tr>
                                <td class="left_column">{lang code='-active' ucf=true}:</td>
                                <td><input type="checkbox" name="nw_active" id="nw_active"{if $item->nw_active} checked="checked"{/if} /></td>
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
                                                                            <div>{lang code='newsadded.catalog.text' ucf=true}: {$item->nw_datecreated}</div>
                                                                            <div>{lang code='newsupdated.catalog.text' ucf=true}: {$item->nw_dateupdated}</div>
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
                    <div class="vkladka activ" id="descriptionTab" onclick="RADTabs.change('descriptionTab');">
                        <div>
                            <div>
                                <div>{lang code='description.catalog.title' ucf=true}</div>
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
                        <div class="lf_col tabcenter" id="descriptionTab_tabcenter" style="width:100%">
                            <div class="kord_lf_col">
                                <!-- group box -->
                                <div class="group_box margin_bottom" >
                                    <span class="tit">{lang code='shortdescription.catalog.title' ucf=true}</span>
                                    <div class="kord_cont" style="height:250px;">
                                        <textarea id="FCKeditorShortDescription" name="FCKeditorShortDescription" style="width:100%;height:100%;">{$item->nw_shortdesc}</textarea>
                                        <script language="JavaScript" type="text/javascript">
                                        {if $params->_get('hasshortdescrFCK')}
                                        addWEditor('FCKeditorShortDescription');
                                        {/if}
                                        </script>
                                    </div>
                                </div>
                                <div class="group_box">
                                    <span class="tit">{lang code='fulldescription.catalog.title' ucf=true}</span>
                                    <div class="kord_cont" style="height: 400px;">
                                        <textarea id="FCKeditorFullDescription" name="FCKeditorFullDescription" style="width:100%;height:100%;">{$item->nw_fulldesc}</textarea>
                                        <script language="JavaScript" type="text/javascript">
                                        var oFCKeditor1 = new FCKeditor('FCKeditorFullDescription') ;
                                        oFCKeditor1.BasePath = '/jscss/fckeditor/';
                                        oFCKeditor1.Config['SkinPath'] = '/jscss/fckeditor/editor/skins/office2003/';
                                        oFCKeditor1.Height = '100%' ;
                                        oFCKeditor1.Width = '100%' ;
                                        oFCKeditor1.ToolbarSet = 'RAD';
                                        oFCKeditor1.ReplaceTextarea() ;
                                        </script>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="lf_col tabcenter" id="imagesTab_tabcenter" style="display:none;width:100%;">
                            <div class="kord_lf_col">
                                <div class="group_box margin_bottom">
                                    <span class="tit">{lang code='image.catalog.title' ucf=true}</span>
                                    <div class="kord_cont">
                                        <div id="tables_images">
                                            {if $item->nw_img}
                                            <div id="img_cat">
                                                <img src="{const SITE_URL}image.php?f={$item->nw_img}&w=100&h=100&m=news" border="0" />
                                                <br />
                                                <label>
                                                    <input type="checkbox" id="del_img_" name="del_img" value="{$item->nw_id}" />&nbsp;
                                                    {lang code='deletethisimage.catalog.text' ucf=true}
                                                </label>
                                                <div style="width:100%;height:1px;border-bottom:1px solid #D9D9D9;"></div>
                                            </div>
                                            {/if}
                                            <div id="tabimage">
                                                  <input type="file" name="news_image" id="news_image" {if $params->showPreloadImages} onchange="RADCATImages.showPreloadImage(this);"{/if} />&nbsp;
                                                  <div id="tabimage_preview"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="alert_upload">{lang code='-reference' ucf=true}: {lang code='uploadsize.catalog.title' ucf=true}  {if $max_post < 1024}<b>{$max_post}</b> B{elseif $max_post < 1024 * 1024}<b>{math equation="s / 1024" s=$max_post format="%.2f"}</b> KB{elseif $max_post < 1024 * 1024 * 1024}<b>{math equation="size / 1024 / 1024" size=$max_post format="%.2f"}</b> MB{else}<b>{math equation="size / 1024 / 1024 / 1024" size=$max_post format="%.2f"}</b> Gb{/if}!</div>
                            </div>
                        </div>
                        <div class="lf_col tabcenter" id="metatagsTab_tabcenter" style="display:none;width:100%;">
                            <div class="kord_lf_col">
                                <div class="group_box margin_bottom">
                                    <span class="tit">{lang code='-metatags' ucf=true}</span>
                                    <div class="kord_cont">
                                        <div>
                                            <table cellpadding="0" cellspacing="3" border="0">
                                                <tr>
                                                    <td width="10%" nowrap="nowrap">
                                                        {lang code='-metakeywords' ucf=true}
                                                    </td>
                                                    <td width="90%" align="left">
                                                        <input type="text" name="nw_metakeywords" id="meta_keywords" value="{$item->nw_metakeywords}" style="width:95%;" />
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td nowrap="nowrap">
                                                        {lang code='-metatitle' ucf=true}
                                                    </td>
                                                    <td align="left">
                                                        <input type="text" name="nw_metatitle" id="meta_title" value="{$item->nw_metatitle}" style="width:95%;" />
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td nowrap="nowrap">
                                                        {lang code='-metadescription' ucf=true}
                                                    </td>
                                                    <td align="left">
                                                        <input type="text" name="nw_metadescription" id="meta_description" value="{$item->nw_metadescription}" style="width:95%;" />
                                                    </td>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
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
    </div>
</div>
{/strip}