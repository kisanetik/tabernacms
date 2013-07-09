var SITE_URL = '{const SITE_URL}';
var SITE_ALIAS = '{const SITE_ALIAS}';
{capture assign="SA_PARENT"}{const SITE_ALIAS}{/capture}
{capture assign="SA_PARENT"}{$SA_PARENT|replace:'XML':''}{/capture}
var SITE_ALIAS_PARENT = '{$SA_PARENT}';

//URL's
var LOAD_URL = '{url href="alias=SYSmanageTreeXML&action=getnodes"}';
var ADD_ITEM_URL = '{url href="alias=`$SA_PARENT`&action=additem"}';
var EDIT_ROW_URL = '{url href="alias=`$SA_PARENT`&action=editrow"}';
var EDIT_TREE_URL = '{url href="action=edittree"}';
var ADD_NODE_URL = '{url href="action=addnode"}';
var SAVE_NODE_URL = '{url href="action=savenode"}';
var DELETE_NODE_URL = '{url href="action=deletenode"}';
var CHANGEPOS_ROW_URL = '{url href="action=chpos"}';
var DELETE_ROW_URL = '{url href="action=deleterow"}';
var GET_NEW_PID = '{url href="action=newlngpid"}';
var SET_ACTIVE_URL = '{url href="action=setactive"}';
var GET_SID_URL = '{url href="alias=SYSmanageTree&action=detailedit"}';
var LOAD_ITEMS_URL = '{url href="action=getitems"}';


//COSTANTS
var TREE_THEME = '{url type="image" preset="original" module="core" file="mootree/mootree.gif"}';
var LOADER_ICO = '{url type="image" preset="original" module="core" file="mootree/mootree_loader.gif"}';
var ROOT_PID = '{$ROOT_PID}';

var HASH = '{$hash}';

//TEXTS & MESSAGES
var ROOT_NODE_TEXT = '{lang code="rootnode.votes.text" ucf=true}';
var LOADING_TEXT = '{lang code="-loading" ucf=true}';
var SAVING_TEXT = '{lang code="-saving" ucf=true}';
var FAILED_REQUEST = '{lang code="requestisfiled.system.text" ucf=true}';
var ERROR_CHOOSE_ITEM = '{lang code="chooseitem.catalog.text" ucf=true}';
var ENTER_NODE_NAME = '{lang code="enternodename.catalog.message" ucf=true}';
var CHOOSE_ITEM = '{lang code="chooseitem.catalog.text" ucf=true}';
var DELETE_GROUP_CONFIRM = '{lang code="deletenodequery.votes.query" ucf=true}';
var DELETE_ITEM_QUERY = '{lang code="deletequery.votes.query" ucf=true}';



