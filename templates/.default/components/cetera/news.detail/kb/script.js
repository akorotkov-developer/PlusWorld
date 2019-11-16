$(document).ready(function(){
    $(".firms-catdesc dt").click(function(){
        $(this).siblings().removeClass('selected').end().next('dd').andSelf().addClass('selected');
    });
});