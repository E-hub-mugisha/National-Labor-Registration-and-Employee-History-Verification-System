@extends('layouts.app')

@section('title', 'Admin Dashboard')

@section('content')

<style>
    :root {
        --bg-base:    #060f11;
        --bg-card:    #0c1a1e;
        --bg-raised:  #112028;
        --border:     #1e3540;
        --border-hi:  #2a4a5a;
        --teal:       #00c5a1;
        --teal-dim:   rgba(0,197,161,.12);
        --teal-glow:  rgba(0,197,161,.25);
        --amber:      #f59e0b;
        --red:        #ef4444;
        --blue:       #3b82f6;
        --text-1:     #e8f4f6;
        --text-2:     #7da4b0;
        --text-3:     #4a7282;
        --font-head:  'Syne', sans-serif;
        --font-body:  'DM Sans', sans-serif;
    }

    @import url('https://fonts.googleapis.com/css2?family=Syne:wght@600;700;800&family=DM+Sans:wght@300;400;500;600&display=swap');

    .dash-wrap         { background: var(--bg-base); min-height: 100vh; padding: 2rem; color: var(--text-1); font-family: var(--font-body); }
    .dash-header       { display: flex; align-items: flex-end; justify-content: space-between; margin-bottom: 2.5rem; }
    .dash-title        { font-family: var(--font-head); font-size: 2rem; font-weight: 800; letter-spacing: -.02em; color: var(--text-1); line-height: 1; }
    .dash-title span   { color: var(--teal); }
    .dash-subtitle     { font-size: .85rem; color: var(--text-2); margin-top: .35rem; }
    .dash-date         { font-size: .8rem; color: var(--text-3); }

    /* KPI grid */
    .kpi-grid          { display: grid; grid-template-columns: repeat(4, 1fr); gap: 1rem; margin-bottom: 1.5rem; }
    .kpi-card          { background: var(--bg-card); border: 1px solid var(--border); border-radius: 14px; padding: 1.4rem 1.5rem; position: relative; overflow: hidden; transition: border-color .2s, transform .2s; }
    .kpi-card:hover    { border-color: var(--border-hi); transform: translateY(-2px); }
    .kpi-card::before  { content: ''; position: absolute; inset: 0; background: var(--teal-dim); opacity: 0; transition: opacity .2s; border-radius: inherit; }
    .kpi-card:hover::before { opacity: 1; }
    .kpi-icon          { width: 40px; height: 40px; border-radius: 10px; display: flex; align-items: center; justify-content: center; margin-bottom: 1rem; font-size: 1.1rem; }
    .kpi-icon.teal     { background: var(--teal-dim); color: var(--teal); border: 1px solid var(--teal-glow); }
    .kpi-icon.amber    { background: rgba(245,158,11,.12); color: var(--amber); border: 1px solid rgba(245,158,11,.25); }
    .kpi-icon.red      { background: rgba(239,68,68,.12); color: var(--red); border: 1px solid rgba(239,68,68,.25); }
    .kpi-icon.blue     { background: rgba(59,130,246,.12); color: var(--blue); border: 1px solid rgba(59,130,246,.25); }
    .kpi-val           { font-family: var(--font-head); font-size: 2.2rem; font-weight: 700; line-height: 1; color: var(--text-1); }
    .kpi-label         { font-size: .8rem; color: var(--text-2); margin-top: .35rem; }
    .kpi-growth        { position: absolute; top: 1.2rem; right: 1.2rem; font-size: .75rem; font-weight: 600; padding: .25rem .55rem; border-radius: 20px; }
    .kpi-growth.up     { background: rgba(0,197,161,.15); color: var(--teal); }
    .kpi-growth.down   { background: rgba(239,68,68,.15); color: var(--red); }
    .kpi-growth.neutral{ background: rgba(255,255,255,.06); color: var(--text-3); }

    /* Section labels */
    .section-title     { font-family: var(--font-head); font-size: 1rem; font-weight: 700; color: var(--text-1); letter-spacing: .04em; text-transform: uppercase; display: flex; align-items: center; gap: .5rem; margin-bottom: 1rem; }
    .section-title::after { content: ''; flex: 1; height: 1px; background: var(--border); }

    /* Chart cards */
    .chart-grid        { display: grid; grid-template-columns: 2fr 1fr; gap: 1rem; margin-bottom: 1.5rem; }
    .chart-grid-3      { display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 1rem; margin-bottom: 1.5rem; }
    .chart-card        { background: var(--bg-card); border: 1px solid var(--border); border-radius: 14px; padding: 1.5rem; }
    .chart-card-title  { font-size: .8rem; text-transform: uppercase; letter-spacing: .08em; color: var(--text-3); font-weight: 600; margin-bottom: 1.2rem; }
    .chart-wrap        { position: relative; }

    /* Data table */
    .data-table        { width: 100%; border-collapse: collapse; }
    .data-table th     { font-size: .72rem; text-transform: uppercase; letter-spacing: .08em; color: var(--text-3); padding: .6rem 1rem; border-bottom: 1px solid var(--border); text-align: left; font-weight: 600; }
    .data-table td     { padding: .75rem 1rem; border-bottom: 1px solid rgba(30,53,64,.5); font-size: .85rem; color: var(--text-1); }
    .data-table tr:last-child td { border-bottom: none; }
    .data-table tr:hover td { background: var(--bg-raised); }

    /* Badges */
    .badge             { font-size: .72rem; font-weight: 600; padding: .22rem .6rem; border-radius: 20px; display: inline-flex; align-items: center; }

    /* Logs */
    .log-row           { display: flex; align-items: flex-start; gap: .9rem; padding: .75rem 0; border-bottom: 1px solid rgba(30,53,64,.5); }
    .log-dot           { width: 8px; height: 8px; border-radius: 50%; background: var(--teal); margin-top: .4rem; flex-shrink: 0; }
    .log-dot.red       { background: var(--red); }
    .log-dot.amber     { background: var(--amber); }
    .log-dot.blue      { background: var(--blue); }
    .log-action        { font-size: .82rem; color: var(--text-1); line-height: 1.4; }
    .log-meta          { font-size: .73rem; color: var(--text-3); margin-top: .15rem; }

    /* Top employers table */
    .rank-num          { font-family: var(--font-head); font-size: .9rem; color: var(--teal); font-weight: 700; }

    /* Donut legend */
    .donut-legend      { display: flex; flex-direction: column; gap: .5rem; margin-top: .75rem; }
    .legend-row        { display: flex; align-items: center; justify-content: space-between; font-size: .8rem; }
    .legend-dot        { width: 9px; height: 9px; border-radius: 50%; flex-shrink: 0; }
    .legend-label      { color: var(--text-2); display: flex; align-items: center; gap: .45rem; }
    .legend-val        { color: var(--text-1); font-weight: 600; }

    /* Responsive tweaks */
    @media (max-width: 1200px) {
        .kpi-grid   { grid-template-columns: repeat(2, 1fr); }
        .chart-grid { grid-template-columns: 1fr; }
        .chart-grid-3 { grid-template-columns: 1fr; }
    }
