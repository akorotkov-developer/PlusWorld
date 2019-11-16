document.addEventListener('DOMContentLoaded', function() {
    // JS height equal: start
    function equalHeight(group) {
        let tallest = 0;
        group.each(function()
        {
            let thisHeight = jQuery(this).height();
            if(thisHeight > tallest) { tallest = thisHeight; } });
        group.height(tallest);
    }
    $(document).ready(function(){
        equalHeight(jQuery(".page-preview__image"));
    });
    // JS height equal: finish
});

function atoprint(f){
    var e=document.getElementById(f).innerHTML;var c=window.document.title;var a=window.document.location;var b=open("");b.document.open();
    b.document.writeln(
        '<html><head><title>Версия для печати</title></head>' +
        '<body text="#000000" bgcolor="#FFFFFF">' +
        '<style>' +
        '.hide-for-print {display: none;}' +
        '.full_access {height: 500px;overflow: hidden;}' +
        '.full_access-box:before {width: 100%;height: 55px; content: ""; display: block; margin-top: -50px; position: relative;background: linear-gradient(to top, rgba(255, 255, 255, 1), rgba(255, 255, 255, 0.1));}' +
        '.full_access-box-box {border:2px solid #ccc;padding: 20px 10px 30px 10px;margin-top: 10px;display: inline-block;width: 98%;}' +
        '.full_access-title {font-size: 24px!important;text-align: center;text-decoration: none;text-transform: none!important;border-bottom: none!important;line-height: 26px!important;margin-top: 10px;}' +
        '.full_access-item {width: 25%;margin: 0 1.5%;float: left;padding: 2.5%;text-align: center;background-color: #d7d8d8;margin-top: 10px;}' +
        '.full_access-item2 {width: 41.5%;margin: 0 1.5%;float: left;padding: 2.5%;text-align: center;background-color: #d7d8d8;margin-top: 10px;}' +
        '.full_access-desc {font-size: 15px;line-height: 22px;color: #666;}' +
        '.full_access-price {font-size: 22px;line-height: 36px;color: #000;}' +
        '.full_access-link { background-image: none!important;background: url("images/header_14_127.png") repeat-x top #ae1a49;width: 100%;display: inline-block;height: 30px;line-height: 30px;color: #fff;padding-left: 0!important;}' +
        '.full_access-desc-small{text-align: center;font-size: 14px;line-height: 22px;color: #666;}' +
        '.js_new-site-show-more {cursor: pointer;text-align: center;color: #1b84d0;opacity: 0.7;font-size: 18px;width: 150px;margin: 10px auto;display: block;}' +
        '</style>' +
        '<div onselectstart="return false;" oncopy="return false;">');
    b.document.writeln('<div style="margin-bottom:5px;"><a href="javascript://" onclick="window.print();">Печать</a> • <a href="javascript://" onclick="window.close();">Закрыть окно</a></div>');
    b.document.writeln("<hr>");
    b.document.writeln('<p><img hspace="10" align="left" width="200" src="/bitrix/templates/info_light_green_copy/images/logo_print.jpg">117218, Москва <br />Ул. Кржижановского, д.29, к.5, офис 2-20 <br />Tel.: +7 495 961 10 65 <br />Fax: +7 495 988 37 30<br />E-mail: <a href="mailto:marketing@plusworld.ru">marketing@plusworld.ru</a></p>');
    b.document.writeln("<br><hr>");b.document.writeln("<h1>"+c+"</h1>");b.document.writeln(e);b.document.writeln('<div style="font-size:8pt;">Страница материала: '+a+"</div>");b.document.writeln('<div style="margin-top:5px;"><a href="javascript://" onclick="window.print();">Печать</a> • <a href="javascript://" onclick="window.close();">Закрыть окно</a></div>');
    b.document.writeln("</div></body></html>");
    b.document.close()
};

