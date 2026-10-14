// ============================================================
// ЛОГИКА СТРАНИЦЫ СЕКРЕТОВ (secret.php)
// ============================================================

// ------------------------------------------------------------
// ГЛОБАЛЬНЫЕ ПЕРЕМЕННЫЕ
// ------------------------------------------------------------
let audioContext = null;
let noiseNode = null;
let noiseGain = null;
let isAudioInitialized = false;
let currentAudio = null;

// Секретные точки тюнера с аудиофайлами
const secrets = {
    // Основные (уже есть)
    25:  { text: "СОСНА ПОМНИТ ЧЕЛНОК", color: "var(--amber)", audio: "/audio/secret_25.mp3" },
    50:  { text: "КУЛИКОВ — ЭТО ДВА ЧЕЛОВЕКА", color: "var(--cyan)", audio: "/audio/secret_50.mp3" },
    75:  { text: "9 МИЛЛИОНОВ УШЛИ НА ПОБЕГ", color: "var(--red)", audio: "/audio/secret_75.mp3" },
    100: { text: "ШАТРОВ УМЕР В ВЕНЕ. МИФ РАЗРУШЕН.", color: "var(--text-color)", audio: "/audio/secret_100.mp3" },
    
    // Аномалии
    14:  { text: "В СТЕНАХ ДК БЬЁТСЯ ПУЛЬС", color: "var(--red)", audio: "/audio/secret_14.mp3" },
    17:  { text: "В ГРАФИНЕ БЕГУТ КОНИ", color: "var(--cyan)", audio: "/audio/secret_17.mp3" },
    77:  { text: "СЕМЬ ПРУДОВ — СЕМЬ ЗЕРКАЛ ЛЕСА", color: "var(--cyan)", audio: "/audio/secret_77.mp3" },
    90:  { text: "ГУЛ НЕ ПРЕКРАЩАЕТСЯ", color: "var(--purple)", audio: "/audio/secret_90.mp3" },
    
    // Люди и факты
    42:  { text: "ДВЕРЬ ОТКРЫТА. КУКЛА В СВИЯГЕ.", color: "var(--purple)", audio: "/audio/secret_42.mp3" },
    52:  { text: "ЯКОВЛЕВ СПАС ШАТРОВА ОТ РАССТРЕЛА", color: "var(--text-color)", audio: "/audio/secret_52.mp3" },
    85:  { text: "ЧУДАК СМОТРИТ НА ТЕБЯ", color: "var(--amber)", audio: "/audio/secret_85.mp3" },
    
    // Глубокие ARG
    33:  { text: "ДЕЛЬФИНЫ И ЛОТОСЫ ЗНАЮТ ПРАВДУ", color: "var(--cyan)", audio: "/audio/secret_33.mp3" },
    55:  { text: "ЗАПАХ ХЛЕБА ПОМНЯТ КРАСНЫЕ СТЕНЫ", color: "var(--amber)", audio: "/audio/secret_55.mp3" },
    65:  { text: "БЕЛИКОВО ХРАНИТ ВТОРОЙ ЗАВОД", color: "var(--red)", audio: "/audio/secret_65.mp3" }
};

// Радиус "зоны захвата" вокруг каждой точки (в единицах ползунка)
const CATCH_RADIUS = 3;

// ------------------------------------------------------------
// ИНИЦИАЛИЗАЦИЯ WEB AUDIO API (белый шум)
// ------------------------------------------------------------
function initAudio() {
    if (isAudioInitialized) return;
    
    try {
        // Создаём контекст (требует user gesture)
        audioContext = new (window.AudioContext || window.webkitAudioContext)();
        
        // Генерируем белый шум через AudioBuffer
        const bufferSize = 2 * audioContext.sampleRate; // 2 секунды шума
        const noiseBuffer = audioContext.createBuffer(1, bufferSize, audioContext.sampleRate);
        const output = noiseBuffer.getChannelData(0);
        
        // Заполняем буфер случайными значениями от -1 до 1
        for (let i = 0; i < bufferSize; i++) {
            output[i] = Math.random() * 2 - 1;
        }
        
        // Создаём зацикленный источник шума
        noiseNode = audioContext.createBufferSource();
        noiseNode.buffer = noiseBuffer;
        noiseNode.loop = true;
        
        // Фильтр для более "тёплого" звука (низкие частоты)
        const filter = audioContext.createBiquadFilter();
        filter.type = 'lowpass';
        filter.frequency.value = 1500; // обрезаем высокие частоты
        
        // GainNode для управления громкостью
        noiseGain = audioContext.createGain();
        noiseGain.gain.value = 0.15; // начальная громкость (15%)
        
        // Цепочка: шум → фильтр → gain → выход
        noiseNode.connect(filter);
        filter.connect(noiseGain);
        noiseGain.connect(audioContext.destination);
        
        noiseNode.start(0);
        isAudioInitialized = true;
        
        console.log('🔊 Аудио-система инициализирована');
    } catch (e) {
        console.error('❌ Ошибка инициализации аудио:', e);
    }
}

