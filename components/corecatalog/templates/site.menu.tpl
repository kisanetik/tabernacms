{strip}
<div class="pic1"></div>
<h4>{lang code='catalog.catalog.title'}</h4>
{foreach from=$items item=item}
    {if $item->tre_active}
        <div class="lineh3" id="browser"></div>
        <div class="menucat">
            <h3 class="arrow">
                <span class="bgh3">
                    <a class="upcatlink{if $item->selected|default:false} selected{/if}" href="{url href="alias=catalog&cat=`$item->tre_id`"}">
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
                                <a href="{url href="SITE_URL?alias=catalog&cat=`$child->tre_id`"}"{if $child->selected|default:false} class="selected"{/if}>
                                    {$child->tre_name}
                                </a>

                            </li>
                        {/if}
                    {/foreach}
                </ul>
            {/if}
        </div>
    {/if}
{/foreach}
{if {$menueffect} != 0} {*1 - нет эффекта, 2 - аккордион, 3 - появление*}
    {url module="core" type="js" file="des/catalogmenu.js"}
    <script type="text/javascript">
        var effect = {$menueffect};
        {literal}
        MenuEffect.init(effect);
        {/literal}
    </script>
{/if}
{/strip}