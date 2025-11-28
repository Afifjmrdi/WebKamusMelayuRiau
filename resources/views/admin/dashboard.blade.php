@extends('layouts.admin')

@section('title', 'Dashboard Admin')

@section('content')

{{-- HERO --}}
<div class="position-relative mb-4">
    <div class="card border-0 shadow-lg rounded-4 overflow-hidden text-white"
        style="background: url('{{ asset('assets/dashboard1.png') }}') no-repeat center/cover; min-height: 170px;">
        <div class="p-5">
            <h1 class="fw-bold text-white">Halo {{ $admin->name ?? 'Admin' }}!</h1>
            <p class="fs-5 opacity-75">Selamat Datang, mohon cek update pengajuan selalu ya.</p>
        </div>
    </div>
</div>

{{-- STATISTICS --}}
<div class="row g-4 mb-4">

    {{-- Total Kosakata --}}
    <div class="col-md-3">
        <div class="card shadow-sm rounded-4 border-0 p-3">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h6 class="text-muted">Total Kosakata</h6>
                    <h3 class="fw-bold">{{ $totalKosakata }}</h3>
                </div>
                <div class="icon-box rounded-4 bg-dark text-white p-3">
                    <i class="bx bx-book-open fs-2"></i>
                </div>
            </div>
        </div>
    </div>

    {{-- Total Pengunjung --}}
    <div class="col-md-3">
        <div class="card shadow-sm rounded-4 border-0 p-3">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h6 class="text-muted">Total Pengunjung Kamus</h6>
                    <h3 class="fw-bold">{{ $totalVisitors }}</h3>
                </div>
                <div class="icon-box rounded-4 bg-dark text-white p-3">
                    <i class="bx bx-globe fs-2"></i>
                </div>
            </div>
        </div>
    </div>

    {{-- Total Pengajuan Kosakata --}}
    <div class="col-md-3">
        <div class="card shadow-sm rounded-4 border-0 p-3">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h6 class="text-muted">Total Pengajuan Kosakata</h6>
                    <h3 class="fw-bold">{{ $totalPengajuan }}</h3>
                </div>
                <div class="icon-box rounded-4 bg-dark text-white p-3">
                    <i class="bx bx-category fs-2"></i>
                </div>
            </div>
        </div>
    </div>

    {{-- Total Pengajuan Koreksi --}}
    <div class="col-md-3">
        <div class="card shadow-sm rounded-4 border-0 p-3">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h6 class="text-muted">Total Pengajuan Koreksi</h6>
                    <h3 class="fw-bold">{{ $totalKoreksi }}</h3>
                </div>
                <div class="icon-box rounded-4 bg-dark text-white p-3">
                    <i class="bx bx-bar-chart-alt-2 fs-2"></i>
                </div>
            </div>
        </div>
    </div>

</div>

{{-- DONUT + LINE CHART --}}
<div class="row g-4">
    <div class="col-md-4">
        <div class="card shadow-sm border-0 rounded-4 p-4">

            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <h5 class="fw-bold" style="margin-top: 15px;">Statistik Kamus</h5>
                    <p class="text-muted medium">{{ array_sum($chartCounts) }} Kosakata</p>
                </div>

                <div id="donutWrapper"
                    style="
                    padding: 10px;
                    background: #fff;
                    border-radius: 50%;
                    width: 160px;
                    height: 160px;
                    display: flex;
                    align-items: center;
                    justify-content: center;
                ">
                    <div id="donutChart" style="width:100%; height:100%;"></div>
                </div>
            </div>

            <h2 class="fw-bold mt-2">{{ array_sum($chartCounts) }}</h2>
            <p class="text-muted medium">Total Kosakata</p>

            <div class="mt-3">
                @foreach ($chartNames as $i => $name)
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div class="d-flex align-items-center gap-3">
                        <div class="p-2 rounded-3" style="background:#eef2ff;">
                            <i class="bx bx-book fs-4 text-primary"></i>
                        </div>
                        <div>
                            <h6 class="mb-0 fw-semibold">{{ $name }}</h6>
                            <small class="text-muted">Jumlah kosakata</small>
                        </div>
                    </div>
                    <span class="fw-bold">{{ $chartCounts[$i] }}</span>
                </div>
                @endforeach
            </div>

        </div>
    </div>

    {{-- LINE CHART --}}
    <div class="col-md-8">
        <div class="card shadow-sm border-0 rounded-4 p-4">
            <h5 class="fw-bold mb-3">Grafik Penambahan Kosakata per Bulan</h5>
            <div id="chartKosakata" style="height: 350px;"></div>
        </div>
    </div>
