{strip}
<script type="text/javascript" 
    src="{url href="alias=SITE_ALIASXML&action=getjs_detail"}{if isset($ref)}ref/{$ref}/{/if}"></script>
<script language="JavaScript" type="text/javascript" src="{const SITE_URL}jscss/fckeditor/fckeditor.js"></script>
<div class="w100">
    <div class="kord_right_col">
        <h1>{lang code='detailtree.menus.title' ucf=true}</h1>
<form enctype="multipart/form-data" id="detail_edit_form" method="post">        
<input type="hidden" name="returntorefferer" id="returntorefferer" value="0" />
<input type="hidden" name="tre_id" value="{$item->tre_id}" id="tre_id" />
<input type="hidden" name="hash" value="{$hash|default:''}" id="hash" />
<input type="hidden" name="sub_action" value="save" />
{if isset($ref)}
<input type="hidden" name="ref" value="{$ref}" />
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
                            <div class="block_header_title">{lang code='editdetail.menus.title' ucf=true}</div>
                        </td>
                        <td>
                            <div class="block_header_title" style="text-align: right;"><span class="red_color" id="detailTreeMessage"></span></div>
                        </td>
                    </tr>
                    </table>
                    
                    <div class="tb_line_ico">
                        <table class="item_ico">
                        <tr>
                            <td>
                            <a href="javascript:RADDTree.cancelClick();">
                                <img src="{const SITE_URL}img/backend/arrow_undo.png" alt="" width="33" height="33" border="0" class="img" alt="{lang code='-cancel'}" title="{lang code='-cancel'}" />
                                <span class="text">{lang code='-cancel'}</span>
                            </a>
                            </td>
                        </tr>
                        </table>
                        {if $action eq 'editProductForm'}
                        <table class="item_ico">
                        <tr>
                            <td>
                            <a href="javascript:RADDTree.deleteClick();">
                                <img src="{const SITE_URL}img/backend/icons/ico_delete.gif" alt="" width="33" height="33" border="0" class="img" alt="{lang code='-delete'}" title="{lang code='-delete'}" />
                                <span class="text">{lang code='-delete'}</span>
                            </a>
                            </td>
                        </tr>
                        </table>
                        {/if}
                        <table class="item_ico">
                        <tr>
                            <td>
                            <a href="javascript:RADDTree.applyClick();">
                                <img src="{const SITE_URL}img/backend/accept.png" alt="" width="33" height="33" border="0" class="img" alt="{lang code='-apply'}" title="{lang code='-apply'}" />
                                <span class="text">{lang code='-apply'}</span>
                            </a>
                            </td>
                        </tr>
                        </table>
                        <table class="item_ico">
                        <tr>
                            <td>
                            <a href="javascript:RADDTree.saveClick();">
                                <img src="{const SITE_URL}img/backend/disk.png" alt="" width="33" height="33" border="0" class="img" alt="{lang code='-save'}" title="{lang code='-save'}" />
                                <span class="text">{lang code='-save'}</span>
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
                                <td class="left_column">{lang code='treename.menus.text'}:</td>
                                <td><input type="text" maxlength="254" class="long_text" name="tre_name" id="tre_name" value="{$item->tre_name}" /></td>
                            </tr>
                            <tr>
                                <td class="left_column">{lang code='treeurl.menus.text'}:</td>
                                <td><input type="text" maxlength="254" class="long_text" name="tre_url" id="tre_url" value="{$item->tre_url}" /></td>
                            </tr>
                            <tr>
                                <td class="left_column">{lang code='treeposition.menus.text'}:</td>
                                <td><input type="text" maxlength="11" class="long_text" name="tre_position" id="tre_position" value="{$item->tre_position}" /></td>
                            </tr>
                            <tr>
                                <td class="left_column">{lang code='-access'}:</td>
                                <td><input type="text" maxlength="3" class="long_text" name="tre_access" id="tre_access" value="{$item->tre_access}" /></td>
                            </tr>
                            <tr>
                                <td class="left_column">{lang code='parent.menus.text'}:</td>
                                <td>
                                	<select id="tre_pid" name="tre_pid">
						                {if isset($parents) and count($parents)}
						                    {include file="$_CURRENT_LOAD_PATH/admin.managetree/tree_recursy.tpl" element=$parents selected=$item->tre_pid nbsp=0}
						                {/if}
						            </select>
								</td>
                            </tr>
							<tr>
								<td class="left_column">{lang code='-active'}</td>
								<td>
									<input type="radio" name="tre_active" id="treeactive_yes" value="1"{if $item->tre_active} checked="checked"{/if} /><label for="treeactive_yes">{lang code='-yes'}</label>
                                    <input type="radio" name="tre_active" id="treeactive_no" value="0"{if !$item->tre_active} checked="checked"{/if} /><label for="treeactive_no">{lang code='-no'}</label>
								</td>
							</tr>
                            </table>
                    </td>
                </tr>
            </table>
            
            <div class="inn_components_out">
            <div class="inn_components">
                <div class="vkladki" id="TabsPanel">
                    <!-- vkladka -->
                    <div class="vkladka activ" id="descriptionTab" onclick="RADTabs.change('descriptionTab');">
                        <div>
                            <div>
                                <div>{lang code='description.menus.title'}</div>
                            </div>
                        </div>
                    </div>
                    <div class="vkladka " id="imagesTab" onclick="RADTabs.change('imagesTab');">
                        <div>
                            <div>
                                <div>{lang code='images.menus.title'}</div>
                            </div>
                        </div>
                    </div>
                    <div class="vkladka " id="metatagsTab" onclick="RADTabs.change('metatagsTab');">
                        <div>
                            <div>
                                <div>{lang code='-metatags'}</div>
                            </div>
                        </div>
                    </div>
                    <div class="clear"></div>
                </div>
                <div class="und_vkladki">
                    <div class="wrap" id="TabsWrapper">
                        <div class="lf_col tabcenter" id="descriptionTab_tabcenter" style="margin:0;">
                            <div class="kord_lf_col">
                                <!-- group box -->
                                <div class="group_box margin_bottom">
                                    <span class="tit">{lang code='fullescription.menus.title'}</span>
                                    <div class="kord_cont" style="height:250px;">
                                        <textarea id="tre_fulldesc" name="tre_fulldesc" style="width:100%;height:100%;">{$item->tre_fulldesc}</textarea>
                                        <script language="JavaScript" type="text/javascript">
                                        addWEditor('tre_fulldesc');
                                        </script>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="lf_col tabcenter" id="imagesTab_tabcenter" style="display:none;">
                            <div class="kord_lf_col">
                                <div class="group_box margin_bottom">
                                    <span class="tit">{lang code='images.menus.title'}</span>
                                    <div class="kord_cont">
                                        <div id="tables_images">
                                        {if isset($params)}
										<table cellpadding="0" cellspacing="0" border="0" width="100%">
											    {if $params->showsectionimage}
		                                            {if strlen($item->tre_image)}
													<tr><td colspan="2">
													    <img src="{const SITE_URL}image.php?f={$item->tre_image}&m=menu&w={$params->detaileditmaxsize_x}&h={$params->detaileditmaxsize_y}" alt="{lang code='imagesection.menus.text'}" title="{lang code='imagesection.menus.text'}" border="0" />
														<input type="checkbox" name="del_img_section" id="del_img_section" /><label for="del_img_section">{lang code='delthisimage.menus.text'}</label>
													</td></tr>
													{/if}
													<tr>
														<td width="1%" nowrap="nowrap">{lang code='imagesection.menus.text'}</td>
														<td><input type="file" name="tre_image" id="tre_image"></td>
													</tr>
												{/if}
												{if $params->showmenuimage}
												    {if isset($item->tre_image_menu) and strlen($item->tre_image_menu)}
													<tr><td colspan="2">
													   <img src="{const SITE_URL}image.php?f={$item->tre_image_menu}&m=menu&w={$params->detaileditmaxsize_x}&h={$params->detaileditmaxsize_y}" alt="{lang code='imagemenu.menus.text'}" title="{lang code='imagemenu.menus.text'}" border="0" />
													   <input type="checkbox" name="del_img_menu" id="del_img_menu" /><label for="del_img_menu">{lang code='delthisimage.menus.text'}</label>
													</td></tr>
													{/if}
													<tr>
                                                        <td width="1%" nowrap="nowrap">{lang code='imagemenu.menus.text'}</td>
                                                        <td><input type="file" name="tre_menuimage" id="tre_image"></td>
                                                    </tr>
												{/if}
												{if $params->showmenuactivimage}
												    {if isset($item->tre_image_menu_a) and strlen($item->tre_image_menu_a)}
													<tr><td colspan="2">
                                                       <img src="{const SITE_URL}image.php?f={$item->tre_image_menu_a}&m=menu&w={$params->detaileditmaxsize_x}&h={$params->detaileditmaxsize_y}" alt="{lang code='imagemenu.menus.text'}" title="{lang code='imagemenu.menus.text'}" border="0" />
													   <input type="checkbox" name="del_img_menu_a" id="del_img_menu_a" /><label for="del_img_menu_a">{lang code='delthisimage.menus.text'}</label>
													</td></tr>
                                                    {/if}
                                                    <tr>
                                                        <td width="1%" nowrap="nowrap">{lang code='imagemenu.menus.text'}</td>
                                                        <td><input type="file" name="tre_menuimagea" id="tre_image"></td>
                                                    </tr>
												{/if}
											</table>
											{/if}
                                        </div>
                                    </div>
                                </div>
                                <div class="alert_upload">{lang code='-reference' ucf=true}: {lang code='uploadsize.catalog.title' ucf=true}  {if $max_post < 1024}<b>{$max_post}</b> B{elseif $max_post < 1024 * 1024}<b>{math equation="s / 1024" s=$max_post format="%.2f"}</b> KB{elseif $max_post < 1024 * 1024 * 1024}<b>{math equation="size / 1024 / 1024" size=$max_post format="%.2f"}</b> MB{else}<b>{math equation="size / 1024 / 1024 / 1024" size=$max_post format="%.2f"}</b> Gb{/if}!</div>
                            </div>
                        </div>
                        <div class="lf_col tabcenter" id="metatagsTab_tabcenter" style="display:none;">
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
                                                        <input type="text" name="tre_metakeywords" id="tre_metakeywords" value="{$item->tre_metakeywords}" style="width:95%;" />
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td nowrap="nowrap">
                                                        {lang code='-metatitle'}
                                                    </td>
                                                    <td align="left">
                                                        <input type="text" name="tre_metatitle" id="tre_metatitle" value="{$item->tre_metatitle}" style="width:95%;" />
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td nowrap="nowrap">
                                                        {lang code='-metadescription'}
                                                    </td>
                                                    <td align="left">
                                                        <input type="text" name="tre_metadesc" id="tre_metadesc" value="{$item->tre_metadesc}" style="width:95%;" />
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