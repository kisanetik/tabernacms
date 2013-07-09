var SITE_URL = '{const SITE_URL}';
var SITE_ALIAS = '{const SITE_ALIAS}';

//URL'S
var LOAD_URL = '{url href="alias=SYSmanageTreeXML&action=getnodes"}';
var LOAD_USERS_URL = '{url href="action=getusers"}';
var EDIT_FORM_URL = '{url href="action=editform"}';
var DELETE_NODE_URL = '{url href="action=deletenode"}';
var SAVE_NODE_URL = '{url href="action=savenode"}';
var ADD_NODE_URL = '{url href="action=addnode"}';
var ADD_USER_URL = '{url href="action=adduser"}';
var EDIT_USER_URL = '{url href="action=edituser"}';
var SAVE_USER_URL = '{url href="action=save"}';
var CHANGE_PASS_URL = '{url href="action=chpass"}';
var DELETE_USER_URL = '{url href="action=deluser"}';
var SAVE_SETTINGS_URL = '{url href="action=savesettings"}';
var GET_NEW_PID =  '{url href="action=newlngpid"}';

//COSTANTS
var TREE_THEME = '{url type="image" module="core" preset="original" file="mootree/mootree.gif"}';
var LOADER_ICO = '{url type="image" module="core" preset="original" file="mootree/mootree_loader.gif"}';
var ROOT_PID = '{$ROOT_PID}';
var LOADING_TEXT = "{lang code="-loading" ucf=true|replace:'"':'&quot;'}";
var MIN_PASS_LENGTH = {if $params->passMinLength}{$params->passMinLength}{else}4{/if};

var HASH = '{$hash}';

//TEXTS & MESSAGES
var ROOT_NODE_TEXT = "{lang code="rootnode.menus.text" ucf=true|replace:'"':'&quot;'}";
var QUESTION_DELETE_NODE = "{lang code="askdeletenode.menus.query" ucf=true|replace:'"':'&quot;'}";
var ERROR_CHOOSE_ITEM = "{lang code="chooseitem.menus.text" ucf=true|replace:'"':'&quot;'}";
var FAILED_REQUEST = "{lang code="requestisfiled.system.text" ucf=true|replace:'"':'&quot;'}";
var ENTER_NODE_NAME = "{lang code="enternodename.menus.message" ucf=true|replace:'"':'&quot;'}";
var CHOOSE_ITEM = "{lang code="chooseitem.menus.text" ucf=true|replace:'"':'&quot;'}";
var DELETE_GROUP_CONFIRM = "{lang code="deletenodegroup.system.query" ucf=true|replace:'"':'&quot;'}";
var ADD_USER_WINDOW_TITLE = "{lang code="addedituserwindow.system.title" ucf=true|replace:'"':'&quot;'}";
var ENTER_EMAIL_MESSAGE = "{lang code="enteremail.system.message" ucf=true|replace:'"':'&quot;'}";
var ENTER_PASS_MESSAGE = "{lang code="enterpass.system.message" ucf=true|replace:'"':'&quot;'}";
var PASS_MUSTBE_EQ = "{lang code="passmustbeeq.system.message" ucf=true|replace:'"':'&quot;'}";
var ENTER_NEW_PASSWORD = "{lang code="enternewpassword.system.message" ucf=true|replace:'"':'&quot;'}";
var CONFIRM_NEW_PASSWORD = "{lang code="confirmnewpassword.system.message" ucf=true|replace:'"':'&quot;'}";
var REALLY_CHANGE_PASS = "{lang code="reallychangepass.system.query" ucf=true|replace:'"':'&quot;'}";
var PASS_NOT_EQ = "{lang code="passnoteq.system.error" ucf=true|replace:'"':'&quot;'}";
var DELETE_USER_CONFIRM = "{lang code="deleteuser.system.query" ucf=true|replace:'"':'&quot;'}";
var PASS_MIN_LENGTH = "{lang code="passminlength.system.error" ucf=true|replace:'"':'&quot;'} "+MIN_PASS_LENGTH;
var LOADING = "{lang code="-loading" ucf=true|replace:'"':'&quot;'}";

