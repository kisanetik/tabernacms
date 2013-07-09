var SITE_URL = '{const SITE_URL}';
var SITE_ALIAS = '{const SITE_ALIAS}';
{capture assign="SA_PARENT"}{const SITE_ALIAS}{/capture}
{capture assign="SA_PARENT"}{$SA_PARENT|replace:'XML':''}{/capture}
var SITE_ALIAS_PARENT = '{$SA_PARENT}';
var BACK_URL = '{url href="alias=`$SA_PARENT`"}';

//URLS
var LOAD_URL = '{url href="action=getnodes"}';
var EDIT_FORM_URL = '{url href="action=editform"}';
var SAVE_EDIT_URL = '{url href="action=save"}';
var DELETE_NODE_URL = '{url href="action=delete"}';
var ADD_NODE_URL = '{url href="action=add"}';
var EDIT_DETAIL_URL = '{url href="alias=`$SA_PARENT`&action=detailedit"}';
var GET_NEW_PID =  '{url href="action=newlngpid"}';

//COSTANTS
var TREE_THEME = '{url type="image" preset="original" module="core" file="mootree/mootree.gif"}';
var LOADER_ICO = '{url type="image" preset="original" module="core" file="mootree/mootree_loader.gif"}';
var ROOT_PID = '0';

var HASH = '{$hash}';

//TEXTS & MESSAGES
var ROOT_NODE_TEXT = "{lang code="rootnode.menus.text" ucf=true|replace:'"':'&quot;'}";
var ERROR_CHOOSE_ITEM = "{lang code="chooseitem.menus.text" ucf=true|replace:'"':'&quot;'}";
var QUESTION_DELETE_NODE = "{lang code="askdeletenode.menus.query" ucf=true|replace:'"':'&quot;'}";
var ERROR_CHOOSE_ITEM = "{lang code="chooseitem.menus.text" ucf=true|replace:'"':'&quot;'}";
var FAILED_REQUEST = "{lang code="requestisfiled.system.text" ucf=true|replace:'"':'&quot;'}";
var ENTER_NODE_NAME = "{lang code="enternodename.menus.message" ucf=true|replace:'"':'&quot;'}";
var LOADING_TEXT = "{lang code="-loading" ucf=true}";
var LOADED_TEXT = "{lang code="-loaded" ucf=true}";