// ------------------------------------------------------------
// УПРАВЛЕНИЕ ГРОМКОСТЬЮ ШУМА
// ------------------------------------------------------------
function setNoiseVolume(value) {
    if (!noiseGain || !audioContext) return;
    
    // Плавное изменение громкости (0.05 сек)
    noiseGain.gain.cancelScheduledValues(audioContext.currentTime);
    noiseGain.gain.setTargetAtTime(
        Math.max(0, Math.min(1, value)),
        audioContext.currentTime,
        0.05
    );
}

// ------------------------------------------------------------
// РАСЧЁТ РАССТОЯНИЯ ДО БЛИЖАЙШЕЙ СЕКРЕТНОЙ ТОЧКИ
// ------------------------------------------------------------
function getDistanceToNearestSecret(value) {
    let minDistance = Infinity;
    let nearestSecret = null;
    
    for (const secretValue in secrets) {
        const distance = Math.abs(value - parseInt(secretValue));
        if (distance < minDistance) {
            minDistance = distance;
            nearestSecret = parseInt(secretValue);
        }
    }
    
    return { distance: minDistance, secret: nearestSecret };
}

// ------------------------------------------------------------
// ВОСПРОИЗВЕДЕНИЕ АУДИОФАЙЛА
// ------------------------------------------------------------
function playSecretAudio(secretValue) {
    const secret = secrets[secretValue];
    if (!secret) return;
    
    // Останавливаем предыдущее аудио, если играет
    if (currentAudio) {
        currentAudio.pause();
        currentAudio.currentTime = 0;
    }
    
    // Создаём новый Audio элемент
    currentAudio = new Audio(secret.audio);
    currentAudio.volume = 0.8;
    
    currentAudio.addEventListener('ended', () => {
        currentAudio = null;
    });
    
    currentAudio.addEventListener('error', (e) => {
        console.warn(`⚠️ Не удалось загрузить аудио: ${secret.audio}`);
        currentAudio = null;
    });
    
    currentAudio.play().catch(e => {
        console.warn('⚠️ Браузер заблокировал автовоспроизведение:', e);
    });
}

// ------------------------------------------------------------
// ОСТАНОВКА АУДИО
// ------------------------------------------------------------
function stopSecretAudio() {
    if (currentAudio) {
        currentAudio.pause();
        currentAudio.currentTime = 0;
        currentAudio = null;
    }
}

// ------------------------------------------------------------
// PAYWALL
// ------------------------------------------------------------
function showPaywall() {
    document.getElementById('paywall')?.classList.add('active');
}

function closePaywall() {
    document.getElementById('paywall')?.classList.remove('active');
}

// ------------------------------------------------------------
// КОНСОЛЬ ДЕШИФРАЦИИ
// ------------------------------------------------------------
function initDecryptConsole() {
    const progress = document.getElementById('progress');
    const finalLine = document.getElementById('console-final');
    if (!progress || !finalLine) return;
    
    let value = 0;
    const interval = setInterval(() => {
        value += Math.random() * 15;
        if (value >= 100) {
            value = 100;
            clearInterval(interval);
            setTimeout(() => {
                finalLine.style.display = 'block';
            }, 500);
        }
        progress.style.width = value + '%';
    }, 200);
}

