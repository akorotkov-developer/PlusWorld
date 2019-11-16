<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
IncludeTemplateLangFile(__FILE__);
require($_SERVER['DOCUMENT_ROOT'] . Plusworld\Config::PLUSWORLD_TEMPLATE_PATH . '/header.php');
?>

<?if ($APPLICATION->GetCurPage() != "/journal_retail_loyalty/podpiska/" and $APPLICATION->GetCurPage() != "/" and $APPLICATION->GetCurPage() != "/calendar_retail_loyalty/events/" ) {?>
    <div class="page-content">
        <div class="grid-container">
            <?if ($APPLICATION->GetCurPage() != "/journal_retail_loyalty/redaction/") {?>
                <div class="grid-x grid-padding-x">
            <?}?>
<?} elseif ($APPLICATION->GetCurPage() == "/") {?>

<?}?>
