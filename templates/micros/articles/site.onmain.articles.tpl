{strip}
<div class="articles_onmain_block">
{foreach from=$items item="tree" name="category"}
    <div class="articles_group">
        <div class="articles_group_title"><a href="#">{$tree->tre_name}</a></div>
        {foreach from=$tree->articles item="article"}
        <div class="articles_item">
            <div class="image_box">
                <a href="{url href="alias=articles&a=`$article->art_id`"}">
                    <img alt="" src="{const SITE_URL}image.php?f={$article->art_img}&m=articles&w=80&h=80"/>
                </a>
            </div>
            <div class="text_box">
                <a href="{url href="alias=articles&a=`$article->art_id`"}">{$article->art_title}</a>{$article->art_shortdesc}
            </div>
            <div class="clear"></div>
        </div>
        {/foreach}
    </div>
{if ($smarty.foreach.category.index mod 2) ne 0}<div class="clear"></div>{/if}
{/foreach}
</div>
{/strip}