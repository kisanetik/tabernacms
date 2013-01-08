{strip}
{capture name="paginator" assign="paginator"}
    <table width="100%" cellpadding="0" cellspacing="0" border="0">
    <tr>
        <td class="on_page" width="35%">
            {lang code="showrowsperpage.text"}:
            {jsencode noencode=true}
                {if $itemsPerPage eq 10}<font class="pages_active">10</font>{else}<a href="{url href="c=$pid&i=10"}">10</a>{/if}&nbsp;|&nbsp;
                {if $itemsPerPage eq 20}<font class="pages_active">20</font>{else}<a href="{url href="c=$pid&i=20"}">20</a>{/if}&nbsp;|&nbsp;
                {if $itemsPerPage eq 50}<font class="pages_active">50</font>{else}<a href="{url href="c=$pid&i=50"}">50</a>{/if}&nbsp;|&nbsp;
                {if $itemsPerPage eq 100}<font class="pages_active">100</font>{else}<a href="{url href="c=$pid&i=100"}">100</a>{/if}
            {/jsencode}
        </td>
        <td class="pages" width="65%">
            {lang code="pages.articles.text"}:
            {if isset($pid)}{assign var=gp value="c=$pid"}{else}{assign var=gp value=""}{/if}
            {if isset($itemsPerPage)}{assign var=gp value="$gp&i=$itemsPerPage"}{/if}
            {jsencode noencode=true}
                {paginator from=0 to=$pages_count curpage=$page-1 GET="$gp" page_varname="pg" prev_title_text='<' first_title_text='<<' next_title_text='>' last_title_text='>>' showsteps=true showlast=true showfirst=true show_long_listing=true}
            {/jsencode}

            {lang code="totalpages.articles.text" ucf=true}:
            <font class="pages_active">{$pages_count-1}</font>&nbsp;|&nbsp;
            {lang code="totalrows.resource.text" ucf=true}:
            <font class="pages_active">{$items_count}</font>
        </td>
    </tr>
    </table>
{/capture}
<div class="blueArea">
    <div class="blueAreaTopLeft">
        <div class="blueAreaTopRight">
            <div class="blueAreaBottomLeft">
                <div class="blueAreaBottomRight">
                    <div class="buttonsArea">
                        <span class="title">
                            {lang code="articles.articles.title" ucf=true}
                        </span>
                    </div>
                    <div class="whiteOnBlueAreaTopLeft">
                        <div class="whiteOnBlueAreaTopRight">
                            <div class="whiteOnBlueAreaBottomLeft">
                                <div class="whiteOnBlueAreaBottomRight padd5">
                                    <ul class="witems article_list">
                                        {foreach from=$items item=article name=article_a}
                                            <li>
                                                {if isset($article->art_img) and strlen($article->art_img) > 0}
                                                <div class="article_image">
                                                    <a title="{$article->art_title}" href="{url href="t=`$article->art_title|@urlencode`&a=`$article->art_id`"}"><img src="{const SITE_URL}image.php?f={$article->art_img}&m=articles&w=160&h=120" width="160" height="120" alt="{$article->art_title|replace:'"':'&quot;'}" title="{$article->art_title|replace:'"':'&quot;'}" border="0"  class="imageborder" /></a>
                                                </div>
                                                {/if}
                                                <p class="article_title">
                                                    <a title="{$article->art_title}" href="{url href="t=`$article->art_title|@urlencode`&a=`$article->art_id`"}">{$article->art_title}</a>
                                                    {if strlen($article->art_shortdesc)}<br />{$article->art_shortdesc|@strip_tags }{/if}
                                                </p>
                                            </li>
                                        {/foreach}
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
{/strip}