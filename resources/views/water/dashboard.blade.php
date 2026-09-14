<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kualitas Air - EcoSense Hub</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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

        /* Top Navigation Switcher */
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

        .nav-status {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 12px;
            color: var(--green-dark);
            background-color: var(--green-light);
            padding: 6px 14px;
            border-radius: 6px;
            border: 1px solid var(--green-border);
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
            margin: auto;
            padding: 28px 24px;
        }

        /* Contextual Advice Banner */
        .context-banner {
            background-color: #ffffff;
            border: 1px solid var(--border);
            border-left: 4px solid var(--green-primary);
            border-radius: 12px;
            padding: 22px 28px;
            margin-bottom: 24px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.04);
        }

        .context-left h3 {
            font-size: 11px;
            text-transform: uppercase;
            letter-spacing: 0.06em;
            color: var(--green-primary);
            font-weight: 700;
            margin-bottom: 4px;
        }

        .context-left h2 {
            font-size: 20px;
            font-weight: 800;
            color: var(--text-primary);
            margin-bottom: 4px;
        }

        .context-left p {
            font-size: 14px;
            color: var(--text-secondary);
            max-width: 760px;
        }

        .action-btns {
            display: flex;
            gap: 8px;
            align-items: center;
        }

        .btn {
            background-color: var(--green-primary);
            color: #ffffff;
            border: 1px solid var(--green-primary);
            padding: 8px 16px;
            border-radius: 6px;
            font-size: 13px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.15s ease;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }

        .btn:hover {
            background-color: var(--green-hover);
            border-color: var(--green-hover);
        }

        .btn-outline {
            background-color: #ffffff;
            border: 1px solid var(--border);
            color: var(--text-primary);
            padding: 8px 16px;
            border-radius: 6px;
            font-size: 13px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.15s ease;
        }

        .btn-outline:hover {
            border-color: var(--green-primary);
            color: var(--green-dark);
            background-color: var(--green-light);
        }

        /* 4 Main Sensor Cards */
        .cards-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 18px;
            margin-bottom: 24px;
        }

        .card {
            background-color: #ffffff;
            border: 1px solid var(--border);
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.04);
            transition: border-color 0.15s ease;
        }

        .card:hover {
            border-color: var(--green-primary);
        }

        .card-header-label {
            color: var(--text-muted);
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            margin-bottom: 8px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .card-value {
            font-size: 28px;
            font-weight: 800;
            color: var(--text-primary);
            display: flex;
            align-items: baseline;
            gap: 4px;
        }

        .card-unit {
            font-size: 13px;
            font-weight: 500;
            color: var(--text-muted);
        }

        .card-meaning {
            font-size: 12px;
            color: var(--green-dark);
            margin-top: 4px;
            font-weight: 600;
        }

        .card-sub {
            font-size: 11px;
            color: var(--text-muted);
            margin-top: 2px;
        }

        /* Panel Chart & Table */
        .panel {
            background-color: #ffffff;
            border: 1px solid var(--border);
            border-radius: 12px;
            padding: 22px;
            margin-bottom: 24px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.04);
        }

        .panel-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 18px;
            flex-wrap: wrap;
            gap: 10px;
        }

        .panel-header h3 {
            font-size: 16px;
            font-weight: 800;
            color: var(--text-primary);
        }

        .time-filters {
            display: flex;
            gap: 4px;
            background-color: #f1f5f9;
            padding: 3px;
            border-radius: 6px;
            border: 1px solid var(--border);
        }

        .time-btn {
            background: transparent;
            border: none;
            color: var(--text-secondary);
            padding: 4px 10px;
            border-radius: 4px;
            font-size: 12px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.15s ease;
        }

        .time-btn.active {
            background-color: var(--green-primary);
            color: #ffffff;
        }

        .chart-box {
            position: relative;
            height: 350px;
            width: 100%;
        }

        /* Table */
        .table-responsive {
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 13px;
        }

        th {
            background-color: #f8fafc;
            color: var(--text-secondary);
            padding: 10px 14px;
            text-align: left;
            font-weight: 700;
            border-bottom: 1px solid var(--border);
            text-transform: uppercase;
            letter-spacing: 0.04em;
            font-size: 11px;
        }

        td {
            padding: 12px 14px;
            border-bottom: 1px solid var(--border);
            color: var(--text-primary);
        }

        tr:hover td {
            background-color: #f8fafc;
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
            max-width: 620px;
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

        .glossary-item {
            border-bottom: 1px solid var(--border);
            padding: 12px 0;
        }

        .glossary-item:last-child {
            border-bottom: none;
        }

        .glossary-item h5 {
            color: var(--green-dark);
            font-size: 14px;
            font-weight: 700;
            margin-bottom: 4px;
        }

        .glossary-item p {
            font-size: 13px;
            color: var(--text-secondary);
            line-height: 1.5;
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
            .cards-grid {
                grid-template-columns: repeat(2, 1fr);
            }
            .context-banner {
                flex-direction: column;
                gap: 14px;
                align-items: flex-start;
            }
            .top-nav {
                padding: 12px 20px;
            }
            .action-btns {
                width: 100%;
                flex-wrap: wrap;
            }
            .action-btns .btn,
            .action-btns .btn-outline {
                flex: 1;
                min-width: 120px;
                text-align: center;
                justify-content: center;
            }
        }

        /* --- MOBILE BREAKPOINT --- */
        @media (max-width: 640px) {
            .top-nav {
                flex-direction: column;
                gap: 10px;
                padding: 12px 16px;
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
            .nav-status {
                display: none;
            }
            .cards-grid {
                grid-template-columns: 1fr 1fr;
                gap: 12px;
            }
            .container {
                padding: 16px 12px;
            }
            .context-banner {
                padding: 18px 16px;
                border-radius: 10px;
            }
            .context-left h2 {
                font-size: 17px;
            }
            .context-left p {
                font-size: 13px;
            }
            .action-btns {
                width: 100%;
                flex-direction: column;
            }
            .action-btns .btn,
            .action-btns .btn-outline {
                width: 100%;
                text-align: center;
                justify-content: center;
            }
            .card {
                padding: 16px;
            }
            .card-value {
                font-size: 22px;
            }
            .chart-box {
                height: 260px;
            }
            .panel {
                padding: 16px;
                border-radius: 10px;
            }
            .panel-header {
                flex-direction: column;
                align-items: flex-start;
            }
            table {
                font-size: 12px;
                min-width: 560px;
            }
            th, td {
                padding: 8px 10px;
            }
            .modal-content {
                padding: 20px 16px;
                max-height: 90vh;
                border-radius: 10px;
            }
        }

        /* --- SMALL MOBILE --- */
        @media (max-width: 380px) {
            .brand-logo {
                height: 28px;
            }
            .cards-grid {
                grid-template-columns: 1fr;
            }
            .card-value {
                font-size: 20px;
            }
            .context-left h2 {
                font-size: 15px;
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
            <a href="{{ route('hub') }}" class="nav-item">Portal Hub</a>
            <a href="{{ route('soil.dashboard') }}" class="nav-item">Monitoring Tanah</a>
            <a href="{{ route('water.dashboard') }}" class="nav-item active">Kualitas Air</a>
            <a href="{{ route('weather.dashboard') }}" class="nav-item">Stasiun Cuaca</a>
        </div>
    </nav>

    <!-- MAIN CONTAINER -->
    <div class="container">

        <!-- 1. CONTEXTUAL PROBLEM SOLVING BANNER -->
        @php
            $waterAdvice = "Kualitas air dalam kondisi prima dan jernih. Aman untuk ekosistem perairan, budidaya ikan, dan kebutuhan air baku.";
            $waterTitle = "Kualitas Air Bersih & Layak";
            if ($latest) {
                if ($latest->turbidity > 25) {
                    $waterTitle = "Kekeruhan Air Meningkat";
                    $waterAdvice = "Tingkat kekeruhan (" . number_format($latest->turbidity, 0) . " NTU) melebihi batas normal. Periksa saringan air atau endapkan partikel lumpur.";
                } elseif ($latest->ph < 6.5 || $latest->ph > 8.5) {
                    $waterTitle = "pH Air di Luar Batas Acuan";
                    $waterAdvice = "Derajat keasaman (" . number_format($latest->ph, 2) . ") tidak seimbang. Tambahkan aerasi atau larutan penetral air.";
                } elseif ($latest->tds > 500) {
                    $waterTitle = "Padatan Terlarut (TDS) Cukup Tinggi";
                    $waterAdvice = "Nilai TDS (" . number_format($latest->tds, 0) . " ppm) cukup pekat. Lakukan sirkulasi pergantian air segar secara berkala.";
                }
            }
        @endphp

        <div class="context-banner">
            <div class="context-left">
                <h3>Rekomendasi Tindakan Lapangan</h3>
                <h2 id="water-title">{{ $waterTitle }}</h2>
                <p id="water-desc">{{ $waterAdvice }}</p>
            </div>
            <div class="action-btns">
                <button class="btn-outline" onclick="openModal()">Panduan Mutu Air</button>
                <button class="btn" onclick="simulateWater()">Uji Data Baru</button>
                <button class="btn-outline" onclick="exportCsv()">Ekspor CSV</button>
            </div>
        </div>

        <!-- 2. 4 METRIC CARDS -->
        <div class="cards-grid">
            <div class="card">
                <div class="card-header-label">
                    <span>Keasaman Air</span>
                    <span style="font-size: 10px; color: var(--text-muted);">PH</span>
                </div>
                <div class="card-value">
                    <span id="val-ph">{{ $latest ? number_format($latest->ph, 2) : '--' }}</span>
                    <span class="card-unit">pH</span>
                </div>
                <div class="card-meaning" id="ph-meaning">Aman & Netral</div>
                <div class="card-sub">Standar Baku Mutu: 6.5 - 8.5</div>
            </div>

            <div class="card">
                <div class="card-header-label">
                    <span>Suhu Air</span>
                    <span style="font-size: 10px; color: var(--text-muted);">TEMP</span>
                </div>
                <div class="card-value">
                    <span id="val-suhu">{{ $latest ? number_format($latest->suhu, 2) : '--' }}</span>
                    <span class="card-unit">°C</span>
                </div>
                <div class="card-meaning">Suhu Sejuk Normal</div>
                <div class="card-sub">Rentang Normal: 24°C - 30°C</div>
            </div>

            <div class="card">
                <div class="card-header-label">
                    <span>Padatan Terlarut (TDS)</span>
                    <span style="font-size: 10px; color: var(--text-muted);">TDS</span>
                </div>
                <div class="card-value">
                    <span id="val-tds">{{ $latest ? number_format($latest->tds, 0) : '--' }}</span>
                    <span class="card-unit">ppm</span>
                </div>
                <div class="card-meaning" id="tds-meaning">Tingkat Kemurnian Baik</div>
                <div class="card-sub">Air Bersih: < 300 ppm</div>
            </div>

            <div class="card">
                <div class="card-header-label">
                    <span>Kekeruhan (Turbidity)</span>
                    <span style="font-size: 10px; color: var(--text-muted);">TURB</span>
                </div>
                <div class="card-value">
                    <span id="val-turbidity">{{ $latest ? number_format($latest->turbidity, 0) : '--' }}</span>
                    <span class="card-unit">NTU</span>
                </div>
                <div class="card-meaning" id="turb-meaning">Jernih Bening</div>
                <div class="card-sub">Jernih: < 5 NTU | Keruh: > 25 NTU</div>
            </div>
        </div>

        <!-- 3. TELEMETRY CHART PANEL -->
        <div class="panel">
            <div class="panel-header">
                <div>
                    <h3>Grafik Fluktuasi Kualitas Air</h3>
                    <span style="font-size: 13px; color: var(--text-muted);">Tren pH, suhu, TDS, dan kekeruhan air secara simultan</span>
                </div>
                <div class="time-filters">
                    <button class="time-btn active" onclick="filterPoints(20)">20 Titik</button>
                    <button class="time-btn" onclick="filterPoints(10)">10 Titik</button>
                    <button class="time-btn" onclick="filterPoints(5)">5 Titik</button>
                </div>
            </div>
            <div class="chart-box">
                <canvas id="waterChart"></canvas>
            </div>
        </div>

        <!-- 4. LOG DATA TABLE -->
        <div class="panel">
            <div class="panel-header">
                <div>
                    <h3>Catatan Log Pengujian Air</h3>
                    <span style="font-size: 13px; color: var(--text-muted);">Daftar data pengujian air terurut dari waktu terbaru</span>
                </div>
                <span style="font-size: 12px; color: var(--green-dark); font-weight: 600;">Sinkronisasi aktif (5 detik)</span>
            </div>
            <div class="table-responsive">
                <table>
                    <thead>
                        <tr>
                            <th>Waktu Rekam</th>
                            <th>pH Air</th>
                            <th>Suhu Air (°C)</th>
                            <th>TDS (ppm)</th>
                            <th>Turbidity (NTU)</th>
                            <th>Status Kondisi</th>
                        </tr>
                    </thead>
                    <tbody id="historyTable">
                        @forelse ($history->reverse() as $row)
                            @php
                                $isAlert = ($row->ph < 6.5 || $row->ph > 8.5 || $row->tds > 500 || $row->turbidity > 25);
                            @endphp
                            <tr>
                                <td>{{ $row->created_at->format('d/m/Y H:i:s') }}</td>
                                <td>{{ number_format($row->ph, 2) }}</td>
                                <td>{{ number_format($row->suhu, 2) }} °C</td>
                                <td>{{ number_format($row->tds, 0) }} ppm</td>
                                <td>{{ number_format($row->turbidity, 0) }} NTU</td>
                                <td>
                                    @if ($isAlert)
                                        <span style="color: var(--amber-dark); font-weight: 700;">Perlu Perhatian</span>
                                    @else
                                        <span style="color: var(--green-dark); font-weight: 700;">Normal Layak</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" style="text-align: center; color: var(--text-muted);">Belum ada data pengujian air</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>

    <!-- GUIDE MODAL -->
    <div id="guideModal" class="modal-overlay" onclick="closeModalOnBg(event)">
        <div class="modal-content">
            <button class="modal-close" onclick="closeModal()">✕</button>
            <h3 style="font-size: 18px; font-weight: 800; color: var(--text-primary); margin-bottom: 4px;">Panduan Parameter Kualitas Air</h3>
            <p style="font-size: 13px; color: var(--text-muted); margin-bottom: 18px;">Penjelasan ringkas parameter fisik dan kimia air baku:</p>

            <div class="glossary-item">
                <h5>Nilai pH Air (Derajat Keasaman)</h5>
                <p>Skala 0 - 14. Netral bernilai 7.0. Budidaya air tawar dan hidroponik memerlukan rentang 6.8 - 7.6. Jika di bawah 6.0, air menjadi asam dan berisiko pada biota air.</p>
            </div>

            <div class="glossary-item">
                <h5>TDS (Total Dissolved Solids • ppm)</h5>
                <p>Kandungan zat padat mineral yang terlarut dalam air. Nilai 150 - 350 ppm sangat baik untuk perikanan tawar dan hidroponik awal.</p>
            </div>

            <div class="glossary-item">
                <h5>Turbidity (Kekeruhan • NTU)</h5>
                <p>Ukuran kejernihan air terhadap hamburan partikel lumpur/alga. Di bawah 5 NTU tergolong sangat jernih; di atas 25 NTU air mulai keruh dan perlu pengendapan.</p>
            </div>

            <div class="glossary-item">
                <h5>Suhu Air (°C)</h5>
                <p>Suhu mempengaruhi metabolisme dan kadar oksigen terlarut dalam air. Suhu ideal perairan kolam berkisar antara 25°C hingga 30°C.</p>
            </div>
        </div>
    </div>

    <script>
        let allHistory = @json($history);
        let activePointLimit = 20;

        function openModal() { document.getElementById('guideModal').classList.add('open'); }
        function closeModal() { document.getElementById('guideModal').classList.remove('open'); }
        function closeModalOnBg(e) { if (e.target.id === 'guideModal') closeModal(); }

        const ctx = document.getElementById('waterChart').getContext('2d');
        const waterChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: [],
                datasets: [
                    {
                        label: 'pH Air',
                        data: [],
                        borderColor: '#0284c7',
                        backgroundColor: 'transparent',
                        borderWidth: 2,
                        tension: 0.1,
                        yAxisID: 'y'
                    },
                    {
                        label: 'Suhu (°C)',
                        data: [],
                        borderColor: '#166534',
                        backgroundColor: 'transparent',
                        borderWidth: 2,
                        tension: 0.1,
                        yAxisID: 'y'
                    },
                    {
                        label: 'TDS (ppm)',
                        data: [],
                        borderColor: '#475569',
                        backgroundColor: 'transparent',
                        borderWidth: 2,
                        tension: 0.1,
                        yAxisID: 'y1'
                    },
                    {
                        label: 'Turbidity (NTU)',
                        data: [],
                        borderColor: '#d97706',
                        backgroundColor: 'transparent',
                        borderWidth: 2,
                        tension: 0.1,
                        yAxisID: 'y'
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                interaction: { mode: 'index', intersect: false },
                plugins: {
                    legend: { labels: { color: '#334155', font: { family: 'Plus Jakarta Sans', size: 12 } } }
                },
                scales: {
                    x: { ticks: { color: '#64748b' }, grid: { color: '#f1f5f9' } },
                    y: { type: 'linear', position: 'left', ticks: { color: '#64748b' }, grid: { color: '#f1f5f9' } },
                    y1: { type: 'linear', position: 'right', ticks: { color: '#475569' }, grid: { drawOnChartArea: false } }
                }
            }
        });

        function renderChart() {
            const slice = allHistory.slice(-activePointLimit);
            waterChart.data.labels = slice.map(i => new Date(i.created_at).toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit' }));
            waterChart.data.datasets[0].data = slice.map(i => i.ph);
            waterChart.data.datasets[1].data = slice.map(i => i.suhu);
            waterChart.data.datasets[2].data = slice.map(i => i.tds);
            waterChart.data.datasets[3].data = slice.map(i => i.turbidity);
            waterChart.update();
        }

        function filterPoints(num) {
            activePointLimit = num;
            document.querySelectorAll('.time-btn').forEach(b => b.classList.remove('active'));
            event.target.classList.add('active');
            renderChart();
        }

        async function updateWaterData() {
            try {
                const res = await fetch('{{ route("water.latest") }}');
                const json = await res.json();
                if (json.success && json.data) {
                    const d = json.data;
                    document.getElementById('val-ph').textContent = Number(d.ph).toFixed(2);
                    document.getElementById('val-suhu').textContent = Number(d.suhu).toFixed(2);
                    document.getElementById('val-tds').textContent = Number(d.tds).toFixed(0);
                    document.getElementById('val-turbidity').textContent = Number(d.turbidity).toFixed(0);

                    if (d.turbidity > 25) {
                        document.getElementById('water-title').textContent = 'Kekeruhan Air Meningkat';
                        document.getElementById('water-desc').textContent = `Tingkat kekeruhan (${Number(d.turbidity).toFixed(0)} NTU) melebihi batas ideal. Periksa saringan air atau filter kolam.`;
                        document.getElementById('turb-meaning').textContent = 'Air Mulai Keruh';
                        document.getElementById('turb-meaning').style.color = 'var(--amber-dark)';
                    } else if (d.ph < 6.5 || d.ph > 8.5) {
                        document.getElementById('water-title').textContent = 'pH Air di Luar Batas Acuan';
                        document.getElementById('water-desc').textContent = `Derajat keasaman (${Number(d.ph).toFixed(2)}) tidak seimbang. Tambahkan larutan penstabil air.`;
                        document.getElementById('ph-meaning').textContent = 'pH Tidak Stabil';
                        document.getElementById('ph-meaning').style.color = 'var(--amber-dark)';
                    } else {
                        document.getElementById('water-title').textContent = 'Kualitas Air Bersih & Layak';
                        document.getElementById('water-desc').textContent = 'Kualitas air dalam kondisi prima dan jernih. Aman untuk ekosistem perairan.';
                        document.getElementById('turb-meaning').textContent = 'Jernih Bening';
                        document.getElementById('turb-meaning').style.color = 'var(--green-dark)';
                        document.getElementById('ph-meaning').textContent = 'Aman & Netral';
                        document.getElementById('ph-meaning').style.color = 'var(--green-dark)';
                    }
                }
            } catch (e) {
                console.error('Error fetching water latest:', e);
            }
        }

        async function updateWaterHistory() {
            try {
                const res = await fetch('{{ route("water.history") }}');
                const json = await res.json();
                if (json.success && json.data) {
                    allHistory = json.data;
                    renderChart();

                    const tbody = document.getElementById('historyTable');
                    tbody.innerHTML = '';
                    allHistory.slice().reverse().forEach(item => {
                        const isAlert = (item.ph < 6.5 || item.ph > 8.5 || item.tds > 500 || item.turbidity > 25);
                        const tr = document.createElement('tr');
                        tr.innerHTML = `
                            <td>${new Date(item.created_at).toLocaleString('id-ID')}</td>
                            <td>${Number(item.ph).toFixed(2)}</td>
                            <td>${Number(item.suhu).toFixed(2)} °C</td>
                            <td>${Number(item.tds).toFixed(0)} ppm</td>
                            <td>${Number(item.turbidity).toFixed(0)} NTU</td>
                            <td>${isAlert ? '<span style="color: var(--amber-dark); font-weight: 700;">Perlu Perhatian</span>' : '<span style="color: var(--green-dark); font-weight: 700;">Normal Layak</span>'}</td>
                        `;
                        tbody.appendChild(tr);
                    });
                }
            } catch (e) {
                console.error('Error updating water history:', e);
            }
        }

        async function simulateWater() {
            try {
                await fetch('{{ route("hub.simulate") }}?scenario=water');
                updateWaterData();
                updateWaterHistory();
            } catch (e) {
                console.error('Simulation failed:', e);
            }
        }

        function exportCsv() {
            let csvContent = "data:text/csv;charset=utf-8,Waktu,pH,Suhu,TDS,Turbidity\n";
            allHistory.forEach(r => {
                csvContent += `${r.created_at},${r.ph},${r.suhu},${r.tds},${r.turbidity}\n`;
            });
            const encodedUri = encodeURI(csvContent);
            const link = document.createElement("a");
            link.setAttribute("href", encodedUri);
            link.setAttribute("download", `log_air_${new Date().toISOString().slice(0,10)}.csv`);
            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);
        }

        renderChart();
        setInterval(updateWaterData, 5000);
        setInterval(updateWaterHistory, 5000);
    </script>
</body>
</html>
