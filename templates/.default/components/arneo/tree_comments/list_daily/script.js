var last_active_element;

function getSelectedText(){

    if(window.getSelection){
        return window.getSelection().toString();
    }
    else if(document.getSelection){
        return document.getSelection();
    }
    else if(document.selection){
        return document.selection.createRange().text;
    }
}

function encloseSelection(prefix, suffix) {
	textarea = document.getElementById("TEXT");
      textarea.focus();
      var start, end, sel, scrollPos, subst;
      if (document.selection != undefined) {
        sel = document.selection.createRange().text;
      } else if (textarea.setSelectionRange != undefined) {
        start = textarea.selectionStart;
        end = textarea.selectionEnd;
        scrollPos = textarea.scrollTop;
        sel = textarea.value.substring(start, end);
      }
      if (sel.match(/ $/)) { // exclude ending space char, if any
        sel = sel.substring(0, sel.length - 1);
        suffix = suffix + " ";
      }
      subst = prefix + sel + suffix;
      if (document.selection != undefined) {
        var range = document.selection.createRange().text = subst;
        textarea.caretPos -= suffix.length;
      } else if (textarea.setSelectionRange != undefined) {
        textarea.value = textarea.value.substring(0, start) + subst +
                         textarea.value.substring(end);
        if (sel) {
          textarea.setSelectionRange(start + subst.length, start + subst.length);
        } else {
          textarea.setSelectionRange(start + prefix.length, start + prefix.length);
        }
        textarea.scrollTop = scrollPos;
      }
    }




new function($) {
  $.fn.setCursorPosition = function(pos) {
    if ($(this).get(0).setSelectionRange) {
      $(this).get(0).setSelectionRange(pos, pos);
    } else if ($(this).get(0).createTextRange) {
      var range = $(this).get(0).createTextRange();
      range.collapse(true);
      range.moveEnd('character', pos);
      range.moveStart('character', pos);
      range.select();
    }
  }

}(jQuery);

function insertAtCursor(val) {

	obj = document.getElementById("TEXT");

	if(document.selection){
		obj.focus();
		sel = document.selection.createRange();
		sel.text = val;
	} else
	if (obj.selectionStart || obj.selectionStart == '0') {
	var startPos = obj.selectionStart;
	var endPos = obj.selectionEnd;
	obj.value = obj.value.substring(0, startPos) + val + obj.value.substring(endPos, obj.value.length);
	} else obj.value += val;
	return false;
}

function str_replace(search, replace, subject) {
	return subject.split(search).join(replace);
}

function scrollToComment(comment_id, to_moderate)
	{
		var comment_id = '#comment_' + comment_id;
        if(to_moderate == 1)
			$('html,body').animate({scrollTop: $('.messages').offset().top}, 100);
		else
			$('html,body').animate({scrollTop: $(comment_id).offset().top}, 100);
	}

function DeleteComment(comment_id, has_subsidiaries)
{

    var DivID = $('#comment_' + comment_id);
    var delete_single_element = 'D_ID=' + comment_id;
    var delete_all_elements = 'ALL_ID=' + comment_id;

    if(has_subsidiaries == 1)
    {
        if (confirm(CONFIRMATION_MULTI))
        {
            $.ajax({

            type: "POST",
            url: "/bitrix/components/arneo/tree_comments/ajax_actions.php",
            data: delete_all_elements,
            cache: false,

            success: function()
            {
                DivID.html(DEL_SUCCESS_MULTI);
            }

            });
        }
    }
    else
    {
        if (confirm(CONFIRMATION_SINGLE))
        {
            $.ajax({

            type: "POST",
            url: "/bitrix/components/arneo/tree_comments/ajax_actions.php",
            data: delete_single_element,
            cache: false,

            success: function()
            {
                DivID.html(DEL_SUCCESS_SINGLE);
            }

            });
        }
    }

}

