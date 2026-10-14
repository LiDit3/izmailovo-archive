// Логика страницы ТЭЦ (chp.php)
document.addEventListener('DOMContentLoaded', () => {
    // Сохранение прогресса (ТЭЦ = сектор 11)
    if (typeof ProgressTracker !== 'undefined') {
        ProgressTracker.markCompleted('11');
    }
    
    // Имитация "живого" мониторинга
    const dangerValues = document.querySelectorAll('.monitor-value.danger');
    setInterval(() => {
        dangerValues.forEach(el => {
            if (el.textContent.includes('%')) {
                const base = 87;
                const fluctuation = Math.floor(Math.random() * 5) - 2;
                el.textContent = (base + fluctuation) + '%';
            }
        });
    }, 3000);
});