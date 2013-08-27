{* 
    Дополнение к заголовкам
    Будьте внимательны - они специально стоят вне блока strip
    для того, чтобы переносы строк не пропускались!
    параметр не обязательный - это всего-лишь демонстрация его работы
*}
{*mailtemplate type="html" name="headers"}
X-Priority: 1 (Highest)
{/mailtemplate*}

{strip}
{mailtemplate type="html" name="from"}
    {lang code="site_admin.mailtemplate.title" ucf=true} <{config get="system.mail"}>
{/mailtemplate}

{mailtemplate type="html" name="subject"}
    {lang code="confirm_email.mailtemplate.title" ucf=true}
{/mailtemplate}

{mailtemplate type="html" name="body"}
    <html>
    <head>
        <title>{lang code="confirm_email.mailtemplate.title" ucf=true}</title>
    </head>
    <body>
        {lang code="confirm_email.mailtemplate.text" ucf=true} <a href="{$link}">{lang code="click_here.mailtemplate.link" ucf=false}</a>
    </body>
    </html>
{/mailtemplate}

{mailtemplate type="text" name="from"}
    {lang code="site_admin.mailtemplate.title" ucf=true} <{config get="system.mail"}>
{/mailtemplate}

{mailtemplate type="text" name="subject"}
    {lang code="confirm_email.mailtemplate.title" ucf=true}
{/mailtemplate}

{mailtemplate type="text" name="body"}
    {literal}
    {lang code="confirm_email.mailtemplate.text" ucf=true} {lang code="click_here.mailtemplate.link" ucf=false}: {$link}
    {/literal}
{/mailtemplate}

{/strip}