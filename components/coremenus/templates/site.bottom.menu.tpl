{strip}
{if !empty($items)}
<div class="linesold">
    <ul>
       {foreach from=$items item=item name="topmenu_items"}
           <li>
               <a href="{url href=$item->tre_url}">{$item->tre_name}</a>
           </li>
       {/foreach}
    </ul>
</div>
{/if}
{/strip}