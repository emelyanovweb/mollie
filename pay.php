<?php
include_once('base.php');

if (isset($_GET['amount'], $_GET['user'], $_GET['url'], $_GET['desc'])) {
    // Установка значений параметров
    $user_id = $_GET['user'];
    $url = $_GET['url'];
    $amount = $_GET['amount'];
    $description = $_GET['desc'];
    $status = 'open';
    $notified = 0;
    $endpoint = 'https://api.mollie.com/v2/payments';

    $data = array(
        'amount' => array(
            'currency' => 'EUR',
            'value' => '' . $amount . '.00'
        ),
        'description' => '' . $description . '',
        'redirectUrl' => 'redirect.php?url=' . $url . '',
        'webhookUrl' => 'chekpay.php',
        // Другие необходимые параметры в соответствии с документацией Mollie API
    );

    $headers = array(
        "Content-Type: application/json",
        "Authorization: Bearer $apiKey"
    );

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $endpoint);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    $response = curl_exec($ch);

    if ($response === false) {
        echo 'Ошибка: ' . curl_error($ch);
    } else {
        $paymentData = json_decode($response, true);

        if ($paymentData['status'] === 'open') {
            $url_pay = $paymentData['_links']['checkout']['href'];

            // Создание нового платежа в базе данных
            $stmt = $db->prepare("INSERT INTO payments (user_id, amount, description, status, payment_id, url, url_pay, notified) VALUES (:user_id, :amount, :description, :status, :payment_id, :url, :url_pay, :notified)");
            $stmt->bindParam(':user_id', $user_id);
            $stmt->bindParam(':amount', $amount);
            $stmt->bindParam(':description', $description);
            $stmt->bindParam(':status', $status);
            $stmt->bindParam(':payment_id', $paymentData['id']);
            $stmt->bindParam(':url', $url);
            $stmt->bindParam(':url_pay', $url_pay);
            $stmt->bindParam(':notified', $notified);
            $stmt->execute();

            // Перенаправление на страницу оплаты
            header('Location: ' . $paymentData['_links']['checkout']['href']);
        } else {
            echo 'Ошибка: Платеж не был создан успешно.';
        }
    }
}

curl_close($ch);
?>