{strip}
<script type="text/javascript">
    var SITE_URL    = '{const SITE_URL}';
    var STR_SAVE    = '{lang code="-save" ucf=true}';
    var STR_DELETE  = '{lang code="-delete" ucf=true}';
    var STR_LOAGING = '{lang code="-loading" ucf=true}';
    var STR_NODATA  = '{lang code="norecords.system.text" ucf=true}';
    var STR_SELECT  = '{lang code="selectlanguage.system.text" ucf=true}';
    var TITLE_ADD_LANG = '{lang code="addlang.system.title" ucf=true}';
    var TITLE_EDIT_LANG = '{lang code="editlang.system.title" ucf=true}';

    var POST_LANG_URL = '{url href="alias=SYSmanageLangsXML"}';
</script>
{url type="js" module="core" file="radlang.js"}
<h1 id="manageLanguagesTitle">{lang code='managelang.lang.title' ucf=true}</h1>
<h4><span class="red_color">
Компонент работает в тестовом режиме, пока можнотолько изменять значения языковых кодов. 
По предложениям и замечаниям просьба обращаться на форум или писать по 
адресу {jsencode}<a href="mailto:webmaster@tabernacms.com">webmaster@tabernacms.com</a>{/jsencode}
</span>
</h4>
<table class="tb_two_column" style="height:auto;width:100%;">
    <tr>
        <td>
            <table class="tb_cont_block" style="width:410px;height:auto;" >
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
                                <table style="width: 100%">
                                <tr>
                                    <td>
                                        <div class="block_header_title">{lang code='tree.lang.title' ucf=true}</div>
                                    </td>
                                    <td>
                                        <div class="block_header_title" style="text-align: right;color:red;"><div class="red_color" id="LangTreeMessage"></div></div>
                                    </td>
                                </tr>
                                </table>
                                <div class="tb_line_ico">
                                    <table class="item_ico">
                                        <tr>
                                            <td>
                                                <a href="javascript:RADLanguagesPanel.deleteLanguage();">
                                                    <img src="{url module="core" preset="original" type="image" file="backend/cross.png"}" width="30" height="30" border="0" alt="{lang code='-delete'}" title="{lang code='-delete'}" />
                                                    <span class="text" style="width:50px;">{lang code='-delete'}</span>
                                                </a>
                                            </td>
                                        </tr>
                                    </table>
                                    <table class="item_ico">
                                        <tr>
                                             <td>
                                                <a href="javascript:RADLangPropertiesPanel.editLanguage();">
                                                    <img src="{url module="core" preset="original" type="image" file="backend/pencil.png"}" width="30" height="30" border="0" alt="{lang code='-edit'}" title="{lang code='-edit'}" />
                                                    <span class="text" style="width:50px;">{lang code='-edit'}</span>
                                                </a>
                                            </td>
                                        </tr>
                                    </table>
                                    <table class="item_ico">
                                        <tr>
                                            <td>
                                                <a href="javascript:RADLangPropertiesPanel.addLanguage();">
                                                    <img src="{url module="core" preset="original" type="image" file="backend/add.png"}" width="30" height="30" border="0" alt="{lang code='-add'}" title="{lang code='-add'}" />
                                                    <span class="text" style="width:50px;">{lang code='-add'}</span>
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
                    <td align="left" id="lang_tree" class="tree" onclick="RADLanguagesPanel.deselect()">
                        {foreach from=$languages item="language"}
                        <div class="element" onclick="RADLanguagesPanel.select(this, event)">
                            <div class="flag">
                                <img src="{url module="core" file="lang/`$language->lng_img`" type="image" preset="language"}" border="0"/>
                            </div>
                            <div class="title">{$language->lng_name}</div>
                            <div class="parameters">
                                <div class="lng_id">{$language->lng_id}</div>
                                <div class="lng_name">{$language->lng_name}</div>
                                <div class="lng_code">{$language->lng_code}</div>
                                <div class="lng_active">{$language->lng_active}</div>
                                <div class="lng_position">{$language->lng_position}</div>
                                <div class="lng_img">{$language->lng_img}</div>
                                <div class="lng_mainsite">{$language->lng_mainsite}</div>
                                <div class="lng_mainadmin">{$language->lng_mainadmin}</div>
                                <div class="lng_maincontent">{$language->lng_maincontent}</div>
                            </div>
                            <div class="default"{if $language->lng_active neq 1} style="display:none"{/if}></div>
                        </div>
                        {/foreach}
                        <div class="clear"></div>
                    </td>
                    <td class="right_border"></td>
                </tr>
                <tr>
                    <td class="left_border"></td>
                    <td class="gray_line">
                        <div class="statusbar">
                            <div class="element">{lang code='langtranslations.core.title' ucf=true}: <span class="language"></span></div>
                            <div class="element">{lang code='setlanguages.core.title' ucf=true}: <span class="translations">{$languages|count}</span></div>
                            <div class="clear"></div>
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
        </td>
        <td align="left" style="width:100%;">
            <table class="tb_cont_block" style="height:auto;width:600px;display:none;" id="editCatTreeBlock">
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
                                <table style="width: 100%">
                                    <tr>
                                        <td>
                                            <div class="block_header_title">{lang code='editlanguage.system.title' ucf=true}</div>
                                        </td>
                                        <td>
                                            <div class="block_header_title" style="text-align: right;"><span class="red_color" id="langInfoMessage"></span></div>
                                        </td>
                                    </tr>
                                </table>
                                <div class="tb_line_ico">
                                    <table class="item_ico">
                                        <tr>
                                            <td>
                                                <a href="javascript:RADLangPropertiesPanel.cancelLanguage();">
                                                    <img class="img" src="{url module="core" preset="original" type="image" file="backend/arrow_undo.png"}" width="30" height="30" border="0" alt="{lang code='-cancel'}" title="{lang code='-cancel'}" />
                                                    <span class="text" style="width:50px;">{lang code='-cancel'}</span>
                                                </a>
                                            </td>
                                        </tr>
                                    </table>
                                    <table class="item_ico">
                                        <tr>
                                            <td>
                                                <a href="javascript:RADLangPropertiesPanel.saveLanguage();">
                                                    <img src="{url module="core" preset="original" type="image" file="backend/disk.png"}" width="30" height="30" border="0" alt="{lang code='-save'}" title="{lang code='-save'}" />
                                                    <span class="text" style="width:50px;">{lang code='-save'}</span>
                                                </a>
                                            </td>
                                        </tr>
                                    </table>
                                    <table class="item_ico" id="language_properties_apply_button">
                                        <tr>
                                            <td>
                                                <a href="javascript:RADLangPropertiesPanel.applyLanguage();">
                                                    <img src="{url module="core" preset="original" type="image" file="backend/accept.png"}" width="30" height="30" border="0" alt="{lang code='-apply'}" title="{lang code='-apply'}" />
                                                    <span class="text" style="width:50px;">{lang code='-apply'}</span>
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
                    <td align="left" id="editLangNode"></td>
                    <td class="right_border"></td>
                </tr>
                <tr>
                    <td class="left_border"></td>
                    <td class="gray_line"></td>
                    <td class="right_border"></td>
                </tr>
                <tr>
                    <td class="corner_lb"></td>
                    <td class="tb_bottom" style="border: 1px solid #ccc;height: 223px; text-align: center; vertical-align: middle;">
                        <img id="language_details_preloader" src="{url type="image" module="core" preset="original" file="mootree/mootree_loader.gif"}" width="18" height="18" style="display:none" />
                        <div id="language_details_pane">
                        <form method="POST" id="language_details_form">
                            <table style="width:100%">
                                <tr>
                                    <td width="50%"><b><label for="lang_lang">{lang code="langtranslations.core.title" ucf=true}:</label></b></td>
                                    <td width="5%">&nbsp;</td>
                                    <td width="20%"><b><label for="lang_code">{lang code="code.mailtemplate.text" ucf=true}:</label></b></td>
                                    <td width="5%">&nbsp;</td>
                                    <td width="20%"><b><label for="lang_position">{lang code="ordering.others.option" ucf=true}:</label></b></td>
                                </tr>
                                <tr>
                                    <td width="50%"><input id="lang_lang" type="text" value="" /></td>
                                    <td width="5%">&nbsp;</td>
                                    <td width="20%"><input id="lang_code" type="text" value="" /></td>
                                    <td width="5%">&nbsp;</td>
                                    <td width="20%"><input id="lang_position" type="text" value="" /></td>
                                </tr>
                                <tr>
                                    <td width="100%" colspan="5">
                                        <b>{lang code="-active" ucf=true}:</b>&nbsp;
                                        <input type="radio" name="active" id="active_yes"/>
                                        <label for="active_yes">{lang code="-yes"}</label>&nbsp;
                                        <input type="radio" name="active" id="active_no"/>
                                        <label for="active_no">{lang code="-no"}</label>
                                    </td>
                                </tr>
                                <tr>
                                    <td width="100%" colspan="5">
                                        <b>{lang code="defaultsite.core.title" ucf=true}:</b>&nbsp;
                                        <input type="radio" name="def_site" id="def_site_yes"/>
                                        <label for="def_site_yes">{lang code="-yes"}</label>&nbsp;
                                        <input type="radio" name="def_site" id="def_site_no"/>
                                        <label for="def_site_no">{lang code="-no"}</label>
                                    </td>
                                </tr>
                                <tr>
                                    <td width="100%" colspan="5">
                                        <b>{lang code="defaultadmin.core.title" ucf=true}:</b>&nbsp;
                                        <input type="radio" name="def_admin" id="def_admin_yes"/>
                                        <label for="def_admin_yes">{lang code="-yes"}</label>&nbsp;
                                        <input type="radio" name="def_admin" id="def_admin_no"/>
                                        <label for="def_admin_no">{lang code="-no"}</label>
                                    </td>
                                </tr>
                                <tr>
                                    <td width="100%" colspan="5">
                                        <b>{lang code="defaultcontentadmin.core.title" ucf=true}:</b>&nbsp;
                                        <input type="radio" name="def_content" id="def_content_yes"/>
                                        <label for="def_content_yes">{lang code="-yes"}</label>&nbsp;
                                        <input type="radio" name="def_content" id="def_content_no"/>
                                        <label for="def_content_no">{lang code="-no"}</label>
                                    </td>
                                </tr>
                                <tr>
                                    <td width="100%" colspan="5">
                                        <table style="width:100%" id="upload_image_pane">
                                            <tbody>
                                                <tr>
                                                    <td colspan="3"><b>{lang code="flag.core.title" ucf=true}:</b></td>
                                                </tr>
                                                <tr align="center">
                                                    <td style="vertical-align: middle; height: 40px; width: 50px; border: 1px solid #eee">
                                                        <img id="language_details_preview_flag" src="" border="0"/>
                                                    </td>
                                                    <td style="vertical-align: top; width: 40px">
                                                        <a href="javascript:void(0)" onclick="RADLangPropertiesPanel.clearPreviewFlagImage()" title="Удалить изображение" id="language_details_preview_clear" style="display: none">
                                                            <img src="{url module="core" preset="original" type="image" file="backend/icons/cross.png"}" width="16" height="16" border="0"/>
                                                        </a>
                                                    </td>
                                                    <td colspan="1" rowspan="2" style="vertical-align: middle;">
    <div id="img_container">
        <a id="addimg_link" href="javascript: RADLangPropertiesPanel.switchUploadFrame()">{lang code="addimage.system.text" utf=true}</a>
    </div>
    <div id="imageUpload_block" style="display: none">
        <iframe width="100%" style="height: 50px; border: none; overflow: hidden"
                id="iframe_upload_image" name="iframe_upload_image"
                src="{url href="alias=SYSmanageLangsXML&action=uploadform"}">
                        Your browser doesn't support iframes
        </iframe>
        <div class="red_color" style="position: relative; top: -20px;">{lang code="maximagesize.system.text" ucf=true} 320х200</div>
    </div>
                                                    </td>
                                                </tr>
                                                <tr align="center">
                                                    <td class="caption"></td>
                                                    <td style="vertical-align: top;">
                                                        &nbsp;
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>

                                    </td>
                                </tr>
                                <tr>
                                    <td width="100%" colspan="3">
                                        <b>{lang code="loadtranslation.core.title" ucf=true}:</b><br/>
                                        <p>{lang code="containstranslations.core.text" ucf=true}</p>
                                        <table>
                                            <tr>
                                                <td colspan="1" rowspan="2" style="vertical-align: middle">
                                                    {lang code="existingtranslations.core.text" ucf=true}
                                                </td>
                                                <td>
                                                    <input name="download_mode" id="download_ignore" checked="checked" type="radio">
                                                    <label for="download_ignore">{lang code="notreplacetrabslate.core.text" ucf=false}</label>
                                                </td>
                                                <td colspan="1" rowspan="2" style="vertical-align: middle">
                                                    {lang code="translatefromserver.core.text" ucf=false}
                                                </td>
                                                <td colspan="1" rowspan="2" style="vertical-align: middle">
                                                    <input type="button" value="{lang code="-load" utf=true}" onclick="RADLangPropertiesPanel.clickDownloadTranslations(event)"/>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <input name="download_mode" id="download_owerwrite" type="radio">
                                                    <label for="download_owerwrite"> {lang code="replacetrabslate.core.text" ucf=false}</label>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                        </form>
                        </div>
                    </td>
                    <td class="corner_rb"></td>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
        <td colspan="2">
            <table id="lnv_block" class="tb_cont_block" style="height:auto;width:100%;">
                <tr>
                    <td class="corner_lt"></td>
                    <td class="header_top"></td>
                    <td class="corner_rt"></td>
                </tr>
                <tr>
                    <td class="left_border"></td>
                    <td class="header_bootom" style="height: 0">
                        <div class="hb">
                            <div class="hb_inner">
                                <div class="tb_line_ico">
                                    <table class="item_ico">
                                        <tbody><tr>
                                            <td>
                                                <a href="javascript:RADTranslationsPanel.clickRefresh();">
                                                    <img width="30" height="30" border="0" title="{lang code='-refresh'}" alt="{lang code='-refresh'}" src="{url module="core" preset="original" type="image" file="backend/arrow_refresh.png"}">
                                                    <span style="width:50px;" class="text">{lang code='-refresh'}</span>
                                                </a>
                                            </td>
                                        </tr>
                                    </tbody></table>
                                    <table class="item_ico">
                                        <tbody><tr>
                                            <td>
                                                <a href="javascript:RADTranslationsPanel.clickSaveAll();">
                                                    <img width="30" height="30" border="0" title="{lang code='-save'}" alt="{lang code='-save'}" src="{url module="core" preset="original" type="image" file="backend/disk_multiple.png"}">
                                                    <span style="width:50px;" class="text">{lang code='-save'}</span>
                                                </a>
                                            </td>
                                        </tr>
                                    </tbody></table>
                                    <table class="item_ico">
                                        <tbody><tr>
                                            <td>
                                                <a href="javascript:RADTranslationsPanel.clickAddTranslation()" id="addBtn">
                                                    <img width="30" height="30" border="0" title="{lang code='-add'}" alt="{lang code='-add'}" src="{url module="core" preset="original" type="image" file="backend/add.png"}">
                                                    <span style="width:50px;" class="text">{lang code='-add'}</span>
                                                </a>
                                            </td>
                                        </tr>
                                    </tbody></table>
                                    <table style="float:left;margin-top:10px;text-align:left;" class="item_ico"><tbody>
                                       <tr>
                                           <td width="250" valign="bottom" nowrap="nowrap" height="100%">
                                                <div>
                                                    <div style="float:left;"><input type="text" value="" onkeypress="RADTranslationsPanel.filter(event)" id="translate_search" name="search"></div>
                                                    <div style="float:left;margin-top:2px;margin-left:5px;">
                                                        <input type="image" onclick="RADTranslationsPanel.filterApply();" title="{lang code='-find'}" alt="{lang code='-find'}" src="{url module="core" preset="original" type="image" file="backend/zoom.png"}">
                                                    </div>
                                                </div>
                                           </td>
                                           <td valign="bottom" nowrap="nowrap">
                                               <div id="alias_type" class="translations-sections">
                                                    <div id="tab_translated" onclick="RADTranslationsPanel.tab('translated')" class="vkladka activ">{lang code="editingtranslations.core.title" ucf=true}</div>
                                                    <div id="tab_untranslated" onclick="RADTranslationsPanel.tab('untranslated')" class="vkladka">{lang code="withouttranslations.core.title" ucf=true}</div>
                                               </div>
                                           </td>
                                       </tr>
                                    </tbody></table>
                                    <div class="clear_rt"></div>
                                </div>
                            </div>
                        </div>
                    </td>
                    <td class="right_border"></td>
                </tr>
                <tr>
                    <td class="left_border"></td>
                    <td align="left" id="list_translation">
                        <table class="tb_list">
                            <tr class="header">
                                <td width="25%"  style="text-align:left;">{lang code="code.mailtemplate.text" ucf=true}</td>
                                <td width="70%" style="text-align:left;">{lang code="translation.core.text" ucf=true}</td>
                                <td width="5%">&nbsp;</td>
                            </tr>
                            <tr class="translation_new" style="display: none">
                                <td width="25%" class="code">
                                    <input id="translation_new_code" type="text"
                                            onkeyup="RADTranslationAdd.onKeyUp(event)"/>
                                </td>
                                <td width="70%" class="translation">
                                    <input id="translation_new_value" type="text"
                                            onkeyup="RADTranslationAdd.onKeyUp(event)"/>
                                </td>
                                <td width="5%" style="text-align: center">
                                    <div id="translation_new_save" style="display: none">
                                        <img src="{url module="core" preset="original" type="image" file="backend/icons/disk.png"}"
                                                width="24" height="24" border="0"
                                                alt="{lang code='-save'}"
                                                title="{lang code='-save'}"
                                                style="position: relative; top: -4px; cursor: pointer"
                                                onclick="RADTranslationAdd.clickSave(event)"/>
                                    </div>
                                </td>
                            </tr>
                            <tr class="preloader" style="display: none">
                                <td colspan="3">{lang code="-loading"}...</td>
                            </tr>
                        </table>
                        <table id="translates_table" class="tb_list"></table>
                    </td>
                    <td class="right_border"></td>
                </tr>
                <tr>
                    <td class="left_border" nowrap="nowrap" style="width:3px;"></td>
                    <td align="left" id="panel_langlist">
                    </td>
                    <td class="right_border" style="width:3px;" nowrap="nowrap"></td>
                </tr>
                <tr>
                    <td class="left_border"></td>
                    <td class="gray_line">

                    </td>
                    <td class="right_border"></td>
                </tr>
                <tr>
                    <td class="corner_lb"></td>
                    <td class="tb_bottom"></td>
                    <td class="corner_rb"></td>
                </tr>
            </table>
        </td>
    </tr>
</table>
{/strip}