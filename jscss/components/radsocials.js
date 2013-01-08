RADSocials = {
		'socLogin': function(provider) {
			if(provider !== undefined) {
				var win = window.open(URL_SOC_LOGIN+'provider/'+provider, SOC_LOGIN_TITLE, 'width=800,height=600,status=0,toolbar=0,resizable=yes');
				var timer = setInterval(function() {
					if(win.closed) {  
						clearInterval(timer);  
						location = SITE_URL;
					}
				}, 1000);
			}
    }
}
