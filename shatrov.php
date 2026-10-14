<?php
$page_title       = 'ДОСЬЕ // ШАТРОВ Н.Я. (1853–...) // ИЗМАЙЛОВО АРХИВ';
$page_description = 'Полная биография Николая Яковлевича Шатрова: от унтер-офицерского сына до крупнейшего фабриканта Симбирской губернии. Сцена на станции Барыш, эмиграция, некролог в Вене.';
$page_keywords    = 'Шатров Николай Яковлевич, биография, Измайлово, фабрикант, меценат, Симбирск';
$page_og_image    = '/assets/og_shatrov.jpg';
$page_section     = 'dossier';
// Переопределяем метаданные для footer
$page_ftp_meta = [
    'id' => '1853-...',
    'subject' => 'Шатров Николай Яковлевич',
    'status' => 'РАССЕКРЕЧЕНО',
    'related' => '02, 03, 04, 07'
];
require_once __DIR__ . '/includes/header.php';
?>

<!-- ═══ FTP-СТРОКА ПОДКЛЮЧЕНИЯ ═══ -->
<div class="ftp-connect">
    <div><span class="ftp-prompt">ftp&gt;</span> <span class="ftp-cmd">get /IZMAILOVO/DOSSIERS/shatrov_1853.txt</span></div>
    <div class="listing-info">200 PORT command successful.</div>
    <div class="listing-info">150 Opening ASCII mode data transfer.</div>
    <div class="listing-info">226 Transfer complete. <span style="color: var(--amber);">12.4K bytes received.</span></div>
</div>


<div class="page-header amber">
    <div class="stamp amber">РАССЕКРЕЧЕНО</div>
    <div class="header-id">АРХИВ ИЗМАЙЛОВО // ЛИЧНОЕ ДЕЛО № 1853-1932</div>
    <h1 class="header-title">ШАТРОВ Н.Я.</h1>
    <div class="header-subtitle">Крупнейший симбирский фабрикант, меценат, статский советник.</div>
    <div class="dossier-dates">РОЖДЕНИЕ: 17 (29) НОЯБРЯ 1853 <span style="color: var(--red);">// СМЕРТЬ: [ЗАСЕКРЕЧЕНО В УЗЛЕ 0x666]</span></div>
</div>

<!-- ═══ FTP-МЕТА СТРОКА ДОСЬЕ ═══ -->
<div style="max-width: 900px; margin: 0 auto 20px; padding: 10px 20px; background: rgba(0, 255, 65, 0.03); border: 1px solid rgba(0, 255, 65, 0.2); font-family: 'Share Tech Mono', monospace; font-size: 0.95rem;">
    <span style="color: #888;">-rw-r--r--</span>
    <span style="color: var(--amber); margin-left: 15px;">archivist</span>
    <span style="color: var(--cyan); margin-left: 15px;">12.4K</span>
    <span style="color: var(--amber); margin-left: 15px;"><?= date('M d', strtotime('-1 day')) ?></span>
    <span style="color: #666; margin-left: 15px;">shatrov_1853.txt</span>
</div>

<!-- ═══ КАРТОЧКА ПЕРСОНЫ ═══ -->
<div class="person-card">
    <div class="person-photo">
        <img src="/images/shatrov_portrait.jpg" alt="Портрет Н.Я. Шатрова">
    </div>
    <div class="person-info">
        <div class="info-row">
            <div class="info-label">Происхождение:</div>
            <div class="info-value">Податное сословие. Отец — Яков Шатров, унтер-офицер.</div>
        </div>
        <div class="info-row">
            <div class="info-label">Образование:</div>
            <div class="info-value">Домашнее. Всего добился сам.</div>
        </div>
        <div class="info-row">
            <div class="info-label">Семья:</div>
            <div class="info-value">Жена: Надежда Васильевна. Приемная дочь: Олимпиада (Липа).</div>
        </div>
        <div class="info-row">
            <div class="info-label">Должность:</div>
            <div class="info-value">Мануфактур-советник (с 1903), статский советник (с 1912).</div>
        </div>
        <div class="info-row">
            <div class="info-label">Активы (1918):</div>
            <div class="info-value" style="color: var(--red);">> 65 000 000 царских рублей</div>
        </div>
        <div class="info-row">
            <div class="info-label">Статус:</div>
            <div class="info-value" style="color: var(--red); font-style: italic;">
                Эмигрант. Следы теряются в 1932 году... 
                <a href="/secret/" style="color: var(--cyan); text-decoration: underline; text-decoration-style: dashed;">[РАССЕКРЕТИТЬ →]</a>
            </div>
        </div>
    </div>
</div>

