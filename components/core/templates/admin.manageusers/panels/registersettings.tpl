{strip}
<div class="inn_components_out" id="inn_components_out_s">
    <div class="inn_components" id="inn_components_s">
        <div id="TabsPanel" class="vkladki">
            <div id="registration_settings_Tab" class="vkladka activ" onclick="RADTabs.change('registration_settings_Tab');">
                <div><div><div>{lang code='registertemplate.session.title'}</div></div></div>
            </div>
            <div id="registrationok_settings_Tab" class="vkladka" onclick="RADTabs.change('registrationok_settings_Tab');">
                <div><div><div>{lang code='registeroktemplate.session.title'}</div></div></div>
            </div>
        </div>
        <div class="clear"></div>
        <div class="und_vkladki" style="height:100%;">
            <div id="TabsWrapper" class="wrap">
                {****  REGISTRATION SETTINGS TAB  ****}
                <form id="registration_settings_form" onsubmit="return false;">
                <div id="registration_settings_Tab_tabcenter" class="lf_col tabcenter" style="width:100%;">
                    <div class="kord_lf_col">
                        <div class="group_box margin_bottom">
                            <span class="tit">{lang code='registration_template.settings.title'}</span>
                            <div class="kord_cont" style="height:auto;">
                                <table cellpadding="0" cellspacing="0" border="0" width="100%" class="mt">
                                    {if count($langs)>1}
                                    <tr>
                                        <td nowrap="nowrap" width="5%">
                                            {lang code='-language' ucf=true}
                                        </td>
                                        <td align="left" width="95%">
                                            {foreach from=$langs item=lang}
                                                <input type="radio" onchange="RADSTab.change({$lang->lng_id},'registration_settings_Tab_tabcenter','table_registration_settings_');" name="registration_lang" value="{$lang->lng_id}" id="lang_regset_{$lang->lng_id}" {if $lang->lng_maincontent} checked="checked"{/if} />
                                                <label for="lang_newsset_{$lang->lng_id}">{$lang->lng_code}</label>
                                            {/foreach}
                                        </td>
                                    </tr>
                                    {/if}
                                    <tr><td{if count($langs)>1} colspan="2"{/if}>
                                    {foreach from=$langs item=lang}
                                    {assign var=lngid value=`$lang->lng_id`}
                                    <input type="hidden" name="4sct_id[{$lngid}]" value="{$mset[$lngid][$registration_template]->sct_id}" />
                                    <table class="set_items" cellpadding="0" cellspacing="0" border="0" width="100%" id="table_registration_settings_{$lngid}"{if $lang->lng_maincontent ne 1} style="display:none;"{/if}>
                                    <tr>
                                        <td nowrap="nowrap" width="5%">
                                            {lang code='backemail.subscribe.text'}&nbsp;
                                        </td>
                                        <td align="left" width="95%">
                                            <input type="text" name="4mail_subscribe_from[{$lngid}]" id="4mail_subscribe_from" value="{$mset[$lngid][$registration_template]->sct_backemail}" />
                                        </td>
                                    </tr>
                                    <tr>
                                        <td nowrap="nowrap">
                                            {lang code='backemailname.subscribe.text'}&nbsp;
                                        </td>
                                        <td align="left">
                                            <input type="text" name="4mail_subscribe_from_name[{$lngid}]" id="4mail_subscribe_from_name" value="{$mset[$lngid][$registration_template]->sct_backemailname}" />
                                        </td>
                                    </tr>
                                    <tr>
                                        <td nowrap="nowrap">
                                            {lang code='backemailtitle.subscribe.text'}&nbsp;
                                        </td>
                                        <td align="left">
                                            <input type="text" name="4mail_subscribe_title[{$lngid}]" id="4mail_subscribe_title" value="{$mset[$lngid][$registration_template]->sct_mailtitle}" />
                                        </td>
                                    </tr>
                                    <tr>
                                        <td nowrap="nowrap">
                                            {lang code='subscribetemplate.subscribe.text'}&nbsp;
                                        </td>
                                        <td align="left">
                                            <textarea rows="10" style="width:95%;" name="4mail_template[{$lngid}]">{$mset[$lngid][$registration_template]->sct_mailtemplate}</textarea>
                                        </td>
                                    </tr>
                                    </table>
                                    {/foreach}
                                    </td></tr>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                </form>
                {****  END OF REGISTRATION SETTINGS TAB  ****}
                {****  REGISTRATION OK SETTINGS TAB  ****}
                <form id="registrationok_settings_form" onsubmit="return false;">
                <div id="registrationok_settings_Tab_tabcenter" class="lf_col tabcenter" style="width:100%;display:none;">
                    <div class="kord_lf_col">
                        <div class="group_box margin_bottom">
                            <span class="tit">{lang code='registrationok_template.settings.title'}</span>
                            <div class="kord_cont" style="height:auto;">
                                <table cellpadding="0" cellspacing="0" border="0" width="100%" class="mt">
                                    {if count($langs)>1}
                                    <tr>
                                        <td nowrap="nowrap" width="5%">
                                            {lang code='-language'}
                                        </td>
                                        <td align="left" width="95%">
                                            {foreach from=$langs item=lang}
                                                <input type="radio" onchange="RADRegSettings.change({$lang->lng_id},'registrationok_settings_Tab_tabcenter','table_registrationok_settings_');" name="registrationok_lang" value="{$lang->lng_id}" id="lang_regokset_{$lang->lng_id}" {if $lang->lng_maincontent} checked="checked"{/if} />
                                                <label for="lang_set_{$lang->lng_id}">{$lang->lng_code}</label>
                                            {/foreach}
                                        </td>
                                    </tr>
                                    {/if}
                                    <tr><td{if count($langs)>1} colspan="2"{/if}>
                                    {foreach from=$langs item=lang}
                                    {assign var=lngid value=`$lang->lng_id`}
                                    <input type="hidden" name="5sct_id[{$lngid}]" value="{$mset[$lngid][$registrationok_template]->sct_id}" />
                                    <table class="set_items" cellpadding="0" cellspacing="0" border="0" width="100%" id="table_registrationok_settings_{$lngid}"{if $lang->lng_maincontent ne 1} style="display:none;"{/if}>
                                    <tr>
                                        <td nowrap="nowrap" width="5%">
                                            {lang code='backemail.subscribe.text'}&nbsp;
                                        </td>
                                        <td align="left" width="95%">
                                            <input type="text" name="5mail_subscribe_from[{$lngid}]" id="5mail_subscribe_from" value="{$mset[$lngid][$registrationok_template]->sct_backemail}" />
                                        </td>
                                    </tr>
                                    <tr>
                                        <td nowrap="nowrap">
                                            {lang code='backemailname.subscribe.text'}&nbsp;
                                        </td>
                                        <td align="left">
                                            <input type="text" name="5mail_subscribe_from_name[{$lngid}]" id="5mail_subscribe_from_name" value="{$mset[$lngid][$registrationok_template]->sct_backemailname}" />
                                        </td>
                                    </tr>
                                    <tr>
                                        <td nowrap="nowrap">
                                            {lang code='backemailtitle.subscribe.text'}&nbsp;
                                        </td>
                                        <td align="left">
                                            <input type="text" name="5mail_subscribe_title[{$lngid}]" id="5mail_subscribe_title" value="{$mset[$lngid][$registrationok_template]->sct_mailtitle}" />
                                        </td>
                                    </tr>
                                    <tr>
                                        <td nowrap="nowrap">
                                            {lang code='subscribetemplate.subscribe.text'}&nbsp;
                                        </td>
                                        <td align="left">
                                            <textarea rows="10" style="width:95%;" name="5mail_template[{$lngid}]">{$mset[$lngid][$registrationok_template]->sct_mailtemplate}</textarea>
                                        </td>
                                    </tr>
                                    </table>
                                    {/foreach}
                                    </td></tr>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                </form>
                {****  END OF REGISTRATION OK SETTINGS TAB  ****}
            </div>
        </div>
    </div>
</div>
{/strip}