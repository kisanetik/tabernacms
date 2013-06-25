{strip}
{*
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
*}
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>{rad_breadcrumbs::getTitle()}</title>
    <META NAME="ROBOTS" CONTENT="INDEX,FOLLOW">
    <META NAME="revisit-after" CONTENT="1 days">
    <META name="description" content="{rad_breadcrumbs::getMetaDescription()}">
    <META name="keywords" content="{rad_breadcrumbs::getMetaTags()}">
    <script language="JavaScript" type="text/javascript">
        var SITE_URL = '{const SITE_URL}';
        var SITE_ALIAS = '{const SITE_ALIAS}';
        var URL_SYSXML = '{url href="alias=SYSXML"}';
        var URL_LANGID = '{$_CURR_LANG_}';
    </script>
    {url file="jscss/components/jquery/jquery.js" type="js" load="sync"}
    <!--Main page scripts (effects, default values, submitting-->
    {url file="jscss/des/modern/product.js" type="js"}
    <!--Order bin library-->
    {url file="jscss/components/radbin.js" type="js"}

    {url file="jscss/des/modern/compiled.css" type="css" param="link"}
    {url file="jscss/des/modern/style.css" type="css" param="link"}
    {url file="jscss/des/modern/core.css" type="css" param="link"}
    {url file="jscss/des/modern/styles.css" type="css" param="link"}
    {url file="jscss/des/modern/fonts.css" type="css" param="link"}
    <!--Should be last, contains internal main page styles-->
    {url file="jscss/des/modern/internal.css" type="css" param="link"}
    {rad_jscss::getHeaderCode()}
</head>
<body>





    <div class="linesold"></div>
    {if isset($bottom)}{$bottom}{/if}
    {if !empty($footer)}{$footer}{/if}
    </div>
<div id="model_counter">
    <p>
        <span id="wordv">Найдено предложений:</span>
    </p>
    <p>
        <span id="m_count1">…&nbsp;</span>. <a id="balloon_button" href="" onclick="filterViewModel.submitFilters(); return false;">Показать</a>
    </p>
</div>

<div id="suggestions"></div>

<div class="container">
<div class="cont_two">
<header class="l-header">
    {if !empty($header)}{$header}{/if}
</header>
    {if isset($top)}{$top}{/if}

<div style="overflow: visible;" id="innerdiv">

<!-- Если убрать съезжает низ сайта -->
<div class="b-light-slider home-light-slider inited">

</div>


<div class="vitrina_right">
    {if !empty($right)}{$right}{/if}
    <div class="ym-banner-type1">
        <div class="ym-banner">
            <a onclick="_gaq.push(['_trackEvent', 'Яндекс Маркет', 'Главная']);" href="#" border="0" width="150" height="101" alt="Читайте отзывы покупателей и оценивайте качество магазина на Яндекс.Маркете"><span class="border-override"></span></span></a>
        </div>
    </div>
</div>
<table class="vitrina">
    <tbody><tr>
        <td>
            <div class="bc-actions" id="comp_b47178655263a4669d884b42376fa555">
                <a class="preview" href="/stock/818805/"><img class="preview_picture" src="/upload/iblock/ac8/ac84f42b6ee37508b04ee07dc2d9fcd0.jpg" style="width:191px; height:171px;" alt="При покупке люстры - скидка 50% на набор полотенец." title="При покупке люстры - скидка 50% на набор полотенец."></a>
                <a class="akcia_title" href="/stock/">Текущие акции</a>
                <a class="at" href="/stock/818805/">При покупке люстры - скидка 50% на набор полотенец.</a>
                Делать покупки в нашем интернет-магазине не только удобно, но и выгодно. Купив люстру стоимостью более 5000 рублей, вы можете приобрести набор полотенец со скидкой 50%.

            </div>			</td>
        <td style="padding:0;">
{if isset($left)}{$left}{/if}
            <div class="week_item">
                <img src="/images/tovar_ned.png" class="tovar_nedeli">
                <a class="itemimg" title="Подвесная люстра Cherry Blossom NT9953-08" href="/catalog/WD_NT9953-08.html" style="cursor:pointer;">
                    <img id="prodPic725583" class="picItem" alt="Подвесная люстра Cherry Blossom NT9953-08" src="http://photo.mebelion.ru/images/47a8d4b646d2bae831daa4885fed0683.jpg">
                </a>

                <div class="hidden">
                    <a class="titleItem" href="/catalog/WD_NT9953-08.html">"Подвесная люстра Cherry Blossom NT9953-08"</a>
                    <p class="itemmanuf"><a href="/brand/wunderlicht/">Wunderlicht</a></p>
                    <p class="detail_price">17 700 руб.</p>
                    <a data-good_id="725583" good_count="1" onclick="add2Cart('725583'); return false;" href="/catalog/WD_NT9953-08.html?action=ADD2BASKET&amp;id=725583&amp;ELEMENT_ID=725583" class="button-v2">Купить</a>
                </div>
            </div>
        </td>
    </tr>
    <tr>
        <td>
            <a class="rss" href="/rss/">Rss подписка на последние новинки</a>

            <h2>Мы в социальных сетях</h2>
            <p>Вы можете общаться с нами в социальных сетях или опубликовать ссылку на наш интернет-магазин, кликнув на иконки, расположенные ниже.
                Приглашаем вас посетить <a href="http://vk.com/club41889242">официальную группу интернет-магазина Mebelion вконтакте</a>. <br>
                Присоединяйтесь к нам! Будем рады видеть вас!</p>
            <!--noindex-->
            <div style="display: none;"><img src="" alt=""></div>
            <div id="asd_share_buttons" class="bc-social">
                <a id="asd_vk_share" href="#" title="Расшарить ВКонтакт" onclick="window.open('http://vkontakte.ru/share.php?url=http%3A%2F%2Fwww.mebelion.ru%2F&amp;title=%D0%93%D0%BB%D0%B0%D0%B2%D0%BD%D0%B0%D1%8F+%D1%81%D1%82%D1%80%D0%B0%D0%BD%D0%B8%D1%86%D0%B0&amp;image=&amp;description=', '', 'scrollbars=yes,resizable=no,width=560,height=350,top='+Math.floor((screen.height - 350)/2-14)+',left='+Math.floor((screen.width - 560)/2-5)); return false;">
                    <!--<img src="/bitrix/templates/main/components/bitrix/asd.share.buttons/share/images/vkontakte.png" alt="ВКонтакт" />-->
                    <span class="i-vk-icon">&nbsp;</span>
                </a>
                <!--<a id="asd_fb_share" href="#" title="Расшарить в Facebook" onclick="window.open('http://www.facebook.com/sharer.php?u=http%3A%2F%2Fwww.mebelion.ru%2F', '', 'scrollbars=yes,resizable=no,width=560,height=350,top='+Math.floor((screen.height - 350)/2-14)+',left='+Math.floor((screen.width - 560)/2-5)); return false;"><img src="/bitrix/templates/main/components/bitrix/asd.share.buttons/share/images/facebook.png" alt="Facebook" border="0" vspace="3" hspace="3" /></a>-->
                <a id="asd_od_share" href="#" title="Расшарить в Одноклассники" onclick="window.open('http://www.odnoklassniki.ru/dk?st.cmd=addShare&amp;st._surl=http%3A%2F%2Fwww.mebelion.ru%2F%3F', '', 'scrollbars=yes,resizable=no,width=620,height=450,top='+Math.floor((screen.height - 450)/2-14)+',left='+Math.floor((screen.width - 620)/2-5)); return false;">
                    <!--<img src="/bitrix/templates/main/components/bitrix/asd.share.buttons/share/images/odnoklassniki.png" alt="Одноклассники" />-->
                    <span class="i-od-icon">&nbsp;</span>
                </a>
                <!--<a id="asd_bz_share" href="#" title="Расшарить в Buzz" onclick="window.open('http://www.google.com/buzz/post?url=http%3A%2F%2Fwww.mebelion.ru%2F&amp;title=%D0%93%D0%BB%D0%B0%D0%B2%D0%BD%D0%B0%D1%8F+%D1%81%D1%82%D1%80%D0%B0%D0%BD%D0%B8%D1%86%D0%B0&amp;imageurl=', '', 'scrollbars=yes,resizable=no,width=700,height=420,top='+Math.floor((screen.height - 420)/2-14)+',left='+Math.floor((screen.width - 700)/2-5)); return false;"><img src="/bitrix/templates/main/components/bitrix/asd.share.buttons/share/images/buzz.png" alt="" /></a>-->
                <a id="asd_tw_share" href="#" title="Расшарить в Twitter" onclick="window.open('http://twitter.com/share?text=%D0%93%D0%BB%D0%B0%D0%B2%D0%BD%D0%B0%D1%8F+%D1%81%D1%82%D1%80%D0%B0%D0%BD%D0%B8%D1%86%D0%B0&amp;url=http%3A%2F%2Fwww.mebelion.ru%2F', '', 'scrollbars=yes,resizable=no,width=560,height=350,top='+Math.floor((screen.height - 350)/2-14)+',left='+Math.floor((screen.width - 560)/2-5)); return false;">
                    <!--<img src="/bitrix/templates/main/components/bitrix/asd.share.buttons/share/images/twitter.png" alt="Twitter" />-->
                    <span class="i-tw-icon">&nbsp;</span>
                </a>
                <a id="asd_ya_share" href="#" title="Расшарить в Яндекс" onclick="window.open('http://wow.ya.ru/posts_share_link.xml?title=%D0%93%D0%BB%D0%B0%D0%B2%D0%BD%D0%B0%D1%8F+%D1%81%D1%82%D1%80%D0%B0%D0%BD%D0%B8%D1%86%D0%B0&amp;url=http%3A%2F%2Fwww.mebelion.ru%2F', '', 'scrollbars=yes,resizable=no,width=560,height=450,top='+Math.floor((screen.height - 450)/2-14)+',left='+Math.floor((screen.width - 560)/2-5)); return false;">
                    <!--<img src="/bitrix/templates/main/components/bitrix/asd.share.buttons/share/images/yandex.png" alt="Яндекс" />-->
                    <span class="i-ya-icon">&nbsp;</span>
                </a>
                <!--<a id="asd_lj_share" rel="nofollow" href="http://www.livejournal.com/update.bml?subject=%D0%93%D0%BB%D0%B0%D0%B2%D0%BD%D0%B0%D1%8F+%D1%81%D1%82%D1%80%D0%B0%D0%BD%D0%B8%D1%86%D0%B0&amp;event=%3Ca+href%3D%22http%3A%2F%2Fwww.mebelion.ru%2F%22+target%3D%22_blank%22%3E%D0%93%D0%BB%D0%B0%D0%B2%D0%BD%D0%B0%D1%8F+%D1%81%D1%82%D1%80%D0%B0%D0%BD%D0%B8%D1%86%D0%B0%3C%2Fa%3E%3Cbr%2F%3E%3Cbr%2F%3E" target="_blank" title="Расшарить в Livejournal"><img src="/bitrix/templates/main/components/bitrix/asd.share.buttons/share/images/livejournal.png" alt="Livejournal" border="0" vspace="3" hspace="3" /></a>
                <a id="asd_li_share" rel="nofollow" href="http://www.liveinternet.ru/journal_post.php?action=l_add&amp;cnurl=http%3A%2F%2Fwww.mebelion.ru%2F" target="_blank" title="Расшарить в Liveinternet"><img src="/bitrix/templates/main/components/bitrix/asd.share.buttons/share/images/liveinternet.png" alt="Liveinternet" border="0" vspace="3" hspace="3" /></a>-->
                <a id="asd_ma_share" rel="nofollow" href="#" title="Расшарить в Mail.Ru" onclick="window.open('http://connect.mail.ru/share?share_url=http%3A%2F%2Fwww.mebelion.ru%2F', '', 'scrollbars=yes,resizable=no,width=560,height=350,top='+Math.floor((screen.height - 350)/2-14)+',left='+Math.floor((screen.width - 560)/2-5)); return false;">
                    <!--<img src="/bitrix/templates/main/components/bitrix/asd.share.buttons/share/images/mailru.png" alt="Mail.Ru" />-->
                    <span class="i-ma-icon">&nbsp;</span>
                </a>
            </div>
            <!--/noindex-->			</td>
        <td class="brands">
            <h2>Популярные бренды</h2>
            <table><tbody><tr><td><a href="/brand/eglo/">Eglo</a><span>941</span></td><td><a href="/brand/globo/">Globo</a><span>1313</span></td></tr><tr><td><a href="/brand/odeon_light/">Odeon Light</a><span>1444</span></td><td><a href="/brand/wunderlicht/">Wunderlicht</a><span>403</span></td></tr><tr><td><a href="/brand/citilux/">Citilux</a><span>704</span></td><td><a href="/brand/sonex/">Sonex</a><span>331</span></td></tr><tr><td><a href="/brand/lightstar/">Lightstar</a><span>668</span></td><td><a href="/brand/arte/">Arte</a><span>768</span></td></tr><tr><td><a href="/brand/NatureS/">NatureS</a><span>157</span></td><td><a href="/brand/novotech/">Novotech</a><span>584</span></td></tr><tr><td><a href="/brand/preciosa/">Preciosa</a><span>247</span></td><td><a href="/brand/Primavelle/">Primavelle</a><span>443</span></td></tr><tr><td><a href="/brand/tac/">TAC</a><span>506</span></td><td><a href="/brand/lussole/">Lussole</a><span>809</span></td></tr></tbody></table>			</td>
    </tr>
    <tr>
        <td class="oblako">

            <div id="tag_cloud">
                <a href="http://www.mebelion.ru/tovari_dlya_doma/svet/spoty/potolochnye/" class="cloud14">Cпоты потолочные</a>
                <a href="http://www.mebelion.ru/tovari_dlya_doma/svet/bra/" class="cloud16">Бра</a>
                <a href="http://www.mebelion.ru/tovari_dlya_doma/mebel/gostinye/stenki/gorki/" class="cloud18">Гостиные стенки-горки</a>
                <a href="http://www.mebelion.ru/tovari_dlya_doma/tekstil/postelnoe-belyo/detskoe/" class="cloud15">Детское постельное белье</a>
                <a href="http://www.mebelion.ru/tovari_dlya_doma/mebel/zhurnalnye-stoliki/" class="cloud15">Журнальные столы</a>
                <a href="http://www.mebelion.ru/tovari_dlya_doma/svet/lyustry/Italia/" class="cloud15">Итальянские люстры</a>
                <a href="http://www.mebelion.ru/tovari_dlya_doma/tekstil/postelnoe-belyo/komplekti/" class="cloud18">Комплекты постельного белья</a>
                <a href="http://www.mebelion.ru/tovari_dlya_doma/svet/svetilniki/krasnye/" class="cloud10">Красные светильники</a>
                <a href="http://www.mebelion.ru/tovari_dlya_doma/kukhni/classika/" class="cloud12">Кухни в классическом стиле</a>
                <a href="http://www.mebelion.ru/tovari_dlya_doma/kukhni/sovremennye/" class="cloud11">Кухни в современном стиле</a>
                <a href="http://www.mebelion.ru/tovari_dlya_doma/svet/lyustry/" class="cloud20">Люстры</a>
                <a href="http://www.mebelion.ru/tovari_dlya_doma/svet/lyustry/dlia-kukhni/" class="cloud18">Люстры для кухни</a>
                <a href="http://www.mebelion.ru/tovari_dlya_doma/svet/lyustry/s-pultom/" class="cloud18">Люстры с пультом управления</a>
                <a href="http://www.mebelion.ru/tovari_dlya_doma/mebel/gostinye/" class="cloud14">Мебель для гостиной</a>
                <a href="http://www.mebelion.ru/tovari_dlya_doma/posuda/nabory/kastriuli/" class="cloud10">Наборы кастрюль</a>
                <a href="http://www.mebelion.ru/tovari_dlya_doma/posuda/kuhonnye-prinadlezhnosti/" class="cloud9">Наборы кухонных принадлежностей</a>
                <a href="http://www.mebelion.ru/tovari_dlya_doma/tekstil/postelnoe-belyo/nabori/" class="cloud17">Наборы постельного белья</a>
                <a href="http://www.mebelion.ru/tovari_dlya_doma/svet/nastolnye-lampy/" class="cloud17">Настольные лампы</a>
                <a href="http://www.mebelion.ru/tovari_dlya_doma/svet/nastolnye-ofisnye-lampy/" class="cloud14">Настольные офисные лампы</a>
                <a href="http://www.mebelion.ru/tovari_dlya_doma/svet/nastolnye-svetilniki/" class="cloud13">Настольные светильники</a>
                <a href="http://www.mebelion.ru/tovari_dlya_doma/tekstil/postelnoe-belyo/" class="cloud19">Постельное белье</a>
                <a href="http://www.mebelion.ru/tovari_dlya_doma/svet/potolochnye-svetilniki/" class="cloud16">Потолочные светильники</a>
                <a href="http://www.mebelion.ru/tovari_dlya_doma/svet/svetilniki/" class="cloud20">Светильники</a>
                <a href="http://www.mebelion.ru/tovari_dlya_doma/svet/svetilniki/dlia-kukhni/" class="cloud13">Светильники для кухни</a>
                <a href="http://www.mebelion.ru/tovari_dlya_doma/mebel/gostinye/stenki/" class="cloud17">Стенки в гостиную</a>
                <a href="http://www.mebelion.ru/tovari_dlya_doma/svet/torshery/" class="cloud17">Торшеры</a>
                <a href="http://www.mebelion.ru/tovari_dlya_doma/svet/ulichnye-fonari/" class="cloud16">Уличные фонари</a>
                <a href="http://www.mebelion.ru/tovari_dlya_doma/svet/lyustry/khrustalnye/" class="cloud18">Хрустальные люстры</a>
                <a href="http://www.mebelion.ru/catalog/RS_RL_1505AX_B.html" class="cloud14">подвесная люстра ретро рл 1505ах/б</a>

            </div>			</td>
    </tr>
    </tbody></table>
</div>

<div style="float:left;">
</div>
<div class="clear"></div>
</div>

<svg height="0">
    <filter id="blur-1"><feGaussianBlur stdDeviation="1"></feGaussianBlur></filter>
    <filter id="blur-2"><feGaussianBlur stdDeviation="2"></feGaussianBlur></filter>
    <filter id="blur-3"><feGaussianBlur stdDeviation="3"></feGaussianBlur></filter>
    <filter id="blur-4"><feGaussianBlur stdDeviation="4"></feGaussianBlur></filter>
    <filter id="blur-5"><feGaussianBlur stdDeviation="5"></feGaussianBlur></filter>
</svg>
<script>
    window.deliveryCity = [
        'Москва','Санкт-Петербург','Абакан','Анадырь','Анапа','Ангарск','Апатиты','Армавир','Архангельск','Астрахань','Барнаул','Белгород','Березники','Бийск','Биробиджан','Благовещенск','Большой Камень','Братск','Брянск','Бугульма','Великий Новгород','Владивосток','Владикавказ','Владимир','Волгоград','Волгодонск','Вологда','Воронеж','Горно-Алтайск','Димитровград','Екатеринбург','Забайкальск','Златоуст','Иваново','Ижевск','Иркутск','Йошкар-Ола','Казань','Калининград','Калуга','Каменск-Уральский','Кемерово','Киров','Кисловодск','Комсомольск-на Амуре','Комсомольск-на-Амуре','Кострома','Красногорск','Краснодар','Красноярск','Курган','Курск','Кызыл','Липецк','Магадан','Магнитогорск','Махачкала','Миасс','Мурманск','Набережные Челны','Надым','Нальчик','Находка','Нефтекамск','Нижневартовск','Нижнекамск','Нижний Новгород','Нижний Тагил','Новокузнецк','Новороссийск','Новосибирск','Новочебоксарск','Новочеркасск','Новый Уренгой','Норильск','Ноябрьск','Омск','Орел','Оренбург','Орск','Орёл','Пенза','Пермь','Петрозаводск','Петропавловск-Камчатский','Псков','Пятигорск','Ростов-на-Дону','Рязань','Салехард','Самара','Саранск','Саратов','Саров','Серов','Смоленск','Сочи','Ставрополь','Старый Оскол','Стерлитамак','Сургут','Сызрань','Сыктывкар','Таганрог','Тамбов','Тверь','Тольятти','Томск','Тула','Тюмень','Улан-Удэ','Ульяновск','Уссурийск','Уфа','Ухта','Хабаровск','Ханты-Мансийск','Чебоксары','Челябинск','Череповец','Черкесск','Чита','Элиста','Южно-Сахалинск','Якутск','Ярославль','Дмитров','Долгопрудный','Домодедово','Дубна','Ивантеевка','Клин','Котельники','Красково','Лобня','Лыткарино','Люберцы','Малаховка','Ногинск','Обнинск','Октябрьский','Орехово-Зуево','Сергиев Посад','Томилино','Химки','Хотьково','Электросталь'
    ];
</script>
<noindex>
<!-- окно обивок (выбора тканей) -->
<!-- <span class="d-popup-open j-open-textyle-popup" data-dpopup="textyle-selector"></span> -->
<div class="b-d-popup-item textyle-selector-popup" data-dpopup="textyle-selector">
    <div class="tsp-item"></div>
</div>
<!-- /окно обивок (выбора тканей) -->



<div style="display: none;" id="gentime">0.103017091751</div>
<div style="display: none;" id="userip">82.179.218.138</div>

<div class="b-d-popup-override"></div>


<!-- заявка на кухню основная -->
<div class="b-d-popup-item b-order-kitchen" data-dpopup="order-kitchen" data-text="kitchen Основная заявка на кухню">
    <div class="b-useful-popup-head">Оформить заявку </div>
    <div class="b-order-kitchen-content">
        <div class="b-order-kitchen-description">
            <p>Если вы хотите рассчитать стоимость кухни, уточнить детали оформления заказа или получить профессиональную консультацию, оставьте заявку.</p>
            <p><span class="c-black">Наш менеджер в кратчайшие сроки свяжется с вами и ответит на все ваши вопросы!</span></p>
        </div>
        <form class="b-order-kitchen-form">
            <div class="bok-form">
                <div class="b-field">
                    <span class="label">Ваше имя:</span>
                    <input type="text" name="name">
                </div>
                <div class="b-field">
                    <span class="label">Номер телефона:</span>
                    <input type="text" class="phone-number-mask" name="phone">
                </div>
                <div class="b-field">
                    <span class="label">Электронная почта:</span>
                    <input type="text" name="email" class="email-field">
                </div>
                <div class="b-field">
                    <input type="submit" class="button-v2 order-kitchen-submit" value="Отправить заявку">
                </div>
            </div>
            <div class="bok-success">
                <div class="bok-success-head">Спасибо! Ваша заявка успешно отправлена.</div>
                <div class="boks-message">Мы обязательно свяжемся с вами в кратчайшие сроки.</div>
                <span class="pseudo-link b-d-popup-close">Продолжить покупки</span>
            </div>
        </form>
    </div>
</div>
<!-- /заявка на кухню основная -->

<!-- заявка на кухню (мы можем сделать любую кухню) -->
<div class="b-d-popup-item b-order-kitchen" data-dpopup="order-kitchen-banner" data-text="kitchen Заявка на кухню с баннера">
    <div class="b-order-kitchen-head">Хотите купить кухню?</div>
    <div class="b-order-kitchen-content">
        <div class="bok-banner"><img src="/images/card/mogem.png" alt=""></div>
        <div class="b-order-kitchen-description">
            <p>У вас есть свои идеи и пожелания к дизайну кухонной мебели? Мы готовы делать кухню, которая вам необходима, вне зависимости от сложности проекта. Мы учтем все ваши пожелания, не упустим ни одной детали и сделаем все возможное, чтобы кухня стала именно такой, какой вы ее себе представляете. </p>
            <p>Узнать подробности или задать интересующие вас вопросы вы можете, позвонив по телефону: <span class="c-black">8 800 777-75-75</span> (бесплатно из всех городов России) или <span class="c-black">8 495 783-29-50.</span></p>
            <p><span class="c-black">Оставьте заявку на изготовление кухни, и наш менеджер в кратчайшие сроки свяжется с вами для уточнения деталей заказа.</span></p>
        </div>
        <form class="b-order-kitchen-form">
            <div class="bok-form">
                <div class="b-field">
                    <span class="label">Ваше имя:</span>
                    <input type="text" name="name">
                </div>
                <div class="b-field">
                    <span class="label">Номер телефона:</span>
                    <input type="text" class="phone-number-mask" name="phone">
                </div>
                <div class="b-field">
                    <span class="label">Электронная почта:</span>
                    <input type="text" name="email" class="email-field">
                </div>
                <div class="b-field">
                    <input type="submit" class="button-v2 order-kitchen-submit" value="Отправить заявку">
                </div>
            </div>
            <div class="bok-success">
                <div class="bok-success-head">Спасибо! Ваша заявка успешно отправлена.</div>
                <div class="boks-message">Мы обязательно свяжемся с вами в кратчайшие сроки.</div>
                <span class="pseudo-link b-d-popup-close">Продолжить покупки</span>
            </div>
        </form>
    </div>
</div>
<!-- /заявка на кухню (мы можем сделать любую кухню) -->

<!-- заявка на кухню (Замер помещения) -->
<div class="b-d-popup-item b-order-kitchen" data-dpopup="order-kitchen-zamer" data-text="kitchen Заявка на кухню. Замер помещения.">
    <div class="b-order-kitchen-head">Замер помещения</div>
    <div class="b-order-kitchen-content">
        <div class="b-order-kitchen-description">
            <p>Для подготовки будущего дизайн-проекта кухонного гарнитура необходимо выполнение точных замеров помещения, в котором будет выполняться монтаж предметов кухонной мебели. Мы рады предложить вам эту услугу абсолютно <span class="c-black">БЕСПЛАТНО.</span></p>
            <p>Дизайнер проведет точный замер помещения, учитывающий все его технические особенности, включая расположение систем коммуникации и другие параметры. Правильно выполненный замер кухни позволит избежать каких-либо трудностей при дальнейшем монтаже кухонной мебели и ее эксплуатации, тем самым обеспечивая желаемый уровень комфорта. </p>
            <p>Кроме того дизайнер окажет профессиональную консультацию, продемонстрирует образцы продукции, каталоги с осуществленными проектами и поможет определиться с деталями вашей будущей кухни.</p>
            <p>В итоге вы получите индивидуальный дизайн-проект кухни с учетом всех пожеланий прямо у вас дома! Вы сразу узнаете стоимость проекта, сможете заключить договор и внести необходимую предоплату. Для заказа услуги вам остается только оформить заявку.
                <br><span class="c-black">Для всех клиентов Mebelion услуга бесплатна.</span></p>
        </div>
        <form class="b-order-kitchen-form">
            <div class="bok-form">
                <div class="b-field">
                    <span class="label">Ваше имя:</span>
                    <input type="text" name="name">
                </div>
                <div class="b-field">
                    <span class="label">Номер телефона:</span>
                    <input type="text" class="phone-number-mask" name="phone">
                </div>
                <div class="b-field">
                    <span class="label">Электронная почта:</span>
                    <input type="text" name="email" class="email-field">
                </div>
                <div class="b-field">
                    <input type="submit" class="button-v2 order-kitchen-submit" value="Отправить заявку">
                </div>
            </div>
            <div class="bok-success">
                <div class="bok-success-head">Спасибо! Ваша заявка успешно отправлена.</div>
                <div class="boks-message">Мы обязательно свяжемся с вами в кратчайшие сроки.</div>
                <span class="pseudo-link b-d-popup-close">Продолжить покупки</span>
            </div>
        </form>
    </div>
</div>
<!-- /заявка на кухню (Замер помещения) -->

<!-- заявка на кухню (Выезд) -->
<div class="b-d-popup-item b-order-kitchen" data-dpopup="order-kitchen-viezd" data-text="kitchen Заявка на кухню. Выезд.">
    <div class="b-order-kitchen-head">Выезд профессионального дизайнера</div>
    <div class="b-order-kitchen-content">
        <div class="b-order-kitchen-description">
            <p>Мы рады предложить услугу по созданию индивидуального проекта кухни прямо у вас дома! Выезд профессионального дизайнера осуществляется <span class="c-black">БЕСПЛАТНО.</span></p>
            <p>Приехав к вам, дизайнер окажет консультацию, продемонстрирует образцы продукции, каталоги с осуществленными проектами и поможет определиться с деталями вашей будущей кухни. После чего сделает все необходимые замеры и разработает индивидуальный дизайн-проект кухни с учетом всех пожеланий прямо при вас!</p>
            <p>Вы сразу узнаете стоимость проекта, сможете заключить договор и внести необходимую предоплату. Для заказа услуги вам остается только оформить заявку.
                <br><span class="c-black">Для всех клиентов Mebelion услуга бесплатна.</span></p>
        </div>
        <form class="b-order-kitchen-form">
            <div class="bok-form">
                <div class="b-field">
                    <span class="label">Ваше имя:</span>
                    <input type="text" name="name">
                </div>
                <div class="b-field">
                    <span class="label">Номер телефона:</span>
                    <input type="text" class="phone-number-mask" name="phone">
                </div>
                <div class="b-field">
                    <span class="label">Электронная почта:</span>
                    <input type="text" name="email" class="email-field">
                </div>
                <div class="b-field">
                    <input type="submit" class="button-v2 order-kitchen-submit" value="Отправить заявку">
                </div>
            </div>
            <div class="bok-success">
                <div class="bok-success-head">Спасибо! Ваша заявка успешно отправлена.</div>
                <div class="boks-message">Мы обязательно свяжемся с вами в кратчайшие сроки.</div>
                <span class="pseudo-link b-d-popup-close">Продолжить покупки</span>
            </div>
        </form>
    </div>
</div>
<!-- /заявка на кухню (Выезд) -->

<!-- заявка на кухню (Демонстрация образцов и каталогов) -->
<div class="b-d-popup-item b-order-kitchen" data-dpopup="order-kitchen-demonstration" data-text="kitchen Заявка на кухню. Демонстрация образцов и каталогов.">
    <div class="b-order-kitchen-head">Демонстрация образцов и каталогов</div>
    <div class="b-order-kitchen-content">
        <div class="b-order-kitchen-description">
            <p>Для демонстрации образцов наш специалист приедет к вам домой в удобное для вас время. Выезд профессионального дизайнера осуществляется <span class="c-black">БЕСПЛАТНО.</span></p>
            <p>Приехав к вам, дизайнер окажет консультацию, продемонстрирует образцы фасадов, каталоги с осуществленными проектами и поможет определиться с деталями вашей будущей кухни. Среди большого количества вариантов вы обязательно подберете кухню, которая будет отвечать всем вашим требованиям, предъявляемым как к ее внешнему виду, так и к функционалу. </p>
            <p>Дизайнер также осуществит все необходимые замеры и разработает индивидуальный дизайн-проект кухни с учетом всех пожеланий прямо при вас! Вы сразу узнаете стоимость проекта, сможете заключить договор и внести необходимую предоплату. Для заказа услуги вам остается только оформить заявку.<br><span class="c-black">Для всех клиентов Mebelion услуга бесплатна.</span></p>
        </div>
        <form class="b-order-kitchen-form">
            <div class="bok-form">
                <div class="b-field">
                    <span class="label">Ваше имя:</span>
                    <input type="text" name="name">
                </div>
                <div class="b-field">
                    <span class="label">Номер телефона:</span>
                    <input type="text" class="phone-number-mask" name="phone">
                </div>
                <div class="b-field">
                    <span class="label">Электронная почта:</span>
                    <input type="text" name="email" class="email-field">
                </div>
                <div class="b-field">
                    <input type="submit" class="button-v2 order-kitchen-submit" value="Отправить заявку">
                </div>
            </div>
            <div class="bok-success">
                <div class="bok-success-head">Спасибо! Ваша заявка успешно отправлена.</div>
                <div class="boks-message">Мы обязательно свяжемся с вами в кратчайшие сроки.</div>
                <span class="pseudo-link b-d-popup-close">Продолжить покупки</span>
            </div>
        </form>
    </div>
</div>
<!-- /заявка на кухню (Демонстрация образцов и каталогов) -->

<!-- заявка на кухню (Дизайн-проект вашей кухни) -->
<div class="b-d-popup-item b-order-kitchen" data-dpopup="order-kitchen-development" data-text="kitchen Заявка на кухню. Дизайн-проект вашей кухни.">
    <div class="b-order-kitchen-head">Дизайн-проект вашей кухни</div>
    <div class="b-order-kitchen-content">
        <div class="b-order-kitchen-description">
            <p>Мы рады предложить вам услугу по разработке индивидуального дизайн-проекта кухни прямо у вас дома! Выезд профессионального дизайнера осуществляется <span class="c-black">БЕСПЛАТНО.</span></p>
            <p>Приехав к вам, дизайнер окажет консультацию, продемонстрирует образцы продукции и каталоги с осуществленными проектами, а также поможет определиться с деталями вашей будущей кухни. </p>
            <p>Вам будут предоставлены различные варианты конфигурации гарнитура. Кроме того, можно будет поэкспериментировать с цветовой гаммой кухни. Дизайнер поможет вам подобрать оптимальное решение по наполнению кухонного гарнитура, произведет необходимые замеры и рассчитает стоимость проекта прямо при вас!</p>
            <p>Вы сразу узнаете стоимость проекта, сможете заключить договор и внести необходимую предоплату. Для заказа услуги вам остается только оформить заявку.<br><span class="c-black">Для всех клиентов Mebelion услуга бесплатна.</span></p>
        </div>
        <form class="b-order-kitchen-form">
            <div class="bok-form">
                <div class="b-field">
                    <span class="label">Ваше имя:</span>
                    <input type="text" name="name">
                </div>
                <div class="b-field">
                    <span class="label">Номер телефона:</span>
                    <input type="text" class="phone-number-mask" name="phone">
                </div>
                <div class="b-field">
                    <span class="label">Электронная почта:</span>
                    <input type="text" name="email" class="email-field">
                </div>
                <div class="b-field">
                    <input type="submit" class="button-v2 order-kitchen-submit" value="Отправить заявку">
                </div>
            </div>
            <div class="bok-success">
                <div class="bok-success-head">Спасибо! Ваша заявка успешно отправлена.</div>
                <div class="boks-message">Мы обязательно свяжемся с вами в кратчайшие сроки.</div>
                <span class="pseudo-link b-d-popup-close">Продолжить покупки</span>
            </div>
        </form>
    </div>
</div>
<!-- /заявка на кухню (Дизайн-проект вашей кухни) -->

<!-- окно быстрого просмотра товара -->

<!-- /окно быстрого просмотра товара -->

<!-- окно добавления в корзину -->
<span class="d-popup-open open-buy-success-popup" data-dpopup="buy-success-popup"></span>

<!-- /окно добавления в корзину -->


<!-- галерея фотографий -->
<span class="d-popup-open photoGalleryPopup-open" data-dpopup="photo-gallery"></span>

<!-- /галерея фотографий -->

<!--
<div class="b-d-popup-item moscow-map" data-dpopup="map1">
    <h2>Москва и Московская область</h2>
    <img src="/images/delivery-map-moskov.jpg" alt="" />
</div>
-->

<!-- заявка на кухню (мы можем сделать любую кухню) -->
<div class="b-d-popup-item b-order-kitchen" data-dpopup="order-kitchen-vitrina" data-text="kitchen Заявка на кухню из списка товаров">
    <div class="b-order-kitchen-head">Хотите купить кухню?</div>
    <div class="b-order-kitchen-content">
        <div class="bok-banner"><img src="/images/card/mogem.png" alt=""></div>
        <div class="b-order-kitchen-description">
            <p>У вас есть свои идеи и пожелания к дизайну кухонной мебели? Мы готовы делать кухню, которая вам необходима, вне зависимости от сложности проекта. Мы учтем все ваши пожелания, не упустим ни одной детали и сделаем все возможное, чтобы кухня стала именно такой, какой вы ее себе представляете. </p>
            <p>Узнать подробности или задать интересующие вас вопросы вы можете, позвонив по телефону: <span class="c-black">8 800 777-75-75</span> (бесплатно из всех городов России) или <span class="c-black">8 495 783-29-50.</span></p>
            <p><span class="c-black">Оставьте заявку на изготовление кухни, и наш менеджер в кратчайшие сроки свяжется с вами для уточнения деталей заказа.</span></p>
        </div>
        <form class="b-order-kitchen-form">
            <div class="bok-form">
                <div class="b-field">
                    <span class="label">Ваше имя:</span>
                    <input type="text" name="name">
                </div>
                <div class="b-field">
                    <span class="label">Номер телефона:</span>
                    <input type="text" class="phone-number-mask" name="phone">
                </div>
                <div class="b-field">
                    <span class="label">Электронная почта:</span>
                    <input type="text" name="email" class="email-field">
                </div>
                <div class="b-field">
                    <input type="submit" class="button-v2 order-kitchen-submit" value="Отправить заявку">
                </div>
            </div>
            <div class="bok-success">
                <div class="bok-success-head">Спасибо! Ваша заявка успешно отправлена.</div>
                <div class="boks-message">Мы обязательно свяжемся с вами в кратчайшие сроки.</div>
                <span class="pseudo-link b-d-popup-close">Продолжить покупки</span>
            </div>
        </form>
    </div>
</div>
<!-- /заявка на кухню (мы можем сделать любую кухню) -->





</noindex>
<footer class="l-footer">
    <div class="logo">
        <a href="/" style="font-size:28px;"><span style="color:#727272; font-size:28px;">tabernacms</span>.com</a>
        © Таберна, tabernacms.com    </div>
    <nav>



        <a href="{url href="alias=page&pgid=4"}" class="footer_link ">О компании</a>

        <a href="{url href="alias=page&pgid=1"}" class="footer_link ">Доставка и оплата</a>


        <a href="{url href="#"}" class="footer_link ">Гарантия</a>

        <a href="{url href="#"}" class="footer_link ">Помощь</a>

        <a href="{url href="#"}" class="footer_link ">Дисконтная карта</a>

        <a href="{url href="#"}" class="footer_link ">Оптовым клиентам</a>

        <a href="{url href="#"}" class="footer_link ">Контактная информация</a>

        <a href="{url href="#"}" class="footer_link ">Карта сайта</a>

        <a href="{url href="#"}" class="footer_link ">Условия продажи</a>


    </nav>

    <div id="adlabs_id"><div id="psevdo_button">Ваш номер: <span class="adlabs_uid_ss">441853</span> </div></div>

</footer>

</div>


<script type="text/javascript">
    {literal}
    window.configurator_catalog = {"322":{"_\u0431\u0435\u043b\u044b\u0439_50 x 68 \u0441\u043c":{"PROPERTIES":{"VO_MANUF":{"VALUES":["417213"],"PROPNAME":"\u041f\u0440\u043e\u0438\u0437\u0432\u043e\u0434\u0438\u0442\u0435\u043b\u044c"},"photo_small":{"VALUES":["http:\/\/photo.mebelion.ru\/images\/ace3d3b8feff92146c8551728fcbf846.jpg"],"PROPNAME":"\u041c\u0430\u043b\u0435\u043d\u044c\u043a\u043e\u0435 \u0444\u043e\u0442\u043e"},"photo_big":{"VALUES":["http:\/\/photo.mebelion.ru\/images\/7f4bc5b6415978d5a7473c0976931831.jpg"],"PROPNAME":"\u0411\u043e\u043b\u044c\u0448\u043e\u0435 \u0444\u043e\u0442\u043e "},"photo_med":{"VALUES":["http:\/\/photo.mebelion.ru\/images\/5e78151ffcc2bfc3ed7b114082d82865.jpg"],"PROPNAME":"\u0421\u0440\u0435\u0434\u043d\u0435\u0435 \u0444\u043e\u0442\u043e"},"search_article":{"VALUES":["NS_KO-P-13-2"],"PROPNAME":"\u0410\u0440\u0442\u0438\u043a\u0443\u043b"},"height":{"VALUES":["0"],"PROPNAME":"\u0412\u044b\u0441\u043e\u0442\u0430, \u043c\u043c"},"group_color":{"VALUES":["\u0431\u0435\u043b\u044b\u0439","\u043e\u0434\u043d\u043e\u0442\u043e\u043d\u043d\u044b\u0439"],"PROPNAME":"\u0413\u0440\u0443\u043f\u043f\u0430 \u0446\u0432\u0435\u0442\u0430"},"length":{"VALUES":["680"],"PROPNAME":"\u0414\u043b\u0438\u043d\u0430, \u043c\u043c"},"additional_parameters":{"VALUES":["\u041f\u043e\u0441\u0442\u0435\u043b\u044c\u043d\u044b\u0435 \u043f\u0440\u0438\u043d\u0430\u0434\u043b\u0435\u0436\u043d\u043e\u0441\u0442\u0438 \u0441 \u0441\u0438\u043d\u0442\u0435\u0442\u0438\u0447\u0435\u0441\u043a\u0438\u043c \u043f\u0443\u0445\u043e\u043c \u0434\u043b\u044f \u0442\u0435\u0445","\u0443 \u043a\u043e\u0433\u043e \u0441\u0443\u0449\u0435\u0441\u0442\u0432\u0443\u0435\u0442 \u0438\u043d\u0434\u0438\u0432\u0438\u0434\u0443\u0430\u043b\u044c\u043d\u0430\u044f \u043d\u0435\u043f\u0435\u0440\u0435\u043d\u043e\u0441\u0438\u043c\u043e\u0441\u0442\u044c \u043d\u0430\u0442\u0443\u0440\u0430\u043b\u044c\u043d\u044b\u0445 \u043d\u0430\u043f\u043e\u043b\u043d\u0438\u0442\u0435\u043b\u0435\u0439. \u0421\u0438\u043d\u0442\u0435\u0442\u0438\u0447\u0435\u0441\u043a\u0438\u0439 \u043f\u0443\u0445 \u043f\u0440\u0435\u0434\u0441\u0442\u0430\u0432\u043b\u044f\u0435\u0442 \u0441\u043e\u0431\u043e\u0439 \u043a\u043e\u043c\u0431\u0438\u043d\u0430\u0446\u0438\u044e \u0438\u0437 \u0443\u043b\u044c\u0442\u0440\u0430\u0442\u043e\u043d\u043a\u0438\u0445 \u0432\u043e\u043b\u043e\u043a\u043e\u043d. \u041e\u043d \u0434\u0430\u0440\u0438\u0442 \u043f\u043e\u0441\u0442\u0435\u043b\u044c\u043d\u044b\u043c \u043f\u0440\u0438\u043d\u0430\u0434\u043b\u0435\u0436\u043d\u043e\u0441\u0442\u044f\u043c \u043d\u0435\u043e\u0431\u044b\u043a\u043d\u043e\u0432\u0435\u043d\u043d\u0443\u044e \u043c\u044f\u0433\u043a\u043e\u0441\u0442\u044c \u0438 \u043b\u0435\u0433\u043a\u043e\u0441\u0442\u044c","\u0430 \u044d\u0444\u0444\u0435\u043a\u0442 \u00ab\u0443\u0442\u043e\u043f\u0430\u043d\u0438\u044f\u00bb \u0441\u0434\u0435\u043b\u0430\u0435\u0442 \u0438\u0445 \u0442\u0430\u043a\u0438\u043c\u0438 \u0436\u0435\u043b\u0430\u043d\u043d\u044b\u043c\u0438 \u0434\u043b\u044f \u043a\u0430\u0436\u0434\u043e\u0434\u043d\u0435\u0432\u043d\u043e\u0433\u043e \u043e\u0442\u0434\u044b\u0445\u0430. \u041e\u0434\u043d\u0438\u043c \u0438\u0437 \u0434\u043e\u0441\u0442\u043e\u0438\u043d\u0441\u0442\u0432 \u0434\u0430\u043d\u043d\u043e\u0439 \u043a\u043e\u043b\u043b\u0435\u043a\u0446\u0438\u0438 \u044f\u0432\u043b\u044f\u0435\u0442\u0441\u044f \u0442\u043e","\u0447\u0442\u043e \u0435\u0435 \u043c\u043e\u0436\u043d\u043e \u043c\u043d\u043e\u0433\u043e\u043a\u0440\u0430\u0442\u043d\u043e \u0441\u0442\u0438\u0440\u0430\u0442\u044c \u0431\u0435\u0437 \u0432\u0440\u0435\u0434\u0430 \u0434\u043b\u044f \u043a\u0430\u0447\u0435\u0441\u0442\u0432\u0430 \u0438\u0437\u0434\u0435\u043b\u0438\u044f. \u041d\u043e\u0432\u0438\u043d\u043a\u0430 - \u043f\u043e\u0434\u0443\u0448\u043a\u0430 \u0438\u0437 \u043f\u043b\u043e\u0442\u043d\u043e\u0433\u043e \u043f\u0443\u0445\u043e\u043d\u0435\u043f\u0440\u043e\u043d\u0438\u0446\u0430\u0435\u043c\u043e\u0433\u043e \u0445\u043b\u043e\u043f\u043a\u0430 \u0441 \u043a\u0430\u043d\u0442\u043e\u043c \u0438\u0437 \u043a\u0440\u0443\u0436\u0435\u0432\u0430. \u0422\u0430\u043a\u043e\u0439 \u0447\u0435\u0445\u043e\u043b \u043d\u0435 \u043f\u043e\u0437\u0432\u043e\u043b\u0438\u0442 \u0434\u043e\u043c\u0430\u0448\u043d\u0435\u0439 \u043f\u044b\u043b\u0438 \u043d\u0430\u043a\u0430\u043f\u043b\u0438\u0432\u0430\u0442\u044c\u0441\u044f \u0432 \u043f\u043e\u0434\u0443\u0448\u043a\u0430\u0445 \u0438 \u0431\u0443\u0434\u0435\u0442 \u043d\u0435\u043f\u0440\u0435\u043e\u0434\u043e\u043b\u0438\u043c\u044b\u043c \u0431\u0430\u0440\u044c\u0435\u0440\u043e\u043c \u0434\u043b\u044f \u043f\u044b\u043b\u0435\u0432\u044b\u0445 \u043a\u043b\u0435\u0449\u0435\u0439. \u0421\u0442\u0438\u0440\u043a\u0430 \u043f\u0440\u0438 40\u0421."],"PROPNAME":"\u0414\u043e\u043f\u043e\u043b\u043d\u0438\u0442\u0435\u043b\u044c\u043d\u044b\u0435 \u043f\u0430\u0440\u0430\u043c\u0435\u0442\u0440\u044b"},"type":{"VALUES":["\u041f\u043e\u0441\u0442\u0435\u043b\u044c\u043d\u044b\u0435 \u043f\u0440\u0438\u043d\u0430\u0434\u043b\u0435\u0436\u043d\u043e\u0441\u0442\u0438","\u041f\u043e\u0434\u0443\u0448\u043a\u0438"],"PROPNAME":"\u0417\u0430\u043f\u0438\u0441\u044c \u0442\u0438\u043f\u043e\u0432"},"count":{"VALUES":["1"],"PROPNAME":"\u041a\u043e\u043b\u0438\u0447\u0435\u0441\u0442\u0432\u043e \u043f\u0440\u0435\u0434\u043c\u0435\u0442\u043e\u0432"},"material_textile":{"VALUES":["100% \u0445\u043b\u043e\u043f\u043e\u043a"],"PROPNAME":"\u041c\u0430\u0442\u0435\u0440\u0438\u0430\u043b \u0442\u043a\u0430\u043d\u0438"},"filler":{"VALUES":["100% \u0441\u0438\u043b\u0438\u043a\u043e\u043d\u0438\u0437\u0438\u0440\u043e\u0432\u0430\u043d\u043d\u043e\u0435 \u0432\u043e\u043b\u043e\u043a\u043d\u043e"],"PROPNAME":"\u041d\u0430\u043f\u043e\u043b\u043d\u0438\u0442\u0435\u043b\u044c"},"primary_color":{"VALUES":["\u0431\u0435\u043b\u044b\u0439"],"PROPNAME":"\u041e\u0441\u043d\u043e\u0432\u043d\u043e\u0439 \u0446\u0432\u0435\u0442"},"density_weaving":{"VALUES":["\u0432\u044b\u0441\u043e\u043a\u0430\u044f"],"PROPNAME":"\u041f\u043b\u043e\u0442\u043d\u043e\u0441\u0442\u044c \u043f\u043b\u0435\u0442\u0435\u043d\u0438\u044f"},"size":{"VALUES":["50 x 68 \u0441\u043c"],"PROPNAME":"\u0420\u0430\u0437\u043c\u0435\u0440"},"seria":{"VALUES":["\u00ab\u041a\u0440\u0443\u0436\u0435\u0432\u043d\u043e\u0435 \u043e\u0431\u043b\u0430\u043a\u043e\u00bb"],"PROPNAME":"\u0421\u0435\u0440\u0438\u044f"},"sort":{"VALUES":["0"],"PROPNAME":"\u0421\u043e\u0440\u0442\u0438\u0440\u043e\u0432\u043a\u0430"},"decoration":{"VALUES":["\u043a\u0440\u0443\u0436\u0435\u0432\u0430"],"PROPNAME":"\u0422\u0438\u043f \u043e\u0442\u0434\u0435\u043b\u043a\u0438"},"type_textile":{"VALUES":["\u0442\u0438\u043a"],"PROPNAME":"\u0422\u0438\u043f \u0442\u043a\u0430\u043d\u0438"},"package":{"VALUES":["\u0441\u0443\u043c\u043a\u0430 \u0438\u0437 \u041f\u0412\u0425"],"PROPNAME":"\u0423\u043f\u0430\u043a\u043e\u0432\u043a\u0430"},"price":{"VALUES":["1000"],"PROPNAME":"\u0426\u0435\u043d\u0430"},"width":{"VALUES":["500"],"PROPNAME":"\u0428\u0438\u0440\u0438\u043d\u0430, \u043c\u043c"},"uniserial":{"VALUES":["NS_KO-P-13-2","NS_KO-P-15-2","NS_KO-P-3-3","NS_KO-P-5-3","NS_KO-O-3-3","NS_KO-O-5-3","NS_KO-O-7-3","NS_KO-O-3-3-T","NS_KO-O-5-3-T","NS_KO-O-7-3-T"],"PROPNAME":"\u041e\u0434\u043d\u043e\u0441\u0435\u0440\u0438\u0439\u043d\u044b\u0435"},"photo_int_small":{"VALUES":["0"],"PROPNAME":"\u041c\u0430\u043b\u0435\u043d\u044c\u043a\u043e\u0435 \u0444\u043e\u0442\u043e \u0432 \u0438\u043d\u0442\u0435\u0440\u044c\u0435\u0440\u0435"},"manufacturer_country":{"VALUES":["\u0420\u043e\u0441\u0441\u0438\u044f"],"PROPNAME":"\u0421\u0442\u0440\u0430\u043d\u0430 \u043f\u0440\u043e\u0438\u0437\u0432\u043e\u0434\u0438\u0442\u0435\u043b\u044f"},"type0":{"VALUES":["4"],"PROPNAME":"\u0413\u0440\u0443\u043f\u043f\u0430 \u043f\u0440\u043e\u0434\u0443\u043a\u0446\u0438\u0438"},"remains_count":{"VALUES":["0"],"PROPNAME":"\u041e\u0441\u0442\u0430\u0442\u043a\u0438"},"elasticity":{"VALUES":["\u0441\u0440\u0435\u0434\u043d\u044f\u044f"],"PROPNAME":"\u0423\u043f\u0440\u0443\u0433\u043e\u0441\u0442\u044c"},"group_filler":{"VALUES":["\u0441\u0438\u043b\u0438\u043a\u043e\u043d\u0438\u0437\u0438\u0440\u043e\u0432\u0430\u043d\u043d\u043e\u0435 \u0432\u043e\u043b\u043e\u043a\u043d\u043e"],"PROPNAME":"\u0413\u0440\u0443\u043f\u043f\u0430 \u043d\u0430\u043f\u043e\u043b\u043d\u0438\u0442\u0435\u043b\u044f"},"group_color_short":{"VALUES":["\u0431\u0435\u043b\u044b\u0439","\u043e\u0434\u043d\u043e\u0442\u043e\u043d\u043d\u044b\u0439"],"PROPNAME":"\u041a\u0440\u0430\u0442\u043a\u0430\u044f \u0433\u0440\u0443\u043f\u043f\u0430 \u0446\u0432\u0435\u0442\u0430"},"product_configurator_group_id":{"VALUES":["322"],"PROPNAME":"ID \u043a\u043e\u043d\u0444\u0438\u0433\u0443\u0440\u0438\u0440\u0443\u0435\u043c\u043e\u0439 \u0433\u0440\u0443\u043f\u043f\u044b \u043f\u0440\u043e\u0434\u0443\u043a\u0442\u043e\u0432"},"product_configurator_priority":{"VALUES":["0"],"PROPNAME":"\u041f\u0440\u0438\u043e\u0440\u0438\u0442\u0435\u0442 \u043f\u0440\u043e\u0434\u0443\u043a\u0442\u0430 \u0432\u043d\u0443\u0442\u0440\u0438 \u043a\u043e\u043d\u0444\u0438\u0433\u0443\u0440\u0438\u0440\u0443\u0435\u043c\u043e\u0439 \u0433\u0440\u0443\u043f\u043f\u044b"},"photo_int2_big":{"VALUES":["0"],"PROPNAME":"\u0411\u043e\u043b\u044c\u0448\u043e\u0435 \u0444\u043e\u0442\u043e \u0432 \u0438\u043d\u0442\u0435\u0440\u044c\u0435\u0440\u0435 2"},"complect_json":{"VALUES":["[]"],"PROPNAME":"\u042d\u043b\u0435\u043c\u0435\u043d\u0442\u044b \u043d\u0430\u0431\u043e\u0440\u0430 JSON"},"manufacturer_full":{"VALUES":["NatureS (\u0420\u043e\u0441\u0441\u0438\u044f)"],"PROPNAME":"\u041f\u0440\u043e\u0438\u0437\u0432\u043e\u0434\u0438\u0442\u0435\u043b\u044c"}},"SECTIONS":["textile","3483","3489"],"NAME":"\u041f\u043e\u0434\u0443\u0448\u043a\u0430 \u00ab\u041a\u0440\u0443\u0436\u0435\u0432\u043d\u043e\u0435 \u043e\u0431\u043b\u0430\u043a\u043e\u00bb NS_KO-P-13-2","ID":"812093","DETAIL_PAGE_URL":"\/catalog\/NS_KO-P-13-2.html","XML_ID":"812093","CODE":"NS_KO-P-13-2","IBLOCK_TYPE_ID":"catalog","IBLOCK_SECTION_ID":"3489","PRICE":1000,"PROPERTY_VO_MANUF_NAME":"NatureS","PROPERTY_VO_MANUF_VALUE":"417213","vo_manuf":"417213","PRODUCT_RATING":"A","MAN_RATING":{"rating":"A","visibility":"30"},"have_group":true,"configurator_props":{"primary_color":["\u0431\u0435\u043b\u044b\u0439"],"size":["50 x 68 \u0441\u043c"],"photo_indicator":[""]},"not_photo_indicator":"1"},"mainitem":{"PROPERTIES":{"VO_MANUF":{"VALUES":["417213"],"PROPNAME":"\u041f\u0440\u043e\u0438\u0437\u0432\u043e\u0434\u0438\u0442\u0435\u043b\u044c"},"photo_small":{"VALUES":["http:\/\/photo.mebelion.ru\/images\/ace3d3b8feff92146c8551728fcbf846.jpg"],"PROPNAME":"\u041c\u0430\u043b\u0435\u043d\u044c\u043a\u043e\u0435 \u0444\u043e\u0442\u043e"},"photo_big":{"VALUES":["http:\/\/photo.mebelion.ru\/images\/7f4bc5b6415978d5a7473c0976931831.jpg"],"PROPNAME":"\u0411\u043e\u043b\u044c\u0448\u043e\u0435 \u0444\u043e\u0442\u043e "},"photo_med":{"VALUES":["http:\/\/photo.mebelion.ru\/images\/5e78151ffcc2bfc3ed7b114082d82865.jpg"],"PROPNAME":"\u0421\u0440\u0435\u0434\u043d\u0435\u0435 \u0444\u043e\u0442\u043e"},"search_article":{"VALUES":["NS_KO-P-13-2"],"PROPNAME":"\u0410\u0440\u0442\u0438\u043a\u0443\u043b"},"height":{"VALUES":["0"],"PROPNAME":"\u0412\u044b\u0441\u043e\u0442\u0430, \u043c\u043c"},"group_color":{"VALUES":["\u0431\u0435\u043b\u044b\u0439","\u043e\u0434\u043d\u043e\u0442\u043e\u043d\u043d\u044b\u0439"],"PROPNAME":"\u0413\u0440\u0443\u043f\u043f\u0430 \u0446\u0432\u0435\u0442\u0430"},"length":{"VALUES":["680"],"PROPNAME":"\u0414\u043b\u0438\u043d\u0430, \u043c\u043c"},"additional_parameters":{"VALUES":["\u041f\u043e\u0441\u0442\u0435\u043b\u044c\u043d\u044b\u0435 \u043f\u0440\u0438\u043d\u0430\u0434\u043b\u0435\u0436\u043d\u043e\u0441\u0442\u0438 \u0441 \u0441\u0438\u043d\u0442\u0435\u0442\u0438\u0447\u0435\u0441\u043a\u0438\u043c \u043f\u0443\u0445\u043e\u043c \u0434\u043b\u044f \u0442\u0435\u0445","\u0443 \u043a\u043e\u0433\u043e \u0441\u0443\u0449\u0435\u0441\u0442\u0432\u0443\u0435\u0442 \u0438\u043d\u0434\u0438\u0432\u0438\u0434\u0443\u0430\u043b\u044c\u043d\u0430\u044f \u043d\u0435\u043f\u0435\u0440\u0435\u043d\u043e\u0441\u0438\u043c\u043e\u0441\u0442\u044c \u043d\u0430\u0442\u0443\u0440\u0430\u043b\u044c\u043d\u044b\u0445 \u043d\u0430\u043f\u043e\u043b\u043d\u0438\u0442\u0435\u043b\u0435\u0439. \u0421\u0438\u043d\u0442\u0435\u0442\u0438\u0447\u0435\u0441\u043a\u0438\u0439 \u043f\u0443\u0445 \u043f\u0440\u0435\u0434\u0441\u0442\u0430\u0432\u043b\u044f\u0435\u0442 \u0441\u043e\u0431\u043e\u0439 \u043a\u043e\u043c\u0431\u0438\u043d\u0430\u0446\u0438\u044e \u0438\u0437 \u0443\u043b\u044c\u0442\u0440\u0430\u0442\u043e\u043d\u043a\u0438\u0445 \u0432\u043e\u043b\u043e\u043a\u043e\u043d. \u041e\u043d \u0434\u0430\u0440\u0438\u0442 \u043f\u043e\u0441\u0442\u0435\u043b\u044c\u043d\u044b\u043c \u043f\u0440\u0438\u043d\u0430\u0434\u043b\u0435\u0436\u043d\u043e\u0441\u0442\u044f\u043c \u043d\u0435\u043e\u0431\u044b\u043a\u043d\u043e\u0432\u0435\u043d\u043d\u0443\u044e \u043c\u044f\u0433\u043a\u043e\u0441\u0442\u044c \u0438 \u043b\u0435\u0433\u043a\u043e\u0441\u0442\u044c","\u0430 \u044d\u0444\u0444\u0435\u043a\u0442 \u00ab\u0443\u0442\u043e\u043f\u0430\u043d\u0438\u044f\u00bb \u0441\u0434\u0435\u043b\u0430\u0435\u0442 \u0438\u0445 \u0442\u0430\u043a\u0438\u043c\u0438 \u0436\u0435\u043b\u0430\u043d\u043d\u044b\u043c\u0438 \u0434\u043b\u044f \u043a\u0430\u0436\u0434\u043e\u0434\u043d\u0435\u0432\u043d\u043e\u0433\u043e \u043e\u0442\u0434\u044b\u0445\u0430. \u041e\u0434\u043d\u0438\u043c \u0438\u0437 \u0434\u043e\u0441\u0442\u043e\u0438\u043d\u0441\u0442\u0432 \u0434\u0430\u043d\u043d\u043e\u0439 \u043a\u043e\u043b\u043b\u0435\u043a\u0446\u0438\u0438 \u044f\u0432\u043b\u044f\u0435\u0442\u0441\u044f \u0442\u043e","\u0447\u0442\u043e \u0435\u0435 \u043c\u043e\u0436\u043d\u043e \u043c\u043d\u043e\u0433\u043e\u043a\u0440\u0430\u0442\u043d\u043e \u0441\u0442\u0438\u0440\u0430\u0442\u044c \u0431\u0435\u0437 \u0432\u0440\u0435\u0434\u0430 \u0434\u043b\u044f \u043a\u0430\u0447\u0435\u0441\u0442\u0432\u0430 \u0438\u0437\u0434\u0435\u043b\u0438\u044f. \u041d\u043e\u0432\u0438\u043d\u043a\u0430 - \u043f\u043e\u0434\u0443\u0448\u043a\u0430 \u0438\u0437 \u043f\u043b\u043e\u0442\u043d\u043e\u0433\u043e \u043f\u0443\u0445\u043e\u043d\u0435\u043f\u0440\u043e\u043d\u0438\u0446\u0430\u0435\u043c\u043e\u0433\u043e \u0445\u043b\u043e\u043f\u043a\u0430 \u0441 \u043a\u0430\u043d\u0442\u043e\u043c \u0438\u0437 \u043a\u0440\u0443\u0436\u0435\u0432\u0430. \u0422\u0430\u043a\u043e\u0439 \u0447\u0435\u0445\u043e\u043b \u043d\u0435 \u043f\u043e\u0437\u0432\u043e\u043b\u0438\u0442 \u0434\u043e\u043c\u0430\u0448\u043d\u0435\u0439 \u043f\u044b\u043b\u0438 \u043d\u0430\u043a\u0430\u043f\u043b\u0438\u0432\u0430\u0442\u044c\u0441\u044f \u0432 \u043f\u043e\u0434\u0443\u0448\u043a\u0430\u0445 \u0438 \u0431\u0443\u0434\u0435\u0442 \u043d\u0435\u043f\u0440\u0435\u043e\u0434\u043e\u043b\u0438\u043c\u044b\u043c \u0431\u0430\u0440\u044c\u0435\u0440\u043e\u043c \u0434\u043b\u044f \u043f\u044b\u043b\u0435\u0432\u044b\u0445 \u043a\u043b\u0435\u0449\u0435\u0439. \u0421\u0442\u0438\u0440\u043a\u0430 \u043f\u0440\u0438 40\u0421."],"PROPNAME":"\u0414\u043e\u043f\u043e\u043b\u043d\u0438\u0442\u0435\u043b\u044c\u043d\u044b\u0435 \u043f\u0430\u0440\u0430\u043c\u0435\u0442\u0440\u044b"},"type":{"VALUES":["\u041f\u043e\u0441\u0442\u0435\u043b\u044c\u043d\u044b\u0435 \u043f\u0440\u0438\u043d\u0430\u0434\u043b\u0435\u0436\u043d\u043e\u0441\u0442\u0438","\u041f\u043e\u0434\u0443\u0448\u043a\u0438"],"PROPNAME":"\u0417\u0430\u043f\u0438\u0441\u044c \u0442\u0438\u043f\u043e\u0432"},"count":{"VALUES":["1"],"PROPNAME":"\u041a\u043e\u043b\u0438\u0447\u0435\u0441\u0442\u0432\u043e \u043f\u0440\u0435\u0434\u043c\u0435\u0442\u043e\u0432"},"material_textile":{"VALUES":["100% \u0445\u043b\u043e\u043f\u043e\u043a"],"PROPNAME":"\u041c\u0430\u0442\u0435\u0440\u0438\u0430\u043b \u0442\u043a\u0430\u043d\u0438"},"filler":{"VALUES":["100% \u0441\u0438\u043b\u0438\u043a\u043e\u043d\u0438\u0437\u0438\u0440\u043e\u0432\u0430\u043d\u043d\u043e\u0435 \u0432\u043e\u043b\u043e\u043a\u043d\u043e"],"PROPNAME":"\u041d\u0430\u043f\u043e\u043b\u043d\u0438\u0442\u0435\u043b\u044c"},"primary_color":{"VALUES":["\u0431\u0435\u043b\u044b\u0439"],"PROPNAME":"\u041e\u0441\u043d\u043e\u0432\u043d\u043e\u0439 \u0446\u0432\u0435\u0442"},"density_weaving":{"VALUES":["\u0432\u044b\u0441\u043e\u043a\u0430\u044f"],"PROPNAME":"\u041f\u043b\u043e\u0442\u043d\u043e\u0441\u0442\u044c \u043f\u043b\u0435\u0442\u0435\u043d\u0438\u044f"},"size":{"VALUES":["50 x 68 \u0441\u043c"],"PROPNAME":"\u0420\u0430\u0437\u043c\u0435\u0440"},"seria":{"VALUES":["\u00ab\u041a\u0440\u0443\u0436\u0435\u0432\u043d\u043e\u0435 \u043e\u0431\u043b\u0430\u043a\u043e\u00bb"],"PROPNAME":"\u0421\u0435\u0440\u0438\u044f"},"sort":{"VALUES":["0"],"PROPNAME":"\u0421\u043e\u0440\u0442\u0438\u0440\u043e\u0432\u043a\u0430"},"decoration":{"VALUES":["\u043a\u0440\u0443\u0436\u0435\u0432\u0430"],"PROPNAME":"\u0422\u0438\u043f \u043e\u0442\u0434\u0435\u043b\u043a\u0438"},"type_textile":{"VALUES":["\u0442\u0438\u043a"],"PROPNAME":"\u0422\u0438\u043f \u0442\u043a\u0430\u043d\u0438"},"package":{"VALUES":["\u0441\u0443\u043c\u043a\u0430 \u0438\u0437 \u041f\u0412\u0425"],"PROPNAME":"\u0423\u043f\u0430\u043a\u043e\u0432\u043a\u0430"},"price":{"VALUES":["1000"],"PROPNAME":"\u0426\u0435\u043d\u0430"},"width":{"VALUES":["500"],"PROPNAME":"\u0428\u0438\u0440\u0438\u043d\u0430, \u043c\u043c"},"uniserial":{"VALUES":["NS_KO-P-13-2","NS_KO-P-15-2","NS_KO-P-3-3","NS_KO-P-5-3","NS_KO-O-3-3","NS_KO-O-5-3","NS_KO-O-7-3","NS_KO-O-3-3-T","NS_KO-O-5-3-T","NS_KO-O-7-3-T"],"PROPNAME":"\u041e\u0434\u043d\u043e\u0441\u0435\u0440\u0438\u0439\u043d\u044b\u0435"},"photo_int_small":{"VALUES":["0"],"PROPNAME":"\u041c\u0430\u043b\u0435\u043d\u044c\u043a\u043e\u0435 \u0444\u043e\u0442\u043e \u0432 \u0438\u043d\u0442\u0435\u0440\u044c\u0435\u0440\u0435"},"manufacturer_country":{"VALUES":["\u0420\u043e\u0441\u0441\u0438\u044f"],"PROPNAME":"\u0421\u0442\u0440\u0430\u043d\u0430 \u043f\u0440\u043e\u0438\u0437\u0432\u043e\u0434\u0438\u0442\u0435\u043b\u044f"},"type0":{"VALUES":["4"],"PROPNAME":"\u0413\u0440\u0443\u043f\u043f\u0430 \u043f\u0440\u043e\u0434\u0443\u043a\u0446\u0438\u0438"},"remains_count":{"VALUES":["0"],"PROPNAME":"\u041e\u0441\u0442\u0430\u0442\u043a\u0438"},"elasticity":{"VALUES":["\u0441\u0440\u0435\u0434\u043d\u044f\u044f"],"PROPNAME":"\u0423\u043f\u0440\u0443\u0433\u043e\u0441\u0442\u044c"},"group_filler":{"VALUES":["\u0441\u0438\u043b\u0438\u043a\u043e\u043d\u0438\u0437\u0438\u0440\u043e\u0432\u0430\u043d\u043d\u043e\u0435 \u0432\u043e\u043b\u043e\u043a\u043d\u043e"],"PROPNAME":"\u0413\u0440\u0443\u043f\u043f\u0430 \u043d\u0430\u043f\u043e\u043b\u043d\u0438\u0442\u0435\u043b\u044f"},"group_color_short":{"VALUES":["\u0431\u0435\u043b\u044b\u0439","\u043e\u0434\u043d\u043e\u0442\u043e\u043d\u043d\u044b\u0439"],"PROPNAME":"\u041a\u0440\u0430\u0442\u043a\u0430\u044f \u0433\u0440\u0443\u043f\u043f\u0430 \u0446\u0432\u0435\u0442\u0430"},"product_configurator_group_id":{"VALUES":["322"],"PROPNAME":"ID \u043a\u043e\u043d\u0444\u0438\u0433\u0443\u0440\u0438\u0440\u0443\u0435\u043c\u043e\u0439 \u0433\u0440\u0443\u043f\u043f\u044b \u043f\u0440\u043e\u0434\u0443\u043a\u0442\u043e\u0432"},"product_configurator_priority":{"VALUES":["0"],"PROPNAME":"\u041f\u0440\u0438\u043e\u0440\u0438\u0442\u0435\u0442 \u043f\u0440\u043e\u0434\u0443\u043a\u0442\u0430 \u0432\u043d\u0443\u0442\u0440\u0438 \u043a\u043e\u043d\u0444\u0438\u0433\u0443\u0440\u0438\u0440\u0443\u0435\u043c\u043e\u0439 \u0433\u0440\u0443\u043f\u043f\u044b"},"photo_int2_big":{"VALUES":["0"],"PROPNAME":"\u0411\u043e\u043b\u044c\u0448\u043e\u0435 \u0444\u043e\u0442\u043e \u0432 \u0438\u043d\u0442\u0435\u0440\u044c\u0435\u0440\u0435 2"},"complect_json":{"VALUES":["[]"],"PROPNAME":"\u042d\u043b\u0435\u043c\u0435\u043d\u0442\u044b \u043d\u0430\u0431\u043e\u0440\u0430 JSON"},"manufacturer_full":{"VALUES":["NatureS (\u0420\u043e\u0441\u0441\u0438\u044f)"],"PROPNAME":"\u041f\u0440\u043e\u0438\u0437\u0432\u043e\u0434\u0438\u0442\u0435\u043b\u044c"}},"SECTIONS":["textile","3483","3489"],"NAME":"\u041f\u043e\u0434\u0443\u0448\u043a\u0430 \u00ab\u041a\u0440\u0443\u0436\u0435\u0432\u043d\u043e\u0435 \u043e\u0431\u043b\u0430\u043a\u043e\u00bb NS_KO-P-13-2","ID":"812093","DETAIL_PAGE_URL":"\/catalog\/grp_322.html","XML_ID":"812093","CODE":"NS_KO-P-13-2","IBLOCK_TYPE_ID":"catalog","IBLOCK_SECTION_ID":"3489","PRICE":1000,"PROPERTY_VO_MANUF_NAME":"NatureS","PROPERTY_VO_MANUF_VALUE":"417213","vo_manuf":"417213","PRODUCT_RATING":"A","MAN_RATING":{"rating":"A","visibility":"30"},"have_group":true,"configurator_props":{"primary_color":["\u0431\u0435\u043b\u044b\u0439"],"size":["50 x 68 \u0441\u043c","68 x 68 \u0441\u043c"],"photo_indicator":[""]},"not_photo_indicator":"1","BUY_URL":"\/catalog\/grp_322.html\/?action=ADD2BASKET&id=812093&ELEMENT_ID=812093","main_in_group":"1","prefix_price":"\u043e\u0442 ","CATALOG_PRICE_1":"\u043e\u0442 1 000 <span class=\"currency\">\u0440\u0443\u0431.<\/span>"},"_\u0431\u0435\u043b\u044b\u0439_68 x 68 \u0441\u043c":{"PROPERTIES":{"VO_MANUF":{"VALUES":["417213"],"PROPNAME":"\u041f\u0440\u043e\u0438\u0437\u0432\u043e\u0434\u0438\u0442\u0435\u043b\u044c"},"photo_small":{"VALUES":["http:\/\/photo.mebelion.ru\/images\/07ad17bf6a6f11f19eb5934def70cc3e.jpg"],"PROPNAME":"\u041c\u0430\u043b\u0435\u043d\u044c\u043a\u043e\u0435 \u0444\u043e\u0442\u043e"},"photo_big":{"VALUES":["http:\/\/photo.mebelion.ru\/images\/8b7d3e627faae08fd0ae8730040c597c.jpg"],"PROPNAME":"\u0411\u043e\u043b\u044c\u0448\u043e\u0435 \u0444\u043e\u0442\u043e "},"photo_med":{"VALUES":["http:\/\/photo.mebelion.ru\/images\/541276457bdf5a94529330f1b023f7df.jpg"],"PROPNAME":"\u0421\u0440\u0435\u0434\u043d\u0435\u0435 \u0444\u043e\u0442\u043e"},"search_article":{"VALUES":["NS_KO-P-15-2"],"PROPNAME":"\u0410\u0440\u0442\u0438\u043a\u0443\u043b"},"height":{"VALUES":["0"],"PROPNAME":"\u0412\u044b\u0441\u043e\u0442\u0430, \u043c\u043c"},"group_color":{"VALUES":["\u0431\u0435\u043b\u044b\u0439","\u043e\u0434\u043d\u043e\u0442\u043e\u043d\u043d\u044b\u0439"],"PROPNAME":"\u0413\u0440\u0443\u043f\u043f\u0430 \u0446\u0432\u0435\u0442\u0430"},"length":{"VALUES":["680"],"PROPNAME":"\u0414\u043b\u0438\u043d\u0430, \u043c\u043c"},"additional_parameters":{"VALUES":["\u041f\u043e\u0441\u0442\u0435\u043b\u044c\u043d\u044b\u0435 \u043f\u0440\u0438\u043d\u0430\u0434\u043b\u0435\u0436\u043d\u043e\u0441\u0442\u0438 \u0441 \u0441\u0438\u043d\u0442\u0435\u0442\u0438\u0447\u0435\u0441\u043a\u0438\u043c \u043f\u0443\u0445\u043e\u043c \u0434\u043b\u044f \u0442\u0435\u0445","\u0443 \u043a\u043e\u0433\u043e \u0441\u0443\u0449\u0435\u0441\u0442\u0432\u0443\u0435\u0442 \u0438\u043d\u0434\u0438\u0432\u0438\u0434\u0443\u0430\u043b\u044c\u043d\u0430\u044f \u043d\u0435\u043f\u0435\u0440\u0435\u043d\u043e\u0441\u0438\u043c\u043e\u0441\u0442\u044c \u043d\u0430\u0442\u0443\u0440\u0430\u043b\u044c\u043d\u044b\u0445 \u043d\u0430\u043f\u043e\u043b\u043d\u0438\u0442\u0435\u043b\u0435\u0439. \u0421\u0438\u043d\u0442\u0435\u0442\u0438\u0447\u0435\u0441\u043a\u0438\u0439 \u043f\u0443\u0445 \u043f\u0440\u0435\u0434\u0441\u0442\u0430\u0432\u043b\u044f\u0435\u0442 \u0441\u043e\u0431\u043e\u0439 \u043a\u043e\u043c\u0431\u0438\u043d\u0430\u0446\u0438\u044e \u0438\u0437 \u0443\u043b\u044c\u0442\u0440\u0430\u0442\u043e\u043d\u043a\u0438\u0445 \u0432\u043e\u043b\u043e\u043a\u043e\u043d. \u041e\u043d \u0434\u0430\u0440\u0438\u0442 \u043f\u043e\u0441\u0442\u0435\u043b\u044c\u043d\u044b\u043c \u043f\u0440\u0438\u043d\u0430\u0434\u043b\u0435\u0436\u043d\u043e\u0441\u0442\u044f\u043c \u043d\u0435\u043e\u0431\u044b\u043a\u043d\u043e\u0432\u0435\u043d\u043d\u0443\u044e \u043c\u044f\u0433\u043a\u043e\u0441\u0442\u044c \u0438 \u043b\u0435\u0433\u043a\u043e\u0441\u0442\u044c","\u0430 \u044d\u0444\u0444\u0435\u043a\u0442 \u00ab\u0443\u0442\u043e\u043f\u0430\u043d\u0438\u044f\u00bb \u0441\u0434\u0435\u043b\u0430\u0435\u0442 \u0438\u0445 \u0442\u0430\u043a\u0438\u043c\u0438 \u0436\u0435\u043b\u0430\u043d\u043d\u044b\u043c\u0438 \u0434\u043b\u044f \u043a\u0430\u0436\u0434\u043e\u0434\u043d\u0435\u0432\u043d\u043e\u0433\u043e \u043e\u0442\u0434\u044b\u0445\u0430. \u041e\u0434\u043d\u0438\u043c \u0438\u0437 \u0434\u043e\u0441\u0442\u043e\u0438\u043d\u0441\u0442\u0432 \u0434\u0430\u043d\u043d\u043e\u0439 \u043a\u043e\u043b\u043b\u0435\u043a\u0446\u0438\u0438 \u044f\u0432\u043b\u044f\u0435\u0442\u0441\u044f \u0442\u043e","\u0447\u0442\u043e \u0435\u0435 \u043c\u043e\u0436\u043d\u043e \u043c\u043d\u043e\u0433\u043e\u043a\u0440\u0430\u0442\u043d\u043e \u0441\u0442\u0438\u0440\u0430\u0442\u044c \u0431\u0435\u0437 \u0432\u0440\u0435\u0434\u0430 \u0434\u043b\u044f \u043a\u0430\u0447\u0435\u0441\u0442\u0432\u0430 \u0438\u0437\u0434\u0435\u043b\u0438\u044f. \u041d\u043e\u0432\u0438\u043d\u043a\u0430 - \u043f\u043e\u0434\u0443\u0448\u043a\u0430 \u0438\u0437 \u043f\u043b\u043e\u0442\u043d\u043e\u0433\u043e \u043f\u0443\u0445\u043e\u043d\u0435\u043f\u0440\u043e\u043d\u0438\u0446\u0430\u0435\u043c\u043e\u0433\u043e \u0445\u043b\u043e\u043f\u043a\u0430 \u0441 \u043a\u0430\u043d\u0442\u043e\u043c \u0438\u0437 \u043a\u0440\u0443\u0436\u0435\u0432\u0430. \u0422\u0430\u043a\u043e\u0439 \u0447\u0435\u0445\u043e\u043b \u043d\u0435 \u043f\u043e\u0437\u0432\u043e\u043b\u0438\u0442 \u0434\u043e\u043c\u0430\u0448\u043d\u0435\u0439 \u043f\u044b\u043b\u0438 \u043d\u0430\u043a\u0430\u043f\u043b\u0438\u0432\u0430\u0442\u044c\u0441\u044f \u0432 \u043f\u043e\u0434\u0443\u0448\u043a\u0430\u0445 \u0438 \u0431\u0443\u0434\u0435\u0442 \u043d\u0435\u043f\u0440\u0435\u043e\u0434\u043e\u043b\u0438\u043c\u044b\u043c \u0431\u0430\u0440\u044c\u0435\u0440\u043e\u043c \u0434\u043b\u044f \u043f\u044b\u043b\u0435\u0432\u044b\u0445 \u043a\u043b\u0435\u0449\u0435\u0439. \u0421\u0442\u0438\u0440\u043a\u0430 \u043f\u0440\u0438 40\u0421."],"PROPNAME":"\u0414\u043e\u043f\u043e\u043b\u043d\u0438\u0442\u0435\u043b\u044c\u043d\u044b\u0435 \u043f\u0430\u0440\u0430\u043c\u0435\u0442\u0440\u044b"},"type":{"VALUES":["\u041f\u043e\u0441\u0442\u0435\u043b\u044c\u043d\u044b\u0435 \u043f\u0440\u0438\u043d\u0430\u0434\u043b\u0435\u0436\u043d\u043e\u0441\u0442\u0438","\u041f\u043e\u0434\u0443\u0448\u043a\u0438"],"PROPNAME":"\u0417\u0430\u043f\u0438\u0441\u044c \u0442\u0438\u043f\u043e\u0432"},"count":{"VALUES":["1"],"PROPNAME":"\u041a\u043e\u043b\u0438\u0447\u0435\u0441\u0442\u0432\u043e \u043f\u0440\u0435\u0434\u043c\u0435\u0442\u043e\u0432"},"material_textile":{"VALUES":["100% \u0445\u043b\u043e\u043f\u043e\u043a"],"PROPNAME":"\u041c\u0430\u0442\u0435\u0440\u0438\u0430\u043b \u0442\u043a\u0430\u043d\u0438"},"filler":{"VALUES":["100% \u0441\u0438\u043b\u0438\u043a\u043e\u043d\u0438\u0437\u0438\u0440\u043e\u0432\u0430\u043d\u043d\u043e\u0435 \u0432\u043e\u043b\u043e\u043a\u043d\u043e"],"PROPNAME":"\u041d\u0430\u043f\u043e\u043b\u043d\u0438\u0442\u0435\u043b\u044c"},"primary_color":{"VALUES":["\u0431\u0435\u043b\u044b\u0439"],"PROPNAME":"\u041e\u0441\u043d\u043e\u0432\u043d\u043e\u0439 \u0446\u0432\u0435\u0442"},"density_weaving":{"VALUES":["\u0432\u044b\u0441\u043e\u043a\u0430\u044f"],"PROPNAME":"\u041f\u043b\u043e\u0442\u043d\u043e\u0441\u0442\u044c \u043f\u043b\u0435\u0442\u0435\u043d\u0438\u044f"},"size":{"VALUES":["68 x 68 \u0441\u043c"],"PROPNAME":"\u0420\u0430\u0437\u043c\u0435\u0440"},"seria":{"VALUES":["\u00ab\u041a\u0440\u0443\u0436\u0435\u0432\u043d\u043e\u0435 \u043e\u0431\u043b\u0430\u043a\u043e\u00bb"],"PROPNAME":"\u0421\u0435\u0440\u0438\u044f"},"sort":{"VALUES":["0"],"PROPNAME":"\u0421\u043e\u0440\u0442\u0438\u0440\u043e\u0432\u043a\u0430"},"decoration":{"VALUES":["\u043a\u0440\u0443\u0436\u0435\u0432\u043e"],"PROPNAME":"\u0422\u0438\u043f \u043e\u0442\u0434\u0435\u043b\u043a\u0438"},"type_textile":{"VALUES":["\u0442\u0438\u043a"],"PROPNAME":"\u0422\u0438\u043f \u0442\u043a\u0430\u043d\u0438"},"package":{"VALUES":["\u0441\u0443\u043c\u043a\u0430 \u0438\u0437 \u041f\u0412\u0425"],"PROPNAME":"\u0423\u043f\u0430\u043a\u043e\u0432\u043a\u0430"},"price":{"VALUES":["1200"],"PROPNAME":"\u0426\u0435\u043d\u0430"},"width":{"VALUES":["680"],"PROPNAME":"\u0428\u0438\u0440\u0438\u043d\u0430, \u043c\u043c"},"uniserial":{"VALUES":["NS_KO-P-13-2","NS_KO-P-15-2","NS_KO-P-3-3","NS_KO-P-5-3","NS_KO-O-3-3","NS_KO-O-5-3","NS_KO-O-7-3","NS_KO-O-3-3-T","NS_KO-O-5-3-T","NS_KO-O-7-3-T"],"PROPNAME":"\u041e\u0434\u043d\u043e\u0441\u0435\u0440\u0438\u0439\u043d\u044b\u0435"},"photo_int_small":{"VALUES":["0"],"PROPNAME":"\u041c\u0430\u043b\u0435\u043d\u044c\u043a\u043e\u0435 \u0444\u043e\u0442\u043e \u0432 \u0438\u043d\u0442\u0435\u0440\u044c\u0435\u0440\u0435"},"manufacturer_country":{"VALUES":["\u0420\u043e\u0441\u0441\u0438\u044f"],"PROPNAME":"\u0421\u0442\u0440\u0430\u043d\u0430 \u043f\u0440\u043e\u0438\u0437\u0432\u043e\u0434\u0438\u0442\u0435\u043b\u044f"},"type0":{"VALUES":["4"],"PROPNAME":"\u0413\u0440\u0443\u043f\u043f\u0430 \u043f\u0440\u043e\u0434\u0443\u043a\u0446\u0438\u0438"},"remains_count":{"VALUES":["0"],"PROPNAME":"\u041e\u0441\u0442\u0430\u0442\u043a\u0438"},"elasticity":{"VALUES":["\u0441\u0440\u0435\u0434\u043d\u044f\u044f"],"PROPNAME":"\u0423\u043f\u0440\u0443\u0433\u043e\u0441\u0442\u044c"},"group_filler":{"VALUES":["\u0441\u0438\u043b\u0438\u043a\u043e\u043d\u0438\u0437\u0438\u0440\u043e\u0432\u0430\u043d\u043d\u043e\u0435 \u0432\u043e\u043b\u043e\u043a\u043d\u043e"],"PROPNAME":"\u0413\u0440\u0443\u043f\u043f\u0430 \u043d\u0430\u043f\u043e\u043b\u043d\u0438\u0442\u0435\u043b\u044f"},"group_color_short":{"VALUES":["\u0431\u0435\u043b\u044b\u0439","\u043e\u0434\u043d\u043e\u0442\u043e\u043d\u043d\u044b\u0439"],"PROPNAME":"\u041a\u0440\u0430\u0442\u043a\u0430\u044f \u0433\u0440\u0443\u043f\u043f\u0430 \u0446\u0432\u0435\u0442\u0430"},"product_configurator_group_id":{"VALUES":["322"],"PROPNAME":"ID \u043a\u043e\u043d\u0444\u0438\u0433\u0443\u0440\u0438\u0440\u0443\u0435\u043c\u043e\u0439 \u0433\u0440\u0443\u043f\u043f\u044b \u043f\u0440\u043e\u0434\u0443\u043a\u0442\u043e\u0432"},"product_configurator_priority":{"VALUES":["1"],"PROPNAME":"\u041f\u0440\u0438\u043e\u0440\u0438\u0442\u0435\u0442 \u043f\u0440\u043e\u0434\u0443\u043a\u0442\u0430 \u0432\u043d\u0443\u0442\u0440\u0438 \u043a\u043e\u043d\u0444\u0438\u0433\u0443\u0440\u0438\u0440\u0443\u0435\u043c\u043e\u0439 \u0433\u0440\u0443\u043f\u043f\u044b"},"photo_int2_big":{"VALUES":["0"],"PROPNAME":"\u0411\u043e\u043b\u044c\u0448\u043e\u0435 \u0444\u043e\u0442\u043e \u0432 \u0438\u043d\u0442\u0435\u0440\u044c\u0435\u0440\u0435 2"},"complect_json":{"VALUES":["[]"],"PROPNAME":"\u042d\u043b\u0435\u043c\u0435\u043d\u0442\u044b \u043d\u0430\u0431\u043e\u0440\u0430 JSON"},"manufacturer_full":{"VALUES":["NatureS (\u0420\u043e\u0441\u0441\u0438\u044f)"],"PROPNAME":"\u041f\u0440\u043e\u0438\u0437\u0432\u043e\u0434\u0438\u0442\u0435\u043b\u044c"}},"SECTIONS":["textile","3483","3489"],"NAME":"\u041f\u043e\u0434\u0443\u0448\u043a\u0430 \u00ab\u041a\u0440\u0443\u0436\u0435\u0432\u043d\u043e\u0435 \u043e\u0431\u043b\u0430\u043a\u043e\u00bb NS_KO-P-15-2","ID":"812103","DETAIL_PAGE_URL":"\/catalog\/NS_KO-P-15-2.html","XML_ID":"812103","CODE":"NS_KO-P-15-2","IBLOCK_TYPE_ID":"catalog","IBLOCK_SECTION_ID":"3489","PRICE":1200,"PROPERTY_VO_MANUF_NAME":"NatureS","PROPERTY_VO_MANUF_VALUE":"417213","vo_manuf":"417213","PRODUCT_RATING":"A","MAN_RATING":{"rating":"A","visibility":"30"},"have_group":true,"configurator_props":{"primary_color":["\u0431\u0435\u043b\u044b\u0439"],"size":["50 x 68 \u0441\u043c","68 x 68 \u0441\u043c"],"photo_indicator":[""]},"not_main_in_group":"1","not_photo_indicator":"1"}}};
    {/literal}
</script>

<!-- Yandex.Metrika counter 09.08.2012 #12247 -->
<script type="text/javascript">
    {literal}
    (function (d, w, c) {
        (w[c] = w[c] || []).push(function() {
            try {
                var webvisor_en = !/iphone|ipad|android/.test( navigator.platform.toLowerCase() ) && !$.browser.ie;
                w.yaCounter16338817 = new Ya.Metrika({id:16338817, enableAll: true, trackHash:true, webvisor:webvisor_en, params:window.yaParams||{ }});
            //Это устанавливает задержку при клике на ссылки, чтобы яндексовая статистика успела отправиться
            w.yaCounter16338817.trackLinks();
            w.yaCounter = w.yaCounter16338817;
        } catch(e) { }
    });

    var n = d.getElementsByTagName("script")[0],
            s = d.createElement("script"),
            f = function () { n.parentNode.insertBefore(s, n); };
    s.type = "text/javascript";
    s.async = true;
    s.src = (d.location.protocol == "https:" ? "https:" : "http:") + "//mc.yandex.ru/metrika/watch.js";

    if (w.opera == "[object Opera]") {
        d.addEventListener("DOMContentLoaded", f);
    } else { f(); }
    })(document, window, "yandex_metrika_callbacks");
    {/literal}
</script>
<noscript>&lt;div&gt;&lt;img src="//mc.yandex.ru/watch/16338817" style="position:absolute; left:-9999px;" alt="" /&gt;&lt;/div&gt;</noscript>
<!-- /Yandex.Metrika counter -->





<div style="display: none;">

    <!--  AdRiver code START. Type:counter(zeropixel) Site: mebelion PZ: 0 BN: 0 -->
    <script language="javascript" type="text/javascript"><!--
        var RndNum4NoCash = Math.round(Math.random() * 1000000000);
        var ar_Tail='unknown'; if (document.referrer) ar_Tail = escape(document.referrer);
        document.write('<img src="http://ad.adriver.ru/cgi-bin/rle.cgi?' + 'sid=186164&bt=21&pz=0&custom=10=0;11=0&rnd=' + RndNum4NoCash + '&tail256=' + ar_Tail + '" border=0 width=1 height=1>')
        //--></script>
    <noscript>&lt;img src="http://ad.adriver.ru/cgi-bin/rle.cgi?sid=186164&amp;bt=21&amp;pz=0&amp;rnd=1197363270&amp;custom=10=0;11=0" border=0 width=1 height=1&gt;</noscript>
    <!--  AdRiver code END  -->
    <script>
        {literal}
        document.write('<img src="http://mixmarket.biz/uni/t.php?aid=1294932306&r='+escape(document.referrer)+'&t='+(new Date()).getTime()+'" width="1" height="1"/>');</script><img src="http://mixmarket.biz/uni/t.php?aid=1294932306&amp;r=&amp;t=1371463705997" width="1" height="1"><noscript>&lt;img src="http://mixmarket.biz/uni/t.php?aid=1294932306&amp;r=&amp;t=" width="1" height="1"/&gt;</noscript><!-- Google Tag Manager --><script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0], j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src='//www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);})(window,document,'script','dataLayer','GTM-6HJR');
        {/literal}
    </script><!-- End Google Tag Manager --></div>


