{strip}
{if isset($pages) and count($pages)}
    {if count($pages) eq 1}
       <span class="centerpage">
           {$pages[0]->pg_fulldesc}
       </span>
    {else}
       <ul class="centerpage">
        {foreach from=$pages item=page}
        <li>
            <a href="{url href="pgid=`$page->pg_id`"}/">
                {$page->pg_title}
            </a>
        </li>
        {/foreach}
        </ul>
    {/if}
{/if}
{if !empty($item)}
  {if !empty($item->pg_title)}
    <h1>{$item->pg_title}</h1>
  {elseif !empty($item->pg_name)}
    <h1>{$item->pg_name}</h1>
  {/if}
  {$item->pg_fulldesc}
{/if}
{/strip}