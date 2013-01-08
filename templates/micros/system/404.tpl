{strip}
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>Ошибка 404: Страница {if ( isset( $message ) )}"{$message}" {/if}не найдена!</title>
</head>
<body>
<a href="{const SITE_URL}">
	<img src="{const SITE_URL}img/backend/logo_1.png" border="0" alt="Taberna - Бесплатная система электроной коммерции!" title="Taberna - Бесплатная система электроной коммерции!">
</a>
<h1 align="center">Страница {if ( isset( $message ) )}"{$message}" {/if}не найдена!</h1>
<h2 align="center" style="margin-top:20px;">Попробуйте вернуться на <a href="{const SITE_URL}">главную</a> страницу</h2>
<h3 align="center" style="margin-top:20px;">Если Вы считаете это ошибкой, пожалуйста, напишите <a href="mailto:{$adminMail}">администратору</a> сайта</h3>
</body>
</html>
{/strip}