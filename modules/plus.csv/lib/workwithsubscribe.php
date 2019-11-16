<?
namespace plus\csv;

class WorkWithSubscribe {
	public $arLid; // Список всех доступных сайтов
    public $subRL; // Подписка на еждневные новости Retail Royality
    public $subPlus; // Подписка на ежедневные новости Plusworld
    public $USER_FIELDS;//Пользовательские поля



	
    // Обновление подписки
    public function RefreshSubscribe() {
        $RUB_ID = array(); // Список подписок пользователя.
        $subscrID = 0; // ID подписки
        $addUser = false;

        //Проверяем хочет ли пользователь на что-то подписаться, если нет, то не создаем ни подписку ни пользователя.
        if (($this->subRL == "да") or ($this->subRL == "yes") or ($this->subPlus == "да") or ($this->subPlus == "yes")) {

            //Проверяем есть ли подписка с таким e-mail, если нет, то создаем ее.
            //Здесь мы используем $subscrID вне цикла, потомучто нам не важно какое значение примет эта переменная
            //если она хоть раз поменяет свое значение на отличное от нуля, то это уже будет означать, что подписка
            //с таким e-mail существует.
            $subscr = \CSubscription::GetList(
                array("ID"=>"ASC"),
                array("EMAIL"=>$this->USER_FIELDS["EMAIL"])
            );
            while(($subscr_arr = $subscr->Fetch())) {
                $subscrID = $subscr_arr["ID"];
            }

            if (intval($subscrID) == 0)
            {
                if (($this->subRL == "да") or ($this->subRL == "yes"))  $RUB_ID[] = 18; ;
                if (($this->subPlus == "да") or ($this->subPlus == "yes")) $RUB_ID[] = 1;
                $arFields = Array(
                    "FORMAT" => "html",
                    "EMAIL" => $this->USER_FIELDS["EMAIL"],
                    "ACTIVE" => "Y",
                    "CONFIRMED" => "Y",
                    "RUB_ID" => $RUB_ID,
                    // http://dev.1c-bitrix.ru/api_help/subscribe/classes/csubscriptiongeneral/csubscriptionadd.php
                    "ALL_SITES" => "Y", // Для всех сайтов
                    "DATE_INSERT" =>ConvertTimeStamp(time(), "FULL"), // Дата добавления записи
                    "DATE_UPDATE" =>ConvertTimeStamp(time(), "FULL"), // Дата модификации записи
                );
                $subscription = new \CSubscription;
                $subscription->Add($arFields);
            }



            //Ищем подписку по нужному e-mail и дальше проводим манипуляции с ней.
            $subscr = \CSubscription::GetList(
                array("ID"=>"ASC"),
                array("EMAIL"=>$this->USER_FIELDS["EMAIL"])
            );

            while(($subscr_arr = $subscr->Fetch())) {
                $subscrUSER_ID = $subscr_arr["USER_ID"];
                $subscrID = $subscr_arr["ID"];

                $subscr_rub = \CSubscription::GetRubricList($subscrID);
                while($subscr_rub_arr = $subscr_rub->Fetch()) {
                    $RUB_ID[] = $subscr_rub_arr["ID"];
                }

                $RUB_ID = array_unique($RUB_ID);

                // Если подписка не привязана к пользователю, то проверяем есть ли пользователь с таким e-mail
                if (intval($subscrUSER_ID) == 0)
                {
                    $filter = array("=email" => $this->USER_FIELDS["EMAIL"]);
                    $rsUsers = \CUser::GetList(($by="ID"), ($order="asc"), $filter);
                    //Здесь переменную $subscrUSER_ID вне цикла потомучто только один пользователь может быть с таким e-mail
                    while($rsUsers->NavNext(true, "f_"))
                    {
                        $subscrUSER_ID = $f_ID;
                    }
                    //Если пользователя нет, то создаем его
                    if (intval($subscrUSER_ID) == 0)
                    {
                        $length = 8;
                        $chartypes = "lower,numbers";
                        $password = $this->random_string($length, $chartypes);
                        $user = new \CUser;

                        $this->USER_FIELDS["LOGIN"] = $this->USER_FIELDS["EMAIL"];
                        $this->USER_FIELDS["ACTIVE"] = "Y";
                        $this->USER_FIELDS["PASSWORD"] = $password;
                        $this->USER_FIELDS["CONFIRM_PASSWORD"] = $password;

                        $subscrUSER_ID = $user->Add($this->USER_FIELDS);


                        //Отправляем пользователю сообщение о подписке с логином и пароем.
                        $arEventFields = array(
                            'EMAIL_TO' => $this->USER_FIELDS["EMAIL"],
                            'MESSAGE' => "Ваш логин: ".$this->USER_FIELDS["EMAIL"]." Ваш пароль: ".$password
                        );

                        \CEvent::Send('ADD_NEW_SUBSCRIBE_USER', $this->arLid, $arEventFields, 'N');

                        $addUser = true;
                    }

                    //Если не было пользователя, то создали его, теперь привязываем его к подписке.
                    $arFields = Array(
                        "USER_ID" => $subscrUSER_ID
                    );
                    $subscription = new \CSubscription;
                    $subscription->Update($subscrID, $arFields);
                }

                //Обновляем данные в подписке.
                if (($this->subRL == "да") or ($this->subRL == "yes")) array_push($this->RUB_ID, 18);
                if (($this->subPlus == "да") or ($this->subPlus == "yes")) array_push($this->RUB_ID, 1);

                $arFields = Array(
                    "ACTIVE" => "Y",
                    "CONFIRMED" => "Y",
                    "RUB_ID" => $RUB_ID,
                    "USER_ID" => $subscrUSER_ID,
                    "ALL_SITES" => "Y", // Для всех сайтов
                    "DATE_UPDATE" =>ConvertTimeStamp(time(), "FULL"), // Дата модификации записи
                );

                $subscription = new \CSubscription;
                $subscription->Update($subscrID, $arFields);
            }
        }

        if ($addUser) {
            return true;
        }
    }

    // Генерации пароля
    public function random_string($length, $chartypes)
    {
        $chartypes_array=explode(",", $chartypes);
        // задаем строки символов.
        //Здесь вы можете редактировать наборы символов при необходимости
        $lower = 'abcdefghijklmnopqrstuvwxyz'; // lowercase
        $upper = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ'; // uppercase
        $numbers = '1234567890'; // numbers
        $special = '^@*+-+%()!?'; //special characters
        $chars = "";
        // определяем на основе полученных параметров,
        //из чего будет сгенерирована наша строка.
        if (in_array('all', $chartypes_array)) {
            $chars = $lower . $upper. $numbers . $special;
        } else {
            if(in_array('lower', $chartypes_array))
                $chars = $lower;
            if(in_array('upper', $chartypes_array))
                $chars .= $upper;
            if(in_array('numbers', $chartypes_array))
                $chars .= $numbers;
            if(in_array('special', $chartypes_array))
                $chars .= $special;
        }
        // длина строки с символами
        $chars_length = strlen($chars) - 1;
        // создаем нашу строку,
        //извлекаем из строки $chars символ со случайным
        //номером от 0 до длины самой строки
        $string = $chars{rand(0, $chars_length)};
        // генерируем нашу строку
        for ($i = 1; $i < $length; $i = strlen($string)) {
            // выбираем случайный элемент из строки с допустимыми символами
            $random = $chars{rand(0, $chars_length)};
            // убеждаемся в том, что два символа не будут идти подряд
            if ($random != $string{$i - 1}) $string .= $random;
        }
        // возвращаем результат
        return $string;
    }

}
?>