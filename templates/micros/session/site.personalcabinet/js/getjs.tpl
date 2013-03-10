/*** TEXTS ***/
var PASSWORDS_NOT_MATCH = '{lang code="passwordsnotmatch.session.message" ucf=true}';
var PASSWORDS_IS_SHORT = '{lang code="passwordishort.session.message" ucf=true}';
var EMPTY_LOGIN_FIELD = '{lang code="emptyloginfield.session.message" ucf=true}';
var TOOMUCHLETTERS_IN_FIELD = '{lang code="toomuchlettersinfield.session.message" ucf=true}';
var EMPTY_EMAIL_FIELD = '{lang code="emptyemailfield.session.message" ucf=true}';
var EMAIL_INCORRECT = '{lang code="emailincorrect.session.message" ucf=true}';
var LOADING_TEXT = '{lang code="-loading" ucf=true}';

/*** URLS ***/
var URL_REF_REFRESH = '{url href="action=refref&typ=AJAX"}';

var REGION = '{$current_lang}';

/*** MONTH ***/
var JANUARY = "{lang code="-january" ucf=true|replace:'"':'&quot;'}";
var FEBRUARY = "{lang code="-february" ucf=true|replace:'"':'&quot;'}";
var MARCH = "{lang code="-march" ucf=true|replace:'"':'&quot;'}";
var APRIL = "{lang code="-april" ucf=true|replace:'"':'&quot;'}";
var MAY = "{lang code="-may" ucf=true|replace:'"':'&quot;'}";
var JUNE = "{lang code="-june" ucf=true|replace:'"':'&quot;'}";
var JULY = "{lang code="-july" ucf=true|replace:'"':'&quot;'}";
var AGUST = "{lang code="-august" ucf=true|replace:'"':'&quot;'}";
var SEPTEMBER = "{lang code="-september" ucf=true|replace:'"':'&quot;'}";
var OCTOBER = "{lang code="-october" ucf=true|replace:'"':'&quot;'}";
var NOVEMBER = "{lang code="-november" ucf=true|replace:'"':'&quot;'}";
var DECEMBER = "{lang code="-december" ucf=true|replace:'"':'&quot;'}";

/*** DAYS ***/
var SUNDAY = "{lang code="-sunday" ucf=true|replace:'"':'&quot;'}";
var MONDAY = "{lang code="-monday" ucf=true|replace:'"':'&quot;'}";
var TUESDAY = "{lang code="-tuesday" ucf=true|replace:'"':'&quot;'}";
var WEDNESDAY = "{lang code="-wednesday" ucf=true|replace:'"':'&quot;'}";
var THURSDAY = "{lang code="-thursday" ucf=true|replace:'"':'&quot;'}";
var FRIDAY = "{lang code="-friday" ucf=true|replace:'"':'&quot;'}";
var SATURDAY = "{lang code="-saturday" ucf=true|replace:'"':'&quot;'}";

/*** DAYS SHORT ***/
var SUNDAY_SHORT = "{lang code="-sunday.short" ucf=true|replace:'"':'&quot;'}";
var MONDAY_SHORT = "{lang code="-monday.short" ucf=true|replace:'"':'&quot;'}";
var TUESDAY_SHORT = "{lang code="-tuesday.short" ucf=true|replace:'"':'&quot;'}";
var WEDNESDAY_SHORT = "{lang code="-wednesday.short" ucf=true|replace:'"':'&quot;'}";
var THURSDAY_SHORT = "{lang code="-thursday.short" ucf=true|replace:'"':'&quot;'}";
var FRIDAY_SHORT = "{lang code="-friday.short" ucf=true|replace:'"':'&quot;'}";
var SATURDAY_SHORT = "{lang code="-saturday.short" ucf=true|replace:'"':'&quot;'}";

