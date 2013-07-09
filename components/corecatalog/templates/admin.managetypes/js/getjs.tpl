var SITE_URL = '{const SITE_URL}';
var SITE_ALIAS = '{const SITE_ALIAS}';
{capture assign="SA_PARENT"}{const SITE_ALIAS}{/capture}
{capture assign="SA_PARENT"}{$SA_PARENT|replace:'XML':''}{/capture}
var SITE_ALIAS_PARENT = '{$SA_PARENT}';
var LOAD_TREE_URL = '{url href="action=getTreeNodes"}';
var EDIT_TREE_URL = '{url href="action=showEditNode"}';
var ADD_TREE_URL = '{url href="action=addNode"}';
var APPLY_EDIT_NODE_URL = '{{url href="action=applyEditNode"}';
var DELETE_TREE_URL = '{url href="action=deleteNode"}';
//SETTING
var LOADER_ICO = '{url type="image" preset="original" module="core" file="mootree/mootree_loader.gif"}';
//LIST LANG VALUES
var LANG_LIST_URL = '{url href="action=showLangsValue"}';
var LANG_EDIT_URL = '{url href="action=editLangValue"}';
var DELETE_PRODUCT_URL = '{url href="action=deletelang"}';
var CHANGE_LANG_URL = '{url href="action=newlang"}';
var ADD_LANG_URL = '{url href="action=addLangForm"}';
var ADD_URL = '{url href="action=add"}';
var SEARCH_PRODUCTS_URL = '{url href="action=searchlang"}';
var DETAIL_EDIT_URL = '{url href="alias=SYSmanageTree&action=detailedit"}';
var DELETE_ITEMSFT_URL = '{url href="action=deleteitemsfromtree"}';

var ROOT_PID = {$ROOT_PID};

var ERROR_CHOOSE_ITEM = "{lang code="chooseitem.catalog.message" ucf=true|replace:'"':'&quot;'}";
var QUESTION_DELETE_NODE = "{lang code="askdeletenode.catalog.query" ucf=true|replace:'"':'&quot;'}";
var ROOT_NODE_NAME = "{lang code="rootnode.catalog.text" ucf=true|replace:'"':'&quot;'}";
/**** LANG ONLY  ****/
  
var TREE_THEME = '{url type="image" preset="original" module="core" file="mootree/mootree.gif"}';

var SELECT_TREE_NODE_MESSAGE = "{lang code="selecttreenode.catalog.error" ucf=true|replace:'"':'&quot;'}";
var DELETE_LANG_QUERY = "{lang code="reallydeletetype.catalog.query" ucf=true|replace:'"':'&quot;'}";

var FAILED_REQUEST = "{lang code="requestisfiled.catalog.error" ucf=true|replace:'"':'&quot;'}";
var CHOOSE_PARENT_NODE = "{lang code="chooseparentnode.catalog.message" ucf=true|replace:'"':'&quot;'}";
var LOADING_TEXT = "{lang code="-loading" ucf=true|replace:'"':'&quot;'}";

