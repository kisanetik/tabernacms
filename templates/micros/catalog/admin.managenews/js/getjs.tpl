var SITE_URL = '{const SITE_URL}';
var SITE_ALIAS = '{const SITE_ALIAS}';
{capture assign="SA_PARENT"}{const SITE_ALIAS}{/capture}
{capture assign="SA_PARENT"}{$SA_PARENT|replace:'XML':''}{/capture}
var SITE_ALIAS_PARENT = '{$SA_PARENT}';

//URL'S
var LOAD_URL = '{url href="alias=SYSmanageTreeXML&action=getnodes"}';
var LOAD_NEWS_URL = '{url href="action=getnews"}';
var EDIT_FORM_URL = '{url href="action=edit"}';
var DELETE_NODE_URL = '{url href="action=deletenode"}';
var SAVE_NODE_URL = '{url href="action=savenode"}';
var ADD_NODE_URL = '{url href="action=addnode"}';
var ADD_NEWS_URL = '{url href="alias=`$SA_PARENT`&action=editform"}';
var EDIT_NEWS_URL = '{url href="alias=`$SA_PARENT`&action=editform"}';
var SAVE_NEWS_URL = '{url href="action=save"}';
var CHANGE_PASS_URL = '{url href="action=chpass"}';
var DELETE_NEWS_URL = '{url href="action=delnews"}';
var GET_NEW_PID =  '{url href="action=newlngpid"}';
var SET_ACTIVE_URL = '{url href="action=setactive"}';
var GET_SID_URL = '{url href="alias=SYSmanageTree&action=detailedit"}';

//COSTANTS
var TREE_THEME = SITE_URL+'jscss/components/mootree/mootree.gif';
var LOADER_ICO = SITE_URL+'jscss/components/mootree/mootree_loader.gif';
var ROOT_PID = '{$ROOT_PID}';

var HASH = '{$hash}';

//TEXTS & MESSAGES
var ROOT_NODE_TEXT = "{lang code="rootnode.catalog.text" ucf=true|replace:'"':'&quot;'}";
var QUESTION_DELETE_NODE = "{lang code="askdeletenode.catalog.query"|replace:'"':'&quot;'}";
var ERROR_CHOOSE_ITEM = "{lang code="chooseitem.catalog.text"|replace:'"':'&quot;'}";
var FAILED_REQUEST = "{lang code="requestisfiled.catalog.text"|replace:'"':'&quot;'}";
var ENTER_NODE_NAME = "{lang code="enternodename.catalog.message"|replace:'"':'&quot;'}";
var LOADING_TEXT = "{lang code="-loading"|replace:'"':'&quot;'}";
var ENTER_NODE_NAME = "{lang code="enternodename.catalog.message"|replace:'"':'&quot;'}";
var CHOOSE_ITEM = "{lang code="chooseitem.catalog.text"|replace:'"':'&quot;'}";
var DELETE_NEWS_CONFIRM = "{lang code="deletenews.catalog.query"|replace:'"':'&quot;'}";
var DELETE_GROUP_CONFIRM = "{lang code="deletegroup.catalog.query"|replace:'"':'&quot;'}";
var SAVING_TEXT = "{lang code="-saving" ucf=true|replace:'"':'&quot;'}";


