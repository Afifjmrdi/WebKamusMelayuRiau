@extends('layouts.admin')

@section('title', 'Dashboard Admin')

@section('content')

<style>
    .donut-wrap {
        width: 170px;
        height: 170px;
        position: relative;
    }

    #donutChart {
        width: 100% !important;
        height: 100% !important;
    }

    .donut-center {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        pointer-events: none;
    }

    .donut-wrap:hover .donut-center {
        opacity: 0;
    }

    .donut-center h4 {
        font-size: 1.6rem;
        line-height: 1.2;
    }
</style>

{{-- HERO --}}
<div class="position-relative mb-4">
    <div class="card border-0 shadow-lg rounded-4 overflow-hidden text-white"
        style="background: url('{{ asset('assets/dashboard1.png') }}') no-repeat center/cover; min-height: 170px;">

        <div class="p-4 d-flex justify-content-between align-items-center flex-wrap gap-4">

            {{-- LEFT : GREETING --}}
            <div>
                <h1 class="fw-bold text-white mb-2">
                    Halo {{ $admin->name ?? 'Admin' }}!
                </h1>
                <h5 class="fs-5 opacity-75 mb-0 text-white mt-4">
                    Selamat Datang,
                    <h5 class="text-white pt-2">mohon cek update pengajuan selalu ya.</h5>
                </h5>
            </div>

            {{-- RIGHT : STAT BOX --}}
            <div class="d-flex flex-wrap gap-3">

                {{-- KOREKSI DITERIMA --}}
                <div class="bg-dark bg-opacity-75 rounded-3 px-2 py-3 text-center text-white shadow-sm"
                    style="min-width:140px">
                    <div class="small fw-semibold">Total Pengunjung Kamus</div>
                    <div class="fs-4 fw-bold">{{ $totalVisitors }}</div>
                    <div class="small opacity-75">Pengunjung</div>
                </div>

                {{-- KOREKSI DITERIMA --}}
                <div class="bg-dark bg-opacity-75 rounded-3 px-2 py-3 text-center text-white shadow-sm"
                    style="min-width:140px">
                    <div class="small fw-semibold">Pengajuan Koreksi</div>
                    <div class="fs-4 fw-bold">{{ $koreksiDiterima }}</div>
                    <div class="small opacity-75">Diterima</div>
                </div>

                {{-- KOREKSI DITOLAK --}}
                <div class="bg-dark bg-opacity-75 rounded-3 px-2 py-3 text-center text-white shadow-sm"
                    style="min-width:140px">
                    <div class="small fw-semibold">Pengajuan Koreksi</div>
                    <div class="fs-4 fw-bold">{{ $koreksiDitolak }}</div>
                    <div class="small opacity-75">Ditolak</div>
                </div>

                {{-- AJUKAN DITERIMA --}}
                <div class="bg-white bg-opacity-75 rounded-3 px-2 py-3 text-center text-dark shadow-sm"
                    style="min-width:140px">
                    <div class="small fw-semibold">Pengajuan Kosakata</div>
                    <div class="fs-4 fw-bold">{{ $ajukanDiterima }}</div>
                    <div class="small opacity-75">Diterima</div>
                </div>

                {{-- AJUKAN DITOLAK --}}
                <div class="bg-white bg-opacity-75 rounded-3 px-2 py-3 text-center shadow-sm text-dark"
                    style="min-width:140px">
                    <div class="small fw-semibold">Pengajuan Kosakata</div>
                    <div class="fs-4 fw-bold">{{ $ajukanDitolak }}</div>
                    <div class="small opacity-75">Ditolak</div>
                </div>

            </div>
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
                    <h6 class="text-muted">Total Istilah</h6>
                    <h3 class="fw-bold">{{ $totalIstilah }}</h3>
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
    {{-- LINE CHART --}}
    <div class="col-md-8">
        <div class="card shadow-sm border-0 rounded-4 p-4">
            <h5 class="fw-bold mb-3">Grafik Penambahan Kosakata per Bulan</h5>
            <div id="chartKosakata" style="height: 350px;"></div>
        </div>
    </div>

    {{-- DONUT CHART --}}
    <div class="col-md-4">
        <div class="card shadow-sm border-0 rounded-4 p-4 h-100">

            {{-- HEADER --}}
            <div class="d-flex justify-content-between align-items-center mb-3">
                <div>
                    <h6 class="fw-bold mb-1 text-uppercase text-muted">
                        Statistik Kamus
                    </h6>
                    <small class="text-muted">
                        Total {{ array_sum($chartCounts) }} Kosakata
                    </small>
                </div>
            </div>

            {{-- DONUT + TOTAL --}}
            <div class="d-flex justify-content-center my-3">
                <div class="position-relative donut-wrap">

                    <canvas id="donutChart" width="170" height="170"></canvas>

                    {{-- CENTER TEXT (CUSTOM) --}}
                    <div class="donut-center text-center">
                        <h4 class="fw-bold mb-0">
                            {{ array_sum($chartCounts) }}
                        </h4>
                        <small class="text-muted">Kosakata</small>
                    </div>

                </div>
            </div>

            <hr class="my-4">

            {{-- LIST STATISTIK --}}
            <div class="d-flex flex-column gap-3">
                @foreach ($chartNames as $i => $name)
                <div class="d-flex justify-content-between align-items-center">

                    <div class="d-flex align-items-center gap-3">
                        <div class="rounded-3 d-flex align-items-center justify-content-center"
                            style="width:42px;height:42px;background:#eef2ff;">
                            <i class="bx bx-book fs-5 text-primary"></i>
                        </div>

                        <div>
                            <div class="fw-semibold">{{ $name }}</div>
                            <small class="text-muted">Jumlah kosakata</small>
                        </div>
                    </div>

                    <span class="fw-bold fs-6">
                        {{ $chartCounts[$i] }}
                    </span>
                </div>
                @endforeach
            </div>

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
    window.addEventListener("load", function() {

        const ctx = document.getElementById("donutChart");
        if (!ctx) return;

        new Chart(ctx, {
            type: "doughnut",
            data: {
                labels: @json($chartNames),
                datasets: [{
                    data: @json($chartCounts),
                    backgroundColor: [
                        "#6366F1",
                        "#22C55E",
                        "#EC4899",
                        "#F59E0B",
                        "#06B6D4",
                        "#8B5CF6"
                    ],
                    borderWidth: 4,
                    borderColor: "#ffffff",
                    hoverOffset: 8
                }]
            },
            options: {
                responsive: true,
                cutout: "70%",
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        enabled: true,
                        backgroundColor: "#111827",
                        padding: 12,
                        titleFont: {
                            size: 13,
                            weight: '600'
                        },
                        bodyFont: {
                            size: 12
                        },
                        callbacks: {
                            title: function(tooltipItems) {
                                const label = tooltipItems[0].label;

                                // 🔥 PECAH JADI DUA BARIS
                                if (label.includes("Indonesia-Melayu")) {
                                    return [
                                        "Kamus Indonesia-",
                                        label.replace("Kamus Indonesia-Melayu ", "Melayu ")
                                    ];
                                }

                                return label;
                            },
                            label: function(context) {
                                return "Jumlah: " + context.raw.toLocaleString("id-ID") + " kosakata";
                            }
                        }
                    }

                },
                animation: {
                    animateRotate: true,
                    duration: 900,
                    easing: "easeOutQuart"
                }
            }
        });

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