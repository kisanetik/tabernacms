var SITE_URL = '{const SITE_URL}';
var SITE_ALIAS = '{const SITE_ALIAS}';
{capture assign="SA_PARENT"}{const SITE_ALIAS}{/capture}
{capture assign="SA_PARENT"}{$SA_PARENT|replace:'XML':''}{/capture}
var SITE_ALIAS_PARENT = '{$SA_PARENT}';
var BACK_URL = '{url href="alias=`$SA_PARENT`"}';
var LOAD_TREE_URL = '{url href="action=getTreeNodes"}';
var EDIT_TREE_URL = '{url href="action=showEditNode"}';
var ADD_TREE_URL = '{url href="action=addNode"}';
var APPLY_EDIT_NODE_URL = '{url href="action=applyEditNode"}';
var DELETE_TREE_URL = '{url href="action=deleteNode"}';
//PRODUCTS LIST
var PRODUCTS_LIST_URL = '{url href="action=showProductsList"}';
var ADD_PRODUCT_URL = '{url href="alias=`$SA_PARENT`&action=addProductForm"}';
var DELETE_PRODUCT_URL = '{url href="action=deleteproduct"}';
var SEARCH_PRODUCTS_URL = '{url href="action=searchproduct"}';
var SET_ACTIVE_URL = '{url href="action=setactive"}';
var CHANGE_COST_URL = '{url href="action=newcost"}';
var CHANGE_CURRENCY_URL = '{url href="action=newcur"}';
var CHANGE_ORDER_URL = '{url href="action=neworder"}';
var GET_NEW_PID =  '{url href="action=newlngpid"}';
var LOADER_ICO = SITE_URL+'jscss/components/mootree/mootree_loader.gif';
var LOAD_URL = '{url href="alias=SYSmanageTreeXML&action=getnodes"}';
var DETAIL_EDIT_URL = '{url href="alias=SYSmanageTree&action=detailedit"}';
var DELETE_PRODUCTS_URL = '{url href="action=deleteproducts"}'; 

var ERROR_CHOOSE_ITEM = "{lang code="chooseitem.catalog.message" ucf=true|replace:'"':'&quot;'}";
var QUESTION_DELETE_NODE = "{lang code="askdeletenode.catalog.query" ucf=true|replace:'"':'&quot;'}";
var ROOT_NODE_NAME = "{lang code="rootnode.catalog.text" ucf=true|replace:'"':'&quot;'}";
/**** CATALOG ONLY  ****/
var ROOT_NODE_NAME = '{$root_node->tre_name|replace:'"':'&quot;'}';
var TREE_THEME = SITE_URL+'jscss/components/mootree/mootree.gif';

var SELECT_TREE_NODE_MESSAGE = "{lang code="selecttreenode.catalog.error"|replace:'"':'&quot;'}";
var DELETE_PRODUCT_QUERY = "{lang code="reallydeleteproduct.catalog.query"|replace:'"':'&quot;'}";

var FAILED_REQUEST = "{lang code="requestisfiled.catalog.text"|replace:'"':'&quot;'}";
var CHOOSE_PARENT_NODE = "{lang code="chooseparentnode.catalog.message" ucf=true|replace:'"':'&quot;'}";
var LOADING_TEXT = "{lang code="-loading"|replace:'"':'&quot;'}";

var HASH = '{$hash}';

{literal}

