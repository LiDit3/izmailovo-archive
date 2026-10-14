<?php
$page_title       = 'МЕДИА-АРХИВ // ФОТО И ВИДЕО // ИЗМАЙЛОВО';
$page_description = 'Оцифрованные плёнки, исторические фотографии, видеозаписи и аудиоканалы посёлка Измайлово. Статус: Аналоговый сдвиг активен.';
$page_keywords    = 'медиа, фото, видео, аудио, Измайлово, архив, Шатров, ТЭЦ';
$page_og_image    = '/assets/og_media.jpg';
$page_section     = 'media';
$page_script      = 'media.js';

$page_ftp_meta = [
    'id'       => 'v1.0',
    'subject'  => 'Media Archive',
    'status'   => 'PARTIAL',
    'location' => 'Узел медиа-архива',
    'related'  => 'PHOTO, VIDEO, AUDIO'
];

require_once __DIR__ . '/includes/header.php';
?>

<!-- ═══ PAYWALL МОДАЛКА ═══ -->
<div class="paywall-overlay" id="paywall">
    <div class="paywall-content">
        <button class="paywall-close" onclick="closePaywall()">✕</button>
        <div class="paywall-icon">🎞️</div>
        <div class="paywall-title">АРХИВ ЧАСТИЧНО ЗАШИФРОВАН</div>
        <div class="paywall-text">
            Некоторые медиа-артефакты находятся в секторе ограниченного доступа.<br>
            Получите ключ дешифровки для просмотра всех материалов.
        </div>
        <div class="paywall-price">299 ₽</div>
        <button class="paywall-btn" onclick="initiatePayment()">🔓 РАСШИФРОВАТЬ АРХИВ</button>
    </div>
</div>

<!-- ═══ FTP-СТРОКА ПОДКЛЮЧЕНИЯ ═══ -->
<div class="ftp-connect">
    <div><span class="ftp-prompt">ftp&gt;</span> <span class="ftp-cmd">get /IZMAILOVO/MEDIA/archive_v1.0.tar</span></div>
    <div class="listing-info">200 PORT command successful.</div>
    <div class="listing-info">150 Opening BINARY mode data transfer.</div>
    <div class="listing-info">226 Transfer complete. <span style="color: var(--amber);">156.8K bytes received.</span></div>
</div>

<!-- ═══ ШАПКА МЕДИА ═══ -->
<div class="page-header amber">
    <div class="stamp amber" id="archive-stamp">ЧАСТИЧНО РАССЕКРЕЧЕНО</div>
    <div class="header-id">ИЗМАЙЛОВО АРХИВ // МЕДИА-УЗЕЛ // ВЕРСИЯ 1.0</div>
    <h1 class="header-title">АРТЕФАКТЫ: ФОТО И ВИДЕО</h1>
    <div class="header-subtitle">Оцифровка найденных плёнок, чертежей и аудиозаписей. Статус: Аналоговый сдвиг активен.</div>
</div>

<!-- ═══ FTP-МЕТА СТРОКА ═══ -->
<div style="max-width: 900px; margin: 0 auto 20px; padding: 10px 20px; background: rgba(255, 176, 0, 0.03); border: 1px solid rgba(255, 176, 0, 0.2); font-family: 'Share Tech Mono', monospace; font-size: 0.95rem;">
    <span style="color: #888;">-rw-r--r--</span>
    <span style="color: var(--amber); margin-left: 15px;">archivist</span>
    <span style="color: var(--cyan); margin-left: 15px;">156.8K</span>
    <span style="color: var(--amber); margin-left: 15px;"><?= date('M d', strtotime('-1 day')) ?></span>
    <span style="color: #666; margin-left: 15px;">archive_v1.0.tar</span>
</div>

<!-- ═══ СТАТИСТИКА АРХИВА ═══ -->
<div class="archive-stats" style="border-color: var(--amber); background: rgba(255, 176, 0, 0.03);">
    <div class="stat-box">
        <div class="stat-value" id="count-photo">12</div>
        <div class="stat-label">Фотоартефактов</div>
    </div>
    <div class="stat-box">
        <div class="stat-value" id="count-video">4</div>
        <div class="stat-label">Видеозаписей</div>
    </div>
    <div class="stat-box">
        <div class="stat-value" id="count-audio">8</div>
        <div class="stat-label">Аудиоканалов</div>
    </div>
    <div class="stat-box">
        <div class="stat-value" style="color: var(--red);text-shadow: var(--red-glow);" id="count-locked">18</div>
        <div class="stat-label">Засекречено</div>
    </div>
</div>

<!-- ═══ ФИЛЬТРЫ ═══ -->
<div class="filters">
    <button class="filter-btn active" onclick="filterMedia('all')">ВСЕ АРТЕФАКТЫ</button>
    <button class="filter-btn" onclick="filterMedia('photo')">ФОТО</button>
    <button class="filter-btn" onclick="filterMedia('video')">ВИДЕО</button>
    <button class="filter-btn amber" onclick="filterMedia('audio')">АУДИО / ГОЛОС ЧЕЛНОКА</button>