function ReplyToComment(id)
{
     $("a#comment_" + id).fadeOut(300);
     $("a#qcomment_" + id).fadeOut(300);
	 $("#leave_comment_link").show();
	 $(".comment_item_reply_link").show();
	 $(".comment_item_quote_link").show();

	 $("#new_comment_form").appendTo("#reply_to_"+id).fadeIn(500);
	 $("#new_comment_form input[name=PARENT_ID]").val(id);

}
function QuoteComment(id)
{
     $("a#comment_" + id).fadeOut(300);
     $("a#qcomment_" + id).fadeOut(300);
	 $("#leave_comment_link").show();
	 $(".comment_item_reply_link").show();
	 $(".comment_item_quote_link").show();

	 $("#new_comment_form").appendTo("#reply_to_"+id).fadeIn(500);
	 $("#new_comment_form input[name=PARENT_ID]").val(id);

     var quote_author = $(" #comment_"+id+" .comment_item_top").text();
     var quote_text = $(" #comment_"+id+" .comment_item_content").text();
     $("#reply_to_"+id+ " textarea").val("[quote]\r\n[i]"+quote_author+"[/i]\r\n"+quote_text+"\r\n[/quote]\r\n").focus().setCursorPosition($("#reply_to_"+id+ " textarea").val().length);

}

function SaveData(id)
{
	 $("#leave_comment_link").show();
	 $(".comment_item_reply_link").show();
	 $(".comment_item_quote_link").show();

     if(id == 0) $("#new_comment_form").appendTo("#reply_to_0").fadeIn(500);
	 else $("#new_comment_form").appendTo("#reply_to_" + id).fadeIn(500);

	 $("#new_comment_form input[name=PARENT_ID]").val(id);

	 scrollToComment(id, 0);

}


function Activate(comment_id, SendingAfterActivate, send_after_answer, send_after_mention)
{
    var activate_comment = 'ACTIVATE_ON=' + comment_id;
    if(SendingAfterActivate == 'Y') SendingAfterActivate = 1;
    else SendingAfterActivate = 0;

    if(send_after_answer == 'Y') send_after_answer = 1;
    else send_after_answer = 0;

    if(send_after_mention == 'Y') send_after_mention = 1;
    else send_after_mention = 0;

    var sendingAfterActivate_config = 'SENDING=' + SendingAfterActivate;

    var DivID = $('#comment_' + comment_id);
    var aActivateID = $('#activate_' + comment_id);

    $.ajax({

        type: "POST",
        url: "/bitrix/components/arneo/tree_comments/ajax_actions.php",
        data: activate_comment,
        cache: false,

        success: function()
        {
            aActivateID.html('');
            DivID.css('background', 'none');
        }

    });

    if(SendingAfterActivate == 1)
    {
        $.ajax({

        type: "POST",
        url: "/bitrix/components/arneo/tree_comments/ajax_actions.php",
        data:  { 'SENDING' : SendingAfterActivate, 'ACTIVATE_ON' : comment_id },
        cache: false,

        success: function(){}

        });
    }

    if(send_after_answer == 1)
    {
        $.ajax({

        type: "POST",
        url: "/bitrix/components/arneo/tree_comments/ajax_actions.php",
        data:  { 'SEND_AFTER_ANSWER' : send_after_answer, 'COMMENT_ID' : comment_id },
        cache: false,

        success: function(){}

        });
    }

    if(send_after_mention == 1)
    {
        $.ajax({

        type: "POST",
        url: "/bitrix/components/arneo/tree_comments/ajax_actions.php",
        data:  { 'SEND_AFTER_MENTION' : send_after_mention, 'COMMENT_ID' : comment_id },
        cache: false,

        success: function(){}

        });
    }
}

function VoteUp(comment_id)
{

        var DivUpID = $('#up_' + comment_id);
        var DivUpCount = Number(DivUpID.html());
        var NewCount = DivUpCount + 1 ;

        if(NewCount == 0)
        {
            NewCount = '';
        }

        $.ajax({

        type: "POST",
        url: "/bitrix/components/arneo/tree_comments/ajax_actions.php",
        data:  { 'VoteUp' : comment_id},
        cache: false,

        success: function(otvet)
        {
            var res = otvet;
            if(res == 1)
            {
                DivUpID.html(NewCount);
            }
            else
            {
                alert(res);
            }
        }

        });
}

function VoteDown(comment_id)
{
    var DivDownID = $('#down_' + comment_id);
    var DivDownCount = Number(DivDownID.html());
    var NewCount = DivDownCount + 1 ;


        if(NewCount == 0)
        {
            NewCount = '';
        }

        $.ajax({

        type: "POST",
        url: "/bitrix/components/arneo/tree_comments/ajax_actions.php",
        data:  { 'VoteDown' : comment_id},
        cache: false,

        success: function(otvet)
        {
            var res = otvet;
            if(res == 1)
            {
                DivDownID.html(NewCount);
            }
            else
            {
                alert(res);
            }
        }

        });
}


