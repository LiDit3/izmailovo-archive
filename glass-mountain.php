<?php
$page_title       = 'ОБЪЕКТ // СТЕКЛЯННАЯ ГОРА // СЕКТОР 16 // ИЗМАЙЛОВО АРХИВ';
$page_description = 'Зона аномального стекловарения. Оптическое искажение. Полевой сканер артефактов. Графины с бегущими конями.';
$page_keywords    = 'Стеклянная гора, Измайлово, стеклодувы, артефакты, графины с конями, стекольный завод';
$page_og_image    = '/assets/og_glass_mountain.jpg';
$page_section     = 'anomaly';
$page_script      = 'glass-mountain.js';

$page_ftp_meta = [
    'id'       => '1845',
    'subject'  => 'Стеклянная гора',
    'status'   => 'ОПТИЧЕСКАЯ АНОМАЛИЯ',
    'location' => 'Лесной массив, ул. Пригородная',
    'related'  => '15, 17'
];

require_once __DIR__ . '/includes/header.php';
?>

<!-- ═══ FTP-СТРОКА ПОДКЛЮЧЕНИЯ ═══ -->
<div class="ftp-connect">
    <div><span class="ftp-prompt">ftp&gt;</span> <span class="ftp-cmd">get /IZMAILOVO/ANOMALIES/glass_mountain_1845.dat</span></div>
    <div class="ftp-reply">200 PORT command successful.</div>
    <div class="ftp-reply" style="color: var(--cyan);">⚠ WARNING: Optical distortion detected in data stream.</div>
    <div class="ftp-reply">150 Opening BINARY mode data transfer.</div>
    <div class="ftp-reply">226 Transfer complete. <span style="color: var(--amber);">5.2K bytes received.</span></div>
</div>

<!-- ═══ ПРЕДУПРЕЖДЕНИЕ ОБ ИСКАЖЕНИИ ═══ -->
<div class="distortion-warning">
    <div class="warning-inner">
        <span>⚠ ВНИМАНИЕ: ЗАФИКСИРОВАНО ОПТИЧЕСКОЕ ИСКАЖЕНИЕ // СТАБИЛЬНОСТЬ РЕАЛЬНОСТИ ПОНИЖЕНА ⚠</span>
    </div>
</div>

<!-- ═══ ШАПКА ОБЪЕКТА ═══ -->
<div class="page-header cyan">
    <div class="stamp cyan">АРТЕФАКТЫ</div>
    <div class="header-id" style="color: var(--cyan);">ИЗМАЙЛОВО АРХИВ // ОБЪЕКТ № 1845 // СЕКТОР 16</div>
    <h1 class="header-title" style="color: var(--cyan); text-shadow: var(--cyan-glow);">СТЕКЛЯННАЯ ГОРА</h1>
    <div class="header-subtitle">Зона аномального стекловарения // Лесной массив у ул. Пригородной</div>
    <div class="header-quote">
        "Здесь выпускались графины, на стенках которых, по мере заполнения их водой, вырисовывались красавцы кони."
    </div>
</div>

<!-- ═══ FTP-МЕТА СТРОКА ═══ -->
<div style="max-width: 900px; margin: 0 auto 20px; padding: 10px 20px; background: rgba(0, 229, 255, 0.03); border: 1px solid rgba(0, 229, 255, 0.2); font-family: 'Share Tech Mono', monospace; font-size: 0.95rem;">
    <span style="color: #888;">-rw-r-----</span>
    <span style="color: var(--amber); margin-left: 15px;">archivist</span>
    <span style="color: var(--cyan); margin-left: 15px;">5.2K</span>
    <span style="color: var(--amber); margin-left: 15px;"><?= date('M d', strtotime('-5 days')) ?></span>
    <span style="color: #666; margin-left: 15px;">glass_mountain_1845.dat</span>
    <span style="color: var(--cyan); margin-left: 15px;">⚡ OPTICAL ANOMALY</span>
</div>

<!-- ═══ ПАНЕЛЬ МОНИТОРИНГА (СКАНЕР) ═══ -->
<div class="monitor-panel">
    <div class="monitor-item">
        <div class="monitor-label">Стабильность реальности</div>
        <div class="monitor-value holo">64%</div>
        <div class="monitor-bar"><div class="monitor-bar-fill"></div></div>
    </div>
    <div class="monitor-item">
        <div class="monitor-label">Концентрация артефактов</div>
        <div class="monitor-value" style="color: var(--cyan); text-shadow: 0 0 10px var(--cyan);">ВЫСОКАЯ</div>
        <div class="monitor-bar"><div class="monitor-bar-fill"></div></div>
    </div>
    <div class="monitor-item">
        <div class="monitor-label">Оптическая аномалия</div>
        <div class="monitor-value holo">АКТИВНА</div>
        <div class="monitor-bar"><div class="monitor-bar-fill"></div></div>
    </div>
    <div class="monitor-item">
        <div class="monitor-label">Найденных слитков</div>
        <div class="monitor-value" id="shard-count">0</div>
        <div class="monitor-bar"><div class="monitor-bar-fill"></div></div>
    </div>
