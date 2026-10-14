<?php
// ============================================================
// 1. ПРОВЕРКА ДОСТУПА (СЕРВЕРНАЯ + КЛИЕНТСКАЯ ДЛЯ РАЗРАБОТКИ)
// ============================================================
session_start();

// Основной способ: через сессию (после интеграции с БД)
$has_key = !empty($_SESSION['has_archivist_key']);



// ============================================================
// 2. ДИНАМИЧЕСКИЕ СТАТУСЫ ФАЙЛОВ
// ============================================================
$file4_status = $has_key ? 'РАССЕКРЕЧЕНО' : 'ТРЕБУЕТСЯ РАСШИФРОВКА';
$file4_color  = $has_key ? 'var(--text-color)' : 'var(--red)';

$file5_status = 'СКРЫТО НА ВИДУ'; // FILE_05 всегда виден частично
$file5_color  = 'var(--amber)';

$file6_status = $has_key ? 'КРИТИЧНО' : 'ТРЕБУЕТСЯ РАСШИФРОВКА';
$file6_color  = $has_key ? 'var(--cyan)' : 'var(--red)';

$file7_status = $has_key ? 'СЛЕЖКА / ДОСЬЕ' : 'ТРЕБУЕТСЯ РАСШИФРОВКА';
$file7_color  = $has_key ? 'var(--purple)' : 'var(--red)';

// ============================================================
// 3. МЕТА-ДАННЫЕ СТРАНИЦЫ
// ============================================================
$page_title       = '⚠ ОШИБКА ЧТЕНИЯ // СЕКРЕТНЫЕ МАТЕРИАЛЫ // ИЗМАЙЛОВО';
$page_description = 'Файлы, не вошедшие в официальный маршрут. Аномалии, противоречия в архивах, тайна исчезновения Шатрова. Доступ ограничен.';
$page_keywords    = 'секреты, Измайлово, Шатров, аномалии, ARG, рассекречено';
$page_og_image    = '/assets/og_secret.jpg';
$page_section     = 'secret';
$page_script      = 'secret.js';

$page_ftp_meta = [
    'id'       => '0x666',
    'subject'  => 'CLASSIFIED',
    'status'   => 'RESTRICTED',
    'location' => 'Узел 0x666',
    'related'  => 'FILE_01 — FILE_07'
];

require_once __DIR__ . '/includes/header.php';
?>

<!-- ═══ PAYWALL МОДАЛКА ═══ -->
<div class="paywall-overlay" id="paywall">
    <div class="paywall-content">
        <button class="paywall-close" onclick="closePaywall()">✕</button>
        <div class="paywall-icon">🔒</div>
        <div class="paywall-title">ДОСТУП ЗАБЛОКИРОВАН</div>
        <div class="paywall-text">
            Для снятия цензуры с секретных файлов требуется ключ уровня "АРХИВАРИУС".
        </div>
        <div class="paywall-price">299 ₽</div>
        <button class="paywall-btn" onclick="initiatePayment()">🔓 КУПИТЬ КЛЮЧ</button>
    </div>
</div>

<!-- ═══ FTP-СТРОКА ПОДКЛЮЧЕНИЯ ═══ -->
<div class="ftp-connect" style="border-color: rgba(255, 0, 64, 0.3); background: rgba(255, 0, 64, 0.03);">
    <div><span class="ftp-prompt">ftp&gt;</span> <span class="ftp-cmd">get /IZMAILOVO/CLASSIFIED/node_0x666.dat</span></div>
    <div class="ftp-reply" style="color: var(--red);">⚠ WARNING: Unauthorized access attempt detected.</div>
    <div class="ftp-reply" style="color: var(--red);">⚠ WARNING: Analog shift in progress. Reality unstable.</div>
    <div class="listing-info">150 Opening BINARY mode data transfer.</div>
    <div class="listing-info">226 Transfer complete. <span style="color: var(--amber);">??? bytes received.</span></div>
</div>

<!-- ═══ ПРЕДУПРЕЖДЕНИЕ ═══ -->
<div class="critical-warning">
    <div class="critical-warning-inner">
        <span>⚠ ВНИМАНИЕ: ОБНАРУЖЕН АНАЛОГОВЫЙ СДВИГ // РЕАЛЬНОСТЬ НЕСТАБИЛЬНА ⚠</span>
    </div>
</div>

<!-- ═══ ШАПКА ═══ -->
<div class="page-header red">
    <div class="stamp <?= $has_key ? 'unlocked' : 'secret' ?>">
        <?= $has_key ? 'ПОЛНЫЙ ДОСТУП' : 'СОВ. СЕКРЕТНО' ?>
    </div>
    <div class="header-id" style="color: var(--red);">ИЗМАЙЛОВО АРХИВ // УЗЕЛ 0x666</div>
    <h1 class="header-title" style="color: var(--red); text-shadow: var(--red-glow);">ЧТО СКРЫВАЮТ СТЕНЫ ФАБРИКИ?</h1>
    <div class="header-subtitle" style="color: var(--purple); text-shadow: var(--purple-glow);">Файлы, не вошедшие в официальный маршрут. Ошибки в матрице посёлка.</div>
