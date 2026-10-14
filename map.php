<?php
$page_title       = 'ТАКТИЧЕСКАЯ КАРТА // МАРШРУТ "ЭХО МАШИН" // ИЗМАЙЛОВО';
$page_description = 'Интерактивная карта маршрута по посёлку Измайлово. 16 секторов, аномальные зоны, уникальные объекты.';
$page_keywords    = 'карта, маршрут, Измайлово, Эхо машин, GPS, секторы, Stadia Maps';
$page_og_image    = '/assets/og_map.jpg';
$page_section     = 'map';
$page_script      = 'map.js';

$page_ftp_meta = [
    'id'       => '1890',
    'subject'  => 'Tactical Map',
    'status'   => 'ONLINE',
    'location' => 'Измайлово, Ульяновская обл.',
    'related'  => 'SECTORS: 16'
];

function clean_json_data($array) {
    if (!is_array($array)) {
        return is_string($array) ? trim($array) : $array;
    }
    
    $cleaned = [];
    foreach ($array as $key => $value) {
        $clean_key = trim($key); // Убираем пробелы из ключей ("id " -> "id")
        $clean_value = is_array($value) 
            ? clean_json_data($value) // Рекурсивная очистка вложенных массивов
            : (is_string($value) ? trim($value) : $value); // Убираем пробелы из значений
        $cleaned[$clean_key] = $clean_value;
    }
    return $cleaned;
}

$json_path = __DIR__ . '/data/data_free.json';
$data = [];
$sectors = [];

if (file_exists($json_path)) {
    $json_content = file_get_contents($json_path);
    
    $bom = pack('H*', 'EFBBBF');
    if (substr($json_content, 0, 3) === $bom) {
        $json_content = substr($json_content, 3);
    }
    
    $raw_data = json_decode($json_content, true);
    
    $data = clean_json_data($raw_data);
    $sectors = $data['sectors'] ?? [];
}

$map_sectors = array_map(function($s) {
    $teaser = '';
    if (isset($s['operator']['teaser'])) {
        $teaser = $s['operator']['teaser'];
    } else {
        $teaser = mb_substr(strip_tags($s['text_operator'] ?? ''), 0, 120);
    }

    return [
        'id' => $s['id'] ?? '',
        'title' => $s['title'] ?? '',
        'location' => $s['location'] ?? '',
        'coords' => $s['coords'] ?? '',
        'is_premium' => !empty($s['is_premium']),
        'is_unique_page' => !empty($s['is_unique_page']), // ВАЖНО: точное имя ключа из JSON
        'unique_url' => $s['unique_url'] ?? '',
        // ВАЖНО: очистка тегов от пробелов для корректной работы фильтра в JS
        'tags' => isset($s['tags']) && is_array($s['tags']) ? array_map('trim', $s['tags']) : [],
        'text_preview' => trim($teaser)
    ];
}, $sectors);

$sectors_json = htmlspecialchars(json_encode($map_sectors, JSON_UNESCAPED_UNICODE), ENT_QUOTES, 'UTF-8');

$total_sectors = count($sectors);

$unique_count = 0;
foreach ($sectors as $s) {
    if (!empty($s['is_unique_page'])) $unique_count++;
}

require_once __DIR__ . '/includes/header.php';
?>

<!-- MapLibre GL JS -->
<link href="/assets/maplibre-gl.css" rel="stylesheet" />
<script src="/assets/maplibre-gl.js"></script>

<!-- ═══ PAYWALL МОДАЛКА ═══ -->
<div class="paywall-overlay" id="paywall">
    <div class="paywall-content">
        <button class="paywall-close">✕</button>
        <div class="paywall-icon">🗺️</div>
        <div class="paywall-title">ЗОНА ОГРАНИЧЕННОГО ДОСТУПА</div>
        <div class="paywall-text">
            Этот сектор требует ключа "Архивариус" для полного доступа.<br>
            Получите ключ для разблокировки всех материалов.
        </div>
        <div class="paywall-price">299 ₽</div>
        <button class="paywall-btn">🔓 КУПИТЬ КЛЮЧ</button>
    </div>
</div>

<!-- ═══ FTP-СТРОКА ПОДКЛЮЧЕНИЯ ═══ -->
<div class="ftp-connect">
    <div><span class="ftp-prompt">ftp&gt;</span> <span class="ftp-cmd">get /IZMAILOVO/MAP/tactical_1890.map</span></div>
    <div class="ftp-reply">200 PORT command successful.</div>
    <div class="ftp-reply">150 Opening BINARY mode data transfer.</div>
    <div class="ftp-reply">226 Transfer complete. <span style="color: var(--amber);"><?= $total_sectors ?> sectors loaded.</span></div>
