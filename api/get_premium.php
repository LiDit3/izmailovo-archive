<?php
// Разрешаем запросы с нашего домена (CORS)
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

// Запускаем сессию
session_start();

// ПРОВЕРКА: Есть ли у пользователя флаг оплаты в сессии?
// Этот флаг ($_SESSION['premium_access']) должен устанавливать ваш скрипт 
// после успешного webhook-уведомления от ЮKassa / CloudPayments.
if (isset($_SESSION['premium_access']) && $_SESSION['premium_access'] === true) {
    
    // Пользователь оплатил: отдаем защищенные данные
    $premium_data = file_get_contents(__DIR__ . '/../data_premium.json');
    echo $premium_data;
    
} else {
    // Пользователь не оплатил: отдаем ошибку 403. 
    // Браузер даже не получит содержимое data_premium.json
    http_response_code(403);
    echo json_encode(["error" => "Доступ запрещен. Требуется ключ Архивариуса."]);
}
?>