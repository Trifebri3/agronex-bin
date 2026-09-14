<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Monitoring Tanah - EcoSense Hub</title>
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

        /* 8 Sensor Metric Cards */
        .sensor-grid {
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
            .sensor-grid {
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
            .sensor-grid {
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
                min-width: 700px;
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
            .sensor-grid {
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
            <a href="{{ route('soil.dashboard') }}" class="nav-item active">Monitoring Tanah</a>
            <a href="{{ route('water.dashboard') }}" class="nav-item">Kualitas Air</a>
            <a href="{{ route('weather.dashboard') }}" class="nav-item">Stasiun Cuaca</a>
        </div>
    </nav>

    <!-- MAIN CONTAINER -->
    <div class="container">

        <!-- 1. CONTEXTUAL PROBLEM SOLVING BANNER -->
        @php
            $soilAdvice = "Kadar air dan nutrisi tanah dalam batas ideal. Tanaman memiliki suplai hara yang mencukupi untuk fase pertumbuhan.";
            $soilTitle = "Kondisi Lahan Sehat & Subur";
            if ($latest) {
                if ($latest->kelembapan < 35) {
                    $soilTitle = "Tanah Kering — Perlu Pengairan";
                    $soilAdvice = "Kelembapan tanah rendah (" . number_format($latest->kelembapan, 1) . "%). Disarankan mengaktifkan pompa penyiraman atau irigasi tetes.";
                } elseif ($latest->kelembapan > 80) {
                    $soilTitle = "Kadar Air Tinggi — Risiko Genangan";
                    $soilAdvice = "Tanah sangat jenuh air (" . number_format($latest->kelembapan, 1) . "%). Pastikan saluran pembuangan lancar agar akar tidak busuk.";
                } elseif ($latest->ph < 6.0) {
                    $soilTitle = "Tanah Cenderung Asam";
                    $soilAdvice = "Nilai pH (" . number_format($latest->ph, 2) . ") berada di bawah batas netral. Pertimbangkan pemberian kapur pertanian saat pemupukan berikutnya.";
                }
            }
        @endphp

        <div class="context-banner">
            <div class="context-left">
                <h3>Rekomendasi Tindakan Lapangan</h3>
                <h2 id="soil-title">{{ $soilTitle }}</h2>
                <p id="soil-desc">{{ $soilAdvice }}</p>
            </div>
            <div class="action-btns">
                <button class="btn-outline" onclick="openModal()">Panduan Parameter</button>
                <button class="btn" onclick="simulateSoil()">Uji Data Baru</button>
                <button class="btn-outline" onclick="exportCsv()">Ekspor CSV</button>
            </div>
        </div>

        <!-- 2. 8 METRIC CARDS -->
        <div class="sensor-grid">
            <div class="card">
                <div class="card-header-label">
                    <span>Kelembapan Tanah</span>
                    <span style="font-size: 10px; color: var(--text-muted);">MOIST</span>
                </div>
                <div class="card-value">
                    <span id="kelembapan">{{ $latest ? number_format($latest->kelembapan, 1) : '--' }}</span>
                    <span class="card-unit">%</span>
                </div>
                <div class="card-meaning" id="moist-meaning">Kadar Air Optimal</div>
                <div class="card-sub">Rentang Normal: 50% - 75%</div>
            </div>

            <div class="card">
                <div class="card-header-label">
                    <span>Suhu Tanah</span>
                    <span style="font-size: 10px; color: var(--text-muted);">TEMP</span>
                </div>
                <div class="card-value">
                    <span id="suhu">{{ $latest ? number_format($latest->suhu, 1) : '--' }}</span>
                    <span class="card-unit">°C</span>
                </div>
                <div class="card-meaning">Suhu Perakaran Normal</div>
                <div class="card-sub">Rentang Normal: 22°C - 30°C</div>
            </div>

            <div class="card">
                <div class="card-header-label">
                    <span>Keasaman (pH)</span>
                    <span style="font-size: 10px; color: var(--text-muted);">PH</span>
                </div>
                <div class="card-value">
                    <span id="ph">{{ $latest ? number_format($latest->ph, 2) : '--' }}</span>
                    <span class="card-unit">pH</span>
                </div>
                <div class="card-meaning" id="ph-meaning">Reaksi Netral</div>
                <div class="card-sub">Rentang Normal: 6.0 - 7.5</div>
            </div>

            <div class="card">
                <div class="card-header-label">
                    <span>Kepekatan Hara (EC)</span>
                    <span style="font-size: 10px; color: var(--text-muted);">EC</span>
                </div>
                <div class="card-value">
                    <span id="ec">{{ $latest ? number_format($latest->ec, 0) : '--' }}</span>
                    <span class="card-unit">us/cm</span>
                </div>
                <div class="card-meaning">Ketersediaan Mineral Baik</div>
                <div class="card-sub">Rentang Normal: 600 - 1200 us/cm</div>
            </div>

            <div class="card">
                <div class="card-header-label">
                    <span>Nitrogen (N)</span>
                    <span style="font-size: 10px; color: var(--text-muted);">N</span>
                </div>
                <div class="card-value">
                    <span id="nitrogen">{{ $latest ? number_format($latest->nitrogen, 0) : '--' }}</span>
                    <span class="card-unit">mg/kg</span>
                </div>
                <div class="card-meaning">Pertumbuhan Daun</div>
                <div class="card-sub">Unsur Hara Makro Primer</div>
            </div>

            <div class="card">
                <div class="card-header-label">
                    <span>Fosfor (P)</span>
                    <span style="font-size: 10px; color: var(--text-muted);">P</span>
                </div>
                <div class="card-value">
                    <span id="fosfor">{{ $latest ? number_format($latest->fosfor, 0) : '--' }}</span>
                    <span class="card-unit">mg/kg</span>
                </div>
                <div class="card-meaning">Penguatan Akar</div>
                <div class="card-sub">Fase Generatif Tanaman</div>
            </div>

            <div class="card">
                <div class="card-header-label">
                    <span>Kalium (K)</span>
                    <span style="font-size: 10px; color: var(--text-muted);">K</span>
                </div>
                <div class="card-value">
                    <span id="kalium">{{ $latest ? number_format($latest->kalium, 0) : '--' }}</span>
                    <span class="card-unit">mg/kg</span>
                </div>
                <div class="card-meaning">Ketahanan Tanaman</div>
                <div class="card-sub">Kekebalan dari Penyakit</div>
            </div>

            <div class="card">
                <div class="card-header-label">
                    <span>Cadangan NPK Total</span>
                    <span style="font-size: 10px; color: var(--text-muted);">NPK</span>
                </div>
                <div class="card-value">
                    <span id="npk-total">{{ $latest ? ($latest->nitrogen + $latest->fosfor + $latest->kalium) : '--' }}</span>
                    <span class="card-unit">mg/kg</span>
                </div>
                <div class="card-meaning">Indeks Kesuburan Kimia</div>
                <div class="card-sub">Total Unsur N + P + K</div>
            </div>
        </div>

        <!-- 3. TELEMETRY CHART PANEL -->
        <div class="panel">
            <div class="panel-header">
                <div>
                    <h3>Grafik Fluktuasi Parameter Tanah</h3>
                    <span style="font-size: 13px; color: var(--text-muted);">Perubahan kelembapan, suhu, dan pH tanah dari waktu ke waktu</span>
                </div>
                <div class="time-filters">
                    <button class="time-btn active" onclick="filterPoints(20)">20 Titik</button>
                    <button class="time-btn" onclick="filterPoints(10)">10 Titik</button>
                    <button class="time-btn" onclick="filterPoints(5)">5 Titik</button>
                </div>
            </div>
            <div class="chart-box">
                <canvas id="soilChart"></canvas>
            </div>
        </div>

        <!-- 4. LOG DATA TABLE -->
        <div class="panel">
            <div class="panel-header">
                <div>
                    <h3>Catatan Log Data Tanah</h3>
                    <span style="font-size: 13px; color: var(--text-muted);">Daftar telemetri sensor terurut dari yang terbaru</span>
                </div>
                <span style="font-size: 12px; color: var(--green-dark); font-weight: 600;">Sinkronisasi aktif (5 detik)</span>
            </div>
            <div class="table-responsive">
                <table>
                    <thead>
                        <tr>
                            <th>Waktu Rekam</th>
                            <th>Kelembapan</th>
                            <th>Suhu</th>
                            <th>pH</th>
                            <th>EC (Hara)</th>
                            <th>N</th>
                            <th>P</th>
                            <th>K</th>
                            <th>Status Kondisi</th>
                        </tr>
                    </thead>
                    <tbody id="historyTable">
                        @forelse ($history->reverse() as $row)
                            <tr>
                                <td>{{ $row->created_at->format('d/m/Y H:i:s') }}</td>
                                <td>{{ number_format($row->kelembapan, 1) }} %</td>
                                <td>{{ number_format($row->suhu, 1) }} °C</td>
                                <td>{{ number_format($row->ph, 2) }}</td>
                                <td>{{ number_format($row->ec, 0) }} us/cm</td>
                                <td>{{ number_format($row->nitrogen, 0) }}</td>
                                <td>{{ number_format($row->fosfor, 0) }}</td>
                                <td>{{ number_format($row->kalium, 0) }}</td>
                                <td>
                                    @if($row->kelembapan < 35)
                                        <span style="color: var(--amber-dark); font-weight: 700;">Kering</span>
                                    @elseif($row->kelembapan > 80)
                                        <span style="color: var(--text-secondary); font-weight: 700;">Basah</span>
                                    @else
                                        <span style="color: var(--green-dark); font-weight: 700;">Optimal</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" style="text-align: center; color: var(--text-muted);">Belum ada data tanah tercatat</td>
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
            <h3 style="font-size: 18px; font-weight: 800; color: var(--text-primary); margin-bottom: 4px;">Panduan Parameter Tanah</h3>
            <p style="font-size: 13px; color: var(--text-muted); margin-bottom: 18px;">Penjelasan ringkas fungsi masing-masing pembacaan sensor:</p>

            <div class="glossary-item">
                <h5>Kelembapan Tanah (%)</h5>
                <p>Menggambarkan kadar lengas tanah di area perakaran. Rentang optimal 50% - 75%. Jika di bawah 35%, segera lakukan penyiraman. Jika di atas 80%, tunda irigasi.</p>
            </div>

            <div class="glossary-item">
                <h5>pH Tanah (0 - 14)</h5>
                <p>Derajat keasaman media tanam. Sebagian besar komoditas pertanian menyerap hara maksimal pada rentang 6.0 - 7.0. Jika di bawah 5.5, aplikasikan kapur pertanian.</p>
            </div>

            <div class="glossary-item">
                <h5>EC Tanah (us/cm)</h5>
                <p>Konduktivitas listrik menunjukkan kepekatan larutan garam mineral pupuk. Nilai 600 - 1200 us/cm ideal untuk tanaman produktif.</p>
            </div>

            <div class="glossary-item">
                <h5>N-P-K (Nitrogen, Fosfor, Kalium)</h5>
                <p>Tiga unsur hara makro primer. Nitrogen membentuk vegetasi daun hijau, Fosfor memperkokoh perakaran dan anakan, Kalium menjaga kekebalan dari penyakit.</p>
            </div>
        </div>
    </div>

    <script>
        let allHistory = @json($history);
        let activePointLimit = 20;

        function openModal() { document.getElementById('guideModal').classList.add('open'); }
        function closeModal() { document.getElementById('guideModal').classList.remove('open'); }
        function closeModalOnBg(e) { if (e.target.id === 'guideModal') closeModal(); }

        const ctx = document.getElementById('soilChart').getContext('2d');
        const soilChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: [],
                datasets: [
                    {
                        label: 'Kelembapan (%)',
                        data: [],
                        borderColor: '#166534',
                        backgroundColor: 'transparent',
                        borderWidth: 2,
                        tension: 0.1,
                        yAxisID: 'y'
                    },
                    {
                        label: 'Suhu (°C)',
                        data: [],
                        borderColor: '#d97706',
                        backgroundColor: 'transparent',
                        borderWidth: 2,
                        tension: 0.1,
                        yAxisID: 'y'
                    },
                    {
                        label: 'pH Tanah',
                        data: [],
                        borderColor: '#0284c7',
                        backgroundColor: 'transparent',
                        borderWidth: 2,
                        tension: 0.1,
                        yAxisID: 'y1'
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
                    y1: { type: 'linear', position: 'right', min: 0, max: 14, ticks: { color: '#0284c7' }, grid: { drawOnChartArea: false } }
                }
            }
        });

        function renderChart() {
            const slice = allHistory.slice(-activePointLimit);
            soilChart.data.labels = slice.map(i => new Date(i.created_at).toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit' }));
            soilChart.data.datasets[0].data = slice.map(i => i.kelembapan);
            soilChart.data.datasets[1].data = slice.map(i => i.suhu);
            soilChart.data.datasets[2].data = slice.map(i => i.ph);
            soilChart.update();
        }

        function filterPoints(num) {
            activePointLimit = num;
            document.querySelectorAll('.time-btn').forEach(b => b.classList.remove('active'));
            event.target.classList.add('active');
            renderChart();
        }

        async function updateSoilData() {
            try {
                const res = await fetch('{{ route("soil.latest") }}');
                const json = await res.json();
                if (json.success && json.data) {
                    const d = json.data;
                    document.getElementById('kelembapan').textContent = Number(d.kelembapan).toFixed(1);
                    document.getElementById('suhu').textContent = Number(d.suhu).toFixed(1);
                    document.getElementById('ph').textContent = Number(d.ph).toFixed(2);
                    document.getElementById('ec').textContent = Number(d.ec).toFixed(0);
                    document.getElementById('nitrogen').textContent = Number(d.nitrogen).toFixed(0);
                    document.getElementById('fosfor').textContent = Number(d.fosfor).toFixed(0);
                    document.getElementById('kalium').textContent = Number(d.kalium).toFixed(0);
                    document.getElementById('npk-total').textContent = Number(d.nitrogen || 0) + Number(d.fosfor || 0) + Number(d.kalium || 0);

                    if (d.kelembapan < 35) {
                        document.getElementById('soil-title').textContent = 'Tanah Kering — Perlu Pengairan';
                        document.getElementById('soil-desc').textContent = `Kelembapan tanah rendah (${Number(d.kelembapan).toFixed(1)}%). Disarankan mengaktifkan pompa penyiraman.`;
                        document.getElementById('moist-meaning').textContent = 'Perlu Penyiraman';
                        document.getElementById('moist-meaning').style.color = 'var(--amber-dark)';
                    } else if (d.kelembapan > 80) {
                        document.getElementById('soil-title').textContent = 'Kadar Air Tinggi — Risiko Genangan';
                        document.getElementById('soil-desc').textContent = `Tanah sangat basah (${Number(d.kelembapan).toFixed(1)}%). Pastikan saluran drainase lancar.`;
                        document.getElementById('moist-meaning').textContent = 'Terlalu Basah';
                        document.getElementById('moist-meaning').style.color = 'var(--text-secondary)';
                    } else {
                        document.getElementById('soil-title').textContent = 'Kondisi Lahan Sehat & Subur';
                        document.getElementById('soil-desc').textContent = 'Kadar air dan nutrisi tanah dalam batas ideal. Tanaman memiliki suplai hara yang mencukupi.';
                        document.getElementById('moist-meaning').textContent = 'Kadar Air Optimal';
                        document.getElementById('moist-meaning').style.color = 'var(--green-dark)';
                    }
                }
            } catch (e) {
                console.error('Error fetching soil latest:', e);
            }
        }

        async function updateSoilHistory() {
            try {
                const res = await fetch('{{ route("soil.history") }}');
                const json = await res.json();
                if (json.success && json.data) {
                    allHistory = json.data;
                    renderChart();

                    const tbody = document.getElementById('historyTable');
                    tbody.innerHTML = '';
                    allHistory.slice().reverse().forEach(item => {
                        let evalBadge = '<span style="color: var(--green-dark); font-weight: 700;">Optimal</span>';
                        if (item.kelembapan < 35) evalBadge = '<span style="color: var(--amber-dark); font-weight: 700;">Kering</span>';
                        else if (item.kelembapan > 80) evalBadge = '<span style="color: var(--text-secondary); font-weight: 700;">Basah</span>';

                        const tr = document.createElement('tr');
                        tr.innerHTML = `
                            <td>${new Date(item.created_at).toLocaleString('id-ID')}</td>
                            <td>${Number(item.kelembapan).toFixed(1)} %</td>
                            <td>${Number(item.suhu).toFixed(1)} °C</td>
                            <td>${Number(item.ph).toFixed(2)}</td>
                            <td>${Number(item.ec).toFixed(0)} us/cm</td>
                            <td>${Number(item.nitrogen).toFixed(0)}</td>
                            <td>${Number(item.fosfor).toFixed(0)}</td>
                            <td>${Number(item.kalium).toFixed(0)}</td>
                            <td>${evalBadge}</td>
                        `;
                        tbody.appendChild(tr);
                    });
                }
            } catch (e) {
                console.error('Error updating soil history:', e);
            }
        }

        async function simulateSoil() {
            try {
                await fetch('{{ route("hub.simulate") }}?scenario=soil');
                updateSoilData();
                updateSoilHistory();
            } catch (e) {
                console.error('Simulation failed:', e);
            }
        }

        function exportCsv() {
            let csvContent = "data:text/csv;charset=utf-8,Waktu,Kelembapan,Suhu,pH,EC,Nitrogen,Fosfor,Kalium\n";
            allHistory.forEach(r => {
                csvContent += `${r.created_at},${r.kelembapan},${r.suhu},${r.ph},${r.ec},${r.nitrogen},${r.fosfor},${r.kalium}\n`;
            });
            const encodedUri = encodeURI(csvContent);
            const link = document.createElement("a");
            link.setAttribute("href", encodedUri);
            link.setAttribute("download", `log_tanah_${new Date().toISOString().slice(0,10)}.csv`);
            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);
        }

        renderChart();
        setInterval(updateSoilData, 5000);
        setInterval(updateSoilHistory, 5000);
    </script>
</body>
</html>
