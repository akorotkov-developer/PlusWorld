<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
?>
<?if ($arResult["isFormErrors"] == "Y"):?><?=$arResult["FORM_ERRORS_TEXT"];?><?endif;?>
<?
$strError = "";
?>
<?=$arResult["FORM_NOTE"]?>




<?if ($arResult["isFormNote"] != "Y")
{
    ?>
    <?=$arResult["FORM_HEADER"]?>

    <div class="blank blank_shadow" data-equalizer-watch>
        <div class="blank__title text-center">будь в курсе<br><span class="text-dark-gray">новостей индустрии</span></div>
            <div class="blank__form">
            <?
            /***********************************************************************************
            form questions
             ***********************************************************************************/
            ?>

            <?

        if (isset($_POST["form_email_4060"])) {?>
                <div id="message">
                    <?
                    CModule::IncludeModule("subscribe"); //Подключаем модуль подписок
                    $RUB_ID = array();
                    array_push($RUB_ID, 18);
                    $strEmail = $_POST["form_email_4060"];

                    //Проверяем есть ли подписка с таким e-mail
                    $subscr = CSubscription::GetList(
                        array("ID"=>"ASC"),
                        array("EMAIL"=>$strEmail)
                    );
                    while(($subscr_arr = $subscr->Fetch()))
                    {
                        $subscrUSER_ID = $subscr_arr["USER_ID"];
                        $subscrID = $subscr_arr["ID"];

                        $subscr_rub = CSubscription::GetRubricList($subscrID);
                        while($subscr_rub_arr = $subscr_rub->Fetch()) {
                            $RUB_ID[] = $subscr_rub_arr["ID"];
                        }
                    }


                    //Если нет, то создаем ее
                    if (intval($subscrID) == 0)
                    {
                        $arFields = Array(
                            "FORMAT" => "html",
                            "EMAIL" => $strEmail,
                            "ACTIVE" => "Y",
                            "CONFIRMED" => "N",
                            "RUB_ID" => $RUB_ID,
                            "ALL_SITES" => "Y", // Для всех сайтов
                            "DATE_INSERT" =>ConvertTimeStamp(time(), "FULL"), // Дата добавления записи
                            "DATE_UPDATE" =>ConvertTimeStamp(time(), "FULL"), // Дата модификации записи
                        );
                        $subscr = new CSubscription;
                        $subscrID = $subscr->Add($arFields, "si");

                    // ID веб-формы
                    $FORM_ID = $arParams["WEB_FORM_ID"];
                    // массив значений ответов
                    $arValues = array (
                        "form_email_4060"  => $_POST["form_email_4060"]
                    );
                    CFormResult::Add($FORM_ID, $arValues);

                    } else {
                        $strError = "Подписка с таким e-mail уже существует";
                    }
                    ?>

                    <?if ($strError != "") {?>
                        <div class="notetext" id="access_subscribe"><?=$strError?></div>
                    <?} else {?>
                        <?
                        $arEventFields = array(
                            'USER_TO' => 'marketing@plus-alliance.com, podpiska@plus-alliance.com, '.$_POST["form_email_4060"],
                            'DATE_SUBSCR' => date("d/m/Y"),
                            'MESSAGE' => $_POST["form_email_4060"],
                            'EMAIL' => $_POST["form_email_4060"]
                        );

                        $arrSite = 'ip';
                        CEvent::Send('FORM_FILLING_podpiska_rassilka', $arrSite, $arEventFields, 'N');
                        ?>
                        <div class="notetext" id="access_subscribe"><b><?=$_POST["form_email_4060"]?></b> подписан на рассылку</div>
                    <?}?>

                </div>

                <script>
                    function scrollToElement(theElement) {
                        if (typeof theElement === "string") theElement = document.getElementById(theElement);

                        var selectedPosX = 0;
                        var selectedPosY = 0;

                        while (theElement != null) {
                            selectedPosX += theElement.offsetLeft;
                            selectedPosY += theElement.offsetTop;
                            theElement = theElement.offsetParent;
                        }

                        window.scrollTo(selectedPosX, selectedPosY-311);
                    }

                    scrollToElement('access_subscribe'); // теперь это будет работать
                </script>
        <?} else {?>

            <?
            foreach ($arResult["QUESTIONS"] as $FIELD_SID => $arQuestion)
            {
                if ($arQuestion['STRUCTURE'][0]['FIELD_TYPE'] == 'hidden')
                {
                    echo $arQuestion["HTML_CODE"];
                }
                else
                {
                    ?>

                    <?
                    if ($arQuestion['STRUCTURE'][0]['FIELD_TYPE'] == "email") {?>
                        <input class="blank__input" type="email" name="form_email_4060" placeholder="Электронная почта">
                        <?
                    } else echo $arQuestion["HTML_CODE"];
                    ?>

                    <?
                }
            } //endwhile
            ?>

        <?}?>

            <button class="blank__submit" type="submit"><i class="fas fa-arrow-right"></i></button>
            <input type="submit" class="blank__submit_button" style="display: none;">

            <script>
                $(document).ready(function() {
                    var validateBool = false;

                    $('.blank__submit').on('click', function() {
                        $('.blank__submit_button').trigger( "click" );
                    });

                    $("form[name='podpiska_rassilka']").submit(function( event ) {
                        if (validateBool == true) {

                        } else {
                            event.preventDefault();
                        }
                    });

                    function validate() {
                        if($(this).val() != '') {
                            var pattern = /^([a-z0-9_\.-])+@[a-z0-9-]+\.([a-z]{2,4}\.)?[a-z]{2,4}$/i;
                            if(pattern.test($(this).val())){
                                $(this).css({'border' : '1px solid #569b44'});
                                $('#valid').text('Верно');
                                validateBool = true;
                                return true;
                            } else {
                                $(this).css({'border' : '1px solid #ff0000'});
                                $('#valid').text('Не верно');
                                return false;
                            }
                        } else {
                            $(this).css({'border' : '1px solid #ff0000'});
                            $('#valid').text('Поле email не должно быть пустым');
                            return false;
                        }
                    }

                    $("form[name='podpiska_rassilka'] input[type='email']").blur(validate);

                    $(window).keydown(function(event){
                        if( (event.keyCode == 13) && (validate == false) ) {
                            event.preventDefault();
                            return false;
                        }
                    });
                });
            </script>

        </div>
    </div>

    <?=$arResult["FORM_FOOTER"]?>
    <?
} //endif (isFormNote)
?>