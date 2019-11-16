<?
$this->setFrameMode(true);
$this->createFrame()->begin('Загрузка');
?>
<div id="comments" class="content_block">
	<? if($arResult['SHOW_COUNT'] == 'Y'):?>
    <h2 class="b"><?=GetMessage('COMMENTS_COUNT')?> (<?=$arResult['COMMENTS_COUNT']?>):</h2>
	<? endif; ?>
    <p class="messages"><? ShowNote(implode("<br />", $arResult["MESSAGES"])); ?></p>
<? if(!$arResult['ERRORS']['CAPTCHA']): ShowError(implode("<br />", $arResult["ERRORS"])); endif; ?>
<? if($arResult['A_NAME'] != '') $arResult['saveName'] = $arResult['A_NAME']; ?>
<script type="text/javascript">
	<? if($arResult['SCROLL_TO_COMMENT']):?>
	var scroll = <?=$arResult['SCROLL_TO_COMMENT']?>;
	<? else: ?>
	var scroll = 0;
	<? endif;?>
	var save_id = <?= $arResult['P_ID'] ?>;
	var generatedString = <?= '"'.$arResult["CAPTCHA_ROBOT_CODE"].'"';?>;
	<? if($arResult['TO_MOD'] == 1):?>
	var to_moderate = 1;
	<? else: ?>
	var to_moderate = 0;
	<? endif; ?>
	var PLEASE_ENTER_COMMENT = <?= '"'.GetMessage('PLEASE_ENTER_COMMENT').'"';?>;
	var PLEASE_ENTER_NAME = <?= '"'.GetMessage('PLEASE_ENTER_NAME').'"';?>;
	var INVALID_EMAIL = <?= '"'.GetMessage('INVALID_EMAIL').'"';?>;
	var CONFIRMATION_MULTI = <?= '"'.GetMessage('CONFIRMATION_MULTI').'"';?>;
	var CONFIRMATION_SINGLE = <?= '"'.GetMessage('CONFIRMATION_SINGLE').'"';?>;
	var DEL_SUCCESS_MULTI = <?= '"'.GetMessage('DEL_SUCCESS_MULTI').'"';?>;
	var DEL_SUCCESS_SINGLE = <?= '"'.GetMessage('DEL_SUCCESS_SINGLE').'"';?>;
	var ROBOT_ERROR = <?= '"'.GetMessage('ROBOT_ERROR').'"';?>;
	var TYPE_LINK = <?= '"'.GetMessage('TYPE_LINK').'"';?>;
	var TYPE_IMAGE = <?= '"'.GetMessage('TYPE_IMAGE').'"';?>;
	var TYPE_VIDEO = <?= '"'.GetMessage('TYPE_VIDEO').'"';?>;
	var TYPE_LINK_TEXT = <?= '"'.GetMessage('TYPE_LINK_TEXT').'"';?>;
