// ============================================================
// ЛОГИКА ТАКТИЧЕСКОЙ КАРТЫ (map.php)
// ============================================================

let map;
let markers = [];

// ============================================================
// 🛡️ ЗАЩИТА: очистка данных от случайных пробелов в JSON
// ============================================================
function cleanSectorData(sectors) {
    if (!Array.isArray(sectors)) return [];
    return sectors.map(sector => {
        const cleaned = {};
        for (const [key, value] of Object.entries(sector)) {
            const cleanKey = key.trim();
            let cleanValue = value;
            if (typeof value === 'string') {
                cleanValue = value.trim();
            } else if (Array.isArray(value)) {
                cleanValue = value.map(v => typeof v === 'string' ? v.trim() : v);
            } else if (value && typeof value === 'object') {
                cleanValue = cleanSectorData([value])[0];
            }
            cleaned[cleanKey] = cleanValue;
        }
        return cleaned;
    });
}

// ============================================================
// ИНИЦИАЛИЗАЦИЯ ПРИ ЗАГРУЗКЕ СТРАНИЦЫ
// ============================================================
document.addEventListener('DOMContentLoaded', () => {
    initMap();
    updateCompletedCount();
    attachEventListeners();
    initFullscreen();
});

// ============================================================
// ИНИЦИАЛИЗАЦИЯ КАРТЫ
// ============================================================
function initMap() {
    const mapElement = document.getElementById('map');
    let sectorsData = [];

    if (mapElement && mapElement.dataset.sectors) {
        try {
            const raw = JSON.parse(mapElement.dataset.sectors);
            // 🛡️ Очищаем данные от пробелов
            sectorsData = cleanSectorData(raw);
            console.log(`✅ Загружено секторов: ${sectorsData.length}`);
            console.log('📋 Первый сектор:', sectorsData[0]);
        } catch (e) {
            console.error('❌ Ошибка парсинга данных секторов:', e);
        }
    } else {
        console.warn('⚠️ Атрибут data-sectors не найден или пуст.');
    }

    map = new maplibregl.Map({
        container: 'map',
        style: 'https://basemaps.cartocdn.com/gl/dark-matter-gl-style/style.json',
        center: [47.2428, 53.7230],
        zoom: 15.5,
        attributionControl: false
    });

    map.addControl(new maplibregl.NavigationControl(), 'top-right');
    map.addControl(new maplibregl.AttributionControl({
        customAttribution: '© <a href="https://carto.com/">CARTO</a> © <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a>'
    }), 'bottom-right');

    map.on('load', () => {
       

        if (sectorsData.length === 0) {
            console.warn('⚠️ Нет данных для создания маркеров!');
            return;
        }

        sectorsData.forEach((sector) => {
            try {
                createMarker(sector);
            } catch (e) {
                console.error(`❌ Ошибка создания маркера для сектора ${sector.id}:`, e);
            }
        });

        sectorsData.forEach(createMarker);
         
        loadManualRoute(); 
        
        
    });
}

// ============================================================
// СОЗДАНИЕ КАСТОМНОГО МАРКЕРА
// ============================================================
function createMarker(sector) {
    if (!sector.coords || sector.coords.trim() === '') {
        console.warn(`⚠️ Сектор ${sector.id}: нет координат`);
        return;
    }

    // Парсинг координат
    const coordsMatch = sector.coords.match(/([\d.]+)\s*°?\s*N?\s*,\s*([\d.]+)\s*°?\s*E?/i);
    if (!coordsMatch) {
        console.warn(`⚠️ Сектор ${sector.id}: не удалось распарсить координаты "${sector.coords}"`);
        return;
    }

    const lat = parseFloat(coordsMatch[1]);
    const lng = parseFloat(coordsMatch[2]);

    if (isNaN(lat) || isNaN(lng)) {
        console.warn(`⚠️ Сектор ${sector.id}: некорректные координаты`);
        return;
    }

    // Определяем класс и иконку маркера
    let markerClass = 'custom-marker';
    let markerIcon = '📍';

    if (sector.is_unique_page) {
        markerClass += ' unique';
        markerIcon = '✨';
    } else if (sector.is_premium) {
        markerClass += ' locked';
        markerIcon = '🔒';
    }

    // Проверяем, пройден ли сектор
    const completed = JSON.parse(localStorage.getItem('completed_sectors') || '[]');
    if (completed.includes(sector.id)) {
        markerClass += ' completed';
        markerIcon = '✓';
    }

    const el = document.createElement('div');
    el.className = markerClass;
    el.innerHTML = markerIcon;
    el.dataset.sectorId = sector.id;

    // Сохраняем теги для фильтрации
    const tags = (sector.tags && Array.isArray(sector.tags)) ? sector.tags : [];
    el.dataset.tags = tags.join(',');

    console.log(`📍 Маркер: ${sector.id} — ${sector.title} [${lat}, ${lng}] теги: [${tags.join(', ')}]`);

    // Создание попапа
    const popupHTML = createPopupHTML(sector);
    const popup = new maplibregl.Popup({ offset: 25, closeButton: true, maxWidth: '300px' }).setHTML(popupHTML);

    const marker = new maplibregl.Marker({ element: el })
        .setLngLat([lng, lat])
        .setPopup(popup)
        .addTo(map);

    markers.push({ marker, element: el, sector, tags });
}

