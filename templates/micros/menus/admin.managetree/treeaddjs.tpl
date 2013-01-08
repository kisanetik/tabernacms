{if !isset($onlySave) and !isset($deleteJS)}
addItemNode('{$item->tre_id}','{$item->tre_name}');
{elseif isset($deleteJS)}
    {if isset($successDel)}
        tree.selected.remove();
        $('editTree').style.display='none';
    {else}
        alert('Delete FAILED');
    {/if}
{else}
	{if isset($isError)}
	    alert('{$message} - rows: {$rows}');
	{else}
		$('editTree').style.display='none';
		tree.selected.text = '{$item->tre_name}';
		tree.selected.update();
	{/if}
{/if}