//Убираем внешние ссылки
$(function(){
    var arrLinks = [0,
        "http://test2.ru/",
        "http://test.ru/",
    ];

    $('a').each(function() {
        var a = new RegExp('/' + window.location.host + '/');
        var e = /([-a-zA-Z0-9@:%_\+.~#?&\/\/=]{2,256}\.[a-z]{2,4}\b(\/?[-a-zA-Z0-9@:%_\+.~#?&\/\/=]*)?)/gi
        var b = new RegExp(e);

        if (this.href && b.test(this.href) && !a.test(this.href)) {
            if ($.inArray(this.href, arrLinks) < 1) {
                $(this).attr("rel", "nofollow noopener noreferrer");
            }
        }
    });
});

$( document ).ready(function() {
    //$('meta[property="og:description"]').remove();

    $(document).foundation();

    /*Мобильное меню*/
/*    var $mobile_menu_btn = $('#mobile_menu_btn');
    var $mobile_menu_pop = $("#mobile_menu_pop");
    var $other_content = $("#other_content");
    var $scrols_panels = $('.scroll-pane,body');

    $mobile_menu_btn.click(function () {
        $scrols_panels.addClass('overflow-hidden');
        $mobile_menu_btn.addClass('mobile_menu_opened');
        $mobile_menu_pop.fadeIn(500);
        $other_content.fadeOut(0);
    });

    $('#mobile_menu_close_btn').click(function () {
        $scrols_panels.removeClass('overflow-hidden');
        $mobile_menu_btn.removeClass('mobile_menu_opened');
        $other_content.fadeIn(0);
        $mobile_menu_pop.fadeOut(500);
    });*/
});

/*Меню для мобильной версии*/
$( document ).ready(function() {
    $('#mobile_menu_close_btn').on('click', function() {
        //$("#mobile_menu_pop").hide("fast");
        $("#mobile_menu_pop").css({"display": "none"});
    });
    $('.header__toggle').on('click', function() {
       // $("#mobile_menu_pop").show("fast");
        $("#mobile_menu_pop").css({"display": "block"});
    });
    $('a[data-open=login-form]').on('click', function() {
        $("#mobile_menu_pop").hide();
    });

    var $mobile_menu = $(document).find('#menu-glavnoe-menyu-mobilnoe.top__list_mobile'),
        $el_have_children  = $mobile_menu.find('li.menu-item-has-children > a');

    if ($el_have_children.length) {
        $el_have_children.each(function () {
            var $that = $(this);
            var $li = $that.parents('li.menu-item-has-children');
            $that.on('click',function (e) {
                if ($li.hasClass('reverce_ico')) {
                    e.preventDefault();
                    $(document).find('#menu-glavnoe-menyu-mobilnoe.top__list_mobile .menu-item-has-children.reverce_ico').find('.sub-menu').hide(500);
                    $(document).find('#menu-glavnoe-menyu-mobilnoe.top__list_mobile .menu-item-has-children.reverce_ico').removeClass('reverce_ico ');

                    return false;
                } else {
                    e.preventDefault();
                    $(document).find('#menu-glavnoe-menyu-mobilnoe.top__list_mobile .menu-item-has-children.reverce_ico').find('.sub-menu').hide(500);
                    $(document).find('#menu-glavnoe-menyu-mobilnoe.top__list_mobile .menu-item-has-children.reverce_ico').removeClass('reverce_ico ');

                    $li.addClass('reverce_ico');
                    $li.find('.sub-menu').show(500);

                    //устраняем баг со сдвигом меню  ,если закрывается верхнее меню автоматом , и нижнее уезжает вверх .
                    $(document).find('#mobile_menu_pop').animate({scrollTop: $li.offset().top - $li.height() / 2}, 50);
                    return false;
                }
            });
        });

        $el_have_children.dblclick(function (e) {
            var $link = $(this);
//         console.info($link.attr('href'));
            document.location.href = $link.attr('href');
        });
    }
});


/* global screenReaderText */
/**
 * Theme functions file.
 *
 * Contains handlers for navigation and widget area.
 */

( function( $ ) {
    var body, masthead, menuToggle, siteNavigation, socialNavigation, siteHeaderMenu, resizeTimer;

    function initMainNavigation( container ) {

        // Add dropdown toggle that displays child menu items.
        var dropdownToggle = $( '<button />', {
            'class': 'dropdown-toggle',
            'aria-expanded': false
        } ).append( $( '<span />', {
            'class': 'screen-reader-text',
            text: 'screenReaderText.expand'
        } ) );

        container.find( '.menu-item-has-children > a' ).after( dropdownToggle );

        // Toggle buttons and submenu items with active children menu items.
        container.find( '.current-menu-ancestor > button' ).addClass( 'toggled-on' );
        container.find( '.current-menu-ancestor > .sub-menu' ).addClass( 'toggled-on' );

        // Add menu items with submenus to aria-haspopup="true".
        container.find( '.menu-item-has-children' ).attr( 'aria-haspopup', 'true' );

        container.find( '.dropdown-toggle' ).click( function( e ) {
            var _this            = $( this ),
                screenReaderSpan = _this.find( '.screen-reader-text' );

            e.preventDefault();
            _this.toggleClass( 'toggled-on' );
            _this.next( '.children, .sub-menu' ).toggleClass( 'toggled-on' );

            // jscs:disable
            _this.attr( 'aria-expanded', _this.attr( 'aria-expanded' ) === 'false' ? 'true' : 'false' );
            // jscs:enable
            screenReaderSpan.text( screenReaderSpan.text() === screenReaderText.expand ? screenReaderText.collapse : screenReaderText.expand );
        } );
    }
    initMainNavigation( $( '.main-navigation' ) );

    masthead         = $( '#masthead' );
    menuToggle       = masthead.find( '#menu-toggle' );
    siteHeaderMenu   = masthead.find( '#site-header-menu' );
    siteNavigation   = masthead.find( '#site-navigation' );
    socialNavigation = masthead.find( '#social-navigation' );

    // Enable menuToggle.
    ( function() {

        // Return early if menuToggle is missing.
        if ( ! menuToggle.length ) {
            return;
        }

        // Add an initial values for the attribute.
        menuToggle.add( siteNavigation ).add( socialNavigation ).attr( 'aria-expanded', 'false' );

        menuToggle.on( 'click.twentysixteen', function() {
            $( this ).add( siteHeaderMenu ).toggleClass( 'toggled-on' );

            // jscs:disable
            $( this ).add( siteNavigation ).add( socialNavigation ).attr( 'aria-expanded', $( this ).add( siteNavigation ).add( socialNavigation ).attr( 'aria-expanded' ) === 'false' ? 'true' : 'false' );
            // jscs:enable
        } );
    } )();

    // Fix sub-menus for touch devices and better focus for hidden submenu items for accessibility.
    ( function() {
        if ( ! siteNavigation.length || ! siteNavigation.children().length ) {
            return;
        }

        // Toggle `focus` class to allow submenu access on tablets.
        function toggleFocusClassTouchScreen() {
            if ( window.innerWidth >= 910 ) {
                $( document.body ).on( 'touchstart.twentysixteen', function( e ) {
                    if ( ! $( e.target ).closest( '.main-navigation li' ).length ) {
                        $( '.main-navigation li' ).removeClass( 'focus' );
                    }
                } );
                siteNavigation.find( '.menu-item-has-children > a' ).on( 'touchstart.twentysixteen', function( e ) {
                    var el = $( this ).parent( 'li' );

                    if ( ! el.hasClass( 'focus' ) ) {
                        e.preventDefault();
                        el.toggleClass( 'focus' );
                        el.siblings( '.focus' ).removeClass( 'focus' );
                    }
                } );
            } else {
                siteNavigation.find( '.menu-item-has-children > a' ).unbind( 'touchstart.twentysixteen' );
            }
        }

        if ( 'ontouchstart' in window ) {
            $( window ).on( 'resize.twentysixteen', toggleFocusClassTouchScreen );
            toggleFocusClassTouchScreen();
        }

        siteNavigation.find( 'a' ).on( 'focus.twentysixteen blur.twentysixteen', function() {
            $( this ).parents( '.menu-item' ).toggleClass( 'focus' );
        } );
    } )();

    // Add the default ARIA attributes for the menu toggle and the navigations.
    function onResizeARIA() {
        if ( window.innerWidth < 910 ) {
            if ( menuToggle.hasClass( 'toggled-on' ) ) {
                menuToggle.attr( 'aria-expanded', 'true' );
            } else {
                menuToggle.attr( 'aria-expanded', 'false' );
            }

            if ( siteHeaderMenu.hasClass( 'toggled-on' ) ) {
                siteNavigation.attr( 'aria-expanded', 'true' );
                socialNavigation.attr( 'aria-expanded', 'true' );
            } else {
                siteNavigation.attr( 'aria-expanded', 'false' );
                socialNavigation.attr( 'aria-expanded', 'false' );
            }

            menuToggle.attr( 'aria-controls', 'site-navigation social-navigation' );
        } else {
            menuToggle.removeAttr( 'aria-expanded' );
            siteNavigation.removeAttr( 'aria-expanded' );
            socialNavigation.removeAttr( 'aria-expanded' );
            menuToggle.removeAttr( 'aria-controls' );
        }
    }

    // Add 'below-entry-meta' class to elements.
    function belowEntryMetaClass( param ) {
        if ( body.hasClass( 'page' ) || body.hasClass( 'search' ) || body.hasClass( 'single-attachment' ) || body.hasClass( 'error404' ) ) {
            return;
        }

        $( '.entry-content' ).find( param ).each( function() {
            var element              = $( this ),
                elementPos           = element.offset(),
                elementPosTop        = elementPos.top,
                entryFooter          = element.closest( 'article' ).find( '.entry-footer' ),
                entryFooterPos       = entryFooter.offset(),
                entryFooterPosBottom = entryFooterPos.top + ( entryFooter.height() + 28 ),
                caption              = element.closest( 'figure' ),
                newImg;

            // Add 'below-entry-meta' to elements below the entry meta.
            if ( elementPosTop > entryFooterPosBottom ) {

                // Check if full-size images and captions are larger than or equal to 840px.
                if ( 'img.size-full' === param ) {

                    // Create an image to find native image width of resized images (i.e. max-width: 100%).
                    newImg = new Image();
                    newImg.src = element.attr( 'src' );

                    $( newImg ).on( 'load.twentysixteen', function() {
                        if ( newImg.width >= 840  ) {
                            element.addClass( 'below-entry-meta' );

                            if ( caption.hasClass( 'wp-caption' ) ) {
                                caption.addClass( 'below-entry-meta' );
                                caption.removeAttr( 'style' );
                            }
                        }
                    } );
                } else {
                    element.addClass( 'below-entry-meta' );
                }
            } else {
                element.removeClass( 'below-entry-meta' );
                caption.removeClass( 'below-entry-meta' );
            }
        } );
    }

    $( document ).ready( function() {
        body = $( document.body );

        $( window )
            .on( 'load.twentysixteen', onResizeARIA )
            .on( 'resize.twentysixteen', function() {
                clearTimeout( resizeTimer );
                resizeTimer = setTimeout( function() {
                    belowEntryMetaClass( 'img.size-full' );
                    belowEntryMetaClass( 'blockquote.alignleft, blockquote.alignright' );
                }, 300 );
                onResizeARIA();
            } );

        belowEntryMetaClass( 'img.size-full' );
        belowEntryMetaClass( 'blockquote.alignleft, blockquote.alignright' );
    } );
} )( jQuery );
