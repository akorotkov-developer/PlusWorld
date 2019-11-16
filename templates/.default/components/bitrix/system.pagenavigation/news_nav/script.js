$( document ).ready(function() {
    let pages = $( "li.newsnav_li" ).toArray();

    drawNavigation();

    function drawNavigation() {
        if ($(document).width() < 959) {
            if ($(pages[pages.length - 3]).html() == "...") {
                $(pages[pages.length - 4]).hide();
                $(pages[pages.length - 5]).hide();
                $('.pagination li').css({"width": "11%"});
            }
            if ($(pages[2]).html() == "...") {
                $(pages[3]).hide();
                $(pages[4]).hide();
                $('.pagination li').css({"width": "11%"});
            }
            if ($(pages[5]).hasClass('current')) {
                $(pages[2]).html("...");
                $(pages[2]).addClass("ellipsis");
                $(pages[3]).hide();
            }
            if ($(pages[2]).html() == "..." && pages.length == 12 && $(pages[pages.length - 3]).html() != "...") {
                $(pages[pages.length - 3]).html("...");
                $(pages[pages.length - 3]).addClass("ellipsis");
                $(pages[pages.length - 4]).hide();
            }
        } else {
            $(pages[pages.length - 4]).show();
            $(pages[pages.length - 5]).show();
            $(pages[3]).show();
            $(pages[4]).show();
            $('.pagination li').css({"width": "5%"});
        }
    }
    //console.log(pages[3]);
    $(window).resize(function(){
        drawNavigation();
    });
});
