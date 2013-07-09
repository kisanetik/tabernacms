{strip}
<form method="post" onsubmit="RADVotesQuestions.saveAnswerName();return false" id="addeditanswer_form">
<input type="hidden" name="vtq_vtid" value="{$item->vtq_vtid}" />
<input type="hidden" name="vtq_id" value="{$item->vtq_id}" />
<input type="hidden" name="hash" value="{$hash|default:''}" />
<table cellpadding="0" cellspacing="0" border="0" width="100%">
    <tr>
        <td>{lang code='answer.votes.title'}</td>
        <td>
            <input type="text" name="vtq_name" id="vtq_name" value="{$item->vtq_name}" />
        </td>
    </tr>
    <tr>
        <td>
            {lang code='position.votes.title' ucf=true}
        </td>
        <td>
            <input type="text" name="vtq_position" id="vtq_position" value="{$item->vtq_position}" />
        </td>
    </tr>
    <tr>
        <td colspan="2" align="center">
            <input type="submit" value="{lang code='-submit' ucf=true}" />&nbsp;<input type="button" onclick="RADVotesQuestions.cancelWindowClick();" value="{lang code='-cancel' ucf=true}" />
        </td>
    </tr>
</table>
</form>
{/strip}