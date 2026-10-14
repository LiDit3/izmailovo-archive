<?php
// Отправляем правильный HTTP-заголовок 404
http_response_code(404);
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ОШИБКА 404 // СЕКТОР УТЕРЯН // ИЗМАЙЛОВО АРХИВ</title>
    <link rel="stylesheet" href="/assets/style.css">
    <style>
        /* Дополнительные стили специально для 404 */
        .error-container {
            max-width: 900px;
            margin: 40px auto;
            padding: 20px;
        }

        .error-code {
            font-size: 8rem;
            color: var(--red);
            text-shadow: var(--red-glow);
            text-align: center;
            margin: 0;
            letter-spacing: 10px;
            animation: errorCodePulse 2s infinite;
        }

        @keyframes errorCodePulse {
            0%, 100% { opacity: 1; text-shadow: 0 0 20px var(--red); }
            50% { opacity: 0.7; text-shadow: 0 0 40px var(--red); }
        }

        .error-title {
            font-size: 2rem;
            color: var(--text-color);
            text-align: center;
            margin: 10px 0 30px 0;
            letter-spacing: 3px;
            text-shadow: var(--glow);
        }

        .error-message {
            background: rgba(255, 0, 64, 0.05);
            border: 2px solid var(--red);
            padding: 25px;
            margin-bottom: 30px;
            font-size: 1.3rem;
            line-height: 1.8;
            position: relative;
        }

        .error-message::before {
            content: "⚠ СИСТЕМНОЕ СООБЩЕНИЕ";
            position: absolute;
            top: -12px;
            left: 50%;
            transform: translateX(-50%);
            background: var(--bg-color);
            color: var(--red);
            padding: 0 15px;
            font-size: 1rem;
            letter-spacing: 2px;
        }

        .error-message .highlight {
            color: var(--amber);
            font-weight: bold;
        }

        /* Журнал инцидента */
        .incident-log {
            background: rgba(0, 0, 0, 0.7);
            border: 1px solid var(--amber);
            padding: 20px;
            margin-bottom: 30px;
            font-size: 1rem;
        }

        .incident-log-title {
            color: var(--amber);
            font-size: 1.2rem;
            margin-bottom: 15px;
            text-transform: uppercase;
            letter-spacing: 2px;
            border-bottom: 1px dashed var(--amber);
            padding-bottom: 10px;
        }

        .log-entry {
            margin: 10px 0;
            color: #aaa;
            padding-left: 15px;
            border-left: 2px solid var(--amber);
        }

        .log-entry .time {
            color: var(--cyan);
            margin-right: 10px;
        }

        .log-entry.error {
            color: var(--red);
            border-left-color: var(--red);
        }

        .log-entry.success {
            color: var(--text-color);
            border-left-color: var(--text-color);
        }

        /* Кнопка восстановления */
        .restore-section {
            text-align: center;
            margin: 40px 0;
            padding: 30px;
            border: 2px dashed var(--cyan);
            background: rgba(0, 229, 255, 0.03);
            display: flex;
            flex-direction: column;
        }

        .restore-btn {
            background: transparent;
            border: 2px solid var(--cyan);
            color: var(--cyan);
            padding: 15px 40px;
            font-family: 'VT323', monospace;
            font-size: 1.5rem;
            cursor: pointer;
            transition: all 0.3s;
            letter-spacing: 2px;
            text-transform: uppercase;
            margin: 10px;
        }

        .restore-btn:hover {
            background: var(--cyan);
            color: var(--bg-color);
            box-shadow: 0 0 30px var(--cyan);
            transform: scale(1.05);
        }

        .restore-btn.primary {
            background: var(--amber);
            border-color: var(--amber);
            color: var(--bg-color);
        }

        .restore-btn.primary:hover {
            box-shadow: 0 0 30px var(--amber);
        }

        /* Счётчик аномалий */
        .anomaly-counter {
            text-align: center;
            margin: 20px 0;
            font-size: 1.1rem;
            color: #888;
        }

        .anomaly-counter .count {
            color: var(--red);
            font-size: 1.5rem;
            text-shadow: var(--red-glow);
        }

        /* Быстрые ссылки */
        .quick-links {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 15px;
            margin: 30px 0;
        }

        .quick-link {
            padding: 15px;
            border: 1px solid var(--text-color);
            background: rgba(0, 255, 65, 0.03);
            text-decoration: none;
            color: var(--text-color);
            text-align: center;
            transition: all 0.3s;
            font-size: 1.1rem;
        }

        .quick-link:hover {
            background: rgba(0, 255, 65, 0.15);
            box-shadow: 0 0 20px rgba(0, 255, 65, 0.4);
            transform: translateY(-3px);
        }

        .quick-link .link-icon {
            font-size: 2rem;
            display: block;
            margin-bottom: 5px;
        }

        /* Пасхалка */
        .easter-egg {
            text-align: center;
            margin-top: 40px;
            font-size: 0.9rem;
            color: #555;
            font-style: italic;
        }

        .easter-egg a {
            color: #555;
            text-decoration: none;
            transition: color 0.3s;
        }

        .easter-egg a:hover {
            color: var(--red);
            text-shadow: var(--red-glow);
        }

        /* Анимация глитча для кода ошибки */
        @keyframes glitch {
            0%, 100% { transform: translate(0); }
            20% { transform: translate(-3px, 3px); }
            40% { transform: translate(-3px, -3px); }
            60% { transform: translate(3px, 3px); }
            80% { transform: translate(3px, -3px); }
        }

        .error-code.glitch {
            animation: errorCodePulse 2s infinite, glitch 0.3s infinite;
        }

        @media (max-width: 768px) {
            .error-code { font-size: 5rem; letter-spacing: 5px; }
            .error-title { font-size: 1.5rem; }
            .error-message { font-size: 1.1rem; padding: 15px; }
            .quick-links { grid-template-columns: 1fr; }
        }
    </style>
