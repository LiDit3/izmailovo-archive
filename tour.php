<?php
$page_title       = 'МАРШРУТ // ЭХО МАШИН // ИЗМАЙЛОВО АРХИВ';
$page_description = 'Аудио-экскурсия по посёлку Измайлово. 16 секторов, 2.5 часа погружения в историю суконной мануфактуры Шатрова.';
$page_section     = 'tour';

require_once __DIR__ . '/includes/header.php';

// Загрузка данных
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

$json_path = __DIR__ . '/data/data_free.json';
$sectors = [];

if (file_exists($json_path)) {
    $json_content = file_get_contents($json_path);
    $bom = pack('H*', 'EFBBBF');
    if (substr($json_content, 0, 3) === $bom) {
        $json_content = substr($json_content, 3);
    }
    $raw_data = json_decode($json_content, true);
    // ПРИМЕНЯЕМ ОЧИСТКУ: это удалит все пробелы в ключах ("operator " -> "operator")
    $data = clean_json_data($raw_data);
    $sectors = $data['sectors'] ?? [];
}
$expansions = $data['expansions'] ?? [];
$total_sectors = count($sectors);
?>

<div class="container">
	<div class="ftp-listing">
		<div class="listing-header">
			<span class="ftp-prompt">ftp&gt;</span>
			<span class="ftp-command">get /IZMAILOVO/TOURS/echo_of_machines.gpx</span></span>
		</div>
		<div class="listing-output" id="ftp-output">
            <div class="listing-info typing-line">200 PORT command successful.</div>
            <div class="listing-info typing-line">150 Opening BINARY mode data transfer.</div>
            <div class="listing-info typing-line">226 Transfer complete. <span style="color: var(--amber);"><?= $total_sectors ?> sectors loaded.</span></div> 
		</div>
	</div>

    <div class="route-header">
        <div class="stamp-route">МАРШРУТ</div>
        <h1 class="glitch" data-text="ЭХО МАШИН">ЭХО МАШИН</h1>
        <div class="route-id">ИЗМАЙЛОВО АРХИВ // МАРШРУТ № 001</div>
        <div class="route-subtitle">Аудио-экскурсия по посёлку Измайлово // <?= $total_sectors ?> секторов // ~2.5 часа</div>
        <div class="route-quote">
         "Жизнь человека, как полотно, и только от вас зависит, какого качества и красоты оно будет."
        </div>
    </div>


<!-- ═══ ПАНЕЛЬ СТАТИСТИКИ (в стиле FTP-сессии) ═══ -->
<div class="stats-panel">
    <div class="stat-item">
        <div class="stat-label">Прогресс маршрута</div>
        <div class="stat-value" id="progress-percent">0%</div>
        <div class="stat-bar">
            <div class="stat-bar-fill" id="progress-bar" style="width: 0%"></div>
        </div>
    </div>
    <div class="stat-item">
        <div class="stat-label">Пройдено секторов</div>
        <div class="stat-value" id="completed-count">0/<?= $total_sectors ?></div>
    </div>
    <div class="stat-item">
        <div class="stat-label">Доступно секторов</div>
        <div class="stat-value"><?= $total_sectors ?>/<?= $total_sectors ?></div>
    </div>
    <div class="stat-item">
        <div class="stat-label">Расчётное время</div>
        <div class="stat-value">2.5 ЧАСА</div>
    </div>
</div>

