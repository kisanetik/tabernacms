{strip}
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd"> 
<html xmlns="http://www.w3.org/1999/xhtml"> 
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" /> 
    <title>{rad_breadcrumbs::getTitle()}</title>
    <META NAME="ROBOTS" CONTENT="INDEX,FOLLOW">
    <META NAME="revisit-after" CONTENT="1 days">
    <META name="description" content="{rad_breadcrumbs::getMetaDescription()}">
    <META name="keywords" content="{rad_breadcrumbs::getMetaTags()}">
    <link rel="canonical" href="{url href="{rad_input::allGetToURLString()}" canonical=true}"/>
    <script language="JavaScript" type="text/javascript">
        var SITE_URL = '{const SITE_URL}';
        var SITE_ALIAS = '{const SITE_ALIAS}';
        var URL_SYSXML = '{url href="alias=SYSXML"}';
        var URL_LANGID = '{$_CURR_LANG_}';
    </script>
    {url module="core" file="jquery/jquery.js" type="js" load="sync"}
    {url module="core" file="des/product.js" type="js" load="sync"}
    {url module="corecatalog" file="radbin.js" type="js" load="sync"}
    {url module="core" file="des/style.css" type="css"}
    {rad_jscss::getHeaderCode()}
</head>
<body>
    {if !empty($header)}{$header}{/if}
    {if !empty($top)}{$top}{/if}
    <div class="lpart">
        {if !empty($left)}{$left}{/if}
    </div>
    <div class="rpart">
        {if !empty($center)}{$center}{/if}
    </div>
    <div class="linesold"></div>
    {if !empty($bottom)}{$bottom}{/if}
    {if !empty($footer)}{$footer}{/if}
</body>
</html>
{/strip}