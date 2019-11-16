$(document).ready(function(){
    // ловим событие отправки формы
    $('.modal-form_auth').submit(function(){

        // хорошим тоном будет сделать минимальную проверку формы перед отправкой
        // хотя бы на заполненность всех обязательных полей
        // в целях краткости здесь она не приводится

        var path = '/ajax/auth.php'; // объявляем путь к ajax-скрипту авторизации
        var formData = $(this).serialize(); // выдергиваем данные из формы

        // объявляем функцию, которая принимает данные из скрипта path
        var success = function( response ){
            console.log(response);
            if ($.trim(response) == 'Y')
            {
                location.reload();
            }
            else
            {
                // в противном случае в переменной response будет текст ошибки
                // и его нужно где-то отобразить
                $('.forgot_errors_auth').html( response ).show();
            }
        };

        // явно указываем тип возвращаемых данных
        var responseType = 'html';

        // делаем ajax-запрос
        $.post( path, formData, success, responseType );

        return false; // не даем форме отправиться обычным способом
    });
});