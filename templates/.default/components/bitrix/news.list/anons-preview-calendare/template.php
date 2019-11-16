<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
/** @var array $arParams */
/** @var array $arResult */
/** @global CMain $APPLICATION */
/** @global CUser $USER */
/** @global CDatabase $DB */
/** @var CBitrixComponentTemplate $this */
/** @var string $templateName */
/** @var string $templateFile */
/** @var string $templateFolder */
/** @var string $componentPath */
/** @var CBitrixComponent $component */
$this->setFrameMode(true);
?>
    <?
    $i = 0;
    foreach ($arResult["CUSTOM_ITEMS"] as $arItem) {
        if ($arItem["ACTIVE_FROM"]) {
            $date = date("d.m.Y H:i:s", strtotime($arItem["ACTIVE_FROM"]));
            $date = DateTime::createFromFormat('d.m.Y H:i:s', $date);
            $date = (string)$date->format('Y-n-d');

            $formatedDay = $arItem["FORMATED_DATE"];
            $arSearchResult = array_filter($arResult["CUSTOM_ITEMS"], function($k) use ($formatedDay) {
                return $k['FORMATED_DATE'] === $formatedDay;
            });
        ?>
            <div class="p_hint" data-date="dayC-<?=$date?>">
                <div class="arrow"></div>
                <a class="close close_hint" >×</a>
                <?
                foreach ($arSearchResult as $arSearchResultItem) {
                ?>
                    <a class="p_event" href="<?=$arSearchResultItem["DETAIL_PAGE_URL"]?>">
                        <span class="hint_title"><?=$arSearchResultItem["NAME"]?></span><br>
                        <span class="hint_dates"><?=$date?></span>
                    </a>
                <?}?>
            </div>
        <?}
    }?>
    <div class="arrow arrow_top"></div>
    <div class="datepicker"></div>

<script>

    var selectedDates = [];
    <?
    foreach($arResult["CUSTOM_ITEMS"] as $arItem){?>
        <?
        if ($arItem["ACTIVE_FROM"]) {
            $date = date("d.m.Y H:i:s", strtotime($arItem["ACTIVE_FROM"]));
            $date = DateTime::createFromFormat('d.m.Y H:i:s', $date);
            $date = (string)$date->format('Y-n-d');
            ?>
            selectedDates.push('<?=$date?>');
        <?}?>
    <?}
    $curDate =  date('Y-n-d');
    ?>
    selectedDates.push('<?=$curDate?>');

    var datesFromDatabase = [];
    var d = new Date();
    var i = 0,
        dateC;
    for (i = 2; i < 7; i++) {
        var tempDay = new Date(); tempDay.setHours(0,0,0,0);
        tempDay.setDate(d.getDate()-i);
        datesFromDatabase.push(tempDay.getTime());
    }

    pickmeup.defaults.locales['ru'] = {
        days: ['Воскресенье', 'Понедельник', 'Вторник', 'Среда', 'Четверг', 'Пятница', 'Суббота'],
        daysShort: ['Вс', 'Пн', 'Вт', 'Ср', 'Чт', 'Пт', 'Сб'],
        daysMin: ['Вс', 'Пн', 'Вт', 'Ср', 'Чт', 'Пт', 'Сб'],
        months: ['Январь', 'Февраль', 'Март', 'Апрель', 'Май', 'Июнь', 'Июль', 'Август', 'Сентябрь', 'Октябрь', 'Ноябрь', 'Декабрь'],
        monthsShort: ['Янв', 'Фев', 'Мар', 'Апр', 'Май', 'Июн', 'Июл', 'Авг', 'Сен', 'Окт', 'Ноя', 'Дек']
    };
    pickmeup('.datepicker', {
        flat : true,
        mode : 'multiple',
        locale: 'ru',
        format: 'Y-m-d',
        prev: '<svg class="svg-icon" viewBox="0 0 19 19" style="fill: #fff;"><path style="color: #fff;" d="M2.8,19h3.8l9.6-9.5L6.6,0H2.8l9.6,9.5L2.8,19z"></path></svg>',
        next: '<svg class="svg-icon" viewBox="0 0 19 19" style="fill: #fff;"><path style="color: #fff;" d="M2.8,19h3.8l9.6-9.5L6.6,0H2.8l9.6,9.5L2.8,19z"></path></svg>',
        render: function(date = Date("Y-m-d")) {
            var d = date.getDate();
            var m =  date.getMonth()+1;
            var y = date.getFullYear();
            dateC = y+'-'+m+'-'+d;
            if ($.inArray(dateC, selectedDates) > -1 && dateC != selectedDates[selectedDates.length - 1]){
                return {
                    class_name : 'dayC-'+dateC + ' pm-selecteditem',
                    disabled: true
                }
            } else {
                return {
                    disabled: true
                }
            };
        },
    });

    pickmeup('.datepicker').set_date(selectedDates);

    jQuery(function($){
        $(document).mouseup(function (e){ // событие клика по веб-документу
            var div = $(".p_hint"); // тут указываем ID элемента
            if (!div.is(e.target) // если клик был не по нашему блоку
                && div.has(e.target).length === 0) { // и не по его дочерним элементам
                div.hide(); // скрываем его
                $('.arrow_top').css('display', 'none');
            }
        });
    });

    $('.datepicker').on('click','.pm-selecteditem', function(){

        var class_names = $(this).attr('class'),
            currentclass, elemPosition = $(this).position();
        class_names = class_names.split(' ');

        $.each(class_names,function(index,value){
            if (value.indexOf('dayC') + 1) {
                currentclass = value;
            }
        });

        if ( $('[data-date="'+currentclass+'"]').css('display') == 'none' ){
            $('.p_hint').each(function(i,elem) {
                $(elem).css('display', 'none');
            });
            $('[data-date="'+currentclass+'"]').appendTo($(this));


            //Зададим позицию всплывающего окна
            var marginleftProp = elemPosition.left - 140, isOuterWindow = false;
            if (marginleftProp > $(window).width() - 290) {
                marginleftProp = $(window).width() - 290;
                isOuterWindow = true;
            }

            $('[data-date="'+currentclass+'"]').css({
                "margin-top": "35px",
                "margin-left":marginleftProp + "px",
            });
            if (marginleftProp < 0) {
                marginleftProp = 0;
            }
            var parentElemPos = $(this).find(".arrow").parent().parent().position().left - (elemPosition.left - 140),
                posTop = 11 + $(this).find(".arrow").parent().parent().position().top + $('.pmu-instance nav').innerHeight() + $('.pmu-instance .pmu-day-of-week').innerHeight();

            $(this).find(".arrow").css({
                "top": "-29px",
                "left": parentElemPos + "px",
                "transform": "rotate(-90deg)",
                "display": "none"
            });
            $(".arrow_top").css({
                "top": posTop + "px",
                "left": $(this).position().left + 14 + "px",
                "display": "block"
            });


            var leftPos = elemPosition.left -130;
            if (leftPos < 20) {
                leftPos = 20;
            }

            if (isOuterWindow) {
                $('[data-date="' + currentclass + '"]').css({"left": 10});
            } else {
                $('[data-date="' + currentclass + '"]').offset({left: leftPos});
            }

            $('[data-date="'+currentclass+'"]').show();
        } else {
            $('[data-date="'+currentclass+'"]').hide();

            $(".arrow_top").css({
                "top": posTop + "px",
                "left": $(this).position().left + 14 + "px",
                "display": "none"
            });
        }
    });

</script>
