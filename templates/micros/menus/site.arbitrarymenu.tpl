{strip}
{if !empty($items)}
<div class="pic1" style="margin-top:12px;"></div>
<h4>{$title}</h4>
{foreach from=$items item=item}
    {if $item->tre_active}
        <div class="lineh3" id="browser"></div>
        <h3 class="arrow"> 
           <span class="bgh3">
               <a class="upcatlink" href="{url href="`$item->tre_url`"}">
                    {$item->tre_name}
               </a>
               </br>
           </span>

        </h3>
        {if $item->child}
            <ul id="browser">
                {foreach from=$item->child item='child'}
                    {if $child->tre_active}
                        <li>
                            <a href="{url href="`$child->tre_url`"}">
                                {$child->tre_name}
                            </a>

                        </li>
                    {/if}
                {/foreach}    
            </ul>
        {/if}

    {/if}
{/foreach}
{/if}
{/strip}