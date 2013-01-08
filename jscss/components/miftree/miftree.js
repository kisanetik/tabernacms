var Builder = {
	root: '/jscss/components/miftree/',
	paths: {
		source: 'Source'
	},
	included: {
		source: {}
	},
	scripts: {
		source: {
			'Core'      : ['Mif.Tree', 'Mif.Tree.Node', 'Mif.Tree.Hover', 'Mif.Tree.Selection', 'Mif.Tree.Load', 'Mif.Tree.Draw'],
			'More'   : ['Mif.Tree.KeyNav', 'Mif.Tree.Sort', 'Mif.Tree.Transform', 'Mif.Tree.Drag', 'Mif.Tree.Drag.Element', 'Mif.Tree.Checkbox', 'Mif.Tree.Rename', 'Mif.Tree.CookieStorage']
		}
	},
	initialize: function(root){
		if (root) this.root = root;
		this.includeType('source');
		return this;
	},
	getFolder: function(type, file){
		var scripts = this.scripts[type];
		for (var folder in scripts){
			for (var i = 0; i < scripts[folder].length; i++){
				var script = scripts[folder][i];
				if (script == file) return folder;
			}
		}
		return false;
	},
	getRequest: function(){
		var pairs = window.location.search.substring(1).split('&');
		var obj = {};
		for (var i = 0, l = pairs.length; i < l; i++){
			var pair = pairs[i].split('=');
			obj[pair[0]] = pair[1];
		}
		return obj;
	},
	includeFile: function(type, folder, file){
		folder = folder || this.getFolder(type, file);
		if (!folder) return false;
		this.included[type][folder] = this.included[type][folder] || [];
		var files = this.included[type][folder];
		for (var i = 0; i < files.length; i++){
			if (files[i] == file) return false;
		}
		this.included[type][folder].push(file);
		return document.writeln('\t<script type="text/javascript" src="' + this.root + this.paths[type] + '/' + folder + '/' + file + '.js"></script>');
	},
	includeFolder: function(type, folder){
		var scripts = this.scripts[type][folder];
		for (var i = 0, l = scripts.length; i < l; i++) this.includeFile(type, folder, scripts[i]);
	},
	includeType: function(type){
		for (var folder in this.scripts[type]) this.includeFolder(type, folder);
	}
};

Builder.includeType('source');
window.prod_root_url = GET_PRODUCTS_ROOT_URL;
window.prod_url = GET_PRODUCTS_URL;


var RADProductsTree = new Class({
		Implements: Options,
		options: {
			retContainer : '', //container function will be run after checking products
			catId : 0, // root catalog tree id
			params : { //reserve
				param1 : null,
				param2 : null
			}
		},
		
	    initialize: function(options){
	        this.setOptions(options);
	        this.handler = this.options.retContainer;
	    },
	    
	    tree: null,
	    
	    handler: null,
	    
		showProductTree: function() {
			var root_tre_id = this.options.catId;
			var req = new Request({
	            url: OPEN_PRODUCTS_TREE,
	            onSuccess: function(txt){
	                if($('CurrencyAddWindow'))
	                    $('CurrencyAddWindow').destroy();
				    showAllSelects();
	                var wheight = Window.getHeight();
		            if(wheight>680){
		                wheight = 680;
		            }
		            wheight = wheight-100;
	                var wnd = new dWindow({
		                   id:'CurrencyAddWindow',
		                   content: txt,
		                   width: 700,
		                   height: wheight,
		                   minWidth: 360,
		                   minHeight: 320,
		                   left: 300,
		                   top: 30,
		                   title: ADD_PRODUCTS
		               }).open($(document.body));
	                
	                RADProductsTree.tree = new Mif.Tree({
	            		container: $('tree_container'),
	            		initialize: function() {
	            			this.initCheckbox('simple');
	            			new Mif.Tree.KeyNav(this);
	            			this.addEvent('nodeCreate', function(node){
	            				node.set({
	            					property:{
	            						id:	node.getPath()
	            					}
	            				});
	            			});
	            		},
	            		types: {
	            			folder: {
	            				openIcon: 'mif-tree-open-icon',
	            				closeIcon: 'mif-tree-close-icon',
	            				loadable: true
	            			},
	            			empty: {
	            				openIcon: 'mif-tree-open-icon',
	            				closeIcon: 'mif-tree-close-icon',
	            				loadable: false
	            			},
	            			loader: {
	            			    openIcon: 'mif-tree-loader-open-icon',
	            			    closeIcon: 'mif-tree-loader-close-icon',
	            			    DDnotAllowed: ['inside','after']
	            			},
	            			disabled: {
	            				openIcon: 'mif-tree-open-icon',
	            				closeIcon: 'mif-tree-close-icon',
	            				dragDisabled: true,
	            				cls: 'disabled'
	            			},
	            			file: {
	            				openIcon: 'mif-tree-file-open-icon',
	            				closeIcon: 'mif-tree-file-close-icon'
	            			}
	            		},
	            		dfltType: 'folder',
	            		height: 18
	            	});

	                RADProductsTree.tree.load({
	            	    url: prod_root_url + 'pid/' + root_tre_id
	                });
	                
	                RADProductsTree.tree.loadOptions = function(node) {
	                	var geturl = prod_url + 'pid/' + root_tre_id;
	                	if(node.data.npid !== undefined)
                		{
	                		geturl = prod_url + 'pid/' + root_tre_id + '/npid/' + node.data.npid;
                		}
	                	return {
	                		url: geturl
	                		//data: {'npid': node.data.npid}
	                	};
	                };
	            },
	            onFailure: function(){
	                alert(FAILED_REQUEST);
	            }
	        }).send();
		},
		
		treeSubmitClick: function() {
			var getChBx = RADProductsTree.tree.getChecked();
			var chArr = new Array();
			for(var i in getChBx) {
				i = parseInt(i);
				if( typeof i === 'number' && isFinite(i) ) {
					chArr[chArr.length] = { 'name': getChBx[i].name, 'id':getChBx[i].data.product_id};
				}
			}
			if(this.handler.length) {
				eval( this.handler+'(chArr)' );
			}
			this.cancelClick();
		},
		
		cancelClick: function() {
	        $('CurrencyAddWindow').destroy();
			showAllSelects();
		}
});

window.addEvent('domready', function() {
	Mif.Tree.Node.implement({
	    getPath: function(){
	        var path = [];
	        var node = this;
	        while(node){
	            path.push(node.name);
	            node = node.getParent();
	        }
	        return path.reverse().join('/');
	    }
	});
});