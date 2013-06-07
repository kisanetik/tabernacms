{strip}
<script language="JavaScript" type="text/javascript">
	var SEARCH_PHRASE = "{lang code='phrase.search.text' ucf=true|replace:'"':'&quot;'}";
</script>
<div class="search"></div>
<div class="cont">
	<form method="post" action="{url href="alias=search"}">
		<input type="text" name="search" maxlength="30" value="{if $search}{$search}{else}{lang code='phrase.search.text' ucf=true|replace:'"':'&quot;'}{/if}" id="scan" 
		{literal}
		   onfocus="if (this.value==SEARCH_PHRASE)this.value='';"
		   onblur="if (this.value==''){this.value=SEARCH_PHRASE}"/>
		{/literal}

		<input type="submit" id="find" name="send" class="tx wt" value="{lang code="-find" ucf=true}"/>
	</form>

	<a href="{const SITE_URL}"><img src="{const SITE_URL}img/des/default/logo.jpg" width="144" height="40" title="TABERNA" class="site_logo"/></a>

	<p class="logo ">{$params->title}</p>
	<ul class="uplist">
		<li class="topic">{lang code="feedback.others.title" ucf=true}</li>
		{if !empty($phones)}
			{foreach from=$phones item="phone" key="key_phone"}
				<li>{$phone}</li>
			{/foreach}
		{/if}
	</ul>
{/strip}