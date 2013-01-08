<br/>{strip}
<input type="hidden" id="aliasESID" name="alias_id" value="{$alias_id}" />
<table cellpadding="0" cellspacing="0" border="0" width="100%" height="100%">
    <tr height="10%">
        <td width="80%" height="100%">

            <div id="ScriptsTPanel" class="vkladki" style="position:static; margin:0 2px; height:31px;">
                        {**********tab navistring(BREADCRUMBS)**********}
                        <div id="NaviTab" class="vkladka" onclick="RADTabs.change('NaviTab','ScriptsTPanel','TabsWrapper2');">
                            <div>
                                                <div>
                                    <div>
                                        {lang code='breadcrumbs.system.title'}
                                    </div>
                                </div>
                            </div>
                        </div>
                        {************tab title************}
                        <div id="TitleTab" class="vkladka activ" onclick="RADTabs.change('TitleTab','ScriptsTPanel','TabsWrapper2');">
                            <div>
                                <div>
                                    <div>
                                        {lang code='-metatitle'}
                                    </div>
                                </div>
                            </div>
                        </div>
                        {***********tab META-description*********}
                        <div id="metadescriptionTab" class="vkladka" onclick="RADTabs.change('metadescriptionTab','ScriptsTPanel','TabsWrapper2');">
                            <div>
                                <div>
                                    <div>
                                        {lang code='-metadescription'}
                                    </div>
                                </div>
                            </div>
                        </div>
                        {***********tab META-Keywords*********}
                        <div id="metatitleTab" class="vkladka" onclick="RADTabs.change('metatitleTab','ScriptsTPanel','TabsWrapper2');">
                            <div>
                                <div>
                                    <div>
                                        {lang code='-metakeywords'}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="clear"></div>
                    </div>
        <style>
        {literal}
        #selection_field{
         top:1px;
        }
        {/literal}
        </style>

            <div class="inn_components_out" style="padding-top:0 !important;position:static; width: 98%;// margin-top:-1px; ">
            <div class="inn_components" style="position: static;background-color:#FFFFFF;">
                <form id="scripts2Form" onsubmit="return false">
                <input type="hidden" name="alias_id" value="{$alias_id}" />
                <input type="hidden" name="hash" value="{$hash|default:''}" />
                <div class="und_vkladki">
                    <div id="TabsWrapper2" class="wrap">
                    <div id="NaviTab_tabcenter" class="lf_col tabcenter" style="width:100%;display:none;">
                                        <div class="kord_lf_col">
                                        <fieldset class="group_box" style="position: static;background-color:#FFFFFF;">
                            <legend class="tit" style="position:static;margin-left:5px;">script</legend>
                                                    <div class="kord_cont">
                                                <textarea id="navi_script" name="navi_script" rows="25" style="width:98%">{$item->navi_script}</textarea>
                                    </div>
                                        </fieldset>
                        </div>
                    </div>
                    <div id="TitleTab_tabcenter" class="lf_col tabcenter" style="width:100%;">
                        <div class="kord_lf_col">
                        <fieldset class="group_box" style="position: static;background-color:#FFFFFF;">
                        <legend class="tit" style="position:static;margin-left:5px;">script</legend>
                            <div class="kord_cont">
                            <textarea id="txt_script" name="txt_script" rows="25" style="width:98%">{$item->title_script}</textarea>
                            </div>
                        <fieldset>
                        </div>
                    </div>
                    <div id="metadescriptionTab_tabcenter" class="lf_col tabcenter" style="width:100%;display:none;">
                        <div class="kord_lf_col">
                            <fieldset class="group_box" style="position: static;background-color:#FFFFFF;">
                                <legend class="tit" style="position:static;margin-left:5px;">script</legend>
                                <div class="kord_cont">
                                    <textarea id="metadescription_script" name="metadescription_script" rows="25" style="width:98%">{$item->metadescription_script}</textarea>
                                </div>
                            </fieldset>
                        </div>
                    </div>
                    <div id="metatitleTab_tabcenter" class="lf_col tabcenter" style="width:100%;display:none;">
                        <div class="kord_lf_col">
                        <fieldset class="group_box" style="position: static;background-color:#FFFFFF;">
                            <legend class="tit" style="position:static;margin-left:5px;">script</legend>
                            <div class="kord_cont">
                                <textarea id="metatitle_script" name="metatitle_script" rows="25" style="width:98%">{$item->metatitle_script}</textarea>
                            </div>
                        </fieldset>
                        </div>
                    </div>
                    </div>
                    <div class="clear"></div>
                </div>
                </form>
            </div>
            </div>
        </td>
        <td>
            <table cellpadding="0" cellspacing="0" border="0" width="100%">
                    <tr>
                    <td nowrap="nowrap" width="5%">
                            {lang code='bc_moduleslist.system.text'}
                    </td>
            </tr>
            <tr>
                    <td>
                            {if isset($helpers) and count($helpers)}
                            <select id="bc_modules" name="bc_modules" onchange="RADScriptWindow.moduleChange();">
                            {foreach from=$helpers item=helper key=controllername}
                            <option value="{$controllername}">{$controllername}</option>
                            {/foreach}
                            </select>
                            {else}
                            {lang code='nomodules.system.text'}
                            {/if}
                    </td>
                    </tr>
                </table>
            {lang code='bc_vars.system.text'}
        <!-- /td>
        </tr>
    <tr height="80%">
        <td width="20%"-->
            {if isset($helpers) and count($helpers)}
            <ul id="helpers" class="helpers_ul">
                {foreach from=$helpers item=helper key=controllername}
                    <li id="li_{$controllername}" class="li_scriptw_p">
                        <ul id="ul_{$controllername}" class="helpers_ul">
                            {if count($helper.vars)}
                            {foreach from=$helper.vars item=var_h key=key_h}
                            <li id="li1_{$controllername}_{$key_h}" class="each_el_key_h" hint="{$var_h}" onmousemove="RADScriptWindow.showHint(this,1);" onmouseout="RADScriptWindow.showHint(this,0);">
                                <a href="javascript:RADScriptWindow.ta('{$controllername}','{$key_h}');">${$key_h}</a>
                            </li>
                            {/foreach}
                            {/if}
                            {if isset($helper.vars2) and count($helper.vars2)}
                            {foreach from=$helper.vars2 item=var_h key=key_h}
                            <li id="li1_{$controllername}_{$key_h}" class="each_el_key_h" hint="{$var_h}" onmousemove="RADScriptWindow.showHint(this,1);" onmouseout="RADScriptWindow.showHint(this,0);">
                                <a href="javascript:RADScriptWindow.ta2('{$controllername}','{$key_h}');">&lt;%{$key_h}%&gt;</a>
                            </li>
                            {/foreach}
                            {/if}
                        </ul>
                    </li>
                {/foreach}
            </ul>
            {/if}
        </td>
    </tr>
    <tr>
        <td colspan="2" align="left">
            <table cellpadding="0" cellspacing="0" border="0">
                <tr>
                    <td width="1%" nowrap="nowrap">
                        {lang code='donescripts.breadcrumbs.text'}
                    </td>
                    <td>
                        <select id="done_bc_scripts">

                        </select>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
    <tr height="10%">
        <td colspan="2" align="center" width="100%">
            <input type="button" value="{lang code='-submit' ucf=true|replace:'"':'&quot;'}" id="submitScriptWindowClick" onclick="RADScriptWindow.submitClick();" />&nbsp;
            <input type="button" id="cancelScriptWindowClick" value="{lang code='-cancel' ucf=true|replace:'"':'&quot;'}" onclick="RADScriptWindow.cancelClick();" />
        </td>
    </tr>
</table>
{*</form>*}
{/strip}