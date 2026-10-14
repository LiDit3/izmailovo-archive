<?php
$page_section = 'home';
$page_script = 'index.js'; // Экран загрузки

require_once __DIR__ . '/includes/header.php';
?>


<!-- ЭКРАН ЗАГРУЗКИ -->
<div id="boot-screen">
	<div class="boot-text" id="boot-text"></div>
	<span class="cursor"></span>
</div>

<div class="container">
	<div id="main-hub">
		<header class="main-header">
			<h1 class="glitch" data-text="АРХИВ: ИЗМАЙЛОВО_1890">АРХИВ: ИЗМАЙЛОВО_1890</h1>
			<div class="subtitle">[ Узел памяти // Барышский район, Ульяновская область. ]</div>
			<div class="header-status">
				<span class="status-dot"></span>
				Статус: <span style="color: var(--text-color);">Рассинхронизация времени обнаружена</span>
			</div>
		</header>

		<div class="ftp-listing">
			<div class="listing-header">
				<span class="ftp-prompt">ftp&gt;</span>
				<span class="ftp-command" id="ftp-cmd"></span><span class="cursor-blink" id="ftp-cursor"></span>
			</div>
			<div class="listing-output" id="ftp-output"> 
			</div>
		</div>

		<div class="sectors-list" id="sectors-list">
			<a href="/shatrov/" class="sector-item premium">
				<div class="sector-row">
					<span class="file-name"><span class="tag-dir">[DIR]</span> N.YA_SHATROV_ARCHIVE/</span>
					<span class="file-desc">Досье: купец Н.Я. Шатров (1853–<span style="color: var(--red);">[ЗАСЕКРЕЧЕНО В УЗЛЕ 0x666]</span>)</span>
				</div>
				<div class="file-meta">
					<span class="item-permissions">-rw-r--r--</span>
					<span class="item-owner">archivist</span>
					<span class="item-size">12.4K</span>
					<span class="item-date"><?= date('M d', strtotime('-1 day')) ?></span>
				</div>
			</a>

			<a href="/chp/" class="sector-item anomaly">
				<div class="sector-row">
					<span class="file-name"><span class="tag-dir">[DIR]</span> POWER_PLANT_LOGS/</span>
					<span class="file-desc">Первая электростанция Симбирской губернии. Опережение на 24 года. Гул продолжается. <span class="item-tag">[ЧЕРТЕЖИ/ВИДЕО]</span></span>
				</div>
				<div class="file-meta">
					<span class="item-permissions">-rw-r-----</span>
					<span class="item-owner">archivist</span>
					<span class="item-size">8.7K</span>
					<span class="item-date"><?= date('M d', strtotime('-3 days')) ?></span>
				</div>
			</a>

			<a href="/tour/" class="sector-item">
				<div class="sector-row">
					<span class="file-name"><span class="tag-exec">[EXEC]</span> ROUTE_PROTOCOL.exe</span>
					<span class="file-desc">Маршрут: экскурсия "Эхо машин". Точки интереса. Рекомендуется для пеших исследований. <span class="item-tag">[GPS-ТРЕК]</span></span>
				</div>
				<div class="file-meta">
					<span class="item-permissions">-rw-r--r--</span>
					<span class="item-owner">archivist</span>
					<span class="item-size">24.1K</span>
					<span class="item-date"><?= date('M d') ?></span>
				</div>
			</a>

			<a href="/glass-mountain/" class="sector-item anomaly">
				<div class="sector-row">
					<span class="file-name"><span class="tag-dir">[DIR]</span> ANOMALY_GLASS_MOUNTAIN/</span>
					<span class="file-desc">Оптическое искажение. Графины с бегущими конями. <span class="item-tag">[АРТЕФАКТЫ]</span></span>
				</div>
				<div class="file-meta">
					<span class="item-permissions">-rw-r-----</span>
					<span class="item-owner">archivist</span>
					<span class="item-size">5.2K</span>
					<span class="item-date"><?= date('M d', strtotime('-5 days')) ?></span>
				</div>
			</a>

			<a href="/map/" class="sector-item">
				<div class="sector-row">
					<span class="file-name"><span class="tag-bin">[BIN]</span> TACTICAL_MAP.dat</span>
					<span class="file-desc">Интерактивная навигация. 16 секторов. MapLibre GL. <span class="item-tag">[MAP]</span></span>
				</div>
				<div class="file-meta">
					<span class="item-permissions">-rw-r--r--</span>
					<span class="item-owner">archivist</span>
					<span class="item-size">24.1K</span>
					<span class="item-date"><?= date('M d') ?></span>
				</div>
			</a>

			<a href="/media/" class="sector-item">
				<div class="sector-row">
					<span class="file-name"><span class="tag-bin">[BIN]</span> DECODED_MEDIA.dat</span>
					<span class="file-desc">Оцифровка плёнок. Помехи, тени, прошлое. <span class="item-tag">[МЕДИА]</span></span>
				</div>
				<div class="file-meta">
					<span class="item-permissions">-rw-r--r--</span>
					<span class="item-owner">archivist</span>
					<span class="item-size">156.8K</span>
					<span class="item-date"><?= date('M d', strtotime('-1 day')) ?></span>
				</div>
			</a>

			<a href="/secret/" class="sector-item restricted secret">
				<div class="sector-row">
					<span class="file-name"><span class="tag-enc">[ENC]</span> CLASSIFIED_NODE_0x666.enc</span>
					<span class="file-desc">Доступ ограничен протоколом. Ошибки в матрице посёлка. <span class="item-tag">[ОШИБКА ЧТЕНИЯ]</span></span>
				</div>
				<div class="file-meta">
					<span class="item-permissions">-rw-------</span>
					<span class="item-owner">archivist</span>
					<span class="item-size">???</span>
					<span class="item-date"><?= date('M d', strtotime('-7 days')) ?></span>
				</div>
			</a>

        <?php
        // ============================================================
        // АВТОМАТИЧЕСКИЙ ПОДСЧЁТ ТИПОВ ФАЙЛОВ В ЛИСТИНГЕ
        // ============================================================
        $listing_items = [
            ['type' => 'dir',  'name' => '[DIR] N.YA_SHATROV_ARCHIVE/',      'class' => 'premium'],
            ['type' => 'dir',  'name' => '[DIR] POWER_PLANT_LOGS/',          'class' => 'anomaly'],
            ['type' => 'exec', 'name' => '[EXEC] ROUTE_PROTOCOL.exe',        'class' => ''],
            ['type' => 'dir',  'name' => '[DIR] ANOMALY_GLASS_MOUNTAIN/',    'class' => 'anomaly'],
            ['type' => 'bin',  'name' => '[BIN] TACTICAL_MAP.dat',           'class' => ''],
            ['type' => 'bin',  'name' => '[BIN] DECODED_MEDIA.dat',          'class' => ''],
            ['type' => 'enc',  'name' => '[ENC] CLASSIFIED_NODE_0x666.enc',  'class' => 'restricted secret'],
        ];

        $count_dir  = 0;
        $count_bin  = 0;
        $count_exec = 0;
        $count_enc  = 0;
        $count_anomaly = 0;

        foreach ($listing_items as $item) {
            switch ($item['type']) {
                case 'dir':  $count_dir++;  break;
                case 'bin':  $count_bin++;  break;
                case 'exec': $count_exec++; break;
                case 'enc':  $count_enc++;  break;
            }
            if (strpos($item['class'], 'anomaly') !== false) {
                $count_anomaly++;
            }
        }

        // ============================================================
        // МАССИВ ARG-ПАСХАЛОК (выбирается случайно при каждой загрузке)
        // ============================================================
        $easter_eggs = [
            '1 signal intercepted on frequency 25%. Source: pine tree.',
            'Analog shift detected. Timeline unstable.',
            'Node 0x666 is watching. Decryption key required.',
            '9 million rubles unaccounted for. Where did they go?',
            'Kulikov exists in two houses simultaneously. Quantum state confirmed.',
            'The shuttle remembers. The pine remembers. Do you?',
            'Warning: 2 anomalies logged. Glass Mountain coordinates locked.',
            'Echo of 1890 detected. Origin: power plant.',
            'File "shatrov_death_1919.txt" conflicts with "vienna_necrology_1932.pdf".',
            'Dolphins and lotuses on brick walls. Ornament decoded.',
            'Signal "ДУМАЙ И БОГАТЕЙ" found in stone. Frequency: 55%.',
            'The loom is still running. Listen carefully.',
        ];

        $random_egg = $easter_eggs[array_rand($easter_eggs)];

        $summary_parts = [];
        if ($count_dir  > 0) $summary_parts[] = "{$count_dir} directories";
        if ($count_bin  > 0) $summary_parts[] = "{$count_bin} binaries";
        if ($count_exec > 0) $summary_parts[] = "{$count_exec} executable";
        if ($count_enc  > 0) $summary_parts[] = "{$count_enc} encrypted";
        if ($count_anomaly > 0) $summary_parts[] = "{$count_anomaly} anomalies";

        $summary_text = implode(', ', $summary_parts) . '.';
        ?>

			<div class="listing-footer">
				<div class="listing-info">226 Transfer complete.</div>
				<div class="listing-summary">
					<?= $summary_text ?>
				</div>
				<div class="listing-egg" style="margin-top: 8px; font-size: 0.85rem; color: var(--purple);cursor: pointer; font-style: italic; opacity: 0.7; font-family: 'Share Tech Mono', monospace;">
					&gt;
					<?= htmlspecialchars($random_egg) ?>
				</div>
			</div>
		</div>
	</div>
</div>


<?php require_once __DIR__ . '/includes/footer.php'; ?>