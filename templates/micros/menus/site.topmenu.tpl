{strip}
{if !empty($items)}
<div class="menu">
    <ul>
        {foreach from=$items item="item" name="topmanu"}
        <li>
            <a href="{url href="`$item->tre_url`"}">{$item->tre_name}</a>
            {if !$item@last}
                <img src="{const SITE_URL}img/des/default/sep.jpg" width="10" height="10"  />
            {/if}
        </li>
        {/foreach}
    </ul>
</div>
{/if}
{/strip}