{strip}
{url href="alias=SITE_ALIASXML&action=getjs" type="js"}
{url type="css" module="core" file="jquery/ui/jquery-ui-datepicker.css"}
<script type="text/javascript">
$('#referals').addClass('act');
$('#referals').removeAttr('href');
</script>
<strong>{lang code="yourreflink.session.text" ucf=true}:</strong>
<input type="text" class="user" id="reflink" value="{$ref_link}" style="width:690px;margin:0;" />
<div id="ref-stat-cal">
    <strong>{lang code="yourrefstat.session.text" ucf=true}:</strong>
    <div class="datecal">
        {lang code="costsfrom.catalog.label"}:&nbsp;<input type="text" class="user" id="datefrom" value="{$date_from|date:'datecal'}" />&nbsp;
        {lang code="coststo.catalog.text"}:&nbsp;<input type="text" class="user" id="dateto" value="{$date_to|date:'datecal'}" />
    </div>
</div>
<div id="referals_content_list" class="rpart">
    <div id="list_referals" class="basket">
        {include file="$_CURRENT_LOAD_PATH/site.personalcabinet/panels/refitems.tpl"}
    </div>
</div>
{/strip}