{if $params->_get('ishaveregistration',false)}
{literal}
RADRegSettings = {
    applyClick: function()
    {
        var dataf = $('registration_settings_form').toQueryString();
        dataf += '&'+$('registrationok_settings_form').toQueryString();
        $('RegistrationSettingsMessage').innerHTML = LOADING;
        var req = new Request({
            url: SAVE_SETTINGS_URL,
            method: 'post',
            data: dataf,
            onSuccess: function(txt){
                $('RegistrationSettingsMessage').innerHTML = '';
                eval(txt);
            },
            onFailure: function(){
                alert(FAILED_REQUEST);
                $('RegistrationSettingsMessage').innerHTML = '';
            }
        }).send();
    },
    toggle: function()
    {
        if($('panel_registersettings').style.display == 'none'){
            $('panel_registersettings').style.display='block';
        }else{
            $('panel_registersettings').style.display='none';
        }
    },
    message: function(mes){
        $('RegistrationSettingsMessage').innerHTML = mes;
        setTimeout("$('RegistrationSettingsMessage').innerHTML = '';",5000);
    }
}
RADSTab = {
    change: function(lang_id,start,set)
    {
        $(start).getElements('table').each(function(el){
            //alert('id='+el.id+' class='+el.className)
            if(el.hasClass('set_items'))
                el.style.display="none";
        });
        $(set+lang_id).style.display='';
    }
}
RADTabs = {
    change: function(id)
    {
       $('TabsPanel').getElements('.vkladka').removeClass('activ');
       $(id).className += ' activ';
       $('TabsWrapper').getElements('div[id$=tabcenter]').setStyle('display', 'none');
       if($(id+'_tabcenter')){
           $(id+'_tabcenter').setStyle('display','block');
       }
    }
}
{/literal}
{/if}