RADhashTree = {
    'hashKey' : 'nic',
    'load_url': LOAD_URL,
    'load'    : function()
    {
        var hash = this.parseValue( window.location.hash );
        if (hash) {
            var url = this.load_url+this.hashKey+'/'+hash+'/';
            var req = new Request({
                url: url,
                onSuccess: function(txt) {
                    treeArray = eval(txt);
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

RADCatalogTree = {
    tree: null,
	selected_id: null,
	init: function()
	{
	   this.tree = new MooTreeControl({
            div: 'rad_mtree',
            mode: 'files',
            theme: TREE_THEME,
            loader: {icon:LOADER_ICO, text:LOADING_TEXT, color:'a0a0a0'},
            grid: true,
            onLoadComplete: function(node) {
                expandNode(node);
            },
            onSelect: function(node, state) {
               if(node.id && state) {
			       RADCatalogTree.selected_id = node.id;
			       RADCatalogTree.select(node.id)
               } /* if state and node.id */
			   if(!node.id && state) {
			       RADCatalogTree.selected_id=ROOT_PID;
			   }
            },
            onLoadComplete: function(node) {
                expandNode(node);
            }
        },{
            text: ROOT_NODE_NAME,
            open: true 
        });
		this.refresh();
	},
	editDetailClick: function()
	{
	   if(this.selected_id!=null) {
	       location = DETAIL_EDIT_URL+'tre_id/'+this.selected_id+'/ref/'+SITE_ALIAS_PARENT+'/'; 
	   }
	},
	deleteNode: function()
	{
	   if(this.selected_id!=null && this.selected_id!=ROOT_PID) {
           if(confirm(QUESTION_DELETE_NODE+'"'+this.tree.selected.text+'"')) {
               var req1 = new Request({
                   url: DELETE_PRODUCTS_URL+'node_id/'+this.selected_id+'/',
                   data:{hash:HASH},
                   method: 'post',
                   onSuccess: function(txt) {
                       if(txt=='ok') {
                           var req = new Request({
                               url: DELETE_TREE_URL+'node_id/'+RADCatalogTree.selected_id+'/',
                               data:{hash:HASH},
                               method: 'post',
                               onSuccess: function(txt) {
                                  eval(txt);
                               },
                               onFailure: function(){
                                   alert(FAILED_REQUEST);
                               }
                           }).send();
                       } else {
                           alert('Some ERROR! Maybe already deleted!');
                       }
                   },
                   onFailure: function() {
                       alert(FAILED_REQUEST);
                   }
               }).send(); 
           }
       }else{
          alert(CHOOSE_PARENT_NODE);
       }
	},
	add: function()
	{
	   if(this.selected_id!=null) {
	       var req = new Request({
	           url: ADD_TREE_URL+'node_id/'+this.selected_id+'/',
	           method: 'post',
	           onSuccess: function(txt) {
	              eval(txt);
	           },
	           onFailure: function() {
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
		   onSuccess: function(txt) {
                    $('editCatalogNode').set("html",txt);
					$('editCatalogNode').style.display = 'block';
					$('editCatTreeBlock').style.display = 'block';
           },
           onFailure: function() {
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
	   RADCatalogList.node_id = node_id;
	   RADCatalogList.refresh();
	},
	dynamiclyInsert: function(text,id)
	{
	   var new_node = this.tree.selected.insert( { text:text, 'id':id } );
       this.tree.select( new_node );
	},
	applyEdit: function()
	{
	   var req = new Request({
	       url: APPLY_EDIT_NODE_URL,
		   method: 'post',
		   data: $('editNodeForm').toQueryString(),
		   onSuccess: function(txt) {
               eval(txt);
           },
           onFailure: function() {
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
	   document.getElementById('CatalogTreeMessage').innerHTML = LOADING_TEXT;
	   this.tree.disable(); /* this stops visual updates while we're building the tree...*/
	   this.tree.root.load(LOAD_TREE_URL+'pid/'+ROOT_PID+'/');
	   this.tree.enable(); /* this turns visual updates on again.*/
	   document.getElementById('CatalogTreeMessage').innerHTML = '';
	},
	changeContntLang: function(lngid,lngcode)
	{
	   var req = new Request({
	       url: GET_NEW_PID+'i/'+lngid+'/',
		   onSuccess: function(txt) {
		      $('panel_cataloglist').set('html','');
              RADCatalogTree.selected_id = undefined;
			  $('editCatalogNode').style.displey = 'none';
		      eval(txt);
		   },
		   onFailure: function() {
		      alert(FAILED_REQUEST);
		   }
	   }).send();
	},
	message: function(message)
	{
	   document.getElementById('CatalogTreeMessage').innerHTML = message;
	   setTimeout("document.getElementById('CatalogTreeMessage').innerHTML = '';",5000);
	}
}

RADCHLangs.addContainer('RADCatalogTree.changeContntLang');

RADCatalogList = {
    changeOrder: function(cat_id)
	{
	   var req = new Request({
           url: CHANGE_ORDER_URL+'no/'+$('cat_position_'+cat_id).value+'/c/'+cat_id+'/',
           data:{hash:HASH},
           onSuccess: function(txt) {
              eval(txt);
           },
           onFailure: function() {
              alert(FAILED_REQUEST);
           }
       }).send();
	},
    changeCurrency: function(cat_id)
	{
	   var req = new Request({
           url: CHANGE_CURRENCY_URL+'nc/'+$('currency_cat_'+cat_id).options[$('currency_cat_'+cat_id).selectedIndex].value+'/c/'+cat_id+'/',
           data:{hash:HASH},
           onSuccess: function(txt) {
              eval(txt);
           },
           onFailure: function() {
              alert(FAILED_REQUEST);
           }
       }).send();
	},
    changeCost: function(cat_id)
	{
	   var req = new Request({
	       url: CHANGE_COST_URL+'nc/'+$('cat_cost_'+cat_id).value+'/c/'+cat_id+'/',
	       data:{hash:HASH},
		   onSuccess: function(txt) {
              eval(txt);
           },
           onFailure: function() {
              alert(FAILED_REQUEST);
           }
	   }).send();
	},
    setActive: function(active,pid)
    {
	   var req = new Request({
	       url:SET_ACTIVE_URL+'v/'+active+'/c/'+pid+'/',
	       data:{hash:HASH},
		   onSuccess: function(txt) {
		      eval(txt);
		   },
		   onFailure: function() {
		      alert(FAILED_REQUEST);
		   }
	   }).send();
    },
    add: function()
	{
	    var sel = '';
		if(RADCatalogTree.selected_id) {
		    sel = 'node_id/'+RADCatalogTree.selected_id+'/';
		}
		location = ADD_PRODUCT_URL+sel; 
	},
	addKeyPress: function(e)
	{
        var key;
        if(window.event) {
            key=window.event.keyCode; /* IE */
        } else {
            key = e.which; /* firefox */
        }
        if(key == 13)
            this.search();
    },//addKeyPress
	search: function()
	{
	   if($('searchword').value.length>0 && RADCatalogTree.selected_id) {
           var sw = 'searchword='+$('searchword').value+'&cat='+RADCatalogTree.selected_id;
		   $('CatalogListMessage').set('html',LOADING_TEXT);
		   var req = new Request({
		       url: SEARCH_PRODUCTS_URL,
			   data: sw,
			   onSuccess: function(txt) {
			       $('CatalogListMessage').set('html','');
                   $('panel_cataloglist').set('html',txt);
               },
               onFailure: function() {
			       $('CatalogListMessage').set('html','');
                   alert(FAILED_REQUEST);
               }
		   }).send();
	   }else{
	       this.refresh();
	   }
	},
	deleteRow: function(cat_id)
	{
		if(confirm(DELETE_PRODUCT_QUERY)) {
			var req = new Request({
				url:DELETE_PRODUCT_URL+'cat_id/'+cat_id+'/',
				data:{hash:HASH},
				onSuccess: function(txt) {
                  eval(txt);
	          },
	          onFailure: function() {
	              alert(FAILED_REQUEST);
	          }
			}).send();
		}
	},
    message: function(message)
    {
        document.getElementById('CatalogListMessage').innerHTML = message;
	    setTimeout("document.getElementById('CatalogListMessage').innerHTML='';",5000);
    },
   refresh: function()
   {
	   if(RADCatalogTree.selected_id) {
	       $('CatalogListMessage').set('html',LOADING_TEXT);
	       var req = new Request({
		      url: PRODUCTS_LIST_URL+'node_id/'+RADCatalogTree.selected_id+'/',
			  onSuccess: function(txt) {
                  $('panel_cataloglist').set('html',txt);
                  if(Browser.Engine.trident) {
                      $('lnv_block').style.display = 'block';
                  } else {
                      $('lnv_block').style.display = 'table';
                  }
			      $('CatalogListMessage').set('html','');
	          },
	          onFailure: function() {
			      $('CatalogListMessage').set('html','');
	              alert(FAILED_REQUEST);
	          }
		   }).send();
	   }else{
	       alert(SELECT_TREE_NODE_MESSAGE);
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
            for(var i in nodes) {
                if (nodes[i].id == treeArray[j]) {
                    nodes[i].toggle(true, true);
                    if (j == lenght-1) {
                        RADCatalogTree.tree.select(nodes[i]);
                    }    
                }
            }
        }
    } else {
        setTimeout( "expandNode(myNode)", 100);
    }
}

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
                onSuccess: function(txt) {
                    treeArray = eval(txt);
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
            for(var i in nodes) {
                if (nodes[i].id == treeArray[j]) {
                    nodes[i].toggle(true, true);
                    if (j == lenght-1) {
                        RADCatalogTree.tree.select(nodes[i]);
                    }    
                }
            }
        }
    } else {
        setTimeout( "expandNode(myNode)", 100);
    }   
}
/* -- Expand a tree  */
window.onload = function(){

    RADCatalogTree.init();
    RADhashtree.load();
};
{/literal}