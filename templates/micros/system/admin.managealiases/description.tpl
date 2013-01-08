{strip}
<table cellpadding="0" cellspacing="0" border="0" width="100%" class="tb_cont_block" style="width:auto;height:auto;margin-left:10px;" align="left">
	<tr>
		<td align="left">
			
            <div class="inn_components_out" style="width:620px;">
                <div class="inn_components">
                    <div id="TabsPanel" class="vkladki">
                        {if isset($langs) and count($langs)}
                           {foreach from=$langs item=lng}
                               <div id="descriptionTab{$lng->lng_id}" class="vkladka{if $lng->lng_id eq $currLngId} activ{/if}" onclick="RADTabs.change('descriptionTab{$lng->lng_id}');">
                                  <div><div><div>{$lng->lng_name}</div></div></div>
                               </div>
                           {/foreach}
                        {/if}
                        <div class="clear"></div>
                    </div>
                    <form id="description_form" onsubmit="return false;">
                    <input type="hidden" name="alias_id" value="{$item->id}" />
                    <input type="hidden" name="hash" value="{$hash|default:''}" />
                    <div class="und_vkladki">
                        <div id="TabsWrapper" class="wrap">
                            {if isset($langs) and count($langs)}
                               {foreach from=$langs item=lng}
                                  {assign var="lngid" value=$lng->lng_id}
                                  <input type="hidden" id="id_description_for_{$lngid}" name="id_description_for[{$lngid}]" value="{if isset($item->description[$lngid])}{$item->description[$lngid]->ald_id}{else}0{/if}" />
                                   <div id="descriptionTab{$lng->lng_id}_tabcenter" class="lf_col tabcenter" style="width:100%;{if $lng->lng_id eq $currLngId}{else}display:none;{/if}">
                                      <div class="kord_lf_col">
                                        <div class="group_box">
                                            <div class="tit">{lang code="aliasdescription.system.title" ucf=true}</div>
                                            <div class="kord_cont"><textarea id="descriptiontxt_{$lngid}" name="descriptiontxt[{$lngid}]" style="width:98%" rows="10">{if isset($item->description[$lngid])}{$item->description[$lngid]->ald_txt}{/if}</textarea></div>
                                        </div>
                                      </div>
                                   </div>
                               {/foreach}
                            {/if}
                        </div>
                        <div class="clear"></div>
                     </div>
                     </form>
                </div>
            </div>
        </td>
    </tr>
	<tr>
		<td align="center">
			<input type="button" onclick="RADAliDescr.applyClick('{$alias_id}');" value="{lang code='-submit'}" />&nbsp;<input type="button" onclick="RADAliDescr.close();" value="{lang code='-cancel'}">
		</td>
	</tr>
</table>
{/strip}