<!-- iScript -->
<div style="visibility: hidden; width: 1px; height: 1px; position: absolute; top:1px;">
<!-- Main. myThings -->
<script type="text/javascript">
function _mt_ready(){
            if (typeof(MyThings) != "undefined") {
                MyThings.Track({
                    EventType: MyThings.Event.Visit,
                    Action: "200"
                });
            }
        }
    </script>
    <!-- // Main. myThings --><!-- All. myThings -->
    <script type="text/javascript">
        var mtHost = (("https:" == document.location.protocol) ? "https" : "http") + "://rainbow-ru.mythings.com";
        var mtAdvertiserToken = "2169-100-ru";
        document.write(unescape("%3Cscript src='" + mtHost + "/c.aspx?atok="+mtAdvertiserToken+"' type='text/javascript'%3E%3C/script%3E"));
    </script><script src="http://rainbow-ru.mythings.com/c.aspx?atok=2169-100-ru" type="text/javascript"></script><div style="width:0px;height:0px" id="_mtContainer"><iframe frameborder="0" src="http://rainbow-ru.mythings.com/pix.aspx?atok=2169-100-ru&amp;eventtype=3&amp;aid=200&amp;mode=html&amp;ver=2.5&amp;ref=&amp;r=0.31614341237582266" style="width: 0px; height: 0px; overflow: hidden; border: none;"></iframe></div><div style="display:none;width:1px;height:1px" id="pr_element"></div>
    <!-- // All. myThings -->

