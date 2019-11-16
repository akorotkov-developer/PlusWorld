jQuery(document).ready(function($){
    $(".sp-link").click(function(){
        sp_id = $(this).attr("id").replace(/^sp_link_(\d+)$/, "$1");

        if($("#sp_form_"+sp_id).hasClass("sp-hide")){

            $("#sp_form_"+sp_id).show().removeClass("sp-hide");
        }
        else
        {
            $("#sp_form_"+sp_id).hide().addClass("sp-hide");
        }
    });
});