<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EcoSense Hub - Platform Telemetri Terpadu</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        :root {
            --bg-page: #f8fafc;
            --bg-card: #ffffff;
            --border: #e2e8f0;
            --border-hover: #cbd5e1;
            --text-primary: #0f172a;
            --text-secondary: #475569;
            --text-muted: #64748b;
            --green-dark: #14532d;
            --green-primary: #166534;
            --green-hover: #15803d;
            --green-light: #f0fdf4;
            --green-border: #bbf7d0;
            --amber-dark: #92400e;
            --amber-light: #fffbeb;
            --amber-border: #fde68a;
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: var(--bg-page);
            color: var(--text-primary);
            min-height: 100vh;
            padding-bottom: 60px;
            line-height: 1.6;
        }

        /* Top Navigation Bar */
        .top-nav {
            background-color: #ffffff;
            border-bottom: 1px solid var(--border);
            position: sticky;
            top: 0;
            z-index: 100;
            padding: 14px 36px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .brand-box {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .brand-logo {
            height: 38px;
            width: auto;
            object-fit: contain;
        }

        .nav-links {
            display: flex;
            align-items: center;
            gap: 4px;
            background-color: #f1f5f9;
            padding: 4px;
            border-radius: 8px;
            border: 1px solid var(--border);
        }

        .nav-item {
            display: flex;
            align-items: center;
            padding: 7px 16px;
            border-radius: 6px;
            font-size: 13px;
            font-weight: 600;
            color: var(--text-secondary);
            text-decoration: none;
            transition: all 0.15s ease;
        }

        .nav-item:hover {
            color: var(--green-dark);
            background-color: #ffffff;
        }

        .nav-item.active {
            background-color: var(--green-primary);
            color: #ffffff;
        }

        .sys-status-badge {
            display: flex;
            align-items: center;
            gap: 8px;
            background-color: var(--green-light);
            border: 1px solid var(--green-border);
            color: var(--green-dark);
            padding: 6px 14px;
            border-radius: 6px;
            font-size: 12px;
            font-weight: 600;
        }

        .status-dot {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background-color: var(--green-primary);
        }

        /* Container */
        .container {
            max-width: 1280px;
            margin: 0 auto;
            padding: 32px 24px;
        }

        /* Holistic Verdict Card */
        .holistic-banner {
            background-color: #ffffff;
            border: 1px solid var(--border);
            border-left: 4px solid var(--green-primary);
            border-radius: 12px;
            padding: 24px 30px;
            margin-bottom: 32px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.04);
        }

        .holistic-left h3 {
            font-size: 11px;
            text-transform: uppercase;
            letter-spacing: 0.06em;
            color: var(--green-primary);
            font-weight: 700;
            margin-bottom: 4px;
        }

        .holistic-left h2 {
            font-size: 22px;
            font-weight: 800;
            color: var(--text-primary);
            margin-bottom: 6px;
        }

        .holistic-left p {
            font-size: 14px;
            color: var(--text-secondary);
            max-width: 780px;
        }

        .btn-outline {
            background-color: #ffffff;
            border: 1px solid var(--border);
            color: var(--text-primary);
            padding: 9px 18px;
            border-radius: 8px;
            font-size: 13px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.15s ease;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            white-space: nowrap;
        }

        .btn-outline:hover {
            border-color: var(--green-primary);
            color: var(--green-dark);
            background-color: var(--green-light);
        }

        /* 3 Dashboard Selection Cards */
        .cards-heading {
            display: flex;
            justify-content: space-between;
            align-items: flex-end;
            margin-bottom: 18px;
        }

        .cards-heading h3 {
            font-size: 18px;
            font-weight: 800;
            color: var(--text-primary);
        }

        .cards-heading span {
            font-size: 12px;
            color: var(--text-muted);
        }

        .dashboard-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 22px;
            margin-bottom: 36px;
        }

        .card-choice {
            background-color: #ffffff;
            border: 1px solid var(--border);
            border-radius: 12px;
            padding: 24px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            position: relative;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.04);
            transition: border-color 0.2s ease, box-shadow 0.2s ease;
            text-decoration: none;
            color: inherit;
        }

        .card-choice:hover {
            border-color: var(--green-primary);
            box-shadow: 0 4px 12px rgba(20, 83, 45, 0.08);
        }

        .card-header-flex {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 16px;
        }

        .node-tag {
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.04em;
            color: var(--green-dark);
            background-color: var(--green-light);
            padding: 4px 8px;
            border-radius: 4px;
            border: 1px solid var(--green-border);
        }

        .verdict-tag {
            font-size: 11px;
            font-weight: 700;
            padding: 4px 10px;
            border-radius: 4px;
        }

        .verdict-optimal {
            background-color: var(--green-light);
            color: var(--green-dark);
            border: 1px solid var(--green-border);
        }

        .verdict-warning {
            background-color: var(--amber-light);
            color: var(--amber-dark);
            border: 1px solid var(--amber-border);
        }

        .card-title-group h3 {
            font-size: 20px;
            font-weight: 800;
            color: var(--text-primary);
            margin-bottom: 6px;
        }

        /* Actionable Guidance Box inside Card */
        .actionable-box {
            background-color: #f8fafc;
            border-left: 3px solid var(--green-primary);
            padding: 10px 12px;
            border-radius: 0 6px 6px 0;
            margin-bottom: 18px;
            font-size: 12px;
            color: var(--text-secondary);
            line-height: 1.5;
        }

        /* Live Preview Grid */
        .live-preview-grid {
            background-color: #f8fafc;
            border-radius: 8px;
            padding: 14px;
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 12px;
            margin-bottom: 20px;
            border: 1px solid var(--border);
        }

        .preview-stat {
            display: flex;
            flex-direction: column;
        }

        .preview-label {
            font-size: 11px;
            color: var(--text-muted);
            text-transform: uppercase;
            font-weight: 600;
            margin-bottom: 2px;
        }

        .preview-val {
            font-size: 18px;
            font-weight: 800;
            color: var(--text-primary);
        }

        .preview-unit {
            font-size: 11px;
            font-weight: 500;
            color: var(--text-muted);
            margin-left: 2px;
        }

        /* Action Button inside Card */
        .card-action-btn {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 11px 16px;
            border-radius: 6px;
            font-size: 13px;
            font-weight: 700;
            background-color: var(--green-light);
            color: var(--green-dark);
            border: 1px solid var(--green-border);
            transition: all 0.15s ease;
        }

        .card-choice:hover .card-action-btn {
            background-color: var(--green-primary);
            color: #ffffff;
            border-color: var(--green-primary);
        }

        /* Scenario Playground */
        .playground-card {
            background-color: #ffffff;
            border: 1px solid var(--border);
            border-radius: 12px;
            padding: 24px 30px;
            margin-bottom: 32px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.04);
        }

        .playground-header {
            margin-bottom: 16px;
        }

        .playground-header h4 {
            font-size: 16px;
            font-weight: 800;
            color: var(--text-primary);
            margin-bottom: 4px;
        }

        .playground-header p {
            font-size: 13px;
            color: var(--text-secondary);
        }

        .scenario-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 12px;
        }

        .scenario-btn {
            background-color: #ffffff;
            border: 1px solid var(--border);
            border-radius: 8px;
            padding: 14px;
            cursor: pointer;
            text-align: left;
            transition: all 0.15s ease;
            display: flex;
            flex-direction: column;
            gap: 4px;
            color: inherit;
        }

        .scenario-btn:hover {
            border-color: var(--green-primary);
            background-color: var(--green-light);
        }

        .scenario-title {
            font-size: 13px;
            font-weight: 700;
            color: var(--green-dark);
        }

        .scenario-desc {
            font-size: 11px;
            color: var(--text-muted);
            line-height: 1.4;
        }

        /* Bottom Section */
        .bottom-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 22px;
        }

        .info-panel {
            background-color: #ffffff;
            border: 1px solid var(--border);
            border-radius: 12px;
            padding: 22px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.04);
        }

        .info-panel h4 {
            font-size: 15px;
            font-weight: 700;
            color: var(--text-primary);
            margin-bottom: 6px;
        }

        .info-panel p {
            font-size: 13px;
            color: var(--text-secondary);
            margin-bottom: 14px;
        }

        .api-list {
            list-style: none;
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        .api-item {
            background-color: #f8fafc;
            border: 1px solid var(--border);
            padding: 8px 12px;
            border-radius: 6px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-family: monospace;
            font-size: 12px;
        }

        .api-badge {
            background-color: var(--green-light);
            color: var(--green-dark);
            border: 1px solid var(--green-border);
            padding: 2px 6px;
            border-radius: 4px;
            font-weight: 700;
            font-size: 10px;
        }

        /* Modal */
        .modal-overlay {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: rgba(15, 23, 42, 0.5);
            display: none;
            align-items: center;
            justify-content: center;
            z-index: 1000;
            padding: 20px;
        }

        .modal-overlay.open {
            display: flex;
        }

        .modal-content {
            background-color: #ffffff;
            border: 1px solid var(--border);
            border-radius: 12px;
            max-width: 640px;
            width: 100%;
            padding: 28px;
            max-height: 85vh;
            overflow-y: auto;
            position: relative;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
        }

        .modal-close {
            position: absolute;
            top: 20px;
            right: 20px;
            background-color: #f1f5f9;
            border: 1px solid var(--border);
            color: var(--text-secondary);
            width: 32px;
            height: 32px;
            border-radius: 6px;
            cursor: pointer;
            font-size: 14px;
            font-weight: bold;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .modal-close:hover {
            background-color: #e2e8f0;
            color: var(--text-primary);
        }

        .glossary-item {
            border-bottom: 1px solid var(--border);
            padding: 12px 0;
        }

        .glossary-item:last-child {
            border-bottom: none;
        }

        .glossary-item h5 {
            font-size: 14px;
            font-weight: 700;
            color: var(--green-dark);
            margin-bottom: 4px;
        }

        .glossary-item p {
            font-size: 13px;
            color: var(--text-secondary);
            line-height: 1.5;
        }

        /* Toast */
        .toast-notif {
            position: fixed;
            bottom: 24px;
            right: 24px;
            background-color: var(--green-dark);
            color: #ffffff;
            padding: 12px 20px;
            border-radius: 8px;
            font-size: 13px;
            font-weight: 600;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
            opacity: 0;
            pointer-events: none;
            transform: translateY(12px);
            transition: all 0.2s ease;
            z-index: 1000;
            max-width: 440px;
        }

        .toast-notif.show {
            opacity: 1;
            pointer-events: auto;
            transform: translateY(0);
        }

        /* --- MOBILE NAV TOGGLE --- */
        .nav-toggle {
            display: none;
            background: none;
            border: 1px solid var(--border);
            border-radius: 6px;
            padding: 6px 10px;
            cursor: pointer;
            color: var(--text-primary);
            font-size: 18px;
            line-height: 1;
        }

        /* --- TABLET BREAKPOINT --- */
        @media (max-width: 1024px) {
            .dashboard-grid {
                grid-template-columns: 1fr;
            }
            .scenario-grid {
                grid-template-columns: repeat(2, 1fr);
            }
            .bottom-grid {
                grid-template-columns: 1fr;
            }
            .holistic-banner {
                flex-direction: column;
                gap: 16px;
                align-items: flex-start;
            }
            .top-nav {
                padding: 12px 20px;
            }
        }

        /* --- MOBILE BREAKPOINT --- */
        @media (max-width: 640px) {
            .top-nav {
                flex-direction: column;
                gap: 10px;
                padding: 12px 16px;
                position: sticky;
                top: 0;
            }
            .top-nav > .brand-box {
                width: 100%;
                display: flex;
                justify-content: space-between;
                align-items: center;
            }
            .nav-toggle {
                display: block;
            }
            .nav-links {
                display: none;
                width: 100%;
                flex-direction: column;
                gap: 4px;
                background-color: #f1f5f9;
                padding: 6px;
                border-radius: 8px;
                border: 1px solid var(--border);
            }
            .nav-links.open {
                display: flex;
            }
            .nav-item {
                width: 100%;
                text-align: center;
                padding: 10px 16px;
                font-size: 14px;
            }
            .sys-status-badge {
                display: none;
            }
            .container {
                padding: 16px 12px;
            }
            .holistic-banner {
                padding: 18px 16px;
                border-radius: 10px;
                margin-bottom: 20px;
            }
            .holistic-left h2 {
                font-size: 18px;
            }
            .holistic-left p {
                font-size: 13px;
            }
            .cards-heading {
                flex-direction: column;
                align-items: flex-start;
                gap: 6px;
                margin-bottom: 14px;
            }
            .cards-heading h3 {
                font-size: 16px;
            }
            .card-choice {
                padding: 18px;
                border-radius: 10px;
            }
            .card-title-group h3 {
                font-size: 17px;
            }
            .preview-val {
                font-size: 16px;
            }
            .scenario-grid {
                grid-template-columns: 1fr;
            }
            .scenario-btn {
                padding: 12px;
            }
            .playground-card {
                padding: 18px 16px;
                border-radius: 10px;
            }
            .playground-header h4 {
                font-size: 15px;
            }
            .info-panel {
                padding: 18px 16px;
                border-radius: 10px;
            }
            .api-item {
                flex-direction: column;
                align-items: flex-start;
                gap: 4px;
                font-size: 11px;
            }
            .modal-content {
                padding: 20px 16px;
                max-height: 90vh;
                border-radius: 10px;
            }
            .toast-notif {
                left: 12px;
                right: 12px;
                bottom: 16px;
                max-width: none;
                text-align: center;
            }
            #sync-indicator {
                display: none;
            }
        }

        /* --- SMALL MOBILE --- */
        @media (max-width: 380px) {
            .brand-logo {
                height: 28px;
            }
            .holistic-left h2 {
                font-size: 16px;
            }
            .card-title-group h3 {
                font-size: 15px;
            }
            .preview-val {
                font-size: 14px;
            }
            .live-preview-grid {
                grid-template-columns: 1fr 1fr;
                gap: 8px;
                padding: 10px;
            }
        }
    </style>
</head>
<body>

    <!-- TOP NAVIGATION -->
    <nav class="top-nav">
        <div class="brand-box">
            <img src="/logopanjang.webp" alt="Agronex Nusantara" class="brand-logo">
            <button class="nav-toggle" onclick="document.querySelector('.nav-links').classList.toggle('open')" aria-label="Menu navigasi">&#9776;</button>
        </div>

        <div class="nav-links">
            <a href="{{ route('hub') }}" class="nav-item active">Portal Hub</a>
            <a href="{{ route('soil.dashboard') }}" class="nav-item">Monitoring Tanah</a>
            <a href="{{ route('water.dashboard') }}" class="nav-item">Kualitas Air</a>
            <a href="{{ route('weather.dashboard') }}" class="nav-item">Stasiun Cuaca</a>
        </div>

        <div class="sys-status-badge">
            <span class="status-dot"></span>
            <span>3 Node Sensor Aktif</span>
        </div>
    </nav>

    <!-- MAIN CONTAINER -->
    <div class="container">

        <!-- 1. HOLISTIC SITUATION BANNER -->
        <section class="holistic-banner">
            <div class="holistic-left">
                <h3>Analisis Situasi Terpadu</h3>
                <h2 id="ecosystem-title">{{ $ecosystemVerdict }}</h2>
                <p id="ecosystem-desc">
                    Kondisi tanah saat ini <strong style="color: var(--green-dark);">{{ $soilHealth }}</strong>, kualitas air terpantau <strong style="color: var(--green-dark);">{{ $waterHealth }}</strong>, dan cuaca area dalam status <strong style="color: var(--green-dark);">{{ $weatherHealth }}</strong>.
                </p>
            </div>
            <div>
                <button class="btn-outline" onclick="openModal()">
                    Panduan Parameter
                </button>
            </div>
        </section>

        <!-- 2. DASHBOARD SELECTION CARDS -->
        <div class="cards-heading">
            <div>
                <h3>Pilih Modul Monitoring</h3>
                <span>Akses analitik mendalam, grafik telemetri, dan log historis per stasiun</span>
            </div>
            <span style="font-size: 12px; color: var(--text-muted);" id="sync-indicator">
                Sinkronisasi otomatis aktif • Pemeriksaan tiap 6 detik
            </span>
        </div>

        <div class="dashboard-grid">

            <!-- CARD 1: SOIL -->
            <a href="{{ route('soil.dashboard') }}" class="card-choice">
                <div>
                    <div class="card-header-flex">
                        <span class="node-tag">Node 01 • Tanah</span>
                        <span class="verdict-tag verdict-optimal" id="soil-badge">
                            <span id="soil-badge-text">{{ $soilHealth }}</span>
                        </span>
                    </div>

                    <div class="card-title-group">
                        <h3>Monitoring Tanah</h3>
                    </div>

                    <div class="actionable-box" id="soil-advice-box">
                        <strong>Catatan Lapangan:</strong>
                        <span id="soil-advice-text">{{ $soilAdvice }}</span>
                    </div>

                    <!-- Live KPI Preview -->
                    <div class="live-preview-grid">
                        <div class="preview-stat">
                            <span class="preview-label">Kelembapan</span>
                            <span class="preview-val" id="soil-moist">{{ $latestSoil ? number_format($latestSoil->kelembapan, 1) : '--' }}<span class="preview-unit">%</span></span>
                        </div>
                        <div class="preview-stat">
                            <span class="preview-label">Suhu Tanah</span>
                            <span class="preview-val" id="soil-temp">{{ $latestSoil ? number_format($latestSoil->suhu, 1) : '--' }}<span class="preview-unit">°C</span></span>
                        </div>
                        <div class="preview-stat">
                            <span class="preview-label">pH Tanah</span>
                            <span class="preview-val" id="soil-ph">{{ $latestSoil ? number_format($latestSoil->ph, 2) : '--' }}</span>
                        </div>
                        <div class="preview-stat">
                            <span class="preview-label">Nutrisi NPK</span>
                            <span class="preview-val" id="soil-npk">{{ $latestSoil ? ($latestSoil->nitrogen + $latestSoil->fosfor + $latestSoil->kalium) : '--' }}<span class="preview-unit">mg/kg</span></span>
                        </div>
                    </div>
                </div>

                <div class="card-action-btn">
                    <span>Masuk ke Dashboard Tanah</span>
                    <span>→</span>
                </div>
            </a>

            <!-- CARD 2: WATER -->
            <a href="{{ route('water.dashboard') }}" class="card-choice">
                <div>
                    <div class="card-header-flex">
                        <span class="node-tag">Node 02 • Air</span>
                        <span class="verdict-tag verdict-optimal" id="water-badge">
                            <span id="water-badge-text">{{ $waterHealth }}</span>
                        </span>
                    </div>

                    <div class="card-title-group">
                        <h3>Kualitas Air</h3>
                    </div>

                    <div class="actionable-box" id="water-advice-box">
                        <strong>Catatan Lapangan:</strong>
                        <span id="water-advice-text">{{ $waterAdvice }}</span>
                    </div>

                    <!-- Live KPI Preview -->
                    <div class="live-preview-grid">
                        <div class="preview-stat">
                            <span class="preview-label">Derajat Keasaman</span>
                            <span class="preview-val" id="water-ph">{{ $latestWater ? number_format($latestWater->ph, 2) : '--' }}<span class="preview-unit">pH</span></span>
                        </div>
                        <div class="preview-stat">
                            <span class="preview-label">Suhu Air</span>
                            <span class="preview-val" id="water-temp">{{ $latestWater ? number_format($latestWater->suhu, 2) : '--' }}<span class="preview-unit">°C</span></span>
                        </div>
                        <div class="preview-stat">
                            <span class="preview-label">Kejernihan</span>
                            <span class="preview-val" id="water-turb">{{ $latestWater ? number_format($latestWater->turbidity, 0) : '--' }}<span class="preview-unit">NTU</span></span>
                        </div>
                        <div class="preview-stat">
                            <span class="preview-label">Padatan Terlarut</span>
                            <span class="preview-val" id="water-tds">{{ $latestWater ? number_format($latestWater->tds, 0) : '--' }}<span class="preview-unit">ppm</span></span>
                        </div>
                    </div>
                </div>

                <div class="card-action-btn">
                    <span>Masuk ke Dashboard Air</span>
                    <span>→</span>
                </div>
            </a>

            <!-- CARD 3: WEATHER -->
            <a href="{{ route('weather.dashboard') }}" class="card-choice">
                <div>
                    <div class="card-header-flex">
                        <span class="node-tag">Node 03 • Cuaca</span>
                        <span class="verdict-tag verdict-optimal" id="weather-badge">
                            <span id="weather-badge-text">{{ $weatherHealth }}</span>
                        </span>
                    </div>

                    <div class="card-title-group">
                        <h3>Stasiun Cuaca</h3>
                    </div>

                    <div class="actionable-box" id="weather-advice-box">
                        <strong>Catatan Lapangan:</strong>
                        <span id="weather-advice-text">{{ $weatherAdvice }}</span>
                    </div>

                    <!-- Live KPI Preview -->
                    <div class="live-preview-grid">
                        <div class="preview-stat">
                            <span class="preview-label">Suhu Ambien</span>
                            <span class="preview-val" id="weather-temp">{{ $latestWeather ? number_format($latestWeather->suhu, 1) : '--' }}<span class="preview-unit">°C</span></span>
                        </div>
                        <div class="preview-stat">
                            <span class="preview-label">Kelembapan Udara</span>
                            <span class="preview-val" id="weather-hum">{{ $latestWeather ? number_format($latestWeather->kelembapan, 1) : '--' }}<span class="preview-unit">%</span></span>
                        </div>
                        <div class="preview-stat">
                            <span class="preview-label">Kecepatan Angin</span>
                            <span class="preview-val" id="weather-wind">{{ $latestWeather ? number_format($latestWeather->kecepatan_angin, 1) : '--' }}<span class="preview-unit">m/s</span></span>
                        </div>
                        <div class="preview-stat">
                            <span class="preview-label">Curah Hujan</span>
                            <span class="preview-val" id="weather-rain">{{ $latestWeather ? $latestWeather->curah_hujan : '0' }}<span class="preview-unit">mm</span></span>
                        </div>
                    </div>
                </div>

                <div class="card-action-btn">
                    <span>Masuk ke Dashboard Cuaca</span>
                    <span>→</span>
                </div>
            </a>

        </div>

        <!-- 3. TACTILE SCENARIO PLAYGROUND -->
        <section class="playground-card">
            <div class="playground-header">
                <h4>Pengujian Respon Skenario</h4>
                <p>Pilih skenario simulasi untuk memverifikasi respon peringatan dan grafik pada sistem:</p>
            </div>

            <div class="scenario-grid">
                <button class="scenario-btn" onclick="applyScenario('ideal')">
                    <div class="scenario-title">Kondisi Normal & Subur</div>
                    <div class="scenario-desc">Kelembapan tanah 65%, pH 7.0, cuaca sejuk, air jernih.</div>
                </button>

                <button class="scenario-btn" onclick="applyScenario('kemarau')">
                    <div class="scenario-title">Skenario Kemarau Panjang</div>
                    <div class="scenario-desc">Suhu 37°C, tanah kering (<25%), laju penguapan tinggi.</div>
                </button>

                <button class="scenario-btn" onclick="applyScenario('hujan')">
                    <div class="scenario-title">Skenario Hujan Deras</div>
                    <div class="scenario-desc">Curah hujan 50 mm, tanah jenuh air, kekeruhan air meningkat.</div>
                </button>

                <button class="scenario-btn" onclick="applyScenario('tercemar')">
                    <div class="scenario-title">Skenario Gangguan Air</div>
                    <div class="scenario-desc">pH air drop asam (<5.5), padatan TDS tinggi, air keruh.</div>
                </button>
            </div>
        </section>

        <!-- 4. BOTTOM GUIDES & IOT API REFERENCE -->
        <div class="bottom-grid">
            <div class="info-panel">
                <h4>Informasi Penyimpanan Data</h4>
                <p>Data telemetri dari mikrokontroler tersimpan dalam basis data lokal untuk kebutuhan rekapitulasi berkala.</p>
                <div style="font-size: 13px; color: var(--text-secondary); display: flex; flex-direction: column; gap: 8px;">
                    <div>• Total Rekaman Data Tanah: <strong id="cnt-soil" style="color: var(--text-primary);">{{ $totalSoilCount }}</strong> log</div>
                    <div>• Total Rekaman Data Air: <strong id="cnt-water" style="color: var(--text-primary);">{{ $totalWaterCount }}</strong> log</div>
                    <div>• Total Rekaman Data Cuaca: <strong id="cnt-weather" style="color: var(--text-primary);">{{ $totalWeatherCount }}</strong> log</div>
                    <div>• Waktu Terakhir Diterima: <strong id="last-sync-tag" style="color: var(--green-dark);">Aktif</strong></div>
                </div>
            </div>

            <div class="info-panel">
                <h4>Format Endpoint Sensor IoT</h4>
                <p>Endpoint pengiriman data telemetri dari perangkat ESP32 / Arduino / Gateway:</p>
                <ul class="api-list">
                    <li class="api-item">
                        <span><span class="api-badge">POST</span> /api/soil-data</span>
                        <span style="color: var(--text-muted);">Sensor Tanah</span>
                    </li>
                    <li class="api-item">
                        <span><span class="api-badge">POST</span> /api/water-data</span>
                        <span style="color: var(--text-muted);">Sensor Kualitas Air</span>
                    </li>
                    <li class="api-item">
                        <span><span class="api-badge">POST</span> /api/weather-data</span>
                        <span style="color: var(--text-muted);">Stasiun Cuaca</span>
                    </li>
                </ul>
            </div>
        </div>

    </div>

    <!-- SENSOR GUIDEBOOK MODAL -->
    <div id="guideModal" class="modal-overlay" onclick="closeModalOnBg(event)">
        <div class="modal-content">
            <button class="modal-close" onclick="closeModal()">✕</button>
            <h3 style="font-size: 18px; font-weight: 800; color: var(--text-primary); margin-bottom: 4px;">Panduan Parameter Sensor</h3>
            <p style="font-size: 13px; color: var(--text-muted); margin-bottom: 18px;">Penjelasan teknis sederhana untuk mempermudah evaluasi kondisi lapangan:</p>

            <div class="glossary-item">
                <h5>EC (Electrical Conductivity) • Kepekatan Hara Pupuk</h5>
                <p>Mengukur kemampuan tanah menghantarkan arus listrik, berbanding lurus dengan garam pupuk terlarut. Nilai 600 - 1200 us/cm menandakan ketersediaan hara memadai.</p>
            </div>

            <div class="glossary-item">
                <h5>TDS (Total Dissolved Solids) • Padatan Terlarut Air</h5>
                <p>Jumlah partikel mineral dan zat terlarut dalam air (ppm). Nilai di bawah 300 ppm tergolong sangat baik untuk perikanan dan sumber air bersih.</p>
            </div>

            <div class="glossary-item">
                <h5>Turbidity • Tingkat Kekeruhan Air (NTU)</h5>
                <p>Tingkat kejernihan air akibat partikel lumpur atau alga tersuspensi. Nilai di bawah 5 NTU menandakan air jernih; di atas 25 NTU air tergolong keruh.</p>
            </div>

            <div class="glossary-item">
                <h5>ET0 (Evapotranspirasi Acuan • mm/hari)</h5>
                <p>Volume penguapan air harian dari tanah dan tanaman ke udara. Jika nilai ET0 tinggi (>5 mm), tanaman memerlukan suplai penyiraman ekstra.</p>
            </div>

            <div class="glossary-item">
                <h5>Derajat Keasaman (pH)</h5>
                <p>Skala keasaman 0 - 14. Netral bernilai 7.0. Sebagian besar tanaman pangan dan ikan tawar tumbuh optimal pada rentang 6.5 hingga 7.5.</p>
            </div>
        </div>
    </div>

    <!-- TOAST NOTIFICATION -->
    <div id="toast" class="toast-notif">Skenario berhasil diterapkan</div>

    <script>
        function showToast(msg) {
            const toast = document.getElementById('toast');
            toast.textContent = msg;
            toast.classList.add('show');
            setTimeout(() => toast.classList.remove('show'), 3000);
        }

        function openModal() {
            document.getElementById('guideModal').classList.add('open');
        }

        function closeModal() {
            document.getElementById('guideModal').classList.remove('open');
        }

        function closeModalOnBg(e) {
            if (e.target.id === 'guideModal') closeModal();
        }

        async function applyScenario(scenarioName) {
            try {
                const res = await fetch(`{{ route('hub.simulate') }}?scenario=${scenarioName}`);
                const json = await res.json();
                if (json.success) {
                    showToast(json.message);
                    fetchHubStatus();
                }
            } catch (e) {
                console.error('Scenario simulation failed:', e);
            }
        }

        async function fetchHubStatus() {
            try {
                const res = await fetch(`{{ route('hub.status') }}`);
                const data = await res.json();
                if (data.success) {
                    // Update Soil Preview
                    if (data.soil.latest) {
                        const s = data.soil.latest;
                        document.getElementById('soil-moist').innerHTML = Number(s.kelembapan).toFixed(1) + '<span class="preview-unit">%</span>';
                        document.getElementById('soil-temp').innerHTML = Number(s.suhu).toFixed(1) + '<span class="preview-unit">°C</span>';
                        document.getElementById('soil-ph').textContent = Number(s.ph).toFixed(2);
                        const npk = Number(s.nitrogen || 0) + Number(s.fosfor || 0) + Number(s.kalium || 0);
                        document.getElementById('soil-npk').innerHTML = npk + '<span class="preview-unit">mg/kg</span>';

                        if (s.kelembapan < 35) {
                            document.getElementById('soil-badge-text').textContent = 'Kering';
                            document.getElementById('soil-badge').className = 'verdict-tag verdict-warning';
                            document.getElementById('soil-advice-text').textContent = 'Kelembapan tanah rendah. Disarankan mengaktifkan penyiraman berkala.';
                        } else if (s.kelembapan > 80) {
                            document.getElementById('soil-badge-text').textContent = 'Terlalu Basah';
                            document.getElementById('soil-badge').className = 'verdict-tag verdict-warning';
                            document.getElementById('soil-advice-text').textContent = 'Tanah sangat jenuh air. Periksa drainase agar akar tidak busuk.';
                        } else {
                            document.getElementById('soil-badge-text').textContent = 'Optimal';
                            document.getElementById('soil-badge').className = 'verdict-tag verdict-optimal';
                            document.getElementById('soil-advice-text').textContent = 'Kadar air dan hara dalam kondisi sangat baik untuk pertumbuhan.';
                        }
                    }
                    document.getElementById('cnt-soil').textContent = data.soil.count;

                    // Update Water Preview
                    if (data.water.latest) {
                        const w = data.water.latest;
                        document.getElementById('water-ph').innerHTML = Number(w.ph).toFixed(2) + '<span class="preview-unit">pH</span>';
                        document.getElementById('water-temp').innerHTML = Number(w.suhu).toFixed(2) + '<span class="preview-unit">°C</span>';
                        document.getElementById('water-turb').innerHTML = Number(w.turbidity).toFixed(0) + '<span class="preview-unit">NTU</span>';
                        document.getElementById('water-tds').innerHTML = Number(w.tds).toFixed(0) + '<span class="preview-unit">ppm</span>';

                        if (w.ph < 6.0 || w.turbidity > 25 || w.tds > 500) {
                            document.getElementById('water-badge-text').textContent = 'Perlu Perhatian';
                            document.getElementById('water-badge').className = 'verdict-tag verdict-warning';
                            document.getElementById('water-advice-text').textContent = 'Kualitas air menyimpang dari ambang batas aman. Segera periksa filter.';
                        } else {
                            document.getElementById('water-badge-text').textContent = 'Normal & Bersih';
                            document.getElementById('water-badge').className = 'verdict-tag verdict-optimal';
                            document.getElementById('water-advice-text').textContent = 'Kualitas air stabil dan aman untuk budidaya maupun kebutuhan harian.';
                        }
                    }
                    document.getElementById('cnt-water').textContent = data.water.count;

                    // Update Weather Preview
                    if (data.weather.latest) {
                        const m = data.weather.latest;
                        document.getElementById('weather-temp').innerHTML = Number(m.suhu).toFixed(1) + '<span class="preview-unit">°C</span>';
                        document.getElementById('weather-hum').innerHTML = Number(m.kelembapan).toFixed(1) + '<span class="preview-unit">%</span>';
                        document.getElementById('weather-wind').innerHTML = Number(m.kecepatan_angin).toFixed(1) + '<span class="preview-unit">m/s</span>';
                        document.getElementById('weather-rain').innerHTML = (m.curah_hujan || 0) + '<span class="preview-unit">mm</span>';

                        if (m.curah_hujan > 20) {
                            document.getElementById('weather-badge-text').textContent = 'Hujan Deras';
                            document.getElementById('weather-badge').className = 'verdict-tag verdict-warning';
                            document.getElementById('weather-advice-text').textContent = 'Hujan lebat terdeteksi. Lindungi persemaian dan tunda pemupukan terbuka.';
                        } else if (m.suhu > 35) {
                            document.getElementById('weather-badge-text').textContent = 'Panas Terik';
                            document.getElementById('weather-badge').className = 'verdict-tag verdict-warning';
                            document.getElementById('weather-advice-text').textContent = 'Suhu udara tinggi. Laju penguapan tanaman meningkat tajam.';
                        } else {
                            document.getElementById('weather-badge-text').textContent = 'Cerah & Kondusif';
                            document.getElementById('weather-badge').className = 'verdict-tag verdict-optimal';
                            document.getElementById('weather-advice-text').textContent = 'Mikroklimat stabil, waktu yang baik untuk aktivitas di lahan.';
                        }
                    }
                    document.getElementById('cnt-weather').textContent = data.weather.count;
                    document.getElementById('last-sync-tag').textContent = data.formatted_time + ' WIB';
                }
            } catch (err) {
                console.error('Polling status error:', err);
            }
        }

        setInterval(fetchHubStatus, 6000);

        // Close mobile nav when clicking a link
        document.querySelectorAll('.nav-item').forEach(link => {
            link.addEventListener('click', () => {
                document.querySelector('.nav-links').classList.remove('open');
            });
        });
    </script>
</body>
</html>
