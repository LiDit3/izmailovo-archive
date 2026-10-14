<?php
$page_title       = 'ОБЪЕКТ ТЭЦ // СЕКТОР 11 // ИЗМАЙЛОВО АРХИВ';
$page_description = 'Первая электростанция Симбирской губернии. Зона аномального гула. Архивные чертежи и рассекреченные данные.';
$page_keywords    = 'ТЭЦ, электростанция, Измайлово, 1890, аномалия, гул, Шатров';
$page_og_image    = '/assets/og_chp.jpg';
$page_section     = 'anomaly';
$page_script      = 'chp.js';

$page_ftp_meta = [
    'id'       => '1890',
    'subject'  => 'ТЭЦ 1890',
    'status'   => 'АНОМАЛИЯ',
    'location' => 'ул. Советская, электростанция',
    'related'  => '07, 12'
];

require_once __DIR__ . '/includes/header.php';
?>

<!-- ═══ FTP-СТРОКА ПОДКЛЮЧЕНИЯ ═══ -->
<div class="ftp-connect">
    <div><span class="ftp-prompt">ftp&gt;</span> <span class="ftp-cmd">get /IZMAILOVO/ANOMALIES/chp_1890.dat</span></div>
    <div class="listing-info">200 PORT command successful.</div>
    <div class="listing-info" style="color: var(--cyan);">⚠ WARNING: Anomalous signal detected in data stream.</div>
    <div class="listing-info">150 Opening BINARY mode data transfer.</div>
    <div class="listing-info">226 Transfer complete. <span style="color: var(--amber);">8.7K bytes received.</span></div>
</div>


<!-- ═══ ПРЕДУПРЕЖДЕНИЕ ОБ АНОМАЛИИ ═══ -->
<div class="anomaly-warning">
    <div class="warning-inner">
        <span>⚠ ВНИМАНИЕ: ЗАФИКСИРОВАНА АНОМАЛЬНАЯ АКТИВНОСТЬ // УРОВЕНЬ ГУЛА ПОВЫШЕН ⚠</span>
    </div>
</div>

<!-- ═══ ШАПКА ОБЪЕКТА ═══ -->
<div class="page-header cyan">
    <div class="stamp cyan">АНОМАЛИЯ</div>
    <div class="header-id" style="color: var(--cyan);">ИЗМАЙЛОВО АРХИВ // ОБЪЕКТ ПОВЫШЕННОГО РИСКА // СЕКТОР 11</div>
    <h1 class="header-title" style="color: var(--cyan); text-shadow: var(--cyan-glow);">ТЭЦ // ЭЛЕКТРОСТАНЦИЯ</h1>
    <div class="header-subtitle">Первая электростанция Симбирской губернии</div>
    <div class="header-dates">ВВЕДЕНА В ЭКСПЛУАТАЦИЮ: 1890 // СТАТУС: ЗАБРОШЕНА // ГУЛ: АКТИВЕН</div>
    <div class="header-quote">
        "Она была построена на четверть века раньше, чем в Симбирске. Измайлово всегда было новатором."
    </div>
</div>

<!-- ═══ FTP-МЕТА СТРОКА ═══ -->
<div style="max-width: 900px; margin: 0 auto 20px; padding: 10px 20px; background: rgba(0, 229, 255, 0.03); border: 1px solid rgba(0, 229, 255, 0.2); font-family: 'Share Tech Mono', monospace; font-size: 0.95rem;">
    <span style="color: #888;">-rw-r-----</span>
    <span style="color: var(--amber); margin-left: 15px;">archivist</span>
    <span style="color: var(--cyan); margin-left: 15px;">8.7K</span>
    <span style="color: var(--amber); margin-left: 15px;"><?= date('M d', strtotime('-3 days')) ?></span>
    <span style="color: #666; margin-left: 15px;">chp_1890.dat</span>
    <span style="color: var(--red); margin-left: 15px;">⚠ ANOMALY</span>
</div>

