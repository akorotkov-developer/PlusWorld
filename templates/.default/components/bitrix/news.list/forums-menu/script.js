$(document).ready(function(){

   $(".request2forum").click(function(){
    fid = $(this).parent(".forum-request").attr("id").replace(/^\w+-(\d+)$/, "$1");

    $.ajax({url: "/bitrix/tools/ajax/forum-user.php",dataType: 'html',data : {'fid':fid},
    beforeSend: function() {
        $("body").css("cursor","wait");
    },
    success: function(data) {
        if (data.error){$("body").css("cursor","auto");}
        else
        {
            $("#fr-"+fid).empty().html(data);
            $("body").css("cursor","auto");
        }
    },
    error: function(data) {
        $("body").css("cursor","auto");
    }
    });

   });

});
