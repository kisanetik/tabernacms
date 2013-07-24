var SITE_ALIAS = '{const SITE_ALIAS}';
var SITE_URL = '{const SITE_URL}';
var MAIN_ACTION = '{$main_action}';

/*URL'S*/
var LOAD_URL = '{url href="action=getnodes"}';
var DELETE_COMPONENT_URL = '{url href="action=deleteComponent"}';
var REINDEX_URL = '{url href="action=getnodes&ma=install&pid=reindex"}';
var SAVE_INCLUDE_URL = '{url href="action=saveinclude"}';
var GETFULL_XMLPARAMS_URL = '{url href="action=getfullxmlparams"}';
var SAVEFULL_XMLPARAMS_URL = '{url href="action=savefullxmlparams"}';
var CONFIGINCLUDE_URL = '{url href="alias=SYSmanageAliasesXML&action=confinclude"}';
var SAVEXMLPARAMS_URL = '{url href="action=savexmlparamsstring"}';
var INSTALLXML_URL = '{url href="action=installXML"}';
var GET_XMLPARAMS_URL = '{url href="action=getxmlparamsstring"}';
var GETFILE_URL = '{url href="action=getfile"}';
var GETFOLDER_URL = '{url href="action=getfolder"}';
var GETMOD_URL = '{url href="action=getmod"}';
var GETINCLUDE_URL = '{url href="action=getinc"}';
var GET_NODES_MA_URL = '{url href="action=getnodes&ma=install"}';
var GET_NODES_REINDEX_URL = '{url href="action=getnodes&ma=install&pid=reindex"}';
var VALIDATE_URL = '{url href="action=validateXML"}';
var GET_PARAMS_SETTINGS_URL = '{url href="action=getParamsSettings"}';
var SAVECONFIG_INCLUDE_URL = '{url href="alias=SYSmanageAliasesXML&action=saveconfinclude&personal=0&onlymain=1"}';

/*COSTANTS*/
var TREE_THEME = '{url type="image" module="core" preset="original" file="mootree/mootree.gif"}';
var LOADER_ICO = '{url type="image" module="core" preset="original" file="mootree/mootree_loader.gif"}';
var CURR_LANG = '{$current_lang}';

var HASH = '{$hash}';

/*TEXTS & MESSAGES*/
var ROOT_NODE_TEXT = "{lang code="rootnode.install.text" ucf=true htmlchars=true}";
var LOADING = "{lang code="-loading" ucf=true htmlchars=true}";
var LOADED = "{lang code="-loaded" ucf=true htmlchars=true}";
var SAVED = "{lang code='-saved' ucf=true htmlchars=true}";
var DELETE_CONFIRM = "{lang code='confirmdelete.repository.query' ucf=true htmlchars=true}";
var INSTALL_XML = "{lang code='confirminstallxml.repository.query' ucf=true htmlchars=true}";
var DELETE = "{lang code='-delete' ucf=true htmlchars=true}";
var SAVING = "{lang code="-saving" ucf=true htmlchars=true}";
var FAILED_REQUEST = "{lang code="requestisfiled.system.message" ucf=true htmlchars=true}";
var XMLPARAMS_WINDOW_TITLE = "{lang code="xmlparamsconfigwindow.system.title" htmlchars=true}";
var XMLCONFIG_WINDOW_TITLE = "{lang code="configincinalwindow.system.title" htmlchars=true}";
var XMLFPARAMS_WINDOW_TITLE = "XMLFPARAMS_WINDOW_TITLE";
var PERM_ERROR = "{lang code="writepermixxtions.system.error" ucf=true htmlchars=true}";