<!-- ═══ ПАНЕЛЬ МОНИТОРИНГА (уникальный элемент ТЭЦ) ═══ -->
<div class="monitor-panel">
    <div class="monitor-item">
        <div class="monitor-label">Уровень гула</div>
        <div class="monitor-value danger">87%</div>
        <div class="monitor-bar"><div class="monitor-bar-fill danger" style="width: 87%;"></div></div>
    </div>
    <div class="monitor-item">
        <div class="monitor-label">Температура стен</div>
        <div class="monitor-value">+12.4°C</div>
    </div>
    <div class="monitor-item">
        <div class="monitor-label">ЭМ-фон</div>
        <div class="monitor-value danger">АНОМАЛЬНЫЙ</div>
    </div>
    <div class="monitor-item">
        <div class="monitor-label">Возраст объекта</div>
        <div class="monitor-value">136 ЛЕТ</div>
    </div>
</div>

<!-- ═══ FTP-ЛИСТИНГ КАНАЛОВ ═══ -->
<div class="ftp-listing" style="border-color: rgba(0, 229, 255, 0.3); background: rgba(0, 229, 255, 0.02);">
    <div class="listing-header">
        <span class="ftp-prompt">ftp&gt;</span>
        <span class="ftp-command">ls /IZMAILOVO/ANOMALIES/chp_1890/channels/</span>
    </div>
    <div class="listing-output">
        <div class="listing-info">200 PORT command successful.</div>
        <div class="listing-info" style="color: var(--cyan);">⚠ WARNING: Anomalous data patterns detected.</div>
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
            <div class="channel-label">📡 КАНАЛ "ОПЕРАТОР" // ТЕХНИЧЕСКИЙ ОТЧЁТ</div>
            <div class="channel-text">
                Электростанция была построена в 1890 году по инициативе Н.Я. Шатрова для обеспечения энергией суконной фабрики и посёлка. Это была <span class="highlight-number">первая ТЭЦ в Симбирской губернии</span> — она появилась на четверть века раньше, чем электростанция в губернском Симбирске.
                <br><br>
                Здание из красного кирпича с характерными промышленными окнами сохранилось до наших дней. Внутри частично уцелело оборудование начала XX века. Местные жители сообщают о периодическом низкочастотном гуле, исходящем из стен здания, особенно в ночное время.
                <br><br>
                <span style="color: var(--cyan);">⚠ Зафиксированные аномалии: низкочастотный гул (14-18 Гц), аномальная температура стен (+2-3°C выше окружающей среды), периодические электромагнитные возмущения.</span>
            </div>
            <button class="audio-locked-btn" onclick="showPaywall()">
                🔒 🎧 СЛУШАТЬ АУДИО-ВЕРСИЮ
                <span class="premium-note">Доступно по ключу "Архивариус" (299 ₽)</span>
            </button>
        </div>

        <!-- КАНАЛ ЧЕЛНОК -->
        <div class="channel-content" id="content-shuttle">
            <div class="channel-label">📼 КАНАЛ "ЧЕЛНОК" // ГОЛОС ИЗ МАШИННОГО ЗАЛА</div>
            <div class="channel-text amber">
                А Измайлово всегда было новатором! Вот смотрите — электростанция наша 1890 года постройки! На четверть века раньше, чем в самом Симбирске! Николай Яковлевич не жалел денег на прогресс.
                <br><br>
                Я помню, как она гудела. Настоящий, честный гул — турбины работали, пар шёл, свет горел. Это был гул жизни, гул труда. А сейчас... сейчас она гудит по-другому. Тихо так, низко, будто стонет во сне. И стены тёплые, даже зимой.
                <br><br>
                <i>Старожилы говорят, что в машинном зале иногда видят тени. Я не знаю, правда ли это. Но я знаю одно: эта станция помнит каждый киловатт, который она дала посёлку. И она не хочет засыпать.</i>
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

<!-- ═══ БЛОК АНОМАЛИЙ ═══ -->
<div class="anomaly-block">
    <div class="anomaly-grid">
        <div class="anomaly-item">
            <div class="anomaly-item-title">🔊 Низкочастотный гул</div>
            <div style="color: #aaa; font-size: 1rem;">
                Периодический гул в диапазоне 14-18 Гц. Источники не обнаружены. Усиливается в ночное время и в туманную погоду.
            </div>
            <div class="anomaly-meter"><div class="anomaly-meter-fill" style="width: 87%;"></div></div>
        </div>
        <div class="anomaly-item">
            <div class="anomaly-item-title">🌡️ Аномальная температура</div>
            <div style="color: #aaa; font-size: 1rem;">
                Температура стен здания стабильно на 2-3°C выше окружающей среды. Отопление отсутствует с 1990-х годов.
            </div>
            <div class="anomaly-meter"><div class="anomaly-meter-fill" style="width: 65%;"></div></div>
        </div>
        <div class="anomaly-item">
            <div class="anomaly-item-title">⚡ ЭМ-возмущения</div>
            <div style="color: #aaa; font-size: 1rem;">
                Периодические электромагнитные всплески. Влияют на работу мобильных устройств в радиусе 15 метров.
            </div>
            <div class="anomaly-meter"><div class="anomaly-meter-fill" style="width: 45%;"></div></div>
        </div>
    </div>
