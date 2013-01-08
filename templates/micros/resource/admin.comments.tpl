{strip}
    {if !isset($action) or $action eq 'dmi'}
    <div class="w100">
        <div class="kord_right_col">
            {include file="$_CURRENT_LOAD_PATH/admin.comments/panels/index.tpl"}
        </div>
    </div>
    {else}
        {switch $action}
            {case 'getjs'}
                {include file="$_CURRENT_LOAD_PATH/admin.comments/js/getjs.tpl"}
            {/case}
            {case 'ri'}
                {include file="$_CURRENT_LOAD_PATH/admin.comments/panels/itemslist.tpl"}
            {/case}
            {case 'ei'}
                {include file="$_CURRENT_LOAD_PATH/admin.comments/panels/edititem.tpl"}
            {/case}
        {/switch}
    {/if}
{/strip}