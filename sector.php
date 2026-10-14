<?php
// ============================================================
// 1. ФУНКЦИЯ ОЧИСТКИ ДАННЫХ ОТ ПРОБЕЛОВ (для JSON)
// ============================================================
function clean_json_data($array) {
    if (!is_array($array)) {
        return is_string($array) ? trim($array) : $array;
    }
    $cleaned = [];
    foreach ($array as $key => $value) {
        $clean_key = trim($key);
        $clean_value = is_array($value)
            ? clean_json_data($value)
            : (is_string($value) ? trim($value) : $value);
        $cleaned[$clean_key] = $clean_value;
    }
    return $cleaned;
}

// ============================================================
// 2. СТРОГАЯ ВАЛИДАЦИЯ ID ИЗ URL
// ============================================================
$raw_id = $_GET['id'] ?? '';

// Разрешаем ТОЛЬКО ровно 2 цифры (например, "00", "05", "13").
// Любое отклонение (буквы, 1 цифра, 3+ цифры like "0013", спецсимволы) = ОШИБКА.
if (!preg_match('/^\d{2}$/', $raw_id)) {
    http_response_code(404);
    include __DIR__ . '/404.php';
    exit;
}

$sector_id = $raw_id; // Теперь $sector_id гарантированно в формате "XX"

// ============================================================
// 3. ЗАГРУЖАЕМ JSON
// ============================================================
$json_path = __DIR__ . '/data/data_free.json';
if (!file_exists($json_path)) {
    http_response_code(500);
    die("❌ ОШИБКА: Файл data_free.json не найден.");
}

$json_content = file_get_contents($json_path);
$bom = pack('H*', 'EFBBBF');
if (substr($json_content, 0, 3) === $bom) {
    $json_content = substr($json_content, 3);
}

$raw_data = json_decode($json_content, true);
if (json_last_error() !== JSON_ERROR_NONE) {
    http_response_code(500);
    die("❌ ОШИБКА JSON: " . json_last_error_msg());
}

$data = clean_json_data($raw_data);
if (!isset($data['sectors']) || !is_array($data['sectors'])) {
    http_response_code(500);
    die("❌ ОШИБКА: В JSON отсутствует массив 'sectors'");
}

// ============================================================
// 4. ИЩЕМ СЕКТОР
// ============================================================
$sector = null;
foreach ($data['sectors'] as $s) {
    if ($s['id'] === $sector_id) {
        $sector = $s;
        break;
    }
}

// ============================================================
// 5. ЕСЛИ СЕКТОР НЕ НАЙДЕН — СТРОГИЙ 404
// ============================================================
if (!$sector) {
    http_response_code(404);
    include __DIR__ . '/404.php';
    exit;
}

// ============================================================
// 6. ПРОВЕРКА НА УНИКАЛЬНУЮ СТРАНИЦУ (РЕДИРЕКТ)
// ============================================================
if (!empty($sector['is_unique_page']) && !empty($sector['unique_url'])) {
    header("Location: " . $sector['unique_url'], true, 301);
    exit;
}

// ============================================================
// 7. ФОРМИРУЕМ МЕТА-ДАННЫЕ (только если сектор найден и валиден)
// ============================================================
$page_title = "СЕКТОР {$sector['id']} // {$sector['title']}";
$operator_text = $sector['operator']['full'] ?? $sector['text_operator'] ?? 'Текст недоступен';
$page_description = mb_substr(strip_tags($operator_text), 0, 160);
$page_section = 'sector';
$page_sector_id = $sector['id'];

// FTP-метаданные
$numeric_id = (int)$sector['id'];
$file_size = number_format(1.5 + $numeric_id * 0.4, 1) . 'K';
$file_date = date('M d', strtotime('-' . $numeric_id . ' days'));
$file_perm = !empty($sector['is_premium']) ? '-rw-r-----' : '-rw-r--r--';

// Навигация (prev/next)
$all_ids = array_column($data['sectors'], 'id');
$current_index = array_search($sector_id, $all_ids);
$prev_id = $current_index > 0 ? $all_ids[$current_index - 1] : null;
$next_id = $current_index !== false && $current_index < count($all_ids) - 1 ? $all_ids[$current_index + 1] : null;

$page_ftp_meta = [
    'id' => $sector['id'],
    'subject' => $sector['title'],
    'status' => !empty($sector['is_premium']) ? 'PREMIUM' : 'FREE',
    'location' => $sector['location'] ?? 'N/A',
    'related' => ($prev_id ? $prev_id : 'START') . ', ' . ($next_id ? $next_id : 'END')
];