</div>
<!-- // iScript -->

<!-- iScript -->
<div style="visibility: hidden; width: 1px; height: 1px; position: absolute; top:1px;">
    <!-- All --><script type="text/javascript">
    {literal}
    <!--document.write(unescape("%3Cscript id='pap_x2s6df8d' src='" + (("https:" == document.location.protocol) ? "https://" : "http://") + "mastertarget.ru/scripts/trackjs.js' type='text/javascript'%3E%3C/script%3E"));//--></script><script type="text/javascript"><!--  PostAffTracker.setAccountId('d9728b1b'); try {PostAffTracker.track();} catch (err) { } //-->
    {/literal}
    </script><!-- // All -->
    <!-- All --><!-- Adlabs.Retail --><script language="JavaScript" type="text/javascript">document.write('<img src="http://luxup.ru/rt/tr/263/?r='+escape(document.referrer)+'&t='+(new Date()).getTime()+(typeof _rt_target !== 'undefined' ? '&trg='+escape(_rt_target) : '') + '" />');</script><!-- Adlabs.Retail --><!-- // All -->
</div>
<!-- // iScript -->

<script type="text/javascript" src="/js/client_id.js"></script>


<noindex>
    {literal}
    <script type="text/javascript">

        window.phpProperties = {"DIVANS_SECTION_CODES":["3281","3350","3378","3628","3636","3287","3455"],"DEFAULT_STATUS_TIME":3,"PRODUCT_PADEJ":["\u0442\u043e\u0432\u0430\u0440","\u0442\u043e\u0432\u0430\u0440\u0430","\u0442\u043e\u0432\u0430\u0440\u043e\u0432"]};</script></noindex><script src="/js/mebelion.min.js?1371442118"></script><script></script><script>$(document).ready(function(){  });

</script>
{/literal}

    <span class="to-top" style="position: fixed; top: auto; bottom: 20px; display: none;"><i class="i i-to-top"></i><span>Наверх</span></span><div class="b-temp-thumbnail"></div><div class="d-helper"><div class="d-helper-inner"><div class="d-helper-container"><div class="d-helper-content"><div class="d-helper-item d-helper-item-default"></div></div><i class="d-helper-tail"></i></div></div></div><div id="sbi_camera_button" class="sbi_search" style="left:0px;top:0px;position:absolute;width:29px;height:27px;border:none;margin:0px 0px 0px 0px;padding:0px 0px 0px 0px;z-index:2147483647;display:none;"></div></body>
</html>
{/strip}