</div>

<!-- ═══ КАРТОЧКА ОБЪЕКТА ═══ -->
<div class="object-card" style="border-color: var(--cyan);">
    <div class="object-photo">
        <img src="/images/glass_mountain.jpg" alt="Стеклянная гора">
    </div>
    <div class="object-info">
        <div class="info-row">
            <div class="info-label">Тип объекта:</div>
            <div class="info-value">Заброшенный стекольный завод</div>
        </div>
        <div class="info-row">
            <div class="info-label">Локация:</div>
            <div class="info-value">Лесной массив, ул. Пригородная</div>
        </div>
        <div class="info-row">
            <div class="info-label">Статус:</div>
            <div class="info-value holo-text">Место силы / ARG-зона</div>
        </div>
        <div class="info-row">
            <div class="info-label">Артефакты:</div>
            <div class="info-value">Разноцветные стеклянные слитки</div>
        </div>
        <div class="info-row">
            <div class="info-label">Легенда:</div>
            <div class="info-value">Графины с бегущими конями</div>
        </div>
        <div class="info-row">
            <div class="info-label">Уровень доступа:</div>
            <div class="info-value" style="color: var(--red);">🔒 ОГРАНИЧЕН</div>
        </div>
    </div>
</div>

<!-- ═══ ТАЙМЛАЙН ═══ -->
<div class="timeline">
    <div class="timeline-item">
        <div class="timeline-year">1849-1866</div>
        <div class="timeline-title">Карта Менде фиксирует завод</div>
        <div class="timeline-text">
            На топографических межевых картах под руководством генерал-лейтенанта А.И. Менде 
            отображён стекольный завод Прибыловского на полпути к деревне Беликово.
        </div>
    </div>
    <div class="timeline-item">
        <div class="timeline-year">1865</div>
        <div class="timeline-title">Архивная фиксация Чивильского завода</div>
        <div class="timeline-text">
            В документах зафиксирован стекловаренный завод "в дачах сел Новой и Старой Хананеевок" 
            со всеми постройками. Крестьяне из Измайлово ходили работать на оба завода.
        </div>
    </div>
    <div class="timeline-item">
        <div class="timeline-year">КОНЕЦ XIX В.</div>
        <div class="timeline-title">Расцвет стеклодувного мастерства</div>
        <div class="timeline-text">
            Мастера создают уникальные графины. Легенда гласит: при наполнении водой 
            на стенках сосудов проявляются силуэты бегущих коней.
        </div>
    </div>
    <div class="timeline-item locked" style="border-left-color: var(--red);">
        <div class="timeline-year" style="color: var(--red);">~1920</div>
        <div class="timeline-title" style="color: var(--red);">Исчезновение с карт</div>
        <div class="timeline-text">
            К 1920 году заводов не стало. На современных картах — пусто. 
            Официальных документов о закрытии не найдено.
            <br><br>
            <span style="color: var(--red); font-style: italic;">
            ⚠️ Заводы стёрли из истории. Но земля помнит.
            </span>
        </div>
    </div>
    <div class="timeline-item locked">
        <div class="timeline-year">1941-1945</div>
        <div class="timeline-title">Деревянно-рельсовая дорога (ДРД)</div>
        <div class="timeline-text">
            Через улицу Пригородную (бывшую Молочную) проходит ДРД. 
            По ней везут раненых от станции до госпиталя.
        </div>
    </div>
    <div class="timeline-item locked">
        <div class="timeline-year">НАШИ ДНИ</div>
        <div class="timeline-title">Земля помнит</div>
        <div class="timeline-text">
            У подножия горы до сих пор находят разноцветные стеклянные слитки. 
            Старожилы рассказывают о заводах, которых нет на картах. 
            Исследователи фиксируют оптические искажения в сумерках.
        </div>
    </div>
</div>



