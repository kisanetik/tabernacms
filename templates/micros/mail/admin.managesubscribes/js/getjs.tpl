var SITE_URL = '{const SITE_URL}';
var SITE_ALIAS = '{const SITE_ALIAS}';
var GROUPS_ID = '{$ROOT_PID}';
var GET_GROUPS_URL =  '{url href="action=getgroups"}';

NAME_EMPTY = "{lang code="emptyname.mail.error"|replace:'"':'&quot;'}";
EMAIL_INCORRECT = "{lang code="emailincorrect.mail.error"|replace:'"':'&quot;'}";
EMAIL_EMPTY = "{lang code="emptyemail.mail.error"|replace:'"':'&quot;'}";
SUBJECT_EMPTY = "{lang code="emptysubject.mail.error"|replace:'"':'&quot;'}";
BODY_EMPTY = "{lang code="emptybody.mail.error"|replace:'"':'&quot;'}";
GROUPS_NOT_SELECTED = "{lang code="groupsnotselected.mail.error"|replace:'"':'&quot;'}";
SMTP_NOT_FULL = "{lang code="wrongsmtp.mail.error"|replace:'"':'&quot;'}";

{literal}
RADMailSubscribes = {
	isHaveError : false,
	
	recAddSelItems: function(sn,items,nbsp)
	{
	    for(var i=0;i < items.length;i++) {
		   if(items[i].child.length)
		      this.recAddSelItems(sn,items[i].child,nbsp+6);
		   var s = '';
		   if(nbsp) {
		       for(var k=0;k < (nbsp/2);k++) {
			       s += ' ';
			   }
		   }
           addSel(sn, s+items[i].tre_name, items[i].tre_id);
		   sn.options[sn.options.length-1].style.marginLeft = nbsp+'px';
        }
	},
	
	getNewGroups: function(lang_id)
	{
	   $('groups_tree').selectedIndex = -1;
	   clearSel($('groups_tree'));
	   var req = new Request({
	       url: GET_GROUPS_URL+'i/'+lang_id+'/',
		   onSuccess: function(txt) {
		      var items = eval(txt);
			  RADMailSubscribes.recAddSelItems($('groups_tree'),items,0);
		   },
		   onFailure: function() {
               alert(FAILED_REQUEST);
           }
	   }).send();
	},
	
	changeContntLang: function(lngid,lngcode)
    {
    	this.isHaveError = false;
		this.getNewGroups(lngid);
    },
    
    setMessage: function(msg)
    {
    	this.isHaveError = true;
    	$('infoMessage').set('html', $('infoMessage').get('html')+msg+'<br>');
    },
    
    clearMessage: function()
    {
    	this.isHaveError = false;
    	$('infoMessage').set('text','');
    },
    
    validateForm: function()
    {
    	this.clearMessage();
    	var name =  $('mailfromname').get('value');
    	if(name.length < 1) {
    		this.setMessage(NAME_EMPTY);
    	}
    	var email =  $('mailfromemail').get('value');
    	if(email.length > 0) {
    		if(/^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/.test(email) == false) {
    			this.setMessage(EMAIL_INCORRECT);
    		}
    	} else {
    		this.setMessage(EMAIL_EMPTY);
    	}
    	var subj =  $('mailsubject').get('value');
    	if(subj.length < 1) {
    		this.setMessage(SUBJECT_EMPTY);
    	}
		var body = WYSIWYG.getContents('FCKeditorMailBody');
    	if(body.length < 1) {
    		this.setMessage(BODY_EMPTY);
    	}
    	var groups = $('groups_tree').getSelected();
    	if(groups.length < 1) {
    		this.setMessage(GROUPS_NOT_SELECTED);
    	}
    	if($('mailsmtp').checked) {
    		var smtphost =  $('smtphost').get('value').length;
    		var smtpport = $('smtpport').get('value').length;
    		var smtpuser = $('smtpuser').get('value').length;
    		var smtppass = $('smtppass').get('value').length;
    		if(smtphost < 1 || smtpport < 1 || smtpuser < 1 || smtppass < 1){
    			this.setMessage(SMTP_NOT_FULL);
    		}
    	}
    	if(this.isHaveError) {
    		return false;
    	} else {
    		return true;
    	}
    },
    
    applyClick: function()
    {
    	if(WYSIWYG.isWYSIWYGMode('FCKeditorMailBody')) {
    		$('mailformat').setProperty('value',0);
    	} else {
    		$('mailformat').setProperty('value',1);
    	}
    	if(this.validateForm()) {
    		$('subscribe_form').submit();
    	}
    },
    
    smtpCheck: function()
    {
    	if($('smtpconfig').style.display=='none') {
    		$('smtpconfig').style.display='block';
		} else {
    		$('smtpconfig').style.display='none';
		}
    }
    
}

RADCHLangs.addContainer('RADMailSubscribes.changeContntLang');

RADTabs = {
    change: function(id)
    {
       $('TabsPanel').getElements('.vkladka').removeClass('activ');
       $(id).className += ' activ';
       $('TabsWrapper').getElements('div[id$=tabcenter]').setStyle('display', 'none');
       if($(id+'_tabcenter')) {
           $(id+'_tabcenter').setStyle('display','block');
       }
    }
}

{/literal}