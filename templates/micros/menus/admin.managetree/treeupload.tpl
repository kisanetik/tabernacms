<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Frameset//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-frameset.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"
    xml:lang="en"
    lang="en"
    dir="ltr">
<body>
<script type="text/javascript" src="{const SITE_URL}jscss/main.js"></script>
<script type="text/javascript">
var ERROR_WRONG_EXTENSION = '{lang code="wrongextension.menus.message"}';
{literal}
function uploadTreeImg()
{
    var fileext = '';
    fileext = fileExt(document.getElementById('tree_image').value);
    fileext = fileext.toLowerCase();
    switch(fileext){
        case '.jpg':
        case '.jpeg':
        case '.gif':
        case '.png':
        case '.ico':
        case '.bmp':
            document.getElementById('tree_formimage').submit();
            break;
        default:
            alert(ERROR_WRONG_EXTENSION);
            break;
    }
}
{/literal}
</script>
<form id="tree_formimage" method="post" enctype="multipart/form-data" action="{const SITE_URL}index.php?alias={const SITE_ALIAS}&action=uploadfile&id={$id}">
<input type="hidden" name="tree_id" id="tree_id" value="{$id}">
<input type="file" id="tree_image" name="tree_image" value="" onchange="uploadTreeImg();" /> 
</form>
{if isset($uploaded)}
<script type="text/javascript">
{if strlen($new_fn)}
if(window.parent.$('tree_img')) {literal} { {/literal}
    window.parent.$('tree_img').src='{const SITE_URL}image.php?m=menu&w=350&h=100&f={$new_fn}';
{literal}
}else{
{/literal}
    var s= '<img src="{const SITE_URL}image.php?m=menu&w=350&h=100&f={$new_fn}" border="0" />';
    s+= '<input type="checkbox" id="tre_image" /><label for="tre_image">{lang code="deleteimage.menus.text"}</label><br />';
    s+= '<a href="javascript: showTreeUploadFrame();">{lang code="changeimage.menus.link"}</a>';
    window.parent.$('img_container').innerHTML = s;
{literal} } {/literal}
window.parent.$('tree_divformimage').style.display='none';
{/if}
</script>
{/if}
</body>
</html>