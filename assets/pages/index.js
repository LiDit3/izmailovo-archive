// ============================================================
// ЛОГИКА ЗАГРУЗКИ И ТЕРМИНАЛА (index.js)
// ============================================================

const bootMessages = [
    "ИНИЦИАЛИЗАЦИЯ СИСТЕМЫ...",
    "ПОДКЛЮЧЕНИЕ К СЕРВЕРУ: IZMAILOVO_LOCAL_NODE",
    "ПРОВЕРКА ЦЕЛОСТНОСТИ ДАННЫХ...",
    "ОБНАРУЖЕНЫ ФАЙЛЫ: SHATROV_FACTORY_LOGS (189X)",
    "ОБНАРУЖЕНЫ ФАЙЛЫ: CHP_SIMBIRSK_GRID (191X)",
    "ВНИМАНИЕ: ОБНАРУЖЕН АНАЛОГОВЫЙ СДВИГ.",
    "ЗАГРУЗКА ИНТЕРФЕЙСА ИССЛЕДОВАТЕЛЯ..."
];

const bootTextEl = document.getElementById('boot-text');
const bootScreen = document.getElementById('boot-screen');
const mainHub = document.getElementById('main-hub');

let msgIndex = 0;
let charIndex = 0;
let currentText = "";

// -----------------------------------------------------------
// 1. АНИМАЦИЯ ЗАГРУЗОЧНОГО ЭКРАНА
// -----------------------------------------------------------
function typeBoot() {
    if (msgIndex < bootMessages.length) {
        if (charIndex < bootMessages[msgIndex].length) {
            currentText += bootMessages[msgIndex][charIndex];
            bootTextEl.textContent = currentText + "\n";
            charIndex++;
            setTimeout(typeBoot, 30 + Math.random() * 50);
        } else {
            currentText += "\n";
            bootTextEl.textContent = currentText;
            msgIndex++;
            charIndex = 0;
            setTimeout(typeBoot, 400);
        }
    } else {
        // Завершение загрузки
        setTimeout(() => {
            if (bootScreen) bootScreen.style.opacity = '0';
            setTimeout(() => {
                if (bootScreen) bootScreen.style.display = 'none';
                if (mainHub) {
                    mainHub.style.display = 'block';
                    // Плавное появление основного контента
                    requestAnimationFrame(() => {
                        mainHub.style.opacity = '1';
                    });
                }
                // Запускаем анимацию терминала (с включенной анимацией печати)
                startTerminalAnimation(true);
            }, 1000);
        }, 800);
    }
}

// -----------------------------------------------------------
// 2. ВСПОМОГАТЕЛЬНАЯ ФУНКЦИЯ ПЕЧАТИ
// -----------------------------------------------------------
function typeWriter(element, text, speed, callback) {
    let i = 0;
    function type() {
        if (i < text.length) {
            element.textContent += text.charAt(i);
            i++;
            setTimeout(type, speed);
        } else if (callback) {
            callback();
        }
    }
    type();
}

