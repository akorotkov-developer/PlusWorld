<? use Plusworld\Config;

if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
IncludeTemplateLangFile(__FILE__);
?>

    <footer class="footer">
        <div class="grid-container text-center medium-text-left">
            <div class="grid-x grid-padding-x">
                <div class="cell large-7 medium-15"><a class="footer__logo" href="#"><img src="./images/logo.svg" alt=""></a><a class="footer__soc" href="#"><i class="fab fa-facebook-f" data-fa-transform="shrink-6 " data-fa-mask="fas fa-circle"></i></a><a class="footer__soc" href="#"><i class="fab fa-twitter" data-fa-transform="shrink-8 " data-fa-mask="fas fa-circle"></i></a><a class="footer__soc" href="#"><i class="fab fa-telegram-plane" data-fa-transform="shrink-6 " data-fa-mask="fas fa-circle"></i></a><a class="footer__soc" href="#"><i class="fas fa-rss" data-fa-transform="shrink-9 " data-fa-mask="fas fa-circle"></i></a></div>
                <div class="cell large-13 medium-order-3 large-order-2">
                    <div class="footer__wait">Ждем ваших материалов по адресу <a class="footer__mail" href="mailto:news@plusworld.ru">news@plusworld.ru</a></div>
                    <div class="footer__row"><a class="footer__link" target="_blank" href="http://cetera.ru/">Создание сайтов — Cetera Labs</a><a class="footer__link" target="_blank" href="#">Политика конфиденциальности</a><a class="footer__link" target="_blank" href="http://www.cetera.ru/support/default.php?project=CCD&amp;lang=ru&amp;page=http://wireframes.cetera.ru/boilerplate_wireframe/">Сообщить об ошибке</a></div>
                    <div class="margin-bottom-2">Copyright © 2012-2017 Retail-Loyalty.org. Все права защищены</div>
                    <div class="margin-bottom-2">Зарегистрировано Федеральной службой по надзору в сфере связи, информационных технологий и массовых коммуникаций. Свидетельства о регистрации ЭЛ № ФС77 — 70419 от 20 июля 2017 года.  </div>
                </div>
                <div class="cell large-4 padding-top-1 medium-order-2 large-order-3 medium-9"><a class="footer__menu" href="#">о портале</a><a class="footer__menu" href="#">реклама</a><a class="footer__menu" href="#">контакты</a></div>
            </div>
        </div>
    </footer>

    </body>
    </html>

<?
require($_SERVER['DOCUMENT_ROOT'] . Plusworld\Config::PLUSWORLD_TEMPLATE_PATH . '/footer.php');
?>