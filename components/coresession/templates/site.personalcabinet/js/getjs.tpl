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
var JANUARY = "{lang code="-january" ucf=true htmlchars=true}";
var FEBRUARY = "{lang code="-february" ucf=true htmlchars=true}";
var MARCH = "{lang code="-march" ucf=true htmlchars=true}";
var APRIL = "{lang code="-april" ucf=true htmlchars=true}";
var MAY = "{lang code="-may" ucf=true htmlchars=true}";
var JUNE = "{lang code="-june" ucf=true htmlchars=true}";
var JULY = "{lang code="-july" ucf=true htmlchars=true}";
var AGUST = "{lang code="-august" ucf=true htmlchars=true}";
var SEPTEMBER = "{lang code="-september" ucf=true htmlchars=true}";
var OCTOBER = "{lang code="-october" ucf=true htmlchars=true}";
var NOVEMBER = "{lang code="-november" ucf=true htmlchars=true}";
var DECEMBER = "{lang code="-december" ucf=true htmlchars=true}";

/*** DAYS ***/
var SUNDAY = "{lang code="-sunday" ucf=true htmlchars=true}";
var MONDAY = "{lang code="-monday" ucf=true htmlchars=true}";
var TUESDAY = "{lang code="-tuesday" ucf=true htmlchars=true}";
var WEDNESDAY = "{lang code="-wednesday" ucf=true htmlchars=true}";
var THURSDAY = "{lang code="-thursday" ucf=true htmlchars=true}";
var FRIDAY = "{lang code="-friday" ucf=true htmlchars=true}";
var SATURDAY = "{lang code="-saturday" ucf=true htmlchars=true}";

/*** DAYS SHORT ***/
var SUNDAY_SHORT = "{lang code="-sunday.short" ucf=true htmlchars=true}";
var MONDAY_SHORT = "{lang code="-monday.short" ucf=true htmlchars=true}";
var TUESDAY_SHORT = "{lang code="-tuesday.short" ucf=true htmlchars=true}";
var WEDNESDAY_SHORT = "{lang code="-wednesday.short" ucf=true htmlchars=true}";
var THURSDAY_SHORT = "{lang code="-thursday.short" ucf=true htmlchars=true}";
var FRIDAY_SHORT = "{lang code="-friday.short" ucf=true htmlchars=true}";
var SATURDAY_SHORT = "{lang code="-saturday.short" ucf=true htmlchars=true}";

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
        $('#list_referals').html('<center><img src="{url type="image" preset="original" module="core" file="mootree/mootree_loader.gif"}" alt="'+LOADING_TEXT+'" border="0" />'+LOADING_TEXT+'</center>');
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