{literal}
RADUsers = {
    showWindow: function(url)
    {
        var req = new Request({
            url: url,
            onSuccess: function(txt){
                if($('AddUserWindow')){
                    $('AddUserWindow').destroy();
                }
                if(!$('AddUserWindow')){
                   var wheight = Window.getHeight();
                   if(wheight>400){
                       wheight = 400;
                   }
                   var wnd = new dWindow({
                       id:'AddUserWindow',
                       content: txt,
                       width: 500,
                       height: wheight,
                       minWidth: 180,
                       minHeight: 160,
                       left: 350,
                       top: 150,
                       title: ADD_USER_WINDOW_TITLE
                   }).open($(document.body));
                 }
            },
            onFailure: function(){
                alert(FAILED_REQUEST);
            }
        }).send();
    },
    changePass: function(u_id)
    {
        if(confirm(REALLY_CHANGE_PASS)) {
            var pass1 = prompt(ENTER_NEW_PASSWORD);
            if(pass1 != null) {
                if(pass1.length >= MIN_PASS_LENGTH) {
                    var pass2 = prompt(CONFIRM_NEW_PASSWORD);
                    if(pass2 != null) {
                        if(pass1 == pass2) {
                            if(pass1.length>=MIN_PASS_LENGTH) {
                                var req = new Request({
                                    url: CHANGE_PASS_URL+'u_id/'+u_id+'/',
                                    method: 'post',
                                    data: 'new_pass='+pass1+'&hash='+HASH,
                                    onSuccess: function(txt){
                                        eval(txt);
                                    },
                                    onFailure: function() {
                                        alert(FAILED_REQUEST);
                                    }
                                }).send();
                            } else {
                              alert(PASS_MIN_LENGTH);
                            }
                        } else {
                            alert(PASS_NOT_EQ);
                        }
                    }
                } else {
                    alert(PASS_MIN_LENGTH);
                }
            }
        }
    },
    addClick: function()//when click to add user to show the add user
    {
        if(RADUsersTree.getSID()){
            this.showWindow(ADD_USER_URL+'node_id/'+RADUsersTree.getSID()+'/');
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
        if(RADUsersTree.getSID() && u_id){
            this.showWindow(EDIT_USER_URL+'u_id/'+u_id+'/node_id/'+RADUsersTree.getSID()+'/');
        }
    },
    deleteRow: function(u_id)
    {
        if(confirm(DELETE_USER_CONFIRM)){
            var req = new Request({
                url: DELETE_USER_URL+'u_id/'+u_id+'/',
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
    submitClick: function()//when click submit in add user form
    {
        if($('u_email').value.length>0){
            if(!$('u_pass') || $('u_pass').value.length>0){
                if( !$('u_pass') || ( $('u_pass').value==$('u_pass1').value) ){
                    var req = new Request({
                        url: SAVE_USER_URL+'node_id/'+RADUsersTree.getSID()+'/',
                        method: 'post',
                        data: $('adduser_form').toQueryString(),
                        onSuccess: function(txt){
                            eval(txt);
                        },
                        onFailure: function(){
                            alert(FAILED_REQUEST);
                        }
                    }).send();
                }else{
                    alert(PASS_MUSTBE_EQ);
                    $('u_pass').focus();
                }
            }else{
                alert(ENTER_PASS_MESSAGE);
                $('u_pass').focus();
            }
        }else{
            alert(ENTER_EMAIL_MESSAGE);
            $('u_email').focus();
        }
    },
    cancelClick: function()//when click cancel in add user form
    {
        if($('AddUserWindow')){
            $('AddUserWindow').destroy();
        }
        showAllSelects();
    },
    message: function(message)
    {
        document.getElementById('UsersListMessage').innerHTML = message;
        setTimeout("document.getElementById('UsersListMessage').innerHTML = '';",5000);
    }
}

RADUsersTree = {
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
                   RADUsersTree.listUsers(node.id);
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
                    var tmp = txt.replace('RADTree.','RADUsersTree.');
                    //TEMPROARY QUICK SOLUTION LIKE INDUS!!!! :)))) SUCK DICK MS!
                    for(var i=0;i<5;i++)
                        tmp = tmp.replace('RADTree.','RADUsersTree.');
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
                    $('editUsersTreeNode').set("html",txt);
                    $('editUsersTreeBlock').style.visibility = 'visible';
                },
                onFailure: function(){
                    alert(FAILED_REQUEST);
                }
            }).send();
        }
    },
    cancelEdit: function()
    {
        $('editUsersTreeBlock').style.visibility = 'hidden';
        $('userslist_block').style.visibility = 'hidden'; 
    },
    cancelClick: function(){this.cancelEdit();},
    deleteNode: function()
    {
        if(this.tree && this.tree.selected && this.tree.selected.id && confirm(DELETE_GROUP_CONFIRM)){
            var req = new Request({
                url: DELETE_NODE_URL+'node_id/'+this.tree.selected.id+'/',
                data: {hash:HASH},
                onSuccess: function(txt){
                    var tmp = txt.replace('RADTree.','RADUsersTree.');
                    //TEMPROARY QUICK SOLUTION LIKE INDUS!!!! :)))) SUCK DICK MS!
                    for(var i=0;i<5;i++)
                        tmp = tmp.replace('RADTree.','RADUsersTree.');
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
        if($('treename').value.length==0){
            $('treename').focus();
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
                url: SAVE_NODE_URL+'node_id/'+RADUsersTree.tree.selected.id+'/',
                data: $('editTreeForm').toQueryString(),
                method: 'post',
                onSuccess: function(txt){
                    var tmp = txt.replace('RADTree.','RADUsersTree.');
                    //TEMPROARY QUICK SOLUTION LIKE INDUS!!!! :)))) SUCK DICK FUCKIN MS!
                    for(var i=0;i<5;i++)
                        tmp = tmp.replace('RADTree.','RADUsersTree.');
                    eval(tmp);
                    $('userslist_block').style.visibility = 'visible';
                },
                onFailure: function(){
                    alert(FAILED_REQUEST);
                }
            }).send();
        }
    },
    listUsers: function(tre_id)
    {
        $('UsersListMessage').set('html',LOADING_TEXT);
        var req = new Request({
            url: LOAD_USERS_URL+'node_id/'+tre_id+'/',
            onSuccess: function(txt){
                $('UsersListMessage').set('html','');
                document.getElementById('panel_userslist').innerHTML = txt;
                if(Browser.Engine.trident){
                    $('userslist_block').style.display = 'block';
                    startList();
                }else{
                    $('userslist_block').style.display = 'table';
                }
                $('userslist_block').style.visibility = 'visible';
            },
            onFailure: function(){
                RADUsers.message(FAILED_REQUEST);
                //alert(FAILED_REQUEST);
            }
        }).send();
    },
    changeContntLang: function(lngid,lngcode)
    {
        var req = new Request({
           url: GET_NEW_PID+'i/'+lngid+'/',
           onSuccess: function(txt){
              RADUsersTree.selected_id = undefined;
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
        document.getElementById('UsersTreeMessage').innerHTML = message;
        setTimeout("document.getElementById('UsersTreeMessage').innerHTML = '';",5000);
    }
}

RADCHLangs.addContainer('RADUsersTree.changeContntLang');

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
                        RADUsersTree.tree.select(nodes[i]);
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
    RADUsersTree.init();   
}

{/literal}