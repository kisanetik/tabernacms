var SITE_URL = '{const SITE_URL}';
var SITE_ALIAS = '{const SITE_ALIAS}';
var SAVE_ALIAS_URL = '{url href="action=save"}';
var APPLY_INC_URL = '{url href="action=applyinc"}';
var DELETE_ONE_URL = '{url href="action=delinc"}';
var ADD_INCLUDE_URL = '{url href="action=addincludewindow"}';
var SUBMIT_WFORM_URL = '{url href="action=addWinclude"}';
var GETCONTROLLER_WFORM_URL = '{url href="action=getcontrollerjs"}';
var CONFIG_FORM_URL = '{url href="action=confinclude"}';
var SAVECONFIG_FORM_URL = '{url href="action=saveconfinclude"}';
var SHOWEDITSCRIPT_URL = '{url href="action=showeditscript"}';
var SAVEEDITSCRIPT_URL = '{url href="action=saveeditscript"}';
var SAVE_DESCRIPTION_URL = '{url href="action=savedescription"}';
var SHOW_INCLUDES_LIST = '{url href="action=getincludeslist"}';
var DESCRIPTION_WINDOW_URL = '{url href="action=descriptionwindow"}';
var CREATE_RULES_THEME_URL = '{url href="action=createtheme"}';
var DELETE_RULES_THEME_URL = '{url href="action=deletetheme"}';
{capture assign="SA_PARENT"}{const SITE_ALIAS}{/capture}
{capture assign="SA_PARENT"}{$SA_PARENT|replace:'XML':''}{/capture}
var SITE_ALIAS_PARENT = '{$SA_PARENT}';
var BACK_URL = '{url href="alias=`$SA_PARENT`"}';

var CULD_NOT_FINISH_REQUEST = "{lang code="culdnotfinishrequest.system.error"|replace:'"':'&quot;'}";
var CHANGED = "{lang code="changed.system.title" ucf=true|replace:'"':'&quot;'}";
var UPDATED = "{lang code="-updated" ucf=true|replace:'"':'&quot;'}";
var DELETE_INCLUDE_QUERY = "{lang code="deleteincinalias.system.query" ucf=true|replace:'"':'&quot;'}";
var IncFieldTitle = "{lang code="addincinalwindow.system.title" ucf=true|replace:'"':'&quot;'}";
var IncConfigTitle = "{lang code="configincinalwindow.system.title" ucf=true|replace:'"':'&quot;'}";
var ScriptWindowTitle = "{lang code="scripttitleswindow.system.title" ucf=true|replace:'"':'&quot;'}";
var DESCRIPTION_TITLE = "{lang code="aliasdescription.system.title" ucf=true|replace:'"':'&quot;'}";
var CREATE_RULES_THEME_MESSAGE = "{lang code="createrules.themes.message" ucf=true|replace:'"':'&quot;'}";
var DELETE_RULES_THEME_MESSAGE = "{lang code="deleterules.themes.message" ucf=true|replace:'"':'&quot;'}";
var LOADING_MESSAGE = "{lang code="-loading" ucf=true|replace:'"':'&quot;'}";
var EDIT_THEME_TEXT = "{lang code="youeditthemerules.system.text" ucf=true|replace:'"':'&quot;'}";
var CURR_LANG = '{$lang}';
var ENTER_ALIASNAME_MESSAGE = "{lang code="enteraliasname.system.message" ucf=true|replace:'"':'&quot;'}";

var HASH = '{$hash}';