<!-- ═══ ИСЧЕЗНУВШИЕ С КАРТ ═══ -->
<div class="anomaly-block" style="border-color: var(--cyan); background: rgba(0, 229, 255, 0.05);">
    <div style="position: absolute; top: -12px; left: 50%; transform: translateX(-50%); background: var(--bg-color); padding: 0 15px; color: var(--cyan); font-size: 1.2rem; letter-spacing: 3px; text-shadow: var(--cyan-glow);">
        ⚠️ ИСЧЕЗНУВШИЕ С КАРТ ⚠️
    </div>
    
    <h3 style="color: var(--cyan); font-size: 1.5rem; margin-bottom: 15px;">ЗАВОДЫ, КОТОРЫХ БОЛЬШЕ НЕТ</h3>
    
    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px; margin: 20px 0;">
        <div style="padding: 15px; border: 1px solid var(--amber); background: rgba(255, 176, 0, 0.05);">
            <div style="color: var(--amber); font-weight: bold; margin-bottom: 8px;">📜 АРХИВЫ ПОМНЯТ</div>
            <div style="font-size: 0.95rem; color: #aaa;">
                Документы 1865 г. и Карты Менде (1849-1866) фиксируют <b>два стекольных завода</b> 
                Прибыловского. Крестьяне ходили туда на работу.
            </div>
        </div>
        <div style="padding: 15px; border: 1px solid var(--red); background: rgba(255, 0, 64, 0.05);">
            <div style="color: var(--red); font-weight: bold; margin-bottom: 8px;">🗺️ КАРТЫ МОЛЧАТ</div>
            <div style="font-size: 0.95rem; color: #aaa;">
                К 1920 году заводов не стало. На современных картах — <b>пусто</b>. 
                Будто их и не было никогда.
            </div>
        </div>
    </div>
    
    <div style="padding: 15px; border: 2px dashed var(--cyan); background: rgba(0, 229, 255, 0.03); margin: 20px 0;">
        <div style="color: var(--cyan); font-weight: bold; margin-bottom: 8px;">🔍 ФИЗИЧЕСКОЕ ДОКАЗАТЕЛЬСТВО</div>
        <div style="font-size: 1.1rem; color: #ccc;">
            У подножия Стеклянной горы до сих пор находят <b style="color: var(--amber);">разноцветные стеклянные слитки</b>. 
            Земля помнит то, что стёрли с карт.
        </div>
    </div>
    
    <div style="padding: 15px; border-left: 4px solid var(--red); background: rgba(255, 0, 64, 0.05); font-style: italic; color: var(--red);">
        <b>⚠️ ВОПРОС АРХИВАРИУСА:</b> Что заставило стереть заводы с карт? 
        И что производили на "втором заводе" у деревни Беликово, 
        о котором помнят только старожилы?
    </div>
</div>

<!-- МИНИ-КАРТА МЕНДЕ (тизер) -->
<div class="map-teaser">
    <div style="color: var(--cyan); font-weight: bold; margin-bottom: 10px; font-size: 1.1rem;">
        🗺️ КАРТА МЕНДЕ (1849-1866) vs СОВРЕМЕННАЯ КАРТА
    </div>
    
    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 10px; margin-bottom: 15px;">
        <div style="aspect-ratio: 4/3; background: #000; border: 1px solid var(--amber); overflow: hidden; position: relative;">
            <img src="/maps/modern_izmailovo.jpg" alt="Современная карта" 
                 style="width: 100%; height: 100%; object-fit: cover; opacity: 0.7;">
            <div style="position: absolute; bottom: 5px; left: 5px; background: rgba(0,0,0,0.8); color: var(--amber); padding: 3px 8px; font-size: 0.8rem;">
                СЕЙЧАС
            </div>
        </div>
        <div style="aspect-ratio: 4/3; background: #000; border: 1px solid var(--cyan); overflow: hidden; position: relative; filter: sepia(0.6) contrast(1.2);">
            <img src="/maps/mende_map_1865.jpg" alt="Карта Менде" 
                 style="width: 100%; height: 100%; object-fit: cover; opacity: 0.8;">
            <div style="position: absolute; bottom: 5px; left: 5px; background: rgba(0,0,0,0.8); color: var(--cyan); padding: 3px 8px; font-size: 0.8rem;">
                1865 ГОД
            </div>
        </div>
    </div>
    
    <div style="padding: 10px; border-left: 3px solid var(--red); background: rgba(255, 0, 64, 0.05); font-size: 0.95rem; color: #ccc;">
        <b style="color: var(--red);">⚠️ ЗАМЕЧЕНО:</b> На Карте Менде отчётливо виден второй завод 
        на полпути к деревне Беликово. На современной карте — <b>пусто</b>.
        <br><br>
        <a href="/secret/" style="color: var(--cyan); text-decoration: underline; text-decoration-style: dashed;">
            🔍 Полное наложение карт доступно в узле /secret/ →
        </a>
    </div>
