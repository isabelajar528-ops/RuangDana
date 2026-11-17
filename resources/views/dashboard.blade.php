<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <meta name="theme-color" content="#f5f7f4">
    <title>RuangDana — Keuangan pribadi</title>
    <link rel="manifest" href="/manifest.json">
<meta name="theme-color" content="#059669">
<link rel="apple-touch-icon" href="/icon-192.png">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=Manrope:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        :root {
            color-scheme: light;
            --ink: #26342c;
            --muted: #77847b;
            --line: #e7ebe7;
            --canvas: #f7f8f6;
            --green: #557b63;
            --green-dark: #344b3b;
            --serif: 'Manrope', 'DM Sans', sans-serif;
            --sans: 'DM Sans', sans-serif;
        }

        * { box-sizing: border-box; }
        html { scroll-behavior: smooth; }
        body {
            margin: 0;
            background: var(--canvas);
            color: var(--ink);
            font-family: var(--sans);
            font-size: 14px;
            -webkit-font-smoothing: antialiased;
        }
        a { color: inherit; text-decoration: none; }
        button, input, select { font: inherit; }
        button, a, input, select { -webkit-tap-highlight-color: transparent; }
        button:focus-visible, a:focus-visible, input:focus-visible, select:focus-visible {
            outline: 3px solid rgba(44, 153, 101, .26);
            outline-offset: 2px;
        }

        .app-shell { min-height: 100vh; }
        .sidebar {
            position: fixed;
            inset: 0 auto 0 0;
            z-index: 5;
            display: flex;
            width: 224px;
            flex-direction: column;
            padding: 25px 16px;
            border-right: 1px solid var(--line);
            background: #fff;
            color: var(--ink);
        }
        .brand { display: flex; align-items: center; gap: 10px; padding: 0 9px; }
        .brand-mark {
            display: grid;
            width: 39px;
            height: 39px;
            place-items: center;
            border: 1px solid #e4ebe4;
            border-radius: 11px;
            background: #eaf0eb;
            color: var(--green-dark);
            font-family: var(--serif);
            font-size: 18px;
            font-weight: 800;
        }
        .brand-name { font-family: var(--serif); font-size: 15px; font-weight: 800; letter-spacing: -.5px; }
        .side-nav { display: grid; gap: 5px; margin-top: 39px; }
        .nav-link {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 11px 12px;
            border-radius: 10px;
            color: #758178;
            font-size: 12px;
            font-weight: 600;
            transition: background .2s ease, color .2s ease;
        }
        .nav-link:hover, .nav-link.active { background: #eef3ef; color: #3d6348; }
        .nav-icon { display: grid; width: 18px; place-items: center; }
        .mobile-bar { display: none; }
        .mobile-nav-icon { font-size: 17px; line-height: 1; }

        .main-content { max-width: 1600px; min-height: 100vh; margin-left: 224px; padding: 31px 42px 38px; }
        .page-head { display: flex; align-items: center; justify-content: space-between; gap: 20px; margin-bottom: 22px; }
        h1, h2, h3, h4, p { margin-top: 0; }
        .page-head h1 { margin: 0; font-family: var(--serif); font-size: clamp(21px, 2vw, 25px); font-weight: 750; letter-spacing: -.8px; line-height: 1.25; }
        .date-chip {
            display: inline-flex;
            align-items: center;
            gap: 9px;
            flex: 0 0 auto;
            margin-top: 0;
            padding: 8px 11px;
            border: 1px solid var(--line);
            border-radius: 9px;
            background: #fff;
            color: #758178;
            font-size: 12px;
            font-weight: 600;
        }
        .date-dot { width: 7px; height: 7px; border-radius: 50%; background: #8ca993; }

        .alert { display: flex; align-items: flex-start; gap: 10px; margin-bottom: 17px; padding: 13px 15px; border: 1px solid; border-radius: 12px; font-size: 13px; }
        .alert-success { border-color: #cde8d7; background: #eff9f2; color: #246842; }
        .alert-error { border-color: #f1d0d0; background: #fff4f3; color: #a44747; }
        .alert ul { margin: 0; padding-left: 17px; }
        .alert li + li { margin-top: 3px; }

        .balance-card {
            position: relative;
            display: flex;
            min-height: 164px;
            align-items: center;
            justify-content: space-between;
            gap: 30px;
            overflow: hidden;
            padding: 25px 28px;
            border: 1px solid #e1e9e2;
            border-radius: 15px;
            background: #eaf0eb;
            color: var(--ink);
            box-shadow: none;
        }
        .balance-copy, .balance-actions { position: relative; z-index: 1; }
        .balance-label { display: flex; align-items: center; gap: 8px; margin-bottom: 10px; color: #65756a; font-size: 12px; font-weight: 600; }
        .balance-label-mark { display: grid; width: 22px; height: 22px; place-items: center; border: 1px solid #d5e0d7; border-radius: 7px; font-size: 12px; }
        .balance-amount { margin: 0; color: #344f3c; font-family: var(--serif); font-size: clamp(29px, 3.5vw, 38px); font-weight: 800; letter-spacing: -1.5px; line-height: 1.1; }
        .balance-actions { display: flex; flex-wrap: wrap; justify-content: flex-end; gap: 9px; }
        .button { display: inline-flex; min-height: 42px; align-items: center; justify-content: center; gap: 8px; padding: 0 15px; border: 0; border-radius: 10px; cursor: pointer; font-size: 12px; font-weight: 700; transition: transform .18s ease, background .18s ease, box-shadow .18s ease; }
        .button:hover { transform: translateY(-1px); }
        .button-light { background: #fff; color: #45684f; box-shadow: none; }
        .button-light:hover { background: #f7faf7; }
        .button-outline { border: 1px solid #d2ded4; background: transparent; color: #45684f; }
        .button-outline:hover { background: rgba(255,255,255,.65); }
        .button-primary { background: #557b63; color: #fff; }
        .button-primary:hover { background: #476d55; box-shadow: 0 4px 10px rgba(61,98,72,.12); }
        .button-dark { width: 100%; background: #557b63; color: #fff; }
        .button-dark:hover { background: #476d55; }

        .metric-grid { display: grid; grid-template-columns: repeat(3, minmax(0, 1fr)); gap: 15px; margin: 17px 0 29px; }
        .metric-card { display: flex; min-height: 103px; align-items: center; gap: 14px; padding: 19px 20px; border: 1px solid var(--line); border-radius: 15px; background: #fff; }
        .metric-icon { display: grid; width: 42px; height: 42px; flex: 0 0 auto; place-items: center; border-radius: 13px; font-size: 16px; font-weight: 700; }
        .metric-icon.income { background: #edf3ee; color: #557b63; }
        .metric-icon.expense { background: #f7efed; color: #ad716c; }
        .metric-icon.goals { background: #f0f1ed; color: #788375; }
        .metric-label { margin-bottom: 5px; color: #829087; font-size: 11px; font-weight: 600; }
        .metric-value { margin: 0; font-family: var(--serif); font-size: clamp(15px, 1.7vw, 19px); font-weight: 800; letter-spacing: -.55px; white-space: nowrap; }
        .metric-value.income { color: #557b63; }
        .metric-value.expense { color: #ad716c; }

        .section-card { border: 1px solid var(--line); border-radius: 17px; background: #fff; box-shadow: 0 3px 12px rgba(28,47,35,.025); }
        .section-heading { display: flex; align-items: center; justify-content: space-between; gap: 15px; padding: 21px 22px 15px; }
        .section-title { margin: 0; font-family: var(--serif); font-size: 15px; font-weight: 800; letter-spacing: -.35px; }

        .goals-section { margin-bottom: 20px; }
        .goal-grid { display: grid; grid-template-columns: repeat(2, minmax(0, 1fr)); gap: 12px; padding: 0 22px 22px; }
        .goal-card { padding: 16px; border: 1px solid #edf0ed; border-radius: 13px; background: #fbfcfa; }
        .goal-top { display: flex; align-items: flex-start; justify-content: space-between; gap: 10px; }
        .goal-name { overflow-wrap: anywhere; margin: 0 0 5px; font-size: 13px; font-weight: 700; }
        .goal-date { color: #8d9991; font-size: 10px; }
        .goal-badge { flex: 0 0 auto; padding: 5px 8px; border-radius: 7px; background: #edf3ee; color: #557b63; font-size: 10px; font-weight: 800; }
        .progress-track { height: 7px; overflow: hidden; margin: 15px 0 10px; border-radius: 20px; background: #e9eee9; }
        .progress-fill { width: 0; height: 100%; border-radius: inherit; background: #72957a; transition: width .5s ease; }
        .goal-bottom { display: flex; align-items: center; justify-content: space-between; gap: 10px; }
        .goal-amount { margin: 0; color: #68766d; font-size: 10px; font-weight: 600; }
        .delete-button { padding: 4px 0 4px 8px; border: 0; background: none; color: #a3ada6; cursor: pointer; font-size: 10px; font-weight: 600; transition: color .18s ease; }
        .delete-button:hover { color: #bd5353; }
        .empty-state { margin: 0 22px 21px; padding: 25px 20px; border: 1px dashed #dce5dc; border-radius: 12px; background: #fbfcfa; color: #87948b; font-size: 12px; text-align: center; }

        .content-grid { display: grid; grid-template-columns: minmax(0, 1.25fr) minmax(285px, .75fr); align-items: start; gap: 20px; }
        .content-grid.goals-page { grid-template-columns: minmax(0, 1fr); }
        .transaction-card { min-width: 0; overflow: hidden; }
        .table-wrap { overflow-x: auto; padding: 0 18px 15px; }
        .transaction-table { width: 100%; border-collapse: collapse; text-align: left; }
        .transaction-table th { padding: 11px 9px; border-bottom: 1px solid #edf0ed; color: #929d95; font-size: 9px; font-weight: 700; letter-spacing: .65px; text-transform: uppercase; white-space: nowrap; }
        .transaction-table td { padding: 13px 9px; border-bottom: 1px solid #f0f2f0; font-size: 11px; vertical-align: middle; }
        .transaction-table tbody tr:last-child td { border-bottom: 0; }
        .transaction-table tbody tr:hover { background: #fbfcfa; }
        .transaction-table .date-cell { color: #839087; white-space: nowrap; }
        .category-name { color: #28372e; font-size: 11px; font-weight: 700; }
        .category-note { max-width: 180px; overflow: hidden; margin-top: 3px; color: #9aa49d; font-size: 10px; text-overflow: ellipsis; white-space: nowrap; }
        .goal-tag { display: inline-block; max-width: 130px; overflow: hidden; padding: 5px 7px; border-radius: 6px; background: #f0f3f0; color: #657269; font-size: 9px; text-overflow: ellipsis; white-space: nowrap; }
        .amount-cell { font-size: 11px; font-weight: 800; text-align: right; white-space: nowrap; }
        .amount-cell.income { color: #278151; }
        .amount-cell.expense { color: #bd5a58; }
        .action-cell { text-align: right; }
        .action-cell form { display: inline; }

        .form-stack { display: grid; gap: 16px; }
        .form-card { padding: 21px; }
        .form-heading { display: flex; align-items: flex-start; gap: 11px; margin-bottom: 17px; }
        .form-mark { display: grid; width: 36px; height: 36px; flex: 0 0 auto; place-items: center; border-radius: 11px; background: #edf3ee; color: #557b63; font-size: 17px; font-weight: 600; }
        .form-mark.target { background: #f0f1ed; color: #788375; }
        .form-title { margin: 2px 0 4px; font-family: var(--serif); font-size: 13px; font-weight: 800; }
        .form-fields { display: grid; gap: 12px; }
        .field { display: grid; gap: 6px; }
        .field label { color: #627067; font-size: 10px; font-weight: 700; }
        .field input, .field select {
            width: 100%;
            min-height: 39px;
            padding: 9px 11px;
            border: 1px solid #e3e9e3;
            border-radius: 9px;
            background: #fff;
            color: #27362d;
            font-size: 11px;
            transition: border-color .18s ease, box-shadow .18s ease;
        }
        .field input::placeholder { color: #a5aea8; }
        .field input:focus, .field select:focus { border-color: #6bb58a; outline: 0; box-shadow: 0 0 0 3px rgba(50,145,88,.1); }
        .form-card .button { min-height: 40px; margin-top: 15px; }

        @media (max-width: 1190px) {
            .main-content { padding-right: 30px; padding-left: 30px; }
            .sidebar { width: 210px; }
            .main-content { margin-left: 210px; }
            .content-grid { grid-template-columns: minmax(0, 1.1fr) minmax(265px, .9fr); gap: 15px; }
            .form-card { padding: 17px; }
        }
        @media (max-width: 930px) {
            .sidebar { display: none; }
            .main-content { margin-left: 0; padding: 20px 24px 100px; }
            .mobile-bar {
                position: fixed;
                inset: auto 0 0;
                z-index: 20;
                display: block;
                margin: 0;
                padding: 8px 12px calc(8px + env(safe-area-inset-bottom));
                border-top: 1px solid var(--line);
                background: rgba(255,255,255,.97);
                box-shadow: 0 -5px 18px rgba(38,52,44,.05);
            }
            .mobile-brand { display: none; }
            .mobile-nav { display: grid; grid-template-columns: repeat(3, minmax(0, 1fr)); gap: 7px; }
            .mobile-nav a {
                display: flex;
                min-height: 52px;
                flex-direction: column;
                align-items: center;
                justify-content: center;
                gap: 5px;
                border-radius: 11px;
                color: #758178;
                font-size: 10px;
                font-weight: 700;
                text-align: center;
            }
            .mobile-nav a:hover, .mobile-nav a.active { background: #eef3ef; color: #45684f; }
        }
        @media (max-width: 680px) {
            .main-content { padding: 16px 16px 28px; }
            .main-content { padding-bottom: calc(90px + env(safe-area-inset-bottom)); }
            .page-head { align-items: center; margin-bottom: 17px; }
            .page-head h1 { max-width: 320px; font-size: 21px; }
            .date-chip { gap: 6px; padding: 8px 9px; font-size: 10px; }
            .balance-card { min-height: 0; align-items: flex-start; flex-direction: column; gap: 17px; padding: 20px 18px; border-radius: 14px; }
            .balance-actions { justify-content: flex-start; }
            .metric-grid { grid-template-columns: 1fr; gap: 9px; margin: 12px 0 22px; }
            .metric-card { min-height: 73px; padding: 12px 15px; }
            .metric-icon { width: 38px; height: 38px; border-radius: 11px; }
            .metric-value { font-size: 16px; }
            .goal-grid { grid-template-columns: 1fr; padding: 0 15px 16px; }
            .section-heading { padding: 18px 16px 13px; }
            .content-grid { grid-template-columns: 1fr; gap: 15px; }
            .transaction-table { min-width: 590px; }
            .table-wrap { padding-right: 10px; padding-left: 10px; }
            .form-stack { grid-row: 1; }
        }
        @media (prefers-reduced-motion: reduce) {
            *, *::before, *::after { scroll-behavior: auto !important; transition-duration: .01ms !important; }
        }
    </style>
</head>
<body>
    <div class="app-shell">
        <aside class="sidebar" aria-label="Navigasi utama">
            <a class="brand" href="{{ route('dashboard', ['tab' => 'overview']) }}" aria-label="RuangDana, ke ringkasan">
                <span class="brand-mark">R</span>
                <span class="brand-name">RuangDana</span>
            </a>

            <nav class="side-nav">
                <a class="nav-link {{ $activeTab === 'overview' ? 'active' : '' }}" href="{{ route('dashboard', ['tab' => 'overview']) }}" @if($activeTab === 'overview') aria-current="page" @endif>
                    <span class="nav-icon" aria-hidden="true">⌂</span>
                    <span>Ringkasan</span>
                </a>
                <a class="nav-link {{ $activeTab === 'goals' ? 'active' : '' }}" href="{{ route('dashboard', ['tab' => 'goals']) }}" @if($activeTab === 'goals') aria-current="page" @endif>
                    <span class="nav-icon" aria-hidden="true">◎</span>
                    <span>Target tabungan</span>
                </a>
                <a class="nav-link {{ $activeTab === 'transactions' ? 'active' : '' }}" href="{{ route('dashboard', ['tab' => 'transactions']) }}" @if($activeTab === 'transactions') aria-current="page" @endif>
                    <span class="nav-icon" aria-hidden="true">↗</span>
                    <span>Transaksi</span>
                </a>
            </nav>

        </aside>

        <main class="main-content">
            <div class="mobile-bar">
                <nav class="mobile-nav" aria-label="Navigasi halaman">
                    <a class="{{ $activeTab === 'overview' ? 'active' : '' }}" href="{{ route('dashboard', ['tab' => 'overview']) }}" @if($activeTab === 'overview') aria-current="page" @endif>
                        <span class="mobile-nav-icon" aria-hidden="true">⌂</span>
                        <span>Ringkasan</span>
                    </a>
                    <a class="{{ $activeTab === 'transactions' ? 'active' : '' }}" href="{{ route('dashboard', ['tab' => 'transactions']) }}" @if($activeTab === 'transactions') aria-current="page" @endif>
                        <span class="mobile-nav-icon" aria-hidden="true">↗</span>
                        <span>Transaksi</span>
                    </a>
                    <a class="{{ $activeTab === 'goals' ? 'active' : '' }}" href="{{ route('dashboard', ['tab' => 'goals']) }}" @if($activeTab === 'goals') aria-current="page" @endif>
                        <span class="mobile-nav-icon" aria-hidden="true">◎</span>
                        <span>Target</span>
                    </a>
                </nav>
            </div>

            <header class="page-head">
                <div>
                    <h1>{{ $pageTitle }}</h1>
                </div>
                <div class="date-chip">
                    <span class="date-dot" aria-hidden="true"></span>
                    {{ now()->format('d M Y') }}
                </div>
            </header>

            @if(session('success'))
                <div class="alert alert-success" role="status">
                    <span aria-hidden="true">✓</span>
                    <span>{{ session('success') }}</span>
                </div>
            @endif

            @if($errors->any())
                <div class="alert alert-error" role="alert">
                    <span aria-hidden="true">!</span>
                    <ul>
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @if($activeTab === 'overview')
            <section class="balance-card" aria-label="Saldo bersih">
                <div class="balance-copy">
                    <div class="balance-label">
                        <span class="balance-label-mark" aria-hidden="true">Rp</span>
                        <span>Total saldo bersih</span>
                    </div>
                    <p class="balance-amount">Rp {{ number_format($balance, 0, ',', '.') }}</p>
                </div>
                <div class="balance-actions">
                    <a class="button button-light" href="{{ route('dashboard', ['tab' => 'transactions']) }}">
                        <span aria-hidden="true">＋</span> Catat transaksi
                    </a>
                    <a class="button button-outline" href="{{ route('dashboard', ['tab' => 'goals']) }}">
                        <span aria-hidden="true">◎</span> Lihat target
                    </a>
                </div>
            </section>

            <section class="metric-grid" aria-label="Ringkasan keuangan">
                <article class="metric-card">
                    <div class="metric-icon income" aria-hidden="true">↙</div>
                    <div>
                        <p class="metric-label">Total pemasukan</p>
                        <p class="metric-value income">Rp {{ number_format($totalIncome, 0, ',', '.') }}</p>
                    </div>
                </article>
                <article class="metric-card">
                    <div class="metric-icon expense" aria-hidden="true">↗</div>
                    <div>
                        <p class="metric-label">Total pengeluaran</p>
                        <p class="metric-value expense">Rp {{ number_format($totalExpense, 0, ',', '.') }}</p>
                    </div>
                </article>
                <article class="metric-card">
                    <div class="metric-icon goals" aria-hidden="true">◎</div>
                    <div>
                        <p class="metric-label">Target aktif</p>
                        <p class="metric-value">{{ $goalCount }} <span style="font-family:var(--sans);font-size:11px;font-weight:600;letter-spacing:0;color:#829087">tujuan</span></p>
                    </div>
                </article>
            </section>
            @endif

            @if($activeTab === 'goals')
            <section class="section-card goals-section" id="goals">
                <div class="section-heading">
                    <div>
                        <h2 class="section-title">Target tabungan</h2>
                    </div>
                </div>

                @if($goals->isEmpty())
                    <p class="empty-state">Belum ada target tabungan.</p>
                @else
                    <div class="goal-grid">
                        @foreach($goals as $goal)
                            <article class="goal-card">
                                <div class="goal-top">
                                    <div>
                                        <h3 class="goal-name">{{ $goal->title }}</h3>
                                        @if($goal->target_date)
                                            <span class="goal-date">Target {{ \Carbon\Carbon::parse($goal->target_date)->format('d M Y') }}</span>
                                        @endif
                                    </div>
                                    <span class="goal-badge">{{ $goal->progress_percentage }}%</span>
                                </div>
                                <div class="progress-track" role="progressbar" aria-label="Progres {{ $goal->title }}" aria-valuenow="{{ $goal->progress_percentage }}" aria-valuemin="0" aria-valuemax="100">
                                    <div class="progress-fill" data-progress="{{ $goal->progress_percentage }}"></div>
                                </div>
                                <div class="goal-bottom">
                                    <p class="goal-amount">Rp {{ number_format($goal->current_amount, 0, ',', '.') }} <span style="color:#b0b9b2">/ Rp {{ number_format($goal->target_amount, 0, ',', '.') }}</span></p>
                                    <form action="{{ route('goals.destroy', ['goal' => $goal, 'tab' => 'goals']) }}" method="POST" onsubmit="return confirm('Hapus target tabungan ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="delete-button">Hapus</button>
                                    </form>
                                </div>
                            </article>
                        @endforeach
                    </div>
                @endif
            </section>
            @endif

            @if($activeTab !== 'overview')
            <div class="content-grid {{ $activeTab === 'goals' ? 'goals-page' : '' }}">
                @if($activeTab === 'transactions')
                <section class="section-card transaction-card" id="transactions">
                    <div class="section-heading">
                        <div>
                            <h2 class="section-title">Riwayat transaksi</h2>
                        </div>
                    </div>
                    @if($transactions->isEmpty())
                        <p class="empty-state">Belum ada transaksi.</p>
                    @else
                        <div class="table-wrap">
                            <table class="transaction-table">
                                <thead>
                                    <tr>
                                        <th scope="col">Tanggal</th>
                                        <th scope="col">Kategori</th>
                                        <th scope="col">Pos target</th>
                                        <th scope="col" style="text-align:right">Nominal</th>
                                        <th scope="col" style="text-align:right">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($transactions as $trx)
                                        <tr>
                                            <td class="date-cell">{{ \Carbon\Carbon::parse($trx->transaction_date)->format('d M Y') }}</td>
                                            <td>
                                                <div class="category-name">{{ $trx->category }}</div>
                                                @if($trx->description)
                                                    <div class="category-note">{{ $trx->description }}</div>
                                                @endif
                                            </td>
                                            <td>
                                                @if($trx->savingsGoal)
                                                    <span class="goal-tag">{{ $trx->savingsGoal->title }}</span>
                                                @else
                                                    <span style="color:#b6beb8">—</span>
                                                @endif
                                            </td>
                                            <td class="amount-cell {{ $trx->type === 'income' ? 'income' : 'expense' }}">
                                                {{ $trx->type === 'income' ? '+' : '−' }} Rp {{ number_format($trx->amount, 0, ',', '.') }}
                                            </td>
                                            <td class="action-cell">
                                                <form action="{{ route('transactions.destroy', ['transaction' => $trx, 'tab' => 'transactions']) }}" method="POST" onsubmit="return confirm('Hapus transaksi ini?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="delete-button">Hapus</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </section>
                @endif

                <div class="form-stack">
                    @if($activeTab === 'transactions')
                    <section class="section-card form-card" id="transaction-form">
                        <div class="form-heading">
                            <span class="form-mark" aria-hidden="true">↕</span>
                            <div>
                                <h2 class="form-title">Catat transaksi</h2>
                            </div>
                        </div>
                        <form action="{{ route('transactions.store', ['tab' => 'transactions']) }}" method="POST">
                            @csrf
                            <div class="form-fields">
                                <div class="field">
                                    <label for="transaction-type">Jenis transaksi</label>
                                    <select id="transaction-type" name="type">
                                        <option value="income" @selected(old('type') === 'income')>Pemasukan / Nabung</option>
                                        <option value="expense" @selected(old('type') === 'expense')>Pengeluaran / Tarik</option>
                                    </select>
                                </div>
                                <div class="field">
                                    <label for="transaction-amount">Nominal (Rp)</label>
                                    <input id="transaction-amount" type="number" name="amount" required min="1" value="{{ old('amount') }}" placeholder="Contoh: 50000">
                                </div>
                                <div class="field">
                                    <label for="transaction-category">Kategori</label>
                                    <input id="transaction-category" type="text" name="category" required maxlength="100" value="{{ old('category') }}" placeholder="Gaji, belanja, makan...">
                                </div>
                                <div class="field">
                                    <label for="transaction-goal">Alokasi target tabungan</label>
                                    <select id="transaction-goal" name="savings_goal_id">
                                        <option value="">Umum / tanpa target</option>
                                        @foreach($goals as $goal)
                                            <option value="{{ $goal->id }}" @selected((string) old('savings_goal_id') === (string) $goal->id)>{{ $goal->title }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="field">
                                    <label for="transaction-date">Tanggal</label>
                                    <input id="transaction-date" type="date" name="transaction_date" value="{{ old('transaction_date', date('Y-m-d')) }}" required>
                                </div>
                                <div class="field">
                                    <label for="transaction-description">Catatan <span style="font-weight:500;color:#9aa49d">(opsional)</span></label>
                                    <input id="transaction-description" type="text" name="description" maxlength="255" value="{{ old('description') }}" placeholder="Keterangan singkat...">
                                </div>
                            </div>
                            <button type="submit" class="button button-primary" style="width:100%">Simpan transaksi</button>
                        </form>
                    </section>
                    @endif

                    @if($activeTab === 'goals')
                    <section class="section-card form-card" id="goal-form">
                        <div class="form-heading">
                            <span class="form-mark target" aria-hidden="true">◎</span>
                            <div>
                                <h2 class="form-title">Buat target baru</h2>
                            </div>
                        </div>
                        <form action="{{ route('goals.store', ['tab' => 'goals']) }}" method="POST">
                            @csrf
                            <div class="form-fields">
                                <div class="field">
                                    <label for="goal-title">Nama target</label>
                                    <input id="goal-title" type="text" name="title" required maxlength="100" value="{{ old('title') }}" placeholder="Dana darurat, liburan...">
                                </div>
                                <div class="field">
                                    <label for="goal-target-amount">Nominal target (Rp)</label>
                                    <input id="goal-target-amount" type="number" name="target_amount" required min="1" value="{{ old('target_amount') }}" placeholder="Contoh: 5000000">
                                </div>
                                <div class="field">
                                    <label for="goal-current-amount">Saldo awal (Rp)</label>
                                    <input id="goal-current-amount" type="number" name="current_amount" min="0" value="{{ old('current_amount', 0) }}" placeholder="0">
                                </div>
                                <div class="field">
                                    <label for="goal-date">Tenggat waktu <span style="font-weight:500;color:#9aa49d">(opsional)</span></label>
                                    <input id="goal-date" type="date" name="target_date" value="{{ old('target_date') }}">
                                </div>
                            </div>
                            <button type="submit" class="button button-dark">Tambah target tabungan</button>
                        </form>
                    </section>
                    @endif
                </div>
            </div>
            @endif
        </main>
    </div>

    <script>
        document.querySelectorAll('[data-progress]').forEach(function (element) {
            element.style.width = element.dataset.progress + '%';
        });
    </script>
    <script>
    if ('serviceWorker' in navigator) {
        window.addEventListener('load', () => {
            navigator.serviceWorker.register('/sw.js');
        });
    }
</script>
</body>
</html>
