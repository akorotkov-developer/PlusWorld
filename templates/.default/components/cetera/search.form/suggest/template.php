<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

<form action="<?=$arResult["FORM_ACTION"]?>">
    <div class="grid-x grid-padding-x align-bottom">
        <div class="small-24 medium-12 large-8 cell">
            <label>
                <?$APPLICATION->IncludeComponent(
                    "cetera:search.suggest.input",
                    "search_n",
                    array(
                        "NAME" => "q",
                        "VALUE" => (isset($_REQUEST['q']) ? htmlspecialchars($_REQUEST['q']):  ""),
                        "INPUT_SIZE" => 0,
                        "DROPDOWN_SIZE" => 10,
                    ),
                    $component, array("HIDE_ICONS" => "Y")
                );?>
            </label>
        </div>

        <?
        $where = 'all';
        if (isset($_REQUEST['where']) && in_array($_REQUEST['where'], array('news','articles','events','expert')))
        {
            $where = $_REQUEST['where'];
        }
        ?>

        <div class="small-12 medium-6 large-4 cell">
            <select name="where">
                <option value="all" <?=($where == 'all' ? 'selected="selected"' : '');?>><?=GetMessage("BSF_T_SEARCH_WHERE_ALL");?></option>
                <option value="news" <?=($where == 'news' ? 'selected="selected"' : '');?>><?=GetMessage("BSF_T_SEARCH_WHERE_NEWS");?></option>
                <option value="articles" <?=($where == 'articles' ? 'selected="selected"' : '');?>><?=GetMessage("BSF_T_SEARCH_WHERE_ARTICLES");?></option>
                <option value="events" <?=($where == 'events' ? 'selected="selected"' : '');?>><?=GetMessage("BSF_T_SEARCH_WHERE_EVENTS");?></option>
                <option value="expert" <?=($where == 'expert' ? 'selected="selected"' : '');?>><?=GetMessage("BSF_T_SEARCH_WHERE_expert");?></option>
            </select>
        </div>

        <div class="small-12 medium-6 large-4 cell end">
            <input class="button expanded button_search" name="s" type="submit" value="<?=GetMessage("BSF_T_SEARCH_BUTTON");?>" />
        </div>


        <script>
        var switch_search_params = function()
        {
            var sp = document.getElementById('search_params');
            var flag;

            if(sp.style.display == 'none')
            {
                flag = false;
                sp.style.display = 'block'
            }
            else
            {
                flag = true;
                sp.style.display = 'none';
            }

            var from = document.getElementsByName('from');
            for(var i = 0; i < from.length; i++)
                if(from[i].type.toLowerCase() == 'text')
                    from[i].disabled = flag

            var to = document.getElementsByName('to');
            for(var i = 0; i < to.length; i++)
                if(to[i].type.toLowerCase() == 'text')
                    to[i].disabled = flag

            return false;
        }
        </script>
        <div style="display: none">
            <p><a class="search-page-params" href="#" onclick="return switch_search_params()"><?echo GetMessage('CT_BSP_ADDITIONAL_PARAMS')?></a></p>
            <div id="search_params" class="search-page-params" style="display:<?echo $arResult["REQUEST"]["FROM"] || $arResult["REQUEST"]["TO"]? 'block': 'none'?>">
                <?=GetMessage('LABEL_FROM')?><?$APPLICATION->IncludeComponent(
                    'bitrix:main.calendar',
                    '',
                    array(
                        'SHOW_INPUT' => 'Y',
                        'INPUT_NAME' => 'from',
                        'INPUT_VALUE' => $arResult["REQUEST"]["~FROM"],
                        'INPUT_NAME_FINISH' => 'to',
                        'INPUT_VALUE_FINISH' =>$arResult["REQUEST"]["~TO"],
                        'INPUT_ADDITIONAL_ATTR' => 'size="10"',
                        'SHOW_TIME' => 'Y',
                    ),
                    null,
                    array('HIDE_ICONS' => 'Y')
                );?>
            </div>
        </div>

    </div>
</form>
