rad_loginpanel = {
    'logout': function() {
        
    },
    'init': function() {
        $('#login_btn').click(function() {
            if($('#loginpanel').length) {
                if($('#loginpanel').css('top') <= '-122px') {
                    $('#loginpanel').animate({'top':'-=218px'},'normal');
                    $('#login_btn').css('background-position', '');
                } else {
                    $('#login_btn').css('background-position', '0 -61px');
                    $('#loginpanel').animate({'top':'+=218px'},'normal');
                    $('#lp_login').focus();
                }
            } else if($('#loginpanel_socials').length) {
                if($('#loginpanel_socials').css('top')=='-120px') {
                    $('#loginpanel_socials').animate({'top':'-=303px'},'normal');
                    $('#login_btn').css('background-position', '');
                } else {
                    $('#login_btn').css('background-position', '0 -61px');
                    $('#loginpanel_socials').animate({'top':'+=303px'},'normal');
                    $('#lp_login').focus();
                }
            }
        });
        $('#logout_btn').click(function() {
            location = URL_LOGOUT;
        });
        $('#cancelLogin').click(function() {
            $('#loginpanel').animate({'top':'-=180px'},'normal');
        });
    }
}
$(function() {
   rad_loginpanel.init(); 
});