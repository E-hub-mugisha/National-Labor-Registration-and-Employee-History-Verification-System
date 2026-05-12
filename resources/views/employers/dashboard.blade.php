@extends('layouts.app')

@section('title', 'Employer Dashboard')

@section('content')
<style>
    @import url('https://fonts.googleapis.com/css2?family=Syne:wght@600;700;800&family=DM+Sans:wght@300;400;500;600&display=swap');

    :root {
        --bg-base:   #060f11;
        --bg-card:   #0c1a1e;
        --bg-raised: #112028;
        --border:    #1e3540;
        --border-hi: #2a4a5a;
        --teal:      #00c5a1;
        --teal-dim:  rgba(0,197,161,.12);
        --teal-glow: rgba(0,197,161,.25);
        --amber:     #f59e0b;
        --red:       #ef4444;
        --blue:      #3b82f6;
        --text-1:    #e8f4f6;
        --text-2:    #7da4b0;
        --text-3:    #4a7282;
        --font-head: 'Syne', sans-serif;
        --font-body: 'DM Sans', sans-serif;
    }

    .dash-wrap          { background: var(--bg-base); min-height: 100vh; padding: 2rem; color: var(--text-1); font-family: var(--font-body); }

    /* Header */
    .emp-header         { display: flex; align-items: flex-start; justify-content: space-between; margin-bottom: 2.5rem; gap: 1rem; }
    .emp-identity       { display: flex; align-items: center; gap: 1.2rem; }
    .emp-logo           { width: 56px; height: 56px; border-radius: 12px; border: 1px solid var(--border-hi); object-fit: cover; background: var(--bg-raised); display: flex; align-items: center; justify-content: center; color: var(--text-3); font-size: 1.5rem; }
    .emp-name           { font-family: var(--font-head); font-size: 1.6rem; font-weight: 800; color: var(--text-1); line-height: 1; }
    .emp-sector         { font-size: .8rem; color: var(--text-2); margin-top: .3rem; }
    .emp-badge          { font-size: .72rem; padding: .25rem .65rem; border-radius: 20px; font-weight: 600; display: inline-flex; align-items: center; gap: .35rem; margin-top: .4rem; }
    .emp-badge.verified { background: rgba(0,197,161,.15); color: var(--teal); }
    .emp-badge.pending  { background: rgba(245,158,11,.15); color: var(--amber); }
    .emp-actions        { display: flex; gap: .6rem; align-items: center; }
    .btn-outline        { font-size: .8rem; padding: .5rem 1rem; border: 1px solid var(--border-hi); border-radius: 8px; color: var(--text-2); background: transparent; cursor: pointer; transition: all .2s; }
    .btn-outline:hover  { border-color: var(--teal); color: var(--teal); }
    .btn-primary        { font-size: .8rem; padding: .5rem 1.1rem; border-radius: 8px; background: var(--teal); color: #060f11; font-weight: 700; border: none; cursor: pointer; transition: opacity .2s; }
    .btn-primary:hover  { opacity: .85; }

    /* KPI */
    .kpi-grid           { display: grid; grid-template-columns: repeat(4, 1fr); gap: 1rem; margin-bottom: 1.5rem; }
    .kpi-card           { background: var(--bg-card); border: 1px solid var(--border); border-radius: 14px; padding: 1.4rem 1.5rem; position: relative; overflow: hidden; transition: border-color .2s, transform .2s; }
    .kpi-card:hover     { border-color: var(--border-hi); transform: translateY(-2px); }
    .kpi-icon           { width: 38px; height: 38px; border-radius: 9px; display: flex; align-items: center; justify-content: center; margin-bottom: 1rem; font-size: 1rem; }
    .kpi-icon.teal      { background: var(--teal-dim); color: var(--teal); border: 1px solid var(--teal-glow); }
    .kpi-icon.amber     { background: rgba(245,158,11,.12); color: var(--amber); border: 1px solid rgba(245,158,11,.25); }
    .kpi-icon.red       { background: rgba(239,68,68,.12); color: var(--red); border: 1px solid rgba(239,68,68,.25); }
    .kpi-icon.blue      { background: rgba(59,130,246,.12); color: var(--blue); border: 1px solid rgba(59,130,246,.25); }
    .kpi-val            { font-family: var(--font-head); font-size: 2rem; font-weight: 700; line-height: 1; color: var(--text-1); }
    .kpi-val-sm         { font-size: 1.3rem; }
    .kpi-label          { font-size: .78rem; color: var(--text-2); margin-top: .35rem; }

    /* Sections */
    .section-title      { font-family: var(--font-head); font-size: 1rem; font-weight: 700; color: var(--text-1); letter-spacing: .04em; text-transform: uppercase; display: flex; align-items: center; gap: .5rem; margin-bottom: 1rem; }
    .section-title::after { content: ''; flex: 1; height: 1px; background: var(--border); }

    .chart-grid         { display: grid; grid-template-columns: 2fr 1fr; gap: 1rem; margin-bottom: 1.5rem; }
    .chart-grid-2       { display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; margin-bottom: 1.5rem; }
    .chart-card         { background: var(--bg-card); border: 1px solid var(--border); border-radius: 14px; padding: 1.5rem; }
    .chart-card-title   { font-size: .78rem; text-transform: uppercase; letter-spacing: .08em; color: var(--text-3); font-weight: 600; margin-bottom: 1.2rem; }

    .data-table         { width: 100%; border-collapse: collapse; }
    .data-table th      { font-size: .72rem; text-transform: uppercase; letter-spacing: .08em; color: var(--text-3); padding: .6rem 1rem; border-bottom: 1px solid var(--border); text-align: left; font-weight: 600; }
    .data-table td      { padding: .75rem 1rem; border-bottom: 1px solid rgba(30,53,64,.5); font-size: .84rem; color: var(--text-1); }
    .data-table tr:last-child td { border-bottom: none; }
    .data-table tr:hover td { background: var(--bg-raised); }

    .badge              { font-size: .72rem; font-weight: 600; padding: .22rem .6rem; border-radius: 20px; display: inline-flex; align-items: center; }
    .avatar-sm          { width: 30px; height: 30px; border-radius: 50%; background: var(--bg-raised); border: 1px solid var(--border); object-fit: cover; display: inline-flex; align-items: center; justify-content: center; font-size: .75rem; color: var(--text-2); }

    .donut-legend       { display: flex; flex-direction: column; gap: .5rem; margin-top: .75rem; }
    .legend-row         { display: flex; align-items: center; justify-content: space-between; font-size: .8rem; }
    .legend-dot         { width: 9px; height: 9px; border-radius: 50%; flex-shrink: 0; }
    .legend-label       { color: var(--text-2); display: flex; align-items: center; gap: .45rem; }
    .legend-val         { color: var(--text-1); font-weight: 600; }

    .empty-state        { text-align: center; padding: 2rem; color: var(--text-3); font-size: .85rem; }

    @media (max-width: 1100px) {
        .kpi-grid    { grid-template-columns: repeat(2,1fr); }
        .chart-grid  { grid-template-columns: 1fr; }
        .chart-grid-2{ grid-template-columns: 1fr; }
    }
</style>

<div class="dash-wrap">

    {{-- Employer header --}}
    <div class="emp-header">
        <div class="emp-identity">
            @if($employer->logo)
                <img src="{{ asset('image/'.$employer->logo) }}" class="emp-logo" alt="logo">
            @else
                <div class="emp-logo"><i class="bi bi-building"></i></div>
            @endif
            <div>
                <div class="emp-name">{{ $employer->name }}</div>
                <div class="emp-sector">{{ $employer->sector_label }} · {{ $employer->district }}, {{ $employer->province }}</div>
                <span class="emp-badge {{ $employer->status }}">
                    <span style="width:6px;height:6px;border-radius:50%;background:currentColor;"></span>
                    {{ ucfirst($employer->status) }}
                </span>
            </div>
        </div>
        <div class="emp-actions">
            <a href="{{ route('employees.index') }}" class="btn-outline">View Employees</a>
            <a href="{{ route('transfers.index') }}" class="btn-primary">Transfer Requests</a>
        </div>
    </div>

    {{-- KPIs --}}
    <div class="kpi-grid">
        <div class="kpi-card">
            <div class="kpi-icon teal"><i class="bi bi-people-fill"></i></div>
            <div class="kpi-val">{{ number_format($totalEmployees) }}</div>
            <div class="kpi-label">Current Employees</div>
        </div>
        <div class="kpi-card">
            <div class="kpi-icon blue"><i class="bi bi-file-earmark-check-fill"></i></div>
            <div class="kpi-val">{{ number_format($activeRecords) }}</div>
            <div class="kpi-label">Active Employment Records</div>
        </div>
        <div class="kpi-card">
            <div class="kpi-icon amber"><i class="bi bi-arrow-left-right"></i></div>
            <div class="kpi-val">{{ number_format($pendingTransfers) }}</div>
            <div class="kpi-label">Incoming Transfer Requests</div>
        </div>
        <div class="kpi-card">
            <div class="kpi-icon teal"><i class="bi bi-currency-dollar"></i></div>
            <div class="kpi-val kpi-val-sm">{{ $avgSalary ? number_format($avgSalary, 0).' RWF' : '—' }}</div>
            <div class="kpi-label">Avg. Active Salary</div>
        </div>
    </div>

    <div class="kpi-grid" style="margin-bottom:2rem;">
        <div class="kpi-card">
            <div class="kpi-icon teal"><i class="bi bi-person-check-fill"></i></div>
            <div class="kpi-val">{{ number_format($rehireEligible) }}</div>
            <div class="kpi-label">Alumni Eligible for Rehire</div>
        </div>
        <div class="kpi-card">
            <div class="kpi-icon red"><i class="bi bi-person-x-fill"></i></div>
            <div class="kpi-val">{{ number_format($rehireIneligible) }}</div>
            <div class="kpi-label">Alumni Ineligible for Rehire</div>
        </div>
        <div class="kpi-card">
            <div class="kpi-icon blue"><i class="bi bi-send-fill"></i></div>
            <div class="kpi-val">{{ number_format($sentTransfers) }}</div>
            <div class="kpi-label">Outgoing Transfers Pending</div>
        </div>
        <div class="kpi-card">
            <div class="kpi-icon amber"><i class="bi bi-chat-square-dots-fill"></i></div>
            <div class="kpi-val">{{ number_format(array_sum($claimsAgainst)) }}</div>
            <div class="kpi-label">Total Claims Filed</div>
        </div>
    </div>

    {{-- Hiring vs Exit Trend --}}
    <div class="section-title">Workforce Trend</div>
    <div class="chart-grid">
        <div class="chart-card">
            <div class="chart-card-title">Monthly Hires vs Exits — Last 12 Months</div>
            <canvas id="hiringChart" height="110"></canvas>
        </div>
        <div class="chart-card">
            <div class="chart-card-title">Conduct Rating Distribution</div>
            <div style="max-width:180px;margin:0 auto;">
                <canvas id="conductChart" height="180"></canvas>
            </div>
            <div class="donut-legend" id="conductLegend"></div>
        </div>
    </div>

    {{-- Department + Exit Reasons --}}
    <div class="section-title">Workforce Composition</div>
    <div class="chart-grid-2">
        <div class="chart-card">
            <div class="chart-card-title">Headcount by Department</div>
            @if($departmentBreakdown->count())
                <canvas id="deptChart" height="180"></canvas>
            @else
                <div class="empty-state"><i class="bi bi-diagram-3" style="font-size:2rem;"></i><br>No department data available</div>
            @endif
        </div>
        <div class="chart-card">
            <div class="chart-card-title">Exit Reasons</div>
            @if($exitReasons->count())
                <canvas id="exitChart" height="180"></canvas>
            @else
                <div class="empty-state"><i class="bi bi-door-open" style="font-size:2rem;"></i><br>No exits recorded yet</div>
            @endif
        </div>
    </div>

    {{-- Claims --}}
    @if(array_sum($claimsAgainst) > 0)
    <div class="section-title">Claims Overview</div>
    <div class="chart-card" style="margin-bottom:1.5rem;">
        <div class="chart-card-title">Claims Against Your Records by Status</div>
        <div style="display:flex;gap:2rem;align-items:center;flex-wrap:wrap;">
            @foreach($claimsAgainst as $status => $count)
            @php
                $colors = ['pending'=>'#f59e0b','under_review'=>'#3b82f6','resolved'=>'#00c5a1','rejected'=>'#ef4444'];
                $labels = ['pending'=>'Pending','under_review'=>'Under Review','resolved'=>'Resolved','rejected'=>'Rejected'];
            @endphp
            <div style="text-align:center;padding:.75rem 1.5rem;background:var(--bg-raised);border-radius:10px;border:1px solid var(--border);">
                <div style="font-family:var(--font-head);font-size:1.8rem;font-weight:700;color:{{ $colors[$status] ?? '#4a7282' }}">{{ $count }}</div>
                <div style="font-size:.75rem;color:var(--text-3);margin-top:.25rem;">{{ $labels[$status] ?? ucfirst($status) }}</div>
            </div>
            @endforeach
        </div>
    </div>
    @endif

    {{-- Recent Transfers + Hires --}}
    <div class="section-title">Recent Activity</div>
    <div class="chart-grid-2">
        <div class="chart-card">
            <div class="chart-card-title">Incoming Transfer Requests</div>
            @if($recentTransfers->count())
            <table class="data-table">
                <thead><tr>
                    <th>Employee</th>
                    <th>From</th>
                    <th>Position</th>
                    <th>Status</th>
                </tr></thead>
                <tbody>
                    @foreach($recentTransfers as $tr)
                    <tr>
                        <td>{{ $tr->employee->full_name ?? '—' }}</td>
                        <td style="font-size:.78rem;color:var(--text-3)">{{ $tr->requestingEmployer->name ?? '—' }}</td>
                        <td style="font-size:.8rem;">{{ $tr->requested_position ?? '—' }}</td>
                        <td><span class="badge {{ $tr->status_badge }}">{{ ucfirst($tr->status) }}</span></td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            @else
                <div class="empty-state"><i class="bi bi-inbox" style="font-size:2rem;"></i><br>No transfer requests yet</div>
            @endif
        </div>

        <div class="chart-card">
            <div class="chart-card-title">Most Recent Hires</div>
            @if($recentHires->count())
            <table class="data-table">
                <thead><tr>
                    <th>Name</th>
                    <th>Position</th>
                    <th>Start Date</th>
                </tr></thead>
                <tbody>
                    @foreach($recentHires as $record)
                    <tr>
                        <td>{{ $record->employee->full_name ?? '—' }}</td>
                        <td style="font-size:.8rem;color:var(--text-2)">{{ $record->position }}</td>
                        <td style="font-size:.78rem;color:var(--text-3)">{{ $record->start_date->format('d M Y') }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            @else
                <div class="empty-state"><i class="bi bi-person-plus" style="font-size:2rem;"></i><br>No employees hired yet</div>
            @endif
        </div>
    </div>

</div>


<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script>
const TEAL   = '#00c5a1';
const AMBER  = '#f59e0b';
const RED    = '#ef4444';
const BLUE   = '#3b82f6';
const PURPLE = '#a78bfa';
const BORDER = '#1e3540';
const TEXT2  = '#7da4b0';

Chart.defaults.color = TEXT2;
Chart.defaults.borderColor = BORDER;
Chart.defaults.font.family = "'DM Sans', sans-serif";

// Hiring vs exits line
new Chart(document.getElementById('hiringChart'), {
    type: 'line',
    data: {
        labels: @json($chartMonths),
        datasets: [
            { label: 'Hires', data: @json($chartHiring), borderColor: TEAL, backgroundColor: 'rgba(0,197,161,.08)', fill: true, tension: .4, pointRadius: 3, pointBackgroundColor: TEAL },
            { label: 'Exits', data: @json($chartExits), borderColor: RED, backgroundColor: 'rgba(239,68,68,.06)', fill: true, tension: .4, pointRadius: 3, pointBackgroundColor: RED },
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

// Conduct donut
const conductData   = @json(array_values($conductBreakdown));
const conductLabels = @json(array_keys($conductBreakdown));
const conductColors = conductLabels.map(l => ({
    excellent:'#00c5a1', good:'#3b82f6', satisfactory:'#f59e0b', poor:'#fb923c', very_poor:'#ef4444'
}[l] || '#4a7282'));

new Chart(document.getElementById('conductChart'), {
    type: 'doughnut',
    data: { labels: conductLabels, datasets: [{ data: conductData, backgroundColor: conductColors, borderWidth: 0 }] },
    options: { plugins: { legend: { display: false } }, cutout: '68%' }
});
const cLegend = document.getElementById('conductLegend');
conductLabels.forEach((l,i) => {
    cLegend.innerHTML += `<div class="legend-row"><span class="legend-label"><span class="legend-dot" style="background:${conductColors[i]}"></span>${l.replace('_',' ')}</span><span class="legend-val">${conductData[i]}</span></div>`;
});

// Department bar
@if($departmentBreakdown->count())
const depts = @json($departmentBreakdown);
new Chart(document.getElementById('deptChart'), {
    type: 'bar',
    data: {
        labels: depts.map(d => d.department),
        datasets: [{ data: depts.map(d => d.total), backgroundColor: TEAL, borderRadius: 5 }]
    },
    options: {
        indexAxis: 'y',
        plugins: { legend: { display: false } },
        scales: {
            x: { grid: { color: BORDER }, ticks: { precision: 0 } },
            y: { grid: { display: false }, ticks: { font: { size: 11 } } }
        }
    }
});
@endif

// Exit reasons
@if($exitReasons->count())
const exits = @json($exitReasons);
new Chart(document.getElementById('exitChart'), {
    type: 'bar',
    data: {
        labels: exits.map(e => e.exit_reason_label ?? e.exit_reason),
        datasets: [{ data: exits.map(e => e.total), backgroundColor: BLUE, borderRadius: 5 }]
    },
    options: {
        plugins: { legend: { display: false } },
        scales: {
            x: { grid: { color: BORDER }, ticks: { precision: 0 } },
            y: { grid: { display: false }, ticks: { font: { size: 11 } } }
        }
    }
});
@endif
</script>

@endsection