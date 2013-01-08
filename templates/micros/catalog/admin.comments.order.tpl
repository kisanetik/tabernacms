{strip}
{if empty($comments_action)}
	{include file="$_CURRENT_LOAD_PATH/admin.comments.order/panels/getpanels.tpl"}
{else}
	{if $comments_action eq 'getjs'}
		{include file="$_CURRENT_LOAD_PATH/admin.comments.order/js/getjs.tpl"}
	{/if}
{/if}
{/strip}