</head>
<body>

    <div class="error-container">
        <!-- Код ошибки -->
        <h1 class="error-code" id="error-code">404</h1>
        <h2 class="error-title">СЕКТОР УТЕРЯН В АНАЛОГОВОМ СДВИГЕ</h2>

        <!-- Основное сообщение -->
        <div class="error-message">
            Запрашиваемый файл <span class="highlight">не найден в архиве Измайлово</span>. 
            Возможно, он был повреждён во время национализации 1918 года, 
            стёрт аналоговым сдвигом, или его никогда не существовало в этой реальности.
            <br><br>
            <span style="color: var(--cyan);">
                Координаты запроса: <span id="requested-url" style="color: var(--amber);">неизвестны</span>
            </span>
        </div>

        <!-- Журнал инцидента -->
        <div class="incident-log">
            <div class="incident-log-title">📋 ЖУРНАЛ ИНЦИДЕНТА #<?= date('Ymd-His') ?></div>
            <div class="log-entry">
                <span class="time">[<?= date('H:i:s') ?>]</span>
                Запрос к узлу: <span id="log-url">/unknown</span>
            </div>
            <div class="log-entry error">
                <span class="time">[<?= date('H:i:s') ?>]</span>
                ОШИБКА: Файл не обнаружен в базе данных архива
            </div>
            <div class="log-entry">
                <span class="time">[<?= date('H:i:s') ?>]</span>
                Попытка восстановления из резервной копии... ПРОВАЛ
            </div>
            <div class="log-entry">
                <span class="time">[<?= date('H:i:s') ?>]</span>
                Сканирование аналогового слоя... АНОМАЛИЯ НЕ ОБНАРУЖЕНА
            </div>
            <div class="log-entry success">
                <span class="time">[<?= date('H:i:s') ?>]</span>
                Система стабильна. Предлагается вернуться в безопасную зону.
            </div>
        </div>

        <!-- Счётчик аномалий -->
        <div class="anomaly-counter">
            Всего потерянных секторов в архиве: <span class="count" id="anomaly-count">404</span>
        </div>

        <!-- Кнопки действий -->
        <div class="restore-section">
            <p style="font-size: 1.3rem; color: var(--text-color); margin-bottom: 20px;">
                Выберите действие для восстановления связи:
            </p>
            <button class="restore-btn" onclick="attemptRestore()">
                🔄 ПОПЫТАТЬСЯ ВОССТАНОВИТЬ СИГНАЛ
            </button>
            <a href="/" class="restore-btn primary">
                 ВЕРНУТЬСЯ В АРХИВ
            </a>
        </div>

        <!-- Быстрые ссылки -->
        <div class="quick-links">
            <a href="/tour/" class="quick-link">
                <span class="link-icon">🗺️</span>
                МАРШРУТ
            </a>
            <a href="/shatrov/" class="quick-link">
                <span class="link-icon">📁</span>
                ДОСЬЕ ШАТРОВА
            </a>
            <a href="/media/" class="quick-link">
                <span class="link-icon">🎞️</span>
                МЕДИА-АРХИВ
            </a>
            <a href="/secret/" class="quick-link">
                <span class="link-icon">🔒</span>
                СЕКРЕТЫ
            </a>
        </div>

        <!-- Пасхалка -->
        <div class="easter-egg">
            Если вы видите эту страницу — возможно, вы нашли то, что не должны были искать.
            <br>
            <a href="/secret/" title="Вы уверены?">Проверить уровень допуска →</a>
        </div>
    </div>

