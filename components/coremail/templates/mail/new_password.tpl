{* 
    Дополнение к заголовкам
    Будьте внимательны - они специально стоят вне блока strip
    для того, чтобы переносы строк не пропускались!
    параметр не обязательный - это всего-лишь демонстрация его работы
*}
{mailtemplate type="html" name="headers"}
X-Priority: 1 (Higuest)
{/mailtemplate}

{*
В случае, если необходимо отправлять письма через SMTP
В другом случае, можно использовать type:mail и будет отправлено сообщение через стандартный mail без доп. параметров
*}
{*mailtemplate type="html" name="transport"}
    type:smtp
    host:example.com
    port:25
    user:admin@example.com
    password:typePassword Here
{/mailtemplate*}

{strip}

{************* HTML FORMAT *************}

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
    Прикрепление, т.е. копия письма кому будет отправленна
    Необязательный параметр
    формат записи может быть как простой e-mail
    пример: admin@site.com
    так и с именем, по формату RFC
    Administration site.com <admin@site.com>
*}
{*mailtemplate type="html" name="Cc"}
    Admin2 <{config get="admin.mail"}>
{/mailtemplate*}

{*
    Прикрепление, т.е. копия письма кому будет отправленна
    Необязательный параметр
    формат записи может быть как простой e-mail
    пример: admin@site.com
    так и с именем, по формату RFC
    Administration site.com <admin@site.com>
*}
{*mailtemplate type="html" name="Bcc"}
    admin3@site.com
{/mailtemplate*}

{*
    Тема для письма
    Обязательный параметр
    Простой текст в одну строчку
*}
    {mailtemplate type="html" name="subject"}
        {lang code="rempass.mail.title" ucf=true}
    {/mailtemplate}

{*
Само тело письма, тут можно сделать {literal}Text{/literal} для того,
чтобы сохранить переносы, или вынести этот параметр за пределы блока {strip}
Обязательный параметр
*}
    {mailtemplate type="html" name="body"}
    <html>
    <head>
        <title>{lang code="rempass.mail.title" ucf=true}</title>
    </head>
    <body>
        {lang code="auth_data_updated.mailtemplate.message" ucf=true}: <a href="{const SITE_URL}">{const SITE_URL}</a>
    <br/>
    E-Mail: {$user->u_email}
    <br/>
        {lang code="pass.mailtemplate.text" ucf=true}: {$clearpass}
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
    {config get="admin.mail"}
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
    admin3@example.com
{/mailtemplate*}

{*
    Тема для письма
    Обязательный параметр
    Простой текст в одну строчку
*}
    {mailtemplate type="text" name="subject"}
        {lang code="rempass.mail.title" ucf=true}
    {/mailtemplate}

{*
Само тело письма, тут можно сделать {literal}Text{/literal} для того,
чтобы сохранить переносы, или вынести этот параметр за пределы блока {strip}
Обязательный параметр
Пример как можно спользовать literal показан
*}
    {mailtemplate type="text" name="body"}
        {literal}
        {lang code="rempass.mail.title" ucf=true}
        {lang code="auth_data_updated.mailtemplate.message" ucf=true}: {config SITE_URL}
        E-Mail: {$user->u_email}
        {lang code="pass.mailtemplate.text" ucf=true}: {$clearpass}
        {/literal}
    {/mailtemplate}

{/strip}