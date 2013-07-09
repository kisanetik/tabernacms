{strip}
<div class="rounded-box-5">

        <b class="r5{if $id->is_ga} r_ga{/if}"></b><b class="r3{if $id->is_ga} r_ga{/if}"></b><b class="r2{if $id->is_ga} r_ga{/if}"></b><b class="r1{if $id->is_ga} r_ga{/if}"></b><b class="r1{if $id->is_ga} r_ga{/if}"></b>
        <div class="inner-box{if $id->is_ga} ga{/if}">
            <h3>
                <div style="width:100%;border-bottom:1px solid white;">
                    <table cellpadding="0" cellspacing="0" border="0" width="100%">
                        <tr>
                            <td width="100%">
                                <font size="3">{$id->inc_name}</font>
                            </td>
                            <td nowrap="nowrap">
                                {if !$id->is_ga}
                                    {if $id->hasOptions}
                                    <a href="javascript:RADIncInAlAction.configOneClick('{$id->incinal_id}');"><img src="{url module="core" preset="original" type="image" file="backend/icons/setting_tools.png"}" alt="{lang code='-config' ucf=true|replace:'"':'&quot;'}" width="17" height="17" border="0"></a>
                                    {/if}
                                    <a href="javascript:RADIncInAlAction.deleteOneClick('{$id->incinal_id}');"><img src="{url module="core" preset="original" type="image" file="backend/icons/cross.png"}" alt="{lang code="-delete" ucf=true|replace:'"':'&quot;'}" width="17" height="17" border="0"></a>
                                {/if}
                            </td>
                        </tr>
                    </table>
                </div>
            </h3>
            <p>
                <table cellpadding="3" cellspacing="3" border="0" width="100%">
                    <tr>
                        <td nowrap="nowrap">
                            {lang code='filenameinclude.system.title'}:&nbsp;
                        </td>
                        <td width="90%" nowrap="nowrap">
                            {$id->m_name}/{$id->inc_filename}
                        </td>
                    </tr>
                    {if isset($id->controllers)}
                    <tr>
                        <td nowrap="nowrap">
                            {lang code='controllerinclude.system.title'}:&nbsp;
                        </td>
                        <td nowrap="nowrap">
                            {if !$id->is_ga}
                            <select name="controller_inc_in_al[{$id->incinal_id}]" onchange="RADIncInAlAction.changed();">
                                {foreach from=$id->controllers key=m_id item=m_val}
                                <option value="{$m_val}"{if $id->controller eq $m_val} selected="selected"{/if}>{$m_val}</option>
                                {/foreach}
                            </select>
                            {else}
                                {$id->controller}
                            {/if}
                        </td>
                    </tr>
                    {/if}
                    <tr>
                        <td nowrap="nowrap">
                            {lang code='positioninclude.system.title'}:&nbsp;
                        </td>
                        <td nowrap="nowrap">
                            {if !$id->is_ga}
                            <select name="position_id[{$id->incinal_id}]" id="position_id_{$id->incinal_id}">
                                {foreach from=$positions item=position}
                                    <option value="{$position->rp_id}"{if $position->rp_id eq $id->rp_id} selected="selectetd"{/if}>{$position->rp_name}</option>
                                {/foreach}
                            </select>
                            {else}
                                {foreach from=$positions item=position}
                                    {if $position->rp_id eq $id->rp_id}{$position->rp_name}{/if}
                                {/foreach}
                            {/if}
                        </td>
                    </tr>
                    <tr>
                        <td nowrap="nowrap">
                            {lang code='orderinclude.system.title'}:&nbsp;
                        </td>
                        <td nowrap="nowrap">
                            {if !$id->is_ga}
                            <input type="text" name="order_sort[{$id->incinal_id}]" id="order_sort_{$id->incinal_id}" value="{$id->order_sort}" style="width:40px;" />
                            {else}
                                {$id->order_sort}
                            {/if}
                        </td>
                    </tr>
                </table>
            </p>
        </div>
        <b class="r1{if $id->is_ga} r_ga{/if}"></b><b class="r1{if $id->is_ga} r_ga{/if}"></b><b class="r2{if $id->is_ga} r_ga{/if}"></b><b class="r3{if $id->is_ga} r_ga{/if}"></b><b class="r5{if $id->is_ga} r_ga{/if}"></b>
    </div>
{/strip}