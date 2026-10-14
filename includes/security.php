<?php
// /includes/security.php
// ВАЖНО: Перед <?php не должно быть НИЧЕГО (ни пробелов, ни пустых строк, ни BOM-символов!)

// 1. Старт сессии (ОБЯЗАТЕЛЬНО до любого вывода в браузер)
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// 2. Генерация уникального nonce для inline-скриптов и стилей
$csp_nonce = base64_encode(random_bytes(16));
$GLOBALS['csp_nonce'] = $csp_nonce; // ИСПРАВЛЕНО: было $sp_nonce

// 3. Формирование директив Content-Security-Policy
$csp_directives = [
    // Базовое правило
    "default-src 'self'",

    // Скрипты: свой домен + nonce + blob: (критично для воркеров MapLibre)
    "script-src 'self' 'nonce-{$csp_nonce}' blob:",

    // Воркеры: свой домен + blob: (критично для MapLibre GL JS)
    "worker-src 'self' blob:",

    // Стили: свой домен + unsafe-inline (нужно для динамических стилей карты) + nonce + внешние шрифты и карты
    "style-src 'self' 'unsafe-inline' https://fonts.googleapis.com https://basemaps.cartocdn.com",
    
    "connect-src 'self' https://basemaps.cartocdn.com https://*.basemaps.cartocdn.com https://router.project-osrm.org",
   

    // Шрифты
    "font-src 'self' https://fonts.gstatic.com",

    // ИЗОБРАЖЕНИЯ: свой домен + data: (для base64 и маркеров) + CartoDB (тайлы карты)
    "img-src 'self' data: https://basemaps.cartocdn.com https://*.basemaps.cartocdn.com",

    // СОЕДИНЕНИЯ (fetch/XHR): свой домен + CartoDB (загрузка JSON-стилей и данных карты)
    "connect-src 'self' https://basemaps.cartocdn.com https://*.basemaps.cartocdn.com",

    // Медиа
    "media-src 'self'",

    // Фреймы
    "frame-src 'self'",

    // Запрет встраивания устаревших объектов
    "object-src 'none'",

    // Ограничение base URI
    "base-uri 'self'",

    // Ограничение отправки форм
    "form-action 'self'",

    // Защита от кликджекинга
    "frame-ancestors 'none'"
];

// 4. Отправка заголовка CSP
header("Content-Security-Policy: " . implode('; ', $csp_directives));

// 5. Дополнительные заголовки безопасности
header("X-Content-Type-Options: nosniff");
header("X-Frame-Options: DENY");
header("X-XSS-Protection: 1; mode=block");
header("Referrer-Policy: strict-origin-when-cross-origin");
header("Permissions-Policy: geolocation=(self), microphone=(), camera=()");