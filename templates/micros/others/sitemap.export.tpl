{strip}
	{if isset($params) && isset($params->export)}
		{if $params->export eq 'yandex.yml'}
			{include file="$_CURRENT_LOAD_PATH/sitemap.export/yandex.yml.tpl"}
		{elseif $params->export eq 'google.xml'}
			{include file="$_CURRENT_LOAD_PATH/sitemap.export/google.xml.tpl"}
		{/if}
	{/if}
{/strip}
