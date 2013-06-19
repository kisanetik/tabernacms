{strip}
{*
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd"> 
<html xmlns="http://www.w3.org/1999/xhtml"> 
*}
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" /> 
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
    {url file="jscss/components/jquery/jquery.js" type="js"}
    {url file="jscss/des/modern/product.js" type="js"}
    {url file="jscss/components/radbin.js" type="js"}
    {url file="jscss/des/modern/style.css" type="css" param="link"}
</head>
<body>

<div class="container">
    <div class="cont_two">
        <header class="l-header">
            <ul class="b-header-menu">
                <li><a href="/page/about.php">О компании</a><span class="separator"></span></li>
                <li><a href="/page/service.php">Доставка и оплата</a><span class="separator"></span></li>
                <li><a href="/page/garantiya.php">Гарантия</a><span class="separator"></span></li>
                <li class="last"><a href="/faq/">Помощь</a><span class="separator"></span></li>
            </ul>
            <div class="clear"></div>
            <div class="b-header-content">
                <a href="{url href="alias=SITE_URL"}" class="logo"></a>
                <div class="b-top-feedback">

                    <div class="b-item-phone">
                        <span class="label">Звонок бесплатный</span>
                        <span class="phone-code">8 (800)</span> <a href="tel:+7111-11-11">111-11-11</a>
                    </div>
                    <div class="b-item-phone">
                        <span class="label">Заказ по телефону</span>
                        <span class="phone-code">8 (495)</span> <a href="tel:+7222-22-22">222-22-22</a>
                    </div>
        
                    <span class="top-callback d-popup-open" data-dpopup="feedback">
                        <span>Обратный звонок</span>
                    </span>
                    <div class="b-time-feedback">
                      Пн-Пт: 9:00-20:00
                      <span class="separator"></span>
                      Сб-Вс: 10:00-18:00
                    </div>
                </div>
                
                <div class="b-top-cart-container">
                    
                    
                    
                    
                    <a href="{url href="alias=bin"}" class="b-top-cart clearfix{*class active can be added if bin products count > 0*}">
                        <span class="label">В корзине:</span>
                        <span class="count j-value">0</span>
                    </a>
                    <span id="sum_basket">Товаров на сумму <span>5 850 руб.</span></span>
                    <div id="mixmarket" style="visibility: hidden; width: 1px; height: 1px;"></div>
                    
                    <div id="div_basket_block">
                        <div id="div_basket_block">
                            <div class="basket_block">
                                <div class="b-basket-prewiev">
                                    <div class="b-item">
                                        <div class="photo">
                                            <a href="/catalog/OD_2280_5.html">
                                                <img src="/images/46a37fec7b8befa4ac42b5e945b1084c.jpg" alt="Накладной светильник Flau 2280/5">
                                            </a>
                                        </div>
                                        <div class="b-item-content">
                                            <div class="name"><a href="/catalog/OD_2280_5.html">Накладной светильник Flau 2280/5</a></div>
                                            <p class="price">1 x 5 850 руб.</p>
                                        </div>
                                        <div class="clear"></div>
                                    </div>
                                </div>
                                <div class="b-basket-prewiev-itog">
                                    <table class="summ">
                                        <tr>
                                            <td class="td-left">Итого:</td>
                                            <td class="td-right">
                                                <b>5 850 
                                                    <span>руб.</span>
                                                </b>
                                            </td>
                                        </tr>
                                    </table>
                                    <div class="b-basket-prewiev-buttons">
                                        <a class="button-v5" style="float: right;" href="/personal/order/make/">Оформить
                                            <br> заказ
                                        </a>
                                        <a class="button-v2" href="/personal/cart/">Перейти
                                            <br> в корзину
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </header>
        
        <nav class="b-top-menu">
            <table>
                <tr>
                    <td class="b-top-first-td">
                        <ul id="menu" class="b-main-menu">
                            <li id="li_sver">
                                <a href="/catalog/svet/" class="drop fldm">
                                    Свет
                                    <span class="separator"></span>
								    <span class="drop_after">&nbsp;</span>
                                </a>
                                
                                
                                
                                
                                
                                
                                <div class="dropdown-shadows">
<table class="dropdown_5columns">
    <tr>
	    <td class="onetwofree">
		    <div class="punkt">
			    <p class="menu-second-level"><a href="/catalog/2975/">Традиционные светильники</a></p>
				<ul>
					<li><a href="/catalog/2976/">Люстры</a></li>
					<li><a href="/catalog/3005/">Хрустальные Люстры</a></li>
					<li><a href="/catalog/2987/">Бра</a></li>
					<li><a href="/catalog/3006/">Хрустальные Бра</a></li>
					<li><a href="/catalog/2979/">Торшеры</a></li>
					<li><a href="/catalog/2978/">Настольные лампы</a></li>
				</ul>
			</div>
			<div class="punkt">
			    <p class="menu-second-level"><a href="/catalog/3038/">Светильники для Ванной</a></p>
			    <ul>
					<li><a href="/catalog/3039/">Настенные</a></li>
					<li><a href="/catalog/3040/">Настенно-потолочные</a></li>
					<li><a href="/catalog/3041/">Потолочные</a></li>
					<li><a href="/catalog/3043/">Специальные для ванной</a></li>
					<li><a href="/catalog/3042/">Точечные</a></li>
				</ul>
			</div>
			<div class="punkt">
			    <p class="menu-second-level"><a href="/catalog/3023/">Светильники для Детской</a></p>
				<ul>
					<li><a href="/catalog/3024/">Люстры и Потолочные</a></li>
					<li><a href="/catalog/3025/">Бра и Настенные</a></li>
					<li><a href="/catalog/3026/">Настенно-потолочные и Споты</a></li>
					<li><a href="/catalog/3027/">Настольные лампы</a></li>
			    </ul>
			</div>
			<div class="punkt">
				<p class="menu-second-level"><a href="/catalog/3237/">Сопутствующие товары</a></p>
				<ul>
				    <li><a href="/catalog/3239/">Настенные часы</a></li>
				</ul>
			</div>
		</td>
		<td class="onetwofree">
			<div class="punkt">
				<p class="menu-second-level"><a href="/catalog/3004/">Интерьерные светильники</a></p>
				<ul>
					<li><a href="/catalog/4041/">Потолочные светильники</a></li>
					<li><a href="/catalog/4081/">Подвесные</a></li>
					<li><a href="/catalog/2980/">Настенно-потолочные</a></li>
					<li><a href="/catalog/2977/">Настенные светильники</a></li>
					<li><a href="/catalog/2981/">Споты</a></li>
					<li><a href="/catalog/2982/">Точечные светильники</a></li>
				</ul>
			</div>
			<div class="punkt">
			    <p class="menu-second-level"><a href="/catalog/3056/">Светильники для Кухни</a></p>
				<ul>
					<li><a href="/catalog/3057/">Настенные</a></li>
					<li><a href="/catalog/3058/">Настенно-потолочные</a></li>
					<li><a href="/catalog/3059/">Потолочные</a></li>
					<li><a href="/catalog/3061/">Специальные для кухни</a></li>
					<li><a href="/catalog/3060/">Точечные</a></li>
				</ul>
			</div>
			<div class="punkt">
				<p class="menu-second-level"><a href="/catalog/3202/">Комплектующие</a></p>
				<ul>
					<li><a href="/catalog/3203/">Лампы</a></li>
					<li><a href="/catalog/3204/">Блоки защиты и питания</a></li>
					<li><a href="/catalog/3205/">Выключатели</a></li>
					<li><a href="/catalog/3206/">Розетки и Провода</a></li>
					<li><a href="/catalog/3207/">Плафоны</a></li>
					<li><a href="/catalog/3208/">Трансформаторы и ПРА</a></li>
				</ul>
			</div>
		</td>
								<td class="onetwofree">
												<div class="punkt">
					<p class="menu-second-level"><a href="/catalog/3093/">Технические светильники</a></p>
																										<ul>
																				<li><a href="/catalog/3094/">Трековые</a></li>
																																	<li><a href="/catalog/3095/">Элементы трековых систем</a></li>
																																	<li><a href="/catalog/3099/">Потолочные</a></li>
																																	<li><a href="/catalog/3098/">Настенно-потолочные</a></li>
																																	<li><a href="/catalog/3097/">Настенные</a></li>
																																	<li><a href="/catalog/3100/">Специальные и Карданные</a></li>
																															</ul>
														</div>
												<div class="punkt">
					<p class="menu-second-level"><a href="/catalog/5441/">Акцентные светильники</a></p>
																										<ul>
																				<li><a href="/catalog/5501/">Встраиваемые светильники</a></li>
																																	<li><a href="/catalog/3003/">Споты</a></li>
																																	<li><a href="/catalog/5511/">Накладные светильники</a></li>
																																	<li><a href="/catalog/3096/">Карданные</a></li>
																																	<li><a href="/catalog/5521/">Трековые светильники</a></li>
																															</ul>
														</div>
												<div class="punkt">
					<p class="menu-second-level"><a href="/catalog/3075/">Специальные светильники</a></p>
																										<ul>
																				<li><a href="/catalog/3076/">Аварийные светильники</a></li>
																																	<li><a href="/catalog/3077/">Для ванной</a></li>
																																	<li><a href="/catalog/3078/">Для кухни</a></li>
																																	<li><a href="/catalog/3079/">Для потолка Армстронг</a></li>
																																	<li><a href="/catalog/3081/">Подсветки</a></li>
																																	<li><a href="/catalog/3080/">Мебельные светильники</a></li>
																															</ul>
														</div>
										</td>
								<td class="onetwofree">
												<div class="punkt">
					<p class="menu-second-level"><a href="/catalog/3132/">Уличные светильники</a></p>
																										<ul>
																				<li><a href="/catalog/3133/">Наземные светильники</a></li>
																																	<li><a href="/catalog/3134/">Настенные</a></li>
																																	<li><a href="/catalog/3135/">Настенно-потолочные</a></li>
																																	<li><a href="/catalog/3136/">Потолочные</a></li>
																																	<li><a href="/catalog/3138/">Специальные светильники</a></li>
																																	<li><a href="/catalog/3137/">Прожекторы</a></li>
																															</ul>
														</div>
												<div class="punkt">
					<p class="menu-second-level"><a href="/catalog/3183/">Световые фигуры</a></p>
																										<ul>
																				<li><a href="/catalog/3184/">Садовые фигуры</a></li>
																																	<li><a href="/catalog/3185/">Световые деревья</a></li>
																																	<li><a href="/catalog/3186/">Настольные лампы</a></li>
																															</ul>
														</div>
												<div class="punkt">
					<p class="menu-second-level"><a href="/catalog/3163/">Световые гирлянды</a></p>
																										<ul>
																				<li><a href="/catalog/3173/">Дюралайт</a></li>
																																	<li><a href="/catalog/3169/">Комплектующие</a></li>
																															</ul>
														</div>
										</td>
						</tr></tbody></table>
