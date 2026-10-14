<?php
// /api/csp_report.php
// Логирует нарушения Content-Security-Policy

// Принимаем только JSON от браузера
header('Content-Type: application/json');
$raw = file_get_contents('php://input');
$data = json_decode($raw, true);

if ($data && isset($data['csp-report'])) {
    $report = $data['csp-report'];
    $log = date('Y-m-d H:i:s') . ' | ' . 
           ($report['violated-directive'] ?? 'unknown') . ' | ' . 
           ($report['blocked-uri'] ?? 'unknown') . ' | ' . 
           ($report['document-uri'] ?? 'unknown') . PHP_EOL;
    
    // Пишем в лог (файл должен быть вне корня сайта!)
    $log_dir = __DIR__ . '/../logs';
    if (!is_dir($log_dir)) {
        mkdir($log_dir, 0755, true);
    }
    file_put_contents($log_dir . '/csp_violations.log', $log, FILE_APPEND);
}

// Всегда возвращаем 204 No Content
http_response_code(204);
exit;