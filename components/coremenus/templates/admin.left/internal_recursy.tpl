{strip}
<ul id="menu_togle_{$id_ul}">
    <li class="razd_li"></li>
    {foreach from=$items item=id}
        <li style="padding:0px;">
        {if strlen($id->tre_url) }
            <a href="{const SITE_URL}{$id->tre_url}">{$id->tre_name}</a>
        {else}
            {$id->tre_name}
        {/if}
        </li>
    {/foreach}
</ul>
{/strip}