{literal}
RADVotesTree = {
    tree: null,
    getSID: function(){
     if(this.tree && this.tree.selected && this.tree.selected.id){
            return this.tree.selected.id;
        }else{
            return false;
        }
  },
  init: function(){
     this.tree = new MooTreeControl({
            div: 'rad_mtree',
            mode: 'files',
            theme: TREE_THEME,
            loader: {icon:LOADER_ICO, text:LOADING_TEXT, color:'a0a0a0'},
            grid: true,
            onSelect: function(node, state) {
               if(node.id && state){
             RADVotes.refresh();
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
  addClick: function()
    {
        if(this.getSID()){
            var req = new Request({
                url: ADD_NODE_URL+'node_id/'+RADVotesTree.getSID()+'/',
                onSuccess: function(txt){
                    var tmp = txt.replace('RADTree.','RADVotesTree.');
                    //TEMPROARY QUICK SOLUTION LIKE INDUS!!!! :)))) SUCK DICK FUCKIN MS!
                    for(var i=0;i<5;i++)
                        tmp = tmp.replace('RADTree.','RADVotesTree.');
                    eval(tmp);
          if(RADVotesTree.getSID()){
             RADVotesTree.editClick();
          }
          $('voteslist_block').style.display = 'none';
                },
                onFailure: function(){
                    alert(FAILED_REQUEST);
                }
            }).send();
        }
    },
  deleteNode: function()
    {
        if(this.getSID() && confirm(DELETE_GROUP_CONFIRM)){
            var req = new Request({
                url: DELETE_NODE_URL+'node_id/'+RADVotesTree.getSID()+'/',
                data: {hash:HASH},
                onSuccess: function(txt){
                    var tmp = txt.replace('RADTree.','RADVotesTree.');
                    //TEMPROARY QUICK SOLUTION LIKE INDUS!!!! :)))) SUCK DICK FUCKIN MS!
                    for(var i=0;i<5;i++)
                        tmp = tmp.replace('RADTree.','RADVotesTree.');
                    eval(tmp);
                    $('voteslist_block').style.display = 'none';
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
  editClick: function()
  {
     if(this.getSID() && ROOT_PID!=this.getSID()){
            var req = new Request({
                url: EDIT_TREE_URL+'node_id/'+RADVotesTree.getSID()+'/',
                onSuccess: function(txt){
                    $('editVotesTreeNode').set("html",txt);
                    $('editVotesTreeBlock').style.visibility = 'visible';
                },
                onFailure: function(){
                    alert(FAILED_REQUEST);
                }
            }).send();
        }
  },
  editDetailClick: function(){
     if(this.getSID()){
         location = GET_SID_URL+'tre_id/'+this.getSID()+'/ref/'+SITE_ALIAS_PARENT+'/';
     }
  },
  saveEdit: function()
    {
        if(this.checkForm()){
            var req = new Request({
                url: SAVE_NODE_URL+'node_id/'+RADVotesTree.getSID()+'/',
                data: $('editnode_form').toQueryString(),
                method: 'post',
                onSuccess: function(txt){
                    var tmp = txt.replace('RADTree.','RADVotesTree.');
                    //TEMPROARY QUICK SOLUTION LIKE INDUS!!!! :)))) SUCK DICK FUCKIN MS!
                    for(var i=0;i<5;i++)
                        tmp = tmp.replace('RADTree.','RADVotesTree.');
                    eval(tmp);
                    $('voteslist_block').style.visibility = 'visible';
                },
                onFailure: function(){
                    alert(FAILED_REQUEST);
                }
            }).send();
        }
    },
  addItemNode: function(id,text)
    {
        if (this.getSID()){
            var new_node = this.tree.selected.insert( { text:text, data: { name:id} } );
            new_node.id = id;
            this.tree.select( new_node );
        }else{
            alert(ERROR_CHOOSE_ITEM);
        }
    },
  cancelClick: function(){
     $('editVotesTreeBlock').style.visibility = 'hidden';
     $('voteslist_block').style.visibility = 'hidden';
  },
  changeContntLang: function(lngid,lngcode)
    {
       var req = new Request({
           url: GET_NEW_PID+'i/'+lngid+'/',
           onSuccess: function(txt){
              $('panel_voteslist').set('html','');
              $('voteslist_block').style.display = 'none';
              if(RADVotesTree.tree.selected)
                RADVotesTree.tree.selected.id = undefined;
              eval(txt);
           },
           onFailure: function(){
              alert(FAILED_REQUEST);
           }
       }).send();
    },
  refresh: function(){
     document.getElementById('VotesTreeMessage').innerHTML = LOADING_TEXT;
       this.tree.disable(); // this stops visual updates while we're building the tree...
       this.tree.root.load(LOAD_URL+'pid/'+ROOT_PID+'/');
       this.tree.enable(); // this turns visual updates on again.
       document.getElementById('VotesTreeMessage').innerHTML = '';
  },
  message: function(mes)
  {
     $('VotesTreeMessage').set('html',mes);
       setTimeout("document.getElementById('VotesTreeMessage').innerHTML = '';",5000);
  }
}
RADVotes = {
    addClick: function()
    {
        if(RADVotesTree.getSID()){
            location = ADD_ITEM_URL+'pid/'+RADVotesTree.getSID()+'/'
        }else{
            alert(CHOOSE_ITEM);
        }
    },
  deleteRow: function(va_id){
     if(confirm(DELETE_ITEM_QUERY)){
        var req = new Request({
            url: DELETE_ROW_URL+'vt_id/'+va_id+'/',
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
  setActive: function(active, pid)
    {
       $('VotesListMessage').set('html',SAVING_TEXT);
       var req = new Request({
           url:SET_ACTIVE_URL+'v/'+active+'/c/'+pid+'/',
           data:{hash:HASH},
           onSuccess: function(txt){
              $('VotesListMessage').set('html','');
              eval(txt);
           },
           onFailure: function(){
              alert(FAILED_REQUEST);
           }
       }).send();
    },
  chPos: function(item_id){
     var new_pos = $('vt_position_'+item_id).value;
     if(new_pos){
        var req = new Request({
            url: CHANGEPOS_ROW_URL+'b/'+item_id+'/p/'+new_pos+'/',
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
       $('VotesListMessage').set('html',LOADING_TEXT);
       if(RADVotesTree.getSID()){
           var req = new Request({
              url:LOAD_ITEMS_URL+'pid/'+RADVotesTree.getSID()+'/',
              onSuccess: function(txt){
                 $('panel_voteslist').set('html',txt);
                 if(Browser.Engine.trident){
                     $('voteslist_block').style.display = 'block';
                     startList();
                 }else{
                     $('voteslist_block').style.display = 'table';
                 }
                 $('VotesListMessage').set('html','');
              },
              onFailure: function(){
                 alert(FAILED_REQUEST);
                 $('VotesListMessage').set('html','');
              }
           }).send();
       }
    },
    message: function(mes)
  {
     $('VotesListMessage').set('html',mes);
     setTimeout("document.getElementById('VotesListMessage').innerHTML = '';",5000);
  }
}
RADCHLangs.addContainer('RADVotesTree.changeContntLang');

window.onload = function() {
    RADVotesTree.init();
}
{/literal}
