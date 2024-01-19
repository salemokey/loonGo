<?php
if ($_SERVER['REQUEST_METHOD'] != 'POST') {
    exit();
}
echo ("Test");
// Ваш сайт
$site = 'https://victor-sienta.github.io/projects/';
// Тема письма
$subject = 'Заявка с сайта '.$site.'!';
// От кого
$from = 'form@'.$site;
// Кому
$to = 'info@'.$site;

//В переменную $token нужно вставить id вашего бота
$token = "6660986001:AAEIFvCvFCeeZf9wzeSRk9e0uG02Rx37TuA";
//В chat_id вставляем id группы
$chat_id = "-4118137003";

var_dump($_POST);
if ( ! empty( $_POST ) ) {
    $name  = htmlspecialchars($_POST['name']);
    $phone  = htmlspecialchars($_POST['phone']);
    $question  = htmlspecialchars($_POST['question']);

    // Тело сообщения для отправки по почте
    // $message = "Имя клиента: $name \r\n";
    // $message .= "Телефон клиента: $phone \r\n";
    // $message .= "Сообщение: $question";

    //Тело сообщения для отправки в телеграмм
    $txt = "Имя клиента: $name %0A";
    $txt .= "Телефон клиента: $phone %0A";
    $txt .= "Сообщение: $question";

    try {
        // $headers = 'From: form@'.$site."\r\n".
        //         'X-Mailer: PHP/' . phpversion();

        //Передаем сообщение по почте
		// $mail = mail( $to, $subject, $message, $headers );

        //Передаем сообщение в телеграмм
        $sendToTelegram = fopen("https://api.telegram.org/bot{$token}/sendMessage?chat_id={$chat_id}&parse_mode=html&text={$txt}","r");
        // $mail &&
        if (  $sendToTelegram ) {
            echo json_encode('Спасибо! Ваша заявка принята. Мы свяжемся с вами в ближайшее время.');
        } else {
            echo json_encode('Ошибка отправки!');
        }

        die();

    } catch (Exception $e) {
        echo json_encode("Ошибка: $e->getMessage()");
    }
} else {
    echo json_encode("Тело сообщения пустое");
}
?>