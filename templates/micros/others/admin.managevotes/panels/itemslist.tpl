{strip}
{if count($items)}
<table cellpadding="0" cellspacing="0" border="0" class="tb_list" id="tb_list" width="100%">
    <tr class="header">
        <td>A</td>
        <td>{lang code='name.votes.title'}</td>
        <td>{lang code='datecreated.votes.title'}</td>
        <td>{lang code='position.votes.title'}</td>
        <td>{lang code='-action'}</td>
    </tr>
    {foreach from=$items item=item}
    <tr>
        <td>
          <a id="active_votes_link_{$item->vt_id}_1" href="javascript:RADVotes.setActive(0,{$item->vt_id});" {if !$item->vt_active} style="display:none;"{/if}><img id="img_active_votes_{$item->vt_id}" src="{const SITE_URL}img/actions/activeround.gif" border="0" alt="{lang code='-turnoff'}" title="{lang code='-turnoff'}" /></a>
          <a id="active_votes_link_{$item->vt_id}_0" href="javascript:RADVotes.setActive(1,{$item->vt_id});" {if $item->vt_active} style="display:none;"{/if}><img id="img_active_votes_{$item->vt_id}" src="{const SITE_URL}img/actions/notactiveround.gif" border="0" alt="{lang code='-turnon'}" title="{lang code='-turnon'}" /></a>
        </td>
        <td>{$item->vt_question}</td>
    <td>
      {$item->vt_datecreated}
    </td>
    <td><input type="text" id="vt_position_{$item->vt_id}" value="{$item->vt_position}" onblur="RADVotes.chPos({$item->vt_id});" /></td>
        <td>
            <a href="{url href="alias=OTHmanageVotes&action=editrow&i=`$item->vt_id`"}">
                <img src="{const SITE_URL}img/backend/billiard_marker.png" alt="{lang code='-edit'}" title="{lang code='-edit'}" border="0" />
            </a>
            <a href="javascript:RADVotes.deleteRow({$item->vt_id});">
                <img src="{const SITE_URL}img/backend/icons/cross.png" alt="{lang code='-delete'}" title="{lang code='-delete'}" border="0" />
            </a>
        </td>
    </tr>
    {/foreach}
</table>
{else}
<div align="center">{lang code='norecords.resource.text' ucf=true}</div>
{/if}
{/strip}