<!-- ═══ ВВЕДЕНИЕ В МАРШРУТ ═══ -->
<div class="route-intro">
    <div class="channel-switcher">
        <button class="channel-btn active" data-channel="operator">📡 КАНАЛ "ОПЕРАТОР"</button>
        <button class="channel-btn amber" data-channel="shuttle">📼 КАНАЛ "ЧЕЛНОК"</button>
    </div>

    <div class="channel-content active" id="channel-operator">
        <div class="channel-label">📡 КАНАЛ "ОПЕРАТОР" // ИНСТРУКТАЖ</div>
        <div class="channel-text">
            Добро пожаловать в посёлок Измайлово. Перед вами маршрут "Эхо машин" — аудио-экскурсия по историческим объектам бывшей суконной мануфактуры. Маршрут проходит через <?= $total_sectors ?> ключевых точек, связанных с историей посёлка от основания в XVIII веке до наших дней. Вы пройдёте по улице Советской, увидите здание первой ТЭЦ губернии, часовню, Дом культуры и завершите прогулку на мосту между прудами. Рекомендуется начать с сектора 00 у здания Администрации. Наденьте наушники, зарядите телефон и приготовьтесь к погружению в историю.
            <br><br>
            <span style="color: var(--amber); font-size: 1rem;">
                ℹ️ Все тексты секторов доступны бесплатно. Полное аудио-погружение с голосом Челнока и архивные документы — по ключу "Архивариус" (299 ₽).
            </span>
        </div>
    </div>

    <div class="channel-content" id="channel-shuttle">
        <div class="channel-label">📼 КАНАЛ "ЧЕЛНОК" // ПРИГЛАШЕНИЕ</div>
        <div class="channel-text amber">
            Ну вот и вы добрались до нас! Я так рад, что вы приехали. Вы только оглянитесь вокруг — какие у нас места красивые, живописные. Посёлок наш в низине стоит, в окружении сосновых лесов, у истока реки Мурки. А я ведь здесь родился, здесь и прожил всю свою жизнь — сначала в лесу деревом был, потом на фабрике челноком трудился, а теперь вот память храню и истории рассказываю. Пойдёмте со мной, я вам покажу всё самое интересное. Только не торопитесь, слушайте внимательно — я ведь многое повидал за свои почти двести лет. И помните: жизнь как полотно, и только от вас зависит, какого качества оно будет.
        </div>
    </div>
</div>

<!-- ═══ FTP-ЛИСТИНГ СЕКТОРОВ ═══ -->
<div class="ftp-listing">    
    <div class="sectors-title">📍 ТОЧКИ МАРШРУТА</div>  

    <div class="sectors-list">

        <?php foreach ($sectors as $sector): ?>
            <?php 
            // 1. Ссылка: уникальная страница или стандартный сектор
            $sector_link = !empty($sector['is_unique_page']) ? $sector['unique_url'] : "/sector/?id=" . $sector['id'];
            
            // 2. CSS-класс для уникальных объектов
            $unique_class = !empty($sector['is_unique_page']) ? "unique-sector" : "";
            
            // 3. Расширения для текущего сектора
            $sector_exps = array_filter($expansions, fn($e) => $e['parent_sector'] === $sector['id']);
            $has_exps = !empty($sector_exps);
            
            // 4. FTP-метаданные (псевдо-размер и дата)
            $file_size = number_format(8 + intval($sector['id']) * 1.3, 1) . 'K';
            $file_date = date('M d', strtotime('-' . intval($sector['id']) . ' days'));
            $file_perm = !empty($sector['is_unique_page']) ? '-rw-r-----' : '-rw-r--r--';

                // Безопасно получаем текст Оператора (поддержка и новой, и старой структуры)
    $operator_text = '';
    if (isset($sector['operator']['teaser'])) {
        $operator_text = $sector['operator']['teaser'];
    } elseif (isset($sector['text_operator'])) {
        $operator_text = $sector['text_operator'];
    }

    // Безопасно получаем текст Челнока
    $shuttle_text = '';
    if (isset($sector['shuttle']['teaser'])) {
        $shuttle_text = $sector['shuttle']['teaser'];
    } elseif (isset($sector['text_shuttle'])) {
        $shuttle_text = $sector['text_shuttle'];
    }
            ?>

        <a href="<?= $sector_link ?>" class="sector-item <?= $unique_class ?>" data-sector="<?= $sector['id'] ?>">  
            <div class="sector-header-row">

            <?php if (!empty($sector['is_unique_page'])): ?>
                <span class="unique-badge">✨ УНИКАЛЬНЫЙ ОБЪЕКТ</span>
            <?php endif; ?>

                <div class="sector-id">СЕКТОР <?= $sector['id'] ?></div>
                <div class="sector-status free">СВОБОДНЫЙ ДОСТУП</div>
            </div>                
            <div class="sector-row">                
                <div class="sector-title"><?= htmlspecialchars($sector['title'] ?? 'Без названия', ENT_QUOTES, 'UTF-8') ?></div>
                <div class="sector-location">📍 <?= htmlspecialchars($sector['location']) ?></div>
                <div class="file-desc"><?= htmlspecialchars($operator_text ?: 'Текст временно недоступен', ENT_QUOTES, 'UTF-8') ?></div>
                <div class="sector-audio-note">🎧 Аудио доступно по ключу</div>                
                
                <?php if ($has_exps): ?>
                <div class="sector-expansions-block">
                    <div class="expansions-label">📦 ВКЛЮЧАЕТ ИСТОРИЧЕСКИЕ РАСШИРЕНИЯ:</div>
                    <?php foreach ($sector_exps as $exp): ?>
                        <?php 
                            $release_time = strtotime($exp['release_date']);
                            $is_future = $release_time > time();
                            ?>
                    <div class="expansion-preview-item">
                        <span style="color: <?= $is_future ? '#888' : 'var(--text-color)' ?>;">
                            <?= $is_future ? '⏳' : '✅' ?> <?= htmlspecialchars($exp['title']) ?>
                        </span>
                        <span style="font-size: 0.8rem; color: var(--amber);">
                            <?= $is_future ? 'Релиз: ' . date('d.m.Y', $release_time) : '💎 Подписка' ?>
                        </span>
                    </div>
                    <?php endforeach; ?>
                </div>
                <?php endif; ?>
            </div>
                
            <div class="file-meta">
                <span class="item-permissions"><?= $file_perm ?></span>
                <span class="item-owner">archivist</span>
                <span class="item-size"><?= $file_size ?></span>
                <span class="item-date"><?= $file_date ?></span>
            </div>
        </a>
        <?php endforeach; ?>
    </div>

    <div class="listing-footer">
        <div class="listing-info">226 Transfer complete.</div>
        <div class="listing-summary">
            <?= $total_sectors ?> files, 1 anomaly detected. Transfer complete.
        </div>
    </div>