</div>

<!-- ═══ ШАПКА КАРТЫ ═══ -->
<div class="page-header cyan">
    <div class="stamp cyan">ТАКТИЧЕСКАЯ</div>
    <div class="header-id" style="color: var(--cyan);">ИЗМАЙЛОВО АРХИВ // УЗЕЛ 1890 // КАРТОГРАФИЯ</div>
    <h1 class="header-title" style="color: var(--cyan); text-shadow: var(--cyan-glow);">ТАКТИЧЕСКАЯ КАРТА</h1>
    <div class="header-subtitle">Интерактивная карта маршрута "Эхо машин" // <?= $total_sectors ?> секторов // ~3.2 км</div>
    <div class="header-quote" style="border-color: var(--cyan); color: var(--cyan);">
        "Все точки маршрута привязаны к реальным координатам. Используйте карту для навигации."
    </div>
</div>

<!-- ═══ FTP-МЕТА СТРОКА ═══ -->
<div style="max-width: 900px; margin: 0 auto 20px; padding: 10px 20px; background: rgba(0, 229, 255, 0.03); border: 1px solid rgba(0, 229, 255, 0.2); font-family: 'Share Tech Mono', monospace; font-size: 0.95rem;">
    <span style="color: #888;">-rw-r--r--</span>
    <span style="color: var(--amber); margin-left: 15px;">archivist</span>
    <span style="color: var(--cyan); margin-left: 15px;">24.1K</span>
    <span style="color: var(--amber); margin-left: 15px;"><?= date('M d') ?></span>
    <span style="color: #666; margin-left: 15px;">tactical_1890.map</span>
</div>

<!-- ═══ ПАНЕЛЬ ФИЛЬТРОВ ═══ -->
<div class="map-filters">
    <div class="filters-header">
        <span class="ftp-prompt">ftp&gt;</span>
        <span class="ftp-cmd">ls /IZMAILOVO/MAP/DIRECTORY/</span>
    </div>
    <div class="filters-buttons">
        <button class="filter-btn active" data-filter="all">[ ВСЕ ]</button>
        <button class="filter-btn" data-filter="поселок">[ ПОСЕЛОК ]</button>
        <button class="filter-btn" data-filter="фабрика">[ ФАБРИКА ]</button>
        <button class="filter-btn" data-filter="аномалия">[ АНОМАЛИИ ]</button>
        <button class="filter-btn amber" data-filter="экспедиция">[ ЭКСПЕДИЦИЯ ]</button>
    </div>
</div>

<!-- ═══ КОНТЕЙНЕР КАРТЫ С DATA-АТРИБУТОМ ═══ -->
<div class="map-terminal" id="map-terminal">
    <div class="terminal-header">
        <div class="terminal-title">◈ ИЗМАЙЛОВО :: УЗЕЛ 1890 :: MAPLIBRE</div>
        <div class="terminal-status">
            NODE: <span style="color: var(--text-color);">ONLINE</span> ● 
            ТОЧЕК: <span style="color: var(--amber);"><?= $total_sectors ?></span> | 
            МАРШРУТ: <span style="color: var(--cyan);">3.2 КМ</span>
        </div>
        <!-- КНОПКА ПОЛНОЭКРАННОГО РЕЖИМА -->
        <button id="fullscreen-btn" class="fullscreen-btn" title="Развернуть на весь экран">⛶</button>
    
    </div>
    
    <!-- ВАЖНО: добавлен атрибут data-sectors -->
    <div id="map" data-sectors='<?= $sectors_json ?>'></div>
</div>

<!-- ═══ СТАТИСТИКА МАРШРУТА ═══ -->
<div class="stats-panel">
    <div class="stat-item">
        <div class="stat-label">Всего секторов</div>
        <div class="stat-value"><?= $total_sectors ?></div>
    </div>
    <div class="stat-item">
        <div class="stat-label">Уникальных объектов</div>
        <div class="stat-value" style="color: var(--cyan);"><?= $unique_count ?></div>
    </div>
    <div class="stat-item">
        <div class="stat-label">Пройдено вами</div>
        <div class="stat-value" id="map-completed">0</div>
    </div>
    <div class="stat-item">
        <div class="stat-label">Расчётное время</div>
        <div class="stat-value">2.5 Ч</div>
    </div>
</div>

