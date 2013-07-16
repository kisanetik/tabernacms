<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<!--
 * Page used to upload new files in the current folder.
-->
<html>
<head>
    <title>File Upload</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    {url module="core" file="wysiwyg/browser.css" type="css"}
    {url module="core" file="wysiwyg/js/common.js" type="js" load="sync"}
    {rad_jscss::getHeaderCode()}
<script type="text/javascript">{literal}

function SetCurrentFolder(resourceType, folderPath)
{
    var sUrl = oConnector.ConnectorUrl + 'Command/FileUpload/';
    sUrl += 'Type/' + resourceType + '/';
    sUrl += 'CurrentFolder/' + encodeURIComponent( folderPath.split('/').join(':') ) + '/';
    document.getElementById('frmUpload').action = sUrl ;
}

function OnSubmit()
{
    if ( document.getElementById('NewFile').value.length == 0 ) {
        alert( 'Please select a file from your computer' ) ;
        return false ;
    }
    // Set the interface elements.
    document.getElementById('eUploadMessage').innerHTML = 'Upload a new file in this folder (Upload in progress, please wait...)' ;
    document.getElementById('btnUpload').disabled = true ;
    return true;
}

function OnUploadCompleted( errorNumber, data )
{
    // Reset the Upload Worker Frame.
    window.parent.frames['frmUploadWorker'].location = 'javascript:void(0)' ;

    // Reset the upload form (On IE we must do a little trick to avoid problems).
    if ( document.all ) document.getElementById('NewFile').outerHTML = '<input id="NewFile" name="upload" style="WIDTH: 100%" type="file">' ;
    else document.getElementById('frmUpload').reset() ;

    // Reset the interface elements.
    document.getElementById('eUploadMessage').innerHTML = 'Upload a new file in this folder' ;
    document.getElementById('btnUpload').disabled = false ;

    switch (errorNumber) {
        case 0:
            window.parent.frames['frmResourcesList'].Refresh();
            break ;
        case 1: // Custom error.
            alert(data);
            break;
        case 201:
            window.parent.frames['frmResourcesList'].Refresh();
            alert( 'A file with the same name is already available. The uploaded file has been renamed to "' + data + '"' );
            break;
        case 202:
            alert('Invalid file');
            break;
        default:
            alert('Error on file upload. Error number: ' + errorNumber);
            break;
    }
}

window.onload = function() {
    window.top.IsLoadedUpload = true;
}
{/literal}</script>
</head>
<body>
<form id="frmUpload" action="" target="frmUploadWorker" method="post" enctype="multipart/form-data" onsubmit="return OnSubmit();">
	<table class="fullHeight" cellspacing="0" cellpadding="0" width="100%" border="0">
		<tr>
			<td nowrap="nowrap">
				<span id="eUploadMessage">Upload a new file in this folder</span><br>
				<table cellspacing="0" cellpadding="0" width="100%" border="0">
					<tr>
						<td width="100%"><input id="NewFile" name="upload" style="WIDTH: 100%" type="file"></td>
						<td nowrap="nowrap">&nbsp;<input id="btnUpload" type="submit" value="Upload"></td>
					</tr>
				</table>
			</td>
		</tr>
	</table>
</form>
</body>
</html>