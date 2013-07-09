{strip}
{if !empty($items)}
<div class="menu">
    <ul>
        {foreach from=$items item="item" name="topmanu"}
        <li>
            <a href="{url href="`$item->tre_url`"}">{$item->tre_name}</a>
            {if !$item@last}
                <img src="{url module="core" file="des/sep.jpg" type="image" preset="original"}" width="10" height="10"  />
            {/if}
        </li>
        {/foreach}
    </ul>
</div>
{/if}
{/strip}