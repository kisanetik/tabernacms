<link rel="stylesheet" href="{const SITE_URL}/jscss/components/fileuploader/image_uploader.css" type="text/css">
{foreach $widgets as $widget}
    {if $widget.title}<p>{$widget.title}:</p>{/if}
    <div id="{$widget.widgetName}">
        <div class="upload_progress_bar">
            {lang code="-loading"}<br/>
            <img src="{const SITE_URL}jscss/components/fileuploader/loader.gif"/><br/>
        </div>
        <p class="upload_form">
            <input type="button" class="upload_button black-button" value="{lang code="-load"}"/>
        </p>
        <div id="{$widget.widgetName}_gallery" class="upload_gallery" style="width : 500px" class="upload_gallery">
            <ul>
                {foreach $widget.images as $imageId => $image name="img3DBin"}
                    <li class="upload_item">
                        <input type="hidden" value="{$image}" name="{$widget.namePrefix}{$widget.widgetName}[]">
                        <a target="_blank" href="{const SITE_URL}image.php?m={$widget.urlDir}&w=1600&h=1200&f={$image}">
                            <img alt="image #{$smarty.foreach.img3DBin.index}" src="{const SITE_URL}image.php?m={$widget.urlDir}&w=150&h=100&f={$image}">
                        </a>
                        <div style="clear: both;"></div>
                        <img src="{const SITE_URL}jscss/components/fileuploader/delete.png" class="upload_delete_trigger">
                    </li>
                {/foreach}
            </ul>
        </div>
    </div>
    <script type="text/javascript">
            {literal}
                    window.addEvent('domready', function() {
                        {/literal}{$widget.widgetName}{literal} = new FileUploader({
                            containerId : '{/literal}{$widget.widgetName}{literal}',
                            fieldPrefixName: '{/literal}{$widget.namePrefix}{literal}',
                            multiImage : {/literal}{if $widget.multiImages==true}true{else}false{/if}{literal},
                            urlDir : '{/literal}{$widget.urlDir}{literal}'
                        });
                    });
                    var {/literal}{$widget.widgetName}{literal} = null;
            {/literal}
    </script>
<div style="clear: both"></div>
{/foreach}