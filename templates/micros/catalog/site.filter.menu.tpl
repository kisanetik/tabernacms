{strip}
{if $show and (!empty($valvalues) or !empty($brands))}
    <div class="val-table">
        <h3><strong>{lang code="filter.catalog.title" ucf=true}</strong></h3>
        {if !empty($valvalues)}
            {foreach from=$valvalues item="vv1" key="vl_id"}
                <ul>
                <li>
                    <span class="val-name">{$valnames[$vl_id]->vl_name|default:'valname[$vl_id]'}:</span>
                </li>
                <li>
                    <a href="{url href="`$currentFilter`&vv[`$vl_id`]=0"}"{if !isset($current.vv[$vl_id]) or !$current.vv[$vl_id]} class="active"{/if}>{lang code="-all" ucf=true}</a>
                </li>
                {foreach from=$vv1 item="vv" key="vv1k"}
                    <li>
                        <a href="{url href="`$currentFilter`&vv[`$vl_id`]=`$vv`"}"{if isset($current.vv[$vl_id]) and $current.vv[$vl_id] eq $vv} class="active"{/if}>{$vv}</a>
                    </li>
                {/foreach}
                </ul>
                <div class="clear"></div>
            {/foreach}
        {/if}
    	{if !empty($brands)}
    	    {if !empty($valvalues)}
    	        <span class="separator"></span>
    	    {/if}
    	    <ul>
    	        <li>
    	            <span class="val-name">{lang code="productbrand.catalog.title" ucf=true}:</span>
    	        </li>
    	        <li><a href="{url href="`$currentFilter`&brand_id=0"}"{if empty($current.brand_id) or empty($current.brand_id[0])} class="active"{/if}>{lang code="-all" ucf=true}</a></li>
    	        {foreach from=$brands item="brand"}
    	            <li>
    	                <a href="{url href="`$currentFilter`&brand_id=`$brand->rcb_id`"}"{if $brand->rcb_id|@in_array:$current.brand_id} class="active"{/if}>
    	                    {$brand->rcb_name}
    	                </a>
    	            </li>
    	        {/foreach}
    	    </ul>
    	    <div class="clear"></div>
    	{/if}
    	{if !empty($prices)}
    	    {if !empty($valvalues) or !empty($brands)}
    	        <span class="separator"></span>
    	    {/if}
    	    {url file="jscss/components/jquery/ui/jquery-ui-redmond.css" type="css" param="link"}
            {url file="jscss/components/jquery/ui/jquery-ui.js" type="js"}
    	    <ul>
    	        <li>
    	            <span class="val-name">{lang code="cost.catalog.title" ucf=true}:</span>
    	        </li>
    	        <li>
            	    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.18/jquery-ui.min.js"></script>
            	    <div class="price-slider">
            	        <p>
            	            <label>
                                {lang code="costsfrom.catalog.label"}
            	                <input type="text" id="amount-min" class="user" style="width: 100px; border: 1px solid rgb(183, 186, 190);" />
            	            </label>
            	            <label>
            	                {lang code="costto.catalog.label"}
            	                <input type="text" id="amount-max" class="user" style="width: 100px; border: 1px solid rgb(183, 186, 190);" />
            	            </label>
            	            <span class="cost">{currency get="ind"}</span>
            	            <input type="button" class="fright btnblue tx wt" value="{lang code="-apply"}" id="price-range" style="margin-top:10px;" />
            	        </p>
            	        <div id="slider-range" style="margin-top:10px;"></div>
            	    </div>
            	    <script type="text/javascript">
            	    var PRICE_MIN = {$prices.min|@round:2};
            	    var PRICE_MAX = {$prices.max|@round:2};
            	    var CURRENT_COSTFROM = {$current.costfrom};
            	    var CURRENT_COSTTO = {$current.costto};
            	    var COST_FILTER_URL = '{url href="`$currentFilter`&costfrom=RAD_COST_FROM&costto=RAD_COST_TO"}';
            	    </script>
            	</li>
            </ul>
    	{/if}
    </div>
{/if}
{/strip}