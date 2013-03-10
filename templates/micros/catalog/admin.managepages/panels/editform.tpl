{strip}
<script language="JavaScript" type="text/javascript" src="{const SITE_URL}jscss/fckeditor/fckeditor.js"></script>
<script language="JavaScript" type="text/javascript" src="{url href="alias=SITE_ALIASXML&action=getjs_editform"}"></script>
<div class="w100">
    <div class="kord_right_col">
        <h1>{lang code="managepages.catalog.title" ucf=true}</h1>
<form enctype="multipart/form-data" id="addedit_form" method="post">
<input type="hidden" name="returntorefferer" id="returntorefferer" value="0" />
<input type="hidden" name="hash" id="hash" value="{$hash|default:''}" />
{if isset($item) && $item->pg_id}
<input type="hidden" name="pg_id" value="{$item->pg_id}" />
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
                            <div class="block_header_title">{if isset($item) && $item->pg_id}{lang code='editpage.catalog.title' ucf=true}{else}{lang code='addpage.catalog.title' ucf=true}{/if}</div>
                        </td>
                        <td>
                            <div class="block_header_title" style="text-align: right;"><span class="red_color" id="addPagesMessage"></span></div>
                        </td>
                    </tr>
                    </table>

                    <div class="tb_line_ico">
                        <table class="item_ico">
                        <tr>
                            <td>
                            <a href="javascript:RADEditPages.cancelClick({$selected_category});">
                                <img src="{const SITE_URL}img/backend/arrow_undo.png" alt="" width="33" height="33" border="0" class="img" alt="{lang code="-cancel"}" title="{lang code="-cancel"}" />
                                <span class="text">{lang code="-cancel" ucf=true}</span>
                            </a>
                            </td>
                        </tr>
                        </table>
                        {if isset($item) && $item->pg_id}
                        <table class="item_ico">
                        <tr>
                            <td>
                            <a href="{url href="action=delpagenojs&nid=`$selected_category`&id=`$item->pg_id`&hash=`$hash`"}" onclick="return RADEditPages.deleteClick();">
                                <img src="{const SITE_URL}img/backend/icons/ico_delete.gif" alt="" width="33" height="33" border="0" class="img" alt="{lang code="-delete"}" title="{lang code="-delete"}" />
                                <span class="text">{lang code="-delete" ucf=true}</span>
                            </a>
                            </td>
                        </tr>
                        </table>
                        {/if}
                        <table class="item_ico">
                        <tr>
                            <td>
                            <a href="javascript:RADEditPages.applyClick();">
                                <img src="{const SITE_URL}img/backend/accept.png" alt="" width="33" height="33" border="0" class="img" alt="{lang code="-apply"}" title="{lang code="-apply"}" />
                                <span class="text">{lang code="-apply" ucf=true}</span>
                            </a>
                            </td>
                        </tr>
                        </table>
                        <table class="item_ico">
                        <tr>
                            <td>
                            <a href="javascript:RADEditPages.saveClick();">
                                <img src="{const SITE_URL}img/backend/disk.png" alt="" width="33" height="33" border="0" class="img" alt="{lang code="-save"}" title="{lang code="-save"}" />
                                <span class="text">{lang code="-save" ucf=true}</span>
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
                                <td class="left_column">{lang code='pagestitle.catalog.title' ucf=true}:</td>
                                <td><input type="text" class="long_text" name="pg_title" id="pg_title" value="{$item->pg_title|replace:'"':'&quot;'}" /></td>
                            </tr>
                            <tr>
                                <td class="left_column">{lang code='pagesname.catalog.title' ucf=true}:</td>
                                <td nowrap="nowrap"><input type="text" class="long_text" name="pg_name" id="pg_name" value="{$item->pg_name|replace:'"':'&quot;'}" style="width:215px;float:left;margin-right:3px;" /></td>
                            </tr>
                            {if $params->_get('have_tags',false)}
                            <tr>
                                <td class="left_column">
                                    {lang code="tags.catalog.title" ucf=true}:
                                </td>
                                <td>
                                    <input type="text" class="long_text" name="pagetags" value="{if !empty($item->tags)}{foreach from=$item->tags item=tag name=page_tags}{$tag->tag_string}{if !$smarty.foreach.page_tags.last},{/if}{/foreach}{/if}"/>
                                </td>
                            </tr>
                            {/if}
                            <tr>
                                <td class="left_column">{lang code='pagescategory.catalog.title' ucf=true}:</td>
                                <td>
                                    <select class="long_text" name="pg_tre_id" id="pg_tre_id">
                                        {include file="`$_CURRENT_LOAD_PATH`/../menus/admin.managetree/tree_recursy.tpl" element=$categories selected=$selected_category nbsp=0}
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td class="left_column">{lang code='-active' ucf=true}:</td>
                                <td><input type="checkbox" name="pg_active" id="pg_active"{if $item->pg_active} checked="checked"{/if} /></td>
                            </tr>
                            <tr>
                                <td class="left_column">{lang code='pagesshowinlist.catalog.title' ucf=true}:</td>
                                <td><input type="checkbox" name="pg_showlist" id="pg_showlist"{if $item->pg_showlist} checked="checked"{/if} /></td>
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
                                                                            <div class="name_info">{lang code='-infoblock' ucf=true}</div>
                                                                            <div>{lang code='pagesadded.catalog.text' ucf=true}: {$item->pg_datecreated}</div>
                                                                            <div>{lang code='pagesucreated.catalog.text' ucf=true}: {if isset($item->created_user)}{$item->created_user->u_login}{/if}</div>
                                                                            <div>{lang code='pagesupdated.catalog.text' ucf=true}: {$item->pg_dateupdated}</div>
                                                                            <div>{lang code='pagesshowed.catalog.text' ucf=true}: 0(featured)</div>
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
                                <div class="group_box margin_bottom" >
                                    <span class="tit">{lang code='shortdescription.catalog.title' ucf=true}</span>
                                    <div class="kord_cont" style="height:250px;">
                                        <textarea id="FCKeditorShortDescription" name="FCKeditorShortDescription" style="width:100%;height:100%;">{$item->pg_shortdesc}</textarea>
                                        {if !$params->_get('havenoshortdesc',false)}
                                        <script language="JavaScript" type="text/javascript">
                                        addWEditor('FCKeditorShortDescription');
                                        </script>
                                        {/if}
                                    </div>
                                </div>
                                <div class="group_box">
                                    <span class="tit">{lang code='fulldescription.catalog.title' ucf=true}</span>
                                    <div class="kord_cont" style="height: 400px;">
                                        <textarea id="FCKeditorFullDescription" name="FCKeditorFullDescription" style="width:100%;height:100%;">{$item->pg_fulldesc}</textarea>
                                        <script language="JavaScript" type="text/javascript">
                                        var oFCKeditor1 = new FCKeditor('FCKeditorFullDescription') ;
                                        oFCKeditor1.BasePath = SITE_URL + '/jscss/fckeditor/';
                                        oFCKeditor1.Config['SkinPath'] = SITE_URL + '/jscss/fckeditor/editor/skins/office2003/';
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
                                <!-- group box -->
                                <div class="group_box margin_bottom">
                                    <span class="tit">{lang code='pageimage.catalog.title' ucf=true}</span>
                                    <div class="kord_cont">
                                        <div id="tables_images">
                                            {if $item->pg_img}
                                            <div id="img_cat">
                                                <img src="{const SITE_URL}image.php?f={$item->pg_img}&w=100&h=100&m=pages" border="0" />&nbsp;
                                                <input type="checkbox" id="del_img_" name="del_img" /><label for="del_img_">{lang code="deletethisimage.catalog.text"}</label>&nbsp;
                                            </div>
                                            {/if}
                                            <div id="tabimage">
                                                  <input type="file" name="pages_image" id="pages_image" {if $params->showPreloadImages} onchange="RADCATImages.showPreloadImage(this);"{/if} />&nbsp;
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
                                                        <input type="text" name="pg_metakeywords" id="meta_keywords" value="{$item->pg_metakeywords}" style="width:95%;" />
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td nowrap="nowrap">
                                                        {lang code='-metatitle' ucf=true}
                                                    </td>
                                                    <td align="left">
                                                        <input type="text" name="pg_metatitle" id="meta_title" value="{$item->pg_metatitle}" style="width:95%;" />
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td nowrap="nowrap">
                                                        {lang code='-metadescription' ucf=true}
                                                    </td>
                                                    <td align="left">
                                                        <input type="text" name="pg_metadescription" id="meta_description" value="{$item->pg_metadescription}" style="width:95%;" />
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