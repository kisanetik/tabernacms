<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<!--
 * This page shows all resources available in a folder in the File Browser.
-->
<html>
<head>
    <title>Resources</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    {url module="core" file="wysiwyg/browser.css" type="css"}
    {url module="core" file="wysiwyg/js/common.js" type="js" load="sync"}
    {rad_jscss::getHeaderCode()}
    <script type="text/javascript">
var IMAGE_FOLDER = '{url module="core" file="wysiwyg/folder.gif" preset="original" type="image"}';

{literal}

var oListManager = new Object() ;

oListManager.Clear = function()
{
    document.body.innerHTML = '' ;
}

function ProtectPath(path)
{
    path = path.replace( /\\/g, '\\\\') ;
    path = path.replace( /'/g, '\\\'') ;
    return path ;
}

oListManager.GetFolderRowHtml = function( folderName, folderPath )
{
    // Build the link to view the folder.
    var sLink = '<a href="#" onclick="OpenFolder(\'' + ProtectPath( folderPath ) + '\');return false;">' ;

    return '<tr>' +
            '<td width="16">' +
                sLink +
                '<img alt="" src="'+ IMAGE_FOLDER + '" width="16" height="16" border="0"><\/a>' +
            '<\/td><td nowrap colspan="2">&nbsp;' +
                sLink +
                folderName +
                '<\/a>' +
        '<\/td><\/tr>' ;
}

oListManager.GetFileRowHtml = function( fileName, fileUrl, fileSize )
{
    // Build the link to view the folder.
    var sLink = '<a href="#" onclick="OpenFile(\'' + ProtectPath( fileUrl ) + '\');return false;">' ;

    // Get the file icon.
    var sIcon = oIcons.GetIcon( fileName ) ;

    return '<tr>' +
            '<td width="16">' +
                sLink +
                '<img alt="" src="' + sIcon + '" width="16" height="16" border="0"><\/a>' +
            '<\/td><td>&nbsp;' +
                sLink +
                fileName +
                '<\/a>' +
            '<\/td><td align="right" nowrap>&nbsp;' +
                fileSize +
                ' KB' +
        '<\/td><\/tr>' ;
}

function OpenFolder( folderPath )
{
    // Load the resources list for this folder.
    window.parent.frames['frmFolders'].LoadFolders( folderPath ) ;
}

function OpenFile( fileUrl )
{
    window.parent.OpenFile(fileUrl);
}

function LoadResources( resourceType, folderPath )
{
    oListManager.Clear() ;
    oConnector.ResourceType = resourceType ;
    oConnector.CurrentFolder = folderPath ;
    oConnector.SendCommand( 'GetFoldersAndFiles', null, GetFoldersAndFilesCallBack ) ;
}

function Refresh()
{
    LoadResources( oConnector.ResourceType, oConnector.CurrentFolder ) ;
}

function GetFoldersAndFilesCallBack( fckXml )
{
    if ( oConnector.CheckError( fckXml ) != 0 )
        return ;

    // Get the current folder path.
    var oFolderNode = fckXml.SelectSingleNode( 'Connector/CurrentFolder' ) ;
    if ( oFolderNode == null )
    {
        alert( 'The server didn\'t reply with a proper XML data. Please check your configuration.' ) ;
        return ;
    }
    var sCurrentFolderPath    = oFolderNode.attributes.getNamedItem('path').value ;
    var sCurrentFolderUrl    = oFolderNode.attributes.getNamedItem('url').value ;

//    var dTimer = new Date() ;

    var oHtml = new StringBuilder( '<table id="tableFiles" cellspacing="1" cellpadding="0" width="100%" border="0">' ) ;

    // Add the Folders.
    var oNodes ;
    oNodes = fckXml.SelectNodes( 'Connector/Folders/Folder' ) ;
    for ( var i = 0 ; i < oNodes.length ; i++ )
    {
        var sFolderName = oNodes[i].attributes.getNamedItem('name').value ;
        oHtml.Append( oListManager.GetFolderRowHtml( sFolderName, sCurrentFolderPath + sFolderName + "/" ) ) ;
    }

    // Add the Files.
    oNodes = fckXml.SelectNodes( 'Connector/Files/File' ) ;
    for ( var j = 0 ; j < oNodes.length ; j++ )
    {
        var oNode = oNodes[j] ;
        var sFileName = oNode.attributes.getNamedItem('name').value ;
        var sFileSize = oNode.attributes.getNamedItem('size').value ;

        // Get the optional "url" attribute. If not available, build the url.
        var oFileUrlAtt = oNodes[j].attributes.getNamedItem('url') ;
        var sFileUrl = oFileUrlAtt != null ? oFileUrlAtt.value : sCurrentFolderUrl + sFileName ;

        oHtml.Append( oListManager.GetFileRowHtml( sFileName, sFileUrl, sFileSize ) ) ;
    }

    oHtml.Append( '<\/table>' ) ;

    document.body.innerHTML = oHtml.ToString() ;

//    window.top.document.title = 'Finished processing in ' + ( ( ( new Date() ) - dTimer ) / 1000 ) + ' seconds' ;

}

window.onload = function()
{
    window.top.IsLoadedResourcesList = true;
}
{/literal}</script>
</head>
<body class="FileArea">
</body>
</html>