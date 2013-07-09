var SITE_URL = '{const SITE_URL}';
var SITE_ALIAS = '{const SITE_ALIAS}';
{capture assign="SA_PARENT"}{const SITE_ALIAS}{/capture}
{capture assign="SA_PARENT"}{$SA_PARENT|replace:'XML':''}{/capture}
var SITE_ALIAS_PARENT = '{$SA_PARENT}';

//URL'S
var LOAD_URL = '{url href="alias=SYSmanageTreeXML&action=getnodes"}';
var LOAD_ARTICLES_URL = '{url href="action=getarticles"}';
var EDIT_FORM_URL = '{url href="action=edit"}';
var DELETE_NODE_URL = '{url href="action=deletenode"}';
var SAVE_NODE_URL = '{url href="action=savenode"}';
var ADD_NODE_URL = '{url href="action=addnode"}';
var ADD_ARTICLES_URL = '{url href="alias=`$SA_PARENT`&action=editform"}';
var EDIT_ARTICLES_URL = '{url href="alias=`$SA_PARENT`&action=editform"}';
var SAVE_ARTICLES_URL = '{url href="action=save"}';
var CHANGE_PASS_URL = '{url href="action/chpass"}';
var DELETE_ARTICLES_URL = '{url href="action=delarticles"}';
var GET_NEW_PID =  '{url href="action=newlngpid"}';
var SET_ACTIVE_URL = '{url href="action=setactive"}';
var GET_SID_URL = '{url href="alias=SYSmanageTree&action=detailedit"}';

//COSTANTS
var TREE_THEME = '{url type="image" module="core" preset="original" file="mootree/mootree.gif"}';
var LOADER_ICO = '{url type="image" module="core" preset="original" file="mootree/mootree_loader.gif"}';
var ROOT_PID = '{$ROOT_PID}';

var HASH = '{$hash}';

//TEXTS & MESSAGES
var ROOT_NODE_TEXT = "{lang code="rootnode.articles.text" ucf=true|replace:'"':'&quot;'}";
var QUESTION_DELETE_NODE = "{lang code='askdeletenode.articles.query' ucf=true|replace:'"':'&quot;'}";
var ERROR_CHOOSE_ITEM = "{lang code='chooseitem.articles.text' ucf=true|replace:'"':'&quot;'}";
var FAILED_REQUEST = "{lang code='requestisfiled.system.error' ucf=true|replace:'"':'&quot;'}";
var ENTER_NODE_NAME = "{lang code='enternodename.articles.message' ucf=true|replace:'"':'&quot;'}";
var LOADING_TEXT = "{lang code='-loading' ucf=true|replace:'"':'&quot;'}";
var ENTER_NODE_NAME = "{lang code='enternodename.articles.message' ucf=true|replace:'"':'&quot;'}";
var CHOOSE_ITEM = "{lang code='chooseitem.articles.text' ucf=true|replace:'"':'&quot;'}";
var DELETE_ARTICLES_CONFIRM = "{lang code='deletearticles.articles.query' ucf=true|replace:'"':'&quot;'}";
var DELETE_GROUP_CONFIRM = "{lang code='deletegroup.articles.query' ucf=true|replace:'"':'&quot;'}";


