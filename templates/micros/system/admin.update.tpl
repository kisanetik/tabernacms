{strip}
    {if !isset($action)}
    <div class="w100">
        <div class="kord_right_col">
            {include file="$_CURRENT_LOAD_PATH/admin.update/panels/index.tpl"}
        </div>
    </div>
    {else}
        {if $action eq 'getjs'}
            {include file="$_CURRENT_LOAD_PATH/admin.update/js/getjs.tpl"}
        {elseif $action eq 'getavaliableupdates'}
            {include file="$_CURRENT_LOAD_PATH/admin.update/panels/updates.items.tpl"}
        {/if}
    {/if}
{/strip}