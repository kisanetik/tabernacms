{strip}
<?xml version="1.0" encoding="UTF-8"?>
<!DOCTYPE yml_catalog SYSTEM "shops.dtd">
<yml_catalog date="{$nowdate}">
	<shop>
    	<name>{$shop_name}</name>
    	<company>{$shop_company}</company>
    	<url>{$shop_url}</url>
    	<platform>{$shop_platform}</platform>
    	<version>{$shop_version}</version>
    	<agency>{$shop_agency}</agency>
    	<email>{$shop_email}</email>
    	<currencies>
    	{foreach $currencies as $currency}
    		<currency id="{$currency->cur_ind}" {if $currency->cur_default_site}rate="1"{else}rate="{$currency->cur_cost}"{/if}/>
		{/foreach}    		
    	</currencies>
    	{if $showCatalog}
        	<categories>
    			{include file="$_CURRENT_LOAD_PATH/sitemap.export/yandex.categories.tpl"}
        	</categories>
        	<local_delivery_cost>0</local_delivery_cost> {* <-- Here should be delivery data in future *}
    		<offers>
    			{include file="$_CURRENT_LOAD_PATH/sitemap.export/yandex.products.tpl"}
    		</offers>
    	{/if}
	</shop>
</yml_catalog>
{/strip}