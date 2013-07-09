var SITE_URL = '{const SITE_URL}';
var SITE_ALIAS = '{const SITE_ALIAS}';
{capture assign="SA_PARENT"}{const SITE_ALIAS}{/capture}
{capture assign="SA_PARENT"}{$SA_PARENT|replace:'XML':''}{/capture}
var SITE_ALIAS_PARENT = '{$SA_PARENT}';
var BACK_URL = '{url href="alias=`$SA_PARENT`"}';

//URL's
var DELETE_ITEM_URL = '{url href="action=deleterow"}';
var REFRESH_QUESTIONS_URL = '{url href="action=listquestions"}';
var DELETE_ANSWER_URL = '{url href="action=deleteanswer"}';
var CHPOS_ANSWER_URL = '{url href="action=moveanswer"}';
var EDIT_ANSWER_URL  = '{url href="action=editanswer"}';
var EDIT_ANSWERFORM_URL  = '{url href="action=editanswerform"}';
var ADD_ANSWERFORM_URL = '{url href="action=editanswerform"}';

//MESSAGES
var FAILED_REQUEST = '{lang code="requestisfiled.system.text"}';
var DELETE_QUERY = '{lang code="deletequery.votes.query"}';
var ENTER_NAME = '{lang code="entername.votes.error"}';
var CHOOSE_CATEGORY = '{lang code="choosecategory.votes.error"}';
var ENTER_ANSWER_QUERY = '{lang code="enteranswer.votes.query"}';
var ANSWER_EMPTY_ERR = '{lang code="answerempty.votes.error"}';
var DELETE_ANSWER_CONFIRM = '{lang code="duyoureallydeleteanswer.votes.query"}';
var ADDEDIT_FORM_TITLE = '{lang code="addeditanswer.votes.title" ucf=true}';
var LOADING = '{lang code="-loading" ucf=true}';
var SAVING = '{lang code="-saving" ucf=true}';

var HASH = '{$hash}';

{literal}
RADAddEditVotes = {
    validateForm: function()
    {
        var messages = new Array();
        if(!$('vt_question').value.length){
            messages.push(ENTER_NAME);
            $('vt_question').focus();
        }
        if(!$('vt_treid').selectedIndex<0){
            messages.push(CHOOSE_CATEGORY);
        }
        if(messages.length>0){
            var s = '';
            for(var i=0;i < messages.length;i++){
                s += messages[i]+String.fromCharCode(10)+String.fromCharCode(13);
            }//for
            alert(s);
            return false;
        }
        return true;
    },
    cancelClick: function()
    {
        location = BACK_URL;
    },
    deleteClick: function()
    {
        if(confirm(DELETE_QUERY) && $('vt_id').value){
            location = DELETE_ITEM_URL+'vt_id/'+$('vt_id').value+'/returnmain/1/hash/'+HASH;
        }
    },
    applyClick: function()
    {
        if(this.validateForm()){
          $('returntorefferer').value='1';
          $('addedit_form').submit();
      }
    },
    saveClick: function()
    {
        if(this.validateForm()){
          $('returntorefferer').value='0';
          $('addedit_form').submit();
      }
    },
    getNewRubrics: function(lngid)
    {
    },
    changeContntLang: function(lngid,lngcode)
    {
       this.getNewRubrics(lngid);
    },
    message: function(mes){
       document.getElementById('addeditItemMessage').innerHTML=message;
       setTimeout("document.getElementById('addeditItemMessage').innerHTML='';",5000);
    }
}

RADCHLangs.addContainer('RADAddEditVotes.changeContntLang');

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

RADVotesQuestions = {
  entered:false,
  deleteRow: function(item_id){
    if(confirm(DELETE_ANSWER_CONFIRM)){
      var req = new Request({
        url: DELETE_ANSWER_URL+'id/'+item_id+'/',
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
  editRow: function(item_id){
  },
  chPosRow: function(item_id){
    var val = $('vtq_position_'+item_id).value;
    if(item_id>0 && val){
    $('addeditItemMessage').set('html',SAVING);
    var req = new Request({
      url:CHPOS_ANSWER_URL+'id/'+item_id+'/v/'+val+'/',
      data:{hash:HASH},
      onSuccess: function(txt){
        $('addeditItemMessage').set('html','');
        eval(txt);
      },
      onFailure: function(){
        alert(FAILED_REQUEST);
      }
    }).send();
    }
  },
  saveAnswerDialog: function(item_id){
    $('addeditItemMessage').set('html',LOADING);
    var url_f = EDIT_ANSWERFORM_URL+'vt_id/'+$('vt_id').value+'/';
    if(item_id)
        url_f+='id/'+item_id+'/';
    var req = new Request({
        url:url_f,
        onSuccess: function(txt){
            $('addeditItemMessage').set('html','');
            if($('AnswerAddFieldWindow')){
                $('AnswerAddFieldWindow').destroy();
            }
            if(!$('AnswerAddFieldWindow')){
               var wheight = Window.getHeight();
               if(wheight>250){
                   wheight = 250;
               }
               wheight = wheight-50;
               var wnd = new dWindow({
                   id:'AnswerAddFieldWindow',
                   content: txt,
                   width: 450,
                   height: wheight,
                   minWidth: 180,
                   minHeight: 160,
                   left: 450,
                   top: 150,
                   title: ADDEDIT_FORM_TITLE
               }).open($(document.body));
           }
        },
        onFailure: function(){
            alert(FAILED_REQUEST);
        }
    }).send();
  },
  saveAnswerName: function(item_id){
    $('addeditItemMessage').set('html',SAVING);
    var req = new Request({
      url: EDIT_ANSWER_URL,
      method: 'post',
      data: $('addeditanswer_form').toQueryString(),
      onSuccess: function(txt){
        $('addeditItemMessage').set('html','');
        eval(txt);
      },
      onFailure: function(){
        alert(FAILED_REQUEST);
      }
    }).send();
    //$('td_ans_name_'+item_id).set('html',$('ans_name_txt_'+item_id).value);
  },
  cancelWindowClick: function(){
      if($('AnswerAddFieldWindow'))
        $('AnswerAddFieldWindow').destroy();
  },
  refresh: function(){
    $('addeditItemMessage').set('html',LOADING);
    var req = new Request({
      url: REFRESH_QUESTIONS_URL+'id/'+$('vt_id').value+'/',
      onSuccess: function(txt){
        $('addeditItemMessage').set('html','');
        $('questions_list').set('html',txt);
      },
      onFailure: function(){
        alert(FAILED_REQUEST);
      }
    }).send();
  },
  message: function(mes){
    document.getElementById('addeditItemMessage').innerHTML=mes;
    setTimeout("document.getElementById('addeditItemMessage').innerHTML='';",5000);
  }
}

{/literal}