{strip}
<table cellpadding="0" cellspacing="0" border="0" width="100%" class="tb_list" id="tb_list">
  {if isset($items) and count($items)}
  <tr class="header">
    <td width="90%">{lang code='answer.votes.title'}</td>
    <td>{lang code='position.votes.title'}</td>
    <td>{lang code='-action'}</td>
  </tr>
  {foreach from=$items item=item}
  <tr>
    <td>{$item->vtq_name}</td>
    <td>
      <input type="text" onChange="javascript:RADVotesQuestions.chPosRow({$item->vtq_id});" name="vtq_position_{$item->vtq_id}" id="vtq_position_{$item->vtq_id}" style="width:30px;" value="{$item->vtq_position}" onChange="RADVotesQuestions.chPos({$item->vtq_id});" />
    </td>
    <td>
      <a href="javascript:RADVotesQuestions.saveAnswerDialog({$item->vtq_id});">
          <img src="{url type="image" module="core" preset="original" file="backend/billiard_marker.png"}" alt="{lang code='-edit' ucf=true|replace:'"':'&quot;'}" title="{lang code='-edit' ucf=true|replace:'"':'&quot;'}" border="0" />
      </a>
      <a href="javascript:RADVotesQuestions.deleteRow({$item->vtq_id});">
          <img src="{url type="image" module="core" preset="original" file="backend/icons/cross.png"}" alt="{lang code='-delete' ucf=true|replace:'"':'&quot;'}" title="{lang code='-delete' ucf=true|replace:'"':'&quot;'}" border="0" />
      </a>
    </td>
  </tr>
  {/foreach}
  {/if}
</table>
{/strip}