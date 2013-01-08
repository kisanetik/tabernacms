tabernalogin = {
	'i18':'',
	'user':null,
	'menu':null,
	'handlers':new Array(),
	'lHandlers':new Array(),
	'init': function()
	{
		var req = new Request.JSON({
			url: URL_SYSXML,
			method: 'post',
            data: {
                'a': 'logintaberna'
            },
            onSuccess: function(JSON, Text) {
            	tabernalogin.i18 = JSON.i18;
            	if(JSON.code==8) {
            		tabernalogin.user = JSON.user;
            		if(JSON.menu.length) {
            			tabernalogin.menu = JSON.menu;
            		}
            		tabernalogin.jsInit();
            	}
            }
		}).send();
	},
	'addContainer':function(handler) 
	{
		return this.handlers.push(handler);
	},
	'addLicenseContainer':function(handler) 
	{
		return this.lHandlers.push(handler);
	},
	'loginWindow':function()
	{
		if($('tabernaLoginWindow')) {
			$('tabernaLoginWindow').destroy();
		}
		var loginform = '<center><h2>'+tabernalogin.i18.TXT_LOGIN+'</h2>';
		loginform += '<h3>'+tabernalogin.i18.TXT_AUTHORIZATION+' <a href="http://tabernacms.com" target="_blank">Taberna CMS</a></h3>';
		loginform += '<div id="tabernalogin_message" style="color:red;width:100%;"></div><br />';
		loginform += '<strong>e-mail:</strong>&nbsp;<input type="text" id="tabernalogin_email" value="" />';
		loginform += '<br /><strong>'+tabernalogin.i18.TXT_PASS+'</strong>&nbsp;<input id="tabernalogin_pass" type="password" value="" />';
		loginform += '<br /><input id="tabernalogin_submit" type="button" value="'+tabernalogin.i18.TXT_SUBMIT+'" onclick="tabernalogin.loginWindowSubmit();" />&nbsp;<input id="tabernalogin_cancel" type="button" value="'+tabernalogin.i18.TXT_CANCEL+'" onclick="$(\'tabernaLoginWindow\').destroy();" />';
		loginform += '</center>';
		var wnd = new dWindow({
            id:'tabernaLoginWindow',
            content: loginform,
            width: 350,
            height: 220,
            minWidth: 180,
            minHeight: 160,
            left: 450,
            top: 150,
            title: tabernalogin.i18.TXT_W_LOGO
        }).open($(document.body));
		$('tabernalogin_email').addEvent('keydown', function(event) {
			if(event.key=='enter') {
				tabernalogin.loginWindowSubmit();
			}
		}).focus();
		$('tabernalogin_pass').addEvent('keydown', function(event) {
			if(event.key=='enter') {
				tabernalogin.loginWindowSubmit();
			}
		});
		return false;
	},
	'loginWindowSubmit': function() 
	{
		if(!$('tabernalogin_email').value.length || !$('tabernalogin_pass').value.length) {
			$('tabernalogin_message').set('html', tabernalogin.i18.TXT_LP_EMPTY);
			return ;
		}
		$('tabernalogin_submit').disabled = true;
		$('tabernalogin_cancel').disabled = true;
		var req = new Request.JSON({
			url: URL_SYSXML,
			method: 'post',
            data: {
                'a': 'logintaberna_lpsave',
                'l':$('tabernalogin_email').value,
                'p':$('tabernalogin_pass').value
            },
            onSuccess: function(JSON, Text) {
            	if(JSON.code==8) {
            		$('tabernaLoginWindow').destroy();
            		tabernalogin.user = JSON.user;
            		tabernalogin.menu = JSON.menu;
            		tabernalogin.jsInit();
            		return ;
            	} else if(JSON.code==1000) {
            		$('tabernalogin_message').set('html', tabernalogin.i18.TXT_UNKNOWN_ERROR);
            	} else if(JSON.code==9) {
            		$('tabernalogin_message').set('html', tabernalogin.i18.TXT_USER_BLOCKED);
            	} else if(JSON.code==1) {
            		$('tabernalogin_message').set('html', tabernalogin.i18.TXT_USER_NOT_FOUND);
            	}
            	$('tabernalogin_submit').disabled = false;
        		$('tabernalogin_cancel').disabled = false;
            }
		}).send();
	},
	'jsInit':function()
	{
		//init JS for showing personal cabinet
		if(this.user.u_email.length) {
			var el = new Element('li', {'id':'TAB_user_menu_ul'});
			el.set('html', '<div id="TAB_user_menu_div"><a href="#"><img src="'+this.user.menu_logo+'" alt="'+this.user.u_login+'" /></a></div>');
			if(this.menu) {
				var elm = new Element('div', {'class':'cont', 'id':'logintaberna_menu_div'});
				var str = '<ul id="TAB_user_submenu_ul" class="TAB_user_submenu"><li><table border="0" cellpadding="0" cellspacing="0">';
				for(var i=0;i<this.menu.length;i++) {
					str += '<tr>';
					var target='';
					if(this.menu[i].target) {
						target = ' target="'+this.menu[i].target+'"';
					}
					var a_tag = '<a href="'+this.menu[i].href+'"'+target+'>'+this.menu[i].title;
					if(this.menu[i].img) {
						str += '<td class="td_icon">'+a_tag+'<img src="'+this.menu[i].img+'" border="0" /></a></td><td nowrap="nowrap" id="TAB_user_submenu_td_'+this.menu[i].id+'" align="left">';
					} else {
						str += '<td nowrap="nowrap" colspan="2" id="TAB_user_submenu_td_'+this.menu[i].id+'" align="left">';
					}
					str += a_tag+'</a>';
					str += '</td></tr>';
				}
				str += '</table></li></ul>';
				elm.set('html', str);
				el.adopt(elm);
			}
			$('taberna_user_menu_td').set('html','').adopt(el);
			if(this.handlers.length) {
                for(var i=0; i < this.handlers.length; i++) {
                    eval(tabernalogin.handlers[i]+'(tabernalogin.user);');
                }
            }
		}
	},
	'readLicense': function(partner) 
	{
		var req = new Request({
			url:URL_SYSXML,
			method:'post',
			data: {
                'a': 'getPartnerLicense',
                'name':partner
            },
            onSuccess: function(txt) {
            	var wnd = new dWindow({
                    id:'tabernaLicenseWindow',
                    content: '<form id="tabernaLicenseForm" onsubmit="return false">'+txt+'</form>',
                    width: 700,
                    height: 500,
                    minWidth: 180,
                    minHeight: 160,
                    left: 100,
                    top: 50,
                    title: tabernalogin.i18.TXT_W_LICENSE
                }).open($(document.body));
            	$('submit_pt').addEvent('click', function() {
            		var acceptedLicense = false;
            		if($('partner_accept_license').get('checked')) {
            			acceptedLicense = true;
            		}
            		$('submit_pt').set('disabled', true);
            		var reqAccept = new Request({
            			url:URL_SYSXML,
            			method:'post',
            			data: {
            				'a':'acceptLicense',
            				'accepted': acceptedLicense,
            				'partner_id': $('partner_id').value
            			},
            			onSuccess: function(txt) {
            				tabernalogin.acceptLicense(txt);
            			}
            		}).send();
            		
            	});
            	$('cancel_pt').addEvent('click', function() {
            		$('tabernaLicenseWindow').destroy();
            	});
            }
		}).send();
		return false;
	},
	'acceptLicense': function(txt) 
	{
		if(txt=='1') {
			if(tabernalogin.lHandlers.length) {
                for(var i=0; i < this.lHandlers.length; i++) {
                    eval(tabernalogin.lHandlers[i]+'();');
                }
            }
			if($('tabernaLicenseWindow')) {
				$('tabernaLicenseWindow').destroy();
			}
		} else {
			alert('some error!');
		}
	}
}
window.addEvent('load', function() {
	tabernalogin.init();
});