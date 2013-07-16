{strip}
<script type="text/javascript">
{* CONST URL'S FOR RAD_BIN FUNCTIONS *}
var URL_BINXML = '{url href="alias=binXML&action=addtobin"}';
var URL_REFRESHBIN = '{url href="alias=binMenuXML&action=refreshbin"}';
var URL_CHANGEBINCOUNT = '{url href="alias=binXML&action=changebincount"}';
var URL_DELFROMBIN = '{url href="alias=binXML&action=delfrombin"}';
var URL_ORDER = '{url href="alias=order.html"}';
var URL_ADDTOBIN = '{url href="alias=binXML&action=addtobin"}';
var URL_SHOWBINWINDOW = '{url href="alias=binMenuXML&action=showbinwindow"}';
</script>
{url module="corecatalog" file="radbin.js" type="js"}
{if count($products)}

    {foreach from=$products item=item name="products"}
    <div class="card">
        <h1>
            <a href="{url href="alias=product&p=`$item->cat_id`"}" class="more">{$item->cat_name}</a>
            {if $item->cat_special_spnews}
                <span style="background-color: #AC34CC;">{lang code='productnew.catalog.text'}</span>
            {/if}
            {if $item->cat_special_sp}
                <span style="background-color: #1BCC3D;">{lang code='productsp.catalog.text'}</span>
            {/if}
            {if $item->cat_special_spoffer}
                <span style="background-color: #3881CC;">{lang code='productspoffer.catalog.text'}</span>
            {/if}
            {if $item->cat_special_sphit}
                <span style="background-color: #FF9C0D;">{lang code='productsphit.catalog.text'}</span>
            {/if}
        </h1>
        <a href="{url href="alias=product&p=`$item->cat_id`"}">
        {if $item->img_filename}
            <img src="{url module="corecatalog" file="`$item->img_filename`" type="image" preset="product_thumb"}" class="goods_pic fleft"  alt="{$item->cat_name|replace:'"':'&quot;'}" border="0"/>
        {else}
            <img src="{url module="core" file="des/no_image_available.png" type="image" preset="original"}" alt="{$item->cat_name|replace:'"':'&quot;'}" class="goods_pic fleft" width="68" height="134" border="0" />
        {/if}
        </a>
        <div class="goodslist">
            <p>{$item->cat_shortdesc}</p>
                
            <div class="b1"></div>
            {capture name="valvalues"}
            {if count($item->type_vl_link)}
                <table class="parameters">
                {foreach from=$item->type_vl_link item=item_l name="type_vl"}
                {if count($item_l->vv_values)}
                <tr>
                    <td class="name">{$item_l->vl_name}<div class="b1"></div></td>
                    <td class="value">
                    {foreach from=$item_l->vv_values item="vv" name="vv"}
                        {if !empty($vv->vv_value)}
                            {$vv->vv_value} {$item_l->ms_value}
                           {if !$smarty.foreach.vv.last}<br />{/if}
                        {/if}
                    {/foreach}
                    </td>
                {/if}
                {/foreach}
                </tr></table>
            {/if}
            {/capture}
            {$smarty.capture.valvalues}
                        
        </div>
        <div class="servfon fright">
            <div class="price1">{lang code="cost.catalog.text"}</div>
            <div class="price">{currency cost="`$item->cat_cost`" curid="`$item->cat_currency_id`"} {currency get="shortname"}</div>
            <input type="submit"{if !$item->cat_availability} disabled="disabled"{/if} name="pay" class="fright btnblue tx wt buyBtn" value="{lang code="buy.catalog.title"}"{if $item->cat_availability} onclick="RADBIN.addToBin({$item->cat_id},this);"{/if}/>
            {if !$item->cat_availability}
                <strong class="required">{lang code="noavilability.catalog.text"}</strong>
            {/if}
        </div>
        <div class="b1 fclear"></div>
    </div>
    {/foreach}
    <div class="paginator" id="paginator">
        {assign var=gp value=""}
        {if !empty($currentFilter)}
            {assign var=gp value="`$currentFilter`&`$gp`"}
        {/if}
        {if isset($cat_id)}{assign var=gp value="`$gp`cat=$cat_id"}{/if}
        {if isset($itemsPerPage)}{assign var=gp value="$gp&i=$itemsPerPage"}{/if}
        <div class="paging">
            {paginator from=0 
                       to=$pages_count 
                       curpage=$page-1 
                       GET="$gp" 
                       prev_title_text='<' 
                       first_title_text='<<' 
                       next_title_text='>' 
                       last_title_text='>>'
                       showsteps=false
                       showfirst=false
                       showlast=false
                       maxshow=100000}
        </div>
        {if $pages_count > 2}
            <span class="total">{$pages_count-1}&nbsp;{lang code="pages.catalog.text"}</span>
        {/if}
    </div>
{/if}

{/strip}