</div>

{{-- BAR CHART PER KAMUS — GABUNG --}}
<div class="row mt-4">
    <div class="col-12">
        <div class="card shadow-sm border-0 rounded-4 p-4">
            <h5 class="fw-bold mb-3">Perbandingan Jumlah Kosakata per Kamus</h5>
            <div id="barChartAll" style="height: 380px;"></div>
        </div>
    </div>
</div>


@endsection

@section('scripts')

{{-- DONUT CHART --}}

<script>
    document.addEventListener("DOMContentLoaded", function() {
        var donutChart = new ApexCharts(document.querySelector("#donutChart"), {
            chart: {
                type: 'donut',
                height: 180,
            },
            series: @json($chartCounts),
            labels: @json($chartNames),
            colors: ['#696cff', '#ff0084ff', '#56ca00', '#ffab00'],
            stroke: {
                width: 4,
                colors: ['#fff']
            },
            dataLabels: {
                enabled: false
            },
            legend: {
                show: false
            },
            plotOptions: {
                pie: {
                    donut: {
                        size: '75%',
                        labels: {
                            show: true,
                            total: {
                                show: true,
                                label: 'Total',
                                formatter: () => "{{ array_sum($chartCounts) }}"
                            }
                        }
                    }
                }
            }
        });

        donutChart.render();
    });
</script>

{{-- LINE CHART --}}
<script>
    document.addEventListener("DOMContentLoaded", function() {
        var chart = new ApexCharts(document.querySelector("#chartKosakata"), {
            chart: {
                type: "line",
                height: 500
            },
            series: [{
                name: "Kosakata",
                data: @json($monthlyData)
            }],
            stroke: {
                width: 3,
                curve: 'smooth'
            },
            xaxis: {
                categories: ["Jan", "Feb", "Mar", "Apr", "Mei", "Jun", "Jul", "Agu", "Sep", "Okt", "Nov", "Des"]
            },
            colors: ['#696cff']
        });

        chart.render();
    });
</script>

{{-- BAR CHART GABUNG --}}
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const colors = [
            "#696cff", "#ff6384", "#36a2eb", "#ff9f40", "#4bc0c0",
            "#9966ff", "#ffcd56", "#28c76f", "#ea5455", "#6f42c1"
        ];

        new ApexCharts(document.querySelector("#barChartAll"), {
            chart: {
                type: "bar",
                height: 380
            },
            series: [{
                name: "Total Kosakata",
                data: @json($chartCounts)
            }],
            xaxis: {
                categories: @json($chartNames),
                labels: {
                    rotate: -15,
                    style: {
                        fontSize: "12px",
                        fontWeight: 500
                    }
                }
            },
            colors: colors.slice(0, @json(count($chartCounts))), // ✅ potong sesuai jumlah data
            plotOptions: {
                bar: {
                    borderRadius: 6,
                    columnWidth: "45%",
                    distributed: true // ✅ warna berbeda tiap bar
                }
            },
            grid: {
                strokeDashArray: 4,
                borderColor: "#e6e6e6"
            },
            dataLabels: {
                enabled: true
            }
        }).render();
    });
</script>


@endsection