<!-- ═══ ИНСТРУКЦИЯ ПО ИСПОЛЬЗОВАНИЮ ═══ -->
<div class="recommendations">
    <div class="rec-title">🗺️ КАК РАБОТАТЬ С КАРТОЙ</div>
    <div class="rec-grid">
        <div class="rec-item">
            <div class="rec-item-title">Навигация</div>
            <div class="rec-item-text">
                Используйте мышь или пальцы для перемещения карты. Колёсико мыши для масштабирования.
            </div>
        </div>
        <div class="rec-item">
            <div class="rec-item-title">Маркеры</div>
            <div class="rec-item-text">
                🟢 Зелёный — свободный доступ<br>
                🔵 Циановый — уникальный объект<br>
                🔴 Красный — требуется ключ
            </div>
        </div>
        <div class="rec-item">
            <div class="rec-item-title">Попапы</div>
            <div class="rec-item-text">
                Кликните на маркер, чтобы увидеть информацию о секторе и перейти на его страницу.
            </div>
        </div>
        <div class="rec-item">
            <div class="rec-item-title">Фильтры</div>
            <div class="rec-item-text">
                Используйте кнопки сверху для фильтрации секторов по типу: фабрика, социальные объекты, аномалии.
            </div>
        </div>
    </div>
</div>

<!-- ═══ FTP-ПОДВАЛ КАРТЫ ═══ -->
<div class="ftp-footer" style="border-color: rgba(0, 229, 255, 0.2); background: rgba(0, 229, 255, 0.02);">
    <div class="ftp-footer-line">
        <span class="ftp-prompt">ftp&gt;</span>
        <span class="ftp-cmd">status tactical_1890</span>
    </div>
    <div class="ftp-footer-output">
        Map Type: <span style="color: var(--cyan);">TACTICAL</span><br>
        Engine: <span style="color: var(--text-color);">MapLibre GL JS 3.6.2 + Stadia Maps</span><br>
        Sectors Loaded: <span style="color: var(--amber);"><?= $total_sectors ?></span><br>
        Center: <span style="color: var(--text-color);">53.7685°N, 47.1130°E</span><br>
        ⚠ <span style="color: var(--red);">АНАЛОГОВЫЙ СДВИГ АКТИВЕН</span>
    </div>
</div>

<!-- ═══ НАВИГАЦИЯ ═══ -->
<div class="nav-footer">
    <a href="/" class="nav-btn">← В АРХИВ</a>
    <a href="/tour/" class="nav-btn">К СПИСКУ МАРШРУТА →</a>
</div>

<!-- ═══ CSS ДЛЯ КАРТЫ ═══ -->
<style>
/* Терминал карты */
.map-terminal {
    max-width: 1000px;
    margin: 20px auto;
    border: 2px solid var(--cyan);
    background: rgba(0, 229, 255, 0.02);
    position: relative;
    box-shadow: 0 0 20px rgba(0, 229, 255, 0.2);
}

.terminal-header {
    padding: 15px 20px;
    border-bottom: 1px dashed var(--cyan);
    display: flex;
    justify-content: space-between;
    align-items: center;
    background: rgba(0, 229, 255, 0.05);
    flex-wrap: wrap;
    gap: 10px;
}

.terminal-title {
    font-size: 1.3rem;
    color: var(--cyan);
    letter-spacing: 2px;
    text-shadow: var(--cyan-glow);
    font-family: 'Share Tech Mono', monospace;
}

.terminal-status {
    font-family: 'Share Tech Mono', monospace;
    font-size: 0.9rem;
    color: #888;
}

#map {
    width: 100%;
    height: 600px;
    background: #0a0a0a;
    position: relative;
}

/* Панель фильтров */
.map-filters {
    max-width: 1000px;
    margin: 20px auto;
    padding: 15px 20px;
    border: 1px solid rgba(0, 229, 255, 0.3);
    background: rgba(0, 0, 0, 0.3);
    font-family: 'Share Tech Mono', monospace;
}

.filters-header {
    margin-bottom: 10px;
    font-size: 1rem;
}

.filters-buttons {
    display: flex;
    gap: 10px;
    flex-wrap: wrap;
}

/* Кастомные маркеры */
.custom-marker {
    width: 32px;
    height: 32px;
    background: var(--bg-color);
    border: 2px solid var(--text-color);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 16px;
    cursor: pointer;
    box-shadow: 0 0 10px var(--text-color);
    transition: transform 0.2s;
}

.custom-marker:hover {
    transform: scale(1.3);
}

.custom-marker.unique {
    border-color: var(--cyan);
    color: var(--cyan);
    box-shadow: 0 0 15px var(--cyan);
}