</div>

<!-- ═══ FTP-МЕТА СТРОКА ═══ -->
<div style="max-width: 900px; margin: 0 auto 20px; padding: 10px 20px; background: rgba(255, 0, 64, 0.03); border: 1px solid rgba(255, 0, 64, 0.2); font-family: 'Share Tech Mono', monospace; font-size: 0.95rem;">
    <span style="color: #888;">-rw-------</span>
    <span style="color: var(--amber); margin-left: 15px;">archivist</span>
    <span style="color: var(--red); margin-left: 15px;">???</span>
    <span style="color: var(--amber); margin-left: 15px;"><?= date('M d', strtotime('-7 days')) ?></span>
    <span style="color: #666; margin-left: 15px;">node_0x666.dat</span>
    <span style="color: var(--red); margin-left: 15px;">🔒 CLASSIFIED</span>
</div>

<!-- ═══ КОНСОЛЬ ДЕШИФРАЦИИ ═══ -->
<div class="decrypt-console" id="console">
    <div class="console-line">&gt; Инициализация протокола "Челнок-7"...</div>
    <div class="console-line">&gt; Подключение к локальной сети посёлка...</div>
    <div class="console-line error">&gt; ОШИБКА: Обнаружено расхождение в исторических данных!</div>
    <div class="console-line">&gt; Запуск анализа аномалий...</div>
    <div class="progress-bar-container">
        <div class="progress-bar-fill" id="progress"></div>
    </div>
    <div class="console-line success" id="console-final" style="display: none;">&gt; ДЕШИФРАЦИЯ ЗАВЕРШЕНА. ДОСТУП К ФАЙЛАМ РАЗРЕШЁН.</div>
</div>

