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
        Администрация сайта <{config get="system.mail"}>
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
        Admin2 <supportcc@example.com>
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
        adminbcc@example.com
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
            На Ваш e-mail {$user->u_email} был отправлен запрос на восстановления пароля с сайта <a href="{const SITE_URL}">{const SITE_URL}</a> 
            <br />
            Для продолжения перейдите по ссылке ниже, и на Ваш e-mail будет выслан новый пароль.
            <br />
            <a href="{$link}">{$link}</a>
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
        Администрация сайта <{config get="system.mail"}>
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
        support@example.com
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
На Ваш e-mail {$user->u_email} был отправлен запрос на восстановления пароля с сайта http://shop.rad-cms.ru 
Для продолжения перейдите по ссылке ниже, и на Ваш e-mail будет выслан новый пароль.
{$link}
{/literal}
    {/mailtemplate}

{/strip}