{literal}
RADArticles = {
    addClick: function()//when click to add article to show the add article form
    {
        location = ADD_ARTICLES_URL+'nid/'+RADArticlesTree.getSID()+'/';
    },
    searchClick: function()
    {
    },
    searchKeyPress: function(event)
    {
    },
    editRow: function(u_id)
    {
        if(RADArticlesTree.getSID() && u_id){
            location = EDIT_ARTICLES_URL+'nid/'+RADArticlesTree.getSID()+'/id/'+u_id+'/';
        }
    },
    setActive: function(active, pid)
    {
       var req = new Request({
           url:SET_ACTIVE_URL+'v/'+active+'/a/'+pid+'/',
           data:{hash:HASH},
           onSuccess: function(txt){
              eval(txt);
           },
           onFailure: function(){
              alert(FAILED_REQUEST);
           }
       }).send();
    },
    deleteRow: function(art_id)
    {
        if(confirm(DELETE_ARTICLES_CONFIRM)){
            var req = new Request({
                url: DELETE_ARTICLES_URL+'art_id/'+art_id+'/',
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
    message: function(message)
    {
        document.getElementById('ArticlesListMessage').innerHTML = message;
        setTimeout("document.getElementById('ArticlesListMessage').innerHTML = '';",5000);
    }
}

RADArticlesTree = {
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
                   RADArticlesTree.listArticles(node.id);
                   RADArticlesTree.cancelEdit();
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
                    var tmp = txt.replace('RADTree.','RADArticlesTree.');
                    //TEMPROARY QUICK SOLUTION LIKE INDUS!!!! :)))) SUCK DICK FUCKIN MS!
                    for(var i=0;i<5;i++)
                        tmp = tmp.replace('RADTree.','RADArticlesTree.');
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
        if(this.tree && this.tree.selected && this.tree.selected.id && ROOT_PID != this.tree.selected.id){
            var req = new Request({
                url: EDIT_FORM_URL+'node_id/'+this.tree.selected.id+'/',
                onSuccess: function(txt){
                    $('editArticlesTreeNode').set("html",txt);
                    $('editArticlesTreeBlock').style.visibility = 'visible';
                },
                onFailure: function(){
                    alert(FAILED_REQUEST);
                }
            }).send();
        }
    },
    cancelEdit: function()
    {
        $('editArticlesTreeBlock').style.visibility = 'hidden';
        $('articleslist_block').style.visibility = 'hidden';
    },
    cancelClick: function(){this.cancelEdit();},
    deleteNode: function()
    {
        if(this.tree && this.tree.selected && this.tree.selected.id && confirm(DELETE_GROUP_CONFIRM)){
            var req = new Request({
                url: DELETE_NODE_URL+'node_id/'+this.tree.selected.id+'/',
                data:{hash:HASH},
                onSuccess: function(txt){
                    var tmp = txt.replace('RADTree.','RADArticlesTree.');
                    //TEMPROARY QUICK SOLUTION LIKE INDUS!!!! :)))) SUCK DICK FUCKIN MS!
                    for(var i=0;i<5;i++)
                        tmp = tmp.replace('RADTree.','RADArticlesTree.');
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
                url: SAVE_NODE_URL+'node_id/'+RADArticlesTree.getSID()+'/',
                data: $('editnode_form').toQueryString(),
                method: 'post',
                onSuccess: function(txt){
                    var tmp = txt.replace('RADTree.','RADArticlesTree.');
                    //TEMPROARY QUICK SOLUTION LIKE INDUS!!!! :)))) SUCK DICK FUCKIN MS!
                    for(var i=0;i<5;i++)
                        tmp = tmp.replace('RADTree.','RADArticlesTree.');
                    eval(tmp);
                    $('articleslist_block').style.visibility = 'visible';
                },
                onFailure: function(){
                    alert(FAILED_REQUEST);
                }
            }).send();
        }
    },
    listArticles: function(tre_id)
    {
        var req = new Request({
            url: LOAD_ARTICLES_URL+'node_id/'+tre_id+'/',
            onSuccess: function(txt){
                $('panel_articleslist').set('html',txt);
                if(Browser.Engine.trident){
                    $('articleslist_block').style.display = 'block';
                    startList();
                }else{
                    $('articleslist_block').style.display = 'table';
                }
                $('articleslist_block').style.visibility = 'visible';
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
    changeContntLang: function(lngid,lngcode)
    {
       var req = new Request({
           url: GET_NEW_PID+'i/'+lngid+'/',
           onSuccess: function(txt){
              $('panel_articleslist').set('html','');
              $('articleslist_block').style.display = 'none';
              eval(txt);
           },
           onFailure: function(){
              alert(FAILED_REQUEST);
           }
       }).send();
    },
    message: function(message)
    {
        document.getElementById('ArticlesTreeMessage').innerHTML = message;
        setTimeout("document.getElementById('ArticlesTreeMessage').innerHTML = '';",5000);
    }
}
RADCHLangs.addContainer('RADArticlesTree.changeContntLang');

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
                        RADArticlesTree.tree.select(nodes[i]);
                    }    
                }
            }
        }
    } else {
        setTimeout( "expandNode(myNode)", 100);
    }   
}
// -- Expand a tree

window.onload = function() {
    RADhashtree.load();
    RADArticlesTree.init();
}

{/literal}