</div>

<!-- ═══ FTP-ЛИСТИНГ МЕДИА ═══ -->
<div class="ftp-listing">
    <div class="listing-header">
        <span class="ftp-prompt">ftp&gt;</span>
        <span class="ftp-command">ls /IZMAILOVO/MEDIA/artifacts/</span>
    </div>
    <div class="listing-output">
        <div class="listing-info">200 PORT command successful.</div>
        <div class="listing-info">150 Opening ASCII mode data transfer.</div>
    </div>

    <div class="media-grid" id="media-grid">
        <!-- ФОТО: СВОБОДНЫЕ -->
        <div class="media-card photo" data-type="photo" onclick="openMedia('photo', 'Герб с челноком')">
            <div class="media-preview">
                <img src="https://via.placeholder.com/400x225/050505/00ff41?text=ГЕРБ+ИЗМАЙЛОВО" alt="Герб">
            </div>
            <div class="media-info">
                <div class="media-title">Герб посёлка</div>
                <div class="media-meta"><span>СЕКТОР 00</span><span>JPG // 2.4MB</span></div>
                <div class="media-desc">Сосна и ткацкий челнок в корнях. Символ памяти посёлка.</div>
            </div>
        </div>

        <div class="media-card photo" data-type="photo" onclick="openMedia('photo', 'Портрет Шатрова')">
            <div class="media-preview">
                <img src="https://via.placeholder.com/400x225/050505/ffb000?text=ШАТРОВ+Н.Я." alt="Шатров">
            </div>
            <div class="media-info">
                <div class="media-title">Портрет Н.Я. Шатрова</div>
                <div class="media-meta"><span>СЕКТОР 02</span><span>JPG // 1.8MB</span></div>
                <div class="media-desc">Арт-объект. Наведите камеру на табличку для дополненной реальности.</div>
            </div>
        </div>

        <!-- ФОТО: ЗАБЛОКИРОВАННЫЕ -->
        <div class="media-card photo locked" data-type="photo" onclick="showPaywall()">
            <div class="media-preview">
                <img src="https://via.placeholder.com/400x225/050505/ff0040?text=ДОМ+ИНЖЕНЕРОВ" alt="Дом инженеров">
                <div class="lock-overlay">
                    <div class="lock-icon">🔒</div>
                    <div class="lock-text">ТРЕБУЕТСЯ КЛЮЧ</div>
                </div>
            </div>
            <div class="media-info">
                <div class="media-title">Дом инженеров</div>
                <div class="media-meta"><span>СЕКТОР 03</span><span>JPG // LOCKED</span></div>
                <div class="media-desc">Дом фабричного специалиста. Архитектура усадебного типа.</div>
            </div>
        </div>

        <div class="media-card photo locked" data-type="photo" onclick="showPaywall()">
            <div class="media-preview">
                <img src="https://via.placeholder.com/400x225/050505/ff0040?text=ТЭЦ+1890" alt="ТЭЦ">
                <div class="lock-overlay">
                    <div class="lock-icon">🔒</div>
                    <div class="lock-text">ТРЕБУЕТСЯ КЛЮЧ</div>
                </div>
            </div>
            <div class="media-info">
                <div class="media-title">ТЭЦ 1890 года</div>
                <div class="media-meta"><span>СЕКТОР 11</span><span>JPG // LOCKED</span></div>
                <div class="media-desc">Первая электростанция Симбирской губернии. Зона аномального гула.</div>
            </div>
        </div>

        <!-- ВИДЕО: СВОБОДНОЕ -->
        <div class="media-card video" data-type="video" onclick="openMedia('video', 'Вид с моста')">
            <div class="media-preview">
                <img src="https://via.placeholder.com/400x225/000000/00e5ff?text=VIDEO+//+DRONE+VIEW" alt="Видео">
            </div>
            <div class="media-info">
                <div class="media-title">Вид с моста (Дрон)</div>
                <div class="media-meta"><span>СЕКТОР 99</span><span>MP4 // 45MB</span></div>
                <div class="media-desc">Панорама прудов и сосновых лесов. Снято в сумерках.</div>
            </div>
        </div>

        <!-- ВИДЕО: ЗАБЛОКИРОВАННОЕ -->
        <div class="media-card video locked" data-type="video" onclick="showPaywall()">
            <div class="media-preview">
                <img src="https://via.placeholder.com/400x225/000000/ff0040?text=VHS+//+PROHODKA" alt="Видео">
                <div class="lock-overlay">
                    <div class="lock-icon">🔒</div>
                    <div class="lock-text">ТРЕБУЕТСЯ КЛЮЧ</div>
                </div>
            </div>
            <div class="media-info">
                <div class="media-title">Проходка по ул. Советской</div>
                <div class="media-meta"><span>СЕКТОР 00-19</span><span>VHS // 120MB</span></div>
                <div class="media-desc">Полная запись маршрута "Эхо машин". Эффект старой пленки.</div>
            </div>
        </div>

        <!-- АУДИО: СВОБОДНОЕ -->
        <div class="media-card audio" data-type="audio" onclick="playAudio('intro')">
            <div class="media-preview">
                <div class="audio-waveform">
                    <div class="wave-bar"></div><div class="wave-bar"></div><div class="wave-bar"></div>
                    <div class="wave-bar"></div><div class="wave-bar"></div><div class="wave-bar"></div>
                    <div class="wave-bar"></div><div class="wave-bar"></div>
                </div>
            </div>
            <div class="media-info">
                <div class="media-title">Голос Челнока: Введение</div>
                <div class="media-meta"><span>СЕКТОР 00</span><span>MP3 // 4.2MB</span></div>
                <div class="media-desc">"Ну, прежде чем стать ткацким челноком жил я в лесу..."</div>
            </div>
        </div>

        <!-- АУДИО: ЗАБЛОКИРОВАННОЕ -->
        <div class="media-card audio locked" data-type="audio" onclick="showPaywall()">
            <div class="media-preview">
                <div class="audio-waveform">
                    <div class="wave-bar"></div><div class="wave-bar"></div><div class="wave-bar"></div>
                    <div class="wave-bar"></div><div class="wave-bar"></div><div class="wave-bar"></div>
                    <div class="wave-bar"></div><div class="wave-bar"></div>
                </div>
            </div>
            <div class="media-info">
                <div class="media-title">Голос Челнока: ТЭЦ</div>
                <div class="media-meta"><span>СЕКТОР 11</span><span>MP3 // LOCKED</span></div>
                <div class="media-desc">"Она была построена на четверть века раньше, чем в Симбирске!"</div>
            </div>
        </div>
    </div>

    <div class="listing-footer">
        <div class="listing-info">226 Transfer complete.</div>
        <div class="listing-summary">8 files displayed, 18 classified. <span style="color: var(--red);">Decryption key required for full access.</span></div>
    </div>
