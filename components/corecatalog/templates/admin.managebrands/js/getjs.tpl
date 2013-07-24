var SITE_URL = '{const SITE_URL}';
var SITE_ALIAS = '{const SITE_ALIAS}';
var SITE_ALIAS_PARENT = SITE_ALIAS.replace('XML','');

//URL'S
var LOAD_URL = '{url href="alias=SYSmanageTreeXML&action=getnodes"}';
var LOAD_BRAND_URL = '{url href="action=getbrands"}';
var EDIT_FORM_URL = '{url href="action&edit"}';
var DELETE_NODE_URL = '{url href="action=deletenode"}';
var SAVE_NODE_URL = '{url href="action=savenode"}';
var ADD_NODE_URL = '{url href="action=addnode"}';
var ADD_BRAND_URL = '{url href="action=editform"}';
var EDIT_BRAND_URL = '{url href="action=editform"}';
var SAVE_BRAND_URL = '{url href="action=save"}';
var CHANGE_PASS_URL = '{url href="action=chpass"}';
var DELETE_BRAND_URL = '{url href="action=delbrand"}';
var GET_NEW_PID =  '{url href="action=newlngpid"}';
var GET_SID_URL = '{url href="alias=SYSmanageTree&action=detailedit"}';

//COSTANTS
var TREE_THEME = '{url type="image" preset="original" module="core" file="mootree/mootree.gif"}';
var LOADER_ICO = '{url type="image" preset="original" module="core" file="mootree/mootree_loader.gif"}';
{if !$params->_get('hassubcats',false)}
    var ROOT_PID = '0';
{else}
    var ROOT_PID = '{$ROOT_PID}';
{/if}

//TEXTS & MESSAGES
var ROOT_NODE_TEXT = "{lang code="rootnode.catalog.text" ucf=true htmlchars=true}";
var QUESTION_DELETE_NODE = "{lang code="askdeletenode.catalog.query" ucf=true htmlchars=true}";
var ERROR_CHOOSE_ITEM = "{lang code="chooseitem.catalog.text" ucf=true htmlchars=true}";
var FAILED_REQUEST = "{lang code="requestisfiled.catalog.text" ucf=true htmlchars=true}";
var ENTER_NODE_NAME = "{lang code="enternodename.catalog.message" ucf=true htmlchars=true}";
var LOADING_TEXT = "{lang code="-loading" ucf=true htmlchars=true}";
var ENTER_NODE_NAME = "{lang code="enternodename.catalog.message" ucf=true htmlchars=true}";
var CHOOSE_ITEM = "{lang code="chooseitem.catalog.text" ucf=true htmlchars=true}";
var DELETE_BRAND_CONFIRM = "{lang code="deletebrand.catalog.query" ucf=true htmlchars=true}";
var DELETE_GROUP_CONFIRM = "{lang code="deletegroup.catalog.query" ucf=true htmlchars=true}";
var DONE_MESSAGE = "{lang code="-loaded" ucf=true htmlchars=true}";
var ADD_BRAND_WTITLE = "{lang code="addbrand.catalog.title" ucf=true htmlchars=true}";

var HASH = '{$hash}';

