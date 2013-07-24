var SITE_ALIAS = '{const SITE_ALIAS}';
var SITE_URL = '{const SITE_URL}';

/*** URL'S ***/
var URL_GET_REFS = '{url href="action=getrefs"}';
var URL_SHOW_DETAILS = '{url href="action=showdetails"}';
var URL_SHOW_DETAILS_STATIC = '{url href="action=showdetailsstatic"}';

{*** TEXTS ***}
var TITLE_SEARCH = '{lang code="-search.title" ucf=true}';
var FAILED_REQUEST = "{lang code="requestisfiled.catalog.text" htmlchars=true}";
var DETAILS_TITLE = '{lang code="partnerdetails.session.title" ucf=true}';

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

var monthNames = [JANUARY,FEBRUARY,MARCH,APRIL,MAY,JUNE,JULY,AGUST,SEPTEMBER,OCTOBER,NOVEMBER,DECEMBER];
var dayNames = [SUNDAY, MONDAY, TUESDAY, WEDNESDAY, THURSDAY, FRIDAY, SATURDAY];
var dayNamesShort = [SUNDAY_SHORT, MONDAY_SHORT, TUESDAY_SHORT, WEDNESDAY_SHORT, THURSDAY_SHORT, FRIDAY_SHORT, SATURDAY_SHORT];

{literal}
rad_referals = {
    'searchword':'',
    'currElId':0,
    'init': function()
    {
        $('searchword').addEvents({
            'focus': function(el){
                if(this.value==TITLE_SEARCH) {this.value=''};
            },
            'blur': function(el){
                if(this.value=='') {this.value=TITLE_SEARCH};
            }
        });
        new DatePicker('.demo_vista', { inputOutputFormat: 'd-m-Y',
                                    pickerClass: 'datepicker_vista',
                                    days: dayNamesShort,
                                    months: monthNames,
                                    onSelect: function(el){
                                        rad_referals.filter();
                                    }}
                   );
        rad_referals.filter();
    },
    'showDetails': function(elId)
    {
        var req = new Request({
            url:URL_SHOW_DETAILS,
            method:'post',
            data:{'uid':elId
                  ,'datefrom':$('date_from').value
                  ,'dateto':$('date_to').value},
            onSuccess: function(txt) {
                var wheight = Window.getHeight();
                    if(wheight>350){
                        wheight = 350;
                    }
                    wheight = wheight-50;
                    if($('refWindow_'+elId)) {
                        $('refWindow_'+elId).destroy();
                    }
                    var wnd = new dWindow({
                        id:'refWindow_'+elId,
                        content: txt,
                        width: 750,
                        height: wheight,
                        minWidth: 180,
                        minHeight: 160,
                        left: 350,
                        top: 100,
                        title: DETAILS_TITLE
                    }).open($(document.body));
                    rad_referals.showDetailStatic(elId);
            }
        }).send();
    },
    'showDetailStatic': function(elId)
    {
        this.currElId = elId;
        var req = new Request({
            url:URL_SHOW_DETAILS_STATIC,
            method:'post',
            data:$('detailsForm_'+rad_referals.currElId).toQueryString(),
            onSuccess: function(txt) {
                $('staticTab'+rad_referals.currElId+'_tabcenter').innerHTML = txt;
            }
        }).send();
    },
    'filter': function()
    {
        this.showLoad();
        var lastSW = $('searchword').value;
        if($('searchword').value==TITLE_SEARCH) {
            $('searchword').value = '';
        }
        var data = $('searchRefForm').toQueryString();
        var req = new Request({
            url:URL_GET_REFS,
            method: 'post',
            data: $('searchRefForm').toQueryString(),
            onSuccess: function(txt) {
                $('panel_reflist').innerHTML = txt;
                rad_referals.addPartnersEvents();
            },
            onFailure: function() {
                rad_referals.message(FAILED_REQUEST);
                rad_referals.showLoad(false);
            }
        }).send();
        $('searchword').value = lastSW;
    },
    'addPartnersEvents': function()
    {
        if($('u_email')) {
            $('u_email').addEvent('click', function(event) {
                rad_referals.showDetails($(this).get('u_id'));
            });
            $('u_fio').addEvent('click', function(event) {
                rad_referals.showDetails($(this).get('u_id'));
            });
        }
    },
    'refresh': function()
    {
        this.filter();
    },
    'showLoad': function(arg)
    {
        arg = arg || true;
    },
    'message': function(txt)
    {
        $('RefListMessage').innerHTML = message;
        setTimeout("$('RefListMessage').innerHTML = '';",5000);
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
window.addEvent('domready', function(e) {
    rad_referals.init();
});
{/literal}