</div>

<!-- ═══ НАВИГАЦИЯ ═══ -->
<div class="nav-footer">
    <a href="/" class="nav-btn">← В АРХИВ</a>
    <a href="/tour/" class="nav-btn">К МАРШРУТУ →</a>
</div>

<script>
// ============================================================
// ЛОГИКА МЕДИА-АРХИВА
// ============================================================

// ФИЛЬТРАЦИЯ МЕДИА
function filterMedia(type) {
    const cards = document.querySelectorAll('.media-card');
    const buttons = document.querySelectorAll('.filter-btn');
    
    buttons.forEach(btn => btn.classList.remove('active'));
    event.target.classList.add('active');
    
    cards.forEach(card => {
        if (type === 'all' || card.dataset.type === type) {
            card.style.display = 'flex';
        } else {
            card.style.display = 'none';
        }
    });
}

// ОТКРЫТИЕ МЕДИА
function openMedia(type, title) {
    if (type === 'photo') {
        alert(`Открытие полноразмерного фото: "${title}"\nВ реальной версии здесь будет лайтбокс с возможностью скачивания.`);
    } else if (type === 'video') {
        alert(`Запуск видео: "${title}"\nВ реальной версии здесь откроется VHS-плеер.`);
    }
}

// ВОСПРОИЗВЕДЕНИЕ АУДИО
function playAudio(id) {
    alert(`Воспроизведение аудио: ${id}\nВ реальной версии здесь запустится терминальный аудиоплеер.`);
}

// ПРОВЕРКА ДОСТУПА ПРИ ЗАГРУЗКЕ
window.addEventListener('DOMContentLoaded', () => {
    const hasAccess = localStorage.getItem('premium_access') === 'true';
    if (hasAccess) {
        // Разблокировка всех карточек
        document.querySelectorAll('.media-card.locked').forEach(card => {
            card.classList.remove('locked');
            const overlay = card.querySelector('.lock-overlay');
            if (overlay) overlay.remove();
            
            // Обновление метаданных
            const meta = card.querySelector('.media-meta span:last-child');
            if (meta && meta.textContent.includes('LOCKED')) {
                meta.textContent = meta.textContent.replace('LOCKED', 'DECRYPTED');
            }
        });
        
        // Обновление шапки и статистики
        const stamp = document.getElementById('archive-stamp');
        if (stamp) {
            stamp.textContent = 'ПОЛНЫЙ ДОСТУП';
            stamp.style.borderColor = 'var(--text-color)';
            stamp.style.color = 'var(--text-color)';
        }
        
        const countLocked = document.getElementById('count-locked');
        if (countLocked) {
            countLocked.textContent = '0';
            countLocked.style.color = 'var(--text-color)';
        }
    }
});
</script>

<?php require_once __DIR__ . '/includes/footer.php'; ?>