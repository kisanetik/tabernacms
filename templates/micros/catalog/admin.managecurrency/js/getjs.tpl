var REFRESH_URL = '{url href="action=getList"}';
var ADDWINDOW_URL = '{url href="action=addwindow"}';
var ADD_ONE_URL = '{url href="action=add"}';
var DELETE_ONE_URL = '{url href="action=deleteone"}';
var GET_PRODUCTS_CNT_URL = '{url href="action=getproductsbycur"}'; 
var EDIT_ONE_URL = '{url href="action=editone"}';
var APPLY_CLICK_URL = '{url href="action=applysave"}';

var FAILED_REQUEST = "{lang code="requestisfiled.catalog.text"|replace:'"':'&quot;'}";
var ADD_CURRENCY_TITLE = "{lang code="addcurrency.catalog.title"|replace:'"':'&quot;'}";
var DELETE_ONE_QUERY = "{lang code="currencydeleteone.catalog.query"|replace:'"':'&quot;' ucf=true}";
var ADDCURRENCY_WTITLE = "{lang code="addeditcurrency.catalog.title"|replace:'"':'&quot;'}";
var PRODUCTS_FOUND = "{lang code="productsfound.catalog.text"|replace:'"':'&quot;' ucf=true}";

var HASH = '{$hash}';

{literal}
RADCurrency = {
    add: function()
    {
        var req = new Request({
            url: ADDWINDOW_URL,
            onSuccess: function(txt){
                if($('CurrencyAddWindow'))
                    $('CurrencyAddWindow').destroy();
				showAllSelects();
                var wheight = Window.getHeight();
	            if(wheight>340){
	                wheight = 340;
	            }
	            wheight = wheight-50;
                var wnd = new dWindow({
	                   id:'CurrencyAddWindow',
	                   content: txt,
	                   width: 400,
	                   height: wheight,
	                   minWidth: 180,
	                   minHeight: 160,
	                   left: 450,
	                   top: 150,
	                   title: ADD_CURRENCY_TITLE
	               }).open($(document.body));
            },
            onFailure: function(){
                alert(FAILED_REQUEST);
            }
        }).send();
    },
    applyClick: function()
    {
        var req = new Request({
            url:APPLY_CLICK_URL,
            data: $('CurrencyListForm').toQueryString(),
            onSuccess: function(txt){
                eval(txt);
            },
            onFailure: function(){
                alert(FAILED_REQUEST);
            }
        }).send();
    },
    deleteClick: function(id,cur_name)
    {
        var has_products = 0;
        var req = new Request({
            url: GET_PRODUCTS_CNT_URL+'cur_id/'+id+'/',
            onSuccess: function(txt) {
                var conf = 1;
                var prod_cnt = parseInt(txt);
                if(prod_cnt > 0) {
					conf = confirm(DELETE_ONE_QUERY+String.fromCharCode(10)+String.fromCharCode(13)+cur_name+String.fromCharCode(10)+String.fromCharCode(13)+PRODUCTS_FOUND+String.fromCharCode(10)+String.fromCharCode(13)+prod_cnt);
                } else {
                	conf = confirm(DELETE_ONE_QUERY);
                }
                if(conf) {
					var req = new Request({
						url: DELETE_ONE_URL+'cur_id/'+id+'/',
						data:{hash:HASH},
			            onSuccess: function(txt) {
			                eval(txt);
			            },
			            onFailure: function() {
			                alert(FAILED_REQUEST);
			            }
			        }).send();
                }
            },
            onFailure: function(){
                alert(FAILED_REQUEST);
            }
        }).send();
	},
    editClick: function(cur_id)
    {
        var req = new Request({
            url: EDIT_ONE_URL+'cur_id/'+cur_id+'/',
            onSuccess: function(txt){
                if($('CurrencyAddWindow'))
                    $('CurrencyAddWindow').destroy();
			    showAllSelects();
                var wheight = Window.getHeight();
	            if(wheight>340){
	                wheight = 340;
	            }
	            wheight = wheight-50;
                var wnd = new dWindow({
	                   id:'CurrencyAddWindow',
	                   content: txt,
	                   width: 350,
	                   height: wheight,
	                   minWidth: 180,
	                   minHeight: 160,
	                   left: 450,
	                   top: 150,
	                   title: ADD_CURRENCY_TITLE
	               }).open($(document.body));
            },
            onFailure: function(){
                alert(FAILED_REQUEST);
            }
        }).send();
    },
    cancelnewclick: function()
    {
        $('CurrencyAddWindow').destroy();
		showAllSelects();
    },
    submitnewclick: function()
    {
        var req = new Request({
            url: ADD_ONE_URL,
            data: $('addCurrencyForm').toQueryString(),
            method: 'post',
            onSuccess: function(txt){
                eval(txt);
            },
            onFailure: function(){
                alert(FAILED_REQUEST);
            }
        }).send();
    },
    refresh: function()
    {
        var req = new Request({
            url: REFRESH_URL,
            onSuccess: function(txt){
                $('currency_list').set('html',txt);
                if(Browser.Engine.trident)
                    startList();
            },
            onFailure: function(){
                alert(FAILED_REQUEST);
            }
        }).send();
    },
    message: function(message)
    {
        document.getElementById('ManageCurrencyMessage').innerHTML = message;
        setTimeout("document.getElementById('ManageCurrencyMessage').innerHTML = '';",5000);
    }
}
window.onload = function(){RADCurrency.refresh();}
{/literal}