$page_script = 'sector.js';
require_once __DIR__ . '/includes/header.php';
?>

<div class="container">
    <!-- ═══ FTP-СТРОКА ПОДКЛЮЧЕНИЯ ═══ -->
    <div class="ftp-connect">
        <div><span class="ftp-prompt">ftp&gt;</span> <span class="ftp-cmd">get /IZMAILOVO/SECTORS/sector_<?= htmlspecialchars($sector['id']) ?>.txt</span></div>
        <div class="ftp-reply">200 PORT command successful.</div>
        <div class="ftp-reply">150 Opening ASCII mode data transfer.</div>
        <div class="ftp-reply">226 Transfer complete. <span style="color: var(--amber);"><?= $file_size ?> bytes received.</span></div>
    </div>

    <!-- ═══ ШАПКА СЕКТОРА ═══ -->
    <div class="page-header <?= !empty($sector['is_premium']) ? 'amber' : '' ?>">
        <div class="stamp <?= !empty($sector['is_premium']) ? 'amber' : '' ?>">
            <?= !empty($sector['is_premium']) ? 'ПРЕМИУМ' : 'СВОБОДНЫЙ ДОСТУП' ?>
        </div>
        <div class="header-id">ИЗМАЙЛОВО АРХИВ // СЕКТОР № <?= htmlspecialchars($sector['id']) ?></div>
        <h1 class="header-title"><?= htmlspecialchars($sector['title']) ?></h1>
        <div class="header-subtitle"><?= htmlspecialchars($sector['location'] ?? '') ?></div>
        <?php if (!empty($sector['coords'])): ?>
            <div class="header-dates">🌐 <?= htmlspecialchars($sector['coords']) ?></div>
        <?php endif; ?>
    </div>

    <!-- ═══ FTP-МЕТА СТРОКА ═══ -->
    <div style="max-width: 900px; margin: 0 auto 20px; padding: 10px 20px; background: rgba(0, 255, 65, 0.03); border: 1px solid rgba(0, 255, 65, 0.2); font-family: 'Share Tech Mono', monospace; font-size: 0.95rem;">
        <span style="color: #888;"><?= $file_perm ?></span>
        <span style="color: var(--amber); margin-left: 15px;">archivist</span>
        <span style="color: var(--cyan); margin-left: 15px;"><?= $file_size ?></span>
        <span style="color: var(--amber); margin-left: 15px;"><?= $file_date ?></span>
        <span style="color: #666; margin-left: 15px;">sector_<?= htmlspecialchars($sector['id']) ?>.txt</span>
    </div>

    <!-- ═══ БЛОК ЛОКАЦИИ ═══ -->
    <div class="location-block">
        <div class="location-item"><span>📍 ЛОКАЦИЯ:</span> <?= htmlspecialchars($sector['location'] ?? 'не указана') ?></div>
        <div class="location-item"><span>⏱ ВРЕМЯ:</span> ~3 минуты</div>
    </div>

    <!-- ═══ FTP-ЛИСТИНГ КАНАЛОВ ═══ -->
    <div class="ftp-listing">
        <div class="listing-header">
            <span class="ftp-prompt">ftp&gt;</span>
            <span class="ftp-command">ls /IZMAILOVO/SECTORS/sector_<?= htmlspecialchars($sector['id']) ?>/</span>
        </div>
        <div class="listing-output">
            <div class="listing-info">200 PORT command successful.</div>
            <div class="listing-info">150 Opening ASCII mode data transfer.</div>
        </div>

        <!-- ПЕРЕКЛЮЧАТЕЛЬ КАНАЛОВ (БЕЗ onclick) -->
        <div class="channels">
            <div class="channel-switcher">
                <button class="channel-btn active" data-channel="operator">📡 ОПЕРАТОР</button>
                <button class="channel-btn amber" data-channel="shuttle">📼 ЧЕЛНОК</button>
            </div>

            <!-- КАНАЛ ОПЕРАТОР (ТОЛЬКО ПОЛНЫЙ ТЕКСТ) -->
            <div class="channel-content active" id="content-operator">
                <div class="channel-label">📡 КАНАЛ "ОПЕРАТОР" // АРХИВНЫЕ ДАННЫЕ</div>
                <div class="channel-text"><?= nl2br(htmlspecialchars($operator_text)) ?></div>

                <?php if (!empty($sector['is_premium'])): ?>
                    <button class="audio-locked-btn" data-action="paywall">
                        🔒 🎧 СЛУШАТЬ АУДИО-ВЕРСИЮ
                        <span class="premium-note">Доступно по ключу "Архивариус" (299 ₽)</span>
                    </button>
                <?php else: ?>
                    <button class="audio-locked-btn" data-action="paywall" style="border-color: var(--text-color); color: var(--text-color);">
                        🎧 СЛУШАТЬ АУДИО-ВЕРСИЮ
                        <span class="premium-note">Доступно по ключу "Архивариус" (299 ₽)</span>
                    </button>
                <?php endif; ?>
            </div>

            <!-- КАНАЛ ЧЕЛНОК (ТОЛЬКО ПОЛНЫЙ ТЕКСТ) -->
            <div class="channel-content" id="content-shuttle">
                <div class="channel-label">📼 КАНАЛ "ЧЕЛНОК" // ГОЛОС ИЗ ПРОШЛОГО</div>
                <div class="channel-text amber"><?= nl2br(htmlspecialchars($shuttle_text)) ?></div>

                <button class="audio-locked-btn" data-action="paywall">
                    🔒 🎧 СЛУШАТЬ ГОЛОС ЧЕЛНОКА
                    <span class="premium-note">Доступно по ключу "Архивариус" (299 ₽)</span>
                </button>
            </div>
        </div>

        <div class="listing-footer">
            <div class="listing-info">226 Transfer complete.</div>
            <div class="listing-summary">
                2 channels, <?= !empty($sector['is_premium']) ? '1 premium' : '0 premium' ?>, <?= !empty($sector['has_expansions']) ? 'expansions available' : 'no expansions' ?>.
            </div>
        </div>
    </div>

    <!-- ═══ МЕДИА-ГАЛЕРЕЯ ═══ -->
    <?php if (!empty($sector['media']) && is_array($sector['media'])): ?>
        <div class="media-gallery-block">
            <div class="gallery-header">📁 АРХИВНЫЕ МАТЕРИАЛЫ СЕКТОРА <?= htmlspecialchars($sector['id']) ?></div>
            <div class="gallery-grid">
                <?php foreach ($sector['media'] as $item): ?>
                    <div class="gallery-item">
                        <?php if ($item['type'] === 'image'): ?>
                            <img src="/<?= ltrim($item['src'], '/') ?>" alt="<?= htmlspecialchars($item['caption'] ?? '') ?>" loading="lazy">
                        <?php elseif ($item['type'] === 'video'): ?>
                            <video controls poster="/<?= ltrim($item['poster'] ?? $item['src'], '/') ?>">
                                <source src="/<?= ltrim($item['src'], '/') ?>" type="video/mp4">
                                Ваш браузер не поддерживает видео.
                            </video>
                        <?php endif; ?>
                        <?php if (!empty($item['caption'])): ?>
                            <div class="gallery-caption"><?= htmlspecialchars($item['caption']) ?></div>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    <?php endif; ?>

    <!-- ═══ НАВИГАЦИЯ МЕЖДУ СЕКТОРАМИ ═══ -->
    <div class="nav-footer">
        <?php if ($prev_id !== null): ?>
            <a href="/sector/?id=<?= $prev_id ?>" class="nav-btn">← СЕКТОР <?= $prev_id ?></a>
        <?php else: ?>
            <a href="/" class="nav-btn">← В АРХИВ</a>
        <?php endif; ?>
        
        <?php if ($next_id !== null): ?>
            <a href="/sector/?id=<?= $next_id ?>" class="nav-btn">СЕКТОР <?= $next_id ?> →</a>
        <?php else: ?>
            <a href="/tour/" class="nav-btn">К МАРШРУТУ →</a>
        <?php endif; ?>
    </div>

    <!-- ═══ PAYWALL МОДАЛКА ═══ -->
    <div class="paywall-overlay" id="paywall">
        <div class="paywall-content">
            <button class="paywall-close" data-action="close-paywall">✕</button>
            <div class="paywall-icon">🔒</div>
            <div class="paywall-title">ДОСТУП ЗАБЛОКИРОВАН</div>
            <div class="paywall-text">
                Аудио-версия и архивные документы этого сектора доступны по ключу "Архивариус".
            </div>
            <div class="paywall-price">299 ₽</div>
            <button class="paywall-btn" data-action="initiate-payment">🔓 КУПИТЬ КЛЮЧ</button>
        </div>
    </div>
</div>    


<?php require_once __DIR__ . '/includes/footer.php'; ?>