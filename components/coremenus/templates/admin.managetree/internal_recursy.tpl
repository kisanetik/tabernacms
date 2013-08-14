{strip}
{capture assign="current_tre_url"}alias={const SITE_ALIAS}{/capture}
<ul id="menu_togle_{$id_ul}">
    <li class="razd_li"></li>
    {foreach from=$items item=id}
        <li style="padding:0px;">
        {if strlen($id->tre_url) }
            {if !empty($furl)}
                <a href="{url href="`$id->tre_url`"}" {if {$current_tre_url} eq $id->tre_url}class="current"{/if}>{$id->tre_name}</a>
            {else}
                <a href="{const SITE_URL}{$id->tre_url}" {if {$current_tre_url} eq $id->tre_url}class="current"{/if}>{$id->tre_name}</a>
            {/if}
        {else}
            {$id->tre_name}
        {/if}
        </li>
    {/foreach}
</ul>
{/strip}