{literal}
RADAliasesAction = {
    applyClick: function(alias_id){
        if($('alias_name').value.length < 1){
            $('aliasInfoMessage').set("html",ENTER_ALIASNAME_MESSAGE);
            return ;
        }
        $('aliasInfoMessage').set("html",LOADING_MESSAGE);
        var data = $('addeditalias').toQueryString();
        var req = new Request({
            url: SAVE_ALIAS_URL,
            data: data,
            method: 'post',
            onSuccess: function(txt){
                eval(txt);
            },
            onFailure: function(){
                $('aliasInfoMessage').set("html",CULD_NOT_FINISH_REQUEST);
                RADAliasesAction.clearTimeout();
            }
        }).send();
    },
    saveClick: function(alias_id){
        if($('alias_name').value.length < 1){
            $('aliasInfoMessage').set("html",ENTER_ALIASNAME_MESSAGE);
            return ;
        }
        $('aliasInfoMessage').set("html",LOADING_MESSAGE);
        var data = $('addeditalias').toQueryString();
        var req = new Request({
            url: SAVE_ALIAS_URL,
            data: data,
            method: 'post',
            onSuccess: function(txt){
            	$('aliasInfoMessage').set("html",UPDATED);
            	location = BACK_URL;
            },
            onFailure: function(){
                $('aliasInfoMessage').set("html",CULD_NOT_FINISH_REQUEST);
                RADAliasesAction.clearTimeout();
            }
        }).send();
    },
    useGA: function(){
        if($('alias_group') && ($('alias_group').selectedIndex > 0)){
            $('template_id').disabled = true;
        }else{
            $('template_id').disabled = false;
        }
    },
    clearTimeout: function()
    {
        setTimeout("$('aliasInfoMessage').set('html','');",5000);
    },
    changed: function()
    {
        $('aliasInfoMessage').set('html',CHANGED);
    }
}
RADIncInAlAction = {
    theme_folder: '',
    configCount:0,
    isSave:false,
    refresh: function()
    {
        if(this.theme_folder==''){
          document.getElementById("inc_h_mes").innerHTML = '';
        }else{
          document.getElementById("inc_h_mes").innerHTML = EDIT_THEME_TEXT+': '+this.theme_folder;
        }
        var req = new Request({
            url: SHOW_INCLUDES_LIST+'id/'+$('alias_id').value+'/theme/'+RADIncInAlAction.theme_folder+'/',
            method: 'get',
            onSuccess: function(txt)
            {
                $('list_includes_content').set("html",txt);
                if(RADIncInAlAction.isSave) {
                	location = BACK_URL;
                }
            },
            onFailure: function(){
                alert(CULD_NOT_FINISH_REQUEST);
            }
        }).send();
        //success list_includes_content
    },
    configOneClick: function(inc_id)
    {
       var themeUrl = '';
       if(RADIncInAlAction.theme_folder.length > 0) {
           themeUrl = 'themeC/'+RADIncInAlAction.theme_folder+'/'
       }
       var req = new Request({
           url: CONFIG_FORM_URL+'inc_id/'+inc_id+'/'+themeUrl,
           onSuccess: function(txt){
               if($('IncConfigWindow')){
                    $('IncConfigWindow').destroy();
                }
                if(!$('IncConfigWindow')){
                   var wheight = Window.getHeight();
                   if(wheight>550){
                       wheight = 550;
                   }
                   wheight = wheight-50;
                   var wnd = new dWindow({
                       id:'IncConfigWindow',
                       content: txt,
                       width: 650,
                       height: wheight,
                       minWidth: 180,
                       minHeight: 160,
                       left: 350,
                       top: 50,
                       title: IncConfigTitle,
                       dragable: false
                   }).open($(document.body));
               }
           },
           onFailure: function(){
               alert(CULD_NOT_FINISH_REQUEST);
           }
       }).send();
    },
    configCancelClick: function()
    {
        if($('IncConfigWindow')){
            $('IncConfigWindow').destroy();
        }
    },
    configSubmitClick: function()
    {
       $('save_config_button').disabled = true;
       $('cancel_config_button').disabled = true;
       this.configCount = 0;
       var use_personal = 0;
       if($('use_personal_only').checked)
           use_personal = 1;
       var req = new Request({
           url: SAVECONFIG_FORM_URL+'personal/0/',
           data: $('configFormWindow').toQueryString(),
           method: 'post',
           onSuccess: function(txt){
              eval(txt);
           },
           onFailure: function(){
               alert(CULD_NOT_FINISH_REQUEST);
           }
       }).send();
       var req = new Request({
           url: SAVECONFIG_FORM_URL+'personal/1/useit/'+use_personal+'/',
           data: $('configPersonalFormWindow').toQueryString(),
           method: 'post',
           onSuccess: function(txt){
              eval(txt);
           },
           onFailure: function(){
               alert(CULD_NOT_FINISH_REQUEST);
           }
       }).send();
    },
    clearTimeout: function()
    {
        setTimeout("$('IncInAlInfoMessage').set('html','');",5000);
    },
    addClick: function()
    {
        var req = new Request({
            url: ADD_INCLUDE_URL+'alias_id/'+$('alias_id').value+'/theme/'+RADIncInAlAction.theme_folder+'/',
            onSuccess: function(txt){
                if($('IncAddFieldWindow')){
                    $('IncAddFieldWindow').destroy();
                }
                if(!$('IncAddFieldWindow')){
                   var wheight = Window.getHeight();
                   if(wheight>250){
                       wheight = 250;
                   }
                   wheight = wheight-50;
                   var wnd = new dWindow({
                       id:'IncAddFieldWindow',
                       content: txt,
                       width: 550,
                       height: wheight,
                       minWidth: 180,
                       minHeight: 160,
                       left: 400,
                       top: 100,
                       title: IncFieldTitle
                   }).open($(document.body));
               }
            },
            onFailure: function(){
                alert(CULD_NOT_FINISH_REQUEST);
            }
        }).send();
    },
    saveClick: function()
    {
        this.isSave = true;
        this.applyClick();
    },
    applyClick: function()
    {
    	$('IncInAlInfoMessage').set("html",LOADING_MESSAGE);
        var req = new Request({
            url: APPLY_INC_URL,
            data: $('includesinaliases').toQueryString(),
            method: 'post',
            onSuccess: function(txt){
                RADIncInAlAction.refresh();
                return true;
            },
            onFailure: function(){
                $('IncInAlInfoMessage').set("html",CULD_NOT_FINISH_REQUEST);
                return false;
            }
        }).send();
        RADIncInAlAction.clearTimeout();
    },
    deleteClick: function()
    {
        var req = new Request({
            url: APPLY_INC_URL+'withDel/true/',
            data: $('includesinaliases').toQueryString(),
            method: 'post',
            onSuccess: function(txt){
                return true;
            },
            onFailure: function(){
                alert(CULD_NOT_FINISH_REQUEST);
                return false;
            }
        }).send();
    },
    cancelWClick: function()
    {
        if($('IncAddFieldWindow')){
            $('IncAddFieldWindow').destroy();
        }
        showAllSelects();
    },
    submitWClick: function()
    {
        $('submitW').disabled='true';
        var req = new Request({
            url: SUBMIT_WFORM_URL,
            data: $('WForm').toQueryString(),
            method: 'post',
            onSuccess: function(txt){
                eval(txt);
            },
            onFailure: function(){
                alert(CULD_NOT_FINISH_REQUEST);
            }
        }).send();
    },
    deleteOneClick: function(inc_id)
    {
        if(confirm(DELETE_INCLUDE_QUERY)){
            var req = new Request({
                url: APPLY_INC_URL,
                data: $('includesinaliases').toQueryString(),
                method: 'post',
                onSuccess: function(txt){
                    //DELETE_ONE_URL
                    var req = new Request({
                        url: DELETE_ONE_URL+'id/'+inc_id+'/js/true/',
                        method: 'post',
                        data: {hash:HASH},
                        onSuccess: function(txt){
                            return true;
                        },
                        onFailure: function(){
                            return false;
                        }
                    }).send();
                },
                onFailure: function(){
                    alert(CULD_NOT_FINISH_REQUEST);
                    return false;
                }
            }).send();
        }
    },
    loadList: function(alias_id)
    {
    },
    checkAll: function(obj)
    {
        var state = obj.selected;
        var els = $('includesinaliases').getElements('input');
        for(var i=0;i < els.length;i++){
            if(els[i].id!=obj.id)
                if(els[i].type=="checkbox")
                    this.checkRow(els[i].id.replace('ch_del_',''));
        }
    },
    checkRow: function(r_id)
    {

        if($('ch_del_'+r_id).checked){
            $('ch_del_'+r_id).checked = false;
            $('tr_'+r_id).removeClass('select_tr');
            $('tr_'+r_id).className=$('tr_'+r_id).className.replace("select_tr", "");
        }else{
            $('ch_del_'+r_id).checked = true;
            $('tr_'+r_id).addClass('select_tr');
            $('tr_'+r_id).className+=" select_tr";
        }
    },
    checkRow1: function(r_id)
    {
        for(var i=0;i<4;i++)
            this.checkRow(r_id);
    },
    deleteDynamiclyRow: function(r_id)
    {
       this.refresh();
        /*
        if($('tr_'+r_id)){
            $('tr_'+r_id).destroy();
        }
        */
    },
    changed: function()
    {
        $('IncInAlInfoMessage').set('html',CHANGED);
    },
    InAddloadController: function(obj)
    {
       var selInd = obj.options[obj.selectedIndex].value;
       var req = new Request({
           url: GETCONTROLLER_WFORM_URL+'inc_id/'+selInd+'/',
           onSuccess: function(txt){
               eval(txt);
           },
           onFailure: function(){
               return false;
           }
       }).send();
    },
    message: function(message)
    {
        document.getElementById('IncInAlInfoMessage').innerHTML = message;
        setTimeout("document.getElementById('IncInAlInfoMessage').innerHTML = '';",5000);
    }
}
RADConfigInc = {
    colorelements: new Array(),
    checkcolor: function(id,id_inp){
        if(!this.colorelements[id]){
            this.colorelements[id] = true;
            new MooRainbow(id, {
                id: 'cp_'+id,
                wheel: true,
                onChange: function(color) {
                    $(id_inp).value = color.hex;
                },
                onComplete: function(color) {
                    $(id_inp).value = color.hex;
                }
            });
        }
    }
}
RADScriptWindow = {
    el: null,
    aliasScriptShow: function(alias_id)
    {
       var req = new Request({
           url: SHOWEDITSCRIPT_URL+'alias_id/'+alias_id+'/',
           onSuccess: function(txt){
                if($('ScriptWindow')){
                    $('ScriptWindow').destroy();
                }
                if(!$('ScriptWindow')){
                   var wheight = Window.getHeight();
                   if(wheight>550){
                       wheight = 550;
                   }
                   wheight = wheight-50;
                   var wnd = new dWindow({
                       id:'ScriptWindow',
                       content: txt,
                       width: 800,
                       height: wheight,
                       minWidth: 180,
                       minHeight: 160,
                       left: 150,
                       top: 50,
                       title: ScriptWindowTitle
                   }).open($(document.body));

                   editAreaLoader.init({
                        id: "txt_script" // id of the textarea to transform
                        ,start_highlight: true  // if start with highlight
                        ,allow_resize: "both"
                        ,allow_toggle: true
                        ,language: CURR_LANG
                        ,font_size: "9"
                        ,font_family: "verdana, monospace"
                        ,syntax: "php"
                    });
                    dWindow._destroy = function(){
                       this.hideSelects(false);
                        if ($type(this.handle) == 'element'){
                            this.handle.destroy();
                        }
                        RADTabs.initedN = false;
                        RADTabs.initedM = false;
                        RADTabs.initedD = false;
                        this.handle = null;

                    }

               }
               RADScriptWindow.initWindow();

            },
            onFailure: function(){
                alert(CULD_NOT_FINISH_REQUEST);
            }
       }).send();
    },
    cancelClick: function()
    {
       if($('ScriptWindow')){
           RADTabs.initedN = false;
           RADTabs.initedM = false;
           RADTabs.initedD = false;
           $('ScriptWindow').destroy();
       }
    },
    initWindow: function()
    {
       $$('#helpers .each_el_key_h').each(function(el){
           if(el.getProperty('hint')){
               var cv = new Element('div');
               cv.className = 'hint-pointer';
               cv.innerHTML = '<table border="0"><tr><td>'+el.getProperty('hint')+'</td></tr></table>';
               cv.setProperty('id','hint_'+el.id);
               cv.injectInside(el);
           }
       });
       this.moduleChange();
    },
    showHint: function(el,show)
    {
       var elid = el.id;
       if(show!=0){
           $('hint_'+elid).style.display = 'block';
       }else{
           $('hint_'+elid).style.display = 'none';
       }
    },
    ta: function(controller,varname)
    {
       var el = this.el || $('txt_script');
       if(el.style.display!='none'){
           insertAtCursor(el,'{$'+controller+'.'+varname+'}');
       }else{
           editAreaLoader.insertTags(el.id,'{$'+controller+'.'+varname+'}','');
       }
    },
    ta2: function(controller,varname)
    {
       var el = this.el || $('txt_script');
       if(el.style.display!='none'){
           insertAtCursor(el,'<%'+controller+'.'+varname+'%>');
       }else{
           editAreaLoader.insertTags(el.id,'<%'+controller+'.'+varname+'%>','');
       }
    },
    moduleChange: function()//when changes module in the <select>
    {
       if($('bc_modules')){
           var controller = $('bc_modules').options[$('bc_modules').selectedIndex].value;
           $$('#helpers .li_scriptw_p').each(function(el){
               if(el.id!='li_'+controller)
                el.style.display = 'none';
           });
           $('li_'+controller).style.display = '';
       }
    },
    submitClick: function()
    {
       RADTabs.initedN = false;
       RADTabs.initedM = false;
       RADTabs.initedD = false;
       $('txt_script').value=editAreaLoader.getValue('txt_script');
       $('navi_script').value=editAreaLoader.getValue('navi_script');
       $('metatitle_script').value=editAreaLoader.getValue('metatitle_script');
       $('metadescription_script').value=editAreaLoader.getValue('metadescription_script');
       $('submitScriptWindowClick').disabled = true;
       $('cancelScriptWindowClick').disabled = true;
       var req = new Request({
           url: SAVEEDITSCRIPT_URL,
           data: $('scripts2Form').toQueryString(),
           method: 'post',
           onSuccess: function(txt){
              eval(txt);
           },
           onFailure: function(){
               alert(CULD_NOT_FINISH_REQUEST);
           }
       }).send();
    }
}

