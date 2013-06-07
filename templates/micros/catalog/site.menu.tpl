{strip}
<div class="pic1"></div>
<h4>{lang code='catalog.catalog.title'}</h4>
{foreach from=$items item=item}
    {if $item->tre_active}
        <div class="lineh3" id="browser"></div>
        <h3 class="arrow"> 
           <span class="bgh3">
               <a class="upcatlink" href="{url href="alias=catalog&cat=`$item->tre_id`"}">
                    {$item->tre_name}
               </a>
               <br/>
           </span>

        </h3>
        {if $item->child}
            <ul id="browser">
                {foreach from=$item->child item='child'}
                    {if $child->tre_active}
                        <li>
                            <a href="{url href="SITE_URL?alias=catalog&cat=`$child->tre_id`"}">
                                {$child->tre_name}
                            </a>

                        </li>
                    {/if}
                {/foreach}    
            </ul>
        {/if}

    {/if}
{/foreach}
{/strip}