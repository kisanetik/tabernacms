{strip}
{url href="alias=SITE_ALIASXML&action=getjs" type="js"}
<style>
    .errormsg {
        display:none;
        color:red;
    }
</style>
<div class="w100">
    <div class="kord_right_col">
        <h1>{lang code="manageconfig.system.title" ucf=true}</h1>
        {if isset($errormessages) and count($errormessages)}
            <div style="color:red;">
                <ul>
                    {foreach $errormessages as $msg}
                        <li>{$msg}</li>
                    {/foreach}
                </ul>
            </div>
        {/if}
        <form method="post" id="configForm">
            <table>
                <tr>
                    <td>{lang code="sitenameconfig.system.text" ucf=true}</td>
                    <td>
                        <input type="text" name="page__defaultTitle" id="page__defaultTitle" value="{$configParams['page.defaultTitle']|escape|default:''}" />
                        <br/>
                        <span id="page__defaultTitle_error" class="errormsg"></span>
                    </td>
                </tr>
                <tr>
                    <td>{lang code="adminemailconfig.system.text" ucf=true}</td>
                    <td>
                        <input type="text" name="admin__mail" id="admin__mail" value="{$configParams['admin.mail']|default:''}" />
                        <br/>
                        <span id="admin__mail_error" class="errormsg"></span>
                    </td>
                </tr>
                <tr>
                    <td>{lang code="systememailconfig.system.text" ucf=true}</td>
                    <td>
                        <input type="text" name="system__mail" id="system__mail" value="{$configParams['system.mail']|default:''}" />
                        <br/>
                        <span id="system__mail_error" class="errormsg"></span>
                    </td>
                </tr>
                <tr>
                    <td>{lang code="referalsconfig.system.text" ucf=true}</td>
                    <td>
                        <select name="referals__on" id="referals__on" onchange="javascript:RADConfig.showReferealsPercent();">
                            <option value="1" {if $configParams['referals.on'] eq true}selected="selected"{/if}>{lang code="onconfig.system.text"}</option>
                            <option value="0" {if $configParams['referals.on'] eq false}selected="selected"{/if}>{lang code="offconfig.system.text"}</option>
                        </select>
                        <br/>
                        <span id="referals__on_error" class="errormsg"></span>
                        {if $configParams['referals.on'] eq true}
                        <div id="refpercent" style="display:block;">
                        {else}
                        <div id="refpercent" style="display:none;">
                        {/if}
                            <span>{lang code="referalspercentconfig.system.text" ucf=true}</span>
                            <br />
                            <input type="text" name="referals__percent" id="referals__percent" value="{$configParams['referals.percent']|escape|default:''}" />
                            <span id="referals__percent_error" class="errormsg"></span>
                        </div>
                    </td>
                </tr>
                {if count($languages)}
                <tr>
                    <td>{lang code="languagesconfig.system.text" ucf=true}</td>
                    <td>
                        <select name="lang__default" id="lang__default">
                            {foreach $languages as $language}
                                {if $language->lng_active eq 1}
                                    <option value="{$language->lng_code}" {if $configParams['lang.default'] eq $language->lng_code}selected="selected"{/if}>{$language->lng_name}</option>
                                {/if}
                            {/foreach}
                        </select>
                        <br/>
                        <span id="lang__location_show_error" class="errormsg"></span>
                    </td>
                </tr>
                {/if}
                <tr>
                    <td>{lang code="langshowconfig.system.text" ucf=true}</td>
                    <td>
                        <select name="lang__location_show" id="lang__location_show">
                            <option value="1" {if $configParams['lang.location_show'] eq true}selected="selected"{/if}>{lang code="onconfig.system.text"}</option>
                            <option value="0" {if $configParams['lang.location_show'] eq false}selected="selected"{/if}>{lang code="offconfig.system.text"}</option>
                        </select>
                        <br/>
                        <span id="lang__location_show_error" class="errormsg"></span>
                    </td>
                </tr>
                {if count($themes)}
                <tr>
                    <td>{lang code="themedefconfig.system.text" ucf=true}</td>
                    <td>
                        <select name="theme__default" id="theme__default">
                            <option value="" {if $configParams['theme.default'] eq ''}selected{/if}>Taberna</option>
                            {foreach from=$themes item=theme}
                                <option value="{$theme}" {if $configParams['theme.default'] eq $theme}selected{/if}>{$theme}</option>
                            {/foreach}
                        </select>
                        <br/>
                        <span id="theme__default_error" class="errormsg"></span>
                    </td>
                </tr>
                {/if}
                <tr>
                    <td>{lang code="currency_decimal_separator.core.text" ucf=true}</td>
                    <td>
                        <input type="text" name="currency__decimal_separator" maxlength="1" id="currency__decimal_separator" value="{if isset($configParams['currency.decimal_separator'])}{$configParams['currency.decimal_separator']|escape|default:''}{else}.{/if}" />
                        <br/>
                        <span id="currency__decimal_separator_error" class="errormsg"></span>
                    </td>
                </tr>
                <tr>
                    <td>{lang code="currency_group_separator.core.text" ucf=true}</td>
                    <td>
                        <input type="text" name="currency__group_separator" maxlength="1" id="currency__group_separator" value="{if isset($configParams['currency.group_separator'])}{$configParams['currency.group_separator']|escape|default:''}{else} {/if}" />
                        <br/>
                        <span id="currency__group_separator_error" class="errormsg"></span>
                    </td>
                </tr>
            </table>
            <input type="hidden" name="action" value="save" />
            <input type="hidden" name="hash" value="{$hash|default:''}" />
            <input type="button" value="{lang code="-save" ucf=true}" onclick="javascript:RADConfig.save();">
        </form>
    </div>
</div>
{/strip}