<div class="dropdown-shadow-top"></div>
<div class="dropdown-shadow-bottom"></div>
                </div>
                                
                                
                                
                                
                                
                                
                                
                                
                            </li>
								<li class="">
    								<a href="/catalog/textile/" class="drop fldm">
    										Текстиль <span class="separator"></span> <span
    										class="drop_after">&nbsp;</span>
    								</a> <!-- Начало пунтка 5 колонок -->
    									<div class="dropdown-shadows">
    										<table class="dropdown_5columns">
    											<tbody>
    												<tr>
    													<!-- Начало контейнера на 5 колонок -->
    													<td class="onetwofree">
    														<div class="punkt">
    															<p class="menu-second-level">
    																<a href="/catalog/3448/">Наборы постельного белья</a>
    															</p>
    															<ul>
    																<li><a href="/catalog/3449/">Комплекты постельного белья</a>
    																</li>
    																<li><a href="/catalog/3467/">Наборы наволочек</a></li>
    																<li><a href="/catalog/3468/">Простыни с наволочками</a>
    																</li>
    															</ul>
    														</div>
    														<div class="punkt">
    															<p class="menu-second-level">
    																<a href="/catalog/3472/">Наборы постельные смешанные</a>
    															</p>
    															<ul>
    																<li><a href="/catalog/3473/">Комплекты с одеялом</a></li>
    																<li><a href="/catalog/3474/">Комплекты с одеялом и
    																		бортиком</a></li>
    																<li><a href="/catalog/3477/">Покрывала с наволочками</a>
    																</li>
    															</ul>
    														</div>
    														<div class="punkt">
    															<p class="menu-second-level">
    																<a href="/catalog/3469/">Наборы постельных
    																	принадлежностей</a>
    															</p>
    															<ul>
    																<li><a href="/catalog/3470/">Одеяла с подушками</a></li>
    																<li><a href="/catalog/3471/">Покрывала с подушками</a></li>
    															</ul>
    														</div>
    													</td>
    													<td class="onetwofree">
    														<div class="punkt">
    															<p class="menu-second-level">
    																<a href="/catalog/3483/">Постельные принадлежности</a>
    															</p>
    															<ul>
    																<li><a href="/catalog/3484/">Одеяла всесезонные</a></li>
    																<li><a href="/catalog/3485/">Одеяла зимние</a></li>
    																<li><a href="/catalog/3486/">Одеяла летние</a></li>
    																<li><a href="/catalog/3487/">Пледы</a></li>
    																<li><a href="/catalog/3488/">Покрывала</a></li>
    																<li><a href="/catalog/3489/">Подушки</a></li>
    																<li><a href="/catalog/3490/">Наматрасники</a></li>
    															</ul>
    														</div>
    														<div class="punkt">
    															<p class="menu-second-level">
    																<a href="/catalog/3515/">Шторы</a>
    															</p>
    															<ul>
    																<li><a href="/catalog/3520/">Готовые наборы</a></li>
    															</ul>
    														</div>
    													</td>
    													<td class="onetwofree">
    														<div class="punkt">
    															<p class="menu-second-level">
    																<a href="/catalog/3479/">Постельное белье</a>
    															</p>
    															<ul>
    																<li><a href="/catalog/3480/">Наволочки</a></li>
    																<li><a href="/catalog/3481/">Простыни</a></li>
    															</ul>
    														</div>
    														<div class="punkt">
    															<p class="menu-second-level">
    																<a href="/catalog/3498/">Текстиль для бани</a>
    															</p>
    															<ul>
    																<li><a href="/catalog/3500/">Халаты банные</a></li>
    																<li><a href="/catalog/3501/">Полотенца</a></li>
    																<li><a href="/catalog/3503/">Принадлежности для бани</a>
    																</li>
    															</ul>
    														</div>
    														<div class="punkt">
    															<p class="menu-second-level">
    																<a href="/catalog/3491/">Домашний текстиль</a>
    															</p>
    															<ul>
    																<li><a href="/catalog/3494/">Халаты домашние</a></li>
    															</ul>
    														</div>
    													</td>
    													<td class="onetwofree">
    														<div class="punkt">
    															<p class="menu-second-level">
    																<a href="/catalog/3505/">Текстиль для ванной и туалета</a>
    															</p>
    															<ul>
    																<li><a href="/catalog/3506/">Полотенца</a></li>
    																<li><a href="/catalog/3507/">Коврики</a></li>
    																<li><a href="/catalog/3508/">Шторы для ванной</a></li>
    																<li><a href="/catalog/3790/">Наборы для ванной</a></li>
    															</ul>
    														</div>
    														<div class="punkt">
    															<p class="menu-second-level">
    																<a href="/catalog/3509/">Текстиль для кухни</a>
    															</p>
    															<ul>
    																<li><a href="/catalog/3510/">Полотенца кухонные</a></li>
    																<li><a href="/catalog/3511/">Салфетки</a></li>
    																<li><a href="/catalog/3512/">Скатерти</a></li>
    															</ul>
    														</div>
    													</td>
    												</tr>
    											</tbody>
    										</table>
    										<div class="dropdown-shadow-top"></div>
    										<div class="dropdown-shadow-bottom"></div>
    									</div>
								</li>
							</ul>
                    </td>
                    <td>
                        <div class="search_title">
                            <div id="title-search" class="form-box">
                                <form id="title-search-form" action="#">
                                    <div class="search-input-ie7">
                                        <input type="text" class="def-val" data-defaultvalue="Поиск товара" autocomplete="off" maxlength="50" size="40" value="Поиск товара" name="query" id="title-search-input">
                                    </div>
                                    <input id="search-submit-button" type="image" src="{const SITE_URL}img/des/modern/title-search-input.png" name="search" />
                                </form>
                            </div>
                        </div>
                    </td>
                    
                    
                </tr>
            </table>
        </nav>
        
        
        
        <div id="innerdiv" style="overflow: visible;">
            <div class="b-light-slider home-light-slider inited">
                <div class="bls-arrows">
                </div>
                <div class="bls-controls">
                    <div class="bls-controls-content">
                        <i class="selected" data-index="0"></i>
                        <i class="" data-index="1"></i>
                    </div>
                </div>
            </div>
            <div class="gray_index">
                <div id="Discount">
                    <div class="div_products_carousel same">
                        <img alt="" class="tovar_nedeli" src="{const SITE_URL}images/best-choise.png" />
                        <div class="jcarousel-container jcarousel-container-horizontal" style="position: relative; display: block;">
                            <div class="jcarousel-clip jcarousel-clip-horizontal" style="position: relative;">
                                <ul class="jcarousel-list products_carousel jcarousel-list-horizontal" style="overflow: hidden; position: relative; top: 0px; margin: 0px; padding: 0px; left: 0px; width: 8080px;">











										<li jcarouselindex="1"
											style="float: left; list-style: none outside none;"
											class="jcarousel-item jcarousel-item-horizontal jcarousel-item-1 jcarousel-item-1-horizontal">


											<div data-article="grp_322" class="b-minicard">

												<div class="bm-discount-label"></div>


												<div class="b-minicard-inner">
													<div class="b-minicard-content">

														<div class="bm-photo">
															<a title="Подушка «Кружевное облако» NS_KO-P-13-2"
																href="/catalog/grp_322.html"> <img
																style="display: inline;" class="lazy"
																title="Подушка «Кружевное облако» NS_KO-P-13-2"
																alt="Подушка «Кружевное облако» NS_KO-P-13-2"
																src="http://photo.mebelion.ru/images/ace3d3b8feff92146c8551728fcbf846.jpg"
																data-original="http://photo.mebelion.ru/images/ace3d3b8feff92146c8551728fcbf846.jpg"
																id="prodPic812093">
															</a> <span class="quick-view-open d-popup-open"
																data-dpopup="quick-view" data-article="grp_322">Быстрый
																просмотр <i class="i i-quick-view"></i>
															</span>

														</div>

														<div class="bm-name">
															<a href="/catalog/grp_322.html">Подушка «Кружевное
																облако» NS_KO-P-13-2</a>
														</div>

														<div class="bm-manufacturer">
															<a href="/brand/NatureS/">NatureS</a>
														</div>


														<div class="bm-price">
															<span class="js-price">от 1 000</span> <span
																class="currency">руб.</span>
														</div>

													</div>

													<div class="bm-hide-info select-group">





														<div class="b-select-cont">
															<select style="display: none;" id="primary_color_322"
																group="322"
																class="select_sizes configurator_size i-select"
																data-class="select-v1" data-revert="true">
																<option selected="selected" value="0">--выберите
																	размер--</option>


																<option value="50 x 68 см">50 x 68 см</option>


																<option value="68 x 68 см">68 x 68 см</option>

															</select>
															<div class="i-s-container select-v1">
																<div class="i-s-content selected">
																	<div class="i-s-value">--выберите размер--</div>
																</div>
																<div class="i-s-arrow">
																	<i class="i i-s-arrow-str"></i>
																</div>
																<div style="display: none;" class="i-s-values">
																	<ul class="values-list">
																		<li class="active" data-value="--выберите размер--"
																			data-servervalue="0">--выберите размер--</li>
																		<li data-value="50 x 68 см"
																			data-servervalue="50 x 68 см">50 x 68 см</li>
																		<li data-value="68 x 68 см"
																			data-servervalue="68 x 68 см">68 x 68 см</li>
																	</ul>
																</div>
																<div class="i-s-clickable"></div>
															</div>
														</div>





														<noindex> <span class="button-v2 add2Cart"
															data-nodeid="812093" data-article="grp_322" active="no"
															data-count="1">Купить</span> </noindex>


													</div>

													<i class="bm-top-left-border"></i>
												</div>
											</div>
										</li>
										<li jcarouselindex="2"
											style="float: left; list-style: none outside none;"
											class="jcarousel-item jcarousel-item-horizontal jcarousel-item-2 jcarousel-item-2-horizontal">


											<div data-article="OD_2280_5" class="b-minicard">

												<div class="bm-discount-label"></div>


												<div class="b-minicard-inner">
													<div class="b-minicard-content">

														<div class="bm-photo">
															<a title="Накладной светильник Flau 2280/5"
																href="/catalog/OD_2280_5.html"> <img
																style="display: inline;" class="lazy"
																title="Накладной светильник Flau 2280/5"
																alt="Накладной светильник Flau 2280/5"
																src="http://photo.mebelion.ru/images/46a37fec7b8befa4ac42b5e945b1084c.jpg"
																data-original="http://photo.mebelion.ru/images/46a37fec7b8befa4ac42b5e945b1084c.jpg"
																id="prodPic769033">
															</a> <span class="quick-view-open d-popup-open"
																data-dpopup="quick-view" data-article="OD_2280_5">Быстрый
																просмотр <i class="i i-quick-view"></i>
															</span>

														</div>

														<div class="bm-name">
															<a href="/catalog/OD_2280_5.html">Накладной светильник
																Flau 2280/5</a>
														</div>

														<div class="bm-manufacturer">
															<a href="/brand/odeon_light/">Odeon Light</a>
														</div>


														<div class="bm-price">
															<span class="js-price">5 850</span> <span
																class="currency">руб.</span>
														</div>

													</div>

													<div class="bm-hide-info select-group">



														<noindex> <span class="button-v2 add2Cart"
															data-nodeid="769033" data-article="OD_2280_5"
															active="yes" data-count="1">Купить</span> </noindex>


													</div>

													<i class="bm-top-left-border"></i>
												</div>
											</div>
										</li>
										<li jcarouselindex="3"
											style="float: left; list-style: none outside none;"
											class="jcarousel-item jcarousel-item-horizontal jcarousel-item-3 jcarousel-item-3-horizontal">


											<div data-article="AR_A1014FN-1BK" class="b-minicard">

												<div class="bm-discount-label"></div>


												<div class="b-minicard-inner">
													<div class="b-minicard-content">

														<div class="bm-photo">
															<a title="Наземный низкий светильник Bremen A1014FN-1BK"
																href="/catalog/AR_A1014FN-1BK.html"> <img
																style="display: inline;" class="lazy"
																title="Наземный низкий светильник Bremen A1014FN-1BK"
																alt="Наземный низкий светильник Bremen A1014FN-1BK"
																src="http://photo.mebelion.ru/images/40d276c25180c084949aeeba80b59116.jpg"
																data-original="http://photo.mebelion.ru/images/40d276c25180c084949aeeba80b59116.jpg"
																id="prodPic716083">
															</a> <span class="quick-view-open d-popup-open"
																data-dpopup="quick-view" data-article="AR_A1014FN-1BK">Быстрый
																просмотр <i class="i i-quick-view"></i>
															</span>

														</div>

														<div class="bm-name">
															<a href="/catalog/AR_A1014FN-1BK.html">Наземный низкий
																светильник Bremen A1014FN-1BK</a>
														</div>

														<div class="bm-manufacturer">
															<a href="/brand/arte/">Arte</a>
														</div>


														<div class="bm-price">
															<span class="js-price">590</span> <span class="currency">руб.</span>
														</div>

													</div>

													<div class="bm-hide-info select-group">



														<noindex> <span class="button-v2 add2Cart"
															data-nodeid="716083" data-article="AR_A1014FN-1BK"
															active="yes" data-count="1">Купить</span> </noindex>


													</div>

													<i class="bm-top-left-border"></i>
												</div>
											</div>
										</li>
										<li jcarouselindex="4"
											style="float: left; list-style: none outside none;"
											class="jcarousel-item jcarousel-item-horizontal jcarousel-item-4 jcarousel-item-4-horizontal">


											<div data-article="ML_Solo_WENGE" class="b-minicard">

												<div class="bm-discount-label"></div>


												<div class="b-minicard-inner">
													<div class="b-minicard-content">

														<div class="bm-photo">
															<a title="Стол журнальный Гамма Соло венге"
																href="/catalog/ML_Solo_WENGE.html"> <img
																style="display: inline;" class="lazy"
																title="Стол журнальный Гамма Соло венге"
																alt="Стол журнальный Гамма Соло венге"
																src="http://photo.mebelion.ru/images/9f148af0e7cfb035d220c2871ecb335f.jpg"
																data-original="http://photo.mebelion.ru/images/9f148af0e7cfb035d220c2871ecb335f.jpg"
																id="prodPic817874">
															</a> <span class="quick-view-open d-popup-open"
																data-dpopup="quick-view" data-article="ML_Solo_WENGE">Быстрый
																просмотр <i class="i i-quick-view"></i>
															</span>

														</div>

														<div class="bm-name">
															<a href="/catalog/ML_Solo_WENGE.html">Стол журнальный
																Гамма Соло венге</a>
														</div>

														<div class="bm-manufacturer">
															<a href="/brand/mebelik/">Мебелик</a>
														</div>


														<div class="bm-price">
															<span class="js-price">5 200</span> <span
																class="currency">руб.</span>
														</div>

													</div>

													<div class="bm-hide-info select-group">



														<noindex> <span class="button-v2 add2Cart"
															data-nodeid="817874" data-article="ML_Solo_WENGE"
															active="yes" data-count="1">Купить</span> </noindex>


													</div>

													<i class="bm-top-left-border"></i>
												</div>
											</div>
										</li>
										<li jcarouselindex="5"
											style="float: left; list-style: none outside none;"
											class="jcarousel-item jcarousel-item-horizontal jcarousel-item-5 jcarousel-item-5-horizontal">


											<div data-article="EG_88274" class="b-minicard">

												<div class="bm-discount-label"></div>


												<div class="b-minicard-inner">
													<div class="b-minicard-content">

														<div class="bm-photo">
															<a title="Бра Catwalk 88274"
																href="/catalog/EG_88274.html"> <img
																style="display: inline;" class="lazy"
																title="Бра Catwalk 88274" alt="Бра Catwalk 88274"
																src="http://photo.mebelion.ru/images/6164757b52079075bafee8ea04023ff0.jpg"
																data-original="http://photo.mebelion.ru/images/6164757b52079075bafee8ea04023ff0.jpg"
																id="prodPic532453">
															</a> <span class="quick-view-open d-popup-open"
																data-dpopup="quick-view" data-article="EG_88274">Быстрый
																просмотр <i class="i i-quick-view"></i>
															</span>

														</div>

														<div class="bm-name">
															<a href="/catalog/EG_88274.html">Бра Catwalk 88274</a>
														</div>

														<div class="bm-manufacturer">
															<a href="/brand/eglo/">Eglo</a>
														</div>


														<div class="bm-price">
															<span class="js-price">2 700</span> <span
																class="currency">руб.</span>
														</div>

													</div>

													<div class="bm-hide-info select-group">



														<noindex> <span class="button-v2 add2Cart"
															data-nodeid="532453" data-article="EG_88274" active="yes"
															data-count="1">Купить</span> </noindex>


													</div>

													<i class="bm-top-left-border"></i>
												</div>
											</div>
										</li>
										<li jcarouselindex="6"
											style="float: left; list-style: none outside none;"
											class="jcarousel-item jcarousel-item-horizontal jcarousel-item-6 jcarousel-item-6-horizontal">


											<div data-article="ML_Priz_6N_MEDBR" class="b-minicard">

												<div class="bm-discount-label"></div>


												<div class="b-minicard-inner">
													<div class="b-minicard-content">

														<div class="bm-photo">
															<a title="Стол журнальный Приз 6h коричневый"
																href="/catalog/ML_Priz_6N_MEDBR.html"> <img class="lazy"
																title="Стол журнальный Приз 6h коричневый"
																alt="Стол журнальный Приз 6h коричневый"
																src="/sharedlibs/images/empty.gif"
																data-original="http://photo.mebelion.ru/images/c5d2717fe3659459ee1b11f0c6c7d75d.jpg"
																id="prodPic817873">
															</a> <span class="quick-view-open d-popup-open"
																data-dpopup="quick-view" data-article="ML_Priz_6N_MEDBR">Быстрый
																просмотр <i class="i i-quick-view"></i>
															</span>

														</div>

														<div class="bm-name">
															<a href="/catalog/ML_Priz_6N_MEDBR.html">Стол журнальный
																Приз 6h коричневый</a>
														</div>

														<div class="bm-manufacturer">
															<a href="/brand/mebelik/">Мебелик</a>
														</div>


														<div class="bm-price">
															<span class="js-price">9 100</span> <span
																class="currency">руб.</span>
														</div>

													</div>

													<div class="bm-hide-info select-group">



														<noindex> <span class="button-v2 add2Cart"
															data-nodeid="817873" data-article="ML_Priz_6N_MEDBR"
															active="yes" data-count="1">Купить</span> </noindex>


													</div>

													<i class="bm-top-left-border"></i>
												</div>
											</div>
										</li>
										<li jcarouselindex="7"
											style="float: left; list-style: none outside none;"
											class="jcarousel-item jcarousel-item-horizontal jcarousel-item-7 jcarousel-item-7-horizontal">


											<div data-article="ML_Sakura_2_W_WENGE" class="b-minicard">

												<div class="bm-discount-label"></div>


												<div class="b-minicard-inner">
													<div class="b-minicard-content">

														<div class="bm-photo">
															<a title="Стол журнальный Сакура 2 (на колесах) венге"
																href="/catalog/ML_Sakura_2_W_WENGE.html"> <img
																class="lazy"
																title="Стол журнальный Сакура 2 (на колесах) венге"
																alt="Стол журнальный Сакура 2 (на колесах) венге"
																src="/sharedlibs/images/empty.gif"
																data-original="http://photo.mebelion.ru/images/a2c5a47530b1878ca8e35846cafc8866.jpg"
																id="prodPic818443">
															</a> <span class="quick-view-open d-popup-open"
																data-dpopup="quick-view"
																data-article="ML_Sakura_2_W_WENGE">Быстрый просмотр <i
																class="i i-quick-view"></i>
															</span>

														</div>

														<div class="bm-name">
															<a href="/catalog/ML_Sakura_2_W_WENGE.html">Стол
																журнальный Сакура 2 (на колесах) венге</a>
														</div>

														<div class="bm-manufacturer">
															<a href="/brand/mebelik/">Мебелик</a>
														</div>


														<div class="bm-price">
															<span class="js-price">8 750</span> <span
																class="currency">руб.</span>
														</div>

													</div>

													<div class="bm-hide-info select-group">



														<noindex> <span class="button-v2 add2Cart"
															data-nodeid="818443" data-article="ML_Sakura_2_W_WENGE"
															active="yes" data-count="1">Купить</span> </noindex>


													</div>

													<i class="bm-top-left-border"></i>
												</div>
											</div>
										</li>
										<li jcarouselindex="8"
											style="float: left; list-style: none outside none;"
											class="jcarousel-item jcarousel-item-horizontal jcarousel-item-8 jcarousel-item-8-horizontal">


											<div data-article="vs_1058" class="b-minicard">

												<div class="bm-discount-label"></div>


												<div class="b-minicard-inner">
													<div class="b-minicard-content">

														<div class="bm-photo">
															<a title="Сковорода Linda VS-1058"
																href="/catalog/vs_1058.html"> <img class="lazy"
																title="Сковорода Linda VS-1058"
																alt="Сковорода Linda VS-1058"
																src="/sharedlibs/images/empty.gif"
																data-original="http://photo.mebelion.ru/images/ac5dd6d3d8aa804b88f740f71a74cb09.jpg"
																id="prodPic1163641">
															</a> <span class="quick-view-open d-popup-open"
																data-dpopup="quick-view" data-article="vs_1058">Быстрый
																просмотр <i class="i i-quick-view"></i>
															</span>

														</div>

														<div class="bm-name">
															<a href="/catalog/vs_1058.html">Сковорода Linda VS-1058</a>
														</div>

														<div class="bm-manufacturer">
															<a href="/brand/Vitesse/">Vitesse</a>
														</div>


														<div class="bm-price">
															<span class="js-price">1 150</span> <span
																class="currency">руб.</span>
														</div>

													</div>

													<div class="bm-hide-info select-group">



														<noindex> <span class="button-v2 add2Cart"
															data-nodeid="1163641" data-article="vs_1058" active="yes"
															data-count="1">Купить</span> </noindex>


													</div>

													<i class="bm-top-left-border"></i>
												</div>
											</div>
										</li>
										<li jcarouselindex="9"
											style="float: left; list-style: none outside none;"
											class="jcarousel-item jcarousel-item-horizontal jcarousel-item-9 jcarousel-item-9-horizontal">


											<div data-article="vs_1728" class="b-minicard">

												<div class="bm-discount-label"></div>


												<div class="b-minicard-inner">
													<div class="b-minicard-content">

														<div class="bm-photo">
															<a title="Набор кухонных ножей Alanala VS-1728"
																href="/catalog/vs_1728.html"> <img class="lazy"
																title="Набор кухонных ножей Alanala VS-1728"
																alt="Набор кухонных ножей Alanala VS-1728"
																src="/sharedlibs/images/empty.gif"
																data-original="http://photo.mebelion.ru/images/4eb4ce3f834ea20b79c6888d29bd686d.jpg"
																id="prodPic839721">
															</a> <span class="quick-view-open d-popup-open"
																data-dpopup="quick-view" data-article="vs_1728">Быстрый
																просмотр <i class="i i-quick-view"></i>
															</span>

														</div>

														<div class="bm-name">
															<a href="/catalog/vs_1728.html">Набор кухонных ножей
																Alanala VS-1728</a>
														</div>

														<div class="bm-manufacturer">
															<a href="/brand/Vitesse/">Vitesse</a>
														</div>


														<div class="bm-price">
															<span class="js-price">3 450</span> <span
																class="currency">руб.</span>
														</div>

													</div>

													<div class="bm-hide-info select-group">



														<noindex> <span class="button-v2 add2Cart"
															data-nodeid="839721" data-article="vs_1728" active="yes"
															data-count="1">Купить</span> </noindex>


													</div>

													<i class="bm-top-left-border"></i>
												</div>
											</div>
										</li>
										<li jcarouselindex="10"
											style="float: left; list-style: none outside none;"
											class="jcarousel-item jcarousel-item-horizontal jcarousel-item-10 jcarousel-item-10-horizontal">


											<div data-article="BL_5171-11" class="b-minicard">

												<div class="bm-discount-label"></div>


												<div class="b-minicard-inner">
													<div class="b-minicard-content">

														<div class="bm-photo">
															<a title="Светильник на штанге Outdoor 5171-11"
																href="/catalog/BL_5171-11.html"> <img class="lazy"
																title="Светильник на штанге Outdoor 5171-11"
																alt="Светильник на штанге Outdoor 5171-11"
																src="/sharedlibs/images/empty.gif"
																data-original="http://photo.mebelion.ru/images/9093c04a67d3b5438588c41699448abe.jpg"
																id="prodPic598213">
															</a> <span class="quick-view-open d-popup-open"
																data-dpopup="quick-view" data-article="BL_5171-11">Быстрый
																просмотр <i class="i i-quick-view"></i>
															</span>

														</div>

														<div class="bm-name">
															<a href="/catalog/BL_5171-11.html">Светильник на штанге
																Outdoor 5171-11</a>
														</div>

														<div class="bm-manufacturer">
															<a href="/brand/blitz/">Blitz</a>
														</div>


														<div class="bm-price">
															<span class="js-price">1 550</span> <span
																class="currency">руб.</span>
														</div>

													</div>

													<div class="bm-hide-info select-group">



														<noindex> <span class="button-v2 add2Cart"
															data-nodeid="598213" data-article="BL_5171-11"
															active="yes" data-count="1">Купить</span> </noindex>


													</div>

													<i class="bm-top-left-border"></i>
												</div>
											</div>
										</li>
										<li jcarouselindex="11"
											style="float: left; list-style: none outside none;"
											class="jcarousel-item jcarousel-item-horizontal jcarousel-item-11 jcarousel-item-11-horizontal">


											<div data-article="ARN_hyper_2" class="b-minicard">

												<div class="bm-discount-label"></div>


												<div class="b-minicard-inner">
													<div class="b-minicard-content">

														<div class="bm-photo">
															<a title="Стол журнальный Hyper 2"
																href="/catalog/ARN_hyper_2.html"> <img class="lazy"
																title="Стол журнальный Hyper 2"
																alt="Стол журнальный Hyper 2"
																src="/sharedlibs/images/empty.gif"
																data-original="http://photo.mebelion.ru/images/200a85f1591f9c9aca39f135e6e6c8ab.jpg"
																id="prodPic1297751">
															</a> <span class="quick-view-open d-popup-open"
																data-dpopup="quick-view" data-article="ARN_hyper_2">Быстрый
																просмотр <i class="i i-quick-view"></i>
															</span>

														</div>

														<div class="bm-name">
															<a href="/catalog/ARN_hyper_2.html">Стол журнальный Hyper
																2</a>
														</div>

														<div class="bm-manufacturer">
															<a href="/brand/glazov/">Глазов</a>
														</div>


														<div class="bm-price">
															<span class="js-price">4 500</span> <span
																class="currency">руб.</span>
														</div>

													</div>

													<div class="bm-hide-info select-group">



														<noindex> <span class="button-v2 add2Cart"
															data-nodeid="1297751" data-article="ARN_hyper_2"
															active="yes" data-count="1">Купить</span> </noindex>


													</div>

													<i class="bm-top-left-border"></i>
												</div>
											</div>
										</li>
										<li jcarouselindex="12"
											style="float: left; list-style: none outside none;"
											class="jcarousel-item jcarousel-item-horizontal jcarousel-item-12 jcarousel-item-12-horizontal">


											<div data-article="NM_Divan_Marsel_2_DI_UB"
												class="b-minicard">

												<div class="bm-discount-label"></div>


												<div class="b-minicard-inner">
													<div class="b-minicard-content">

														<div class="bm-photo">
															<a title="Диван Марсель-2 220"
																href="/catalog/NM_Divan_Marsel_2_DI_UB.html"> <img
																class="lazy" title="Диван Марсель-2 220"
																alt="Диван Марсель-2 220"
																src="/sharedlibs/images/empty.gif"
																data-original="http://photo.mebelion.ru/images/fe525f4d281525359c5a1199d94be5cc.jpg"
																id="prodPic1208041">
															</a> <span class="quick-view-open d-popup-open"
																data-dpopup="quick-view"
																data-article="NM_Divan_Marsel_2_DI_UB">Быстрый просмотр
																<i class="i i-quick-view"></i>
															</span>

														</div>

														<div class="bm-name">
															<a href="/catalog/NM_Divan_Marsel_2_DI_UB.html">Диван
																Марсель-2 220</a>
														</div>

														<div class="bm-manufacturer">
															<a href="/brand/nikologorskaya_mebelnaya_manufaktura/">Никологорские
																мебельные мануфактуры</a>
														</div>


														<div class="bm-price">
															<span class="bm-time-delivery"
																title="срок поставки от 10 дней"><i
																class="i i-time-delivery"></i> от 10 дней</span> <span
																class="js-price">26 000</span> <span class="currency">руб.</span>
														</div>

													</div>

													<div class="bm-hide-info select-group">



														<noindex> <span class="button-v2 add2Cart"
															data-nodeid="1208041"
															data-article="NM_Divan_Marsel_2_DI_UB" active="yes"
															data-count="1">Купить</span> </noindex>


													</div>

													<i class="bm-top-left-border"></i>
												</div>
											</div>
										</li>
										<li jcarouselindex="13"
											style="float: left; list-style: none outside none;"
											class="jcarousel-item jcarousel-item-horizontal jcarousel-item-13 jcarousel-item-13-horizontal">


											<div data-article="vs_1183" class="b-minicard">

												<div class="bm-discount-label"></div>


												<div class="b-minicard-inner">
													<div class="b-minicard-content">

														<div class="bm-photo">
															<a title="Сковорода Carmen VS-1183"
																href="/catalog/vs_1183.html"> <img class="lazy"
																title="Сковорода Carmen VS-1183"
																alt="Сковорода Carmen VS-1183"
																src="/sharedlibs/images/empty.gif"
																data-original="http://photo.mebelion.ru/images/37bd4344f81cb0a8662b05db182734c7.jpg"
																id="prodPic1164061">
															</a> <span class="quick-view-open d-popup-open"
																data-dpopup="quick-view" data-article="vs_1183">Быстрый
																просмотр <i class="i i-quick-view"></i>
															</span>

														</div>

														<div class="bm-name">
															<a href="/catalog/vs_1183.html">Сковорода Carmen VS-1183</a>
														</div>

														<div class="bm-manufacturer">
															<a href="/brand/Vitesse/">Vitesse</a>
														</div>


														<div class="bm-price">
															<span class="js-price">1 350</span> <span
																class="currency">руб.</span>
														</div>

													</div>

													<div class="bm-hide-info select-group">



														<noindex> <span class="button-v2 add2Cart"
															data-nodeid="1164061" data-article="vs_1183" active="yes"
															data-count="1">Купить</span> </noindex>


													</div>

													<i class="bm-top-left-border"></i>
												</div>
											</div>
										</li>
										<li jcarouselindex="14"
											style="float: left; list-style: none outside none;"
											class="jcarousel-item jcarousel-item-horizontal jcarousel-item-14 jcarousel-item-14-horizontal">


											<div data-article="vs_2310" class="b-minicard">

												<div class="bm-discount-label"></div>


												<div class="b-minicard-inner">
													<div class="b-minicard-content">

														<div class="bm-photo">
															<a title="Чайник для заваривания VS-2310"
																href="/catalog/vs_2310.html"> <img class="lazy"
																title="Чайник для заваривания VS-2310"
																alt="Чайник для заваривания VS-2310"
																src="/sharedlibs/images/empty.gif"
																data-original="http://photo.mebelion.ru/images/afc9f5739d2cdd10911eccba99cd2198.jpg"
																id="prodPic1166141">
															</a> <span class="quick-view-open d-popup-open"
																data-dpopup="quick-view" data-article="vs_2310">Быстрый
																просмотр <i class="i i-quick-view"></i>
															</span>

														</div>

														<div class="bm-name">
															<a href="/catalog/vs_2310.html">Чайник для заваривания
																VS-2310</a>
														</div>

														<div class="bm-manufacturer">
															<a href="/brand/Vitesse/">Vitesse</a>
														</div>


														<div class="bm-price">
															<span class="js-price">1 800</span> <span
																class="currency">руб.</span>
														</div>

													</div>

													<div class="bm-hide-info select-group">



														<noindex> <span class="button-v2 add2Cart"
															data-nodeid="1166141" data-article="vs_2310" active="yes"
															data-count="1">Купить</span> </noindex>


													</div>

													<i class="bm-top-left-border"></i>
												</div>
											</div>
										</li>
										<li jcarouselindex="15"
											style="float: left; list-style: none outside none;"
											class="jcarousel-item jcarousel-item-horizontal jcarousel-item-15 jcarousel-item-15-horizontal">


											<div data-article="LUM_G7045" class="b-minicard">

												<div class="bm-discount-label"></div>


												<div class="b-minicard-inner">
													<div class="b-minicard-content">

														<div class="bm-photo">
															<a title="Тарелка для вторых блюд Volare Black G7045"
																href="/catalog/LUM_G7045.html"> <img class="lazy"
																title="Тарелка для вторых блюд Volare Black G7045"
																alt="Тарелка для вторых блюд Volare Black G7045"
																src="/sharedlibs/images/empty.gif"
																data-original="http://photo.mebelion.ru/images/c82576bccb8a832cd8c8e1c4a509d2e6.jpg"
																id="prodPic1191251">
															</a> <span class="quick-view-open d-popup-open"
																data-dpopup="quick-view" data-article="LUM_G7045">Быстрый
																просмотр <i class="i i-quick-view"></i>
															</span>

														</div>

														<div class="bm-name">
															<a href="/catalog/LUM_G7045.html">Тарелка для вторых блюд
																Volare Black G7045</a>
														</div>

														<div class="bm-manufacturer">
															<a href="/brand/Luminarc/">Luminarc</a>
														</div>


														<div class="bm-price">
															<span class="js-price">300</span> <span class="currency">руб.</span>
														</div>

													</div>

													<div class="bm-hide-info select-group">



														<noindex> <span class="button-v2 add2Cart"
															data-nodeid="1191251" data-article="LUM_G7045"
															active="yes" data-count="1">Купить</span> </noindex>


													</div>

													<i class="bm-top-left-border"></i>
												</div>
											</div>
										</li>
										<li jcarouselindex="16"
											style="float: left; list-style: none outside none;"
											class="jcarousel-item jcarousel-item-horizontal jcarousel-item-16 jcarousel-item-16-horizontal">


											<div data-article="LUM_H5543" class="b-minicard">

												<div class="bm-discount-label"></div>


												<div class="b-minicard-inner">
													<div class="b-minicard-content">

														<div class="bm-photo">
															<a title="Тарелка для вторых блюд Flowerfield Red H5543"
																href="/catalog/LUM_H5543.html"> <img class="lazy"
																title="Тарелка для вторых блюд Flowerfield Red H5543"
																alt="Тарелка для вторых блюд Flowerfield Red H5543"
																src="/sharedlibs/images/empty.gif"
																data-original="http://photo.mebelion.ru/images/e93de6a23dc2d7dcba5697c80aebea69.jpg"
																id="prodPic1196911">
															</a> <span class="quick-view-open d-popup-open"
																data-dpopup="quick-view" data-article="LUM_H5543">Быстрый
																просмотр <i class="i i-quick-view"></i>
															</span>

														</div>

														<div class="bm-name">
															<a href="/catalog/LUM_H5543.html">Тарелка для вторых блюд
																Flowerfield Red H5543</a>
														</div>

														<div class="bm-manufacturer">
															<a href="/brand/Luminarc/">Luminarc</a>
														</div>


														<div class="bm-price">
															<span class="js-price">150</span> <span class="currency">руб.</span>
														</div>

													</div>

													<div class="bm-hide-info select-group">



														<noindex> <span class="button-v2 add2Cart"
															data-nodeid="1196911" data-article="LUM_H5543"
															active="yes" data-count="1">Купить</span> </noindex>


													</div>

													<i class="bm-top-left-border"></i>
												</div>
											</div>
										</li>
										<li jcarouselindex="17"
											style="float: left; list-style: none outside none;"
											class="jcarousel-item jcarousel-item-horizontal jcarousel-item-17 jcarousel-item-17-horizontal">


											<div data-article="vs_2321" class="b-minicard">

												<div class="bm-discount-label"></div>


												<div class="b-minicard-inner">
													<div class="b-minicard-content">

														<div class="bm-photo">
															<a title="Ступка с пестиком VS-2321"
																href="/catalog/vs_2321.html"> <img class="lazy"
																title="Ступка с пестиком VS-2321"
																alt="Ступка с пестиком VS-2321"
																src="/sharedlibs/images/empty.gif"
																data-original="http://photo.mebelion.ru/images/4b9f622dad0b314801a9561a09512977.jpg"
																id="prodPic1166301">
															</a> <span class="quick-view-open d-popup-open"
																data-dpopup="quick-view" data-article="vs_2321">Быстрый
																просмотр <i class="i i-quick-view"></i>
															</span>

														</div>

														<div class="bm-name">
															<a href="/catalog/vs_2321.html">Ступка с пестиком VS-2321</a>
														</div>

														<div class="bm-manufacturer">
															<a href="/brand/Vitesse/">Vitesse</a>
														</div>


														<div class="bm-price">
															<span class="js-price">950</span> <span class="currency">руб.</span>
														</div>

													</div>

													<div class="bm-hide-info select-group">



														<noindex> <span class="button-v2 add2Cart"
															data-nodeid="1166301" data-article="vs_2321" active="yes"
															data-count="1">Купить</span> </noindex>


													</div>

													<i class="bm-top-left-border"></i>
												</div>
											</div>
										</li>
										<li jcarouselindex="18"
											style="float: left; list-style: none outside none;"
											class="jcarousel-item jcarousel-item-horizontal jcarousel-item-18 jcarousel-item-18-horizontal">


											<div data-article="TRM_3481-01_met" class="b-minicard">

												<div class="bm-discount-label"></div>


												<div class="b-minicard-inner">
													<div class="b-minicard-content">

														<div class="bm-photo">
															<a title="Стол обеденный Византия 3481-01"
																href="/catalog/TRM_3481-01_met.html"> <img class="lazy"
																title="Стол обеденный Византия 3481-01"
																alt="Стол обеденный Византия 3481-01"
																src="/sharedlibs/images/empty.gif"
																data-original="http://photo.mebelion.ru/images/1f98b94f1b4333812bc7853612697848.jpg"
																id="prodPic1302691">
															</a> <span class="quick-view-open d-popup-open"
																data-dpopup="quick-view" data-article="TRM_3481-01_met">Быстрый
																просмотр <i class="i i-quick-view"></i>
															</span>

														</div>

														<div class="bm-name">
															<a href="/catalog/TRM_3481-01_met.html">Стол обеденный
																Византия 3481-01</a>
														</div>

														<div class="bm-manufacturer">
															<a href="/brand/territoriya_mebeli/">Территория Мебели</a>
														</div>


														<div class="bm-price">
															<span class="js-price">7 850</span> <span
																class="currency">руб.</span>
														</div>

													</div>

													<div class="bm-hide-info select-group">



														<noindex> <span class="button-v2 add2Cart"
															data-nodeid="1302691" data-article="TRM_3481-01_met"
															active="yes" data-count="1">Купить</span> </noindex>


													</div>

													<i class="bm-top-left-border"></i>
												</div>
											</div>
										</li>
										<li jcarouselindex="19"
											style="float: left; list-style: none outside none;"
											class="jcarousel-item jcarousel-item-horizontal jcarousel-item-19 jcarousel-item-19-horizontal">


											<div data-article="SLV_HM_010.27_02" class="b-minicard">

												<div class="bm-discount-label"></div>


												<div class="b-minicard-inner">
													<div class="b-minicard-content">

														<div class="bm-photo">
															<a title="Стенка для гостиной Калипсо"
																href="/catalog/SLV_HM_010.27_02.html"> <img class="lazy"
																title="Стенка для гостиной Калипсо"
																alt="Стенка для гостиной Калипсо"
																src="/sharedlibs/images/empty.gif"
																data-original="http://photo.mebelion.ru/images/7e9ce536c150138c363f6794894aa3f6.jpg"
																id="prodPic1283391">
															</a> <span class="quick-view-open d-popup-open"
																data-dpopup="quick-view" data-article="SLV_HM_010.27_02">Быстрый
																просмотр <i class="i i-quick-view"></i>
															</span>

														</div>

														<div class="bm-name">
															<a href="/catalog/SLV_HM_010.27_02.html">Стенка для
																гостиной Калипсо</a>
														</div>

														<div class="bm-manufacturer">
															<a href="/brand/silva/">Сильва</a>
														</div>


														<div class="bm-price">
															<span class="js-price">14 000</span> <span
																class="currency">руб.</span>
														</div>

													</div>

													<div class="bm-hide-info select-group">



														<noindex> <span class="button-v2 add2Cart"
															data-nodeid="1283391" data-article="SLV_HM_010.27_02"
															active="yes" data-count="1">Купить</span> </noindex>


													</div>

													<i class="bm-top-left-border"></i>
												</div>
											</div>
										</li>
										<li jcarouselindex="20"
											style="float: left; list-style: none outside none;"
											class="jcarousel-item jcarousel-item-horizontal jcarousel-item-20 jcarousel-item-20-horizontal">


											<div data-article="VT_GF6090_00000003467" class="b-minicard">

												<div class="bm-discount-label"></div>


												<div class="b-minicard-inner">
													<div class="b-minicard-content">

														<div class="bm-photo">
															<a title="Коврик для ванной Grass VT_GF6090_00000003467"
																href="/catalog/VT_GF6090_00000003467.html"> <img
																class="lazy"
																title="Коврик для ванной Grass VT_GF6090_00000003467"
																alt="Коврик для ванной Grass VT_GF6090_00000003467"
																src="/sharedlibs/images/empty.gif"
																data-original="http://photo.mebelion.ru/images/c5c9d888e7b84395411c5289afdfbeb0.jpg"
																id="prodPic1161651">
															</a> <span class="quick-view-open d-popup-open"
																data-dpopup="quick-view"
																data-article="VT_GF6090_00000003467">Быстрый просмотр <i
																class="i i-quick-view"></i>
															</span>

														</div>

														<div class="bm-name">
															<a href="/catalog/VT_GF6090_00000003467.html">Коврик для
																ванной Grass VT_GF6090_00000003467</a>
														</div>

														<div class="bm-manufacturer">
															<a href="/brand/Valiant/">Valiant</a>
														</div>


														<div class="bm-price">
															<span class="js-price">850</span> <span class="currency">руб.</span>
														</div>

													</div>

													<div class="bm-hide-info select-group">



														<noindex> <span class="button-v2 add2Cart"
															data-nodeid="1161651"
															data-article="VT_GF6090_00000003467" active="yes"
															data-count="1">Купить</span> </noindex>


													</div>

													<i class="bm-top-left-border"></i>
												</div>
											</div>
										</li>
										<li jcarouselindex="21"
											style="float: left; list-style: none outside none;"
											class="jcarousel-item jcarousel-item-horizontal jcarousel-item-21 jcarousel-item-21-horizontal">


											<div data-article="FRY_TF862-1" class="b-minicard">

												<div class="bm-discount-label"></div>


												<div class="b-minicard-inner">
													<div class="b-minicard-content">

														<div class="bm-photo">
															<a title="Овощерезка TF862-1"
																href="/catalog/FRY_TF862-1.html"> <img class="lazy"
																title="Овощерезка TF862-1" alt="Овощерезка TF862-1"
																src="/sharedlibs/images/empty.gif"
																data-original="http://photo.mebelion.ru/images/68638f925c2ef348e69188e5eb91cdda.jpg"
																id="prodPic820531">
															</a> <span class="quick-view-open d-popup-open"
																data-dpopup="quick-view" data-article="FRY_TF862-1">Быстрый
																просмотр <i class="i i-quick-view"></i>
															</span>

														</div>

														<div class="bm-name">
															<a href="/catalog/FRY_TF862-1.html">Овощерезка TF862-1</a>
														</div>

														<div class="bm-manufacturer">
															<a href="/brand/FryBest/">FryBest</a>
														</div>


														<div class="bm-price">
															<span class="js-price">950</span> <span class="currency">руб.</span>
														</div>

													</div>

													<div class="bm-hide-info select-group">



														<noindex> <span class="button-v2 add2Cart"
															data-nodeid="820531" data-article="FRY_TF862-1"
															active="yes" data-count="1">Купить</span> </noindex>


													</div>

													<i class="bm-top-left-border"></i>
												</div>
											</div>
										</li>
										<li jcarouselindex="22"
											style="float: left; list-style: none outside none;"
											class="jcarousel-item jcarousel-item-horizontal jcarousel-item-22 jcarousel-item-22-horizontal">


											<div data-article="vs_1409" class="b-minicard">

												<div class="bm-discount-label"></div>


												<div class="b-minicard-inner">
													<div class="b-minicard-content">

														<div class="bm-photo">
															<a title="Термос Patty VS-1409"
																href="/catalog/vs_1409.html"> <img class="lazy"
																title="Термос Patty VS-1409" alt="Термос Patty VS-1409"
																src="/sharedlibs/images/empty.gif"
																data-original="http://photo.mebelion.ru/images/c1717a5910869322297c2b5a673d5d8a.jpg"
																id="prodPic818932">
															</a> <span class="quick-view-open d-popup-open"
																data-dpopup="quick-view" data-article="vs_1409">Быстрый
																просмотр <i class="i i-quick-view"></i>
															</span>

														</div>

														<div class="bm-name">
															<a href="/catalog/vs_1409.html">Термос Patty VS-1409</a>
														</div>

														<div class="bm-manufacturer">
															<a href="/brand/Vitesse/">Vitesse</a>
														</div>


														<div class="bm-price">
															<span class="js-price">1 700</span> <span
																class="currency">руб.</span>
														</div>

													</div>

													<div class="bm-hide-info select-group">



														<noindex> <span class="button-v2 add2Cart"
															data-nodeid="818932" data-article="vs_1409" active="yes"
															data-count="1">Купить</span> </noindex>


													</div>

													<i class="bm-top-left-border"></i>
												</div>
											</div>
										</li>
										<li jcarouselindex="23"
											style="float: left; list-style: none outside none;"
											class="jcarousel-item jcarousel-item-horizontal jcarousel-item-23 jcarousel-item-23-horizontal">


											<div data-article="FRT_CB-15" class="b-minicard">

												<div class="bm-discount-label"></div>


												<div class="b-minicard-inner">
													<div class="b-minicard-content">

														<div class="bm-photo">
															<a title="Стенка для гостиной Полонез 1 CB-15"
																href="/catalog/FRT_CB-15.html"> <img class="lazy"
																title="Стенка для гостиной Полонез 1 CB-15"
																alt="Стенка для гостиной Полонез 1 CB-15"
																src="/sharedlibs/images/empty.gif"
																data-original="http://photo.mebelion.ru/images/02294ebdf55c100edd4e5c4b2fbf1ccb.jpg"
																id="prodPic1282081">
															</a> <span class="quick-view-open d-popup-open"
																data-dpopup="quick-view" data-article="FRT_CB-15">Быстрый
																просмотр <i class="i i-quick-view"></i>
															</span>

														</div>

														<div class="bm-name">
															<a href="/catalog/FRT_CB-15.html">Стенка для гостиной
																Полонез 1 CB-15</a>
														</div>

														<div class="bm-manufacturer">
															<a href="/brand/fran/">Фран</a>
														</div>


														<div class="bm-price">
															<span class="js-price">14 000</span> <span
																class="currency">руб.</span>
														</div>

													</div>

													<div class="bm-hide-info select-group">



														<noindex> <span class="button-v2 add2Cart"
															data-nodeid="1282081" data-article="FRT_CB-15"
															active="yes" data-count="1">Купить</span> </noindex>


													</div>

													<i class="bm-top-left-border"></i>
												</div>
											</div>
										</li>
										<li jcarouselindex="24"
											style="float: left; list-style: none outside none;"
											class="jcarousel-item jcarousel-item-horizontal jcarousel-item-24 jcarousel-item-24-horizontal">


											<div data-article="vs_1248" class="b-minicard">

												<div class="bm-discount-label"></div>


												<div class="b-minicard-inner">
													<div class="b-minicard-content">

														<div class="bm-photo">
															<a title="Чайный сервиз Esperanza VS-1248"
																href="/catalog/vs_1248.html"> <img class="lazy"
																title="Чайный сервиз Esperanza VS-1248"
																alt="Чайный сервиз Esperanza VS-1248"
																src="/sharedlibs/images/empty.gif"
																data-original="http://photo.mebelion.ru/images/3b5270694f9921de2f600f74a55dae42.jpg"
																id="prodPic831751">
															</a> <span class="quick-view-open d-popup-open"
																data-dpopup="quick-view" data-article="vs_1248">Быстрый
																просмотр <i class="i i-quick-view"></i>
															</span>

														</div>

														<div class="bm-name">
															<a href="/catalog/vs_1248.html">Чайный сервиз Esperanza
																VS-1248</a>
														</div>

														<div class="bm-manufacturer">
															<a href="/brand/Vitesse/">Vitesse</a>
														</div>


														<div class="bm-price">
															<span class="js-price">3 850</span> <span
																class="currency">руб.</span>
														</div>

													</div>

													<div class="bm-hide-info select-group">



														<noindex> <span class="button-v2 add2Cart"
															data-nodeid="831751" data-article="vs_1248" active="yes"
															data-count="1">Купить</span> </noindex>


													</div>

													<i class="bm-top-left-border"></i>
												</div>
											</div>
										</li>
										<li jcarouselindex="25"
											style="float: left; list-style: none outside none;"
											class="jcarousel-item jcarousel-item-horizontal jcarousel-item-25 jcarousel-item-25-horizontal">


											<div data-article="IL_INL-1052W-02Ch" class="b-minicard">

												<div class="bm-discount-label"></div>


												<div class="b-minicard-inner">
													<div class="b-minicard-content">

														<div class="bm-photo">
															<a title="Бра InLIGHT-1052W INL-1052W-02 Chrome"
																href="/catalog/IL_INL-1052W-02Ch.html"> <img
																class="lazy"
																title="Бра InLIGHT-1052W INL-1052W-02 Chrome"
																alt="Бра InLIGHT-1052W INL-1052W-02 Chrome"
																src="/sharedlibs/images/empty.gif"
																data-original="http://photo.mebelion.ru/images/c93b2dbed6c3c589ff3f4a5687d59ef8.jpg"
																id="prodPic745173">
															</a> <span class="quick-view-open d-popup-open"
																data-dpopup="quick-view"
																data-article="IL_INL-1052W-02Ch">Быстрый просмотр <i
																class="i i-quick-view"></i>
															</span>

														</div>

														<div class="bm-name">
															<a href="/catalog/IL_INL-1052W-02Ch.html">Бра
																InLIGHT-1052W INL-1052W-02 Chrome</a>
														</div>

														<div class="bm-manufacturer">
															<a href="/brand/altalusse/">Altalusse</a>
														</div>


														<div class="bm-price">
															<span class="js-price">5 900</span> <span
																class="currency">руб.</span>
														</div>

													</div>

													<div class="bm-hide-info select-group">



														<noindex> <span class="button-v2 add2Cart"
															data-nodeid="745173" data-article="IL_INL-1052W-02Ch"
															active="yes" data-count="1">Купить</span> </noindex>


													</div>

													<i class="bm-top-left-border"></i>
												</div>
											</div>
										</li>
										<li jcarouselindex="26"
											style="float: left; list-style: none outside none;"
											class="jcarousel-item jcarousel-item-horizontal jcarousel-item-26 jcarousel-item-26-horizontal">


											<div data-article="vs_2033" class="b-minicard">

												<div class="bm-discount-label"></div>


												<div class="b-minicard-inner">
													<div class="b-minicard-content">

														<div class="bm-photo">
															<a title="Кастрюля VS-2033" href="/catalog/vs_2033.html">
																<img class="lazy" title="Кастрюля VS-2033"
																alt="Кастрюля VS-2033"
																src="/sharedlibs/images/empty.gif"
																data-original="http://photo.mebelion.ru/images/0f4a53cba5e0cac832db2cefa76d1991.jpg"
																id="prodPic1165081">
															</a> <span class="quick-view-open d-popup-open"
																data-dpopup="quick-view" data-article="vs_2033">Быстрый
																просмотр <i class="i i-quick-view"></i>
															</span>

														</div>

														<div class="bm-name">
															<a href="/catalog/vs_2033.html">Кастрюля VS-2033</a>
														</div>

														<div class="bm-manufacturer">
															<a href="/brand/Vitesse/">Vitesse</a>
														</div>


														<div class="bm-price">
															<span class="js-price">1 150</span> <span
																class="currency">руб.</span>
														</div>

													</div>

													<div class="bm-hide-info select-group">



														<noindex> <span class="button-v2 add2Cart"
															data-nodeid="1165081" data-article="vs_2033" active="yes"
															data-count="1">Купить</span> </noindex>


													</div>

													<i class="bm-top-left-border"></i>
												</div>
											</div>
										</li>
										<li jcarouselindex="27"
											style="float: left; list-style: none outside none;"
											class="jcarousel-item jcarousel-item-horizontal jcarousel-item-27 jcarousel-item-27-horizontal">


											<div data-article="vs_1755" class="b-minicard">

												<div class="bm-discount-label"></div>


												<div class="b-minicard-inner">
													<div class="b-minicard-content">

														<div class="bm-photo">
															<a title="Набор кухонных ножей VS-1755"
																href="/catalog/vs_1755.html"> <img class="lazy"
																title="Набор кухонных ножей VS-1755"
																alt="Набор кухонных ножей VS-1755"
																src="/sharedlibs/images/empty.gif"
																data-original="http://photo.mebelion.ru/images/2c2d2aa04584044b5bed2724f551afbd.jpg"
																id="prodPic839841">
															</a> <span class="quick-view-open d-popup-open"
																data-dpopup="quick-view" data-article="vs_1755">Быстрый
																просмотр <i class="i i-quick-view"></i>
															</span>

														</div>

														<div class="bm-name">
															<a href="/catalog/vs_1755.html">Набор кухонных ножей
																VS-1755</a>
														</div>

														<div class="bm-manufacturer">
															<a href="/brand/Vitesse/">Vitesse</a>
														</div>


														<div class="bm-price">
															<span class="js-price">1 700</span> <span
																class="currency">руб.</span>
														</div>

													</div>

													<div class="bm-hide-info select-group">



														<noindex> <span class="button-v2 add2Cart"
															data-nodeid="839841" data-article="vs_1755" active="yes"
															data-count="1">Купить</span> </noindex>


													</div>

													<i class="bm-top-left-border"></i>
												</div>
											</div>
										</li>
										<li jcarouselindex="28"
											style="float: left; list-style: none outside none;"
											class="jcarousel-item jcarousel-item-horizontal jcarousel-item-28 jcarousel-item-28-horizontal">


											<div data-article="SLV_HM_010.11" class="b-minicard">

												<div class="bm-discount-label"></div>


												<div class="b-minicard-inner">
													<div class="b-minicard-content">

														<div class="bm-photo">
															<a title="Стенка для гостиной Лагуна НМ 010.11"
																href="/catalog/SLV_HM_010.11.html"> <img class="lazy"
																title="Стенка для гостиной Лагуна НМ 010.11"
																alt="Стенка для гостиной Лагуна НМ 010.11"
																src="/sharedlibs/images/empty.gif"
																data-original="http://photo.mebelion.ru/images/0d7910b09cc0cf4aa42486af970c0320.jpg"
																id="prodPic1283241">
															</a> <span class="quick-view-open d-popup-open"
																data-dpopup="quick-view" data-article="SLV_HM_010.11">Быстрый
																просмотр <i class="i i-quick-view"></i>
															</span>

														</div>

														<div class="bm-name">
															<a href="/catalog/SLV_HM_010.11.html">Стенка для гостиной
																Лагуна НМ 010.11</a>
														</div>

														<div class="bm-manufacturer">
															<a href="/brand/silva/">Сильва</a>
														</div>


														<div class="bm-price">
															<span class="js-price">26 550</span> <span
																class="currency">руб.</span>
														</div>

													</div>

													<div class="bm-hide-info select-group">



														<noindex> <span class="button-v2 add2Cart"
															data-nodeid="1283241" data-article="SLV_HM_010.11"
															active="yes" data-count="1">Купить</span> </noindex>


													</div>

													<i class="bm-top-left-border"></i>
												</div>
											</div>
										</li>
										<li jcarouselindex="29"
											style="float: left; list-style: none outside none;"
											class="jcarousel-item jcarousel-item-horizontal jcarousel-item-29 jcarousel-item-29-horizontal">


											<div data-article="LUM_G5491" class="b-minicard">

												<div class="bm-discount-label"></div>


												<div class="b-minicard-inner">
													<div class="b-minicard-content">

														<div class="bm-photo">
															<a title="Декантер Versailles G5491"
																href="/catalog/LUM_G5491.html"> <img class="lazy"
																title="Декантер Versailles G5491"
																alt="Декантер Versailles G5491"
																src="/sharedlibs/images/empty.gif"
																data-original="http://photo.mebelion.ru/images/89b891153cfa724067f4ac3751d953b8.jpg"
																id="prodPic1189571">
															</a> <span class="quick-view-open d-popup-open"
																data-dpopup="quick-view" data-article="LUM_G5491">Быстрый
																просмотр <i class="i i-quick-view"></i>
															</span>

														</div>

														<div class="bm-name">
															<a href="/catalog/LUM_G5491.html">Декантер Versailles
																G5491</a>
														</div>

														<div class="bm-manufacturer">
															<a href="/brand/Luminarc/">Luminarc</a>
														</div>


														<div class="bm-price">
															<span class="js-price">1 350</span> <span
																class="currency">руб.</span>
														</div>

													</div>

													<div class="bm-hide-info select-group">



														<noindex> <span class="button-v2 add2Cart"
															data-nodeid="1189571" data-article="LUM_G5491"
															active="yes" data-count="1">Купить</span> </noindex>


													</div>

													<i class="bm-top-left-border"></i>
												</div>
											</div>
										</li>
										<li jcarouselindex="30"
											style="float: left; list-style: none outside none;"
											class="jcarousel-item jcarousel-item-horizontal jcarousel-item-30 jcarousel-item-30-horizontal">


											<div data-article="MW_228020901" class="b-minicard">

												<div class="bm-discount-label"></div>


												<div class="b-minicard-inner">
													<div class="b-minicard-content">

														<div class="bm-photo">
															<a title="Бра Космос 1 228020901"
																href="/catalog/MW_228020901.html"> <img class="lazy"
																title="Бра Космос 1 228020901"
																alt="Бра Космос 1 228020901"
																src="/sharedlibs/images/empty.gif"
																data-original="http://photo.mebelion.ru/images/d4475876c7503f85f263cb62ca74d8df.jpg"
																id="prodPic815243">
															</a> <span class="quick-view-open d-popup-open"
																data-dpopup="quick-view" data-article="MW_228020901">Быстрый
																просмотр <i class="i i-quick-view"></i>
															</span>

														</div>

														<div class="bm-name">
															<a href="/catalog/MW_228020901.html">Бра Космос 1
																228020901</a>
														</div>

														<div class="bm-manufacturer">
															<a href="/brand/mv-Light/">MW-Light</a>
														</div>


														<div class="bm-price">
															<span class="js-price">860</span> <span class="currency">руб.</span>
														</div>

													</div>

													<div class="bm-hide-info select-group">



														<noindex> <span class="button-v2 add2Cart"
															data-nodeid="815243" data-article="MW_228020901"
															active="yes" data-count="1">Купить</span> </noindex>


													</div>

													<i class="bm-top-left-border"></i>
												</div>
											</div>
										</li>






									</ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="div_products_carousel same">
                </div>
            </div>
        </div>
        
        
        
        
        
        
        
        
    </div>
    <footer class="l-footer"></footer>
</div>
<span class="to-top"></span>

{*
{if !empty($header)}{$header}{/if}
        
{if isset($top)}{$top}{/if}
	
<div class="lpart"> 
    
    {if isset($left)}{$left}{/if}

</div>
<div class="rpart">
            
	{if isset($center)}{$center}{/if}
		
</div>
		
<div class="linesold"></div>
    {if isset($bottom)}{$bottom}{/if}
    {if !empty($footer)}{$footer}{/if}
		
			
</div>
</div>
*}
</body>
</html>
{/strip}