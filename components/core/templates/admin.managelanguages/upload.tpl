<!DOCTYPE html>
<html>
    <head>
        <script type="text/javascript">
    
        var ERROR_WRONG_EXTENSION = '{lang code="wrongextension.menus.message"}',
            UPLOADED_FILENAME     = '{if isset($new_fn)}{$new_fn}{/if}';
    
        {literal}
        function uploadTreeImg()
        {
            var fileext = '';
            fileext = fileExt(document.getElementById('lng_image').value);
            fileext = fileext.toLowerCase();
            switch (fileext) {
                case '.jpg':
                case '.jpeg':
                case '.gif':
                case '.png':
                case '.ico':
                case '.bmp':
                    document.getElementById('lang_upload_form').submit();
                    break;
                default:
                    alert(ERROR_WRONG_EXTENSION);
                    break;
            }
        }
        if (UPLOADED_FILENAME.length > 0) {
            window.parent.RADLangPropertiesPanel.setImage(UPLOADED_FILENAME);
            window.parent.RADLanguagesPanel.setFlag(UPLOADED_FILENAME);
        }
        {/literal}
        </script>
        {url module="core" file="main.js" type="js"}
        {rad_jscss::getHeaderCode()}
    </head>
    <body>
        <form id="lang_upload_form" method="post" enctype="multipart/form-data">
            <input  type="file" id="lng_image" name="lng_image" onchange="uploadTreeImg()" size="60" style="width: 100%" /> 
            <input  type="hidden" id="lng_id" name="lng_id" value="{$lng_id}" />
        </form>
    </body>
</html>
