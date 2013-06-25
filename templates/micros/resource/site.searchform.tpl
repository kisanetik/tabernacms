{strip}
<script language="JavaScript" type="text/javascript">
	var SEARCH_PHRASE = "{lang code='phrase.search.text' ucf=true|replace:'"':'&quot;'}";
</script>
<form method="post" action="{url href="alias=search"}"><div id="search-box">
	<input type="text" name="search" maxlength="30" value="{if $search}{$search}{else}{lang code='phrase.search.text' ucf=true|replace:'"':'&quot;'}{/if}" id="scan"
	{literal}
	   onfocus="if (this.value==SEARCH_PHRASE)this.value='';"
	   onblur="if (this.value==''){this.value=SEARCH_PHRASE}"/>
	{/literal}
	<input type="submit" id="find" name="send" class="tx wt" value="{lang code="-find" ucf=true}"/>
	{if $params->search_query_hint}<span id="search-hint"><a href="#search_query_hint" rel="ibox" title="{lang code='search.query_hint_title' ucf=true}">?</a></span>
		{url file="jscss/components/jquery/ibox/ibox.js" type="js" load="sync"}
		<div id="search_query_hint" class="hide">{lang code='search.query_hint' ucf=true}</div>
	{/if}
	{if $params->substring_checkbox}
		<div id="search-ss"><label><input type="checkbox" name="ss" value="1"{if $params->substring_checked} checked{/if}> Искать по фрагментам слов</label></div>
	{/if}
	</div>
</form>
{/strip}