<!-- ═══ FTP-ЛИСТИНГ КАНАЛОВ ═══ -->
<div class="ftp-listing">
    <div class="listing-header">
        <span class="ftp-prompt">ftp&gt;</span>
        <span class="ftp-command">ls /IZMAILOVO/DOSSIERS/shatrov_1853/channels/</span>
    </div>
    <div class="listing-output">
        <div class="listing-info">200 PORT command successful.</div>
        <div class="listing-info">150 Opening ASCII mode data transfer.</div>
    </div>

    <!-- ПЕРЕКЛЮЧАТЕЛЬ КАНАЛОВ -->
    <div class="channels">
        <div class="channel-switcher">
            <button class="channel-btn active" onclick="switchChannel('archive')">📡 АРХИВ</button>
            <button class="channel-btn amber" onclick="switchChannel('shuttle')">📼 ЧЕЛНОК</button>
        </div>

        <!-- КАНАЛ АРХИВ -->
        <div class="channel-content active" id="channel-archive">
            <div class="channel-label">📡 КАНАЛ "АРХИВ" // ОФИЦИАЛЬНАЯ ХРОНИКА</div>
            <div class="channel-text">
                В 1885 году Н.Я. Шатров приобрел убыточную мануфактуру Прибыловского и превратил её в передовую фабрику. Ручные станки были заменены механическими фирмы «Добров и Набгольц». К началу ХХ века на фабрике работало свыше <span class="highlight-number">1 500 человек</span>, мощность увеличилась в 10 раз (до <span class="highlight-number">1,5 млн аршин</span> сукна в год).
                <br><br>
                Шатров стал одним из крупнейших производителей сукна в губернии, поставляя продукцию в армию, Симбирск, Казань, Саратов и до Порт-Артура. На Нижегородской ярмарке он имел три каменные лавки. Помимо фабрики, ему принадлежали лесопильные и винокуренный заводы, 4200 десятин земли и дома в Симбирске.
            </div>
        </div>

        <!-- КАНАЛ ЧЕЛНОК -->
        <div class="channel-content" id="channel-shuttle">
            <div class="channel-label">📼 КАНАЛ "ЧЕЛНОК" // ЧЕЛОВЕК ПО ПРОЗВИЩУ "ЧУДАК"</div>
            <div class="channel-text amber">
                Если бы речь шла только о набивании кармана – это не стоило бы внимания. Но Николай Яковлевич поистине был «чудаком» среди фабрикантов. Он построил больницу, ясли, богадельню и церковно-приходскую школу, став её почетным попечителем.
                <br><br>
                Зарплата у нас была выше, чем везде. Давали две недели отпуска до родов и пособие 1 рубль 50 копеек! В общественной столовой на 1000 мест рабочие бесплатно питались 3 раза в день. А еще при фабрике был конный двор: любому желающему можно было прийти за навозом и взять в аренду лошадь. Зачем за навозом? А вот это, мил человек, вы сами прогуглите, я интригу сохраню!
                <br><br>
                А как пели наши хоры! Один из фабричной молодежи, другой из сельских. Как запоют разом – душа на волю просится!
            </div>
        </div>
    </div>

    <div class="listing-footer">
        <div class="listing-info">226 Transfer complete.</div>
        <div class="listing-summary">2 channels, 0 premium, 0 anomaly detected.</div>
    </div>
</div>

<!-- ═══ ТАЙМЛАЙН ЖИЗНИ ═══ -->
<div class="timeline">
    <div class="timeline-item">
        <div class="timeline-year">1853</div>
        <div class="timeline-title">Рождение в военном сословии</div>
        <div class="timeline-text">Родился в семье унтер-офицера Якова Шатрова. Не имея богатых предков, всего добился сам.</div>
    </div>
    <div class="timeline-item">
        <div class="timeline-year">1885</div>
        <div class="timeline-title">Покупка мануфактуры</div>
        <div class="timeline-text">Приобретает сезонное предприятие Прибыловского. Начало модернизации и строительства поселка.</div>
    </div>
    <div class="timeline-item">
        <div class="timeline-year">1895</div>
        <div class="timeline-title">Дом на Венце</div>
        <div class="timeline-text">Приобретает городская усадьба в Симбирске, на Никольской улице. Реконструкция под руководством архитектора Август Шодэ</div> 
        <a href="/secret/" style="color: var(--purple); text-decoration: underline; text-decoration-style: dashed; font-size: 0.9rem;">
            [СЛУХ: Дверь, печатающая деньги →]
        </a>
    </div>
    <div class="timeline-item">
        <div class="timeline-year">1897</div>
        <div class="timeline-title">Храм и Орден</div>
        <div class="timeline-text">Освящение построенного на его средства храма Казанской иконы Божьей Матери. Пожалован орден св. Станислава 2-й степени.</div>
    </div>
    <div class="timeline-item">
        <div class="timeline-year">15.10.1918</div>
        <div class="timeline-title">Национализация</div>
        <div class="timeline-text">Добровольно передает государству все предприятия, запасы, дома и лавки. Сумма активов оценивается более чем в 65 миллионов рублей.</div>
    </div>
    <div class="timeline-item" style="border-left-color: var(--red);">
        <div class="timeline-year" style="color: var(--red); text-shadow: var(--red-glow);">АВГУСТ 1919</div>
        <div class="timeline-title">Исчезновение и начало легенды</div>
        <div class="timeline-text">
            После кратковременного ареста и освобождения Шатров покидает Измайлово. Официальные биографические источники обрываются.
            <br><br>
            <span style="color: var(--amber); font-style: italic;">"Дальнейшая судьба Н.Я. Шатрова неизвестна"</span> — так пишут большинство краеведческих справочников. Местные рабочие десятилетиями передавали легенду о том, что он "растворился в пару машинного зала ТЭЦ".
        </div>
    </div>
    <div class="timeline-item" style="border-left-color: var(--red); opacity: 0.7;">
        <div class="timeline-year" style="color: var(--red);">1925 – 1932</div>
        <div class="timeline-title">Архивная аномалия</div>
        <div class="timeline-text">
            В архивах зафиксированы противоречивые, засекреченные данные: слухи о побеге на Дальний Восток, перехваченные сообщения из Швейцарии и странные визиты в Измайлово людей из окружения Инессы Арманд.
            <br><br>
            <span style="color: var(--red); font-weight: bold;">⚠️ ДОСТУП ОГРАНИЧЕН: Полная хроника событий 1919–1932 гг. находится в защищенном узле.</span>
        </div>
    </div>
