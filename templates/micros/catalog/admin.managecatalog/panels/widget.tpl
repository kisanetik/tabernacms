{foreach $widgets as $widget}
    <form id="{$widget.widgetName}_form" action="{url href="action={$widget.uploadAction}"}" method="post" style="visibility:hidden" enctype="multipart/form-data"
          target="{$widget.widgetName}" >
        <input type="hidden" name="uiName" value="{$widget.widgetName}"/>
        {if isset($token)}<input type="hidden" name="token" value="{$token}"/>{/if}
        <input class="upload_file_field" id="file_field_{$widget.widgetName}" style="" multiple="true" name="uploadFile" type="file" size="30"/>
        <input name="fileName" type="hidden" value=""/>
        <input name="filePathForSave" type="hidden" value="{$widget.filePathForSave}"/>
        <input name="fileType" type="hidden" value=""/>
        <iframe class="upload_transfer" name="{$widget.widgetName}" src="#"></iframe>
    </form>
    {if count($widget.images)}
        {literal}
        <script type="text/javascript">
                window.addEvent('domready', function() {
        {/literal}{$widget.widgetName}{literal}.init();
    });
    </script>
    {/literal}
    {/if}
{/foreach}