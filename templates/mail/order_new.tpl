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
        так и сименем, по формату RFC
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
        так и сименем, по формату RFC
        Administration site.com <admin@site.com>
    *}
    {*mailtemplate type="html" name="Cc"}
        adminCC <admincc@site.com>
    {/mailtemplate*}
    
    {*
        Прикрепление, т.е. копия письма кому будет отправленна
        Необязательный параметр
        формат записи может быть как простой e-mail
        пример: admin@site.com
        так и сименем, по формату RFC
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
        {lang code="order.mailtemplate.title" ucf=true}
    {/mailtemplate}
    
    {*
    Само тело письма, тут можно сделать {literal}Text{/literal} для того,
    чтобы сохранить переносы, или вынести этот параметр за пределы блока {strip}
    Обязательный параметр
    *}
    {mailtemplate type="html" name="body"}
<html>
    <head>
        <title>{lang code="order.mailtemplate.title" ucf=true}</title>
    </head>
    <body>
        <h2>{config get="page.defaultTitle"}</h2>
        <h1 style="color: rgb(56, 68, 86); font-size: 12pt; font-weight: bold;">Заказ № {$order->order_num}</h1>
        <table border="0" style="font-size: 11pt;">
            <tr>
                <td align="right"><b>Заказчик:</b></td>
                <td>{$order->order_fio}</td></tr>
            <tr>
                <td align="right"><b>Телефон:</b></td>
                <td>{$order->order_phone}</td>
            </tr>
            <tr>
                <td align="right"><b>Адрес:</b></td>
                <td>{$order->order_address}</td>
            </tr>
            <tr>
                <td align="right"><b>Дата заказа:</b></td>
                <td>{$order->order_dt}</td>
            </tr>
        </table>

        <table width="100%" cellpadding="4" border="1" style="border: 2px solid rgb(56, 68, 86); border-collapse: collapse; font-size: 10pt;">
            <tr style="text-align: center; background-color: rgb(195, 210, 233); font-weight: bold;">
                <td align="middle">Код</td>
                <td align="middle">Наименование</td>
                <td align="middle">Цена</td>
                <td align="middle">Кол-во</td>
                <td align="middle">Сумма</td>
            </tr>
            {foreach $order->order_positions as $op}
            <tr>
                <td align="middle">{$op->product->cat_code}</td>
                <td align="middle">{$op->product->cat_name}</td>
                <td align="middle">{$op->bp_cost}</td>
                <td align="middle">{$op->bp_count} шт</td>
                <td align="middle">{$op->bp_cost * $op->bp_count} {$order->order_currency}</td>
           </tr>
           {/foreach}
           {if !empty($order->delivery)}
           <tr>
               <td align="right" colspan="2">
                   {lang code="orderdelivery.catalog.text" ucf=true}:&nbsp;{$order->delivery->rdl_name}
               </td>
               <td align="right" colspan="3">{$order->delivery->rdl_cost}&nbsp;{currency get="ind"}</td>
           </tr>
           {/if}
           <tr>
                <td align="right" style="background-color: rgb(195, 210, 233);" colspan="2">Итого:</td>
                <td align="right" colspan="4">{$order->order_summ} {$order->order_currency}</td>
           </tr>
        </table>
</body>
</html>
{/mailtemplate}

{************* TEXT FORMAT *************}
    
    {*
        От кого будет отправляться письмо
        Обязательный параметр
        формат записи может быть как простой e-mail
        пример: admin@site.com
        так и сименем, по формату RFC
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
        так и сименем, по формату RFC
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
        так и сименем, по формату RFC
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
        {lang code="order.mailtemplate.title" ucf=true}
    {/mailtemplate}
    
    {*
    Само тело письма, тут можно сделать {literal}Text{/literal} для того,
    чтобы сохранить переносы, или вынести этот параметр за пределы блока {strip}
    Обязательный параметр
    Пример как можно спользовать literal показан
    *}
    {mailtemplate type="text" name="body"}
{lang code="order.mailtemplate.title" ucf=true}
{literal}
{config get="page.defaultTitle"}
Заказ № {/literal}{$order->order_num}{literal}
Заказчик: {/literal}{$order->order_fio}{literal}
Телефон: {/literal}{$order->order_phone}{literal}
Адрес: {/literal}{$order->order_address}{literal}
Дата заказа: {/literal}{$order->order_dt}{literal}

Код | Наименование | Цена | Кол-во | Сумма |
{/literal}
{foreach $order->order_positions as $op}
{$op->product->cat_code} | {$op->product->cat_name} | {$op->bp_cost} | {$op->bp_count} шт | {$op->bp_cost * $op->bp_count} {$order->order_currency} | {literal}
{/literal}
{/foreach}
{if !empty($order->delivery)}
{lang code="orderdelivery.catalog.text" ucf=true} | {$order->delivery->rdl_name} | {$order->delivery->rdl_cost} {currency get="ind"}
{/if}
{literal}___________________________
Итого: {/literal}{$order->order_summ} {$order->order_currency}
    {/mailtemplate}
{/strip}