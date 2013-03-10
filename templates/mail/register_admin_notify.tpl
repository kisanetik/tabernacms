{*
В случае, если необходимо отправлять письма через SMTP
В другом случае, можно использовать type:mail и будет отправлено сообщение через стандартный mail без доп. параметров
*}
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
		{lang code="site_admin.mailtemplate.title" ucf=true} <{config get="system.mail"}>
	{/mailtemplate}

{*
	Тема для письма
	Обязательный параметр
	Простой текст в одну строчку
*}
	{mailtemplate type="html" name="subject"}
		{lang code="registration_admin.mailtemplate.title" ucf=true}
	{/mailtemplate}

{*
Само тело письма, тут можно сделать {literal}Text{/literal} для того,
чтобы сохранить переносы, или вынести этот параметр за пределы блока {strip}
Обязательный параметр
*}
	{mailtemplate type="html" name="body"}
	<html>
	<head>
		<title>{lang code="registration_admin.mailtemplate.title" ucf=true}</title>
	</head>
	<body>
		{lang code="was_registered_new_profile.mailtemplate.message" ucf=true}<br/>
	login: <strong>{$user->u_login}</strong><br/>
	e-mail: <strong>{$user->u_email}</strong>
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
		{lang code="site_admin.mailtemplate.title" ucf=true} <{config get="system.mail"}>
	{/mailtemplate}

{*
	Тема для письма
	Обязательный параметр
	Простой текст в одну строчку
*}
	{mailtemplate type="text" name="subject"}
		{lang code="registration_admin.mailtemplate.title" ucf=true}
	{/mailtemplate}

{*
Само тело письма, тут можно сделать {literal}Text{/literal} для того,
чтобы сохранить переносы, или вынести этот параметр за пределы блока {strip}
Обязательный параметр
Пример как можно спользовать literal показан
*}
	{mailtemplate type="text" name="body"}
		{lang code="was_registered_new_profile.mailtemplate.message" ucf=true}
	login: {$user->u_login}
	e-mail: {$user->u_email}
	{/mailtemplate}

{/strip}