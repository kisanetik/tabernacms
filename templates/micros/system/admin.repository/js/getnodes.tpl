{strip}
{literal}<?xml version="1.0"?>{/literal}
<nodes>
    {if !empty($items)}
        {foreach from=$items item=item}
            <node text="{$item.text|replace:'"':"&quot;"|replace:"&nbsp;":" "}" {if !empty($item.url)}load="{$item.url}" {/if}id="{$item.id}" islast="{$item.islast}"{if !empty($item.data)} {$item.data}{/if} />
        {/foreach}
    {/if}
</nodes>
{/strip}