// Логика, специфичная только для страницы sector.php
document.addEventListener('DOMContentLoaded', () => {
    // Получаем ID сектора из data-атрибута body (добавьте его в sector.php, см. ниже)
    const sectorId = document.body.dataset.sectorId;
    
    if (sectorId) {
        ProgressTracker.markCompleted(sectorId);
        // updateUI вызывается глобально, но на всякий случай продублируем для элементов сектора
        ProgressTracker.updateUI();
    }

    // Привязка событий для кнопок paywall внутри sector.php (через data-action)
    document.querySelectorAll('[data-action="paywall"]').forEach(btn => {
        btn.addEventListener('click', window.showPaywall);
    });
    document.querySelectorAll('[data-action="close-paywall"]').forEach(btn => {
        btn.addEventListener('click', window.closePaywall);
    });
    document.querySelectorAll('[data-action="initiate-payment"]').forEach(btn => {
        btn.addEventListener('click', window.initiatePayment);
    });
});