{literal}
RADTree = {
    tree: null,
    myCounter: 0,
    myNode: null,
    treeArray: null,
    init: function()
    {
        this.tree = new MooTreeControl({
            div: 'rad_mtree',
            mode: 'files',
            theme: TREE_THEME,
            loader: {icon:LOADER_ICO, text:LOADING_TEXT, color:'a0a0a0'},
            grid: true,
            onSelect: function(node, state) {
               if(node.id && state){
                   RADTree.showEditForm(node.id);
               }//if state and node.id
            },
            onLoadComplete: function(node) {
                RADTree.expandNode(node);
            }
        },{
            text: ROOT_NODE_TEXT,
            open: true
        });
        this.tree.disable(); // this stops visual updates while we're building the tree...
        this.tree.root.load(LOAD_URL+'pid/'+ROOT_PID+'/');
        this.tree.root.id = ROOT_PID;
        this.tree.enable(); // this turns visual updates on again.
    },
    checkForm: function()
    {
        if($('treename').value.length=0){
            alert(ENTER_NODE_NAME);
            $('treename').focus();
            return false;
        }
        return true;
    },
    addItemNode: function(id,text)
    {
        if (this.tree.selected){
            var new_node = this.tree.selected.insert( { text:text, data: { name:id} } );
            new_node.id = id;
            this.tree.select( new_node );
        }else{
            alert(ERROR_CHOOSE_ITEM);
        }
    },
    editClick: function()
    {
        if(this.tree && this.tree.selected && this.tree.selected.id){
            RADTree.showEditForm(this.tree.selected.id);
        }else{
            alert(ERROR_CHOOSE_ITEM);
        }
    },
    editDetailClick: function()
    {
       if(this.tree && this.tree.selected && this.tree.selected.id){
           location = EDIT_DETAIL_URL+'tre_id/'+this.tree.selected.id+'/';
        }
    },
    saveClick: function()
    {
        if(this.checkForm()){
            var node_id = this.tree.selected.id;
            var req = new Request({
                url: SAVE_EDIT_URL+'id/'+node_id+'/',
                method: 'post',
                data: $('editTreeForm').toQueryString(),
                onSuccess: function(txt){
                    eval(txt);
                },
                onFailure: function(){
                    alert(FAILED_REQUEST);
                }
            }).send();
        }
    },
    addClick: function()
    {
        if(this.tree.selected) {
            $('TreeMessage').set('html', LOADING_TEXT);
            var req = new Request({
                url: ADD_NODE_URL+'id/'+this.tree.selected.id+'/',
                onSuccess: function(txt){
                    eval(txt);
                    RADTree.message(LOADED_TEXT);
                },
                onFailure: function(){
                    alert(FAILED_REQUEST);
                }
            }).send();
        }else{
            alert(ERROR_CHOOSE_ITEM);
        }
    },
    deleteClick: function()
    {
        if(this.tree && this.tree.selected && this.tree.selected.id && confirm(QUESTION_DELETE_NODE+' "'+this.tree.selected.text+'" ?')){
            var req = new Request({
                url: DELETE_NODE_URL+'id/'+this.tree.selected.id+'/',
                data: {hash:HASH},
                onSuccess: function(txt){
                    eval(txt);
                },
                onFailure: function(){
                    alert(FAILED_REQUEST);
                }
            }).send();
        }
    },
    cancelClick: function()
    {
        $('editTreeBlock').style.visibility = 'hidden';
    },
    showEditForm: function(node_id)
    {
        if(node_id!=0) {
            $('TreeMessage').set('html',LOADING_TEXT);
            var req = new Request({
                url: EDIT_FORM_URL+'node_id/'+node_id+'/',
                onSuccess: function(txt){
                    $('editTreeNode').set("html",txt);
                    $('editTreeBlock').style.visibility = 'visible';
                    RADTree.message(LOADED_TEXT);
                },
                onFailure: function(){
                    alert(FAILED_REQUEST);
                }
            }).send();
        }
    },
    showTreeUploadFrame: function()
    {
        //ERROR_WRONG_EXTENSION
        if( $('tree_divformimage').style.display=='block' ){
            $('tree_divformimage').style.display='none';
        }else{
            $('tree_divformimage').style.display='block';
        }
    },
    changeContntLang: function(lngid,lngcode)
    {
        var req = new Request({
           url: GET_NEW_PID+'i/'+lngid+'/',
           onSuccess: function(txt){
              RADTree.selected_id = undefined;
              eval(txt);
           },
           onFailure: function(){
              alert(FAILED_REQUEST);
           }
       }).send();
    },
    refresh: function()
    {
         this.tree.disable(); // this stops visual updates while we're building the tree...
         this.tree.root.load(LOAD_URL+'pid/'+ROOT_PID+'/');
         this.tree.root.id = ROOT_PID;
         this.tree.enable(); // this turns visual updates on again.
    },
    message: function(message)
    {
        document.getElementById('TreeMessage').innerHTML = message;
        setTimeout("document.getElementById('TreeMessage').innerHTML = '';",5000);
    },
    expandNode: function(node)
    {
        this.myNode = node;
        if ( this.myCounter > 500 ) {
            return;
        }
        this.myCounter++;
        if (this.treeArray) {
            var lenght = this.treeArray.length;
            for(var j=0; j<=lenght-1; j++) {
                var nodes = node.nodes;
                for(var i in nodes) {
                    if (nodes[i].id == RADTree.treeArray[j]) {
                        nodes[i].toggle(true, true);
                        if (j == lenght-1) {
                            RADTree.tree.select(nodes[i]);
                        }    
                    }
                }
            }
        } else {
            setTimeout( "RADTree.expandNode(RADTree.myNode)", 100);
        } 
    }
}
RADhashtree = {
    'hashKey' : 'nic',
    'load_url': LOAD_URL,
    'load'    : function()
    {
        var hash = this.parseValue(window.location.hash);
        if (hash) {
            var url = this.load_url+this.hashKey+'/'+hash+'/';
            var req = new Request({
                url: url,
                onSuccess: function(txt) {
                    RADTree.treeArray = eval(txt);
                },
                onFailure: function() {
                    alert(FAILED_REQUEST);
                }
            }).send();
        }
    },
    'parseValue' : function(value)
    {
        var pattern = this.hashKey == null ? '\w+/([^/]+)$' : this.hashKey + '/([^/]+)';
        var re = new RegExp(pattern, 'i');
        var match = re.exec(value);
        if (match != null) {
            return match[1];
        } else {
            return "";
        }
    }
}

RADCHLangs.addContainer('RADTree.changeContntLang');

window.addEvent('load',function() {
    RADhashtree.load();
    RADTree.init();
});

{/literal}