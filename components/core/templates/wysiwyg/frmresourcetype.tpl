<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<!--
 * This page shows the list of available resource types.
-->
<html>
    <head>
        <title>Available types</title>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        {url module="core" file="wysiwyg/browser.css" type="css"}
        {url module="core" file="wysiwyg/js/common.js" type="js" load="sync"}
        {rad_jscss::getHeaderCode()}
        <script type="text/javascript">{literal}

function SetResourceType( type )
{
    window.parent.frames["frmFolders"].SetResourceType( type ) ;
}

var aTypes = [
    ['File','File'],
    ['Image','Image'],
    ['Flash','Flash'],
    ['Media','Media']
] ;

window.onload = function()
{
    var oCombo = document.getElementById('cmbType') ;
    oCombo.innerHTML = '' ;
    for ( var i = 0 ; i < aTypes.length ; i++ )
    {
        if ( oConnector.ShowAllTypes || aTypes[i][0] == oConnector.ResourceType )
            AddSelectOption( oCombo, aTypes[i][1], aTypes[i][0] ) ;
    }
}

{/literal}</script>
    </head>
    <body>
        <table class="fullHeight" cellSpacing="0" cellPadding="0" width="100%" border="0">
            <tr>
                <td nowrap>
                    Resource Type<BR>
                    <select id="cmbType" style="WIDTH: 100%" onchange="SetResourceType(this.value);">
                        <option>&nbsp;
                    </select>
                </td>
            </tr>
        </table>
    </body>
</html>