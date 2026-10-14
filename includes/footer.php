<?php
// /includes/footer.php

// Динамическая генерация FTP-метаданных
if (!isset($page_ftp_meta)) $page_ftp_meta = [];
if (empty($page_ftp_meta['type'])) $page_ftp_meta['type'] = $page_section ?? 'archive';

if (empty($page_ftp_meta['id'])) {
    switch ($page_ftp_meta['type']) {
        case 'sector':
            $sector_id = preg_replace('/[^0-9]/', '', $_GET['id'] ?? '00');
            $page_ftp_meta['id'] = $sector_id;
            $page_ftp_meta['subject'] = "Sector {$sector_id}";
            $page_ftp_meta['status'] = 'ACTIVE';
            break;
        case 'dossier':
            $page_ftp_meta['id'] = '1853-1932';
            $page_ftp_meta['subject'] = 'Шатров Н.Я.';
            $page_ftp_meta['status'] = 'РАССЕКРЕЧЕНО';
            break;
        case 'route':
            $page_ftp_meta['id'] = '001';
            $page_ftp_meta['subject'] = 'Эхо машин';
            $page_ftp_meta['status'] = 'ACTIVE';
            break;
        case 'secret':
            $page_ftp_meta['id'] = '0x666';
            $page_ftp_meta['subject'] = 'CLASSIFIED';
            $page_ftp_meta['status'] = 'RESTRICTED';
            break;
        case 'home':
        case 'archive':
        default:
            $page_ftp_meta['id'] = 'ROOT';
            $page_ftp_meta['subject'] = 'IZMAILOVO_LOCAL_NET';
            $page_ftp_meta['status'] = 'ONLINE';
            break;
    }
}

$status_color = 'var(--text-color)';
if (isset($page_ftp_meta['status'])) {
    switch ($page_ftp_meta['status']) {
        case 'РАССЕКРЕЧЕНО': case 'ACTIVE': case 'ONLINE': $status_color = 'var(--amber)'; break;
        case 'RESTRICTED': case 'CLASSIFIED': $status_color = 'var(--red)'; break;
        case 'ANOMALY': $status_color = 'var(--cyan)'; break;
        case 'PARTIAL': $status_color = 'var(--purple)'; break;
    }
}
?>

    <style>
        /* Лёгкий стиль для Footer */
        .system-status-bar {
            max-width: 900px;
            margin: 60px auto 20px;
            padding: 15px 20px;
            border-top: 1px solid rgba(0, 255, 65, 0.15);
            font-family: 'Share Tech Mono', monospace;
            font-size: 0.9rem;
            color: #666;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 15px;
        }
        .status-item { display: flex; gap: 8px; }
        .status-label { color: #444; text-transform: uppercase; font-size: 0.8rem; }
        .status-value { color: var(--text-color); }
        .status-value.highlight { color: <?= $status_color ?>; }
        
        .footer-quote {
            max-width: 900px;
            margin: 0 auto 30px;
            padding: 0 20px;
            text-align: center;
            font-family: 'VT323', monospace;
            font-size: 1.1rem;
            color: #444;
            letter-spacing: 1px;
        }
        .footer-quote span { color: #666; font-style: italic; }
        
        .footer-links {
            max-width: 900px;
            margin: 0 auto;
            padding: 0 20px 20px;
            text-align: center;
            font-family: 'Share Tech Mono', monospace;
            font-size: 0.8rem;
        }
        .footer-links a { color: #555; text-decoration: none; margin: 0 10px; transition: color 0.2s; }
        .footer-links a:hover { color: var(--amber); }

        @media (max-width: 768px) {
            .system-status-bar { flex-direction: column; align-items: flex-start; gap: 10px; }
        }
    </style>

    <!-- Строка состояния системы (в стиле нижней панели NC) -->
    <div class="system-status-bar">
        <div class="status-item">
            <span class="status-label">TYPE:</span>
            <span class="status-value"><?= htmlspecialchars(strtoupper($page_ftp_meta['type'])) ?></span>
        </div>
        <div class="status-item">
            <span class="status-label">ID:</span>
            <span class="status-value"><?= htmlspecialchars($page_ftp_meta['id']) ?></span>
        </div>
        <div class="status-item">
            <span class="status-label">SUBJECT:</span>
            <span class="status-value"><?= htmlspecialchars($page_ftp_meta['subject']) ?></span>
        </div>
        <div class="status-item">
            <span class="status-label">STATUS:</span>
            <span class="status-value highlight"><?= htmlspecialchars($page_ftp_meta['status']) ?></span>
        </div>
        <div class="status-item">
            <span class="status-label">UPDATED:</span>
            <span class="status-value"><?= date('d.m.Y') ?></span>
        </div>
    </div>

    <!-- Цитата -->
    <div class="footer-quote">
        "No matter where you are, everyone is always connected."<br>
        <span>Даже через сто лет. Измайлово помнит.</span>
    </div>

    <!-- Ссылки -->
    <div class="footer-links">
        <a href="/privacy">Политика конфиденциальности</a>
        <span>•</span>
        <a href="/terms">Условия использования</a>
    </div>

    <!-- Скрипты с CSP Nonce -->
    <script src="/assets/script.js" nonce="<?= htmlspecialchars($GLOBALS['csp_nonce'] ?? '') ?>"></script>
    <?php if (!empty($page_script)): ?>
        <script src="/assets/pages/<?= htmlspecialchars($page_script) ?>" nonce="<?= htmlspecialchars($GLOBALS['csp_nonce'] ?? '') ?>"></script>
    <?php endif; ?>
</body>
</html>