</div>

<!-- ═══ FTP-ЛИСТИНГ КАНАЛОВ ═══ -->
<div class="ftp-listing" style="border-color: rgba(0, 229, 255, 0.3); background: rgba(0, 229, 255, 0.02);">
    <div class="listing-header">
        <span class="ftp-prompt">ftp&gt;</span>
        <span class="ftp-command">ls /IZMAILOVO/ANOMALIES/glass_mountain_1845/channels/</span>
    </div>
    <div class="listing-output">
        <div class="listing-info">200 PORT command successful.</div>
        <div class="listing-info" style="color: var(--cyan);">⚠ WARNING: Optical data patterns detected.</div>
        <div class="listing-info">150 Opening ASCII mode data transfer.</div>
    </div>

    <!-- ПЕРЕКЛЮЧАТЕЛЬ КАНАЛОВ -->
    <div class="channels">
        <div class="channel-switcher">
            <button class="channel-btn active" onclick="switchChannel('operator')">📡 ОПЕРАТОР</button>
            <button class="channel-btn amber" onclick="switchChannel('shuttle')">📼 ЧЕЛНОК</button>
        </div>

        <!-- КАНАЛ ОПЕРАТОР -->
        <div class="channel-content active" id="content-operator">
            <div class="channel-label">📡 КАНАЛ "ОПЕРАТОР" // АРХИВНЫЕ ДАННЫЕ</div><div class="channel-text">
Недалеко от улицы Пригородной в лесу находится возвышенность, известная как 
<b>Стеклянная гора</b>. Название — не метафора. По свидетельствам старожилов, 
здесь когда-то работал стекольный завод, функционировавший параллельно с 
суконной мануфактурой Прибыловского.
<br><br>
<span style="color: var(--red);">
⚠️ Однако на современных картах этого завода НЕТ.
</span>
<br><br>
В архивных документах 1865 года зафиксирован Чивильский стекловаренный завод 
"в дачах сел Новой и Старой Хананеевок". На Картах Менде (1849-1866) стекольный 
завод Прибыловского отображён в другом месте — на полпути к деревне Беликово. 
Крестьяне из Измайлово ходили работать на оба завода.
<br><br>
К 1920 году заводов не стало. <b>Их стёрли с карт.</b> Но земля помнит: 
у подножия горы до сих пор находят разноцветные стеклянные слитки — 
физическое доказательство того, что здесь когда-то было производство.
<br><br>
<span style="color: var(--cyan);">
⚠️ ВОПРОС АРХИВА: Почему заводы исчезли с карт? Что именно производили 
на "втором заводе" у деревни Беликово? И почему о нём помнят только старожилы?
</span>
</div>
            <button class="audio-locked-btn" onclick="showPaywall()">
                🔒 🎧 СЛУШАТЬ АУДИО-ВЕРСИЮ
                <span class="premium-note">Доступно по ключу "Архивариус" (299 ₽)</span>
            </button>
        </div>

        <!-- КАНАЛ ЧЕЛНОК -->
        <div class="channel-content" id="content-shuttle">
            <div class="channel-label">📼 КАНАЛ "ЧЕЛНОК" // ГОЛОС ИЗ ПРОШЛОГО</div><div class="channel-text amber">
Ох, это место особенное... Старожилы рассказывали — а я и сам помню — 
что там трудились искусные мастера-стеклодувы. Представляете? Графины делали 
такие, что нальёшь воды — а внутри кони бегут! Красавцы такие, будто живые.
<br><br>
Но знаешь что странно? Заводов-то было <b>два</b>. Один — здесь, у горы. 
А второй — в лесу, ближе к Беликово. Туда крестьяне из Измайлово ходили 
на работу. И что там варили — никто толком не знает. Говорили, не только стекло...
<br><br>
А потом — тишина. К 1920 году заводов уже не было. С карт их стёрли. 
Будто и не было никогда. Но ты покопай у подножия горы — найдёшь разноцветные 
стекляшки. Они и сейчас изнутри светятся, особенно когда солнце сквозь листву 
пробивается. <i>Земля-то не забудет, что на ней было.</i>
<br><br>
Говорят, кто такой слиток найдёт — тому удача в делах. 
А я тебе больше скажу: иногда в сумерках там такое мерцание начинается, 
будто завод до сих пор работает, только печи топятся не дровами, а чем-то другим...
</div>
            <button class="audio-locked-btn" onclick="showPaywall()">
                🔒 🎧 СЛУШАТЬ ГОЛОС ЧЕЛНОКА
                <span class="premium-note">Доступно по ключу "Архивариус" (299 ₽)</span>
            </button>
        </div>
    </div>

    <div class="listing-footer">
        <div class="listing-info">226 Transfer complete.</div>
        <div class="listing-summary">2 channels, 1 anomaly detected. <span style="color: var(--cyan);">Proceed with caution.</span></div>
    </div>