{literal}
RADLangTree = {
    tree: null,
    selected_id: null,
    init: function()
    {
        this.tree = new MooTreeControl({
            div: 'rad_mtree',
            mode: 'files',
            theme: TREE_THEME,
            loader: {
                icon:LOADER_ICO, 
                text:LOADING_TEXT, 
                color:'a0a0a0'
            },
            grid: true,
            onSelect: function(node, state) {
                if(node.id && state){
                    RADLangTree.selected_id = node.id;
                    RADLangTree.select(node.id)
                }//if state and node.id
                if(!node.id && state) {
                    RADLangTree.selected_id = ROOT_PID; 
                }
            }
        },{
            text: ROOT_NODE_NAME, 
            open: true 
        });
        this.refresh();
    },
    deleteNode: function()
    {
        if(this.selected_id!=null){
            if(confirm(QUESTION_DELETE_NODE)){
                var req1 = new Request({
                    url: DELETE_ITEMSFT_URL+'node_id/'+RADLangTree.selected_id+'/',
                    method: 'post',
                    onSuccess: function(txt) {
                        var req = new Request({
                            url: DELETE_TREE_URL+'node_id/'+RADLangTree.selected_id+'/',
                            method: 'post',
                            onSuccess: function(txt){
                                eval(txt);
                            },
                            onFailure: function(){
                                alert(FAILED_REQUEST);
                            }
                        }).send();
                    }
                }).send();
            }
        }else{
            alert(CHOOSE_PARENT_NODE);
        }
    },
    add: function()
    {
        if(this.selected_id!=null){
            var req = new Request({
                url: ADD_TREE_URL+'node_id/'+this.selected_id+'/',
                method: 'post',
                onSuccess: function(txt){
                    eval(txt);
                },
                onFailure: function(){
                    alert(FAILED_REQUEST);
                }
            }).send();
        }else{
            alert(CHOOSE_PARENT_NODE);
        }
    },
    editSelected: function()
    {
        if(this.selected_id){
            this.edit(this.selected_id);
        }
    },
    edit: function(node_id)
    {
        var req = new Request({
            url: EDIT_TREE_URL+'node_id/'+node_id+'/',
            method: 'post',
            onSuccess: function(txt){
                $('editLangNode').set("html",txt);
                $('editLangNode').style.display = 'block';
                $('editCatTreeBlock').style.display = 'block';
            },
            onFailure: function(){
                alert(FAILED_REQUEST);
            }
        }).send();
    },
    cancelEdit: function()
    {
        $('editCatTreeBlock').style.display = 'none';
    },
    select: function(node_id)
    {
        //this.edit(node_id);
        RADLangList.node_id = node_id;
        RADLangList.refresh();
    },
    dynamiclyInsert: function(text,id){
        var new_node = this.tree.selected.insert( {
            text:text, 
            'id':id
        } );
        //this.tree.expand();
        this.tree.select( new_node );
    },
    applyEdit: function()
    {
        var req = new Request({
            url: APPLY_EDIT_NODE_URL,
            method: 'post',
            data: $('editNodeForm').toQueryString(),
            onSuccess: function(txt){
                eval(txt);
            },
            onFailure: function(){
                alert(FAILED_REQUEST);
            }
        }).send();
    },
    submitEdit: function()
    {
        this.applyEdit();
        this.cancelEdit();
    },
    refresh: function()
    {
        document.getElementById('LangTreeMessage').innerHTML = LOADING_TEXT;
        this.tree.disable(); // this stops visual updates while we're building the tree...
        this.tree.root.load(LOAD_TREE_URL+'pid/'+ROOT_PID+'/');
        this.tree.enable(); // this turns visual updates on again.
        document.getElementById('LangTreeMessage').innerHTML = '';
    },
    changeContntLang: function(lngid,lngcode)
    {
        var req = new Request({
            url: GET_NEW_PID+'i/'+lngid+'/',
            onSuccess: function(txt){
                $('panel_langlist').set('html','');
                RADLangTree.selected_id = undefined;
                $('editLangNode').style.displey = 'none';
                eval(txt);
            },
            onFailure: function(){
                alert(FAILED_REQUEST);
            }
        }).send();
    },
    message: function(message)
    {
        document.getElementById('LangTreeMessage').innerHTML = message;
        setTimeout("document.getElementById('LangTreeMessage').innerHTML = '';",5000);
    }
}

RADCHLangs.addContainer('RADLangTree.changeContntLang');

