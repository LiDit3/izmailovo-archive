// ============================================================
// ОБЩИЕ ФУНКЦИИ ДЛЯ ВСЕГО САЙТА "ИЗМАЙЛОВО АРХИВ"
// ============================================================

// 1. УНИВЕРСАЛЬНОЕ ПЕРЕКЛЮЧЕНИЕ КАНАЛОВ (без onclick, работает и на tour, и на sector)
function initChannelSwitcher() {
    document.querySelectorAll('.channel-switcher').forEach(switcher => {
        switcher.querySelectorAll('.channel-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                const channel = this.dataset.channel;
                const parent = this.closest('.channels') || this.closest('.route-intro');

                // Обновляем кнопки в текущем блоке
                parent.querySelectorAll('.channel-btn').forEach(b => b.classList.remove('active'));
                this.classList.add('active');

                // Обновляем контент (поддерживает и id="channel-...", и id="content-...")
                parent.querySelectorAll('.channel-content').forEach(c => c.classList.remove('active'));
                const target = parent.querySelector(`#channel-${channel}`) || parent.querySelector(`#content-${channel}`);
                if (target) target.classList.add('active');
            });
        });
    });
}

// 2. PAYWALL ФУНКЦИИ
window.showPaywall = function() { document.getElementById('paywall')?.classList.add('active'); };
window.closePaywall = function() { document.getElementById('paywall')?.classList.remove('active'); };
window.initiatePayment = function() { alert('Переход к оплате...\n\nВ реальной версии здесь будет интеграция с ЮKassa.'); };

// 3. ПРОВЕРКА ПРЕМИУМ-ДОСТУПА (универсальная, обновляет UI на любой странице)
function checkPremiumAccess() {
    const hasAccess = localStorage.getItem('premium_access') === 'true';
    if (!hasAccess) return false;

    // Разблокировка кнопок аудио (кроме тех, что явно помечены как бесплатные)
    document.querySelectorAll('.audio-locked-btn').forEach(btn => {
        if (btn.dataset.action === 'audio-operator') return; 

        btn.innerHTML = '▶ ВОСПРОИЗВЕСТИ АУДИО';
        btn.style.borderStyle = 'solid';
        btn.style.borderColor = 'var(--text-color)';
        btn.style.color = 'var(--text-color)';
        btn.onclick = () => alert('Воспроизведение аудио...');
    });

    // Обновление штампов "ПРЕМИУМ" -> "ПОЛНЫЙ ДОСТУП"
    document.querySelectorAll('.stamp, .stamp-route').forEach(stamp => {
        if (stamp.textContent.trim() === 'ПРЕМИУМ') {
            stamp.textContent = 'ПОЛНЫЙ ДОСТУП';
            stamp.style.borderColor = 'var(--text-color)';
            stamp.style.color = 'var(--text-color)';
        }
    });

    // Обновление заметок об аудио на странице tour.php
    document.querySelectorAll('.sector-audio-note').forEach(note => {
        note.textContent = '✅ Аудио разблокировано';
        note.style.color = 'var(--text-color)';
        note.style.background = 'rgba(0, 255, 65, 0.1)';
    });

    return true;
}

// 4. ПРОГРЕСС МАРШРУТА (универсальный)
const ProgressTracker = {
    STORAGE_KEY: 'completed_sectors',
    markCompleted(sectorId) {
        if (!sectorId) return;
        const completed = this.getCompleted();
        if (!completed.includes(sectorId)) {
            completed.push(sectorId);
            localStorage.setItem(this.STORAGE_KEY, JSON.stringify(completed));
        }
    },
    getCompleted() {
        return JSON.parse(localStorage.getItem(this.STORAGE_KEY) || '[]');
    },
    updateUI() {
        const completed = this.getCompleted();
        const percentEl = document.getElementById('progress-percent');
        const countEl = document.getElementById('completed-count');
        const barEl = document.getElementById('progress-bar');

        // Если мы на странице tour.php (есть элементы прогресса)
        if (percentEl && countEl && barEl) {
            const totalItems = document.querySelectorAll('.sector-item[data-sector]').length || 16;
            const percent = Math.round((completed.length / totalItems) * 100);
            percentEl.textContent = `${percent}%`;
            countEl.textContent = `${completed.length}/${totalItems}`;
            barEl.style.width = `${percent}%`;
        }

        // Подсветка пройденных секторов (работает на tour.php и map.php)
        document.querySelectorAll('.sector-item').forEach(item => {
            if (item.dataset.sector && this.isCompleted(item.dataset.sector)) {
                item.classList.add('completed');
            }
        });
    }
};

// 5. МОБИЛЬНОЕ МЕНЮ
function initMobileMenu() {
    const burger = document.getElementById('nav-burger');
    const nav = document.getElementById('site-nav');
    if (!burger || !nav) return;

    burger.addEventListener('click', (e) => {
        e.stopPropagation();
        nav.classList.toggle('open');
        burger.classList.toggle('open');
    });
    document.addEventListener('click', (e) => {
        if (!nav.contains(e.target)) {
            nav.classList.remove('open');
            burger.classList.remove('open');
        }
    });
}

// 6. ГЛОБАЛЬНАЯ ИНИЦИАЛИЗАЦИЯ
document.addEventListener('DOMContentLoaded', () => {
    initMobileMenu();
    initChannelSwitcher();       // <-- Запускаем переключатель каналов
    checkPremiumAccess();        // <-- Проверяем доступ и обновляем UI
    ProgressTracker.updateUI();  // <-- Обновляем прогресс, если элементы есть на странице
});