</div>

<!-- ═══ БЛОК ARG / СКАНЕР АРТЕФАКТОВ (уникальный элемент) ═══ -->
<div class="arg-scanner">
    <div class="scanner-display">
        <div class="scanner-result" id="scanner-result">
            ОЖИДАНИЕ КОМАНДЫ СКАНИРОВАНИЯ...
        </div>
    </div>
    <button class="scan-btn" id="scan-btn" onclick="runScanner()">🔍 СКАНИРОВАТЬ МЕСТНОСТЬ</button>
    <p style="margin-top: 15px; font-size: 1rem; color: #888;">
        * Симуляция полевого детектора артефактов. В реальности ищите слитки у подножия горы.
    </p>
</div>

<!-- ═══ FTP-ЛИСТИНГ ДОКУМЕНТОВ ═══ -->
<div class="ftp-listing" style="border-color: rgba(0, 229, 255, 0.3); background: rgba(0, 229, 255, 0.02);">
    <div class="listing-header">
        <span class="ftp-prompt">ftp&gt;</span>
        <span class="ftp-command">ls /IZMAILOVO/ANOMALIES/glass_mountain_1845/documents/</span>
    </div>
    <div class="listing-output">
        <div class="listing-info">200 PORT command successful.</div>
        <div class="listing-info" style="color: var(--cyan);">⚠ WARNING: Some files require decryption key.</div>
        <div class="listing-info">150 Opening ASCII mode data transfer.</div>
    </div>

    <div class="documents">
        <div class="doc-title" style="color: var(--cyan);">📄 АРХИВНЫЕ МАТЕРИАЛЫ</div>
        
        <div class="doc-item" onclick="alert('Загрузка карты лесного массива 1890 года...')">
            <span class="doc-icon">🗺️</span>
            <span class="doc-name">forest_map_prigorodnaya_1890.pdf</span>
            <span class="doc-size">3.1 MB</span>
        </div>
        
        <div class="doc-item locked" onclick="showPaywall()">
            <span class="doc-icon">🔒</span>
            <span class="doc-name">artifact_deposit_coordinates.json</span>
            <span class="doc-size">12 KB</span>
            <span class="doc-lock">🔒</span>
        </div>
        
        <div class="doc-item locked" onclick="showPaywall()">
            <span class="doc-icon">🔒</span>
            <span class="doc-name">decanter_horses_blueprint.dwg</span>
            <span class="doc-size">5.4 MB</span>
            <span class="doc-lock">🔒</span>
        </div>
        
        <div class="doc-item locked" onclick="showPaywall()">
            <span class="doc-icon">🔒</span>
            <span class="doc-name">glassblower_personal_diaries.zip</span>
            <span class="doc-size">8.7 MB</span>
            <span class="doc-lock">🔒</span>
        </div>
    </div>

    <div class="listing-footer">
        <div class="listing-info">226 Transfer complete.</div>
        <div class="listing-summary">4 files, 3 classified. <span style="color: var(--cyan);">Decryption key required.</span></div>
    </div>
</div>

<!-- ═══ НАВИГАЦИЯ ═══ -->
<div class="nav-footer">
    <a href="/sector/?id=15" class="nav-btn">← СЕКТОР 15 (ПОЧТА)</a>
    <a href="/sector/?id=17" class="nav-btn">СЕКТОР 17 (ОБЩЕЖИТИЕ) →</a>
</div>

<!-- ═══ PAYWALL МОДАЛКА ═══ -->
<div class="paywall-overlay" id="paywall">
    <div class="paywall-content">
        <button class="paywall-close" onclick="closePaywall()">✕</button>
        <div class="paywall-icon">🔮</div>
        <div class="paywall-title">ЗОНА ОГРАНИЧЕННОГО ДОСТУПА</div>
        <div class="paywall-text">
            Точные координаты залегания артефактов и чертежи графина с конями засекречены.<br>
            Получите ключ дешифровки для полного доступа.
        </div>
        <div class="paywall-price">299 ₽</div>
        <button class="paywall-btn" onclick="initiatePayment()">🔓 РАСШИФРОВАТЬ ЗОНУ</button>
    </div>
</div>

<?php require_once __DIR__ . '/includes/footer.php'; ?>