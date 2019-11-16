;
$(document).foundation();

(function($) {
  "use strict";
  $(function() {
    //begin of fix equalizer
    if ($('*').has('[data-equalizer]').length) {
      setTimeout(function() {

        Foundation.reInit('equalizer');

      }, 1000);
    }

    //end of fix equalizer
    //begin of .news__item js-hover
    $('.news__item').mouseenter(function() {
      $(this).find('.news__link').addClass('js-hover');
    }).mouseleave(function() {
      $(this).find('.news__link').removeClass('js-hover');
    });
    //end of .news__item js-hover
    //begin of marquee plugin

    $('.header__marquee').marquee({
      duration: 60000,
      pauseOnHover: true,
      duplicated: true,
      startVisible: true
    });
    //end of marquee plugin
    //begin of equalize .js-head-height
    function setHeight() {


      $('.js-head-height').css('height', 'auto');
      var maxHeight2 = Math.max.apply(null, $(".js-head-height").map(function() {
        return $(this).height();
      }).get());
      $('.js-head-height').height(maxHeight2);


    }
    $(window).on('load', function() {

      setHeight();
    });
    $(window).on('resize', function() {

      setHeight();
    });
    //end of equalize .js-head-height

    //begin of .slide-events slider
    $(".slide-events").slick({
      infinite: true,
      dots: false,
      arrows: true,
      slidesToShow: 5,
      slidesToScroll: 5,
      autoplay: false,
      prevArrow: '<div class="slick-prev"><svg class="svg-icon" viewBox="0 0 19 19"><path d="M2.8,19h3.8l9.6-9.5L6.6,0H2.8l9.6,9.5L2.8,19z"/></svg></div>',
      nextArrow: '<div class="slick-next"><svg class="svg-icon" viewBox="0 0 19 19"><path d="M2.8,19h3.8l9.6-9.5L6.6,0H2.8l9.6,9.5L2.8,19z"/></svg></div>',
      responsive: [{
          breakpoint: 1200,
          settings: {
            slidesToShow: 4,
            arrows: false,
            slidesToScroll: 4,
            dots: true
          }
        },
        {
          breakpoint: 700,
          settings: {
            slidesToShow: 3,
            arrows: false,
            slidesToScroll: 3,
            dots: true
          }
        },
        {
          breakpoint: 550,
          settings: {
            slidesToShow: 2,
            slidesToScroll: 2,
            arrows: false,
            dots: true
          }
        },
        {
          breakpoint: 400,
          settings: {
            slidesToShow: 1,
            slidesToScroll: 1,
            arrows: false,
            dots: true
          }
        }
        // You can unslick at a given breakpoint now by adding:
        // settings: "unslick"
        // instead of a settings object
      ]
    });

    //begin of .currency slider
    $(".currency").slick({
      infinite: true,
      dots: false,
      arrows: true,
      slidesToShow: 1,
      slidesToScroll: 1,
      autoplay: false,
      autoplaySpeed: 5000,
      autoplayHoverPause: true,
      fade: false,
      swipeToSlide: true,
      prevArrow: '<div class="slick-prev"><svg class="svg-icon" viewBox="0 0 19 19"><path d="M2.8,19h3.8l9.6-9.5L6.6,0H2.8l9.6,9.5L2.8,19z"/></svg></div>',
      nextArrow: '<div class="slick-next"><svg class="svg-icon" viewBox="0 0 19 19"><path d="M2.8,19h3.8l9.6-9.5L6.6,0H2.8l9.6,9.5L2.8,19z"/></svg></div>'
    });
    //end of .currency slider
    //begin of .market slider
    $(".market").slick({
      infinite: true,
      dots: true,
      arrows: true,
      slidesToShow: 1,
      slidesToScroll: 1,
      autoplay: false,
      autoplaySpeed: 5000,
      autoplayHoverPause: true,
      fade: false,
      swipeToSlide: true,
      prevArrow: '<div class="slick-prev"><svg class="svg-icon" viewBox="0 0 19 19"><path d="M2.8,19h3.8l9.6-9.5L6.6,0H2.8l9.6,9.5L2.8,19z"/></svg></div>',
      nextArrow: '<div class="slick-next"><svg class="svg-icon" viewBox="0 0 19 19"><path d="M2.8,19h3.8l9.6-9.5L6.6,0H2.8l9.6,9.5L2.8,19z"/></svg></div>'
    });
    //end of .market slider
    /**
     * Разные карусели
     */
    $(".x-carousel-main").slick({
      infinite: true,
      dots: false,
      arrows: true,
      slidesPerRow: 1,
      slidesToShow: 1,
      slidesToScroll: 1,
      autoplay: true,
      autoplaySpeed: 5000,
      autoplayHoverPause: true,
      fade: true,
      swipeToSlide: true,
      prevArrow: '<span><i class="slick-prev fas fa-angle-left fa-4x"> </i></span>',
      nextArrow: '<span><i class="slick-next fas fa-angle-right fa-4x"> </i></span>'
    });

    $(".x-carousel-services").slick({
      infinite: true,
      dots: true,
      arrows: false,
      slidesPerRow: 1,
      slidesToShow: 1,
      slidesToScroll: 1,
      autoplay: true,
      autoplaySpeed: 5000,
      autoplayHoverPause: true
    });

    // special projects slider
    if ($(".special-projects_3th").length) {
      $(".special-projects").slick({
        infinite: true,
        dots: false,
        arrows: true,
        prevArrow: '<button class="special-projects__button slick-prev"><svg class="svg-icon" viewBox="0 0 19 19"><path d="M2.8,19h3.8l9.6-9.5L6.6,0H2.8l9.6,9.5L2.8,19z"/></svg></button>',
        nextArrow: '<button class="special-projects__button slick-next"><svg class="svg-icon" viewBox="0 0 19 19"><path d="M2.8,19h3.8l9.6-9.5L6.6,0H2.8l9.6,9.5L2.8,19z"/></svg></button>',
        slidesPerRow: 1,
        slidesToShow: 3,
        slidesToScroll: 1,
        autoplay: true,
        autoplaySpeed: 5000,
        autoplayHoverPause: true,
        variableWidth: true
      });
    } else {
      $(".special-projects").slick({
        infinite: true,
        dots: false,
        arrows: true,
        prevArrow: '<button class="special-projects__button slick-prev"><svg class="svg-icon" viewBox="0 0 19 19"><path d="M2.8,19h3.8l9.6-9.5L6.6,0H2.8l9.6,9.5L2.8,19z"/></svg></button>',
        nextArrow: '<button class="special-projects__button slick-next"><svg class="svg-icon" viewBox="0 0 19 19"><path d="M2.8,19h3.8l9.6-9.5L6.6,0H2.8l9.6,9.5L2.8,19z"/></svg></button>',
        customPaging: '10px',
        slidesPerRow: 1,
        slidesToShow: 4,
        slidesToScroll: 1,
        autoplay: true,
        autoplaySpeed: 5000,
        autoplayHoverPause: true,
        variableWidth: true
      });
    }

    $(".x-carousel-news").slick({
      infinite: true,
      arrows: false,
      slidesPerRow: 1,
      slidesToShow: 1,
      slidesToScroll: 1,
      fade: true,
      swipeToSlide: true,
      autoplay: true,
      autoplaySpeed: 7000,
      autoplayHoverPause: true
    });
    $('.x-carousel-news-link').on('click', function(e) {

      e.preventDefault();
      var $this = $(this),
        index = $this.closest('.x-carousel-news-links').find('.x-carousel-news-link').index($this);
      $('.x-carousel-news').slick('slickGoTo', index);
    });

    /**
     * Показ любого блока по наведению на другой
     */
    var toggleLeaveTimer;
    $('[data-toggle-hover-dd]').on('mouseenter mouseleave', function(e) {
      var selector = '#' + $(this).data('toggle-hover-dd');
      if ($(selector).length > 0) {
        var $toggler = $(selector);
        var className = $toggler.data('toggler-hover-dd');
        if (e.type == 'mouseenter' && !$toggler.hasClass(className)) {
          $toggler.addClass(className)
        }
        if (e.type == 'mouseleave' && $toggler.hasClass(className)) {
          toggleLeaveTimer = setTimeout(function() {
            $toggler.removeClass(className)
          }, 300);
        }
      }
    });
    $('[data-toggler-hover-dd]').on('mouseenter', function() {
      clearTimeout(toggleLeaveTimer);
    }).on('mouseleave', function() {
      var $toggler = $(this);
      var className = $toggler.data('toggler-hover-dd');
      if ($toggler.hasClass(className)) {
        toggleLeaveTimer = setTimeout(function() {
          $toggler.removeClass(className)
        }, 300);
      }
    });

    // change width for .drop_full
    function changeWidth() {
      var width = $(window).width();

      $('.drop_full').width((width - 100));

      if ($(window).width() < 640) {
        $('.drop_full').width(200);
      }
    }

    changeWidth();

    $(window).on('resize', function() {
      changeWidth();
    });

    $(".form-close").on("click", function() {
      $(".reveal-overlay").trigger("click");
    });

    //Форма подписки после прокрутки сайдбара
    var $widthWindow = $(window).width(),
      $widthContent = $(".page-content .grid-container").innerWidth(),
      $rightpos = ((($widthWindow - $widthContent) / 2) + 9).toFixed();

    var target = $('.lastblock_on_sidebar');
    if (target.length > 0) {
      var targetPos = target.offset().top;
    }
    var winHeight = $(window).height();
    var scrollToElem = targetPos + $(window).height();
    $(window).scroll(function() {
      var winScrollTop = $(this).scrollTop();

      if (winScrollTop > scrollToElem - 50) {
        //$(".float-subcribe").show("fast");

        $(".subscribe-block").addClass("float-subcribe");
        $(".subscribe-block").css({
          "right": $rightpos,
          "width": $(".subscribe-block-width").innerWidth()
        });

      } else {
        //$(".float-subcribe").hide("fast");
        $(".subscribe-block").removeClass("float-subcribe");
      }
    });
    /***************/

    /*Закрыть poppup окно крестиком*/
    if ($('.popup_close img').length > 0) {
      $(".popup_close img").on('click', function() {
        $(".popup-window-overlay").trigger('click');
        $(".reveal-overlay").trigger('click');
      });
    }
    if ($('.popup_close_forgot_password img').length > 0) {
      $(".popup_close_forgot_password img").on('click', function() {
        $(".link_forgot-password-hidden").trigger('click');
      });
    }

    /*Поиск на мобильной версии сайта в шапке*/
    $(".search-button-inmobilemenu").on('click', function() {
      $(".search-button-inmobilemenu").hide();
      $(".header__toggle").hide();
      $(".close-mobilesearch").show();
      $(".search-top_mobileblock").show();
    });
    $(".close-mobilesearch").on('click', function() {
      $(".search-button-inmobilemenu").show();
      $(".header__toggle").show();
      $(".close-mobilesearch").hide();
      $(".search-top_mobileblock").hide();
    });

  });
})(jQuery);