RADTabs = {
    initedN: false,
    initedM: false,
    initedD: false,
    //dvy 14.09.2009
    initedK: false,
    change: function(id,panel,wrapper)
    {
       panel = panel || 'TabsPanel';
       wrapper = wrapper || 'TabsWrapper';
       if(panel!='TabsPanel'){
           if(id=='TitleTab'){
              RADScriptWindow.el = $('txt_script');
           }else if(id=='NaviTab'){
              RADScriptWindow.el = $('navi_script');
           }else if(id=='metatitleTab'){
              RADScriptWindow.el = $('metatitle_script');
           }else if(id=='metadescriptionTab'){
              RADScriptWindow.el = $('metadescription_script');
           }
       }
       $(panel).getElements('.vkladka').removeClass('activ');
       $(id).className += ' activ';
       $(wrapper).getElements('div[id$=tabcenter]').setStyle('display', 'none');
       if($(id+'_tabcenter')){
           $(id+'_tabcenter').setStyle('display','block');
       }
       if(panel!='TabsPanel'){
           if(id=='NaviTab' && !this.initedN){
              this.initedN = true;
              editAreaLoader.init({
                        id: "navi_script" // id of the textarea to transform
                        ,start_highlight: true  // if start with highlight
                        ,allow_resize: "both"
                        ,allow_toggle: true
                        ,language: CURR_LANG
                        ,font_size: "9"
                        ,font_family: "verdana, monospace"
                        ,syntax: "php"
                    });

           }else if(id=='metatitleTab' && !this.initedM){
              this.initedM = true;
              editAreaLoader.init({
                        id: "metatitle_script" // id of the textarea to transform
                        ,start_highlight: true  // if start with highlight
                        ,allow_resize: "both"
                        ,allow_toggle: true
                        ,language: CURR_LANG
                        ,font_size: "9"
                        ,font_family: "verdana, monospace"
                        ,syntax: "php"
                    });
           }else if(id=='metadescriptionTab' && !this.initedD){
              this.initedD = true;
              editAreaLoader.init({
                        id: "metadescription_script" // id of the textarea to transform
                        ,start_highlight: true  // if start with highlight
                        ,allow_resize: "both"
                        ,allow_toggle: true
                        ,language: CURR_LANG
                        ,font_size: "9"
                        ,font_family: "verdana, monospace"
                        ,syntax: "php"
                    });
           }else if(id=='TitleTab' && !this.initedK){
               this.initedK = true;
               editAreaLoader.init({
                        id: "txt_script" // id of the textarea to transform
                        ,start_highlight: true  // if start with highlight
                        ,allow_resize: "both"
                        ,allow_toggle: true
                        ,language: CURR_LANG
                        ,font_size: "9"
                        ,font_family: "verdana, monospace"
                        ,syntax: "php"
                    });
           }
       }
    }
}

