{strip}
<div class="search"></div>
<div class="cont">
	{*
	<form method="get" action="" >
        {literal}
		<input type="text" name="search"  maxlength="30"  value="Введите то, не знаю что" id="scan" onfocus="if (this.value=='Введите то, не знаю что') this.value='';"
onblur="if (this.value==''){this.value='Введите то, не знаю что'}" />
        {/literal}
			
		<input  type="button" id="find" name="send" class="tx wt" value="Найти" />
	</form>
	*}
	
	<a href="{const SITE_URL}"><img src="{const SITE_URL}img/des/default/logo.jpg" width="144" height="40" title="TABERNA" class="site_logo" /></a>
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