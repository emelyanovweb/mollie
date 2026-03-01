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
 
    // Проверка статусов платежей и обновление их в базе данных 
    foreach ($payments_list as $payment) { 
        $status = $payment['status']; 
        $paymentId = $payment['id']; 
 
        // Выборка статуса платежа из базы данных 
        $stmt = $db->prepare("SELECT status, user_id FROM payments WHERE payment_id = :payment_id"); 
        $stmt->bindParam(':payment_id', $paymentId); 
        $stmt->execute(); 
        $result = $stmt->fetch(PDO::FETCH_ASSOC); 
 
        // Если статус в базе данных не open, то обновляем его 
        if ($status != "open" and $status != "expired") { 
 
            $stmt = $db->prepare("UPDATE payments SET status = :status WHERE payment_id = :payment_id"); 
            $stmt->bindParam(':status', $status); 
            $stmt->bindParam(':payment_id', $paymentId); 
            $stmt->execute(); 
 
            // Получение user_id для назначения тега 
            $userId = $result['user_id']; 
 
        }
    }     
} 
 
curl_close($ch); 
?>