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
    {if isset($header)}{$header}{/if}
    {if isset($top)}{$top}{/if}
    {if isset($center)}{$center}{/if}
</div>
<div class="footer">
    {if isset($bottom)}{$bottom}{/if}
</div>
{if isset($footer)}{$footer}{/if}
</body>
</html>
{/strip}