<!-- ═══ FTP-ЛИСТИНГ СЕКРЕТНЫХ ФАЙЛОВ ═══ -->
<div class="ftp-listing" style="border-color: rgba(255, 0, 64, 0.3); background: rgba(255, 0, 64, 0.02);">
    <div class="listing-header">
        <span class="ftp-prompt">ftp&gt;</span>
        <span class="ftp-command">ls /IZMAILOVO/CLASSIFIED/node_0x666/files/</span>
    </div>
    <div class="listing-output">
        <div class="listing-info">200 PORT command successful.</div>
        <div class="listing-info" style="color: var(--red);">⚠ WARNING: 8 files detected. Some require decryption key.</div>
        <div class="listing-info">150 Opening ASCII mode data transfer.</div>
    </div>

    <div class="files-grid">
        
        <!-- ═══════════════════════════════════════════════════ -->
        <!-- FILE_01: ЯЙЦА В РАСТВОРЕ (ВСЕМ)                   -->
        <!-- ═══════════════════════════════════════════════════ -->
        <div class="secret-file">
            <div class="file-header">
                <span class="file-id">FILE_01 // АРХИТЕКТУРНЫЙ АНАЛИЗ</span>
                <span class="file-status">ЦЕНЗУРА</span>
            </div>
            <h2 class="file-title">АНОМАЛИЯ "ЯЙЦА В РАСТВОРЕ"</h2>
            <div class="file-text">
                Официальная легенда гласит, что при кладке стен Дома Культуры (XVIII век) в раствор добавляли куриные яйца для прочности. <span class="redacted">Краеведы называют это "враками" и мифом.</span> Однако лабораторный анализ образца раствора, проведённый в 2024 году, выявил <span class="redacted">высокую концентрацию органического белка и следы ДНК, не принадлежащей известным видам птиц.</span> Стены здания до сих пор остаются тёплыми на ощупь, даже зимой.
            </div>
            <div class="anomaly-note">
                ПРИМЕЧАНИЕ: Если вы приложите ухо к стене ДК в секторе 14, вы услышите не эхо, а ритмичное биение. Частота совпадает с пульсом человека в состоянии покоя.
            </div>
        </div>

        <!-- ═══════════════════════════════════════════════════ -->
        <!-- FILE_02: 9 МИЛЛИОНОВ (ВСЕМ)                        -->
        <!-- ═══════════════════════════════════════════════════ -->
        <div class="secret-file">
            <div class="file-header">
                <span class="file-id">FILE_02 // МАТЕМАТИЧЕСКИЙ СБОЙ</span>
                <span class="file-status">КРИТИЧНО</span>
            </div>
            <h2 class="file-title">КУДА ДЕЛИСЬ 9 МИЛЛИОНОВ?</h2>
            <div class="file-text">
                <p>В архиве зафиксировано фундаментальное противоречие, не имеющее документального объяснения.</p>
                <p>В <b>публичных отчётах</b> и тексте официальной экскурсии указана сумма, переданная государству в 1918 году:</p>
                <div style="background: rgba(255, 176, 0, 0.05); padding: 15px; border-left: 4px solid var(--amber); margin: 15px 0;">
                    <span style="color: var(--amber); font-size: 1.3rem; font-family: 'Share Tech Mono', monospace;">
                        56 000 000 царских рублей
                    </span>
                </div>
                <p>Однако в <b>рассекреченном протоколе национализации</b> от 15 октября 1918 года фигурирует другая цифра:</p>
                <div style="background: rgba(255, 0, 64, 0.05); padding: 15px; border-left: 4px solid var(--red); margin: 15px 0;">
                    <span style="color: var(--red); font-size: 1.3rem; font-family: 'Share Tech Mono', monospace;">
                        &gt; 65 000 000 рублей
                    </span>
                </div>
                <p><span class="redacted">Разница в 9 миллионов царских рублей (примерно 11,5 миллиарда современных рублей при пересчёте по методу потребительской корзины) не имеет документального подтверждения.</span></p>
                <p style="color: var(--red); font-style: italic; margin-top: 20px;">
                    ⚠️ ВОПРОС АРХИВАРИУСА: Куда исчезли 9 миллионов? 
                    Ни в одном официальном документе эта сумма не учтена.
                </p>
            </div>
            <div class="anomaly-note">
                <b>🔍 ГИПОТЕЗЫ АРХИВА:</b><br><br>
                <b>1. Побег:</b> Сумма была использована для тайной организации эмиграции Шатрова.<br><br>
                <b>2. Швейцарские банки:</b> Деньги переведены через посредников в европейские банки.<br><br>
                <b>3. "Чёрная касса":</b> Неучтённые активы, связанные со "вторым заводом" у деревни Беликово (см. FILE_06).
            </div>
        </div>

        <!-- ═══════════════════════════════════════════════════ -->
        <!-- FILE_02.5: ПОЛНЫЙ РЕЕСТР (ВСЕМ)                    -->
        <!-- ═══════════════════════════════════════════════════ -->
        <div class="secret-file" style="border-color: var(--cyan);">
            <div class="file-header">
                <span class="file-id" style="color: var(--cyan);">FILE_02.5 // ПОЛНЫЙ РЕЕСТР</span>
                <span class="file-status" style="color: var(--cyan); border-color: var(--cyan);">ИНВЕНТАРИЗАЦИЯ 1918</span>
            </div>
            <h2 class="file-title" style="color: var(--cyan);">ЧТО ИМЕННО ПЕРЕДАЛ ШАТРОВ ГОСУДАРСТВУ</h2>
            <div class="file-text">
                <p>Николай Яковлевич Шатров был одним из крупнейших предпринимателей Симбирской губернии. По состоянию на 1918 год ему принадлежало:</p>
                <div style="margin: 20px 0;">
                    <div style="padding: 12px; border-bottom: 1px dashed rgba(0, 229, 255, 0.3); display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 10px;">
                        <span style="color: var(--text-color);">🏭 Суконная фабрика в селе Измайлово</span>
                        <span style="color: var(--amber); font-family: 'Share Tech Mono', monospace;">~60 000 000 ₽</span>
                    </div>
                    <div style="padding: 12px; border-bottom: 1px dashed rgba(0, 229, 255, 0.3); display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 10px;">
                        <span style="color: var(--text-color);">🪵 Акшуатский лесопильный завод</span>
                        <span style="color: #888; font-family: 'Share Tech Mono', monospace;">оценка не сохр.</span>
                    </div>
                    <div style="padding: 12px; border-bottom: 1px dashed rgba(0, 229, 255, 0.3); display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 10px;">
                        <span style="color: var(--text-color);">🪵 Измайловский лесопильный завод</span>
                        <span style="color: #888; font-family: 'Share Tech Mono', monospace;">оценка не сохр.</span>
                    </div>
                    <div style="padding: 12px; border-bottom: 1px dashed rgba(0, 229, 255, 0.3); display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 10px;">
                        <span style="color: var(--text-color);">🥃 Винокуренный завод (Карсунский уезд)</span>
                        <span style="color: #888; font-family: 'Share Tech Mono', monospace;">оценка не сохр.</span>
                    </div>
                    <div style="padding: 12px; border-bottom: 1px dashed rgba(0, 229, 255, 0.3); display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 10px;">
                        <span style="color: var(--text-color);">🌲 Земельные и лесные угодья (4200 десятин)</span>
                        <span style="color: #888; font-family: 'Share Tech Mono', monospace;">оценка не сохр.</span>
                    </div>
                    <div style="padding: 12px; border-bottom: 1px dashed rgba(0, 229, 255, 0.3); display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 10px;">
                        <span style="color: var(--text-color);">🏪 Торговые лавки в Симбирске (3 каменные)</span>
                        <span style="color: #888; font-family: 'Share Tech Mono', monospace;">оценка не сохр.</span>
                    </div>
                    <div style="padding: 12px; border-bottom: 1px dashed rgba(0, 229, 255, 0.3); display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 10px;">
                        <span style="color: var(--text-color);">🏪 Торговые лавки в Нижнем Новгороде</span>
                        <span style="color: #888; font-family: 'Share Tech Mono', monospace;">оценка не сохр.</span>
                    </div>
                    <div style="padding: 12px; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 10px;">
                        <span style="color: var(--text-color);">🏠 Дома в Симбирске (3 каменных + 3 деревянных)</span>
                        <span style="color: #888; font-family: 'Share Tech Mono', monospace;">оценка не сохр.</span>
                    </div>
                </div>
                <div style="background: rgba(255, 176, 0, 0.1); padding: 15px; border-left: 4px solid var(--amber); margin-top: 20px;">
                    <b style="color: var(--amber);">ИТОГО ПО ПРОТОКОЛУ:</b> 
                    <span style="font-family: 'Share Tech Mono', monospace; font-size: 1.2rem; color: var(--amber);">&gt; 65 000 000 ₽</span>
                </div>
            </div>
            <div class="anomaly-note" style="border-left-color: var(--red);">
                <b>⚠️ ПАРАДОКС:</b> Только стоимость суконной фабрики оценивалась в 60 миллионов. 
                Сумма остальных активов должна была значительно превышать оставшиеся 5 миллионов.
                <br><br>
                <span class="redacted">Либо оценки были намеренно занижены, либо часть имущества не вошла в реестр.</span>
            </div>
        </div>

        <!-- ═══════════════════════════════════════════════════ -->
        <!-- FILE_03: ДВОЙНИК УПРАВЛЯЮЩЕГО (ВСЕМ)               -->
        <!-- ═══════════════════════════════════════════════════ -->
        <div class="secret-file">
            <div class="file-header">
                <span class="file-id">FILE_03 // БИОМЕТРИЯ</span>
                <span class="file-status">ПРОТИВОРЕЧИЕ</span>
            </div>
            <h2 class="file-title">ДВА ДОМА ОДНОГО ЧЕЛОВЕКА</h2>
            <div class="file-text">
                В архивах есть неразрешимое противоречие. Дом на берегу пруда официально числится как резиденция управляющего фабрикой. Однако в советских документах указано, что управляющий В.И. Куликов проживал в Доме фабричного специалиста (Советская 16). <span class="redacted">Оба здания существовали одновременно. Куликов не мог жить в двух местах сразу.</span> Старожилы утверждают, что видели двух разных Куликовых, которые никогда не появлялись на улице одновременно.
            </div>
            <div class="anomaly-note">
                ⚠ СТАТУС: Объект "Куликов" классифицирован как квантовая суперпозиция. Наблюдение фиксирует только одно состояние.
            </div>
        </div>

        <!-- ═══════════════════════════════════════════════════ -->
        <!-- FILE_04: ТАЙНА ИСЧЕЗНОВЕНИЯ ШАТРОВА                -->
        <!-- ═══════════════════════════════════════════════════ -->
        <div class="secret-file" style="border-color: var(--amber); background: rgba(255, 176, 0, 0.02);">
            <div class="file-header">
                <span class="file-id" style="color: var(--amber);">FILE_04 // ЛИЧНОЕ ДЕЛО № 1853</span>
                <span class="file-status" id="file4-status" style="color: <?= $file4_color ?>; border-color: <?= $file4_color ?>;">
                    <?= $file4_status ?>
                </span>
            </div>
            <h2 class="file-title" style="color: var(--amber);">ПРОТОКОЛ «БАРЫШ-1919»: КУДА ИСЧЕЗ ШАТРОВ?</h2>
            
            <?php if ($has_key): ?>
                <!-- БЛОК ПРАВДЫ (ВИДЕН С КЛЮЧОМ) -->
                <div class="file-text" id="file4-truth">
                    <div style="background: rgba(255, 176, 0, 0.1); padding: 15px; border-left: 4px solid var(--amber); margin-bottom: 20px;">
                        <strong style="color: var(--amber);">✅ ДАННЫЕ РАССЕКРЕЧЕНЫ. МИФ РАЗРУШЕН. ВОССТАНОВЛЕНА ПОЛНАЯ ХРОНОЛОГИЯ.</strong>
                    </div>
                    
                    <h3 style="color: var(--cyan); margin-top: 20px;">📍 СЦЕНА 1: СТАНЦИЯ БАРЫШ, АВГУСТ 1919</h3>
                    <p>Он не растворился в паре. Он ушел пешком, провожаемый тысячами.</p>
                    
                    <div style="background: rgba(0,0,0,0.5); padding: 20px; border: 1px dashed var(--cyan); margin: 20px 0; font-family: 'Special Elite', cursive;">
                        <p style="font-size: 1.4rem; color: var(--text-color); text-align: center; margin: 0;">
                            Шатров повернулся к толпе и <strong>встал на колени</strong>.
                            <br><br>
                            <span style="color: var(--amber);">«Простите меня! — сказал меценат. — За все простите!»</span>
                            <br><br>
                            Толпа простого народа тоже опустилась на колени.
                        </p>
                    </div>

                    <h3 style="color: var(--cyan); margin-top: 20px;">📍 СЦЕНА 2: СЛЕДЫ НА КАРТЕ (1919–1925)</h3>
                    <p>В 1925 году в Измайлово приехала <strong>Варвара Арманд</strong>. Она сообщила:</p>
                    
                    <div style="background: #fff8dc; color: #000; padding: 15px; border: 2px solid #8b4513; font-family: 'Courier New', monospace; transform: rotate(-1deg); margin: 20px 0; box-shadow: 5px 5px 15px rgba(0,0,0,0.5);">
                        <div style="border-bottom: 1px dashed #8b4513; padding-bottom: 5px; margin-bottom: 10px; font-weight: bold;">
                            СОВ. СЕКРЕТНО // ПЕРЕХВАЧЕНО 1925
                        </div>
                        <p style="margin: 0; font-size: 1.1rem;">
                            «Шатров, живущий в Швейцарии, очень плох и очень нуждается. Просит передать привет фабрике».
                        </p>
                        <div style="text-align: right; margin-top: 10px; font-style: italic;">— В. Арманд</div>
                    </div>

                    <h3 style="color: var(--cyan); margin-top: 20px;">📍 СЦЕНА 3: ФИНАЛ. ВЕНА, 1932</h3>
                    <blockquote style="font-family: 'Special Elite', cursive; font-size: 1.3rem; color: var(--text-color); border-left: 3px solid var(--cyan); padding-left: 15px; margin: 20px 0; font-style: italic;">
                        «После продолжительной болезни тихо скончался в Баден (подле Вены) 30 июня на 79-м году жизни Мануфактур-Советник Николай Яковлевич Шатров...»
                    </blockquote>

                    <div class="necrology-gallery">
                        <div class="gallery-item">
                            <img src="/images/necrology_full_page.jpg" alt="Полная страница газеты" class="gallery-image">
                            <div class="gallery-caption">АРХИВНЫЙ СКАН: ПОЛНАЯ СТРАНИЦА</div>
                        </div>
                        <div class="gallery-item highlight">
                            <img src="/images/necrology_cropped.jpg" alt="Вырезка с некрологом" class="gallery-image">
                            <div class="gallery-caption">🔍 ДЕШИФРОВАННЫЙ ФРАГМЕНТ</div>
                        </div>
                    </div>
                </div>
                
                <div class="anomaly-note" id="file4-shuttle" style="border-left-color: var(--amber); background: rgba(255, 176, 0, 0.05);">
                    <strong style="color: var(--amber);">🎙️ ГОЛОС ЧЕЛНОКА:</strong><br>
                    <span style="color: var(--text-color);">
                    "Я чувствовал, как дрожала земля на станции Барыш... Гул, который вы слышите — это не аномалия. Это эхо его прощания."
                    </span>
                </div>
            <?php else: ?>
                <!-- БЛОК МИФА (ВИДЕН ВСЕМ) -->
                <div class="file-text" id="file4-myth">
                    Официальная история обрывается на 1919 годе. Местные легенды гласят, что Шатров бесследно исчез.
                    <br><br>
                    <span class="redacted">Запись в журнале ТЭЦ от 14 ноября 1919 года: "Владелец посетил машинный зал. Вошёл в туман от парового котла. Не вышел. Дверь заблокирована изнутри."</span>
                </div>
                
                <!-- ТИЗЕР -->
                <div style="margin-top: 20px; padding: 20px; border: 2px dashed var(--amber); background: rgba(255, 176, 0, 0.03); text-align: center;">
                    <div style="color: var(--amber); font-size: 1.2rem; margin-bottom: 10px;">🔒 ПОЛНАЯ ХРОНОЛОГИЯ 1919–1932</div>
                    <div style="color: #aaa; font-size: 1rem; margin-bottom: 15px;">
                        Сцена на станции Барыш • Телеграмма Варвары Арманд • Некролог из "Возрождения" (1932) • Голос Челнока
                    </div>
                    <button class="audio-locked-btn" style="max-width: 300px; margin: 0 auto;" onclick="showPaywall()">
                        🔓 РАСШИФРОВАТЬ (299 ₽)
                    </button>
                </div>
            <?php endif; ?>
        </div>

        <!-- ═══════════════════════════════════════════════════ -->
        <!-- FILE_05: ТАЙНА ГЕРБА (БАЗА — ВСЕМ, ФОТО — ПЛАТНО) -->
        <!-- ═══════════════════════════════════════════════════ -->
        <div class="secret-file" style="border-color: var(--amber); background: rgba(255, 176, 0, 0.02);">
            <div class="file-header">
                <span class="file-id" style="color: var(--amber);">FILE_05 // ГЕРАЛЬДИЧЕСКАЯ АНОМАЛИЯ</span>
                <span class="file-status" id="file5-status" style="color: <?= $file5_color ?>; border-color: <?= $file5_color ?>;">
                    <?= $file5_status ?>
                </span>
            </div>
            <h2 class="file-title" style="color: var(--amber);">ТАЙНА ГЕРБА ИЗМАЙЛОВО</h2>
            
            <!-- БАЗОВАЯ ЧАСТЬ (ВИДНА ВСЕМ) -->
            <div class="file-text">
                <p>Официальное описание герба посёлка Измайлово, внесённого в Государственный геральдический регистр РФ:</p>
                
                <blockquote style="font-family: 'Special Elite', cursive; font-size: 1.2rem; color: var(--text-color); border-left: 3px solid var(--amber); padding: 15px; margin: 20px 0; font-style: italic; background: rgba(255, 176, 0, 0.05);">
                    «В зелёном поле под золотой узкой елеобразной главой — <strong style="color: var(--amber);">сосна, оплетающая корнями, положенный в оконечности ткацкий челнок</strong>; все фигуры — золотые».
                </blockquote>
                
                <p>Источник: <span style="color: var(--cyan);">heraldicum.ru</span> — Геральдикум, база данных по российской геральдике.</p>
                
                <p>Обратите внимание: <b style="color: var(--amber);">ткацкий челнок официально присутствует в гербе посёлка</b>. Это государственный документ.</p>
                
                <p>Однако подавляющее большинство жителей посёлка, проходя мимо здания Администрации, <span class="redacted">видят просто "ёлочку" на зелёном фоне</span>. Они не замечают челнок в корнях сосны.</p>
            </div>
            
            <?php if ($has_key): ?>
                <!-- ПЛАТНАЯ ЧАСТЬ: ФОТО И СВЯЗЬ С ТЮНЕРОМ -->
                <div style="margin: 25px 0; padding: 20px; border: 1px dashed var(--amber); background: rgba(255, 176, 0, 0.03);">
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px;">
                        <div style="text-align: center;">
                            <img src="/images/gerb_izmailovo_official.png" alt="Официальный герб" 
                                 style="max-width: 100%; height: auto; border: 2px solid var(--amber); filter: sepia(0.3) contrast(1.1);">
                            <div style="color: var(--amber); font-size: 0.9rem; margin-top: 10px;">ОФИЦИАЛЬНЫЙ ГЕРБ</div>
                        </div>
                        <div style="text-align: center;">
                            <img src="/images/gerb_closeup_shuttle.png" alt="Фрагмент с челноком" 
                                 style="max-width: 100%; height: auto; border: 2px solid var(--cyan); filter: contrast(1.3) brightness(1.1);">
                            <div style="color: var(--cyan); font-size: 0.9rem; margin-top: 10px;">🔍 ЧЕЛНОК В КОРНЯХ</div>
                        </div>
                    </div>
                </div>

                <div style="padding: 15px; border-left: 4px solid var(--cyan); background: rgba(0, 229, 255, 0.05);">
                    <strong style="color: var(--cyan);">📻 СВЯЗЬ С ЧАСТОТОЙ 25%:</strong><br>
                    <span style="color: var(--text-color);">
                    Настройте тюнер частот ниже на отметку <strong style="color: var(--amber);">25%</strong> — 
                    поймаете сигнал: <span style="color: var(--amber); font-family: 'Share Tech Mono', monospace;">"СОСНА ПОМНИТ ЧЕЛНОК"</span>.
                    </span>
                </div>
                
                <p style="color: var(--red); font-style: italic; margin-top: 20px;">
                    ⚠️ ПАРАДОКС АРХИВА: Тайна не спрятана. Она буквально нарисована на гербе. Но никто её не видит.
                </p>
            <?php else: ?>
                <!-- ТИЗЕР -->
                <div style="margin-top: 20px; padding: 20px; border: 2px dashed var(--amber); background: rgba(255, 176, 0, 0.03); text-align: center;">
                    <div style="color: var(--amber); font-size: 1.2rem; margin-bottom: 10px;">🔒 ФОТОГРАФИИ ГЕРБА И СВЯЗЬ С ТЮНЕРОМ</div>
                    <div style="color: #aaa; font-size: 1rem; margin-bottom: 15px;">
                        Увеличенный фрагмент с челноком • Связь с частотой 25% • Парадокс архива
                    </div>
                    <button class="audio-locked-btn" style="max-width: 300px; margin: 0 auto;" onclick="showPaywall()">
                        🔓 РАСШИФРОВАТЬ (299 ₽)
                    </button>
                </div>
            <?php endif; ?>
        </div>

        <!-- ═══════════════════════════════════════════════════ -->
        <!-- FILE_06: КАРТА МЕНДЕ (ПОЛНОСТЬЮ ПЛАТНО)            -->
        <!-- ═══════════════════════════════════════════════════ -->
        <div class="secret-file" style="border-color: var(--cyan);">
            <div class="file-header">
                <span class="file-id" style="color: var(--cyan);">FILE_06 // КАРТОГРАФИЧЕСКАЯ АНОМАЛИЯ</span>
                <span class="file-status" id="file6-status" style="color: <?= $file6_color ?>; border-color: <?= $file6_color ?>;">
                    <?= $file6_status ?>
                </span>
            </div>
            <h2 class="file-title" style="color: var(--cyan);">ЗАВОДЫ, СТЁРТЫЕ С КАРТ</h2>
            
            <!-- БАЗОВАЯ ЧАСТЬ (ВИДНА ВСЕМ) -->
            <div class="file-text">
                В архивных документах 1865 года зафиксирован Чивильский стекловаренный завод.
                На Картах Менде (1849-1866) отображён ещё один завод Прибыловского —
                на полпути к деревне Беликово.
                <br><br>
                <span class="redacted">К 1920 году заводов не стало</span>.
                На современных картах — <span class="redacted">пусто</span>.
                Официальных документов о закрытии <span class="redacted">не сохранилось</span>.
            </div>
            
            <?php if ($has_key): ?>
                <!-- ИНТЕРАКТИВНАЯ КАРТА (ПЛАТНО) -->
                <div style="margin: 30px 0; padding: 20px; border: 2px solid var(--cyan); background: rgba(0, 0, 0, 0.6);">
                    <div style="color: var(--cyan); font-size: 1.3rem; margin-bottom: 15px; text-align: center; text-shadow: var(--cyan-glow);">
                        🗺️ ИНТЕРАКТИВНОЕ НАЛОЖЕНИЕ КАРТ
                    </div>
                    <div style="position: relative; width: 100%; height: 450px; background: #000; border: 1px solid var(--cyan); overflow: hidden; cursor: grab;">
                        <img src="/maps/modern_izmailovo.jpg" alt="Современная карта"
                             style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; object-fit: cover; opacity: 0.7;">
                        <img src="/maps/mende_map_1865.jpg" alt="Карта Менде"
                             id="mende-map"
                             style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; object-fit: cover; opacity: 0.6; cursor: move; filter: sepia(0.8) contrast(1.3);">
                        <div style="position: absolute; top: 30%; left: 40%; background: var(--amber); color: #000; padding: 5px 10px; font-size: 0.9rem; border-radius: 3px; z-index: 10; pointer-events: none;">
                            📍 Локация А (официальная)
                        </div>
                        <div style="position: absolute; top: 50%; left: 60%; background: var(--red); color: #fff; padding: 5px 10px; font-size: 0.9rem; border-radius: 3px; z-index: 10; animation: pulse 2s infinite; pointer-events: none;">
                            📍 Локация Б (Карта Менде)
                        </div>
                        <div style="position: absolute; bottom: 10px; left: 50%; transform: translateX(-50%); background: rgba(0,0,0,0.8); color: var(--cyan); padding: 5px 15px; font-size: 0.85rem; border-radius: 3px; z-index: 10; pointer-events: none;">
                            Перетаскивайте карту Менде мышкой
                        </div>
                    </div>
                </div>
                
                <div class="anomaly-note">
                    <b>ГИПОТЕЗА АРХИВА:</b> "Стеклянная гора" — это место, где <b>оба завода</b> сбрасывали отходы.
                    <br><br>
                    <span style="color: var(--red);">
                    ⚠️ Координаты "Локации Б" по Карте Менде: <span class="redacted">53.7712°N, 47.1189°E</span>
                    </span>
                </div>
            <?php else: ?>
                <!-- ТИЗЕР -->
                <div style="margin-top: 20px; padding: 20px; border: 2px dashed var(--cyan); background: rgba(0, 229, 255, 0.03); text-align: center;">
                    <div style="color: var(--cyan); font-size: 1.2rem; margin-bottom: 10px;">🗺️ ИНТЕРАКТИВНАЯ КАРТА МЕНДЕ</div>
                    <div style="color: #aaa; font-size: 1rem; margin-bottom: 15px;">
                        Наложение карты 1865 года на современную • Координаты "Локации Б" • Задача исследователя
                    </div>
                    <button class="audio-locked-btn" style="max-width: 300px; margin: 0 auto; border-color: var(--cyan); color: var(--cyan);" onclick="showPaywall()">
                        🔓 РАСШИФРОВАТЬ (299 ₽)
                    </button>
                </div>
            <?php endif; ?>
        </div>

        <!-- ═══════════════════════════════════════════════════ -->
        <!-- FILE_07: ЛЕГЕНДА О ФАЛЬШИВОМОНЕТЧЕСТВЕ             -->
        <!-- ═══════════════════════════════════════════════════ -->
        <div class="secret-file" style="border-color: var(--purple); background: rgba(189, 0, 255, 0.02);">
            <div class="file-header">
                <span class="file-id" style="color: var(--purple);">FILE_07 // ПОЛИЦЕЙСКИЙ АРХИВ 1886</span>
                <span class="file-status" id="file7-status" style="color: <?= $file7_color ?>; border-color: <?= $file7_color ?>;">
                    <?= $file7_status ?>
                </span>
            </div>
            <h2 class="file-title" style="color: var(--purple);">ИНЦИДЕНТ НА МОСТУ ЧЕРЕЗ СВИЯГУ</h2>
            
            <!-- БАЗОВАЯ ЧАСТЬ (ВИДНА ВСЕМ) -->
            <div class="file-text">
                <p>В архивах Симбирской полиции сохранилось донесение филера за 1886 год. Объектом слежки был Н.Я. Шатров.</p>
                <p>Мошенники попытались продать купцу "фальшивые рубли" по курсу 1 к 4. На мосту через Свиягу Шатров, будучи один против троих или четверых, мгновенно распознал обман: "пачки" оказались резаной бумагой, обложенной настоящими банкнотами.</p>
                <div style="background: rgba(0,0,0,0.6); padding: 15px; border-left: 3px solid var(--purple); margin: 15px 0; font-style: italic; color: #ccc;">
                    Шатров вырвал "куклу", разорвал её и швырнул бумагу в Свиягу. Мошенники напасть не рискнули.
                </div>
                <p>Казалось бы, история о том, как <b>самого</b> Шатрова пытались обмануть. Но "дым без огня не бывает".</p>
            </div>
            
            <?php if ($has_key): ?>
                <!-- ПЛАТНАЯ ЧАСТЬ: ГОРОДСКАЯ ЛЕГЕНДА -->
                <div class="anomaly-note" style="border-left-color: var(--red); background: rgba(255, 0, 64, 0.05);">
                    <strong style="color: var(--red);">⚠️ ГОРОДСКАЯ ЛЕГЕНДА (В.А. ВОЛЫНЦЕВ):</strong><br>
                    В особняке Шатрова в Симбирске был установлен <span class="redacted">станок для печати фальшивых денег</span>, 
                    замаскированный под внутреннюю дверь: <span class="redacted">открыл-закрыл — две купюры</span>.
                    <br><br>
                    <strong>ГИПОТЕЗА:</strong> Суконщики закупали шерсть в Центральной Азии. Соблазн расплатиться "фантиками" был велик. 
                    Не эта ли "тень" и породила легенду?
                </div>
            <?php else: ?>
                <!-- ТИЗЕР -->
                <div style="margin-top: 20px; padding: 20px; border: 2px dashed var(--purple); background: rgba(189, 0, 255, 0.03); text-align: center;">
                    <div style="color: var(--purple); font-size: 1.2rem; margin-bottom: 10px;">🔒 ГОРОДСКАЯ ЛЕГЕНДА О СТАНКЕ</div>
                    <div style="color: #aaa; font-size: 1rem; margin-bottom: 15px;">
                        "Дверь, печатающая деньги" • Связь с закупками шерсти в Средней Азии • Гипотеза архива
                    </div>
                    <button class="audio-locked-btn" style="max-width: 300px; margin: 0 auto; border-color: var(--purple); color: var(--purple);" onclick="showPaywall()">
                        🔓 РАСШИФРОВАТЬ (299 ₽)
                    </button>
                </div>
            <?php endif; ?>
        </div>

    </div>

    <div class="listing-footer">
        <div class="listing-info">226 Transfer complete.</div>
        <div class="listing-summary">8 files, 4 with classified sections. <span style="color: var(--red);">Decryption key required for full access.</span></div>
    </div>
