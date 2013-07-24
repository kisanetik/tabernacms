{strip}
{if (isset($message))}
    {assign var=message value=" `$message` "}
{else}
    {assign var=message value=" "}
{/if}
<a href="{const SITE_URL}">
    <img src="{url module="core" preset="original" type="image" file="backend/logo_1.png"}" alt="{config get="page.defaultTitle"}" title="{config get="page.defaultTitle"}" style="border:0px;margin:10px;">
</a>
<h1 align="center" style="margin:20px 0;">{lang code="404.site.title" find="@message@" replace=$message ucf=true}</h1>
<h2 align="center">{lang code="404returnto.site.text" find="@link@" replace={const SITE_URL} ucf=true}</h2>
<div align="center" style="margin-top:20px;">{lang code="404writeto.site.text" find=array("@link@", "@subject@") replace=array($adminMail, {lang code="404mailsubject.site.mail" find="@link@" replace={$smarty.server.REQUEST_URI|escape} ucf=true}) ucf=true}</div>
{/strip}