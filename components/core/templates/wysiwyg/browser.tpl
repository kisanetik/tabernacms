<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Frameset//EN"
   "http://www.w3.org/TR/html4/frameset.dtd">
<!--
 * This page compose the File Browser dialog frameset.
-->
<html>
    <head>
        <title>Resources Browser</title>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        {url module="core" file="wysiwyg/browser.css" type="css"}
        {url module="core" file="wysiwyg/js/fckxml.js" type="js" load="sync"}
        {rad_jscss::getHeaderCode()}
        <script type="text/javascript">
var ICONS_FILES = [
    ['ai', '{url module="core" file="wysiwyg/icons/ai.gif" preset="original" type="image"}'],
    ['avi', '{url module="core" file="wysiwyg/icons/avi.gif" preset="original" type="image"}'],
    ['bmp', '{url module="core" file="wysiwyg/icons/bmp.gif" preset="original" type="image"}'],
    ['cs', '{url module="core" file="wysiwyg/icons/cs.gif" preset="original" type="image"}'],
    ['dll', '{url module="core" file="wysiwyg/icons/dll.gif" preset="original" type="image"}'],
    ['doc,docx', '{url module="core" file="wysiwyg/icons/doc.gif" preset="original" type="image"}'],
    ['exe', '{url module="core" file="wysiwyg/icons/exe.gif" preset="original" type="image"}'],
    ['fla', '{url module="core" file="wysiwyg/icons/fla.gif" preset="original" type="image"}'],
    ['gif', '{url module="core" file="wysiwyg/icons/gif.gif" preset="original" type="image"}'],
    ['htm,html', '{url module="core" file="wysiwyg/icons/htm.gif" preset="original" type="image"}'],
    ['jpg,jpeg', '{url module="core" file="wysiwyg/icons/jpg.gif" preset="original" type="image"}'],
    ['js', '{url module="core" file="wysiwyg/icons/js.gif" preset="original" type="image"}'],
    ['mdb', '{url module="core" file="wysiwyg/icons/mdb.gif" preset="original" type="image"}'],
    ['mp3', '{url module="core" file="wysiwyg/icons/mp3.gif" preset="original" type="image"}'],
    ['pdf', '{url module="core" file="wysiwyg/icons/pdf.gif" preset="original" type="image"}'],
    ['png', '{url module="core" file="wysiwyg/icons/png.gif" preset="original" type="image"}'],
    ['ppt', '{url module="core" file="wysiwyg/icons/ppt.gif" preset="original" type="image"}'],
    ['rdp', '{url module="core" file="wysiwyg/icons/rdp.gif" preset="original" type="image"}'],
    ['swf', '{url module="core" file="wysiwyg/icons/swf.gif" preset="original" type="image"}'],
    ['swt', '{url module="core" file="wysiwyg/icons/swt.gif" preset="original" type="image"}'],
    ['txt', '{url module="core" file="wysiwyg/icons/txt.gif" preset="original" type="image"}'],
    ['vsd', '{url module="core" file="wysiwyg/icons/vsd.gif" preset="original" type="image"}'],
    ['xls,xlsx', '{url module="core" file="wysiwyg/icons/xls.gif" preset="original" type="image"}'],
    ['xml', '{url module="core" file="wysiwyg/icons/xml.gif" preset="original" type="image"}'],
    ['zip', '{url module="core" file="wysiwyg/icons/zip.gif" preset="original" type="image"}']
];
var DEFAULT_ICON = '{url module="core" file="wysiwyg/icons/default.gif" preset="original" type="image"}';
{literal}
// Automatically detect the correct document.domain (#1919).
(function()
{
    var d = document.domain ;

    while ( true )
    {
        // Test if we can access a parent property.
        try
        {
            var test = window.opener.document.domain ;
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

function GetUrlParam( paramName )
{
    var oRegex = new RegExp( '[\?&]' + paramName + '=([^&]+)', 'i' ) ;
    var oMatch = oRegex.exec( window.top.location.search ) ;

    if ( oMatch && oMatch.length > 1 )
        return decodeURIComponent( oMatch[1] ) ;
    else
        return '' ;
}

function OpenFile( fileUrl )
{
    if (window.opener.CKEDITOR) {
        window.opener.CKEDITOR.tools.callFunction(GetUrlParam('CKEditorFuncNum'), fileUrl, '');
        window.close();
        window.opener.focus();
    }
}

var oConnector = new Object() ;
oConnector.CurrentFolder    = '/' ;

var sConnUrl = GetUrlParam( 'Connector' ) ;

oConnector.ConnectorUrl = '{/literal}{url href="action=browse"}{literal}';//sConnUrl + ( sConnUrl.indexOf('?') != -1 ? '&' : '?' ) ;

var sServerPath = GetUrlParam( 'ServerPath' ) ;
if ( sServerPath.length > 0 )
    oConnector.ConnectorUrl += 'ServerPath/' + encodeURIComponent( sServerPath ) + '/' ;

oConnector.ResourceType        = GetUrlParam( 'Type' ) ;
oConnector.ShowAllTypes        = ( oConnector.ResourceType.length == 0 ) ;

if ( oConnector.ShowAllTypes )
    oConnector.ResourceType = 'File' ;

oConnector.SendCommand = function( command, params, callBackFunction )
{
    var sUrl = this.ConnectorUrl + 'Command/' + command + '/';
    sUrl += 'Type/' + this.ResourceType + '/';
    sUrl += 'CurrentFolder/' + encodeURIComponent( this.CurrentFolder.split('/').join(':') ) + '/';

    if ( params ) sUrl += params;

    // Add a random salt to avoid getting a cached version of the command execution
    sUrl += 'uuid/' + new Date().getTime() + '/';

    var oXML = new FCKXml() ;

    if ( callBackFunction )
        oXML.LoadUrl( sUrl, callBackFunction ) ;    // Asynchronous load.
    else
        return oXML.LoadUrl( sUrl ) ;

    return null ;
}

oConnector.CheckError = function( responseXml )
{
    var iErrorNumber = 0 ;
    var oErrorNode = responseXml.SelectSingleNode( 'Connector/Error' ) ;

    if ( oErrorNode )
    {
        iErrorNumber = parseInt( oErrorNode.attributes.getNamedItem('number').value, 10 ) ;

        switch ( iErrorNumber )
        {
            case 0 :
                break ;
            case 1 :    // Custom error. Message placed in the "text" attribute.
                alert( oErrorNode.attributes.getNamedItem('text').value ) ;
                break ;
            case 101 :
                alert( 'Folder already exists' ) ;
                break ;
            case 102 :
                alert( 'Invalid folder name' ) ;
                break ;
            case 103 :
                alert( 'You have no permissions to create the folder' ) ;
                break ;
            case 110 :
                alert( 'Unknown error creating folder' ) ;
                break ;
            default :
                alert( 'Error on your request. Error number: ' + iErrorNumber ) ;
                break ;
        }
    }
    return iErrorNumber ;
}

var oIcons = new Object() ;
oIcons.AvailableIcons = new Object() ;

for (var i=0; i<ICONS_FILES.length ; i++) {
    var icon = ICONS_FILES[i];
    var icon_ext = icon[0].split(',');
    for (var j=0; j<icon_ext.length ; j++) {
        oIcons.AvailableIcons[ icon_ext[j] ] = icon[1];
    }
}

oIcons.GetIcon = function( fileName )
{
    var sExtension = fileName.substr( fileName.lastIndexOf('.') + 1 ).toLowerCase() ;

    if (this.AvailableIcons[ sExtension ])
        return this.AvailableIcons[ sExtension ];
    else
        return DEFAULT_ICON;
}

function OnUploadCompleted( errorNumber, fileUrl, fileName, customMsg )
{
    if (errorNumber == "1")
        window.frames['frmUpload'].OnUploadCompleted( errorNumber, customMsg ) ;
    else
        window.frames['frmUpload'].OnUploadCompleted( errorNumber, fileName ) ;
}
</script>{/literal}
</head>
    <frameset cols="150,*" class="Frame" framespacing="3" bordercolor="#f1f1e3" frameborder="1">
        <frameset rows="50,*" framespacing="0">
            <frame src="{url href="action=frmresourcetype"}" scrolling="no" frameborder="0">
            <frame name="frmFolders" src="{url href="action=frmfolders"}" scrolling="auto" frameborder="1">
        </frameset>
        <frameset rows="50,*,50" framespacing="0">
            <frame name="frmActualFolder" src="{url href="action=frmactualfolder"}" scrolling="no" frameborder="0">
            <frame name="frmResourcesList" src="{url href="action=frmresourceslist"}" scrolling="auto" frameborder="1">
            <frameset cols="150,*,0" framespacing="0" frameborder="0">
                <frame name="frmCreateFolder" src="{url href="action=frmcreatefolder"}" scrolling="no" frameborder="0">
                <frame name="frmUpload" src="{url href="action=frmupload"}" scrolling="no" frameborder="0">
                <frame name="frmUploadWorker" src="javascript:void(0)" scrolling="no" frameborder="0">
            </frameset>
        </frameset>
    </frameset>
</html>