</div>

<!-- ═══ АРТЕФАКТ (ФОТО) ═══ -->
<div class="artifact-block" style="border-color: var(--cyan);">
    <div class="artifact-image">
        <img src="/images/chp_main.jpg" alt="Здание ТЭЦ 1890 года">
    </div>
    <div class="artifact-info">
        <div class="artifact-title" style="color: var(--cyan);">АРТЕФАКТ // ТЭЦ 1890</div>
        <div class="artifact-desc">
            Здание первой электростанции Симбирской губернии. Красный кирпич, промышленные окна, частично сохранившееся оборудование.
            <br><br>
            <span style="color: var(--amber);">Полный архивный пакет (чертежи 1890 г., фото оборудования, протоколы замеров аномалий) доступен по ключу "Архивариус".</span>
        </div>
    </div>
</div>

<!-- ═══ НАВИГАЦИЯ ═══ -->
<div class="nav-footer">
    <a href="/sector/?id=07" class="nav-btn">← СЕКТОР 07 (ФАБРИКА)</a>
    <a href="/sector/?id=12" class="nav-btn">СЕКТОР 12 (ДОМ УПРАВЛЯЮЩЕГО) →</a>
</div>

<!-- ═══ PAYWALL МОДАЛКА ═══ -->
<div class="paywall-overlay" id="paywall">
    <div class="paywall-content">
        <button class="paywall-close" onclick="closePaywall()">✕</button>
        <div class="paywall-icon">🔒</div>
        <div class="paywall-title">ДОСТУП ЗАБЛОКИРОВАН</div>
        <div class="paywall-text">
            Аудио-версия, чертежи ТЭЦ 1890 г. и протоколы замеров аномалий доступны по ключу "Архивариус".
        </div>
        <div class="paywall-price">299 ₽</div>
        <button class="paywall-btn" onclick="initiatePayment()">🔓 КУПИТЬ КЛЮЧ</button>
    </div>
</div>

<!-- ═══ CSS: УНИКАЛЬНЫЕ СТИЛИ ТЭЦ ═══ -->
<style>
/* Панель мониторинга */
.monitor-panel {
    max-width: 900px;
    margin: 20px auto;
    padding: 20px;
    border: 2px solid var(--cyan);
    background: rgba(0, 229, 255, 0.03);
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
    gap: 15px;
}

.monitor-item {
    padding: 15px;
    border: 1px solid rgba(0, 229, 255, 0.3);
    background: rgba(0, 0, 0, 0.5);
    text-align: center;
}

.monitor-label {
    font-size: 0.9rem;
    color: var(--cyan);
    text-transform: uppercase;
    letter-spacing: 1px;
    margin-bottom: 8px;
}

.monitor-value {
    font-size: 2rem;
    color: var(--text-color);
    font-family: 'Share Tech Mono', monospace;
    text-shadow: var(--glow);
}

.monitor-value.danger {
    color: var(--red);
    text-shadow: var(--red-glow);
    animation: valueBlink 1s infinite;
}

.monitor-bar {
    height: 4px;
    background: rgba(0, 229, 255, 0.2);
    margin-top: 10px;
    position: relative;
    overflow: hidden;
}

.monitor-bar-fill {
    height: 100%;
    background: var(--cyan);
    box-shadow: var(--cyan-glow);
}

.monitor-bar-fill.danger {
    background: var(--red);
    box-shadow: var(--red-glow);
    animation: barPulse 2s infinite;
}

/* Адаптивность мониторинга */
@media (max-width: 768px) {
    .monitor-panel {
        grid-template-columns: 1fr 1fr;
    }
    .monitor-value {
        font-size: 1.5rem;
    }
}

@media (max-width: 480px) {
    .monitor-panel {
        grid-template-columns: 1fr;
    }
}
</style>

<?php require_once __DIR__ . '/includes/footer.php'; ?>