// ------------------------------------------------------------
// ТЮНЕР ЧАСТОТЫ (с белым шумом и аудио)
// ------------------------------------------------------------
function initFrequencyTuner() {
    const tuner = document.getElementById('tuner');
    const canvas = document.getElementById('wave-canvas');
    const tunerText = document.getElementById('tuner-text');
    const tunerStatus = document.querySelector('.tuner-status');
    const tunerContainer = document.querySelector('.frequency-tuner');
    const resetBtn = document.getElementById('tuner-reset');
    
    if (!tuner || !canvas) return;
    
    const ctx = canvas.getContext('2d');
    
    // Функция ресайза canvas
    function resizeCanvas() {
        canvas.width = canvas.offsetWidth;
        canvas.height = canvas.offsetHeight;
    }
    resizeCanvas();
    window.addEventListener('resize', resizeCanvas);
    
    let animationId;
    let lastPlayedSecret = null; // чтобы не запускать аудио повторно
    
    // Отрисовка волны
    function drawWave(value) {
        ctx.clearRect(0, 0, canvas.width, canvas.height);
        
        // Определяем, находимся ли мы в секретной точке
        const { distance, secret } = getDistanceToNearestSecret(value);
        const isInSecretZone = distance <= CATCH_RADIUS;
        const secretData = isInSecretZone ? secrets[secret] : null;
        
        // Цвет волны: зелёный в точке, янтарный вне
        ctx.strokeStyle = isInSecretZone ? '#00ff41' : '#ffb000';
        ctx.lineWidth = 2;
        ctx.shadowBlur = isInSecretZone ? 20 : 10;
        ctx.shadowColor = ctx.strokeStyle;
        ctx.beginPath();
        
        // Амплитуда: в точке — чистая синусоида, вне — шум
        const noiseAmount = isInSecretZone 
            ? Math.max(0, (distance / CATCH_RADIUS) * 20) 
            : 15 + value * 0.3;
        
        const amplitude = isInSecretZone ? 35 : 15 + value * 0.3;
        const frequency = 0.02 + value * 0.001;
        
        for (let x = 0; x < canvas.width; x++) {
            // Шум: сильный вне точек, слабый в точках
            const noise = isInSecretZone 
                ? (Math.random() - 0.5) * noiseAmount 
                : (Math.random() - 0.5) * (100 - value) * 0.3;
            
            const y = canvas.height / 2 
                + Math.sin(x * frequency + Date.now() * 0.002) * amplitude 
                + noise;
            
            if (x === 0) ctx.moveTo(x, y);
            else ctx.lineTo(x, y);
        }
        ctx.stroke();
        
        // Если в секретной зоне — рисуем индикатор "захвата"
        if (isInSecretZone) {
            ctx.save();
            ctx.fillStyle = secretData.color.replace('var(--', '').replace(')', '');
            // Используем CSS-переменные через getComputedStyle
            const computedColor = getComputedStyle(document.documentElement)
                .getPropertyValue(
                    secret === 25 ? '--amber' : 
                    secret === 50 ? '--cyan' : 
                    secret === 75 ? '--red' : '--text-color'
                ).trim() || '#00ff41';
            
            ctx.fillStyle = computedColor;
            ctx.globalAlpha = 0.3;
            ctx.fillRect(0, 0, canvas.width, canvas.height);
            ctx.restore();
        }
        
        animationId = requestAnimationFrame(() => drawWave(value));
    }
    
    // Обработчик ползунка
    tuner.addEventListener('input', (e) => {
        const value = parseInt(e.target.value);
        
        // При первом взаимодействии — инициализируем аудио
        if (!isAudioInitialized) {
            initAudio();
        }
        
        // Восстанавливаем AudioContext, если был приостановлен
        if (audioContext && audioContext.state === 'suspended') {
            audioContext.resume();
        }
        
        // Расчёт расстояния до ближайшей точки
        const { distance, secret } = getDistanceToNearestSecret(value);
        const isInSecretZone = distance <= CATCH_RADIUS;
        
        // Управление громкостью шума
        // Чем ближе к точке — тем тише шум
        if (isInSecretZone) {
            // Плавное затухание: в центре точки — 0, на границе — 0.15
            const noiseVolume = (distance / CATCH_RADIUS) * 0.15;
            setNoiseVolume(noiseVolume);
        } else {
            setNoiseVolume(0.15);
        }
        
        // Обновление UI
        if (isInSecretZone && secrets[secret]) {
            const secretData = secrets[secret];
            tunerText.textContent = secretData.text;
            tunerText.style.color = secretData.color;
            tunerStatus.textContent = '📡 СИГНАЛ ПОЙМАН';
            tunerStatus.style.color = secretData.color;
            
            // Воспроизводим аудио только при первом входе в точку
            if (lastPlayedSecret !== secret) {
                lastPlayedSecret = secret;
                playSecretAudio(secret);
                
                if (navigator.vibrate) navigator.vibrate(100);
            }
        } else {
            tunerText.textContent = '⚡ ПОМЕХИ... ПОИСК СИГНАЛА...';
            tunerText.style.color = '#888';
            tunerStatus.textContent = '📡 СКАНИРОВАНИЕ ЧАСТОТЫ';
            tunerStatus.style.color = '#888';
            
            // Останавливаем аудио, если вышли из точки
            if (lastPlayedSecret !== null) {
                lastPlayedSecret = null;
                stopSecretAudio();
            }
        }
        
        // Состояние "прорыв" на 100%
        if (value === 100) {
            tunerContainer.classList.add('breached');
            resetBtn.style.display = 'inline-block';
        } else {
            tunerContainer.classList.remove('breached');
            resetBtn.style.display = 'none';
        }
    });
    
    // Кнопка сброса
    resetBtn.addEventListener('click', () => {
        tuner.value = 0;
        tunerText.textContent = 'Нажмите на ползунок, чтобы начать поиск частоты';
        tunerText.style.color = 'var(--text-color)';
        tunerStatus.textContent = '⏸ ОЖИДАНИЕ СИГНАЛА';
        tunerStatus.style.color = '#888';
        tunerContainer.classList.remove('breached');
        resetBtn.style.display = 'none';
        
        lastPlayedSecret = null;
        stopSecretAudio();
        setNoiseVolume(0.15);
    });
    
    // Запуск отрисовки волны
    drawWave(0);
}

