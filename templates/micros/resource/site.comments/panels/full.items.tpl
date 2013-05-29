{strip}
{url type="js" file="jscss/components/radcomments.js"}
{url type="js" file="jscss/fckeditor/fckeditor.js"}
<div class="commentsWrapper">
    <h1>{lang code="commentforrecord.resource.title" ucf=true} "
        {switch $typ}
            {case 'news'}
                <a href="{url href="alias=news&t=`$to_item->nw_title|@urlencode`&nid=`$item_id`"}">
            {/case}
            {case 'product'}
                <a href="{url href="alias=product&p=`$item_id`"}">
            {/case}
            {case 'articles'}
                <a href="{url href="alias=articles&t=`$to_item->art_title|@urlencode`&a=`$item_id`"}">
            {/case}
        {/switch}
        {$item_title}</a>"</h1>
    <div id="comments_loader">
        <img src="{const SITE_URL}jscss/components/mootree/mootree_loader.gif" alt="{lang code="-loading" ucf=true}" title="{lang code="-loading" ucf=true}" border="0" />
    </div>
    <div id="commentsItems">
        {include file="$_CURRENT_LOAD_PATH/site.comments/panels/items.tpl"}
    </div>

    <div class="paging">
        <div class="paginator_items">
            {foreach from=$paginator->getPages() item=page}
                {if $page->isCurrentPage}
                    <b>
                {else}
                    <a href="{$page->href()}">
                {/if}
                {$page->text()}
                {if $page->isCurrentPage}
                    </b>
                {else}
                    </a>
                {/if}&nbsp;
            {/foreach}
        </div>
    </div>

</div>
{if !$onlyregistered or !empty($user->u_id)}
    <form id="f_addComment" onSumbit="return false;">
        <div class="news" id="formComment">
            <div class="newsfon" style="width:100%;"></div>
            <h4>{lang code="addcomment.resource.title" ucf=true}</h4>
            <div class="comments">
                <textarea id="text_comments" style="width:98%;height:100px;"></textarea>
            </div>
            <div style="text-align:center;width:100%;">
                <input class="btnblue ltgrbt tx blc subsbt" type="submit" value="{lang code="-submit" ucf=true}" />
            </div>
        </div>
    </form>
    <script type="text/javascript">
        var ADD_COMMENT_URL = '{url href="alias=commentsXML&comments_action=a"}';
        var HASH = '{$hash}';
        var ITEM_ID = '{$item_id}';
        var ITEM_TYPE = '{$typ}';
        {literal}
            $(function() {tcomments.init_short(ITEM_ID, ITEM_TYPE);});
        {/literal}
    </script>
{/if}
{/strip}