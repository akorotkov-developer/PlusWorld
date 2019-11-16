<form method="POST" action="/bitrix/admin/iblock_element_edit.php?type=<?echo $type?>
 &lang=<?echo LANG?>&IBLOCK_ID=<?echo $IBLOCK_ID?>&<?
 echo GetFilterParams("filter_");?>#tb" ENCTYPE="multipart/form-data" name="form_element">
<?echo GetFilterHiddens("filter_");?>
<input type="hidden" name="Update" value="Y">
<input type="hidden" name="from" value="<?echo htmlspecialchars($from)?>">
<input type="hidden" name="WF" value="<?echo htmlspecialchars($WF)?>">
<input type="hidden" name="return_url" value="<?echo $return_url?>">
<input type="hidden" name="ID" value="<?echo $ID?>">
<input type="hidden" name="IBLOCK_SECTION_ID" value="<?echo IntVal($IBLOCK_SECTION_ID)?>">
<table border="0" cellspacing="1" cellpadding="3" class="edittable" width="100%">

    <tr>
        <td valign="top" align="right"><font class="tablefieldtext"><font class="required">*</font>Название</font></td>
        <td valign="top">
            <input name="NAME" type="text" value="<?echo $str_NAME?>"/>
        </td>
    </tr>
    <?
    $prop_code = "ADDRESS";
    $prop_fields = $PROP[$prop_code];
    $prop_values = $prop_fields["VALUE"];
    ?>
    <tr>
        <td valign="top" align="right"><font class="tablefieldtext"><?echo htmlspecialcharsex($prop_fields["NAME"])?>:</font></td>
        <td valign="top">
        <font class="tablebodytext"><?
              _ShowPropertyField('PROP['.$prop_fields["ID"].']',
                                 $prop_fields, $prop_values, ((!$bVarsFromForm) && ($ID<=0)), $bVarsFromForm);?></font>
    </td>
    </tr>
    <?
    $prop_code = "PHONE";
    $prop_fields = $PROP[$prop_code];
    $prop_values = $prop_fields["VALUE"];
    ?>
    <tr>
        <td valign="top" align="right"><font class="tablefieldtext"><?echo htmlspecialcharsex($prop_fields["NAME"])?>:</font></td>
        <td valign="top">
        <font class="tablebodytext"><?
              _ShowPropertyField('PROP['.$prop_fields["ID"].']',
                                 $prop_fields, $prop_values, ((!$bVarsFromForm) && ($ID<=0)), $bVarsFromForm);?></font>
    </td>
    </tr>
        <?
    $prop_code = "FAX";
    $prop_fields = $PROP[$prop_code];
    $prop_values = $prop_fields["VALUE"];
    ?>
    <tr>
        <td valign="top" align="right"><font class="tablefieldtext"><?echo htmlspecialcharsex($prop_fields["NAME"])?>:</font></td>
        <td valign="top">
        <font class="tablebodytext"><?
              _ShowPropertyField('PROP['.$prop_fields["ID"].']',
                                 $prop_fields, $prop_values, ((!$bVarsFromForm) && ($ID<=0)), $bVarsFromForm);?></font>
    </td>
    </tr>
        <?
    $prop_code = "EMAIL";
    $prop_fields = $PROP[$prop_code];
    $prop_values = $prop_fields["VALUE"];
    ?>
    <tr>
        <td valign="top" align="right"><font class="tablefieldtext"><?echo htmlspecialcharsex($prop_fields["NAME"])?>:</font></td>
        <td valign="top">
        <font class="tablebodytext"><?
              _ShowPropertyField('PROP['.$prop_fields["ID"].']',
                                 $prop_fields, $prop_values, ((!$bVarsFromForm) && ($ID<=0)), $bVarsFromForm);?></font>
    </td>
    </tr>
        <?
    $prop_code = "URL";
    $prop_fields = $PROP[$prop_code];
    $prop_values = $prop_fields["VALUE"];
    ?>
    <tr>
        <td valign="top" align="right"><font class="tablefieldtext"><?echo htmlspecialcharsex($prop_fields["NAME"])?>:</font></td>
        <td valign="top">
        <font class="tablebodytext"><?
              _ShowPropertyField('PROP['.$prop_fields["ID"].']',
                                 $prop_fields, $prop_values, ((!$bVarsFromForm) && ($ID<=0)), $bVarsFromForm);?></font>
    </td>
    </tr>

    <tr>
        <td valign="top" align="center" colspan="2" class="tablehead" nowrap><font class="tableheadtext"><b>Краткое описание</b></font></td>
    </tr>
    <?if (ereg('(MSIE|Internet Explorer) ([0-9]).([0-9])+',
               $_SERVER['HTTP_USER_AGENT'],
               $version) &&
          IntVal($version[2])>=5 &&
          COption::GetOptionString("iblock", "use_htmledit", "Y")=="Y" &&
          CModule::IncludeModule("fileman")):?>
    <tr>
        <td valign="top" colspan="2">
            <?CFileMan::AddHTMLEditorFrame("PREVIEW_TEXT",
                                           $str_PREVIEW_TEXT,
                                           "PREVIEW_TEXT_TYPE",
                                           $str_PREVIEW_TEXT_TYPE, 440,
				       "N",
					0,
					"",
					"",
					$arIBlock["LID"]
					);?>
        </td>
    </tr>
    <?else:?>
    <tr>
        <td valign="top" align="right"><font class="tablefieldtext">Тип описания:</font></td>
        <td valign="top">
            <font class="tablebodytext">
                <input type="radio"
                       name="PREVIEW_TEXT_TYPE"
                       value="text"<?
                       if ($str_PREVIEW_TEXT_TYPE!="html")
                           echo " checked"?>> Текст /
                       <input type="radio"
                              name="PREVIEW_TEXT_TYPE"
                              value="html"<?
                              if ($str_PREVIEW_TEXT_TYPE=="html")
                                  echo " checked"?>> HTML
            </font>
        </td>
    </tr>
    <tr>
        <td valign="top" align="center"colspan="2" width="100%">
            <textarea cols="110" class="typearea" rows="10" name="PREVIEW_TEXT" wrap="virtual"><?echo $str_PREVIEW_TEXT?></textarea>
        </td>
    </tr>
    <?endif?>

    <tr>
        <td valign="top" align="right" class="tablebody" nowrap><font class="tablefieldtext">Логотип:</font></td>
        <td valign="top" align="left" class="tablebody"><font class="tablebodytext">

            <?echo CFile::InputFile("PREVIEW_PICTURE", 20, $str_PREVIEW_PICTURE, false, 0, "IMAGE", "class=\"typefile\"", 40);?><br>
            <?echo CFile::ShowImage($str_PREVIEW_PICTURE, 200, 200, "border=0", "", true)?>
            </font>
        </td>
    </tr>
    <?if($arIBTYPE["SECTIONS"]=="Y"):?>
    <tr>
        <td valign="top" align="right"><font class="tablefieldtext">Разделы:</font></td>
        <td valign="top" align="left">
        <?$l = CIBlockSection::GetTreeList(Array("IBLOCK_ID"=>$IBLOCK_ID));?>
        <select name="IBLOCK_SECTION[]" size="14" multiple class="typeselect">
            <option value="0"<?if(is_array($str_IBLOCK_ELEMENT_SECTION) && in_array(0, $str_IBLOCK_ELEMENT_SECTION))echo " selected"?>>Не привязан к разделу</option>
        <?
            while($l->ExtractFields("l_")):
                ?><option value="<?echo $l_ID?>"
                  <?if (is_array($str_IBLOCK_ELEMENT_SECTION) &&
                        in_array($l_ID, $str_IBLOCK_ELEMENT_SECTION))
                        echo " selected"?>>
                  <?echo str_repeat(" . ", $l_DEPTH_LEVEL)?><?echo $l_NAME?></option><?
            endwhile;
        ?>
        </select>
        </td>
    </tr>
    <?endif?>
    <tr>
        <td valign="top" align="center" colspan="2" class="tablehead"><font class="tableheadtext"><b>Активность и документооборот</b></font></td>
    </tr>
    <?if ($WF=="Y" || $view=="Y"):?>
    <tr>
        <td valign="top" align="right"><font class="tablefieldtext">Статус:</font></td>
        <td valign="top" nowrap><font class="tablebodytext">
        <?echo SelectBox("WF_STATUS_ID", CWorkflowStatus::GetDropDownList("N", "desc"), "", $str_WF_STATUS_ID);?></font></td>
    </tr>
    <?endif;?>
    <?
    if($ID>0):
        $p = CIblockElement::GetByID($ID);
        $pr = $p->ExtractFields("prn_");

        if(CModule::IncludeModule("workflow")):
            if(strlen($pr["DATE_CREATE"])>0):
            ?>
                <tr>
                    <td valign="top" align="right"><font class="tablefieldtext">Создана:</font></td>
                    <td valign="top"><font class="tablebodytext"><?echo $pr["DATE_CREATE"]?><?
                    if (intval($pr["CREATED_BY"])>0):
                    ?>&nbsp;&nbsp;&nbsp;[<a class="tablebodylink" href="user_edit.php?lang=<?=lang?>&id=<?=$pr["created_by"]?>"><?echo $pr["CREATED_BY"]?></a>]&nbsp;<?=htmlspecialcharsex($pr["CREATED_USER_NAME"])?><?
                    endif;
                    ?></font></td>
                </tr>
            <?endif;?>
            <tr>
                <td valign="top" align="right"><font class="tablefieldtext">Изменена:</font></td>
                <td valign="top"><font class="tablebodytext"><?echo $str_TIMESTAMP_X?><?
                if (intval($str_MODIFIED_BY)>0):
                ?>&nbsp;&nbsp;&nbsp;[<a class="tablebodylink" href="user_edit.php?lang=<?=lang?>&id=<?=$str_modified_by?>"><?echo $str_MODIFIED_BY?></a>]&nbsp;<?=$str_USER_NAME?><?
                endif;
                ?></font></td>
            </tr>
        <?endif?>
        <?if($WF=="Y" && strlen($prn_WF_DATE_LOCK)>0):?>
        <tr>
            <td valign="top" align="right" nowrap><font class="tablefieldtext">Заблокирована:</font></td>
            <td valign="top" nowrap><font class="tablebodytext"><?echo $prn_WF_DATE_LOCK?><?
            if (intval($prn_WF_LOCKED_BY)>0):
            ?>&nbsp;&nbsp;&nbsp;[<a class="tablebodylink" href="user_edit.php?lang=<?=lang?>&id=<?=$prn_wf_locked_by?>"><?echo $prn_WF_LOCKED_BY?></a>]&nbsp;<?=$prn_LOCKED_USER_NAME?><?
            endif;
            ?></font></td>
        </tr>
        <?endif;?>
    <?endif;?>
    <?if (CModule::IncludeModule("workflow")):?>
    <tr>
        <td valign="top" align="center" colspan="2">
            <textarea name="WF_COMMENTS" class="typearea" cols="110" rows="10"><?echo $str_WF_COMMENTS?></textarea></td>
    </tr>
    <?endif?>
</table>
<br>
<input <?if ($view=="Y" || $prn_LOCK_STATUS=="red") echo "disabled";?> type="submit" class="button" name="save" value="<?echo (($ID > 0)?"Изменить":"Добавить")?>">
&nbsp;
<input <?if ($view=="Y" || $prn_LOCK_STATUS=="red") echo "disabled";?> class="button" type="submit" name="apply" value="Применить">
&nbsp;
<input <?if ($view=="Y" || $prn_LOCK_STATUS=="red") echo "disabled";?> type="submit" class="button" name="dontsave" value="Выйти без сохранения">
</form>