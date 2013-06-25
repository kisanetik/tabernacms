{strip} {* done *}
<div class="b-cart-container">
    <a href="{url href="alias=order.html"}" class="b-cart {if {$count|string_format:"%.0f"} != 0} active{/if}">
        <span class="label">{lang code='yourbin.bin.title' ucf=true}</span>
        <span class="count">{$count|string_format:"%.0f"}</span>
    </a>
    {if {$count|string_format:"%.0f"} != 0}
        <span id="sum_basket">{$count|string_format:"%.0f"} {lang code="productsintheamount.catalog.text"} <span>{$cost|string_format:"%.2f"} {$curr->cur_ind}</span></span>
    {/if}
</div>
<div style="clear: both"></div>
{/strip}