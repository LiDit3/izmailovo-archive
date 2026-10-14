// Логика страницы tour.php
document.addEventListener('DOMContentLoaded', () => {
    ProgressTracker.updateUI();
    
    // Проверка премиум-доступа для маршрута
    const hasAccess = localStorage.getItem('premium_access') === 'true';
    if (hasAccess) {
        document.querySelectorAll('.sector-audio-note').forEach(note => {
            note.textContent = '✅ Аудио разблокировано';
            note.style.color = 'var(--text-color)';
        });
    }
});