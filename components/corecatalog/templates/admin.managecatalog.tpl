{strip}
{if isset($action)}
    {if $action eq 'getjs'}{include file="$_CURRENT_LOAD_PATH/admin.managecatalog/js/getjs.tpl"}{/if}
    {if $action eq 'getjs_product'}{include file="$_CURRENT_LOAD_PATH/admin.managecatalog/js/getjs_addeditproduct.tpl"}{/if}
    {if $action eq 'getTreeNodes' or $action eq 'addNode' or $action eq 'applyEditNode' or $action eq 'deleteNode' or $action eq 'deleteproduct' or $action eq 'getcats' or $action eq 'gettypesed'}{/if}
    {if $action eq 'showEditNode'}{include file="$_CURRENT_LOAD_PATH/admin.managecatalog/panels/tree_edit.tpl"}{/if}
    {if $action eq 'showProductsList'}{include file="$_CURRENT_LOAD_PATH/admin.managecatalog/panels/productslist.tpl"}{/if}
    {if ($action eq 'addProductForm' or $action eq 'editform')}{include file="$_CURRENT_LOAD_PATH/admin.managecatalog/panels/addform.tpl"}{/if}
    {if $action eq 'getjs_addeditproduct'}{include file="$_CURRENT_LOAD_PATH/admin.managecatalog/js/getjs_addeditproduct.tpl"}{/if}
    {if $action eq 'getProductTypes'}{include file="$_CURRENT_LOAD_PATH/admin.managecatalog/js/getproducttypes.tpl"}{/if}
    {if $action eq 'searchproduct'}{include file="$_CURRENT_LOAD_PATH/admin.managecatalog/panels/productslist.tpl"}{/if}
    {if $action eq 'productfileupload'}{include file="$_CURRENT_LOAD_PATH/admin.managecatalog/panels/file-upload.tpl"}{/if}
    {if $action eq '3dbin_genere'}{include file="$_CURRENT_LOAD_PATH/admin.managecatalog/panels/3dimages.tpl"}{/if}
    {if $action eq '3dbin_refresh'}{include file="$_CURRENT_LOAD_PATH/admin.managecatalog/panels/3dimages.tpl"}{/if}
{else}
<div class="w100">
    <div class="kord_right_col">
        {include file="$_CURRENT_LOAD_PATH/admin.managecatalog/panels/getpanels.tpl"}
    </div>
</div>
{/if}
{/strip}