// ------------------------------------------------------------
// ИНТЕРАКТИВНАЯ КАРТА МЕНДЕ (FILE_06)
// ------------------------------------------------------------
function initMendeMap() {
    const mendeMap = document.getElementById('mende-map');
    if (!mendeMap) return;
    
    let isDragging = false;
    let startX, startY, initialLeft, initialTop;
    
    mendeMap.addEventListener('mousedown', (e) => {
        isDragging = true;
        startX = e.clientX;
        startY = e.clientY;
        initialLeft = parseInt(mendeMap.style.left || 0);
        initialTop = parseInt(mendeMap.style.top || 0);
        mendeMap.style.cursor = 'grabbing';
        e.preventDefault();
    });
    
    document.addEventListener('mousemove', (e) => {
        if (!isDragging) return;
        const dx = e.clientX - startX;
        const dy = e.clientY - startY;
        mendeMap.style.left = (initialLeft + dx) + 'px';
        mendeMap.style.top = (initialTop + dy) + 'px';
    });
    
    document.addEventListener('mouseup', () => {
        isDragging = false;
        if (mendeMap) mendeMap.style.cursor = 'move';
    });
    
    // Touch-поддержка
    mendeMap.addEventListener('touchstart', (e) => {
        isDragging = true;
        startX = e.touches[0].clientX;
        startY = e.touches[0].clientY;
        initialLeft = parseInt(mendeMap.style.left || 0);
        initialTop = parseInt(mendeMap.style.top || 0);
    });
    
    document.addEventListener('touchmove', (e) => {
        if (!isDragging) return;
        const dx = e.touches[0].clientX - startX;
        const dy = e.touches[0].clientY - startY;
        mendeMap.style.left = (initialLeft + dx) + 'px';
        mendeMap.style.top = (initialTop + dy) + 'px';
    });
    
    document.addEventListener('touchend', () => {
        isDragging = false;
    });
}

// ------------------------------------------------------------
// РАЗБЛОКИРОВКА ПРИ НАЛИЧИИ КЛЮЧА
// ------------------------------------------------------------
function unlockSecretContent() {
    const hasAccess = localStorage.getItem('premium_access') === 'true';
    if (!hasAccess) return;
    
    // Раскрытие FILE_04 (правда о Шатрове)
    const file4Myth = document.getElementById('file4-myth');
    const file4Truth = document.getElementById('file4-truth');
    const file4Status = document.getElementById('file4-status');
    const file4Shuttle = document.getElementById('file4-shuttle');
    
    if (file4Myth) file4Myth.style.display = 'none';
    if (file4Truth) file4Truth.style.display = 'block';
    if (file4Shuttle) file4Shuttle.style.display = 'block';
    
    if (file4Status) {
        file4Status.textContent = 'РАССЕКРЕЧЕНО';
        file4Status.style.color = 'var(--text-color)';
        file4Status.style.borderColor = 'var(--text-color)';
    }
    
    // Снятие redacted-эффекта со всех файлов
    document.querySelectorAll('.redacted').forEach(el => {
        el.style.background = 'transparent';
        el.style.color = 'var(--red)';
        el.style.textShadow = '0 0 5px var(--red)';
    });
    
    // Обновление штампа
    const stamp = document.querySelector('.stamp');
    if (stamp) {
        stamp.textContent = 'ПОЛНЫЙ ДОСТУП';
        stamp.style.borderColor = 'var(--text-color)';
        stamp.style.color = 'var(--text-color)';
        stamp.style.animation = 'none';
    }
}

// ------------------------------------------------------------
// ОЧИСТКА ПРИ УХОДЕ СО СТРАНИЦЫ
// ------------------------------------------------------------
window.addEventListener('beforeunload', () => {
    stopSecretAudio();
    if (noiseNode) {
        try { noiseNode.stop(); } catch(e) {}
    }
    if (audioContext) {
        try { audioContext.close(); } catch(e) {}
    }
});

// ------------------------------------------------------------
// ИНИЦИАЛИЗАЦИЯ
// ------------------------------------------------------------
document.addEventListener('DOMContentLoaded', () => {
    initDecryptConsole();
    initFrequencyTuner();
    initMendeMap();
    unlockSecretContent();
});