</div>

<!-- ═══ РЕКОМЕНДАЦИИ (в стиле инструкции) ═══ -->
<div class="ftp-manual">
    <div class="manual-header">
        <span class="ftp-prompt">ftp&gt;</span>
        <span class="ftp-command">cat /IZMAILOVO/TOURS/manual.txt</span>
    </div>

    <div class="manual-content">
        <div class="rec-title">📋 ИНСТРУКТАЖ ПЕРЕД МАРШРУТОМ</div>
        <div class="rec-grid">
            <div class="rec-item">
                <div class="rec-item-title">Что взять с собой</div>
                <div class="rec-item-text">
                    <ul>
                        <li>Заряженный смартфон</li>
                        <li>Наушники (обязательно для аудио)</li>
                        <li>Удобная обувь</li>
                        <li>Вода</li>
                        <li>Хорошее настроение</li>
                    </ul>
                </div>
            </div>
            <div class="rec-item">
                <div class="rec-item-title">Сложность маршрута</div>
                <div class="rec-item-text">
                    <ul>
                        <li>Расстояние: ~3 км</li>
                        <li>Время: 2-2.5 часа</li>
                        <li>Рельеф: равнинный</li>
                        <li>Доступность: для всех возрастов</li>
                    </ul>
                </div>
            </div>
            <div class="rec-item">
                <div class="rec-item-title">Правила маршрута</div>
                <div class="rec-item-text">
                    <ul>
                        <li>Слушайте аудио на каждой точке</li>
                        <li>Не сходите с тропы</li>
                        <li>Уважайте частную собственность</li>
                        <li>Не мусорите</li>
                        <li>Делитесь впечатлениями</li>
                    </ul>
                </div>
            </div>
            <div class="rec-item">
                <div class="rec-item-title">Монетизация</div>
                <div class="rec-item-text">
                    <ul>
                        <li>✅ Все тексты секторов — бесплатно</li>
                        <li>🎧 Аудио-каналы — по ключу (299 ₽)</li>
                        <li>🔒 Архивные документы — по ключу</li>
                        <li>💎 Исторические расширения — по подписке</li>
                        <li>📊 Прогресс сохраняется автоматически</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- ═══ КНОПКА СТАРТА ═══ -->
<div class="start-section">
    <a href="/sector/?id=00" class="start-btn" style="text-decoration: none; display: inline-block;">🎧 НАЧАТЬ МАРШРУТ</a>
    <p style="margin-top: 20px; font-size: 1.2rem; color: #888;">
        Рекомендуется начать с сектора 00 у здания Администрации
    </p>
</div>

<!-- ═══ НАВИГАЦИЯ ═══ -->
<div class="nav-footer">
    <a href="/" class="nav-btn">← В АРХИВ</a>
    <a href="/shatrov/" class="nav-btn">ДОСЬЕ ШАТРОВА →</a>
</div>

</div>
<?php require_once __DIR__ . '/includes/footer.php'; ?>