{literal}
rad_personalcabinet = 
{
    'reflink':'',
    'init': function()
    {
        $('#tab_pass').toggle(false);
        if($('#changepass').length) {
            $('#changepass').click(function(){
                $('#tab_pass').toggle('fast');
            });
        }
        if($('#reflink').length) {
            rad_personalcabinet.reflink = $('#reflink').val();
            $('#reflink').focus(function(){
                this.select();
            });
            $('#reflink').blur(function(){
                $('#reflink').val(rad_personalcabinet.reflink);
            });
            var monthNames = [JANUARY,FEBRUARY,MARCH,APRIL,MAY,JUNE,JULY,AGUST,SEPTEMBER,OCTOBER,NOVEMBER,DECEMBER];
            var dayNames = [SUNDAY, MONDAY, TUESDAY, WEDNESDAY, THURSDAY, FRIDAY, SATURDAY];
            var dayNamesShort = [SUNDAY_SHORT, MONDAY_SHORT, TUESDAY_SHORT, WEDNESDAY_SHORT, THURSDAY_SHORT, FRIDAY_SHORT, SATURDAY_SHORT];
            $( "#datefrom" ).datepicker({ 
                dateFormat: "dd-mm-yy", 
                monthNames: monthNames,
                dayNames: dayNames,
                dayNamesMin: dayNamesShort
            }).change(function(){
                rad_personalcabinet.refreshRef();
            });
            $( "#dateto" ).datepicker({ 
                dateFormat: "dd-mm-yy", 
                monthNames: monthNames,
                dayNames: dayNames,
                dayNamesMin: dayNamesShort
            }).change(function(){
                rad_personalcabinet.refreshRef();
            });
        }
    },
    'refreshRef': function()
    {
        $('#list_referals').html('<center><img src="'+SITE_URL+'jscss/components/mootree/mootree_loader.gif" alt="'+LOADING_TEXT+'" border="0" />'+LOADING_TEXT+'</center>');
        $('#list_referals').load(URL_REF_REFRESH,{'datefrom':$( "#datefrom" ).val(), 'dateto':$( "#dateto" ).val()});
    }
}

rad_profile = 
{
   'checkForm': function () 
    {
        $('#u_login_error').css('display','none');
        $('#u_email_error').css('display','none');
        $('#u_pass_error').css('display','none');
        $('#u_pass1_error').css('display','none');
        $('#u_pass2_error').css('display','none');

        var isError = false;
        if($('#u_login').val().length < 1) {
            $('#u_login_error').css('display','block');
            $('#u_login_error').text(EMPTY_LOGIN_FIELD);
            isError = true;
        } else if ($('#u_login').val().length > 70){
            $('#u_login_error').css('display','block');
            $('#u_login_error').text(TOOMUCHLETTERS_IN_FIELD);
            isError = true;
        }
        var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
        if($('#u_email').val().length < 1) {
            $('#u_email_error').css('display','block');
            $('#u_email_error').text(EMPTY_EMAIL_FIELD);
            isError = true;            
        } else if(!emailReg.test($('#u_email').val())) {
            $('#u_email_error').css('display','block');
            $('#u_email_error').text(EMAIL_INCORRECT);
            isError = true;               
        } else if($('#u_email').val().length > 64) {
            $('#u_email_error').css('display','block');
            $('#u_email_error').text(TOOMUCHLETTERS_IN_FIELD);
            isError = true;
        }
        if($('#changepass').is(':checked')) {
            if($('#u_pass').val().length < 6) {
                $('#u_pass_error').css('display','block');
                $('#u_pass_error').text(PASSWORDS_IS_SHORT);
                isError = true;
            }
	        if($('#u_pass1').val().length < 6) {
                $('#u_pass1_error').css('display','block');
                $('#u_pass1_error').text(PASSWORDS_IS_SHORT);
                isError = true;
	        }
			if($('#u_pass1').val()!=$('#u_pass2').val()) {
                $('#u_pass2_error').css('display','block');
                $('#u_pass2_error').text(PASSWORDS_NOT_MATCH);
                isError = true;			    
			}
		}
        if(isError) {
            return false;
        } else {
            return true;
        }
    },
    
    'editClick': function()
    {
        if(this.checkForm()){
            $('#editprofile_form').submit();
        }
    },
}

$(function(){
    rad_personalcabinet.init();
});
{/literal}