{literal}
RADInstallTree = {
    'tree':null,
    'i':null,
    'PID':null,
    getSID: function()
    {
        if(this.tree && this.tree.selected && this.tree.selected.id){
            return this.tree.selected.id;
        }else{
            return false;
        }
    },
    'editClick': function()
    {
        RADInstallTree.listComponent(RADInstallTree.tree.selected.id);
    },
    'cancelEdit': function()
    {
        $('editComponentTreeBlock').style.visibility = 'hidden';
        $('editComponentTreeNode').set('html', '');
    },
    'deleteComponent':function()
    {
        if (confirm(DELETE_CONFIRM)) {
         $('ComponentTreeMessage').set('html', DELETE);
            var req = new Request({
                url: DELETE_COMPONENT_URL,
                method:'post',
                data:$('editIncludeForm'),
                onSuccess: function(txt){
                    if(txt) {
                        var data = eval("("+ txt +")");
                        var i = data.i;
                        RADInstallTree.message(DELETE);
                    
                        if(i) {
                            var node = RADInstallTree.tree.get( i );

                                if(node) {
                                        node.remove();
                                        var old = RADInstallTree.tree.get( 'reindex' );
                                        if(old) {
                                                old.load(REINDEX_URL);
                                                old.toggle(true, false);
                                                 }
                                            $('editComponentTreeBlock').style.visibility = 'hidden';
                                            $('editComponentTreeNode').set('html', '');
                                        }
                                }
                              }
                           
                },
                onFailure: function(){
                    alert(FAILED_REQUEST);
                    RADInstallTree.message(LOADED);
                }
            }).send();
            
            }
            
    },
    'saveEdit': function()
    {
        if($('editIncludeForm')){
            selAllEl($('system_prelogic'));
            RADInstallTree.message(SAVING);
            var req = new Request({
                url:SAVE_INCLUDE_URL,
                method:'post',
                data:$('editIncludeForm'),
                onSuccess: function(txt){
                    var objtxt = JSON.decode(txt);
                    if(objtxt && objtxt.permission_error) {
                        alert(PERM_ERROR);
                        RADInstallTree.message(PERM_ERROR);
                        return;
                    }
                    RADTreeCreate.init(txt);
                },
                onFailure: function(){
                    alert(FAILED_REQUEST);
                    RADInstallTree.message(LOADED);
                    RADInstallTree.cancelEdit();
                }
            }).send();
        }
    },
    'editDetailClick': function()
    {
        if(RADInstallTree.getSID()){
            $('ComponentTreeMessage').set('html', LOADING);
            var req = new Request({
                url:GETFULL_XMLPARAMS_URL+'i/'+RADInstallTree.getSID()+'/',
                onSuccess: function(txt){
                    if($('editXMLFParamsWindow_'+RADInstallTree.getSID()))
                        $('editXMLFParamsWindow_'+RADInstallTree.getSID()).destroy();
                    var wnd = new dWindow({
                        id:'editXMLFParamsWindow_'+RADInstallTree.getSID(),
                        content: txt,
                        width: 650,
                        height: 550,
                        minWidth: 180,
                        minHeight: 160,
                        left: 300,
                        top: 80,
                        title: XMLFPARAMS_WINDOW_TITLE+RADInstallTree.tree.selected.text,
                        dragable: true
                    }).open($(document.body));
                    editAreaLoader.init({
                        id: "xmlfullparams_text_"+RADInstallTree.getSID() // id of the textarea to transform
                        ,start_highlight: true  // if start with highlight
                        ,allow_resize: "both"
                        ,allow_toggle: true
                        ,language: CURR_LANG
                        ,font_size: "8"
                        ,font_family: "verdana, monospace"
                        ,syntax: "php"
                    });
                    RADInstallTree.message(LOADED);
                },
                onFailure: function(){
                    alert(FAILED_REQUEST);
                    RADInstallTree.message(LOADED);
                }
            }).send();
        }
    },
    'saveDetailClick': function(inc_id)
    {
        if(inc_id){
            $('ComponentTreeMessage').set('html', SAVING);
            $('saveXMLFButton_'+inc_id).style.disabled = true;
            var req = new Request({
                url: SAVEFULL_XMLPARAMS_URL+'i/'+inc_id+'/',
                method:'post',
                data:{'xmlstring':editAreaLoader.getValue('xmlfullparams_text_'+inc_id), 'hash':HASH},
                onSuccess: function(txt){
                    var objtxt = JSON.decode(txt);
                    if(objtxt && objtxt.permission_error) {
                        $('editXMLFParamsWindow_'+inc_id).destroy();
                        alert(PERM_ERROR);
                        RADInstallTree.message(PERM_ERROR);
                        return;
                    }
                    $('editXMLFParamsWindow_'+inc_id).destroy();
                    RADInstallTree.message(SAVED);
                },
                onFailure: function(){
                    alert(FAILED_REQUEST);
                    RADInstallTree.message(LOADED);
                }
            }).send();
        }
    },
    'editConfigClick': function()
    {
        if(RADInstallTree.getSID()){
            $('ComponentTreeMessage').set('html', LOADING);
            var req = new Request({
                url: CONFIGINCLUDE_URL+'inc_id/'+RADInstallTree.getSID()+'/onlymain/true/',
                onSuccess: function(txt){
                    if($('editConfigParamsWindow_'+RADInstallTree.getSID()))
                        $('editConfigParamsWindow_'+RADInstallTree.getSID()).destroy();
                    var wnd = new dWindow({
                        id:'editConfigParamsWindow_'+RADInstallTree.getSID(),
                        content: txt,
                        width: 650,
                        height: 550,
                        minWidth: 180,
                        minHeight: 160,
                        left: 300,
                        top: 80,
                        title: XMLCONFIG_WINDOW_TITLE+RADInstallTree.tree.selected.text,
                        dragable: true
                    }).open($(document.body));
                    RADInstallTree.message(LOADED);
                },
                onFailure: function(){
                    alert(FAILED_REQUEST);
                    RADInstallTree.message(LOADED);
                }
            }).send();
        }
    },
    'saveXMLStringParams': function(inc_id)
    {
        $('ComponentTreeMessage').set('html', SAVING);
        var req = new Request({
            method:'post',
            url:SAVEXMLPARAMS_URL+'i/'+inc_id+'/',
            data: {'xmlstring':editAreaLoader.getValue('wxmlparams_string_'+inc_id), 'hash':HASH},
            onSuccess: function(txt){
                var objtxt = JSON.decode(txt);
                if(objtxt && objtxt.permission_error) {
                    $('editXMLParamsWindow_'+inc_id).destroy();
                    alert(PERM_ERROR);
                    RADInstallTree.message(PERM_ERROR);
                    return;
                }
                RADInstallTree.listComponent(RADInstallTree.tree.selected.id);
                $('editXMLParamsWindow_'+inc_id).destroy();
                RADInstallTree.message('{lang code="-saved" ucf=true}');
            },
            onFailure: function(){
                alert(FAILED_REQUEST);
                RADInstallTree.message(LOADED);
            }
        }).send();
    },
    'installXML': function()
    {
      if (confirm(INSTALL_XML)) {  
        $('ComponentTreeMessage').set('html', SAVING);
        var req = new Request({
            method:'post',
            url:INSTALLXML_URL,
            data:$('editIncludeForm'),
            onSuccess: function(txt){
                try {
                    var objtxt = JSON.decode(txt);
                    if(objtxt && objtxt.permission_error) {
                        alert(PERM_ERROR);
                        RADInstallTree.message(PERM_ERROR);
                    } else {
                        RADTreeCreate.init(txt);
                    }
                } catch(err) {
                    alert(err.message);
                    RADInstallTree.message(err.message);
                }
            },
            onFailure: function(){
                alert(FAILED_REQUEST);
                RADInstallTree.message(LOADED);
            }
        }).send();
       } 
    },
    'editXMLParamsClick': function()
    {
        if(RADInstallTree.getSID()){
            $('ComponentTreeMessage').set('html', LOADING);
            var req = new Request({
                url: GET_XMLPARAMS_URL+'i/'+RADInstallTree.getSID()+'/',
                onSuccess: function(txt){
                    if($('editXMLParamsWindow_'+RADInstallTree.getSID()))
                        $('editXMLParamsWindow_'+RADInstallTree.getSID()).destroy();
                    var wnd = new dWindow({
                        id:'editXMLParamsWindow_'+RADInstallTree.getSID(),
                        content: txt,
                         width: 450,
                         height: 430,
                         minWidth: 180,
                         minHeight: 160,
                         left: 300,
                         top: 80,
                         title: XMLPARAMS_WINDOW_TITLE+RADInstallTree.tree.selected.text,
                         dragable: true
                    }).open($(document.body));
                    editAreaLoader.init({
                        id: "wxmlparams_string_"+RADInstallTree.getSID() // id of the textarea to transform
                        ,start_highlight: true  // if start with highlight
                        ,allow_resize: "both"
                        ,allow_toggle: true
                        ,language: CURR_LANG
                        ,font_size: "8"
                        ,font_family: "verdana, monospace"
                        ,syntax: "php"
                    });
                    RADInstallTree.message(LOADED);
                },
                onFailure: function(){
                    alert(FAILED_REQUEST);
                    RADInstallTree.message(LOADED);
                }
            }).send();
        }
    },
    'listComponent': function(id)
    {
        if(RADInstallTree.tree.selected.data.islast=='1' && 
            !RADInstallTree.tree.selected.data.folder){
            var sa = GETINCLUDE_URL;
            RADIncInParams.paramsLoad(id);
            $('ico_editDetail').style.display='block';
            $('ico_saveDetail').style.display='block';
            $('ico_delDetail').style.display='block'; 
            $('ico_editXMLParams').style.display='block';
            $('ico_Install').style.display='none';
            $('ico_Install_XML').style.display='none';
        }else{
            $('ico_editDetail').style.display='none';
            $('ico_editConfig').style.display='none';
            $('ico_editXMLParams').style.display='none';
            $('ico_Install').style.display='none';
            $('ico_Install_XML').style.display='none';
            $('ico_saveDetail').style.display='none';
            if(RADInstallTree.tree.selected.data.file){
                $('ico_Install').style.display='block';
                RADInstallXML.validateXML(RADInstallTree.tree.selected.data.file, RADInstallTree.tree.selected.data.folder);      
                $('ico_delDetail').style.display='none';
                var sa = GETFILE_URL+'fn/'+RADInstallTree.tree.selected.data.file+'/folder/'+RADInstallTree.tree.selected.data.folder+'/';
            }else if(RADInstallTree.tree.selected.data.folder){
                var sa = GETFOLDER_URL+'folder/'+RADInstallTree.tree.selected.data.folder+'/';
            }else{
                var sa = GETMOD_URL;
                $('ico_saveDetail').style.display='none';
            }
        }
        $('ComponentTreeMessage').set('html', LOADING);
        var req = new Request({
            url: sa+'i/'+id+'/',
            onSuccess: function(txt){
                $('editComponentTreeNode').set('html', txt);
                $('editComponentTreeBlock').style.visibility = 'visible';
                RADInstallTree.message(LOADED);
            },
            onFailure: function(){
                alert(FAILED_REQUEST);
                RADInstallTree.message(LOADED);
            }
        }).send();
    },
    'init': function()
    {
        $('rad_mtree').set('html', '');
        this.tree = new MooTreeControl({
            div: 'rad_mtree',
            mode: 'files',
            theme: TREE_THEME,
            loader: {icon:LOADER_ICO, text:LOADING, color:'a0a0a0'},
            grid: true,
            onSelect: function(node, state) {
               if(node.id && state){
                   RADInstallTree.listComponent(node.id);
               }
            }
        },{
            text: ROOT_NODE_TEXT,
            open: true
        });
        this.tree.disable(); 
        this.tree.root.load(LOAD_URL+'ma/'+MAIN_ACTION+'/');
        this.tree.root.id = null;
        this.tree.enable();
    },
    'message': function(message)
    {
        $('ComponentTreeMessage').set('html',message);
        setTimeout("document.getElementById('ComponentTreeMessage').innerHTML = '';",5000);
    }
}
RADTreeCreate = {
    'init': function(txt) {
        if(txt) {
            if (/^[\],:{}\s]*$/.test(txt.replace(/\\(?:["\\\/bfnrt]|u[0-9a-fA-F]{4})/g, '@')
                .replace(/"[^"\\\n\r]*"|true|false|null|-?\d+(?:\.\d*)?(?:[eE][+\-]?\d+)?/g, ']')
                .replace(/(?:^|:|,)(?:\s*\[)+/g, '')) && txt.length) {
                
                var data = eval("("+ txt +")");
                var pid = data.PID;
                var i = data.i;
                RADInstallTree.PID = pid;
                RADInstallTree.i = i;
                RADInstallTree.message(SAVED);
                RADInstallTree.cancelEdit();
    
                if(pid) {
                    var old = RADInstallTree.tree.get( 'reindex' );
                    var node = RADInstallTree.tree.get( pid );
                    if(node) {
                        RADInstallTree.tree.disable();
                        node.load(GET_NODES_MA_URL+'pid/'+pid+'/');
                        node.open = true;
                        RADInstallTree.tree.enable();
                    } else {
                        RADInstallTree.init();
                        return;
                    }
                    if(old) {
                        old.load(GET_NODES_REINDEX_URL);
                        old.toggle(true, false);
                    }
                } else {
                    if(txt.length) {
                        RADInstallTree.listComponent(txt);
                    }
                }
            } else {
                RADInstallTree.message(SAVED);
                if(txt.length) {
                    RADInstallTree.listComponent(txt);
                }    
            }
        }
    }
}

RADInstallXML = {
    'validateXML': function(fn, folder) {

    if(fn && folder) {
        var req = new Request({
                url: VALIDATE_URL+'fn/'+fn+'/folder/'+folder,
                onSuccess: function(txt) {
                var obj = eval('('+txt+')');
                    if(obj.success == true) {
                        $('ico_Install_XML').style.display='block';
                    } else {
                        $('ico_Install_XML').style.display='none';
                    }
                },
                onFailure: function(){
                    alert(FAILED_REQUEST);
                    RADInstallTree.message(LOADED);
                }
            }).send();
    }

    }
}

RADIncInParams = {
    'params': null,
    'paramsLoad': function(id) {
        if(id){
            var req = new Request({
                url: GET_PARAMS_SETTINGS_URL+'i/'+id+'/',
                onSuccess: function(txt) {
                var obj = eval('('+txt+')');
                    if(obj.success == true) {
                        $('ico_editConfig').style.display='block';
                    } else {
                        $('ico_editConfig').style.display='none';
                    }
                },
                onFailure: function(){
                    alert(FAILED_REQUEST);
                    RADInstallTree.message(LOADED);
                }
            }).send();
        }
    }
}

RADIncInAlAction = {
    'configCount': 2,
    'configSubmitClick': function(inc_id)
    {
        var req = new Request({
            url: SAVECONFIG_INCLUDE_URL,
            data: $('editConfigParamsWindow_'+inc_id).toQueryString(),
            onSuccess: function(txt){
                eval(txt);
            },
            onFailure: function(){
                alert(FAILED_REQUEST);
                RADInstallTree.message(LOADED);
            }
        }).send();
    },
    'configCancelClick': function(inc_id)
    {
        if($('editConfigParamsWindow_'+inc_id))
            $('editConfigParamsWindow_'+inc_id).destroy();
    },
    'message': function(str)
    {
        RADInstallTree.message(str);
    }
}
window.onload = function() {
    RADInstallTree.init();
}
{/literal}