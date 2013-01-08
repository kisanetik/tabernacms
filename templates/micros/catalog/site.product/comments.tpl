{strip}
{foreach from=$comments item="comment" name="comm"}
    {include file="$_CURRENT_LOAD_PATH/site.product/comment.tpl" comment=$comment}
   
{foreachelse}
	<div>
		<td>&nbsp;</td>
		<td>{lang code='no_responces.product.text' ucf=true}</td>
    </div>
{/foreach}
{/strip}
