{strip}
{if isset($autocomplete_url)}
	{url module="" file="jquery/jquery.js" type="js" load="sync"}
	{url module="" file="jquery/ui/jquery-ui.js" type="js" load="sync"}
{/if}
<script language="JavaScript" type="text/javascript">
{if isset($autocomplete_url)}{literal}
var cache = {};
var last_term;
$(function() {
	$("#scan").autocomplete({
		minLength: 3,
		delay: 500,
		source: function(request, response) {
			var term = request.term;
			if (term in cache) {
				response(cache[term]);
				return;
			}
			delete request.term;
			last_term = term;
			$.getJSON("{/literal}{$autocomplete_url}{literal}"+term+"/", request, function(data, status, xhr) {
				cache[term] = data;
				if (last_term == term) {
					response(data);
				}
			});
		}
	});
});{/literal}{/if}
var SEARCH_PHRASE = "{lang code='phrase.search.text' ucf=true htmlchars=true}";
</script>
<form method="post" action="{url href="alias=search"}"><div id="search-box">
    <input type="text" name="search" maxlength="30" value="{if $search}{$search}{else}{lang code='phrase.search.text' ucf=true htmlchars=true}{/if}" id="scan"
    {literal}
       onfocus="if (this.value==SEARCH_PHRASE)this.value='';"
       onblur="if (this.value==''){this.value=SEARCH_PHRASE}"/>
    {/literal}
    <input type="submit" id="find" name="send" class="tx wt" value="{lang code="-find" ucf=true}"/>
    {if $params->search_query_hint}<span id="search-hint"><a href="#search_query_hint" rel="ibox&width=410&height=350&relative=1&rleft=-100" title="{lang code='search.query_hint_title' ucf=true}">?</a></span>
        {url module="" file="jquery/ibox/ibox.js" type="js" load="sync"}
<script language="javascript">iBox.close_label="{lang code="-close" ucf=true}";</script>
        <div id="search_query_hint" class="hide">{lang code='search.query_hint' ucf=true}</div>
    {/if}
    {if $params->substring_checkbox}
        <div id="search-ss"><label><input type="checkbox" name="ss" value="1"{if $params->substring_checked} checked{/if}> Искать по фрагментам слов</label></div>
    {/if}
    </div>
</form>
{/strip}