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

{************* HTML FORMAT *************}

{*
В случае, если необходимо отправлять письма через SMTP
В другом случае, можно использовать type:mail и будет отправлено сообщение через стандартный mail без доп. параметров
*}
{*mailtemplate type="html" name="transport"}
    type:smtp
    host:example.com
    port:25
    user:admin@example.com
    password:my password
{/mailtemplate*}

{*
    От кого будет отправляться письмо
    Обязательный параметр
    формат записи может быть как простой e-mail
    пример: admin@site.com
    так и с именем, по формату RFC
    Administration site.com <admin@site.com>
*}
    {mailtemplate type="html" name="from"}
        {lang code="site_admin.mailtemplate.title" ucf=true} <{config get="system.mail"}>
    {/mailtemplate}

{*
    Кому будет отправленна копия письма
    Необязательный параметр
    формат записи может быть как простой e-mail
    пример: admin@site.com
    так и с именем, по формату RFC
    Administration site.com <admin@site.com>
*}
{*mailtemplate type="html" name="Cc"}
    AdminCC <admincc@mail.com>
{/mailtemplate*}

{*
    Кому будет отправленна скрытая копия письма
    Необязательный параметр
    формат записи может быть как простой e-mail
    пример: admin@site.com
    так и с именем, по формату RFC
    Administration site.com <admin@site.com>
*}
{*mailtemplate type="html" name="Bcc"}
    adminbcc@example.com
{/mailtemplate*}

{*
    Тема для письма
    Обязательный параметр
    Простой текст в одну строчку
*}
    {mailtemplate type="html" name="subject"}
        {lang code="registration.mailtemplate.title" ucf=true}
    {/mailtemplate}

{*
Само тело письма, тут можно сделать {literal}Text{/literal} для того,
чтобы сохранить переносы, или вынести этот параметр за пределы блока {strip}
Обязательный параметр
*}
    {mailtemplate type="html" name="body"}
    <html>
    <head>
        <title>{lang code="registration.mailtemplate.title" ucf=true}</title>
    </head>
    <body>
        {lang code="register_in_site.mailtemplate.title" ucf=true} {const SITE_URL}<br/>
        {lang code="to_confirm_registration_click.mailtemplate.text" ucf=true} <a href="{$link}">{lang code="click_here.mailtemplate.link" ucf=false}</a>
    </body>
    </html>
    {/mailtemplate}


{************* TEXT FORMAT *************}

{*
    От кого будет отправляться письмо
    Обязательный параметр
    формат записи может быть как простой e-mail
    пример: admin@site.com
    так и с именем, по формату RFC
    Administration site.com <admin@site.com>
*}
    {mailtemplate type="text" name="from"}
        {lang code="site_admin.mailtemplate.title" ucf=true} <{config get="system.mail"}>
    {/mailtemplate}

{*
    Прикрепление, т.е. копия письма кому будет отправленна
    Необязательный параметр
    формат записи может быть как простой e-mail
    пример: admin@site.com
    так и с именем, по формату RFC
    Administration site.com <admin@site.com>
*}
{*mailtemplate type="text" name="Cc"}
    admincc@example.com
{/mailtemplate*}

{*
    Прикрепление, т.е. копия письма кому будет отправленна
    Необязательный параметр
    формат записи может быть как простой e-mail
    пример: admin@site.com
    так и с именем, по формату RFC
    Administration site.com <admin@site.com>
*}
{*mailtemplate type="text" name="Bcc"}
    adminbcc@example.com
{/mailtemplate*}

{*
    Тема для письма
    Обязательный параметр
    Простой текст в одну строчку
*}
    {mailtemplate type="text" name="subject"}
        {lang code="registration.mailtemplate.title" ucf=true}
    {/mailtemplate}

{*
Само тело письма, тут можно сделать {literal}Text{/literal} для того,
чтобы сохранить переносы, или вынести этот параметр за пределы блока {strip}
Обязательный параметр
Пример как можно спользовать literal показан
*}
    {mailtemplate type="text" name="body"}
        {literal}
        {lang code="registration.mailtemplate.title" ucf=true}
        {lang code="register_in_site.mailtemplate.title" ucf=true} {const SITE_URL}
        {lang code="to_confirm_registration_click.mailtemplate.text" ucf=true} {lang code="click_here.mailtemplate.link" ucf=false}: {$link}
        {/literal}
    {/mailtemplate}

{/strip}