<script>
// Показываем запрошенный URL (с декодированием кириллицы)
document.addEventListener('DOMContentLoaded', () => {
    // Получаем "сырой" закодированный URL
    let rawUrl = window.location.pathname + window.location.search;
    
    // Пытаемся декодировать кириллицу и спецсимволы
    let requestedUrl = rawUrl;
    try {
        requestedUrl = decodeURIComponent(rawUrl);
    } catch (e) {
        // Если URL содержит битые percent-последовательности,
        // оставляем исходный вариант, чтобы не ломать страницу
        console.warn('Не удалось декодировать URL:', e);
    }
    
    // Вставляем в интерфейс
    const urlEl = document.getElementById('requested-url');
    const logUrlEl = document.getElementById('log-url');
    if (urlEl) urlEl.textContent = requestedUrl;
    if (logUrlEl) logUrlEl.textContent = requestedUrl;

    // Динамический счётчик аномалий (случайное число для атмосферы)
    const baseCount = 404;
    const randomAdd = Math.floor(Math.random() * 50);
    const anomalyCountEl = document.getElementById('anomaly-count');
    if (anomalyCountEl) anomalyCountEl.textContent = baseCount + randomAdd;

    // Случайный глитч кода ошибки
    setInterval(() => {
        const code = document.getElementById('error-code');
        if (code && Math.random() > 0.7) {
            code.classList.add('glitch');
            setTimeout(() => code.classList.remove('glitch'), 300);
        }
    }, 3000);
});

// Функция "восстановления сигнала"
function attemptRestore() {
    const btn = event.target;
    const originalText = btn.textContent;
    btn.textContent = '⏳ ВОССТАНОВЛЕНИЕ...';
    btn.disabled = true;
    let progress = 0;
    const interval = setInterval(() => {
        progress += Math.random() * 15;
        if (progress >= 100) {
            clearInterval(interval);
            btn.textContent = '❌ ВОССТАНОВЛЕНИЕ НЕВОЗМОЖНО';
            btn.style.borderColor = 'var(--red)';
            btn.style.color = 'var(--red)';
            setTimeout(() => {
                btn.textContent = originalText;
                btn.disabled = false;
                btn.style.borderColor = '';
                btn.style.color = '';
                alert('Сигнал не удалось восстановить. Сектор окончательно утерян в аналоговом сдвиге.\nРекомендуется вернуться в архив.');
            }, 1500);
        } else {
            btn.textContent = `⏳ ВОССТАНОВЛЕНИЕ... ${Math.floor(progress)}%`;
        }
    }, 200);
}

// Консольное сообщение для любопытных разработчиков
console.log('%c⚠ ИЗМАЙЛОВО АРХИВ // СИСТЕМНОЕ СООБЩЕНИЕ', 'color: #ff0040; font-size: 16px; font-weight: bold;');
console.log('%cВы нашли страницу 404. Возможно, вы ищете что-то, что было намеренно скрыто.', 'color: #00ff41; font-size: 12px;');
console.log('%cПопробуйте: /secret/', 'color: #ffb000; font-size: 12px;');
</script>
</body>
</html>