{strip}
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>{const RAD_BC_TITLE}</title>
    {url file="jscss/admin.css" type="css" param="link"}
    {url file="jscss/components/windows/windows.css" type="css" param="link"}
    {url file="jscss/mootools-core-1.4.5-full-compat.js" type="js"}
    {url file="jscss/mootools-more-1.4.0.1.js" type="js"}
    
    {url file="jscss/components/windows/windows.js" type="js"}
    {url file="jscss/main.js" type="js"}
    <script language="JavaScript" type="text/javascript" src="{url href="alias=chlang&action=getJS"}"></script>
    <script language="JavaScript" type="text/javascript">
        var SITE_URL = '{const SITE_URL}';
        var SITE_ALIAS = '{const SITE_ALIAS}';
        var URL_SYSXML = '{url href="alias=SYSXML"}';
        var URL_LANGID = '{$_CURR_LANG_}';
    </script>
    {url file="jscss/components/tabernalogin.js" type="js"}
</head>
{/strip}