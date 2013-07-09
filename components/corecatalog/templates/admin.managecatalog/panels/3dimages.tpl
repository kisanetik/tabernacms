{strip}
{if !empty($items_3dbin)}
    {foreach $items_3dbin as $item}
        <hr />
        <div class="3ditem">
            <object type="application/x-shockwave-flash" data="{url file="3dbin/`$item->img_filename`" type="dfile" module="corecatalog"}" width="530" height="400" id="intro_swf_example" style="visibility: visible; ">
            </object>
            <br />
            <label>
                <input type="radio" name="main_3d_image" value="{$item->img_id}" {if $item->img_main} checked="checked"{/if} />
                &nbsp;
                {lang code='defaultimage.catalog.text' ucf=true}
            </label>
            <br />
            <label>
                <input type="checkbox" id="del_3dimg_{$item->img_id}" name="del_3dimg[{$item->img_id}]" />&nbsp;
                {lang code='deletethisimage.catalog.text' ucf=true}
            </label>
        </div>
    {/foreach}
{/if}
{/strip}