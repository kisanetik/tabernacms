{strip}
<div class="inn_components_out" style="width:650px;">
    <div class="inn_components" style="background-color:#FFFFFF; margin-bottom: 15px;"><div>
        {if empty($onlymain)}
        <div id="ciTabsPanel" class="vkladki">
            <div class="vkladka{if !$inc_item->params_presonal} activ{/if}" id="configMain" onclick="RADTabs.change('configMain','ciTabsPanel','TabsWrapperMain');">
                <div>
                    <div>
                        <div>{lang code="mainincconfig.system.title" ucf=true}</div>
                    </div>
                </div>
            </div>
            <div class="vkladka{if $inc_item->params_presonal} activ{/if}" id="configPersonal" onclick="RADTabs.change('configPersonal','ciTabsPanel','TabsWrapperMain');">
                <div>
                    <div>
                        <div>{lang code="personalincconfig.system.title" ucf=true}</div>
                    </div>
                </div>
            </div>
        <div class="clear"></div>
        </div>
        {/if}
        <div class="und_vkladki">
            <div id="TabsWrapperMain" class="wrap">
                <div id="configMain_tabcenter" class="lf_col tabcenter" style="{if !$inc_item->params_presonal} display:block;{else} display:none;{/if}width:100%;">
                <form method="post" id="configFormWindow{if !empty($onlymain)}_{$inc_id}{/if}" onsubmit="RADIncInAlAction.configSubmitClick();return false;">
                <input type="hidden" name="inc_id" value="{$inc_id}" />
                <input type="hidden" name="hash" value="{$hash|default:''}" />
                {if !empty($onlymain)}
                <input type="hidden" name="onlymain" value="1" />
                {/if}
                <table cellpadding="0" cellspacing="0" border="0" width="100%">
                    {foreach from=$items->_getParamsNames() item=item key=kid}
                    {if $items->_typeof($item) eq 'hidden'}
                        <input type="hidden" name="paramtype[{$item}]" value="{$items->_typeof($item)}" />
                        <input type="hidden" name="param[{$item}]" value="{$values->_get($item, $items->_default($item))}" />
                    {else}
                       {if $items->_isMultilang($item)}
                           <input type="hidden" name="multilang[{$item}]" value="1" />
                       {/if}
                        <tr>
                            <td valign="top" style="width:200px;">
                                {lang code="`$items->_getName($item)`"}
                            </td>
                            <td align="left" valign="top">
                                <input type="hidden" name="paramtype[{$item}]" value="{$items->_typeof($item)}" />
                                {if ($items->_typeof($item) eq 'integer' or $items->_typeof($item) eq 'int')}
                                    <input type="text" name="param[{$item}]" value="{$values->_get($item, $items->_default($item))}" />
                                {elseif ($items->_typeof($item) eq 'boolean' or $items->_typeof($item) eq 'bool')}
                                    {if $items->_isMultilang($item)}
                                        {foreach from=$langs item=lng}
                                            {assign var="lngid" value=$lng->lng_id}
                                            ({$lng->lng_code})<input type="radio" name="param[{$item}][lang_{$lngid}]" id="{$item}_yes_{$lngid}" value="1"{if $values->_get($item, $items->_default($item), $lng->lng_id) eq '1'} checked="checked"{/if} /><label for="{$item}_yes_{$lngid}">{lang code='-yes'}</label>
                                                              <input type="radio" name="param[{$item}][lang_{$lngid}]" id="{$item}_no_{$lngid}" value="0"{if $values->_get($item, $items->_default($item), $lng->lng_id) eq '0'} checked="checked"{/if} /><label for="{$item}_no_{$lngid}">{lang code='-no'}</label>
                                                              <br />
                                        {/foreach}
                                    {else}
                                        <input type="radio" name="param[{$item}]" id="{$item}_yes" value="1"{if $values->_get($item, $items->_default($item)) eq '1'} checked="checked"{/if} /><label for="{$item}_yes">{lang code='-yes'}</label>
                                        <input type="radio" name="param[{$item}]" id="{$item}_no" value="0"{if $values->_get($item, $items->_default($item)) eq '0'} checked="checked"{/if} /><label for="{$item}_no">{lang code='-no'}</label>
                                    {/if}
                                {elseif ($items->_typeof($item) eq 'text')}
                                    {if $items->_isMultilang($item)}
                                       {foreach from=$langs item=lng}
                                           {assign var="lngid" value=$lng->lng_id}
                                           ({$lng->lng_code})<input type="text" name="param[{$item}][lang_{$lngid}]" value="{$values->_get($item, $items->_default($item), $lng->lng_id)|@htmlspecialchars}" /><br />
                                       {/foreach}
                                    {else}
                                        <input type="text" name="param[{$item}]" value="{$values->_get($item, $items->_default($item))|@htmlspecialchars}" />
                                    {/if}
                                {elseif ($items->_typeof($item) eq 'textarea' or $items->_typeof($item) eq 'fckeditor' or $items->_typeof($item) eq 'fck')}
                                    {if $items->_isMultilang($item)}
                                       {foreach from=$langs item=lng}
                                           {assign var="lngid" value=$lng->lng_id}
                                           ({$lng->lng_code})<textarea style="width:90%;" rows="5" name="param[{$item}][lang_{$lngid}]">{$values->_get($item, $items->_default($item), $lng->lng_id)|@htmlspecialchars}</textarea><br />
                                       {/foreach}
                                    {else}
                                        <textarea style="width:90%;" rows="5" name="param[{$item}]">{$values->_get($item, $items->_default($item))|@htmlspecialchars}</textarea>
                                    {/if}
                                {elseif ($items->_typeof($item) eq 'treenodeselect') or ($items->_typeof($item) eq 'treenode.multiselect')}{*add multiselect=attribute  multiple="multiple"*}
                                    {if $items->_isMultilang($item)}
                                       {foreach from=$langs item=lng}
                                         {assign var=lngid value=$lng->lng_id}
                                           ({$lng->lng_code})<select name="param[{$item}][lang_{$lng->lng_id}]{if $items->_typeof($item) eq 'treenode.multiselect'}[]" multiple="multiple" style="height:100px;"{else}"{/if}>
                                               {include file="$_CURRENT_LOAD_PATH/admin.managealiases/tree_recursy.tpl" elements=$tree[$lngid] nbsp_count=0 ml=$lng->lng_id values=$values}
                                           </select><br />
                                       {/foreach}
                                    {else}
                                    <select name="param[{$item}]{if $items->_typeof($item) eq 'treenode.multiselect'}[]" multiple="multiple" style="height:100px;"{else}"{/if}>
                                        {include file="$_CURRENT_LOAD_PATH/admin.managealiases/tree_recursy.tpl" elements=$tree[$cur_lng_id] nbsp_count=0}
                                    </select>
                                    {/if}
                                {elseif ($items->_typeof($item) eq 'checkboxes')}
                                    {foreach from=$items->_get($item) item=ia key=kia}
                                        <input type="checkbox" name="param[{$item}][{$kia}]" value="{$kia}" id="{$item}_{$kia}"{if $values->_eq($item,$kia)} checked="checked"{/if} />
                                        <label for="{$item}_{$kia}">{lang code=$ia}</label><br />
                                    {/foreach}
                                {elseif ($items->_typeof($item) eq 'multiselect')}
                                    <select name="param[{$item}][]" multiple="multiple" style="height:40px;">
                                        {foreach from=$items->_get($item) item=ia key=kia}
                                            <option value="{$kia}"{if $values->_eq($item,$kia) or ($items->_default($item) eq $kia) } selected="selected"{/if}>{lang code=$ia}</option>
                                        {/foreach}
                                    </select>
                                {elseif ($items->_typeof($item) eq 'select')}
                                    <select name="param[{$item}]">
                                        {foreach from=$items->_get($item) item=ia key=kia}
                                            <option value="{$kia}"{if $values->_eq($item,$kia) or ($items->_default($item) eq $kia) } selected="selected"{/if}>{lang code=$ia}</option>
                                        {/foreach}
                                    </select>
                                {elseif $items->_typeof($item) eq 'color'}
                                    <input type="text" id="param[{$item}]" id="param_{$item}" value="{$values->_get($item, $items->_default($item))}" />
                                {elseif ($items->_typeof($item) eq 'checkbox')}
                                    <input type="checkbox" name="param[{$item}]"{if $values->_get($item, $items->_default($item)) eq '1'} checked="checked"{/if} />
                                {elseif ($items->_typeof($item) eq 'pageselect') and isset($pages) and count($pages)}
                                	{if $items->_isMultilang($item)}
                                       {foreach from=$langs item=lng}
                                         {assign var=lngid value=$lng->lng_id}
                                           ({$lng->lng_code})<select name="param[{$item}][lang_{$lng->lng_id}]">
                                               {foreach from=$pages item=page}
                                                    {if $page->pg_langid eq $lng->lng_id}
                                                    <option value="{$page->pg_id}"{if $page->pg_id eq $values->_get( $item, $items->_default($item), $lng->lng_id)} selected="selected"{/if}>{$page->pg_title}</option>
                                                    {/if}
                                               {/foreach}
                                           </select><br />
                                       {/foreach}
                                    {else}
	                                    <select name="param[{$item}]">
	                                        {foreach from=$pages item=page}
	                                        	<option value="{$page->pg_id}"{if $page->pg_id eq $values->_get( $item, $items->_default($item) )} selected="selected"{/if}>{$page->pg_title}</option>
	                                        {/foreach}
	                                    </select>
                                    {/if}
                                {elseif ($items->_typeof($item) eq 'bannerplaceselect') and isset($banner_places) and count($banner_places)}
                                    {if $items->_isMultilang($item)}
                                       {foreach from=$langs item=lng}
                                         {assign var=lngid value=$lng->lng_id}
                                           ({$lng->lng_code})<select name="param[{$item}][lang_{$lng->lng_id}]">
                                               {include file="$_CURRENT_LOAD_PATH/admin.managealiases/tree_recursy.tpl" elements=$banner_places[$lngid] nbsp_count=0 ml=$lng->lng_id values=$values}
                                           </select><br />
                                       {/foreach}
                                    {else}
                                    <select name="param[{$item}]">
                                        {include file="$_CURRENT_LOAD_PATH/admin.managealiases/tree_recursy.tpl" elements=$banner_places[$cur_lng_id] nbsp_count=0}
                                    </select>
                                    {/if}
                                {/if}
                            </td>
                        </tr>
                    {/if}
                    {/foreach}
                </table>
                </form>
            </div>
            {if empty($onlymain)}
            <div id="configPersonal_tabcenter" class="lf_col tabcenter" style="{if $inc_item->params_presonal} display:block;{else} display:none;{/if}width:100%;">
                <form method="post" id="configPersonalFormWindow">
                <input type="hidden" name="inc_id" value="{$inc_id}" />
                <input type="hidden" name="hash" value="{$hash|default:''}" />
                <table cellpadding="0" cellspacing="0" border="0" width="100%">
                    {foreach from=$items->_getParamsNames() item=item key=kid}
                    {if $items->_typeof($item) eq 'hidden'}
                        <input type="hidden" name="paramtype[{$item}]" value="{$items->_typeof($item)}" />
                        <input type="hidden" name="param[{$item}]" value="{$params_orig->_get($item, $items->_default($item))}" />
                    {else}
                       {if $items->_isMultilang($item)}
                           <input type="hidden" name="multilang[{$item}]" value="1" />
                       {/if}
                        <tr>
                            <td valign="top" style="width:200px;">
                                {lang code="`$items->_getName($item)`"}
                            </td>
                            <td align="left" valign="top">
                                <input type="hidden" name="paramtype[{$item}]" value="{$items->_typeof($item)}" />
                                {if ($items->_typeof($item) eq 'integer' or $items->_typeof($item) eq 'int')}
                                    <input type="text" name="param[{$item}]" value="{$params_orig->_get($item, $items->_default($item))}" />
                                {elseif ($items->_typeof($item) eq 'boolean' or $items->_typeof($item) eq 'bool')}
                                    <input type="radio" name="param[{$item}]" id="{$item}_yes" value="1"{if $params_orig->_get($item, $items->_default($item)) eq '1'} checked="checked"{/if} /><label for="{$item}_yes">{lang code='-yes'}</label>
                                    <input type="radio" name="param[{$item}]" id="{$item}_no" value="0"{if $params_orig->_get($item, $items->_default($item)) eq '0'} checked="checked"{/if} /><label for="{$item}_no">{lang code='-no'}</label>
                                {elseif ($items->_typeof($item) eq 'text')}
                                    {if $items->_isMultilang($item)}
                                       {foreach from=$langs item=lng}
                                           {assign var="lngid" value=$lng->lng_id}
                                           ({$lng->lng_code})<input type="text" name="param[{$item}][lang_{$lngid}]" value="{$params_orig->_get($item, $items->_default($item), $lng->lng_id)}" /><br />
                                       {/foreach}
                                    {else}
                                        <input type="text" name="param[{$item}]" value="{$params_orig->_get($item, $items->_default($item))}" />
                                    {/if}
                                {elseif ($items->_typeof($item) eq 'textarea' or $items->_typeof($item) eq 'fckeditor' or $items->_typeof($item) eq 'fck')}
                                    {if $items->_isMultilang($item)}
                                       {foreach from=$langs item=lng}
                                           {assign var="lngid" value=$lng->lng_id}
                                           ({$lng->lng_code})<textarea style="width:90%;" rows="5" name="param[{$item}][lang_{$lngid}]">{$params_orig->_get($item, $items->_default($item), $lng->lng_id)}</textarea><br />
                                       {/foreach}
                                    {else}
                                        <textarea style="width:90%;" rows="5" name="param[{$item}]">{$params_orig->_get($item, $items->_default($item))}</textarea>
                                    {/if}
                                {elseif ($items->_typeof($item) eq 'treenodeselect') or ($items->_typeof($item) eq 'treenode.multiselect')}{*add multiselect=attribute  multiple="multiple"*}
                                    {if $items->_isMultilang($item)}
                                       {foreach from=$langs item=lng}
                                           {assign var=lngid value=$lng->lng_id}
                                           ({$lng->lng_code})<select name="param[{$item}][lang_{$lng->lng_id}]{if $items->_typeof($item) eq 'treenode.multiselect'}[]" multiple="multiple" style="height:100px;"{else}"{/if}>
                                               {include file="$_CURRENT_LOAD_PATH/admin.managealiases/tree_recursy.tpl" elements=$tree[$lngid] nbsp_count=0 ml=$lng->lng_id values=$params_orig}
                                           </select><br />
                                       {/foreach}
                                    {else}
                                    <select name="param[{$item}]{if $items->_typeof($item) eq 'treenode.multiselect'}[]" multiple="multiple" style="height:100px;"{else}"{/if}>
                                        {include file="$_CURRENT_LOAD_PATH/admin.managealiases/tree_recursy.tpl" elements=$tree[$cur_lng_id] nbsp_count=0 values=$params_orig}
                                    </select>
                                    {/if}
                                {elseif ($items->_typeof($item) eq 'checkboxes')}
                                    {foreach from=$items->_get($item) item=ia key=kia}
                                        <input type="checkbox" name="param[{$item}][{$kia}]" value="{$kia}" id="{$item}_{$kia}"{if $params_orig->_eq($item,$kia)} checked="checked"{/if} />
                                        <label for="{$item}_{$kia}">{lang code=$ia}</label><br />
                                    {/foreach}
                                {elseif ($items->_typeof($item) eq 'multiselect')}
                                    <select name="param[{$item}][]" multiple="multiple" style="height:40px;">
                                        {foreach from=$items->_get($item) item=ia key=kia}
                                            <option value="{$kia}"{if $params_orig->_eq($item,$kia) or ($items->_default($item) eq $kia) } selected="selected"{/if}>{lang code=$ia}</option>
                                        {/foreach}
                                    </select>
                                {elseif ($items->_typeof($item) eq 'select')}
                                    <select name="param[{$item}]">
                                        {foreach from=$items->_get($item) item=ia key=kia}
                                            <option value="{$kia}"{if $params_orig->_eq($item,$kia) or ($items->_default($item) eq $kia) } selected="selected"{/if}>{lang code=$ia}</option>
                                        {/foreach}
                                    </select>
                                {elseif $items->_typeof($item) eq 'color'}
                                    <input type="text" id="param[{$item}]" id="param_{$item}" value="{$params_orig->_get($item, $items->_default($item))}" />
                                {elseif ($items->_typeof($item) eq 'checkbox')}
                                    <input type="checkbox" name="param[{$item}]"{if $params_orig->_get($item, $items->_default($item)) eq '1'} checked="checked"{/if} />
                                {elseif ($items->_typeof($item) eq 'pageselect') and isset($pages) and count($pages)}
                                    {if $items->_isMultilang($item)}
                                       {foreach from=$langs item=lng}
                                         {assign var=lngid value=$lng->lng_id}
                                           ({$lng->lng_code})<select name="param[{$item}][lang_{$lng->lng_id}]">
                                               {foreach from=$pages item=page}
                                                   {if $page->pg_langid eq $lng->lng_id}
                                                   <option value="{$page->pg_id}"{if $page->pg_id eq $params_orig->_get( $item, $items->_default($item), $lng->lng_id)} selected="selected"{/if}>{$page->pg_title}</option>
                                                   {/if}
                                               {/foreach}
                                           </select><br />
                                       {/foreach}
                                    {else}
                                        <select name="param[{$item}]">
                                            {foreach from=$pages item=page}
                                                <option value="{$page->pg_id}"{if $page->pg_id eq $params_orig->_get( $item, $items->_default($item) )} selected="selected"{/if}>{$page->pg_title}</option>
                                            {/foreach}
                                        </select>
                                    {/if}
                                {elseif ($items->_typeof($item) eq 'bannerplaceselect') and isset($banner_places) and count($banner_places)}
                                    <select name="param[{$item}]">
                                        {include file="$_CURRENT_LOAD_PATH/admin.managealiases/tree_recursy.tpl" elements=$banner_places[$cur_lng_id] nbsp_count=0 values=$params_orig}
                                    </select>
                                {/if}
                            </td>
                        </tr>
                    {/if}
                    {/foreach}
                </table>
            </div>
            {/if}
            <div class="clear"></div>
        </div>
    </div>
</div>
<table cellpadding="0" cellpadding="0" border="0" width="100%" >
    {if empty($onlymain)}
    <tr>
        <td align="center">
            <input type="checkbox" id="use_personal_only"{if $inc_item->params_presonal} checked="checked"{/if} /><label for="use_personal_only">{lang code='useonlypersonal.system.label'}</label>
        </td>
    </tr>
    {/if}
    <tr>
        <td align="center">
            <input type="button" id="save_config_button" value="{lang code='-submit'}" onclick="RADIncInAlAction.configSubmitClick({$inc_id});" />&nbsp;<input id="cancel_config_button" type="button" value="{lang code='-cancel'}" onclick="RADIncInAlAction.configCancelClick({$inc_id});" />
        </td>
    </tr>
</table>
{/strip}