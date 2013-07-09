{strip}
<select multiple="multiple" id="product_tree" name="product_tree[]" style="height:100px;width:350px;">
{if isset($trees) and count($trees)}
{include file="$_CURRENT_LOAD_PATH/admin.managecatalog/panels/tree_add_recursy.tpl" elements=$trees nbsp_count=0}
{/if}
</select>
{/strip}