RADLangList = {
    message: function(message)
    {
        document.getElementById('LangListMessage').innerHTML = message;
        setTimeout("document.getElementById('LangListMessage').innerHTML='';",5000);
    },
    refresh: function()
    {
        var page_url = '';
        if(isset($('lnv_page')) && typeof($('lnv_page')) != "undefined" && $('lnv_page').value && $('lnv_page').value != false) {
            var page = $('lnv_page').value;
            if(page) {
                page_url = '/page/'+page+'/';
            } else {
                page_url = '/';
            }
        } else {
            page_url = '/';
        } 

        if(RADLangTree.selected_id){
            $('LangListMessage').set('html',LOADING_TEXT);
            var req = new Request({
                url: LANG_LIST_URL+'node_id/'+RADLangTree.selected_id+page_url,
                onSuccess: function(txt){
                    $('panel_langlist').set("html",txt);
                    if(Browser.Engine.trident)
                        startList();
                    $('LangListMessage').set('html','');
                },
                onFailure: function(){
                    $('LangListMessage').set('html','');
                    alert(FAILED_REQUEST);
                }
            }).send();

        }else{
            alert(SELECT_TREE_NODE_MESSAGE);
        }
    },
    paging: function(page){
        if(page && RADLangTree.selected_id) {
            var req = new Request({
                url: LANG_LIST_URL+'node_id/'+RADLangTree.selected_id+'/page/'+page+'/',
                onSuccess: function(txt){
                    //eval(txt);
                    $('LangListMessage').set('html','');
                    $('panel_langlist').set('html',txt);
                },
                onFailure: function(){
                    alert(FAILED_REQUEST);
                }
            }).send();
        } else {
            alert(SELECT_TREE_NODE_MESSAGE);
        }
    },
    changeLangs: function(lang_id) {
        var req = new Request({
            url: CHANGE_LANG_URL+'nl/'+$('langs_'+lang_id).options[$('langs_'+lang_id).selectedIndex].value+'/lang_id/'+lang_id+'/',
            onSuccess: function(txt){
                eval(txt);
                $('LangListMessage').set('html','');
            },
            onFailure: function(){
                $('LangListMessage').set('html','');
                alert(FAILED_REQUEST);
            }
        }).send();
    },   
    changeLangValue: function(lang_id, lnv_lang) {
        if(lang_id && lnv_lang) {
            $('LangListMessage').set('html',LOADING_TEXT);

            var lnv_value = $('lnv_value_'+lang_id).value;
            var lnv_code = document.getElementById('lnv_code_'+lang_id).innerHTML;
            var sw = 'lnv_value='+lnv_value+'&lnv_code='+lnv_code;
            var req = new Request({
                url: LANG_EDIT_URL+'id/'+lang_id+'/lang_id/'+lnv_lang+'/',
                data: sw,
                onSuccess: function(txt) {
                    eval(txt);
                    $('LangListMessage').set('html','');
                },
                onFailure: function() {
                    $('LangListMessage').set('html','');
                    alert(FAILED_REQUEST);
                }
            }).send();

        } else {
            alert(SELECT_TREE_NODE_MESSAGE);
        }
    }, 
    addLang: function()
    {
        var lnv_code = $('lnv_code').value;
        var lnv_value = $('lnv_value').value;
        var lnv_lang = $('lnv_lang').options[$('lnv_lang').selectedIndex].value;
        if( lnv_code && lnv_lang )
        {  
            var sw = 'lnv_code='+lnv_code+'&lnv_value='+lnv_value+'&params=add'; 
            var req = new Request({
                url:ADD_URL+'lnv_lang/'+lnv_lang+'/',
                data: sw,
                onSuccess: function(txt){
                    eval(txt);
                },
                onFailure: function(){
                    alert(FAILED_REQUEST);
                }
            }).send();
        }    else {
            alert(SELECT_TREE_NODE_MESSAGE);
        }  
    },
    addLangValues: function()
    {   

        if(RADLangTree.selected_id) {
            var req = new Request({
                url:ADD_LANG_URL+'lnv_lang/'+RADLangTree.selected_id+'/',
                onSuccess: function(txt){
                    //eval(txt);
                    $('LangListMessage').set('html','');
                    $('panel_langlist').set('html',txt);
                },
                onFailure: function(){
                    alert(FAILED_REQUEST);
                }
            }).send(); 
        } else {
            alert(SELECT_TREE_NODE_MESSAGE);
        }

    },
    search: function()
    {
        if($('searchword').value.length>0 && RADLangTree.selected_id){ 
            var sw = 'searchword='+$('searchword').value;
            $('LangListMessage').set('html',LOADING_TEXT);
            var req = new Request({
                url: SEARCH_PRODUCTS_URL,
                data: sw,
                onSuccess: function(txt){
                    $('LangListMessage').set('html','');
                    $('panel_langlist').set('html',txt);
                },
                onFailure: function(){
                    $('LangListMessage').set('html','');
                    alert(FAILED_REQUEST);
                }
            }).send();
        }else{
            this.refresh();
        }
    },
    deleteRow: function(lang_id) {
        if(RADLangTree.selected_id) {
            if(confirm(DELETE_LANG_QUERY))
            {
                var req = new Request({
                    url:DELETE_PRODUCT_URL+'lang_id/'+lang_id+'/',
                    onSuccess: function(txt){
                        eval(txt);
                    },
                    onFailure: function(){
                        alert(FAILED_REQUEST);
                    }
                }).send();
            }
        } else {
            alert(SELECT_TREE_NODE_MESSAGE);
        }
    }
   
}

window.onload = function(){
    RADLangTree.init();
};

{/literal}