{strip}
<div class="rpart" id="basket_delivery">
    <div class="reg_form">
        <p class="formfeedback">{lang code="delivery.catalog.title" ucf=true}</p>
    </div>
    <div class="select_delivery">
        <select id="delivery_select" name="delivery">
            <option value="0" cost="0">{lang code="-choose" ucf=true}</option>
        {foreach from=$delivery item="item"}
            <option value="{$item->rdl_id}" cost="{currency cost="`$item->rdl_cost`" curid="`$item->rdl_currency`"}">
                {$item->rdl_name}
            </option>
        {/foreach}
        </select>
    </div>
    {foreach from=$delivery item="item"}
        {if $item->rdl_active}
            <p id="del_desc_{$item->rdl_id}" class="formfeedback nm delivery-description" style="display:none;">
                {$item->rdl_description}
            </p>
        {/if}
    {/foreach}
    <div class="underbst" id="delivery-costs-block" style="display:none;">
        <h2>
            {lang code="totalwithdelivery.catalog.text" ucf=true}:<span><span id="total-with-delivery"></span> {currency get="shortname"}</span>
        </h2>
    </div>
</div>
{/strip}