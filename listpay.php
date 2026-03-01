<?php

include_once('base.php');

// Получение списка платежей
$endpoint = 'https://api.mollie.com/v2/payments';

$headers = array(
    "Content-Type: application/json",
    "Authorization: Bearer $apiKey"
);

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $endpoint);
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

$response = curl_exec($ch);

if ($response === false) {
    echo 'Ошибка: ' . curl_error($ch);
} else {
    // Преобразование ответа в JSON
    $payments = json_decode($response, true);
    // Список платежей
    $payments_list = $payments['_embedded']['payments'];
    // Вывод списка платежей в JSON на страницу
    echo json_encode($payments_list);
}

curl_close($ch);

?>