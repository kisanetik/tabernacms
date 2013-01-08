var SITE_ALIAS = '{const SITE_ALIAS}';
var SITE_URL = '{const SITE_URL}';
var HASH_STR = '{$hash}';

/*URL'S*/
var LOAD_URL = '{url href="action=getavaliableupdates"}';
var INSTALL_FILE_URL = '{url href="action=installfile"}';
var INSTALL_SQL_URL = '{url href="action=installSQL"}';
var INSTALL_EVAL_URL = '{url href="action=installEVAL"}';

/*TEXTS & MESSAGES*/
var LOADING = "{lang code="-loading" ucf=true|replace:'"':'&quot;'}";
var LOADED = "{lang code="-loaded" ucf=true|replace:'"':'&quot;'}";
var SAVED = "{lang code='-saved' ucf=true|replace:'"':'&quot;'}";
var SAVING = "{lang code="-saving" ucf=true|replace:'"':'&quot;'}";
var FAILED_REQUEST = "{lang code="requestisfiled.system.message" ucf=true|replace:'"':'&quot;'}";
var TOUPDATE_VERSION_ERROR = "{lang code="errorversiontoupdate.system.error" ucf=true|replace:'"':'&quot;'}";
var REALLY_UPDATE_CURRENT_SYS = "{lang code="updatecurrentsysver.system.query" ucf=true|replace:'"':'&quot;'}";
var TO_NEXT_TXT = "{lang code="tonext.system.text" ucf=true|replace:'"':'&quot;'}";
var INSTALL_UPDATES_TEXT = "{lang code="installtext.system.text" ucf=true|replace:'"':'&quot;'}";
var DONE_TEXT = "{lang code='-done' ucf=true|replace:'"':'&quot;'}";

{literal}
RADUpdate = {
    updateList:null,
    filesCount:0,
    'init': function()
    {
        var req = new Request({
            url: LOAD_URL,
            evalScripts: true,
            onSuccess: function(txt){
                $('panel_itemslist').set('html', txt);
                if($('a_detail_update')) {
                    var toggle_detail_href = new Fx.Slide('detail_updates');
                    toggle_detail_href.hide();
                    $('a_detail_update').addEvent('click', function(event){
                        event.stop();
                        toggle_detail_href.toggle();
                        return false;
                    });
                }
            },
            onFailure: function()
            {
                alert(FAILED_REQUEST);
                $('panel_itemslist').set('html', FAILED_REQUEST);
            }
        }).send();
    },
    'installVersion': function()
    {
        if(!this.updateList.version) {
            alert(TOUPDATE_VERSION_ERROR);
        }
        if(confirm(REALLY_UPDATE_CURRENT_SYS+this.updateList.version+TO_NEXT_TXT+'?')){
            $('panel_itemslist').set('html','<center>'+INSTALL_UPDATES_TEXT+'<img border="0" src="'+SITE_URL+'jscss/components/mootree/mootree_loader.gif"></center>');
            this.startListUpdate();
        }
        return false;
    },
    'startListUpdate': function()
    {
        var el = new Element('div', {'id':'pb','style':'margin-left:5%;width:90%;height:90px;'});
        var el2 = new Element('div', {'id':'pb_step', 'style':'height:40px;width:0%;background: blue;color:#FFFFFF;text-align:center;font-weight:bold;font-size:12px;font-family: Verdana;padding-top:30px;'});
        var el_title = new Element('h4', {'id':'update_title', 'style':'margin-top:10px;text-align:center;'});
        var br = new Element('br');
        el2.inject(el);
        $('panel_itemslist').adopt(el_title);
        $('update_title').set('html', 'Обновляем файлы...');
        $('panel_itemslist').adopt(br);
        $('panel_itemslist').adopt(el);
        this.updateFiles(0);
    },
    'updateFiles': function(i)
    {
        i = i || 0;
        $('pb_step').style.width = Math.ceil(i/RADUpdate.updateList.files.length*100)+'%';
        $('pb_step').set('html', $('pb_step').style.width );
        if(i < this.updateList.files.length){
            var data = {'version':this.updateList.version, 'gf':RADUpdate.updateList.files[i], 'hash':HASH_STR};
            var req = new Request({
                url:INSTALL_FILE_URL,
                data:data,
                onSuccess: function(txt){
                    RADUpdate.updateFiles(++i);
                },
                onFailure: function()
                {
                    RADUpdate.message(FAILED_REQUEST);
                    $('panel_itemslist').set('html', FAILED_REQUEST);
                }
            }).send();
        }else{
            $('update_title').set('html', 'SQL...');
            this.updateSQL(0);
        }
    },
    'updateSQL': function(i)
    {
        i = i || 0;
        $('pb_step').style.display='none';
        if(this.updateList.sql.length) {
            var req = new Request({
                url:INSTALL_SQL_URL,
                data:{'version':RADUpdate.updateList.version, 'hash':HASH_STR},
                onSuccess: function(txt){
                    RADUpdate.updateEval(0);
                },
                onFailure: function() {
                    RADUpdate.message(FAILED_REQUEST);
                    $('panel_itemslist').set('html', FAILED_REQUEST);
                }
            }).send();
        } else {
            this.updateEval(0);
        }
    },
    'updateEval': function(i)
    {
        /*
        var req = new Request({
            onSuccess: function(txt){
                $('pb_step').style.width = '100%';
                $('pb_step').set('html', $('pb_step').style.width );
                $('update_title').set('html', 'Все готово! Обновление завершенно!');
            },
            onFailure: function() {
                RADUpdate.message(FAILED_REQUEST);
                $('panel_itemslist').set('html', FAILED_REQUEST);
            }
        }).send();
        */
        $('panel_itemslist').set('html', DONE_TEXT);
    },
    'message': function(message)
    {
        $('ItemsListMessage').set('html',message);
        setTimeout("document.getElementById('ItemsListMessage').innerHTML = '';",5000);
    }
}
window.onload = function() {
    RADUpdate.init();
}
{/literal}