RADAliDescr = {
    returntomain: false,
    applyClick: function(alias_id)
    {
       var req = new Request({
           url: SAVE_DESCRIPTION_URL,
           data: $('description_form').toQueryString(),
           onSuccess: function(txt){
              RADAliDescr.close();
              eval(txt);
              if(RADAliDescr.returntomain)
                 location = BACK_URL;
           },
           onFailure: function(){
               alert(CULD_NOT_FINISH_REQUEST);
           }
       }).send();

    },
    saveClick: function(alias_id)
    {
       this.returntomain = true;
       this.applyClick(alias_id);
    },
    close: function()
    {
       if($('DescriptionWindow')){
           $('DescriptionWindow').destroy();
       }
    },
    show: function(alias_id)
    {
       var req = new Request({
           url: DESCRIPTION_WINDOW_URL+'a/'+alias_id+'/',
           onSuccess: function(txt){
                if($('DescriptionWindow')){
                    $('DescriptionWindow').destroy();
                }
                if(!$('DescriptionWindow')){
                   var wheight = Window.getHeight();
                   if(wheight>330){
                       wheight = 330;
                   }
                   wheight = wheight-50;
                   var wnd = new dWindow({
                       id:'DescriptionWindow',
                       content: txt,
                       width: 650,
                       height: wheight,
                       minWidth: 180,
                       minHeight: 160,
                       left: 350,
                       top: 100,
                       title: DESCRIPTION_TITLE
                   }).open($(document.body));
                }
           },
           onFailure: function(){
               alert(CULD_NOT_FINISH_REQUEST);
           }
       }).send();
    },
    message: function(mes)
    {
        document.getElementById('aliasInfoMessage').innerHTML = mes;
        setTimeout("document.getElementById('aliasInfoMessage').innerHTML = '';",5000);
    }
}


