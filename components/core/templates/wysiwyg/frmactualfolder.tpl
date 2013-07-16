<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<!--
 * This page shows the actual folder path.
-->
<html>
    <head>
        <title>Folder path</title>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        {url module="core" file="wysiwyg/browser.css" type="css"}
        {rad_jscss::getHeaderCode()}
        <script type="text/javascript">{literal}
// Automatically detect the correct document.domain (#1919).
(function()
{
    var d = document.domain ;

    while ( true )
    {
        // Test if we can access a parent property.
        try
        {
            var test = window.top.opener.document.domain ;
            break ;
        }
        catch( e )
        {}

        // Remove a domain part: www.mytest.example.com => mytest.example.com => example.com ...
        d = d.replace( /.*?(?:\.|$)/, '' ) ;

        if ( d.length == 0 )
            break ;        // It was not able to detect the domain.

        try
        {
            document.domain = d ;
        }
        catch (e)
        {
            break ;
        }
    }
})() ;

function SetCurrentFolder( resourceType, folderPath )
{
    document.getElementById('tdName').innerHTML = folderPath ;
}

window.onload = function()
{
    window.top.IsLoadedActualFolder = true ;
}

{/literal}</script>
    </head>
    <body>
        <table class="fullHeight" cellSpacing="0" cellPadding="0" width="100%" border="0">
            <tr>
                <td>
                    <button style="WIDTH: 100%" type="button">
                        <table cellSpacing="0" cellPadding="0" width="100%" border="0">
                            <tr>
                                <td><img height="32" alt="" src="{url module="core" file="wysiwyg/folderopened32.gif" preset="original" type="image"}" width="32"></td>
                                <td>&nbsp;</td>
                                <td id="tdName" width="100%" nowrap class="ActualFolder">/</td>
                                <td>&nbsp;</td>
                                <td><img height="8" src="{url module="core" file="wysiwyg/arrow.gif" preset="original" type="image"}" width="12" alt=""></td>
                                <td>&nbsp;</td>
                            </tr>
                        </table>
                    </button>
                </td>
            </tr>
        </table>
    </body>
</html>