// ============================================================
// ФИЛЬТРАЦИЯ МАРКЕРОВ ПО ТЕГАМ
// ============================================================
function filterMap(selectedTag, btn) {
    document.querySelectorAll('.filter-btn').forEach(b => b.classList.remove('active'));
    btn.classList.add('active');

    let visibleCount = 0;
    markers.forEach(item => {
        const tags = item.tags || [];
        if (selectedTag === 'all' || tags.includes(selectedTag)) {
            item.element.style.display = 'flex';
            visibleCount++;
        } else {
            item.element.style.display = 'none';
        }
    });
    console.log(`🔍 Фильтр "${selectedTag}": показано ${visibleCount} из ${markers.length} маркеров`);
}

// ============================================================
// 1. ЗАГРУЗКА РУЧНОГО МАРШРУТА ИЗ GEOJSON
// ============================================================
function loadManualRoute() {
    fetch('/data/route.json') // Путь к вашему файлу
        .then(response => response.json())
        .then(geojsonData => {
            const routeId = 'manual-route';
            
            // Удаляем старые слои, если они есть (для безопасной перезагрузки)
            if (map.getLayer(routeId)) map.removeLayer(routeId);
            if (map.getSource(routeId)) map.removeSource(routeId);

            // Добавляем источник данных
            map.addSource(routeId, {
                type: 'geojson',
                data: geojsonData
            });

            // Добавляем слой отрисовки линии
            map.addLayer({
                id: routeId,
                type: 'line',
                source: routeId,
                layout: {
                    'line-join': 'round',
                    'line-cap': 'round'
                },
                paint: {
                    'line-color': '#00e5ff', // Циановый цвет, как в стиле терминала
                    'line-width': 4,
                    'line-opacity': 0.8,
                    'line-dasharray': [3, 2] // Пунктир
                }
            });
            console.log('✅ Ручной маршрут успешно загружен');
        })
        .catch(err => console.error('❌ Не удалось загрузить файл маршрута:', err));
}

// ============================================================
// 2. ОБНОВЛЕННАЯ ФИЛЬТРАЦИЯ (МАРКЕРЫ + ЛИНИЯ МАРШРУТА)
// ============================================================
function filterMap(selectedTag, btn) {
    // 1. Обновляем визуальное состояние кнопок
    document.querySelectorAll('.filter-btn').forEach(b => b.classList.remove('active'));
    btn.classList.add('active');

    // 2. Фильтруем маркеры (ваш существующий код)
    markers.forEach(item => {
        if (selectedTag === 'all' || (item.tags && item.tags.includes(selectedTag))) {
            item.element.style.display = 'flex';
        } else {
            item.element.style.display = 'none';
        }
    });

    // 3. 🆕 ФИЛЬТРУЕМ СЛОЙ МАРШРУТА
    if (map.getLayer('manual-route')) {
        if (selectedTag === 'all') {
            // Если выбрано "ВСЕ", убираем фильтр (показываем весь маршрут)
            map.setFilter('manual-route', null);
        } else {
            // Если выбран конкретный тег, показываем только те сегменты линии, 
            // в свойстве 'tags' которых есть этот тег.
            // MapLibre выражение: проверить, содержится ли selectedTag в массиве/строке tags
            map.setFilter('manual-route', ['in', selectedTag, ['get', 'tags']]);
        }
    }
}

 

