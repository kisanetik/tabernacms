{strip}
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>{const RAD_BC_TITLE}</title>

    {url module="coreframing" file="admin.css" type="css"}
    {url module="coreframing" file="windows/windows.css" type="css"}
    {url module="coreframing" file="mootools-core-1.4.5-full-compat.js" type="js"}
    {url module="coreframing" file="mootools-more-1.4.0.1.js" type="js"}

    {url module="coreframing" file="windows/windows.js" type="js"}
    {url module="core" file="main.js" type="js"}
    {url module="coreframing" href="alias=chlang&action=getJS" type="js"}
    <script language="JavaScript" type="text/javascript">
        var SITE_URL = '{const SITE_URL}';
        var SITE_ALIAS = '{const SITE_ALIAS}';
        var URL_SYSXML = '{url href="alias=SYSXML"}';
        var URL_LANGID = '{$_CURR_LANG_}';
    </script>
    {url module="coreframing" file="tabernalogin.js" type="js"}
    {rad_jscss::getHeaderCode()}
</head>
<body>
  <div id="global_div">
    <table id="main">
        <tr>
            <td class="main">
                <div id="main_inn">
                    <table class="main_tbl">
                    {if isset($top)}
                        <tr>
                            <td class="header">
                                {$top}
                            </td>
                        </tr>
                    {/if}
                        <tr>
                            <td class="center" id="center_wrap_parent">
                                {if isset($center)}
                                <div class="wrap" id="center_wrap">
                                    <div class="right_col" id="center_right_col">
                                        {$center}
                                    </div>
                                </div>
                                {/if}
                                {if isset($left)}
                                <div class="left_col" id="left_menu_wrapper">
                                    {$left}
                                </div>
                                {/if}
                                <div class="clear"></div>
                                <div class="clear_footer"></div>
                            </td>
                        </tr>
                    </table>
                </div>
            </td>
        </tr>
    </table>
  </div>
  <div class="footer">
    {if isset($bottom)}
        {$bottom}
    {/if}
  </div>
</body>
{if isset($footer)}{$footer}{/if}
{/strip}