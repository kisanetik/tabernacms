{strip}
{url module="core" file="simple-modal/style.css" type="css"}
{url module="core" file="simple-modal/simple-modal.js" type="js" load="sync"}
{url href="alias=SITE_ALIASXML&action=getjs" type="js"}
{url module="" file="editarea/edit_area_full.js" type="js"}

<script type="text/javascript">
    var alias_id = {$item->id}
            {literal}
            window.onload = function() {
                ThemeRules.edit(alias_id, 'default');
            }
{/literal}
    var themes = [''{foreach from=$themes item=theme},'{$theme}'{/foreach}];
</script>
<h1>{lang code='aliasedit.system.title' ucf=true}</h1>
<table cellpadding="0" cellspacing="0" border="0" class="tb_two_column" style="height:auto;width:100%;">
    <tr>
        <td width="410">
            <table cellpadding="0" cellspacing="0" border="0" class="tb_cont_block" style="width:auto;height:auto;" >
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
                                        <div class="block_header_title">{lang code="aliases.system.title" ucf=true ucf=true}</div>
                                    </td>
                                    <td width="300px">
                                        <div class="block_header_title" style="text-align: right;"><span class="red_color" id="aliasInfoMessage"></span></div>
                                    </td>
                                </tr>
                                </table>

                                <!--  <div class="block_header_title">{lang code='aliases.system.title' ucf=true}</div>-->
                                <div class="tb_line_ico">
                                    <table class="item_ico">
                                        <tr>
                                            <td>
                                                <a href="{url href="alias=SITE_ALIAS"}">
                                                    <img class="img" src="{url module="core" preset="original" type="image" file="backend/cross.png"}" alt="{lang code='-cancel' ucf=true htmlchars=true}" title="{lang code='-cancel' ucf=true htmlchars=true}" width="30" height="30" border="0">
                                                    <span class="text" style="width:50px;">{lang code='-cancel' ucf=true htmlchars=true}</span>
                                                </a>
                                            </td>
                                        </tr>
                                    </table>
                                    <table class="item_ico">
                                        <tr>
                                            <td>
                                                <a href="javascript:RADAliasesAction.applyClick('{$item->id}');">
                                                    <img src="{url module="core" preset="original" type="image" file="backend/accept.png"}" alt="{lang code='-apply' ucf=true htmlchars=true}" title="{lang code='-apply' ucf=true htmlchars=true}" width="30" height="30" border="0">
                                                    <span class="text" style="width:50px;">{lang code='-apply' ucf=true}</span>
                                                </a>
                                            </td>
                                        </tr>
                                    </table>
                                    <table class="item_ico">
                                        <tr>
                                            <td>
                                                <a href="javascript:RADAliasesAction.saveClick('{$item->id}');">
                                                    <img src="{url module="core" preset="original" type="image" file="backend/disk.png"}" alt="{lang code='-save' ucf=true htmlchars=true}" title="{lang code='-save' ucf=true htmlchars=true}" width="30" height="30" border="0">
                                                    <span class="text" style="width:50px;">{lang code='-save' ucf=true}</span>
                                                </a>
                                            </td>
                                        </tr>
                                    </table>
                                    {if $action ne 'add' and $item->ali_admin < 2}
                                    <table class="item_ico">
                                        <tr>
                                            <td>
                                                <a href="javascript:RADScriptWindow.aliasScriptShow('{$item->id}');">
                                                    <img src="{url module="core" preset="original" type="image" file="backend/alias_script.gif"}" alt="{lang code='metatags.system.button' ucf=true htmlchars=true}" title="{lang code='metatags.system.button' ucf=true htmlchars=true}" width="30" height="30" border="0">
                                                    <span class="text" style="width:50px;">{lang code='metatags.system.button' ucf=true}</span>
                                                </a>
                                            </td>
                                        </tr>
                                    </table>
                                    <table class="item_ico">
                                        <tr>
                                            <td>
                                                <a href="javascript:RADAliDescr.show('{$item->id}');">
                                                    <img src="{url module="core" preset="original" type="image" file="backend/alias_script.gif"}" alt="{lang code='description.system.button' ucf=true htmlchars=true}" title="{lang code='description.system.button' ucf=true htmlchars=true}" width="30" height="30" border="0">
                                                    <span class="text" style="width:50px;">{lang code='description.system.button' ucf=true}</span>
                                                </a>
                                            </td>
                                        </tr>
                                    </table>
                                    {/if}
                                    <div class="clear_rt"></div>
                                </div>
                            </div>
                        </div>
                    </td>
                    <td class="right_border"></td>
                </tr>
                <tr>
                    <td class="left_border"></td>
                    <td align="left" class="panel_main">
                        <form method="post" id="addeditalias">
                        <input type="hidden" name="alias_id" id="alias_id" value="{$item->id}" />
                        <input type="hidden" name="hash" id="hash" value="{$hash|default:''}" />
                            <table cellpadding="0" cellspacing="0" border="0" class="tb_add">
                                <tr>
                                    <td class="left_column">{lang code='aliasname.system.text' ucf=true}:</td>
                                    <td><input type="text" name="alias_name" id="alias_name" class="long_text" value="{$item->alias}" onKeyUp='RADAliasesAction.changed();' /></td>
                                </tr>
                                <tr>
                                    <td class="left_column">{lang code='template.system.text' ucf=true}:</td>
                                    <td>
                                        <select id="template_id" name="tempate_id" onchange="RADAliasesAction.changed();">
                                            {if count($templates)}
                                                {foreach from=$templates item=template}
                                                   <option value="{$template->id}"{if $template->id eq $item->template_id} selected="selected"{/if}>{$template->filename}</option>
                                                {/foreach}
                                            {/if}
                                        </select>
                                    </td>
                                </tr>
                                {if $item->ali_admin < 2}
                                    <tr>
                                        <td class="left_column">{lang code='orgroupalias.system.text' ucf=true}:</td>
                                        <td>
                                            <select id="alias_group" name="alias_group" onchange="RADAliasesAction.useGA();">
                                                <option value="0">{lang code="notusega.system.option"}</option>
                                                {if count($group_alias)}
                                                    {foreach from=$group_alias item=ga}
                                                        <option value="{$ga->id}"{if $item->group_id eq $ga->id} selected="selected"{/if}>{$ga->alias}</option>
                                                    {/foreach}
                                                {/if}
                                            </select>
                                        </td>
                                    </tr>
                                    {if isset($action) and $action ne 'add' }
                                    <script language="JavaScript" type="text/javascript">
{literal}window.onload=function(){RADAliasesAction.useGA();};{/literal}
                                    </script>
                                    {/if}
                                    <tr>
                                        <td class="left_column">{lang code="-active" ucf=true}:</td>
                                        <td>
                                            <input type="checkbox" name="active" id="active" {if $item->active}checked="checked"{/if} /><label for="active">&nbsp;{lang code="-yes"}</label>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="left_column">{lang code='isadminalias.system.text'}:</td>
                                        <td>
                                            <input type="checkbox" name="ali_admin" id="ali_admin" {if $item->ali_admin}checked="checked"{/if} /><label for="ali_admin">&nbsp;{lang code="-yes"}</label>
                                        </td>
                                    </tr>
                                    {if isset($inclasses)}
                                    <tr>
                                        <td class="left_column">{lang code="input_class.system.text" ucf=true}:</td>
                                        <td>
                                            <select id="input_class" name="input_class" onchange="RADAliasesAction.changed();">
                                                <option value="0">{lang code="standart.system.text" ucf=true}</option>
                                                {if count($inclasses)}
                                                    {foreach from=$inclasses key=kclass item=class}
                                                        <option value="{$class}"{if $class eq $item->input_class} selected="selected" {/if}>{$class}</option>
                                                    {/foreach}
                                                {/if}
                                            </select>
                                        </td>
                                    </tr>
                                    {/if}
                                {else}
                                    <input type="hidden" name="active" value="1" />
                                    <input type="hidden" name="ali_admin" value="2" />
                                {/if}
                                {*if isset($powercache) and $powercache}
                                <tr>
                                    <td class="left_column">{lang code="aliascached.system.text" ucf=true}:</td>
                                    <td>
                                        <input type="checkbox" name="ali_cached" id="ali_cached"{if $item->caching} checked="checked"{/if} />
                                        <label for="ali_cached">{lang code='-yes'}</label>
                                    </td>
                                </tr>
                                {/if*}
                            </table>
                        </form>
                    </td>
                    <td class="right_border"></td>
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
        {*****     THEMES     *******}
        {if $action eq 'edit' and count($themes) > 0}
        <td align="left">
            <table cellpadding="0" cellspacing="0" border="0" class="tb_cont_block" style="width:auto;height:auto;margin-left:10px;width:270px;" align="left" >
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
                                        <div class="block_header_title">{lang code='themes.system.title' ucf=true}</div>
                                    </td>
                                    <td>
                                        <div class="block_header_title" style="text-align: right;"><span class="red_color" id="themesMessage"></span></div>
                                    </td>
                                </tr>
                                </table>

                            </div>
                        </div>
                    </td>
                    <td class="right_border"></td>
                </tr>
                <tr>
                    <td class="left_border"></td>
                    <td align="left">
                        {*********           CONTENT          **************}
                        <table cellpadding="0" cellspacing="0" border="0" class="tb_list" id="tb_list">
                            <tr class="header">
                                <td width="90%" nowrap="nowrap">
                                    {lang code='templatename.system.title' ucf=true}
                                </td>
                                <td>
                                    {lang code='templaterules.system.title' ucf=true}
                                </td>
                                <td nowrap="nowrap">
                                    {lang code='-action' ucf=true}
                                </td>
                            </tr>
                            <tr>
                                <td title="Default main"">
                                    {lang code='-default'}
                                </td>
                                <td>
                                    <img src="{url module="core" preset="original" type="image" file="backend/icons/accept.png"}" alt="{lang code='-yes' ucf=true htmlchars=true}" title="{lang code='-yes' ucf=true htmlchars=true}" border="0" />
                                </td>
                                <td>
                                    <a href="javascript:ThemeRules.edit({$item->id},'');"><img src="{url module="core" preset="original" type="image" file="backend/icons/page_edit.png"}" alt="{lang code='-edit' ucf=true htmlchars=true}" title="{lang code='-edit' ucf=true htmlchars=true}" border="0" /></a>
                                </td>
                            </tr>
                            {foreach from=$themes item=theme key=th_key}
                            <tr>
                                <td>
                                    {$theme}
                                </td>
                                <td>
                                    {assign var="rule_exist" value=false}
                                    {foreach from=$themes_rules item=theme_rule}
                                       {if $theme_rule->theme_folder eq $theme}
                                           {assign var="rule_exist" value=true}
                                       {/if}
                                    {/foreach}
                                    <img id="theme_ex_t_{$theme}" {if !$rule_exist}style="display:none;"{/if} src="{url module="core" preset="original" type="image" file="backend/icons/accept.png"}" alt="{lang code='-yes' ucf=true htmlchars=true}" title="{lang code='-yes' ucf=true htmlchars=true}" border="0" />
                                </td>
                                <td>
                                    <a id="theme_hrf_add_{$theme}" {if $rule_exist}style="display:none;"{/if} href="javascript:ThemeRules.create({$item->id},'{$theme}');"><img src="{url module="core" preset="original" type="image" file="backend/icons/page_add.png"}" alt="{lang code='-edit' ucf=true htmlchars=true}" title="{lang code='-edit' ucf=true htmlchars=true}" border="0" /></a>
                                    <a id="theme_hrf_edit_{$theme}" {if !$rule_exist}style="display:none;"{/if} href="javascript:ThemeRules.edit({$item->id},'{$theme}');"><img src="{url module="core" preset="original" type="image" file="backend/icons/page_edit.png"}" alt="{lang code='-edit' ucf=true htmlchars=true}" title="{lang code='-edit' ucf=true htmlchars=true}" border="0" /></a>
                                    <a id="theme_hrf_del_{$theme}" {if !$rule_exist}style="display:none;"{/if} href="javascript:ThemeRules.delete({$item->id},'{$theme}');"><img src="{url module="core" preset="original" type="image" file="backend/icons/cross.png"}"" alt="{lang code='-delete' ucf=true htmlchars=true}" title="{lang code='-delete' ucf=true htmlchars=true}" border="0" /></a>
                                    <a id="theme_hrf_copy_{$theme}" {if !$rule_exist}style="display:none;"{/if} href="javascript:ThemeRules.copy({$item->id},'{$theme}');"><img src="{url module="core" preset="original" type="image" file="backend/icons/page_add.png"}"" alt="{lang code='copycopmonents.aliases.text' ucf=true htmlchars=true}" title="{lang code='copycopmonents.aliases.text' ucf=true htmlchars=true}" border="0" /></a>
                                </td>
                            </tr>
                            {/foreach}
                        </table>
                        {*********         END CONTENT        **************}
                    </td>
                    <td class="right_border"></td>
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
            &nbsp;
        </td>
        {/if}
    </tr>
