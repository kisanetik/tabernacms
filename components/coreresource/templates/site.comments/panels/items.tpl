{strip}
{if !empty($items)}
    <div class="interview">
        <h4>{lang code="comments.resource.title" ucf=true}</h4>
            {foreach from=$items item="comment" name="comm"}
                {include file="$_CURRENT_LOAD_PATH/site.comments/panels/item_one.tpl" comment=$comment}
            {/foreach}    
        {if $comments_action neq 'f'}
        <span class="all_link">
            <a href="{url href="alias=comments&comments_action=f&t=`$typ`&item=`$item_id`"}">{lang code="allcomments.resource.link" ucf=true}</a>
        </span>
        {/if}
    </div>
{else}
    {*<center>Пока нет комментариев</center>*}
{/if}
{/strip}
