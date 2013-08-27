{strip}
{if isset($action) and (!isset($wrong_capcha) or !$wrong_capcha)}
    {if $action eq 'update1'}
        {include file="$_CURRENT_LOAD_PATH/site.order/step1.list.tpl"}
    {elseif ($action eq 'order') or ($action eq 'success')}
       {if isset($message)}
            <script language="JavaScript" type="text/javascript">
                var URL_REFRESHBIN = '{url href="alias=binMenuXML&action=refreshbin"}';
                RADBIN.refresh();
            </script>            
           <div style="width:100%; text-align:center;color:#898989;"><h2>{$message}</h2></div>
       {/if}
    {/if}
{else}

{if isset($message) and $message != false }
        <div style="width:100%; text-align:center;color:#898989;"><h2>{$message}</h2></div>
{else}
<script language="JavaScript" type="text/javascript">
    var ENTER_NAME = '{lang code='entername.basket.error' ucf=true}';
    var ENTER_PHONE = '{lang code='enterphone.basket.error' ucf=true}';
    var REQUEST_FAILED = '{lang code='requestfailed.basket.error' ucf=true}';
    var ENTER_CAPCHA = '{lang code="entercapcha.session.text" ucf=true}';
    var ENTER_EMAIL = '{lang code="enteremail.basket.error" ucf=true}';
    var EMAIL_INCORRECT = '{lang code="emailincorrect.basket.error" ucf=true}';
    var EMPTY_EMAIL_FIELD   = '{lang code="emptyemailfield.session.message" ucf=true}';
    var ENTER_ADDRESS = '{lang code="enteraddress.basket.error" ucf=true}';
    var CONFIRM_DELETTING = '{lang code="deletebinposition.catalog.query" ucf=true}';
    var REQUIRED_FIELD      = '{lang code="requiredfield.session.message" ucf=true}';
    {* CONST URL'S FOR RAD_BIN FUNCTIONS *}
    var URL_BINXML = '{url href="alias=binXML&action=addtobin"}';
    var URL_REFRESHBIN = '{url href="alias=binMenuXML&action=refreshbin"}';
    var URL_CHANGEBINCOUNT = '{url href="alias=binXML&action=changebincount"}';
    var URL_DELFROMBIN = '{url href="alias=binXML&action=delfrombin"}';
    var URL_ORDER = '{url href="alias=order.html"}';
    var URL_ADDTOBIN = '{url href="alias=binXML&action=addtobin"}';
    var URL_SHOWCAPTCHA = '{url href="alias=SYSXML&a=showCaptcha"}';
    var URL_REFRESHORDER = '{url href="alias=order.htmlXML&action=update1"}';
</script>
{*}{url type="js" module="corecatalog" file="radorder.js"}{*}
    {if isset($error) and $error != false} <div style="width:100%; text-align:center;color:#898989;"><h2>{$error}</h2></div> {/if}
    <div class="rpart" id="basket_content_list">
        {include file="$_CURRENT_LOAD_PATH/site.order/step1.list.tpl"}
    </div>
    {if !empty($delivery) and !empty($items)}
       {include file="$_CURRENT_LOAD_PATH/site.order/delivery.tpl"}
    {/if}
    {if !empty($items)}
    <div class="rpart" id="basket_order_data">
        {include file="$_CURRENT_LOAD_PATH/site.order/quick.order.data.tpl"}
    </div>
    {/if}
    {/if}
{/if}
{/strip}