// -----------------------------------------------------------
// 3. АНИМАЦИЯ ТЕРМИНАЛА (С ПОДДЕРЖКОЙ МГНОВЕННОГО РЕЖИМА)
// -----------------------------------------------------------
function startTerminalAnimation(animate = true) {
    const cmdElement = document.getElementById('ftp-cmd');
    const outputElement = document.getElementById('ftp-output');
    const cursor = document.getElementById('ftp-cursor');
    const sectorsList = document.getElementById('sectors-list');
    const listingFooter = document.getElementById('listing-footer');

    if (!cmdElement || !outputElement) return;

    // Динамическая дата для реалистичности
    const now = new Date();
    const month = now.toLocaleString('en-US', { month: 'short' });
    const day = String(now.getDate()).padStart(2, '0');
    const time = now.toLocaleString('en-US', { hour: '2-digit', minute: '2-digit', hour12: false });
    const dateStr = `${month} ${day} ${time}`;

    const ftpCommand = "ls -la";
    const ftpOutputLines = [
        "200 PORT command successful.",
        "150 Opening ASCII mode data transfer.",
        `drwxr-xr-x  2  archivist  archive    4096  ${dateStr}  ./`,
        `drwxr-xr-x  2  archivist  archive    4096  ${dateStr}  ../`
    ];

    // Функция для финального отображения контента
    function revealContent() {
        if (sectorsList) sectorsList.classList.add('revealed');
        if (listingFooter) listingFooter.style.opacity = '1';
    }

    if (animate) {
        // === ПУТЬ С АНИМАЦИЕЙ ПЕЧАТИ ===
        typeWriter(cmdElement, ftpCommand, 60, () => {
            if (cursor) cursor.style.display = 'none';
            
            let lineIndex = 0;
            function typeNextLine() {
                if (lineIndex < ftpOutputLines.length) {
                    const lineDiv = document.createElement('div');
                    lineDiv.className = 'listing-info typing-line';
                    outputElement.appendChild(lineDiv);
                    
                    typeWriter(lineDiv, ftpOutputLines[lineIndex], 15, () => {
                        lineIndex++;
                        setTimeout(typeNextLine, 100); // Пауза между строками
                    });
                } else {
                    revealContent();
                }
            }
            setTimeout(typeNextLine, 300);
        });
    } else {
        // === МГНОВЕННЫЙ ПУТЬ (без анимации) ===
        cmdElement.textContent = ftpCommand;
        if (cursor) cursor.style.display = 'none'; // Скрываем курсор, так как печать не идет

        ftpOutputLines.forEach(line => {
            const lineDiv = document.createElement('div');
            lineDiv.className = 'listing-info typing-line';
            lineDiv.textContent = line; // Мгновенная вставка текста
            outputElement.appendChild(lineDiv);
        });

        // Мгновенно показываем список секторов и подвал
        revealContent();
    }
}

// -----------------------------------------------------------
// 4. ЛОГИКА ПРОВЕРКИ ВРЕМЕНИ (1 РАЗ В СУТКИ)
// -----------------------------------------------------------
window.addEventListener('DOMContentLoaded', () => {
    const ONE_DAY_MS = 24 * 60 * 60 * 1000; // 24 часа в миллисекундах
    const lastSeen = localStorage.getItem('izmailovo_last_boot');
    const now = Date.now();
    
    // Определяем, нужно ли показывать анимацию
    const shouldAnimate = !lastSeen || (now - parseInt(lastSeen)) > ONE_DAY_MS;

    if (shouldAnimate) {
        // Сохраняем текущее время
        localStorage.setItem('izmailovo_last_boot', now.toString());
        
        // Скрываем контент на время анимации
        if (mainHub) {
            mainHub.style.display = 'none';
            mainHub.style.opacity = '0';
        }
        
        // Запускаем полную анимацию (загрузка + терминал)
        typeBoot();
    } else {
        // Прошло меньше суток: пропускаем загрузку, показываем всё сразу
        if (bootScreen) bootScreen.style.display = 'none';
        if (mainHub) {
            mainHub.style.display = 'block';
            mainHub.style.opacity = '1';
        }
        
        // Запускаем терминал в МГНОВЕННОМ режиме (без печати)
        startTerminalAnimation(false);
    }

    // -----------------------------------------------------------
    // 5. КЛИК ПО ПАСХАЛКЕ (ARG-ПЕРЕХОДЫ)
    // -----------------------------------------------------------
    document.querySelector('.listing-egg')?.addEventListener('click', function() {
        const text = this.textContent.trim().replace(/^>\s*/, '').toLowerCase();
        
        if (text.includes('25%') || text.includes('сосна') || text.includes('pine')) {
            window.location.href = '/secret/'; 
        } else if (text.includes('0x666')) {
            window.location.href = '/secret/';
        } else if (text.includes('9 миллионов') || text.includes('9 million')) {
            window.location.href = '/secret/'; 
        } else if (text.includes('куликов') || text.includes('kulikov')) {
            window.location.href = '/sector/?id=07'; 
        } else if (text.includes('стеклянная гора') || text.includes('glass mountain')) {
            window.location.href = '/glass-mountain/';
        } else if (text.includes('1890') || text.includes('электростанция') || text.includes('power plant')) {
            window.location.href = '/chp/';
        } else if (text.includes('шатров') || text.includes('vienna') || text.includes('shatrov')) {
            window.location.href = '/shatrov/';
        } else if (text.includes('дельфины') || text.includes('лотосы') || text.includes('dolphins')) {
            window.location.href = '/sector/?id=07';
        } else if (text.includes('станок') || text.includes('loom')) {
            window.location.href = '/sector/?id=00'; 
        }
    });
});