{literal}
RADBrand = {
    node_id: 0,
    addClick: function(i)//when click to add user to show the add user
    {
        $('BrandListMessage').set('html',LOADING_TEXT);
        if(i) {
            var URL = EDIT_BRAND_URL+'node_id/'+ROOT_PID+'/rcb_id/'+i+'/';
        } else {
            var URL = ADD_BRAND_URL+'node_id/'+ROOT_PID+'/';
        }
        var data = {};
        if(i) {
            data.i = i;
        }
        var req = new Request({
            url: URL,
            data: data,
            onSuccess: function(txt) {
                if($('addMesWindow')){
                    $('addMesWindow').destroy();
                }
                if(!$('addMesWindow')){
                   var wheight = Window.getHeight();
                   if(wheight>350){
                       wheight = 350;
                   }
                   wheight = wheight-50;
                   var wnd = new dWindow({
                       id:'addMesWindow',
                       content: txt,
                       width: 550,
                       height: wheight,
                       minWidth: 180,
                       minHeight: 160,
                       left: 350,
                       top: 100,
                       title: ADD_BRAND_WTITLE
                   }).open($(document.body));
                   $('rcb_name').focus();
                }
                RADBrand.message(DONE_MESSAGE);
            }
        }).send();
    },
    searchClick: function()
    {
    },
    searchKeyPress: function(event)
    {
    },
    editRow: function(i)
    {
        RADBrand.addClick(i);
        /*if(!$('rad_mtree') && u_id){
            location = EDIT_BRAND_URL+'node_id/'+ROOT_PID+'/rcb_id/'+u_id+'/';
        }else if(RADBrandTree.getSID() && u_id){
            location = EDIT_BRAND_URL+'node_id/'+RADBrandTree.getSID()+'/rcb_id/'+u_id+'/';
        }*/
    },
    applyClick: function()
    {
        /*if(this.checkForm()){
            $('returntorefferer').value='1';
            $('addedit_form').submit();
        }*/
        var req = new Request({
            url: ADD_BRAND_URL,
            data: $('addedit_form').toQueryString(),
            onSuccess: function(txt){
                if($('addMesWindow')){
                    $('addMesWindow').destroy();
                }
                RADBrandTree.listBrand(ROOT_PID);
            }
        }).send();
    },
    deleteRow: function(n_id)
    {
        if(confirm(DELETE_BRAND_CONFIRM)){
            var req = new Request({
                url: DELETE_BRAND_URL+'n_id/'+n_id+'/',
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
    refreshItems: function()
    {
        $('BrandListMessage').set('html',LOADING_TEXT);
        var req = new Request({
            url: LOAD_BRAND_URL,
            onSuccess: function(txt){
                $('brandList').set('html',txt);
                RADBrand.message(DONE_MESSAGE);
            }
        }).send();
    },
    cancelClick: function(){if($('addMesWindow')){$('addMesWindow').destroy();}},
    refresh: function()
    {
        var sid = RADBrandTree.getSID();
        if(sid && $('rad_mtree')){
            RADBrandTree.listBrand(this.node_id);
        }else{
            RADBrandTree.listBrand(ROOT_PID);
        }
    },
    message: function(message)
    {
        document.getElementById('BrandListMessage').innerHTML = message;
        setTimeout("document.getElementById('BrandListMessage').innerHTML = '';",5000);
    }
}

RADBrandTree = {
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
                   RADBrandTree.listBrand(node.id);
                   RADBrandTree.cancelEdit();
               }//if state and node.id
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
                    var tmp = txt.replace('RADTree.','RADBrandTree.');
                    //TEMPROARY QUICK SOLUTION LIKE INDUS!!!! :)))) SUCK DICK FUCKIN MS!
                    for(var i=0;i<5;i++)
                        tmp = tmp.replace('RADTree.','RADBrandTree.');
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
                    $('editBrandTreeNode').set("html",txt);
                    $('editBrandTreeBlock').style.visibility = 'visible';
                },
                onFailure: function(){
                    alert(FAILED_REQUEST);
                }
            }).send();
        }
    },
    cancelEdit: function()
    {
        $('editBrandTreeBlock').style.visibility = 'hidden';
    },
    cancelClick: function(){this.cancelEdit();},
    deleteNode: function()
    {
        if(this.tree && this.tree.selected && this.tree.selected.id && confirm(DELETE_GROUP_CONFIRM)){
            var req = new Request({
                url: DELETE_NODE_URL+'node_id/'+this.tree.selected.id+'/',
                onSuccess: function(txt){
                    var tmp = txt.replace('RADTree.','RADBrandTree.');
                    //TEMPROARY QUICK SOLUTION LIKE INDUS!!!! :)))) SUCK DICK FUCKIN MS!
                    for(var i=0;i<5;i++)
                        tmp = tmp.replace('RADTree.','RADBrandTree.');
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
                url: SAVE_NODE_URL+'node_id/'+RADBrandTree.getSID()+'/',
                data: $('editnode_form').toQueryString(),
                method: 'post',
                onSuccess: function(txt){
                    var tmp = txt.replace('RADTree.','RADBrandTree.');
                    //TEMPROARY QUICK SOLUTION LIKE INDUS!!!! :)))) SUCK DICK FUCKIN MS!
                    for(var i=0;i<5;i++)
                        tmp = tmp.replace('RADTree.','RADBrandTree.');
                    eval(tmp);
                },
                onFailure: function(){
                    alert(FAILED_REQUEST);
                }
            }).send();
        }
    },
    listBrand: function(tre_id,page)
    {
        page = page || 1;
        var req = new Request({
            url: LOAD_BRAND_URL+'node_id/'+tre_id+'/p/'+page+'/',
            onSuccess: function(txt){
                $('panel_brandlist').set('html',txt);
                if(Browser.Engine.trident){
                    $('brandlist_block').style.display = 'block';
                    startList();
                }else{
                    $('brandlist_block').style.display = 'table';
                }
            },
            onFailure: function(){
                alert(FAILED_REQUEST);
            }
        }).send();
    },
    paging: function(p){
        $('td_paging').set('html','<img src="'+LOADER_ICO+'" border="0" />');
        var sid = RADBrandTree.getSID();
        if(sid && $('rad_mtree')){
            RADBrandTree.listBrand(sid,p);
        }else{
            RADBrandTree.listBrand(ROOT_PID,p);
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
           url: GET_BRAND_PID+'i/'+lngid+'/',
           onSuccess: function(txt){
              $('panel_brandlist').set('html','');
              $('brandlist_block').style.display = 'none';
              if(RADBrandTree.tree.selected)
                RADBrandTree.tree.selected.id = undefined;
              eval(txt);
           },
           onFailure: function(){
              alert(FAILED_REQUEST);
           }
       }).send();
    },
    message: function(message)
    {
        document.getElementById('BrandTreeMessage').innerHTML = message;
        setTimeout("document.getElementById('BrandTreeMessage').innerHTML = '';",5000);
    }
}
RADCHLangs.addContainer('RADBrandTree.changeContntLang');
{/literal}
{if !$params->_get('hassubcats',false)}
{literal}
window.onload = function() {
RADBrand.node_id = ROOT_PID;
RADBrand.refresh();
}
{/literal}{else}{literal}
window.onload = function() {
    RADBrandTree.init();
}
{/literal}
{/if}