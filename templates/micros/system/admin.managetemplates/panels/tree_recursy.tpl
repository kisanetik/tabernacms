{strip}
{if count($elements)}
<ul{if !strlen($href)} id="adoptme" style="display:none;"{/if}>
	{foreach from=$elements item="item" key="key"}
		<li>
			<a href="{$href}@{$key}">{$key}</a>
			{if is_array($item)}{include file="$_CURRENT_LOAD_PATH/admin.managetemplates/panels/tree_recursy.tpl" elements=$item href="`$href`@`$key`"}{/if}
		</li>
	{/foreach}
</ul>
{/if}
{/strip}