{literal}
RADNews = {
    node_id: 0,
    addClick: function()//when click to add user to show the add user
    {
        var sid = RADNewsTree.getSID();
        if(sid && $('rad_mtree')){
            location = ADD_NEWS_URL+'node_id/'+sid+'/';
        }else{
            location = ADD_NEWS_URL+'node_id/'+ROOT_PID+'/';
        }
    },
    searchClick: function()
    {
    },
    searchKeyPress: function(event)
    {
    },
    editRow: function(u_id)
    {
        if(!$('rad_mtree') && u_id){
            location = EDIT_NEWS_URL+'node_id/'+ROOT_PID+'/nw_id/'+u_id+'/';
        }else if(RADNewsTree.getSID() && u_id){
            location = EDIT_NEWS_URL+'node_id/'+RADNewsTree.getSID()+'/nw_id/'+u_id+'/';
        }
    },
    deleteRow: function(n_id)
    {
        if(confirm(DELETE_NEWS_CONFIRM)){
            var req = new Request({
                url: DELETE_NEWS_URL+'n_id/'+n_id+'/',
                data:{hash:HASH},
                onSuccess: function(txt){
                    eval(txt);
                },
                onFailure: function(){
                    alert(FAILED_REQUEST);
                }
            }).send();
        }
    },
    refresh: function()
    {
        var sid = RADNewsTree.getSID();
        if(sid && $('rad_mtree')){
            RADNewsTree.listNews(this.node_id);
        }else{
            RADNewsTree.listNews(ROOT_PID);
        }
    },
    message: function(message)
    {
        document.getElementById('NewsListMessage').innerHTML = message;
        setTimeout("document.getElementById('NewsListMessage').innerHTML = '';",5000);
    },
    setActive: function(active, pid)
    {
       $('NewsListMessage').set('html',SAVING_TEXT);
       var req = new Request({
           url:SET_ACTIVE_URL+'v/'+active+'/c/'+pid+'/',
           data:{hash:HASH},
           onSuccess: function(txt){
              $('NewsListMessage').set('html','');
              eval(txt);
           },
           onFailure: function(){
              alert(FAILED_REQUEST);
           }
       }).send();
    }
}

