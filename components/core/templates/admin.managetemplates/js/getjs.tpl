var SITE_URL = '{const SITE_URL}';
var SITE_ALIAS = '{const SITE_ALIAS}';

//URL'S
var LOAD_FILES_URL = '{url href="action=getfiles"}';
var SELET_TREE_URL = '{url href="action=selecttree"}';
var EDIT_TREE_URL  = '{url href="action=editnode"}';
var EDIT_FILE_URL  = '{url href="action=editfile"}';
var SAVE_FILE_URL  = '{url href="action=savefile"}';

//COSTANTS
var TREE_THEME = '{url type="image" module="core" preset="original" file="mootree/mootree.gif"}';
var LOADER_ICO = '{url type="image" module="core" preset="original" file="mootree/mootree_loader.gif"}';
var ROOT_PID = '{$ROOT_PID}';
var LOADING_TEXT = '{lang code="-loading"}';
var CURR_LANG = '{$lang}';

//TEXTS & MESSAGES
var ROOT_NODE_TEXT = "{lang code="rootnode.system.text" ucf=true htmlchars=true}";
var QUESTION_DELETE_NODE = "{lang code="askdeletenode.system.query" ucf=true htmlchars=true}";
var FAILED_REQUEST = "{lang code="requestisfiled.system.text" ucf=true htmlchars=true}";
var EDIT_FILE_WINDOW_TITLE = "{lang code="editfilewindow.system.title" ucf=true htmlchars=true}";

{literal}
RADFoldersTree = {
    tree: null,
    getSID: function()
    {
        if(this.tree && this.tree.selected && this.tree.selected.data.url){
            return this.tree.selected.data.url;
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
            grid: true,
            onSelect: function(node, state) {
                if (state) RADFoldersTree.treeClick();
            }
        },{
            text: ROOT_NODE_TEXT,
            open: true
        });
        this.tree.adopt('adoptme');
    },
    showEdit: function()
    {
        if(this.getSID()){
            var data = this.getSID();
            while(data.indexOf('/')!=-1){data = data.replace('/','@');}
            //IE 6 !!!!!
            $('hidden_data').value = data;
            var req = new Request({
                url: EDIT_TREE_URL,
                //IE 6 AGAIN
                data: $('hiddenform').toQueryString(),
                method: 'post',
                onSuccess: function(txt){
                    $('editFoldersTreeBlock').style.visibility = 'visible';
                    document.getElementById('editFoldersTreeNode').innerHTML = txt;
                },
                onFailure: function(){
                    alert(FAILED_REQUEST);
                }
            }).send();
        }
    },
    treeClick: function()
    {
        if(this.getSID()){
            $('editFoldersTreeBlock').style.visibility = 'hidden';
            var data = this.getSID();
            while(data.indexOf('/')!=-1){data = data.replace('/','@');}
            var req = new Request({
                url: SELET_TREE_URL+'dpath/'+data+'/',
                onSuccess: function(txt){
                    eval(txt);
                },
                onFailure: function(){
                    alert(FAILED_REQUEST);
                }
            }).send();
        }
    },
    cancelEdit: function()
    {
        $('editFoldersTreeBlock').style.visibility = 'hidden';
    },
    editFile: function()
    {
        if(this.getSID()){
            var data = this.getSID();
            RADFolders.editFile(data);
        }
    },
    refresh: function()
    {
    },
    message: function(message)
    {
        document.getElementById('FoldersTreeMessage').innerHTML = message;
        setTimeout("document.getElementById('FoldersTreeMessage').innerHTML = '';",5000);
    }
}

RADFolders = {
    showWindow: function(url,data)
    {
        var req = new Request({
            url: url,
            onSuccess: function(txt){
                if($('EditFileWindow')){
                    $('EditFileWindow').destroy();
                }
                if(!$('EditFileWindow')){
                   var wheight = Window.getHeight();
                   if(wheight>640){
                       wheight = 640;
                   }
                   wheight = wheight-50;
                   var wnd = new dWindow({
                       id:'EditFileWindow',
                       content: txt,
                       width: 600,
                       height: wheight,
                       minWidth: 180,
                       minHeight: 160,
                       left: 445,
                       top: 10,
                       title: EDIT_FILE_WINDOW_TITLE,
                       dragable: true
                   }).open($(document.body));

                   editAreaLoader.init({
                        id: "w_code" // id of the textarea to transform
                        ,start_highlight: true  // if start with highlight
                        ,allow_resize: "both"
                        ,allow_toggle: true
                        ,language: CURR_LANG
                        ,font_size: "9"
                        ,font_family: "verdana, monospace"
                        ,syntax: "php"
                    });

                   $('edif_file_hid').value = data;
                 }
            },
            onFailure: function(){
                alert(FAILED_REQUEST);
            }
        }).send();
    },
    editFile: function(data)
    {
        while(data.indexOf('/')!=-1){data = data.replace('/','@');}
        this.showWindow(EDIT_FILE_URL+'dpath/'+data+'/',data);
    },
    saveWindowClick: function()
    {
        $('w_code').value=editAreaLoader.getValue('w_code');
        var req = new Request({
            url: SAVE_FILE_URL,
            method: 'post',
            data: $('edit_file_form').toQueryString(),
            onSuccess: function(txt){
                eval(txt);
            },
            onFailure: function(){
                alert(FAILED_REQUEST);
            }
        }).send();
    },
    cancelWindowClick: function()
    {
        if($('EditFileWindow')){
            $('EditFileWindow').destroy();
        }
    },
    refresh: function()
    {
    },
    message: function(message)
    {
       document.getElementById('FilesListMessage').innerHTML = message;
       setTimeout("document.getElementById('FilesListMessage').innerHTML = '';",5000);
    }
}


window.onload = function() {
    RADFoldersTree.init();
}

{/literal}