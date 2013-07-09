{strip}
    {if !isset($action)}
    <div class="w100">
        <div class="kord_right_col">
            {include file="$_CURRENT_LOAD_PATH/admin.repository/panels/index.tpl"}
        </div>
    </div>
    {else}
        {if $action eq 'install'}
            {include file="$_CURRENT_LOAD_PATH/admin.repository/panels/install.index.tpl"}
        {elseif $action eq 'getjs'}
            {include file="$_CURRENT_LOAD_PATH/admin.repository/js/getjs.tpl"}
        {elseif $action eq 'getnodes'}
            {include file="$_CURRENT_LOAD_PATH/admin.repository/js/getnodes.tpl"}
        {elseif $action eq 'getmod'}
            {if isset($item)}
                {include file="$_CURRENT_LOAD_PATH/admin.repository/panels/moduleinfo.tpl"}
            {else}
                {lang code="`$i`install.system.help"}
            {/if}
        {elseif $action eq 'getinc' or $action eq 'getfile'}
            {include file="$_CURRENT_LOAD_PATH/admin.repository/panels/includeinfo.tpl"}
        {elseif $action eq 'getxmlparamsstring'}
            {include file="$_CURRENT_LOAD_PATH/admin.repository/panels/xmlparamsstring.tpl"}
        {elseif $action eq 'getfullxmlparams'}
            {include file="$_CURRENT_LOAD_PATH/admin.repository/panels/xmlfullparamsstring.tpl"}
        {elseif $action eq 'network'}
            <center><h3>На данный момент находится в стадии разработки</h3></center>
        {/if}
    {/if}
{/strip}