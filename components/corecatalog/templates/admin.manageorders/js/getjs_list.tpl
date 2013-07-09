var SITE_URL = '{const SITE_URL}';
var SITE_ALIAS = '{const SITE_ALIAS}';

var REFRESH_URL = '{url href="action=refresh"}';
var DELETE_URL = '{url href="action=delete"}';

var FAILED_REQUEST = "{lang code='requestisfiled.catalog.text' ucf=true|replace:'"':'&quot;'}";
var CONFIRM_DELETE_ORDER = "{lang code='reallydeleteorder.catalog.query' ucf=true|replace:'"':'&quot;'}";
var LOADING_TEXT = "{lang code='-loading' ucf=true|replace:'"':'&quot;'}";

var HASH = '{$hash}';

{literal}
RADOrdersList = {
    st:null,
    sch:null,
    chFilters: function(){
        var st = $('order_status').options[$('order_status').selectedIndex].value;
        var sch = $('order_scheme').options[$('order_scheme').selectedIndex].value;
        if( (st>0 || st==(-1)) && (sch>0 || sch==(-1)) ){
            this.st = st;
            this.sch = sch;
            this.refresh(st, sch);
        }
    },
    refresh: function(st, sch, page){
        document.getElementById('OrdersListMessage').innerHTML = LOADING_TEXT;
        var s = '';
        if(st && sch) {
            s = 'pid/'+st+'/scheme/'+sch+'/';
        } else if(st && this.sch) {
            s = 'pid/'+st+'/scheme/'+this.sch+'/';
        } else if(this.st && sch) {
            s = 'pid/'+this.st+'/scheme/'+sch+'/';
        } else if(this.st && this.sch) {
            s = 'pid/'+this.st+'/scheme/'+this.sch+'/';
        }
        page = page || 1;
        s = s +'p/'+page;
        var req = new Request({
            url: REFRESH_URL+s,
            onSuccess: function(txt){
               document.getElementById('panel_orderslist').innerHTML = txt;
               document.getElementById('OrdersListMessage').innerHTML = '';
            },
            onFailure: function(){
                alert(FAILED_REQUEST);
            }
        }).send();
    },
    deleteOrder: function(oid)
    {
       if( confirm( CONFIRM_DELETE_ORDER ) ){
           var req = new Request({
               url: DELETE_URL+'oid/'+oid+'/',
               data:{hash:HASH},
               onSuccess: function(txt){
                  eval( txt );
               },
               onFailure: function(){
                   alert(FAILED_REQUEST);
               }
           }).send();
       }
    },
    'changeContntLang': function(lngid,lngcode)
    {
       RADOrdersList.refresh();
    },
    message: function(mes){
        document.getElementById('OrdersListMessage').innerHTML = mes;
        setTimeout("document.getElementById('OrdersListMessage').innerHTML = '';",5000);
    },
    paging: function(p){
        $('td_paging').set('html','<img src="{url type="image" preset="original" module="core" file="mootree/mootree_loader.gif"}" border="0" />');
        this.refresh(this.st, this.sch, p);
    },
}
RADCHLangs.addContainer('RADOrdersList.changeContntLang');
{/literal}