.custom-marker.locked {
    border-color: var(--red);
    color: var(--red);
    box-shadow: 0 0 10px var(--red);
}

.custom-marker.completed {
    background: var(--amber);
    border-color: var(--amber);
    color: var(--bg-color);
    box-shadow: 0 0 15px var(--amber);
}

/* Стилизация элементов управления MapLibre */
.maplibregl-ctrl-group {
    background: rgba(5, 5, 5, 0.9) !important;
    border: 1px solid var(--cyan) !important;
    box-shadow: 0 0 10px rgba(0, 229, 255, 0.3) !important;
}

.maplibregl-ctrl-group button {
    background-image: none !important;
    color: var(--cyan) !important;
    font-family: 'Share Tech Mono', monospace !important;
    font-size: 1.2rem !important;
}

.maplibregl-ctrl-group button:hover {
    background: rgba(0, 229, 255, 0.2) !important;
}

.maplibregl-ctrl-attrib {
    background: rgba(5, 5, 5, 0.8) !important;
    color: #555 !important;
    font-family: 'Share Tech Mono', monospace !important;
    font-size: 0.7rem !important;
}

.maplibregl-ctrl-attrib a {
    color: var(--cyan) !important;
}

/* Попап в стиле терминала */
.maplibregl-popup-content {
    background: rgba(5, 5, 5, 0.95) !important;
    border: 1px solid var(--amber) !important;
    color: var(--text-color) !important;
    font-family: 'VT323', monospace !important;
    font-size: 1.1rem !important;
    padding: 15px !important;
    box-shadow: 0 0 20px rgba(255, 176, 0, 0.3) !important;
    max-width: 300px !important;
}

.maplibregl-popup-tip {
    border-top-color: var(--amber) !important;
}

.maplibregl-popup-close-button {
    color: var(--amber) !important;
    font-size: 1.2rem !important;
}

.popup-id {
    color: var(--amber);
    font-size: 0.9rem;
    margin-bottom: 5px;
    font-family: 'Share Tech Mono', monospace;
}

.popup-title {
    color: var(--amber);
    font-size: 1.3rem;
    margin-bottom: 8px;
    text-shadow: var(--amber-glow);
    line-height: 1.3;
}

.popup-location {
    color: #aaa;
    font-size: 0.95rem;
    margin-bottom: 10px;
    font-family: 'Share Tech Mono', monospace;
}

.popup-status {
    display: inline-block;
    padding: 3px 10px;
    border: 1px solid;
    font-size: 0.85rem;
    margin-bottom: 10px;
    text-transform: uppercase;
    letter-spacing: 1px;
}

.popup-status.free {
    color: var(--text-color);
    border-color: var(--text-color);
}

.popup-status.premium {
    color: var(--red);
    border-color: var(--red);
}

.popup-status.unique {
    color: var(--cyan);
    border-color: var(--cyan);
}

.popup-link {
    display: inline-block;
    margin-top: 10px;
    padding: 6px 15px;
    border: 1px solid var(--text-color);
    color: var(--text-color);
    text-decoration: none;
    font-size: 1rem;
    transition: all 0.3s;
    font-family: 'VT323', monospace;
}

.popup-link:hover {
    background: var(--text-color);
    color: var(--bg-color);
}

.popup-link.premium {
    border-color: var(--red);
    color: var(--red);
}

.popup-link.premium:hover {
    background: var(--red);
    color: white;
}

.popup-link.unique {
    border-color: var(--cyan);
    color: var(--cyan);
}

.popup-link.unique:hover {
    background: var(--cyan);
    color: var(--bg-color);
}

/* CRT-эффект поверх карты */
.map-terminal::after {
    content: " ";
    display: block;
    position: absolute;
    top: 0; left: 0; bottom: 0; right: 0;
    background: linear-gradient(rgba(18, 16, 16, 0) 50%, rgba(0, 0, 0, 0.1) 50%);
    background-size: 100% 2px;
    pointer-events: none;
    z-index: 10;
}

/* Адаптивность */
@media (max-width: 768px) {
    #map {
        height: 400px;
    }
    
    .terminal-header {
        flex-direction: column;
        text-align: center;
    }
    
    .terminal-title {
        font-size: 1rem;
    }
    
    .filters-buttons {
        justify-content: center;
    }
    
    .filter-btn {
        font-size: 1rem;
        padding: 8px 15px;
    }
}
</style>

<?php require_once __DIR__ . '/includes/footer.php'; ?>