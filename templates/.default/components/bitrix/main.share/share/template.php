<?$this->setFrameMode(true);?>
<?// print_r($arResult); ?>
 <script type="text/javascript" src="http://yastatic.net/share/share.js" charset="utf-8"></script> 
    <script type="text/javascript"> 
        // создаем блок
        var YaShareInstance = new Ya.share({
            element: 'ya_share',
            title: "Опросы и голосования",
            description: "<?=$arResult["PAGE_TITLE"]?>",
            image: "http://www.plusworld.ru/upload/templates/logo_plus_ru.png",
			l10n: "ru",
			link: "<?=$arResult["PAGE_URL"]?>",
            elementStyle: {
                text: "",
                type: "none"
            }
        });
        // Блок еще не проинициализировался, поэтому ничего не произойдет
        YaShareInstance.updateShareLink('http://api.yandex.ru', 'API');
    </script>

<span id="ya_share"></span>
