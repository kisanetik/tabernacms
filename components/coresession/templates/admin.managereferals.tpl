{strip}
{if !empty($action)}
    {switch $action}
        {case 'getjs'}
            {include file="$_CURRENT_LOAD_PATH/admin.managereferals/js/getjs.tpl"}
        {/case}
        {case 'getrefs'}
            {include file="$_CURRENT_LOAD_PATH/admin.managereferals/panels/getusers.tpl"}
        {/case}
        {case 'showdetails'}
            {include file="$_CURRENT_LOAD_PATH/admin.managereferals/panels/details.tpl"}
        {/case}
        {case 'showdetailsstatic'}
            {include file="$_CURRENT_LOAD_PATH/admin.managereferals/panels/details_static.tpl"}
        {/case}
        {default}
            1234
    {/switch}
{else}
<div class="w100">
    <div class="kord_right_col">
        {include file="$_CURRENT_LOAD_PATH/admin.managereferals/panels/getpanels.tpl"}
    </div>
</div>
{/if}
{/strip}