var SITE_URL = '{const SITE_URL}';
var SITE_ALIAS = '{const SITE_ALIAS}';

var CHANGE_STATE_URL = '{url href="action=changestate"}';
var ADD_PRODUCTS_URL = '{url href="alias=SITE_ALIAS&action=addProducts"}';
var SHOW_ORDER_URL = '{url href="action=show_order"}';
var DELETE_POSITION_URL = '{url href="action=delete_position"}';
var CHANGE_COUNT_URL = '{url href="action=change_count"}';
var SELECTED_STATE_ERROR = "{lang code='selectstateorders.catalog.error' ucf=true|replace:'"':'&quot;'}";
var FAILED_REQUEST = "{lang code='requestisfiled.catalog.text' ucf=true|replace:'"':'&quot;'}";
var LOADING_TEXT = "{lang code="-updated" ucf=true|replace:'"':'&quot;'}";
var DONE_TEXT = "{lang code="-done" ucf=true|replace:'"':'&quot;'}";
var DELETE_CONFIRM = "{lang code="reallydeleteproduct.catalog.query" ucf=true|replace:'"':'&quot;'}"; 
var HASH = '{$hash}';

{literal}
RADOrders = {
    saveStatus: function(oid)
    {
       var nsid=$('order_status').options[$('order_status').selectedIndex].value;
       if( (nsid>0) && (oid>0) ){
           var req = new Request({
               url: CHANGE_STATE_URL+'nsid/'+nsid+'/oid/'+oid+'/',
               data:{hash:HASH},
               onSuccess: function(txt){
                  eval(txt);
               },
               onFailure: function(){
                   alert(FAILED_REQUEST);
               }
           }).send();
       }else{
           alert(SELECTED_STATE_ERROR);
       }
    },
    'message': function(mes)
    {
        document.getElementById('ShowOrderMessage').innerHTML = mes;
        setTimeout("document.getElementById('ShowOrderMessage').innerHTML = '';",5000);
    },
    'addProducts': function(productsList)
    {
        if(this.order_id > 0) {
            var jsondata = JSON.decode( '{"jsondata":'+JSON.encode(productsList)+'}' );
            var req = new Request({
                url: ADD_PRODUCTS_URL + 'oid/'+this.order_id+'/hash/'+HASH,
                data: Object.toQueryString(jsondata),
                onSuccess: function(txt) {
                    eval(txt);
                },
                onFailure: function() {
                    alert(FAILED_REQUEST);
                }
            }).send();
        }
    },
    'refresh': function()
    {
        this.message(LOADING_TEXT);
        var req = new Request({
                url: SHOW_ORDER_URL + 'oid/'+this.order_id,
                onSuccess: function(txt) {
                    $('panel_orderDetailshow').set('html',txt);
                },
                onFailure: function() {
                    alert(FAILED_REQUEST);
                }
            }).send();
    },
    'deleteOrder': function(cat_id)
    {
        if(confirm(DELETE_CONFIRM)) {
            if(cat_id > 0 && this.order_id > 0) {
                var req = new Request({
                    url: DELETE_POSITION_URL + 'oid/' + this.order_id + '/cat_id/' + cat_id + '/',
                    data: {hash:HASH},
                    onSuccess: function(txt) {
                        eval(txt);
                    },
                    onFailure: function() {
                        alert(FAILED_REQUEST);
                    }
                }).send();
            }
        }
    },
    changeCount: function(cat_id)
    {
       var count = $('p_count_'+cat_id).value;
       if(count == 0) {
           this.deleteOrder(cat_id);
           this.refresh();
       } else if (count > 0) {
           var req = new Request({
               url: CHANGE_COUNT_URL+'oid/'+this.order_id+'/cat_id/'+cat_id+'/count/'+count+'/',
               data:{hash:HASH},
               onSuccess: function(txt) {
                  eval(txt);
               },
               onFailure: function() {
                  alert(FAILED_REQUEST);
               }
           }).send();
      } else {
           this.refresh();
      } 
    }
}

{/literal}