</div>

<!-- ═══ ИНТЕРАКТИВНЫЙ ТЮНЕР ═══ -->
<div class="frequency-tuner">
    <div class="tuner-title">📻 ПЕРЕСТРОЙКА ЧАСТОТЫ "ЧЕЛНОК"</div>
    <p class="tuner-hint">Двигайте ползунок, чтобы поймать скрытый сигнал</p>
    <div class="tuner-visualizer">
        <canvas id="wave-canvas" width="800" height="120"></canvas>
    </div>
    <div class="tuner-controls">
        <input type="range" min="0" max="100" value="0" step="1" class="tuner-slider" id="tuner">
        <div class="tuner-scale">
            <span>0</span><span>25</span><span>50</span><span>75</span><span>100</span>
        </div>
    </div>
    <div class="tuner-display" id="tuner-display">
        <div class="tuner-status">⏸ ОЖИДАНИЕ СИГНАЛА</div>
        <div class="tuner-text" id="tuner-text">Нажмите на ползунок, чтобы начать поиск частоты</div>
    </div>
    <button class="tuner-reset-btn" id="tuner-reset" style="display: none;">🔄 СБРОСИТЬ СИГНАЛ</button>
</div>

<!-- ═══ НАВИГАЦИЯ ═══ -->
<div class="nav-footer">
    <a href="/" class="nav-btn">← ПОКИНУТЬ ЗОНУ</a>
    <a href="/tour/" class="nav-btn">ВЕРНУТЬСЯ К МАРШРУТУ →</a>
</div>

<?php require_once __DIR__ . '/includes/footer.php'; ?>