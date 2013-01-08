<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Frameset//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-frameset.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"
    xml:lang="en"
    lang="en"
    dir="ltr">
<body>
<script type="text/javascript" language="JavaScript" src="{const SITE_URL}jscss/main.js"></script>
<script language="JavaScript" value="text/javascript">
var ERROR_WRONG_EXTENSION = '{lang code="wrongextension.system.message" ucf=true}';
{literal}
function uploadImg()
{
    var fileext = '';
    fileext = fileExt(document.getElementById('lng_img').value);
    fileext = fileext.toLowerCase();
    switch(fileext){
        case '.jpg':
        case '.jpeg':
        case '.gif':
        case '.png':
        case '.ico':
        case '.bmp':
            document.getElementById('lng_formimage').submit();
            break;
        default:
            alert(ERROR_WRONG_EXTENSION);
            break;
    }
}
{/literal}
</script>
<form id="lng_formimage" method="post" enctype="multipart/form-data" action="{url href="action=uploadfile&id=`$id`"}">
<input type="hidden" name="lang_id" id="lang_id" value="{$id}">
<input type="file" id="lng_img" name="lng_img" value="" onchange="uploadImg();" /> 
</form>
{if isset($new_fn)}
<script language="JavaScript" value="text/javascript">
if(window.parent.$('lng_img_img')) {literal} { {/literal}
    window.parent.$('lng_img_img').src='{const SITE_URL}image.php?f={$new_fn}&w={$params->showimaxsize_x}&h={$params->showimaxsize_y}&m=lang';
	window.parent.$('sh_img').style.display='block';
	window.parent.$('lng_img_img').style.display='block';
{literal}
}
{/literal}
window.parent.$('divformimage').style.display='none';
</script>
{/if}
</body>
</html>