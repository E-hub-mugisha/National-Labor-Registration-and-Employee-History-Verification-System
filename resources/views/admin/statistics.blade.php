@extends('layouts.app')
@section('title', 'Labor Market Statistics')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="fw-bold mb-0">Labor Market Statistics</h4>
        <small class="text-muted">National employment data overview</small>
    </div>
</div>

<div class="row g-4">

    {{-- Employment by Status --}}
    <div class="col-lg-6">
        <div class="card">
            <div class="card-header bg-white py-3">
                <h6 class="mb-0 fw-bold">
                    <i class="bi bi-pie-chart me-2 text-primary"></i>
                    Employment by Status
                </h6>
            </div>
            <div class="card-body">
                <canvas id="statusChart" height="250"></canvas>
            </div>
        </div>
    </div>

    {{-- Top Industries --}}
    <div class="col-lg-6">
        <div class="card">
            <div class="card-header bg-white py-3">
                <h6 class="mb-0 fw-bold">
                    <i class="bi bi-bar-chart me-2 text-primary"></i>
                    Top Industries
                </h6>
            </div>
            <div class="card-body">
                <canvas id="industryChart" height="250"></canvas>
            </div>
        </div>
    </div>

    {{-- Monthly Registrations --}}
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header bg-white py-3">
                <h6 class="mb-0 fw-bold">
                    <i class="bi bi-graph-up me-2 text-primary"></i>
                    Monthly Employee Registrations
                </h6>
            </div>
            <div class="card-body">
                <canvas id="registrationsChart" height="200"></canvas>
            </div>
        </div>
    </div>

    {{-- Exit Reasons --}}
    <div class="col-lg-4">
        <div class="card">
            <div class="card-header bg-white py-3">
                <h6 class="mb-0 fw-bold">
                    <i class="bi bi-door-open me-2 text-primary"></i>
                    Exit Reasons
                </h6>
            </div>
            <div class="card-body">
                @forelse($exitReasons as $reason => $count)
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <small>{{ ucfirst(str_replace('_', ' ', $reason)) }}</small>
                    <div class="d-flex align-items-center gap-2">
                        <div style="width:80px;background:#F0F0F0;border-radius:4px;height:8px;">
                            <div style="width:{{ ($count / $exitReasons->sum()) * 100 }}%;
                                        background:var(--secondary);
                                        border-radius:4px;
                                        height:8px;">
                            </div>
                        </div>
                        <span class="badge bg-secondary">{{ $count }}</span>
                    </div>
                </div>
                @empty
                <p class="text-muted small">No exit records yet.</p>
                @endforelse
            </div>
        </div>
    </div>

    {{-- Employment by District --}}
    <div class="col-12">
        <div class="card">
            <div class="card-header bg-white py-3">
                <h6 class="mb-0 fw-bold">
                    <i class="bi bi-geo-alt me-2 text-primary"></i>
                    Top Districts by Employee Count
                </h6>
            </div>
            <div class="card-body">
                <div class="row g-2">
                    @forelse($employmentByDistrict as $district => $count)
                    <div class="col-md-6">
                        <div class="d-flex justify-content-between align-items-center mb-1">
                            <small class="fw-medium">{{ $district ?? 'Unknown' }}</small>
                            <small class="text-muted">{{ $count }}</small>
                        </div>
                        <div style="background:#F0F0F0;border-radius:4px;height:8px;">
                            <div style="width:{{ ($count / $employmentByDistrict->max()) * 100 }}%;
                                        background:var(--primary);
                                        border-radius:4px;
                                        height:8px;">
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="col-12">
                        <p class="text-muted small">No district data yet.</p>
                    </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

</div>

@push('scripts')
<script>
    // Employment by Status Chart
    new Chart(document.getElementById('statusChart'), {
        type: 'doughnut',
        data: {
            labels: {!! json_encode($employmentByStatus->keys()->map(fn($k) => ucfirst(str_replace('_', ' ', $k))) ) !!},
            datasets: [{
                data: {!! json_encode($employmentByStatus->values()) !!},
                backgroundColor: [
                    '#1B3A6B', '#2E6DB4', '#1A7A4A',
                    '#D97706', '#DC2626', '#6B7280'
                ],
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { position: 'bottom' }
            }
        }
    });

    // Top Industries Chart
    new Chart(document.getElementById('industryChart'), {
        type: 'bar',
        data: {
            labels: {!! json_encode($topIndustries->keys()) !!},
            datasets: [{
                label: 'Employers',
                data: {!! json_encode($topIndustries->values()) !!},
                backgroundColor: '#2E6DB4',
                borderRadius: 6,
            }]
        },
        options: {
            responsive: true,
            plugins: { legend: { display: false } },
            scales: {
                y: { beginAtZero: true, ticks: { precision: 0 } }
            }
        }
    });

    // Monthly Registrations Chart
    new Chart(document.getElementById('registrationsChart'), {
        type: 'line',
        data: {
            labels: {!! json_encode($monthlyRegistrations->keys()) !!},
            datasets: [{
                label: 'Registrations',
                data: {!! json_encode($monthlyRegistrations->values()) !!},
                borderColor: '#1B3A6B',
                backgroundColor: 'rgba(27,58,107,.1)',
                tension: 0.4,
                fill: true,
            }]
        },
        options: {
            responsive: true,
            plugins: { legend: { display: false } },
            scales: {
                y: { beginAtZero: true, ticks: { precision: 0 } }
            }
        }
    });
</script>
@endpush

@endsection