RADNewsTree = {
    tree: null,
    getSID: function()
    {
        if(this.tree && this.tree.selected && this.tree.selected.id){
            return this.tree.selected.id;
        }else{
            return false;
        }
    },
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
                   RADNewsTree.listNews(node.id);
                   RADNewsTree.cancelEdit();
               }//if state and node.id
            },
            onLoadComplete: function(node)
            {
                expandNode(node);
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
    editDetailClick: function(){
       if(this.getSID()){
           location = GET_SID_URL+'tre_id/'+this.getSID()+'/ref/'+SITE_ALIAS_PARENT+'/';
       }
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
    addClick: function()
    {
        if(this.tree && this.tree.selected && this.tree.selected.id){
            var req = new Request({
                url: ADD_NODE_URL+'node_id/'+this.tree.selected.id+'/',
                onSuccess: function(txt){
                    var tmp = txt.replace('RADTree.','RADNewsTree.');
                    //TEMPROARY QUICK SOLUTION LIKE INDUS!!!! :)))) SUCK DICK FUCKIN MS!
                    for(var i=0;i<5;i++)
                        tmp = tmp.replace('RADTree.','RADNewsTree.');
                    eval(tmp);
                },
                onFailure: function(){
                    alert(FAILED_REQUEST);
                }
            }).send();
        }
    },
    editClick: function()
    {
        if(this.tree && this.tree.selected && this.tree.selected.id){
            var req = new Request({
                url: EDIT_FORM_URL+'node_id/'+this.tree.selected.id+'/',
                onSuccess: function(txt){
                    $('editNewsTreeNode').set("html",txt);
                    $('editNewsTreeBlock').style.visibility = 'visible';
                },
                onFailure: function(){
                    alert(FAILED_REQUEST);
                }
            }).send();
        }
    },
    cancelEdit: function()
    {
        $('editNewsTreeBlock').style.visibility = 'hidden';
    },
    cancelClick: function(){this.cancelEdit();},
    deleteNode: function()
    {
        if(this.tree && this.tree.selected && this.tree.selected.id && confirm(DELETE_GROUP_CONFIRM)){
            var req = new Request({
                url: DELETE_NODE_URL+'node_id/'+this.tree.selected.id+'/',
                data:{hash:HASH},
                onSuccess: function(txt){
                    var tmp = txt.replace('RADTree.','RADNewsTree.');
                    //TEMPROARY QUICK SOLUTION LIKE INDUS!!!! :)))) SUCK DICK FUCKIN MS!
                    for(var i=0;i<5;i++)
                        tmp = tmp.replace('RADTree.','RADNewsTree.');
                    eval(tmp);
                },
                onFailure: function(){
                    alert(FAILED_REQUEST);
                }
            }).send();
        }
    },
    checkForm: function()
    {
        if($('tre_name').value.length==0){
            $('tre_name').focus();
            alert(ENTER_NODE_NAME);
            return false;
        }
        if(this.tree.selected.id<=0){
            alert(CHOOSE_ITEM);
            return false;
        }
        return true;
    },
    saveEdit: function()
    {
        if(this.checkForm()){
            var req = new Request({
                url: SAVE_NODE_URL+'node_id/'+RADNewsTree.getSID()+'/',
                data: $('editnode_form').toQueryString(),
                method: 'post',
                onSuccess: function(txt){
                    var tmp = txt.replace('RADTree.','RADNewsTree.');
                    //TEMPROARY QUICK SOLUTION LIKE INDUS!!!! :)))) SUCK DICK FUCKIN MS!
                    for(var i=0;i<5;i++)
                        tmp = tmp.replace('RADTree.','RADNewsTree.');
                    eval(tmp);
                },
                onFailure: function(){
                    alert(FAILED_REQUEST);
                }
            }).send();
        }
    },
    listNews: function(tre_id,page)
    {
        page = page || 1;
        var req = new Request({
            url: LOAD_NEWS_URL+'node_id/'+tre_id+'/p/'+page+'/',
            onSuccess: function(txt){
                $('panel_newslist').set('html',txt);
                if(Browser.Engine.trident){
                    $('newslist_block').style.display = 'block';
                    startList();
                }else{
                    $('newslist_block').style.display = 'table';
                }
            },
            onFailure: function(){
                alert(FAILED_REQUEST);
            }
        }).send();
    },
    paging: function(p){
        $('td_paging').set('html','<img src="jscss/tree/mootree/dist/mootree_loader.gif" border="0" />');
        var sid = RADNewsTree.getSID();
        if(sid && $('rad_mtree')){
            RADNewsTree.listNews(sid,p);
        }else{
            RADNewsTree.listNews(ROOT_PID,p);
        }
    },
    refresh: function()
    {
        this.tree.disable(); // this stops visual updates while we're building the tree...
        this.tree.root.load(LOAD_URL+'pid/'+ROOT_PID+'/');
        this.tree.root.id = ROOT_PID;
        this.tree.enable(); // this turns visual updates on again.
    },
    changeContntLang: function(lngid,lngcode)
    {
       var req = new Request({
           url: GET_NEW_PID+'i/'+lngid+'/',
           onSuccess: function(txt){
              $('panel_newslist').set('html','');
              $('newslist_block').style.display = 'none';
              if(RADNewsTree.tree.selected)
                RADNewsTree.tree.selected.id = undefined;
              eval(txt);
           },
           onFailure: function(){
              alert(FAILED_REQUEST);
           }
       }).send();
    },
    message: function(message)
    {
        document.getElementById('NewsTreeMessage').innerHTML = message;
        setTimeout("document.getElementById('NewsTreeMessage').innerHTML = '';",5000);
    }
}
RADCHLangs.addContainer('RADNewsTree.changeContntLang');

// -- Extand a tree
var treeArray = null;
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
                onSuccess: function(txt)
                {
                    treeArray = eval(txt);
                },
                onFailure: function()
                {
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

var myCounter = 0;
var myNode = null;
function expandNode(node)
{
    myNode = node;
    if ( myCounter > 500 ) {
        //alert ('timeout');
        return;
    }
    myCounter++;
    if (treeArray) {
        var lenght = treeArray.length;
        for(var j=0; j<=lenght-1; j++) {
            var nodes = node.nodes;
            for(var i in nodes)
            {
                if (nodes[i].id == treeArray[j]) {
                    nodes[i].toggle(true, true);
                    if (j == lenght-1) {
                        RADNewsTree.tree.select(nodes[i]);
                    }    
                }
            }
        }
    } else {
        setTimeout( "expandNode(myNode)", 100);
    }   
}
// -- Expand a tree

{/literal}
{if !$params->_get('hassubcats',false)}
{literal}
window.onload = function() {
RADNews.node_id = ROOT_PID;
RADNews.refresh();

}
{/literal}{else}{literal}
window.onload = function() {
    RADhashtree.load();
    RADNewsTree.init();
}
{/literal}
{/if}