// ============================================================
// СОЗДАНИЕ HTML ДЛЯ ПОПАПА
// ============================================================
function createPopupHTML(sector) {
    let statusClass = 'free';
    let statusText = 'СВОБОДНЫЙ ДОСТУП';
    let linkClass = '';
    let linkText = '[ ОТКРЫТЬ СЕКТОР → ]';
    let url = `/sector/?id=${sector.id}`;

    if (sector.is_unique_page) {
        statusClass = 'unique';
        statusText = 'УНИКАЛЬНЫЙ ОБЪЕКТ';
        linkClass = 'unique';
        linkText = '[ ОТКРЫТЬ ДОСЬЕ → ]';
        url = sector.unique_url || url;
    } else if (sector.is_premium) {
        statusClass = 'premium';
        statusText = 'ТРЕБУЕТСЯ КЛЮЧ';
        linkClass = 'premium';
        linkText = '[ РАЗБЛОКИРОВАТЬ → ]';
    }

    const teaser = sector.operator?.teaser || '';
    const shortTeaser = teaser.length > 120 ? teaser.substring(0, 120) + '...' : teaser;

    return `
        <div class="popup-id">СЕКТОР ${sector.id}</div>
        <div class="popup-title">${escapeHtml(sector.title || '')}</div>
        <div class="popup-location">📍 ${escapeHtml(sector.location || '')}</div>
        <div class="popup-status ${statusClass}">${statusText}</div>
        <div style="color: #aaa; font-size: 0.95rem; margin: 10px 0; line-height: 1.4;">
            ${escapeHtml(shortTeaser)}
        </div>
        <a href="${url}" class="popup-link ${linkClass}">${linkText}</a>
    `;
}

// ============================================================
// ЭКРАНИРОВАНИЕ HTML
// ============================================================
function escapeHtml(text) {
    const div = document.createElement('div');
    div.textContent = text || '';
    return div.innerHTML;
}

// ============================================================
// ПРИВЯЗКА СОБЫТИЙ
// ============================================================
function attachEventListeners() {
    document.querySelectorAll('.filter-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            filterMap(this.dataset.filter, this);
        });
    });

    const closeBtn = document.querySelector('.paywall-close');
    if (closeBtn) closeBtn.addEventListener('click', closePaywall);

    const payBtn = document.querySelector('.paywall-btn');
    if (payBtn) payBtn.addEventListener('click', initiatePayment);
}

// ============================================================
// ПОЛНОЭКРАННЫЙ РЕЖИМ
// ============================================================
function initFullscreen() {
    const fullscreenBtn = document.getElementById('fullscreen-btn');
    const mapTerminal = document.getElementById('map-terminal');

    if (!fullscreenBtn || !mapTerminal) return;

    fullscreenBtn.addEventListener('click', () => {
        if (!document.fullscreenElement) {
            if (mapTerminal.requestFullscreen) mapTerminal.requestFullscreen();
            else if (mapTerminal.webkitRequestFullscreen) mapTerminal.webkitRequestFullscreen();
            else if (mapTerminal.mozRequestFullScreen) mapTerminal.mozRequestFullScreen();
            else if (mapTerminal.msRequestFullscreen) mapTerminal.msRequestFullscreen();
        } else {
            if (document.exitFullscreen) document.exitFullscreen();
            else if (document.webkitExitFullscreen) document.webkitExitFullscreen();
            else if (document.mozCancelFullScreen) document.mozCancelFullScreen();
            else if (document.msExitFullscreen) document.msExitFullscreen();
        }
    });

    document.addEventListener('fullscreenchange', handleFullscreenChange);
    document.addEventListener('webkitfullscreenchange', handleFullscreenChange);
    document.addEventListener('mozfullscreenchange', handleFullscreenChange);
    document.addEventListener('MSFullscreenChange', handleFullscreenChange);

    function handleFullscreenChange() {
        if (map) map.resize();
        const isFullscreen = document.fullscreenElement || document.webkitFullscreenElement ||
                           document.mozFullScreenElement || document.msFullscreenElement;
        fullscreenBtn.innerHTML = isFullscreen ? '✕' : '⛶';
        fullscreenBtn.title = isFullscreen ? 'Выйти из полноэкранного режима' : 'Развернуть на весь экран';
    }
}

// ============================================================
// ОБНОВЛЕНИЕ СЧЁТЧИКА
// ============================================================
function updateCompletedCount() {
    const completed = JSON.parse(localStorage.getItem('completed_sectors') || '[]');
    const countEl = document.getElementById('map-completed');
    if (countEl) countEl.textContent = completed.length;
}

// ============================================================
// PAYWALL ФУНКЦИИ
// ============================================================
function showPaywall() {
    document.getElementById('paywall')?.classList.add('active');
}

function closePaywall() {
    document.getElementById('paywall')?.classList.remove('active');
}

function initiatePayment() {
    alert('Переход к оплате...\n\nВ реальной версии здесь будет интеграция с ЮKassa.');
}