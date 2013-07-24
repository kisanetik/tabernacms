{strip}
{if isset($action) and ($action eq 'saveeditscript' or $action eq 'save' or $action eq 'applyinc' or $action eq 'delinc' or $action eq 'addWinclude' or $action eq 'saveconfinclude' or $action eq 'getcontrollerjs' or $action eq 'savedescription' or $action eq 'createtheme' or $action eq 'copycomponents' or $action eq 'deletetheme') }
{elseif isset($action) and $action eq 'getjs'}
    {include file="$_CURRENT_LOAD_PATH/admin.managealiases/getjs.tpl"}
{elseif isset($action) and $action eq 'addincludewindow'}
    {include file="$_CURRENT_LOAD_PATH/admin.managealiases/addinclude.window.tpl"}
{elseif isset($action) and $action eq 'getincludeslist'}
    {include file="$_CURRENT_LOAD_PATH/admin.managealiases/includeslist.tpl"}
{elseif isset($action) and $action eq 'confinclude'}
    {include file="$_CURRENT_LOAD_PATH/admin.managealiases/configinclude.tpl"}
{elseif isset($action) and $action eq 'showeditscript'}
    {include file="$_CURRENT_LOAD_PATH/admin.managealiases/editscript.tpl"}
{elseif isset($action) and $action eq 'getjs_aliaslist'}
    {include file="$_CURRENT_LOAD_PATH/admin.managealiases/getjs_aliaslist.tpl"}
{elseif isset($action) and $action eq 'refreshlist'}
    {include file="$_CURRENT_LOAD_PATH/admin.managealiases/aliaseslist_inc.tpl"}
{elseif isset($action) and $action eq 'search'}
    {include file="$_CURRENT_LOAD_PATH/admin.managealiases/aliaseslist_inc.tpl"}
{elseif isset($action) and $action eq 'descriptionwindow'}
    {include file="$_CURRENT_LOAD_PATH/admin.managealiases/description.tpl"}
{else}
<div class="w100">
    <div class="kord_right_col">
    {if !isset($action)}
        {include file="$_CURRENT_LOAD_PATH/admin.managealiases/aliaseslist.tpl"}
    {else}
        {if $action=='edit' or $action=='add' or $action=='reindex'}
            {if $smarty.const.SITE_ALIAS eq 'SYSmanageAliases'}
                {include file="$_CURRENT_LOAD_PATH/admin.managealiases/editadd.tpl"}
            {else}
                {include file="$_CURRENT_LOAD_PATH/admin.managealiases/$action.tpl"}
            {/if}
        {else}
            For delete!!!!!
        {/if}
    {/if}
    </div>
</div>
{/if}
{/strip}