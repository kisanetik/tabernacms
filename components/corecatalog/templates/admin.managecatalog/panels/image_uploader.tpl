{url type="js" module="core" file="fileuploader/image_uploader.css"}
{foreach $widgets as $widget}
    {if $widget.title}<p>{$widget.title}:</p>{/if}
    <div id="{$widget.widgetName}">
        <div class="upload_progress_bar">
            {lang code="-loading"}<br/>
            <img src="{url type="image" preset="original" module="core" file="fileuploader/loader.gif"}"/><br/>
        </div>
        <p class="upload_form">
            <input type="button" class="upload_button black-button" value="{lang code="-load"}"/>
        </p>
        <div id="{$widget.widgetName}_gallery" class="upload_gallery" style="width : 500px" class="upload_gallery">
            <ul>
                {foreach $widget.images as $imageId => $image name="img3DBin"}
                    <li class="upload_item">
                        <input type="hidden" value="{$image}" name="{$widget.namePrefix}{$widget.widgetName}[]">
                        <a target="_blank" href="{url module="corecatalog" file="`$image`" type="image" preset="box_large"}">
                            <img alt="image #{$smarty.foreach.img3DBin.index}" src="{url module="corecatalog" file="`$image`" type="image" preset="box_large"}">
                        </a>
                        <div style="clear: both;"></div>
                        <img src="{url type="image" preset="original" module="core" file="fileuploader/delete.png"}" class="upload_delete_trigger">
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