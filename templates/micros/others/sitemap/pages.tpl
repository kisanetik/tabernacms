{strip}
{if !empty($pages)}
    <ul class="pages">
        {foreach from=$pages item="page"}
            <li>
                {if !empty($page->pages) and count($page->pages) > 1}
                    <a href="{url href="alias=page&cp=`$page->tre_id`"}">{$page->tre_name}</a>
                    {if !empty($page->pages)}
                        <ul class="page-items">
                            {foreach from=$page->pages item="pitem"}
                                <li>
                                    <a href="{url href="alias=page&pgid=`$pitem->pg_id`"}">{$pitem->pg_title}</a>
                                </li>
                            {/foreach}
                        </ul>
                    {/if}
                {else}
                    {if !empty($page->tre_url)}
                        <a href="{url href="`$page->tre_url`"}">{$page->tre_name}</a>
                    {elseif !empty($page->pages[0])}
                        <a href="{url href="alias=page&pgid=`$page->pages[0]->pg_id`"}">{$page->pages[0]->pg_title}</a>
                    {/if}
                {/if}
            </li>
        {/foreach}
    </ul>
{/if}{* --PAGES-- *}
{/strip}