$().ready(function()
{

	$('#checkRobotLabel').bind('click', function() {

	   if ($("#checkRobotInput").is(':checked')) {
			$("#checkRobotInput").removeAttr("checked");
			$('#robotString').val(generatedString);
	   }
	   else{
		   $("#checkRobotInput").attr("checked", "checked");
		   $('#robotString').val('');
	   }
	})

	$("#checkRobotInput").change(function() {
		if(!$(this).is(':checked'))
			$('#robotString').val(generatedString);
        else
            $('#robotString').val('');
	});

	$('#quoteIcon').click(function(){
		if (last_active_element == "comment")
		{
			insertAtCursor("[quote]" + getSelectedText() + "[/quote]");
			last_active_element = "";
		}
		else
		{
			encloseSelection('[quote]', '[/quote]');
			last_active_element = "";
		}
	});

	$('.comment_item_content').mouseup(function(){
		last_active_element = "comment";
	});

	$('#TEXT').mouseup(function(){
		last_active_element = "textarea";
	});

  var InputClass = 'blured';
  var ClickedClass = 'clicked';
  $('.'+InputClass).focus(function(){
    if ($(this).attr('defvalue') == undefined)
    	$(this).attr('defvalue',$(this).val());
    if (($(this).attr('blurvalue') == undefined)||($(this).attr('blurvalue') == $(this).attr('defvalue')))
      $(this).val('').addClass(ClickedClass);
  }).blur(function(){
    var blurvalue = $(this).val();
    if (blurvalue == '')
      $(this)
        .removeAttr('blurvalue')
        .val($(this).attr('defvalue'))
        .removeClass(ClickedClass);
    else
      $(this).attr('blurvalue',blurvalue);
  });



	$('#link').click(function() {

      $('#TEXT').focus();

		var link = prompt(TYPE_LINK);
		if(link)
		{
			var link_text = prompt(TYPE_LINK_TEXT, getSelectedText());
			if(!link_text) link_text = link;

			link = str_replace('http://', '', link);
			var full_link = "[url=http://" + link + "]" + link_text + "[/url]";

			insertAtCursor(full_link);
		}
	});

	$('#image').click(function() {
		var image = prompt(TYPE_IMAGE);

		if(image){
			var full_image = "[IMG]" + image + "[/IMG]";
			insertAtCursor(full_image);
		}
	});

	$('#video').click(function() {
		var video = prompt(TYPE_VIDEO);

		if(video){
			var full_video = "[VIDEO]" + video + "[/VIDEO]";
			insertAtCursor(full_video);
		}
	});
    if(save_id > 0)
    {
        SaveData(save_id);
    }

    else if(save_id != -1)
    {
        SaveData(0);
    }

    if(scroll != 0) {

    	scrollToComment(scroll, to_moderate);
    	scroll = 0;
    }

    $(".add_fileinput").click(function(){
        $("<input type=\"file\" name=\"comment_file[]\" /> <br />").insertBefore(".add_fileinput");
        if ($("input:file").length >= 5) $(this).remove();
    });

    $('div[id^=comment_]').hover(function()
    {
        var id = $(this).attr("id").replace(/^\w+\_(\d+)$/, "$1");

        $('a#comment_' + id).css('font-weight', 'bold');
        $('a#qcomment_' + id).css('font-weight', 'bold');
    }, function(){

        var id = $(this).attr("id").replace(/^\w+\_(\d+)$/, "$1");
        $('a#comment_' + id).css('font-weight', 'normal');
        $('a#qcomment_' + id).css('font-weight', 'normal');

    });

    $('#form_show').click(function()
    {
        $('#addform').fadeIn(1000);
    });

	$('#new_comment_form').submit(function() {

		if($('#checkRobotInput').is(':checked'))
		{
			alert(ROBOT_ERROR);
			return false;
		}

        else if($('#EMAIL').val() != '')
        {
    	    var email = $('#EMAIL').val();
            var reg = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;

             if (!email.match(reg))
             {
                alert(INVALID_EMAIL);
                return false;
             }
        }

  		else if($('#AUTHOR_NAME').val() == '')
		{
			alert(PLEASE_ENTER_NAME);
			return false;
		}

		else if($('#TEXT').val() == '')
		{
			alert(PLEASE_ENTER_COMMENT);
			return false;
		}

		else
		{
			$(this).find("button[type=submit]").attr('disabled', 'disabled');
			$(this).find("button[type=submit]").css('cursor', 'wait');
			return true;
		}

	});
});