function insertAtCursor(myField, myValue) {
  //  if MSIE
  if (document.selection) {
    myField.focus();
    sel = document.selection.createRange();
    sel.text = myValue;
  }
  else if (myField.selectionStart || myField.selectionStart == '0') {
    var startPos = myField.selectionStart;
    var endPos = myField.selectionEnd;
    myField.value = myField.value.substring(0, startPos) + myValue + myField.value.substring(endPos, myField.value.length);
  }
  else {
    myField.value += myValue;
  }
} // insertAtCursor

ThemeRules = {
    create: function(alias_id,theme_folder)
    {
       if(confirm(CREATE_RULES_THEME_MESSAGE+String.fromCharCode(10)+String.fromCharCode(13)+theme_folder)){
           document.getElementById('themesMessage').innerHTML = LOADING_MESSAGE;
           var req = new Request({
              url: CREATE_RULES_THEME_URL+'alias_id/'+alias_id+'/theme/'+theme_folder+'/',
              onSuccess: function(txt){
                 eval(txt);
                 document.getElementById('themesMessage').innerHTML = '';
                 $("theme_ex_t_"+theme_folder).style.display="";
                 $("theme_hrf_del_"+theme_folder).style.display="";
                 $("theme_hrf_add_"+theme_folder).style.display="none";
                 $("theme_hrf_edit_"+theme_folder).style.display="";
                 RADIncInAlAction.theme_folder = theme_folder;
                 RADIncInAlAction.refresh();
              },
              onFailure: function(){
                 alert(CULD_NOT_FINISH_REQUEST);
              }
           }).send();
       }
    },

    'delete': function(alias_id,theme_folder)

    {
       if(confirm(DELETE_RULES_THEME_MESSAGE+String.fromCharCode(10)+String.fromCharCode(13)+theme_folder)){
           var req = new Request({
              url: DELETE_RULES_THEME_URL+'alias_id/'+alias_id+'/theme/'+theme_folder+'/',
              onSuccess: function(txt){
                 eval(txt);
                 document.getElementById('themesMessage').innerHTML = '';
                 $("theme_ex_t_"+theme_folder).style.display="none";
                 $("theme_hrf_del_"+theme_folder).style.display="none";
                 $("theme_hrf_add_"+theme_folder).style.display="";
                 $("theme_hrf_edit_"+theme_folder).style.display="none";
                 document.getElementById("inc_h_mes").innerHTML = "";
                 RADIncInAlAction.theme_folder = '';
                 RADIncInAlAction.refresh();
              },
              onFailure: function(){
                 alert(CULD_NOT_FINISH_REQUEST);
              }
           }).send();
       }
    },
    edit: function(alias_id,theme_folder)
    {
       RADIncInAlAction.theme_folder = theme_folder;
       RADIncInAlAction.refresh();
    }
}

{/literal}