</div>

<!-- ═══ МОСТИК НА СЕКРЕТНУЮ СТРАНИЦУ ═══ -->
<div style="max-width: 900px; margin: 40px auto; padding: 0 20px;">
    <div style="border: 2px dashed var(--red); background: rgba(255, 0, 64, 0.05); padding: 30px; text-align: center; position: relative;">
        <div style="position: absolute; top: -15px; left: 50%; transform: translateX(-50%); background: var(--bg-color); padding: 0 15px; color: var(--red); font-size: 1.2rem; letter-spacing: 2px; text-shadow: var(--red-glow);">
            ⚠️ ОБНАРУЖЕНО ПРОТИВОРЕЧИЕ В АРХИВАХ
        </div>
        <h3 style="color: var(--text-color); font-size: 1.8rem; margin-bottom: 15px;">КУДА ИСЧЕЗ ШАТРОВ НА САМОМ ДЕЛЕ?</h3>
        <p style="font-size: 1.3rem; color: #aaa; margin-bottom: 25px; line-height: 1.6;">
            Официальное досье обрывается на 1919 годе. Но в рассекреченных узлах архива хранятся иные данные: <br>
            протоколы допросов, телеграмма Варвары Арманд из Швейцарии (1925) и скан некролога из парижской газеты «Возрождение» (1932), подтверждающий смерть в Вене.
        </p>
        <a href="/secret/" style="display: inline-block; background: var(--red); color: white; text-decoration: none; padding: 15px 40px; font-size: 1.5rem; font-family: 'VT323', monospace; letter-spacing: 2px; transition: all 0.3s; box-shadow: 0 0 15px var(--red);">
            🔓 ПЕРЕЙТИ К РАССЕКРЕЧЕННЫМ МАТЕРИАЛАМ
        </a>
        <p style="font-size: 1rem; color: #666; margin-top: 15px;">
            (Для полного доступа к узлу /secret/ требуется ключ "Архивариус")
        </p>
    </div>
</div>

<!-- ═══ FTP-ЛИСТИНГ ДОКУМЕНТОВ ═══ -->
<div class="ftp-listing">
    <div class="listing-header">
        <span class="ftp-prompt">ftp&gt;</span>
        <span class="ftp-command">ls /IZMAILOVO/DOSSIERS/shatrov_1853/documents/</span>
    </div>
    <div class="listing-output">
        <div class="listing-info">200 PORT command successful.</div>
        <div class="listing-info">150 Opening ASCII mode data transfer.</div>
    </div>

    <div class="documents">
        <div class="doc-title">📄 РАССЕКРЕЧЕННЫЕ ДОКУМЕНТЫ</div>
        
        <div class="doc-item" onclick="alert('Открытие скана газеты 1899 года...')">
            <span class="doc-icon">📰</span>
            <span class="doc-name">simbirskie_vedomosti_1899_stanislav.jpg</span>
            <span class="doc-size">2.1 MB</span>
        </div>
        
        <div class="doc-item" onclick="alert('Открытие протокола национализации...')">
            <span class="doc-icon">📜</span>
            <span class="doc-name">nationalization_protocol_1918_65mln.pdf</span>
            <span class="doc-size">4.5 MB</span>
        </div>

        <div class="doc-item" style="border-color: var(--cyan); background: rgba(0, 229, 255, 0.05);" onclick="alert('Открытие телеграммы...')">
            <span class="doc-icon">📠</span>
            <span class="doc-name" style="color: var(--cyan);">intercept_armand_switzerland_1925.txt</span>
            <span class="doc-size">12 KB</span>
        </div>
    </div>

    <div class="listing-footer">
        <div class="listing-info">226 Transfer complete.</div>
        <div class="listing-summary">3 files, 1 classified. Transfer complete.</div>
    </div>
</div>

<!-- ═══ НАВИГАЦИЯ ═══ -->
<div class="nav-footer">
    <a href="/" class="nav-btn">← В АРХИВ</a>
    <a href="/sector/?id=02" class="nav-btn">К МАРШРУТУ (СЕКТОР 02) →</a>
</div>

<?php require_once __DIR__ . '/includes/footer.php'; ?>