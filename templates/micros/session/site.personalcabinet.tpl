{strip}
    {if !empty($action)}
        {if $action eq 'getjs'}
            {include file="$_CURRENT_LOAD_PATH/site.personalcabinet/js/getjs.tpl"}
        {else}
            {if empty($typ) or $typ neq 'AJAX'}
                {include file="$_CURRENT_LOAD_PATH/site.personalcabinet/panels/getpanels.tpl"}
            {/if}
	        {switch $action}
	            {case 'profile'}
	                {include file="$_CURRENT_LOAD_PATH/site.personalcabinet/panels/profile_edit.tpl"}
	            {/case}
	            {case 'orders'}
	                {include file="$_CURRENT_LOAD_PATH/site.personalcabinet/panels/orders.tpl"}
	            {/case}
	            {case 'referals'}
	               {include file="$_CURRENT_LOAD_PATH/site.personalcabinet/panels/referals.tpl"}
	            {/case}
	            {case 'refref'}
	               {if !empty($typ) and $typ eq 'AJAX'}
	                   {include file="$_CURRENT_LOAD_PATH/site.personalcabinet/panels/refitems.tpl"}
	               {else}
	                   {include file="$_CURRENT_LOAD_PATH/site.personalcabinet/panels/referals.tpl"}
	               {/if}
	            {/case}
	        {/switch}
	    {/if}
    {else}
        {include file="$_CURRENT_LOAD_PATH/site.personalcabinet/panels/getpanels.tpl"}
    {/if}
{/strip}