</script>
<div
<? $arResult['HAS_SUBSIDIARIES'] = 0; ?>
<? if($arResult['NO_INDEX'] == 'Y'):?><noindex><? endif;?>
<div class="comments_block">
<?if (count($arResult['COMMENTS'])>0) {?>
	<div class="comments_list">
	<? foreach($arResult['COMMENTS'] as $COMMENT): ?>
	<? if((($COMMENT['ACTIVATED'] == 0 && $arResult['GROUPS']) || $arResult['ISADMIN']) || $COMMENT['ACTIVATED'] == 1): ?>
		<div class="comment_item <? if($COMMENT['ACTIVATED'] == 0 && ($arResult['GROUPS'] || $arResult['ISADMIN'])): echo "not_approved"; endif; ?>" style="margin-left: <?=$COMMENT['LEFT_MARGIN']?>px;" id="comment_<?=$COMMENT['ID']?>">
			<div <? if($arResult['SHOW_USERPIC'] == "Y"): ?> class="user_icon" <? endif; ?>>
				<? if($arResult['SHOW_USERPIC'] == 'Y'):?>
				<?/* if($COMMENT['USER']['USERLINK'] != ''): ?><a href="<?= $COMMENT['USER']['USERLINK'] ?>"><? endif; */?>
				<? if($COMMENT['USER']['PERSONAL_PHOTO']): ?>
				<img width="48" height="48" src="<?= $COMMENT['USER']['PERSONAL_PHOTO'];?>" alt="<?=$COMMENT['USER']['LOGIN']?>" />
				<? else: ?><img width="48" height="48" src="<?=$this->__folder?>/images/nophoto.gif" alt="<?=$COMMENT['USER']['LOGIN']?>" /><? endif; ?>
				<?/* if($COMMENT['USER']['USERLINK'] != ''): ?></a><? endif;*/ ?>
				<? endif; ?>
			</div>
			<div class="comment_item_container">
			<? foreach($arResult['COMMENTS'] as $one): ?>
			<? if($one['PARENT_ID'] == $COMMENT['ID']) $arResult['HAS_SUBSIDIARIES'] = 1; ?>
			<? endforeach; ?>
			<? if($COMMENT['USER']['LOGIN']): ?>
				<div class="comment_item_top" <? if($arResult['SHOW_USERPIC'] != "Y"): echo 'style="margin-left:0px;"'; endif; ?>><strong><?=$COMMENT['USER']['LOGIN']?></strong><?if ($COMMENT["USER"]["COMPANY"]):?> (<?=$COMMENT['USER']['COMPANY']?>)<?endif;?><? if($arResult['SHOW_DATE'] == 'Y'): ?>, <?=$COMMENT['DATE_CREATE'] ?><? endif; ?><? if($COMMENT["COMMENT_LINK"] != "N"):?><a href="#<?= $COMMENT["COMMENT_LINK"] ?>" class="link_to_comment authorized">#</a><? endif; ?></div>
			<div class="comment_item_controls">
					<? if($arResult['ALLOW_RATING'] == 'Y'): ?>
						<? if($arResult['CURRENT_USER'] != 0): ?><a href="javascript://" onclick="javascript:VoteUp(<?=$COMMENT['ID']?>)"><? endif; ?><img src="<?=$this->__folder?>/images/up.png" alt="<? if($arResult['CURRENT_USER'] == 0): ?><?= GetMessage("VOTE_AUTH_ERROR") ?><? else: echo "+1"; ?><? endif; ?>" /><? if($arResult['CURRENT_USER'] != 0): ?></a><? endif; ?><span id="up_<?= $COMMENT['ID'] ?>" class="green"><?= $COMMENT['VoteUp']; ?></span>
						<? if($arResult['CURRENT_USER'] != 0): ?><a href="javascript://" onclick="javascript:VoteDown(<?=$COMMENT['ID']?>)"><? endif; ?><img src="<?=$this->__folder?>/images/down.png" alt="<? if($arResult['CURRENT_USER'] == 0): ?><?= GetMessage("VOTE_AUTH_ERROR") ?><? else: echo "-1"; ?><? endif; ?>" /><? if($arResult['CURRENT_USER'] != 0): ?></a><? endif; ?><span id="down_<?= $COMMENT['ID'] ?>" class="red"><?= $COMMENT['VoteDown']; ?></span>
				<? endif; ?>
				<? if($arResult['GROUPS'] || $arResult['ISADMIN']): ?>
						<span class="admin-control">
							<? if($COMMENT['ACTIVATED'] != 1): ?> <a id="activate_<?= $COMMENT['ID'] ?>" onclick="javascript:Activate(<?=$COMMENT['ID']?>, <?= "'".$arResult['SEND_TO_USER_AFTER_ACTIVATE']."'" ?>, <?= "'".$arResult['SEND_TO_USER_AFTER_ANSWERING']."'"?>, <?= "'".$arResult['SEND_TO_USER_AFTER_MENTION_NAME']."'"?>);" href="javascript://"><img src="<?=$this->__folder?>/images/approve.png" alt="<?= GetMessage("CONFIRM") ?>" /></a><? endif; ?>
							<a onclick="javascript:DeleteComment(<?=$COMMENT['ID'].', '.$arResult['HAS_SUBSIDIARIES']?>);" href="javascript://"><img src="<?=$this->__folder?>/images/delete.png" alt="<?= GetMessage("DELETE") ?>" /></a>
						</span>
					<? endif; ?>
				</div>
				<br class="clear" />
			<? endif; ?>
			<? if(!$COMMENT['USER']['LOGIN']): ?>
			<div class="comment_item_top" <? if($arResult['SHOW_USERPIC'] != "Y"): echo "style='margin-left:0px;'"; endif; ?>><strong><?=$COMMENT['AUTHOR_NAME']?></strong><? if($arResult['SHOW_DATE'] == 'Y'): ?>, <?= $COMMENT['DATE_CREATE'] ?><? endif; ?><? if($COMMENT["COMMENT_LINK"] != "N"):?><a href="#<?= $COMMENT["COMMENT_LINK"] ?>" class="link_to_comment">#</a><? endif; ?></div>
				<div class="comment_item_controls">
						<? if($arResult['ALLOW_RATING'] == 'Y'): ?>
						<? if($arResult['CURRENT_USER'] != 0): ?><a href="javascript://" onclick="javascript:VoteUp(<?=$COMMENT['ID']?>)"><? endif; ?><img src="<?=$this->__folder?>/images/up.png" alt="<? if($arResult['CURRENT_USER'] == 0): ?><?= GetMessage("VOTE_AUTH_ERROR") ?><? else: echo "+1"; ?><? endif; ?>" /><? if($arResult['CURRENT_USER'] != 0): ?></a><? endif; ?><span id="up_<?= $COMMENT['ID'] ?>" class="green"><?= $COMMENT['VoteUp']; ?></span>
						<? if($arResult['CURRENT_USER'] != 0): ?><a href="javascript://" onclick="javascript:VoteDown(<?=$COMMENT['ID']?>)"><? endif; ?><img src="<?=$this->__folder?>/images/down.png" alt="<? if($arResult['CURRENT_USER'] == 0): ?><?= GetMessage("VOTE_AUTH_ERROR") ?><? else: echo "-1"; ?><? endif; ?>" /><? if($arResult['CURRENT_USER'] != 0): ?></a><? endif; ?><span id="down_<?= $COMMENT['ID'] ?>" class="red"><?= $COMMENT['VoteDown']; ?></span>
					<? endif; ?>
						<? if($arResult['GROUPS'] || $arResult['ISADMIN']): ?>
						<span class="admin-control">
							<? if($COMMENT['ACTIVATED'] != 1): ?> <a id="activate_<?= $COMMENT['ID'] ?>" onclick="javascript:Activate(<?=$COMMENT['ID']?>, <?= "'".$arResult['SEND_TO_USER_AFTER_ACTIVATE']."'" ?>, <?= "'".$arResult['SEND_TO_USER_AFTER_ANSWERING']."'"?>, <?= "'".$arResult['SEND_TO_USER_AFTER_MENTION_NAME']."'"?>);" href="javascript://"><img src="<?=$this->__folder?>/images/approve.png" alt="<?= GetMessage("CONFIRM") ?>" /></a><? endif; ?>
							<a onclick="javascript:DeleteComment(<?=$COMMENT['ID'].', '.$arResult['HAS_SUBSIDIARIES']?>);" href="javascript://"><img src="<?=$this->__folder?>/images/delete.png" alt="<?= GetMessage("DELETE") ?>" /></a>
						</span>
					<? endif; ?>
				</div>
				<br class="clear" />
			<? endif; ?>
			<div class="comment_item_content"><?=$COMMENT['COMMENT']?></div>
            <?if (!empty($COMMENT["FILES"])):?>
            <div class="comment_attach"><strong><?= GetMessage("ATTACHED_FILES") ?>:</strong><br />
            <?foreach($COMMENT["FILES"] AS $k=>$data):?>
                <div class="attach">
                <a href="<?=$data["FULLSRC"]?>"  class="fancybox" rel="comment_<?=$COMMENT['ID']?>"><img src="<?=$data["SRC"]?>" width="<?=$data["WIDTH"]?>" height="<?=$data["HEIGHT"]?>"  /></a>
                </div>
            <?endforeach;?>
            <div class="clear"></div>
            </div>
            <?endif;?>
			<? if($arResult['CAN_COMMENT'] == 'Y' && $arResult['MAX_DEPTH_LEVEL'] > 1 && $COMMENT['ACTIVATED'] == 1):?>
			<div id="reply_to_<?=$COMMENT['ID']?>">
				<a id="comment_<?=$COMMENT['ID']?>" onclick="javascript:ReplyToComment(<?=$COMMENT['ID']?>);" href="javascript://" title="<?=GetMessage('REPLY')?>" class="comment_item_reply_link"><?=GetMessage('REPLY')?></a>
			</div>
            <div id="quote_to_<?=$COMMENT['ID']?>">
			    <a id="qcomment_<?=$COMMENT['ID']?>" onclick="javascript:QuoteComment(<?=$COMMENT['ID']?>);" href="javascript://" title="<?=GetMessage('QUOTE')?>" class="comment_item_quote_link"><?=GetMessage('QUOTE')?></a>&nbsp;
			</div>
			<? endif; ?>
			<br class="clear" />
		</div>
		<br class="clear" />
		</div>
	<? $arResult['HAS_SUBSIDIARIES'] = 0; ?>
	<? endif; ?>
	<? endforeach; ?>
	</div>
	<br class="clear" />
<? } ?>
	<? if($arResult['CAN_COMMENT'] == 'Y'):?>
		<div class="comment_reply"><div id="reply_to_0"><a onclick="javascript:ReplyToComment(0);" href="javascript://" id="leave_comment_link"><?=GetMessage('LEAVE_COMMENT')?></a></div></div>
		<form <? if($arResult['CURRENT_USER'] != 0): ?>onsubmit="document.getElementById('submitButton').disabled=true;document.getElementById('submitButton').style.cursor='wait';" <? endif; ?> method="post" action="" id="new_comment_form" style="display: none;" enctype="multipart/form-data">
			<fieldset id="addform" style="border: none;">
			<? if($arResult["ERRORS"]['CAPTCHA']): echo ShowError($arResult["ERRORS"]['CAPTCHA']); endif; ?>

        	<? if($arResult['PREMODERATION'] == "Y" && !$arResult['ERRORS']['CAPTCHA']&& !$arResult['ISADMIN']): ?><p id="form_show" align="left" style="color: green; margin-bottom: 10px; font-size: 12px; padding-top:15px;"><?=GetMessage('MODERATION');?></p><? endif; ?>

			<?/* if($arResult['CURRENT_USER'] == 0):?>
            <p><font color="red">*&nbsp;</font><?= GetMessage("NAME"); ?>:</p><input class="blured" id="AUTHOR_NAME" value="<?= $arResult['saveName'] ?>" type="text" name="AUTHOR_NAME" />
            <p><?= GetMessage("EMAIL"); ?>:</p><input id="EMAIL" value="<?= $arResult['EMAIL'] ?>" type="text" name="EMAIL" />
			<? endif; */?>

			<p><font color="red">*&nbsp;</font><?= GetMessage("YOUR_COMMENT"); ?>:</p>
			<? if($arResult['SHOW_FILEMAN'] == 1): ?>
		<? /*
                <div class="editor">
			<a title="<?= GetMessage("b"); ?>" onclick="javascript:encloseSelection('[b]', '[/b]');" href="javascript://"><img alt="<?= GetMessage("b"); ?>" src="<?=$this->__folder?>/images/icons/b.jpg" /></a>
			<a title="<?= GetMessage("i"); ?>" onclick="javascript:encloseSelection('[i]', '[/i]');" href="javascript://"><img alt="<?= GetMessage("i"); ?>" src="<?=$this->__folder?>/images/icons/i.jpg" /></a>
			<a title="<?= GetMessage("u"); ?>" onclick="javascript:encloseSelection('[u]', '[/u]');" href="javascript://"><img alt="<?= GetMessage("u"); ?>" src="<?=$this->__folder?>/images/icons/u.jpg" /></a>
			<a title="<?= GetMessage("s"); ?>" onclick="javascript:encloseSelection('[s]', '[/s]');" href="javascript://"><img alt="<?= GetMessage("s"); ?>" src="<?=$this->__folder?>/images/icons/s.jpg" /></a>
			<a id="quoteIcon" title="<?= GetMessage("q"); ?>" href="javascript://"><img alt="<?= GetMessage("q"); ?>" src="<?=$this->__folder?>/images/icons/quote.jpg" /></a>
			
			<!--<a title="<?= GetMessage("c"); ?>" onclick="javascript:encloseSelection('[code]', '[/code]');" href="javascript://"><img alt="<?= GetMessage("c"); ?>" src="<?=$this->__folder?>/images/icons/code.jpg" /></a>-->
			
			<a title="<?= GetMessage("l"); ?>" id="link" href="javascript://"><img alt="<?= GetMessage("l"); ?>" src="<?=$this->__folder?>/images/icons/link.jpg" /></a>
			<a title="<?= GetMessage("image"); ?>" id="image" href="javascript://"><img alt="<?= GetMessage("image"); ?>" src="<?=$this->__folder?>/images/icons/image.jpg" /></a>
			<a title="<?= GetMessage("video"); ?>" id="video" href="javascript://"><img alt="<?= GetMessage("video"); ?>" src="<?=$this->__folder?>/images/icons/video.jpg" /></a>
			
			
			<? if($arResult['ALLOW_SMILES'] == 1): ?>
			<a href="javascript://" onclick="return insertAtCursor(':)')"><img src="<?=$this->__folder?>/images/icons/smile.jpg" /></a>
			<a href="javascript://" onclick="return insertAtCursor(':D')"><img src="<?=$this->__folder?>/images/icons/xd.jpg" /></a>
			<a href="javascript://" onclick="return insertAtCursor(':(')"><img src="<?=$this->__folder?>/images/icons/sad.jpg" /></a>
			<a href="javascript://" onclick="return insertAtCursor('x_x')"><img src="<?=$this->__folder?>/images/icons/x_x.jpg" /></a>
			<a href="javascript://" onclick="return insertAtCursor('0_0')"><img src="<?=$this->__folder?>/images/icons/0_0.jpg" /></a>
			<? endif; ?>
			</div>
            */?>
			<? endif; ?>
			<textarea name="COMMENT" id="TEXT"><?=$arResult['TEXT'] ?></textarea>
			<br />

                <?/*
			<p><?= GetMessage("YOUR_FILES"); ?>:</p>
			<div class="comment_files">
			<input type="file" name="comment_file[]" />
			<br />
			<span class="add_fileinput"><?= GetMessage("ADD_FILE"); ?></span>
			</div>
                */?>

			<input type="hidden" name="PARENT_ID" value="0" />
			<? if($arResult["CAPTCHA_TYPE"] == "CAPTCHA_BITRIX"):?>
				<p><font color="red">*&nbsp;</font><?= GetMessage("CAPTCHA"); ?>:</p>
				<img src="/bitrix/tools/captcha.php?captcha_sid=<?=$arResult["CAPTCHA_CODE"]?>" alt="CAPTCHA" />
				<input type="hidden" name="captcha_sid" value="<?=$arResult["CAPTCHA_CODE"]?>" />
				<input type="text" name="captcha_word" class="comment_captcha" />
			<? elseif($arResult["CAPTCHA_TYPE"] == "ROBOT"): ?>
				<div class="checkRobot"><input id="checkRobotInput" type="checkbox" value="Y" name="ROBOT" checked="checked"  /><label id="checkRobotLabel"><?= GetMessage("robot"); ?></label></div>
				<input type="hidden" id="robotString" name="ROBOT_STRING" value=""  />
			<? endif; ?>

			<button id="submitButton" type="submit" class="comment_submit" name="submit"><?=GetMessage('ADD')?></button><br />

			</fieldset>
		</form>

	<?elseif($USER->IsAuthorized() && $arResult['CAN_COMMENT'] == 'N'):?>
        <?=GetMessage("COMMENT_FORBIDDEN");?>
    <?else:?>

		<div class="comment_reply" style="margin-top: 0"><div id="reply_to_0"><a onclick="javascript:ReplyToComment(0);" href="javascript://" id="leave_comment_link"><?=GetMessage('LEAVE_COMMENT')?></a></div></div>
		<form <? if($arResult['CURRENT_USER'] != 0): ?>onsubmit="document.getElementById('submitButton').disabled=true;document.getElementById('submitButton').style.cursor='wait';" <? endif; ?> method="post" action="" id="new_comment_form" style="display: none;" enctype="multipart/form-data">
			<fieldset id="addform" style="border: none;">
				<? if($arResult["ERRORS"]['CAPTCHA']): echo ShowError($arResult["ERRORS"]['CAPTCHA']); endif; ?>

				<? if($arResult['PREMODERATION'] == "Y" && !$arResult['ERRORS']['CAPTCHA']&& !$arResult['ISADMIN']): ?><p id="form_show" align="left" style="color: green; margin-bottom: 10px; font-size: 12px; padding-top:15px;"><?=GetMessage('MODERATION');?></p><? endif; ?>

				<?/* if($arResult['CURRENT_USER'] == 0):?>
            <p><font color="red">*&nbsp;</font><?= GetMessage("NAME"); ?>:</p><input class="blured" id="AUTHOR_NAME" value="<?= $arResult['saveName'] ?>" type="text" name="AUTHOR_NAME" />
            <p><?= GetMessage("EMAIL"); ?>:</p><input id="EMAIL" value="<?= $arResult['EMAIL'] ?>" type="text" name="EMAIL" />
			<? endif; */?>

				<p><font color="red">*&nbsp;</font><?= GetMessage("YOUR_COMMENT"); ?>:</p>
				<? if($arResult['SHOW_FILEMAN'] == 1): ?>
				<?/*
                <div class="editor">
			<a title="<?= GetMessage("b"); ?>" onclick="javascript:encloseSelection('[b]', '[/b]');" href="javascript://"><img alt="<?= GetMessage("b"); ?>" src="<?=$this->__folder?>/images/icons/b.jpg" /></a>
			<a title="<?= GetMessage("i"); ?>" onclick="javascript:encloseSelection('[i]', '[/i]');" href="javascript://"><img alt="<?= GetMessage("i"); ?>" src="<?=$this->__folder?>/images/icons/i.jpg" /></a>
			<a title="<?= GetMessage("u"); ?>" onclick="javascript:encloseSelection('[u]', '[/u]');" href="javascript://"><img alt="<?= GetMessage("u"); ?>" src="<?=$this->__folder?>/images/icons/u.jpg" /></a>
			<a title="<?= GetMessage("s"); ?>" onclick="javascript:encloseSelection('[s]', '[/s]');" href="javascript://"><img alt="<?= GetMessage("s"); ?>" src="<?=$this->__folder?>/images/icons/s.jpg" /></a>
			<a id="quoteIcon" title="<?= GetMessage("q"); ?>" href="javascript://"><img alt="<?= GetMessage("q"); ?>" src="<?=$this->__folder?>/images/icons/quote.jpg" /></a>

			<!--<a title="<?= GetMessage("c"); ?>" onclick="javascript:encloseSelection('[code]', '[/code]');" href="javascript://"><img alt="<?= GetMessage("c"); ?>" src="<?=$this->__folder?>/images/icons/code.jpg" /></a>-->

			<a title="<?= GetMessage("l"); ?>" id="link" href="javascript://"><img alt="<?= GetMessage("l"); ?>" src="<?=$this->__folder?>/images/icons/link.jpg" /></a>
			<a title="<?= GetMessage("image"); ?>" id="image" href="javascript://"><img alt="<?= GetMessage("image"); ?>" src="<?=$this->__folder?>/images/icons/image.jpg" /></a>
			<a title="<?= GetMessage("video"); ?>" id="video" href="javascript://"><img alt="<?= GetMessage("video"); ?>" src="<?=$this->__folder?>/images/icons/video.jpg" /></a>


			<? if($arResult['ALLOW_SMILES'] == 1): ?>
			<a href="javascript://" onclick="return insertAtCursor(':)')"><img src="<?=$this->__folder?>/images/icons/smile.jpg" /></a>
			<a href="javascript://" onclick="return insertAtCursor(':D')"><img src="<?=$this->__folder?>/images/icons/xd.jpg" /></a>
			<a href="javascript://" onclick="return insertAtCursor(':(')"><img src="<?=$this->__folder?>/images/icons/sad.jpg" /></a>
			<a href="javascript://" onclick="return insertAtCursor('x_x')"><img src="<?=$this->__folder?>/images/icons/x_x.jpg" /></a>
			<a href="javascript://" onclick="return insertAtCursor('0_0')"><img src="<?=$this->__folder?>/images/icons/0_0.jpg" /></a>
			<? endif; ?>
			</div>
                */?>
				<? endif; ?>
				<textarea name="COMMENT" id="TEXT"><?=$arResult['TEXT'] ?></textarea>
				<br />

                <?/*
				<p><?= GetMessage("YOUR_FILES"); ?>:</p>
			<div class="comment_files">
			<input type="file" name="comment_file[]" />
			<br />
			<span class="add_fileinput"><?= GetMessage("ADD_FILE"); ?></span>
			</div>
                */?>

				<input type="hidden" name="PARENT_ID" value="0" />
				<? if($arResult["CAPTCHA_TYPE"] == "CAPTCHA_BITRIX"):?>
					<p><font color="red">*&nbsp;</font><?= GetMessage("CAPTCHA"); ?>:</p>
					<img src="/bitrix/tools/captcha.php?captcha_sid=<?=$arResult["CAPTCHA_CODE"]?>" alt="CAPTCHA" />
					<input type="hidden" name="captcha_sid" value="<?=$arResult["CAPTCHA_CODE"]?>" />
					<input type="text" name="captcha_word" class="comment_captcha" />
				<? elseif($arResult["CAPTCHA_TYPE"] == "ROBOT"): ?>
					<div class="checkRobot"><input id="checkRobotInput" type="checkbox" value="Y" name="ROBOT" checked="checked"  /><label id="checkRobotLabel"><?= GetMessage("robot"); ?></label></div>
					<input type="hidden" id="robotString" name="ROBOT_STRING" value=""  />
				<? endif; ?>

				<input type="button" onclick="location.href='/personal/?backurl=<?=$APPLICATION->GetCurDir();?>';" class="comment_submit" value="<?=GetMessage('ADD')?>" /><br />

			</fieldset>
		</form>

		<p class="comment-auth-message"><?=GetMessage('AUTH')?></p>

	<?endif;?>

<? if($arResult['NO_INDEX'] == 'Y'):?></noindex><? endif;?>
</div>
</div>
<div class="clear"></div>
</div>