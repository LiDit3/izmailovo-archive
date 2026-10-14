<?php
// /includes/header.php
require_once __DIR__ . '/security.php';

$page_title       = $page_title       ?? 'ИЗМАЙЛОВО // АРХИВ ШАТРОВА';
$page_description = $page_description ?? 'Восстановленный цифровой архив рабочего посёлка Измайлово.';
$page_keywords    = $page_keywords    ?? 'Измайлово, Шатров, Ульяновская область, экскурсия, краеведение';
$page_og_image    = $page_og_image    ?? '/assets/og_default.jpg';
$page_canonical   = $page_canonical   ?? 'https://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
$page_section     = $page_section     ?? 'archive';
$page_sector_id   = $page_sector_id   ?? '';

$is_logged_in = !empty($_SESSION['user_id']);
$current_uri = $_SERVER['REQUEST_URI'] ?? '';
$current_path = trim(parse_url($current_uri, PHP_URL_PATH), '/');

function is_active($paths, $current_path) {
    if (!is_array($paths)) $paths = [$paths];
    foreach ($paths as $path) {
        if ($current_path === $path || $current_path === $path . '/') return true;
    }
    return false;
}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($page_title) ?></title>
    <meta name="description" content="<?= htmlspecialchars($page_description) ?>">
    <meta name="keywords" content="<?= htmlspecialchars($page_keywords) ?>">
    <link rel="canonical" href="<?= htmlspecialchars($page_canonical) ?>">
    
    <!-- Open Graph -->
    <meta property="og:type" content="website">
    <meta property="og:site_name" content="ИЗМАЙЛОВО АРХИВ">
    <meta property="og:title" content="<?= htmlspecialchars($page_title) ?>">
    <meta property="og:description" content="<?= htmlspecialchars($page_description) ?>">
    <meta property="og:image" content="<?= htmlspecialchars($page_og_image) ?>">
    <meta property="og:url" content="<?= htmlspecialchars($page_canonical) ?>">
    
    <link rel="icon" href="data:image/svg+xml,<svg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 100 100%22><text y=%22.9em%22 font-size=%2290%22>📟</text></svg>">
    <link rel="stylesheet" href="/assets/style.css">
    <?php if (isset($page_extra_head)): ?><?= $page_extra_head ?><?php endif; ?>

    <style>
        /* Лёгкий стиль для Header */
        .top-session-bar {
            max-width: 900px;
            margin: 0 auto;
            padding: 8px 20px;
            font-family: 'Share Tech Mono', monospace;
            font-size: 0.85rem;
            color: #666;
            border-bottom: 1px solid rgba(0, 255, 65, 0.1);
            display: flex;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 10px;
        }
        .top-session-bar .highlight { color: var(--amber); }
        
        .site-nav {
            max-width: 900px;
            margin: 0 auto 30px;
            padding: 0 20px;
            display: flex;
            align-items: center;
            flex-wrap: wrap;
            gap: 5px;
            position: relative;
        }
        .nav-link {
            font-family: 'VT323', monospace;
            font-size: 1.3rem;
            color: #888;
            text-decoration: none;
            padding: 8px 16px;
            border-radius: 4px;
            transition: all 0.2s ease;
            position: relative;
        }
        .nav-link:hover {
            color: var(--text-color);
            background: rgba(0, 255, 65, 0.05);
        }
        .nav-link.active {
            color: var(--bg-color);
            background: var(--text-color);
            font-weight: bold;
            box-shadow: 0 0 10px rgba(0, 255, 65, 0.3);
        }
        .nav-link.nav-secret.active { background: var(--red); box-shadow: 0 0 10px rgba(255, 0, 64, 0.3); }
        .nav-link.nav-profile.active { background: var(--cyan); box-shadow: 0 0 10px rgba(0, 229, 255, 0.3); color: #000; }
        
        .nav-burger {
            display: none;
            flex-direction: column;
            justify-content: space-between;
            width: 28px;
            height: 20px;
            background: transparent;
            border: none;
            cursor: pointer;
            padding: 0;
            margin-left: auto;
        }
        .burger-line {
            display: block;
            width: 100%;
            height: 2px;
            background: var(--text-color);
            border-radius: 2px;
            transition: all 0.3s ease;
        }
        .nav-burger.open .burger-line:nth-child(1) { transform: translateY(9px) rotate(45deg); }
        .nav-burger.open .burger-line:nth-child(2) { opacity: 0; }
        .nav-burger.open .burger-line:nth-child(3) { transform: translateY(-9px) rotate(-45deg); }

        @media (max-width: 768px) {
            .nav-burger { display: flex; }
            .site-nav .nav-link { 
                display: none; 
                width: 100%; 
                text-align: left; 
                margin-top: 5px;
            }
            .site-nav.open .nav-link { display: block; }
        }
    </style>
</head>
<body data-section="<?= htmlspecialchars($page_section) ?>"<?= $page_sector_id ? ' data-sector-id="' . htmlspecialchars($page_sector_id) . '"' : '' ?>>

    <!-- Верхняя панель сессии -->
    <div class="top-session-bar">
        <span>USER: <span class="highlight"><?= $is_logged_in ? htmlspecialchars($_SESSION['email'] ?? 'researcher') : 'anonymous' ?></span></span>
        <span>NODE: IZMAILOVO_LOCAL_NET</span>
        <span>LAST LOGIN: <?= date('d.m.Y H:i') ?></span>
    </div>

    <!-- Навигация -->
    <nav class="site-nav" id="site-nav">
        <a href="/" class="nav-link <?= is_active(['', 'index', 'index.php'], $current_path) ? 'active' : '' ?>">🏠 АРХИВ</a>
        <a href="/tour" class="nav-link <?= is_active(['tour', 'tour.php'], $current_path) ? 'active' : '' ?>">МАРШРУТ</a>
        <a href="/map" class="nav-link <?= is_active(['map', 'map.php'], $current_path) ? 'active' : '' ?>">КАРТА</a>
        <a href="/shatrov" class="nav-link <?= is_active(['shatrov', 'shatrov.php'], $current_path) ? 'active' : '' ?>">ШАТРОВ</a>
        <a href="/media" class="nav-link <?= is_active(['media', 'media.php'], $current_path) ? 'active' : '' ?>">МЕДИА</a>
        <a href="/secret" class="nav-link nav-secret <?= is_active(['secret', 'secret.php'], $current_path) ? 'active' : '' ?>">🔒 СЕКРЕТЫ</a>
        
        <?php if ($is_logged_in): ?>
            <a href="/profile" class="nav-link nav-profile <?= is_active(['profile', 'profile.php'], $current_path) ? 'active' : '' ?>" style="margin-left: auto;">👤 КАБИНЕТ</a>
            <a href="/logout" class="nav-link">ВЫХОД</a>
        <?php else: ?>
            <a href="/login" class="nav-link nav-profile <?= is_active(['login', 'login.php'], $current_path) ? 'active' : '' ?>" style="margin-left: auto;">ВХОД</a>
        <?php endif; ?>

        <button class="nav-burger" id="nav-burger" aria-label="Открыть меню" aria-expanded="false">
            <span class="burger-line"></span>
            <span class="burger-line"></span>
            <span class="burger-line"></span>
        </button>
    </nav>