</table>









<table cellpadding="0" cellspacing="0" border="0" class="tb_two_column" id="includes_list"{if isset($action) and $action eq 'add' } style="display:none;margin-top:15px;"{else} style="margin-top:15px;"{/if}>
    <tr>
        <td style="width:100%;">
            <table cellpadding="0" cellspacing="0" border="0" class="tb_cont_block" style="width:100%;height:auto;" >
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
                                        <div class="block_header_title">{lang code="includesinaliases.system.title" ucf=true}</div>
                                    </td>
                                    <td>
                                        <div class="block_header_title" style="text-align: right;"><span class="red_color" id="IncInAlInfoMessage"></span></div>
                                    </td>
                                </tr>
                                </table>
                                <div class="tb_line_ico">
                                    {*
                                    <table class="item_ico">
                                        <tr>
                                            <td>
                                                <a href="javascript:RADIncInAlAction.deleteClick();">
                                                    <img src="{url module="core" preset="original" type="image" file="backend/icons/ico_delete.gif"}" alt="{lang code='-delete' ucf=true htmlchars=true}" title="{lang code='-delete' ucf=true htmlchars=true}" width="30" height="30" border="0">
                                                    <span class="text" style="width:50px;">{lang code='-delete'}</span>
                                                </a>
                                            </td>
                                        </tr>
                                    </table>
                                    *}
                                    <table class="item_ico">
                                        <tr>
                                            <td>
                                                <a href="javascript:RADIncInAlAction.applyClick();">
                                                    <img src="{url module="core" preset="original" type="image" file="backend/accept.png"}" alt="{lang code='-apply' ucf=true htmlchars=true}" title="{lang code='-apply' ucf=true htmlchars=true}" width="30" height="30" border="0">
                                                    <span class="text" style="width:50px;">{lang code='-apply'}</span>
                                                </a>
                                            </td>
                                        </tr>
                                    </table>
                                    <table class="item_ico">
                                        <tr>
                                            <td>
                                                <a href="javascript:RADIncInAlAction.saveClick();">
                                                    <img src="{url module="core" preset="original" type="image" file="backend/disk.png"}" alt="{lang code='-save' ucf=true htmlchars=true}" title="{lang code='-save' ucf=true htmlchars=true}" width="30" height="30" border="0">
                                                    <span class="text" style="width:50px;">{lang code='-save'}</span>
                                                </a>
                                            </td>
                                        </tr>
                                    </table>
                                    <table class="item_ico">
                                        <tr>
                                            <td>
                                                <a href="javascript:RADIncInAlAction.addClick();">
                                                    <img src="{url module="core" preset="original" type="image" file="backend/add.png"}" alt="{lang code='-add' ucf=true htmlchars=true}" title="{lang code='-add' ucf=true htmlchars=true}" width="30" height="30" border="0">
                                                    <span class="text" style="width:50px;">{lang code='-add'}</span>
                                                </a>
                                            </td>
                                        </tr>
                                    </table>
                                    <table class="item_ico">
                                        <tr>
                                            <td>
                                                <a href="javascript:RADIncInAlAction.refresh();">
                                                    <img src="{url module="core" preset="original" type="image" file="backend/arrow_rotate_clockwise.png"}" alt="{lang code='-refresh' ucf=true htmlchars=true}" title="{lang code='-refresh' ucf=true htmlchars=true}" width="30" height="30" border="0">
                                                    <span class="text" style="width:50px;">{lang code='-refresh'}</span>
                                                </a>
                                            </td>
                                        </tr>
                                    </table>
                                    <table class="item_ico" style="float:left;">
                                        <tr>
                                            <td>
                                                <span id="inc_h_mes" class="red_color"></span>
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
                    <td align="left" id="list_includes_content">
                        {include file="$_CURRENT_LOAD_PATH/admin.managealiases/includeslist.tpl"}
                    </td>
                    <td class="right_border"></td>
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