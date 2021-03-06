{strip}
{capture assign="current_tre_url"}alias={const SITE_ALIAS}{/capture}
{if !isset($subnode)}
<div class="top_menu" id="div_top_menu" style="z-index:10;">
    <ul id="top_menu">
    {foreach from=$items item=item}
        <li class="razd_li"></li>
        <li>
            <div{if strlen($item->tre_url)} onclick="location='{const SITE_URL}{$item->tre_url}';"{/if}>
                <a href="{if strlen($item->tre_url)}{url href="`$item->tre_url`"}{else}#{/if}">{$item->tre_name}</a>
            </div>
                {if isset($item->child) and is_array($item->child) and count($item->child)}
                    {include file="$_CURRENT_LOAD_PATH/admin.topomenu.tpl" subnode=1 items=$item->child}
                {/if}
        </li>
    {/foreach}
    {if count($langs)}
        {if (count($langs_interface) > 0)}
            {foreach from=$langs_interface item="lng" key=lang_key}
            <li style="float:right;margin-right:0px;" class="lang_item">
                    <a href="{url href="alias=chlang&lang=`$lng->lng_code`"}" title="{$lng->lng_name}">
                        {if !empty($lng->lng_img)}
                            <img src="{url module="core" file="lang/`$lng->lng_img`" type="image" preset="language_medium"}" alt="{$lng->lng_name}" title=""/>
                            <span>{$lng->lng_name}</span>
                        {else}
                            {$lng->lng_code}
                        {/if}
                    </a>
                </li>
            {/foreach}
        {/if}
        <li style="float:right;margin-right:120px;">
            <div>
                <a href="javascript://">{lang code='contentlang.session.menu' ucf=true}</a>
            </div>
            <div class="cont" style="margin:0px;">
                <ul>
                    <li>
                        <table cellpadding="0" cellspacing="0" border="0" id="cont_langs_table">
                        {foreach from=$langs item=lng}
                            <tr{if $lng->lng_id eq $contentLngId} class="current"{/if}>
                                <td class="td_icon">
                                    {if !empty($lng->lng_img)}
                                        <img src="{url module="core" file="lang/`$lng->lng_img`" type="image" preset="language_tiny"}" border="0" />
                                    {/if}
                                </td>
                                <td nowrap="nowrap" id="td_txt_lang">
                                    {if $lng->lng_id eq $contentLngId}
                                        <a style="display:none;color:#376872;" id="lngcont_href_{$lng->lng_id}" href="javascript:RADCHLangs.changeContent({$lng->lng_id},'{$lng->lng_code}');">{$lng->lng_name}</a>
                                        <span id="lngcont_{$lng->lng_id}"><a name="lngcont_{$lng->lng_id}">{$lng->lng_name}</a></span>
                                    {else}
                                        <span style="display:none;color:#376872;" id="lngcont_{$lng->lng_id}"><a name="lngcont_{$lng->lng_id}">{$lng->lng_name}</a></span>
                                        <a id="lngcont_href_{$lng->lng_id}" href="javascript:RADCHLangs.changeContent({$lng->lng_id},'{$lng->lng_code}');">{$lng->lng_name}</a>
                                    {/if}
                                </td>
                            </tr>
                            {/foreach}
                        </table>
                    </li>
                </ul>
            </div>
        </li>
    {/if}
    </ul>
</div>
<!--[if IE]><script type="text/javascript">startList();</script><![endif]-->
<div class="logo">
    <a href="{url href="alias=admin"}">
        <img src="{url type="image" module="core" preset="original" file="backend/logo.png"}" width="99" height="45" border="0" alt="logo" title="{lang code="taberna_slogan.site.title" ucf=true}" />
    </a>
</div>
<div class="top_cn">
    <div class="opt_menu">
        <table><tbody>
            <tr>
                <td>
                    <a class="help" target="_blank" href="http://wiki.tabernacms.com"><span>{lang code='-help' ucf=true}</span></a>
                </td>
                <td id="taberna_user_menu_td">
                    <a class="tabernalogin" href="#" onclick="tabernalogin.loginWindow();">
                        <span>{lang code="authorize.session.link" ucf=true}</span>
                    </a>
                </td>
                <td class="exit_opt">
                    <a class="logout" href="{url href="alias=login&logout=true"}"><span>{lang code="-exit" ucf=true}</span></a>
                </td>
            </tr>
        </tbody></table>
    </div>
</div>
{else}
    <div class="cont" style="margin:0px;">
        <ul>
            <li>
                <table cellpadding="0" cellspacing="0" border="0">
                    {foreach from=$items item=item}
                        <tr {if strlen($item->tre_url)} {/if} id="tr_top_{$item->tre_id}" {if $current_tre_url eq $item->tre_url}class="current"{/if}>
                            <td class="td_icon" id="td_ico_{$item->tre_id}">
                                <a href="{if strlen($item->tre_url)}{url href="`$item->tre_url`"}{else}#{/if}">
                                    {if !empty($item->tre_image_menu)}
                                        <img src="{url module="coremenus" file="`$item->tre_image_menu`" type="image" preset="productstree"}" alt="{$item->tre_name}" width="16" height="16" border="0" />
                                    {elseif !empty($item->tre_image)}
                                        <img src="{url module="coremenus" file="`$item->tre_image`" type="image" preset="productstree"}" alt="{$item->tre_name}" width="16" height="16" border="0" />
                                    {else}
                                        <img src="{url module="core" file="backend/icons/icon_1.png" type="image" preset="productstree"}" alt="{$item->tre_name}" width="16" height="16" border="0" />
                                    {/if}
                                </a>
                            </td>
                            <td nowrap="nowrap" id="td_txt_{$item->tre_id}">
                                <a href="{if strlen($item->tre_url)}{url href="`$item->tre_url`"}{else}#{/if}">{$item->tre_name}</a>{if isset($item->child) and is_array($item->child) and count($item->child)}{include file="$_CURRENT_LOAD_PATH/admin.topomenu.tpl" subnode=1 items=$item->child}{/if}
                            </td>
                        </tr>
                    {/foreach}
                </table>
            </li>
        </ul>
    </div>
{/if}
{/strip}
