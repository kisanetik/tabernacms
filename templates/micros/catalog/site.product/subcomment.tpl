{strip}
{if $comment->rcm_parent_id != 0}
    <ul class="sub">
{else}
    <ul>
{/if}

    <li>
        <div class="comment_str">
            <span class="comment_nickname">{$comment->rcm_nickname}</span>
            <span class="comment_date">{$comment->rcm_datetime}</span>
            <span class="comment_text">{$comment->rcm_text}</span>
            <div class="comment_buttons">
                <span class="comment_reply" onclick="product.comment.form_toggle({$comment->rcm_id})" >
                    {lang code='-reply' ucf=true}
                </span>
            </div>
        </div>
        {if (!empty($comment->subcomments))}
            {foreach from=$comment->subcomments item="subcomment" name="comm"}
                {include file="$_CURRENT_LOAD_PATH/site.product/comment.tpl" comment=$subcomment}
            {/foreach}    
        {/if}
    </li>

</ul>

{/strip}