</style>

<div class="dash-wrap">

    {{-- Header --}}
    <div class="dash-header">
        <div>
            <div class="dash-title">Admin <span>Dashboard</span></div>
            <div class="dash-subtitle">National Employment Management System</div>
        </div>
        <div class="dash-date">{{ now()->format('l, d F Y') }}</div>
    </div>

    {{-- KPI Row 1 --}}
    <div class="kpi-grid">
        <div class="kpi-card">
            <div class="kpi-icon teal"><i class="bi bi-people-fill"></i></div>
            @if($employeeGrowth > 0)
                <span class="kpi-growth up">↑ {{ $employeeGrowth }}%</span>
            @elseif($employeeGrowth < 0)
                <span class="kpi-growth down">↓ {{ abs($employeeGrowth) }}%</span>
            @else
                <span class="kpi-growth neutral">—</span>
            @endif
            <div class="kpi-val">{{ number_format($totalEmployees) }}</div>
            <div class="kpi-label">Total Employees <span style="color:var(--teal)">· {{ number_format($activeEmployees) }} active</span></div>
        </div>

        <div class="kpi-card">
            <div class="kpi-icon blue"><i class="bi bi-building-fill"></i></div>
            @if($employerGrowth > 0)
                <span class="kpi-growth up">↑ {{ $employerGrowth }}%</span>
            @elseif($employerGrowth < 0)
                <span class="kpi-growth down">↓ {{ abs($employerGrowth) }}%</span>
            @else
                <span class="kpi-growth neutral">—</span>
            @endif
            <div class="kpi-val">{{ number_format($totalEmployers) }}</div>
            <div class="kpi-label">Employers <span style="color:var(--blue)">· {{ $verifiedEmployers }} verified</span></div>
        </div>

        <div class="kpi-card">
            <div class="kpi-icon amber"><i class="bi bi-hourglass-split"></i></div>
            <div class="kpi-val">{{ number_format($pendingEmployers) }}</div>
            <div class="kpi-label">Pending Verifications</div>
        </div>

        <div class="kpi-card">
            <div class="kpi-icon red"><i class="bi bi-exclamation-triangle-fill"></i></div>
            <div class="kpi-val">{{ number_format($openClaims) }}</div>
            <div class="kpi-label">Open Claims <span style="color:var(--amber)">· {{ $pendingTransfers }} transfers</span></div>
        </div>
    </div>

    {{-- KPI Row 2 --}}
    <div class="kpi-grid" style="margin-bottom:2rem;">
        <div class="kpi-card">
            <div class="kpi-icon teal"><i class="bi bi-file-earmark-text-fill"></i></div>
            <div class="kpi-val">{{ number_format($totalRecords) }}</div>
            <div class="kpi-label">Employment Records</div>
        </div>

        <div class="kpi-card">
            <div class="kpi-icon red"><i class="bi bi-slash-circle-fill"></i></div>
            <div class="kpi-val">{{ number_format($blacklistedCount) }}</div>
            <div class="kpi-label">Blacklisted Employees</div>
        </div>

        <div class="kpi-card">
            <div class="kpi-icon amber"><i class="bi bi-arrow-left-right"></i></div>
            <div class="kpi-val">{{ number_format($pendingTransfers) }}</div>
            <div class="kpi-label">Pending Transfers</div>
        </div>

        <div class="kpi-card">
            <div class="kpi-icon blue"><i class="bi bi-bar-chart-fill"></i></div>
            <div class="kpi-val">{{ number_format($totalEmployers > 0 ? round($totalEmployees / $totalEmployers, 1) : 0) }}</div>
            <div class="kpi-label">Avg. Employees / Employer</div>
        </div>
    </div>

    {{-- Registration Trend --}}
    <div class="section-title">Registration Trends</div>
    <div class="chart-grid">
        <div class="chart-card">
            <div class="chart-card-title">Monthly Registrations — Last 12 Months</div>
            <div class="chart-wrap"><canvas id="regTrendChart" height="110"></canvas></div>
        </div>
        <div class="chart-card">
            <div class="chart-card-title">Employee Status Breakdown</div>
            <div class="chart-wrap" style="max-width:200px;margin:0 auto;">
                <canvas id="empStatusChart" height="180"></canvas>
            </div>
            <div class="donut-legend" id="empStatusLegend"></div>
        </div>
    </div>

    {{-- Sector + Claims + Transfers --}}
    <div class="section-title">Distribution Analysis</div>
    <div class="chart-grid-3">
        <div class="chart-card">
            <div class="chart-card-title">Employer Sector Distribution</div>
            <canvas id="sectorChart" height="220"></canvas>
        </div>
        <div class="chart-card">
            <div class="chart-card-title">Claims by Status</div>
            <div style="max-width:180px;margin:0 auto;"><canvas id="claimsChart" height="180"></canvas></div>
            <div class="donut-legend" id="claimsLegend"></div>
        </div>
        <div class="chart-card">
            <div class="chart-card-title">Transfer Requests by Status</div>
            <div style="max-width:180px;margin:0 auto;"><canvas id="transferChart" height="180"></canvas></div>
            <div class="donut-legend" id="transferLegend"></div>
        </div>
    </div>

    {{-- Tables --}}
    <div class="section-title">Top Employers &amp; Province Distribution</div>
    <div style="display:grid;grid-template-columns:1fr 1fr;gap:1rem;margin-bottom:1.5rem;">
        <div class="chart-card">
            <div class="chart-card-title">Top Employers by Headcount</div>
            <table class="data-table">
                <thead><tr>
                    <th>#</th>
                    <th>Employer</th>
                    <th>Sector</th>
                    <th style="text-align:right">Staff</th>
                </tr></thead>
                <tbody>
                    @foreach($topEmployers as $i => $emp)
                    <tr>
                        <td><span class="rank-num">{{ $i + 1 }}</span></td>
                        <td>{{ $emp->name }}</td>
                        <td><span style="color:var(--text-3);font-size:.78rem;">{{ $emp->sector_label }}</span></td>
                        <td style="text-align:right;font-weight:600;color:var(--teal)">{{ $emp->current_employees_count }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="chart-card">
            <div class="chart-card-title">Province Distribution</div>
            <canvas id="provinceChart" height="200"></canvas>
        </div>
    </div>

    {{-- Exit Reasons --}}
    <div class="section-title">Exit Reason Analysis</div>
    <div class="chart-card" style="margin-bottom:1.5rem;">
        <div class="chart-card-title">Exit Reason Breakdown (All Time)</div>
        <canvas id="exitChart" height="80"></canvas>
    </div>

    {{-- Audit Logs --}}
    <div class="section-title">Recent System Activity</div>
    <div class="chart-card">
        <div class="chart-card-title">Audit Log — Last 10 Actions</div>
        @foreach($recentLogs as $log)
        @php
            $dotClass = match($log->action) {
                'deleted'  => 'red',
                'login','logout' => 'blue',
                'updated','verified' => 'amber',
                default => '',
            };
        @endphp
        <div class="log-row">
            <div class="log-dot {{ $dotClass }}"></div>
            <div>
                <div class="log-action">
                    <strong style="color:var(--text-1)">{{ $log->action_label }}</strong>
                    — {{ $log->description }}
                </div>
                <div class="log-meta">
                    {{ $log->user->name ?? 'System' }}
                    · {{ $log->ip_address }}
                    · {{ $log->created_at->diffForHumans() }}
                </div>
            </div>
        </div>
        @endforeach
    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script>
const TEAL   = '#00c5a1';
const AMBER  = '#f59e0b';
const RED    = '#ef4444';
const BLUE   = '#3b82f6';
const PURPLE = '#a78bfa';
const ORANGE = '#fb923c';
const BORDER = '#1e3540';
const TEXT2  = '#7da4b0';

Chart.defaults.color = TEXT2;
Chart.defaults.borderColor = BORDER;
Chart.defaults.font.family = "'DM Sans', sans-serif";

// Registration trend
new Chart(document.getElementById('regTrendChart'), {
    type: 'line',
    data: {
        labels: @json($chartMonths),
        datasets: [
            {
                label: 'Employees',
                data: @json($chartEmployees),
                borderColor: TEAL,
                backgroundColor: 'rgba(0,197,161,.08)',
                fill: true,
                tension: .4,
                pointRadius: 3,
                pointBackgroundColor: TEAL,
            },
            {
                label: 'Employers',
                data: @json($chartEmployers),
                borderColor: BLUE,
                backgroundColor: 'rgba(59,130,246,.06)',
                fill: true,
                tension: .4,
                pointRadius: 3,
                pointBackgroundColor: BLUE,
            }
        ]
    },
    options: {
        plugins: { legend: { labels: { boxWidth: 10, font: { size: 11 } } } },
        scales: {
            x: { grid: { color: BORDER } },
            y: { grid: { color: BORDER }, beginAtZero: true, ticks: { precision: 0 } }
        }
    }
});

// Employee status donut
const empStatusData = @json(array_values($employeeStatusBreakdown));
const empStatusLabels = @json(array_keys($employeeStatusBreakdown));
const empStatusColors = empStatusLabels.map(l => ({ active:'#00c5a1', unemployed:'#3b82f6', blacklisted:'#ef4444' }[l] || '#4a7282'));

new Chart(document.getElementById('empStatusChart'), {
    type: 'doughnut',
    data: { labels: empStatusLabels, datasets: [{ data: empStatusData, backgroundColor: empStatusColors, borderWidth: 0 }] },
    options: { plugins: { legend: { display: false } }, cutout: '68%' }
});
const legend = document.getElementById('empStatusLegend');
empStatusLabels.forEach((l,i) => {
    legend.innerHTML += `<div class="legend-row"><span class="legend-label"><span class="legend-dot" style="background:${empStatusColors[i]}"></span>${l}</span><span class="legend-val">${empStatusData[i]}</span></div>`;
});

// Sector horizontal bar
const sectorData = @json($sectorDistribution);
new Chart(document.getElementById('sectorChart'), {
    type: 'bar',
    data: {
        labels: sectorData.map(s => s.sector),
        datasets: [{ data: sectorData.map(s => s.total), backgroundColor: TEAL, borderRadius: 4 }]
    },
    options: {
        indexAxis: 'y',
        plugins: { legend: { display: false } },
        scales: {
            x: { grid: { color: BORDER }, ticks: { precision: 0 } },
            y: { grid: { display: false }, ticks: { font: { size: 10 } } }
        }
    }
});

// Claims donut
function makeDonut(canvasId, legendId, rawData, colorMap) {
    const labels = Object.keys(rawData);
    const vals   = Object.values(rawData);
    const colors = labels.map(l => colorMap[l] || '#4a7282');
    new Chart(document.getElementById(canvasId), {
        type: 'doughnut',
        data: { labels, datasets: [{ data: vals, backgroundColor: colors, borderWidth: 0 }] },
        options: { plugins: { legend: { display: false } }, cutout: '68%' }
    });
    if (legendId) {
        const el = document.getElementById(legendId);
        labels.forEach((l,i) => {
            el.innerHTML += `<div class="legend-row"><span class="legend-label"><span class="legend-dot" style="background:${colors[i]}"></span>${l}</span><span class="legend-val">${vals[i]}</span></div>`;
        });
    }
}

makeDonut('claimsChart','claimsLegend', @json($claimsBreakdown), {
    pending: AMBER, under_review: BLUE, resolved: TEAL, rejected: RED
});
makeDonut('transferChart','transferLegend', @json($transferStats), {
    pending: AMBER, approved: TEAL, rejected: RED, cancelled: '#4a7282'
});

// Province bar
const prov = @json($provinceDistribution);
new Chart(document.getElementById('provinceChart'), {
    type: 'bar',
    data: {
        labels: prov.map(p => p.province || 'Unknown'),
        datasets: [{ data: prov.map(p => p.total), backgroundColor: [TEAL, BLUE, AMBER, PURPLE, ORANGE], borderRadius: 6 }]
    },
    options: {
        plugins: { legend: { display: false } },
        scales: {
            x: { grid: { display: false } },
            y: { grid: { color: BORDER }, ticks: { precision: 0 } }
        }
    }
});

// Exit reasons
const exits = @json($exitReasons);
new Chart(document.getElementById('exitChart'), {
    type: 'bar',
    data: {
        labels: exits.map(e => e.exit_reason_label ?? e.exit_reason),
        datasets: [{ data: exits.map(e => e.total), backgroundColor: BLUE, borderRadius: 4 }]
    },
    options: {
        plugins: { legend: { display: false } },
        scales: {
            x: { grid: { display: false } },
            y: { grid: { color: BORDER }, ticks: { precision: 0 } }
        }
    }
});
</script>

@endsection