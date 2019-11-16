<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?if($arParams['JQUERY']=="Y"){?>
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.0/jquery.min.js"></script>
<?}?>
<?if(is_array($arResult['BANNERS']) && !empty($arResult['BANNERS'])){?>
    <? $block_id = 'cetera_banner_slider_'.randString(5, 'abcdef01234');?>
    <div id="<?=$block_id;?>" class="b-banners__bottom-lenta <?=$arResult['SLIDER_CSS_CLASS']?>" style="<?if($arParams['WIDTH']){?>width:<?=$arParams['WIDTH'];?>;<?}?><?if($arParams['HEIGHT']){?>height:<?=$arParams['HEIGHT'];?><?}?>">
        <?if($arParams['PAGER_STYLE'] != 'none' && count($arResult['BANNERS'])>1){?>
            <div class="cetera-banner_slider-pager">
                <div class="cetera-banner_slider-pager-inner">
                    <?foreach($arResult['BANNERS'] as $key=>$arBanner){?>
                        <?if($arParams['PAGER_STYLE']=='digits') {
                            $page_value = ($key+1);
                        } elseif(in_array($arParams['PAGER_STYLE'], array('text', 'amazon'))) {
                            $page_value = $arBanner['FIELDS']['NAME'];
                        } elseif($arParams['PAGER_STYLE']=='thumbs') {
                            $arFileTmp = CFile::ResizeImageGet($arBanner['FIELDS']['IMAGE_ID'], array("width" => 64, "height" => 64), BX_RESIZE_IMAGE_PROPORTIONAL, true);
                            $page_value = '<img width="'.$arFileTmp['width'].'" height="'.$arFileTmp['height'].'" src="'.$arFileTmp['src'].'" />';
                        } else {
                            $page_value = '&nbsp';
                        }?>
                        <a <?if($key==0){?>class="active"<?}?> href="#" title="<?=$arBanner['FIELDS']['NAME'];?>"><?=$page_value?></a>
                    <?}?>
                </div>
            </div>
        <?}?>
        <div class="cetera-banner_slider-wrapper">
            <?foreach($arResult['BANNERS'] as $arBanner){?>
                <?if($arParams['PAGER_STYLE']=='thumbs'){?>
                    <div class="cetera-banner_slider-item" data-banner_id="<?=$arBanner['FIELDS']['ID']?>">
                        <?$arImage = CFile::GetFileArray($arBanner['FIELDS']['IMAGE_ID']);?>
                        <img alt="<?=$arBanner['FIELDS']['NAME'];?>" width="<?=$arImage['WIDTH'];?> height="<?=$arImage['HEIGHT']?>" src="<?=$arImage['SRC'];?>" />
                        <p>
                            <?if($arBanner['FIELDS']['URL']){?>
                                <a href="<?=$arBanner['FIELDS']['URL'];?>" <?if($arBanner['FIELDS']["URL_TARGET"]){?>target="<?=$arBanner['FIELDS']["URL_TARGET"];?>"<?}?>><?=$arBanner['FIELDS']['NAME'];?></a><br/>
                            <?}else{?>
                                <?=$arBanner['FIELDS']['NAME'];?><br/>
                            <?}?>
                            <?if($arBanner['FIELDS']['IMAGE_ALT']){?>
                                <span><?=$arBanner['FIELDS']['IMAGE_ALT'];?></span>
                            <?}?>
                        </p>
                    </div>
                <?}else{?>
                    <div class="cetera-banner_slider-item" data-banner_id="<?=$arBanner['FIELDS']['ID']?>"><?=$arBanner['HTML'];?></div>
                <?}?>
            <?}?>
        </div>
    </div>
<?}?>
<?if(count($arResult['BANNERS'])>1){?>
    <script type="text/javascript">
        (function($) {
            var obBeonoRotation = new Cetera_Banner_Rotation ({
                id : '<?=$block_id;?>',
                transition_speed: <?=$arParams['TRANSITION_SPEED'];?>,
                transition_interval: <?=$arParams['TRANSITION_INTERVAL'];?>,
                effect: '<?=$arParams['EFFECT'];?>',
                stop_on_focus: <?=($arParams['STOP_ON_FOCUS']=='Y')?'true':'false';?>
            });
            <?if($arParams['PAGER_STYLE']=='amazon'){?>
            obBeonoRotation.onAfterShowBanner = function(banner_index) {
                if ($('.cetera-banner_slider-cursor', this.context).length < 1) {
                    $('.cetera-banner_slider-pager', this.context).append('<img class="cetera-banner_slider-cursor" src="<?=$this->GetFolder();?>/images/mzn-arrow.png">');
                }
                var cursor_position = $('a.active', this.context).position();
                var cursor_position_left = (cursor_position.left-135) + ($('a.active', this.context).width()/2);

                $('.cetera-banner_slider-cursor', this.context).css({
                    //'top': $('.cetera-banner_slider-pager', this.context).outerHeight()+'px'
                }).animate({ 'left': cursor_position_left + 'px'}, this.transition_speed);
            };
            <?}?>
            obBeonoRotation.init();
        })(jQuery);
    </script>
<?}?>