<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

$arFixBanner = array(
    "FIX_SHOW" => "Y"
);

if(!isset($arParams['PAGER_STYLE'])) {
    $arParams['PAGER_STYLE'] = 'text';
}

// compatibility with 1.1.0
if(in_array($arParams['PAGER_STYLE'], array('horizontal', 'vertical'))) {
    $arParams['PAGER_ORIENT'] = $arParams['PAGER_STYLE'];
}

if(!isset($arParams['PAGER_POSITION'])) {
    $arParams['PAGER_POSITION'] = 'bottom_left';
}

if(!isset($arParams['EFFECT'])) {
    $arParams['EFFECT'] = '';
}

if(!isset($arParams['TRANSITION_SPEED'])) {
    $arParams['TRANSITION_SPEED'] = 300;
}

if(!isset($arParams['TRANSITION_INTERVAL'])) {
    $arParams['TRANSITION_INTERVAL'] = 5000;
}

$arResult['SLIDER_CSS_CLASS'] = 'cetera-banner_slider';

if ($arParams['PAGER_STYLE']) {
    $arResult['SLIDER_CSS_CLASS'] .= ' cetera-banner_slider_pager_'.$arParams['PAGER_STYLE'];
}

if ($arParams['PAGER_ORIENT']) {
    $arResult['SLIDER_CSS_CLASS'] .= ' cetera-banner_slider_pager_'.$arParams['PAGER_ORIENT'];
}

if ($arParams['PAGER_POSITION']) {
    $arResult['SLIDER_CSS_CLASS'] .= ' cetera-banner_slider_pager_'.$arParams['PAGER_POSITION'];
}
$TARGETING = $arParams['TARGETING'];
if ($TARGETING != "N") {
    $TARGETING = "Y";
}
$arBANNERS = array();
$Type = $arParams['TYPE'];
if ($TARGETING) {
    $resBANNERS = CAdvBanner::GetPageWeights_RS();
    while($ar_fields = $resBANNERS->GetNext()) {
        if (strlen($Type)>0) {
            if ($ar_fields["TYPE_SID"]==$Type) {

                $rsBannerID = CAdvBanner::GetByID($ar_fields["BANNER_ID"], false);
                $arBannerID = $rsBannerID->Fetch();
                $ar_fields['FIELDS'] = $arBannerID;
                $ar_fields['HTML'] = CAdvBanner::GetHTML($arBannerID);
                array_push($arBANNERS,$ar_fields);

                $arFixBannerTemp = $arFixBanner;
                $arFixBannerTemp["ID"] = intval($ar_fields["BANNER_ID"]);
                CAdvBanner::FixShow($arFixBannerTemp);
            }
        }
        else
        {
            $rsBannerID = CAdvBanner::GetByID($ar_fields["BANNER_ID"], false);
            $arBannerID = $rsBannerID->Fetch();
            $ar_fields['FIELDS'] = $arBannerID;
            $ar_fields['HTML'] = CAdvBanner::GetHTML($arBannerID);
            array_push($arBANNERS,$ar_fields);

            $arFixBannerTemp = $arFixBanner;
            $arFixBannerTemp["ID"] = intval($ar_fields["BANNER_ID"]);
            CAdvBanner::FixShow($arFixBannerTemp);
        }
    }
}
else
{
    $arFilterBANNERS = Array(
        "TYPE_SID"	 => $Type
    );

    $rsBanners = CAdvBanner::GetList($by, $order, $arFilterBANNERS, $is_filtered, "N");
    while($ar_fields = $rsBanners->NavNext(true, "f_"))
    {
        $rsBannerID = CAdvBanner::GetByID($ar_fields["BANNER_ID"], false);
        $arBannerID = $rsBannerID->Fetch();
        $ar_fields['FIELDS'] = $arBannerID;
        $ar_fields['HTML'] = CAdvBanner::GetHTML($arBannerID);
        array_push($arBANNERS,$ar_fields);

        $arFixBannerTemp = $arFixBanner;
        $arFixBannerTemp["ID"] = intval($ar_fields["BANNER_ID"]);
        CAdvBanner::FixShow($arFixBannerTemp);
    }
}
$arResult['BANNERS'] = $arBANNERS;

if($arParams['PAGER_STYLE']=='thumbs') {
    foreach($arResult['BANNERS'] as $key=>$arBanner) {
        $url = $arBanner['FIELDS']["URL"];
        $url = CAdvBanner::PrepareHTML($url, $arBanner['FIELDS']);
        $url = CAdvBanner::GetRedirectURL($url, $arBanner['FIELDS']);
        $arResult['BANNERS'][$key]['FIELDS']["URL"] = $url;
    }
}
?>