<style>
    .btn-kamus {
        height: 42px !important;
        display: flex;
        align-items: center;
    }
</style>

<div class="card-body">
    {{-- 🔍 Form Pencarian, Filter, Reset & Tambah Data --}}
    <form method="GET" action="{{ route('admin.kamus') }}" id="filterForm"
        class="d-flex flex-wrap justify-content-between align-items-center mb-4 gap-3">

        <input type="hidden" name="page" value="{{ request('page', 1) }}">

        <!-- Bagian Kiri -->
        <div class="d-flex flex-wrap align-items-center gap-2 flex-grow-1" style="min-width: 500px;">

            <!-- Search -->
            <div class="input-group" style="max-width: 300px;">
                <input type="text" name="search" id="searchInput"
                    value="{{ request('search') }}"
                    class="form-control"
                    placeholder="Cari kata atau arti...">
            </div>
            
            <!-- Filter Asal Kamus -->
            <select id="asalKamusSelect" name="asal_kamus" class="form-select" style="max-width: 220px;">
                <option value="">Semua Kamus...</option>

                @foreach(($asalKamusList ?? $daftarAsalKamus) as $asal)
                <option value="{{ $asal }}"
                    {{ request('asal_kamus') == $asal ? 'selected' : '' }}>
                    {{ $asal }}
                </option>
                @endforeach
            </select>

            <!-- Filter Kelas Kata -->
            <select name="kelas_kata" id="kelasKataSelect"
                class="form-select"
                style="max-width: 170px;">
                <option value="">Semua Kelas Kata</option>
                <option value="n" {{ request('kelas_kata') == 'n' ? 'selected' : '' }}>n (Nomina)</option>
                <option value="v" {{ request('kelas_kata') == 'v' ? 'selected' : '' }}>v (Verba)</option>
                <option value="a" {{ request('kelas_kata') == 'a' ? 'selected' : '' }}>a (Adjektiva)</option>
                <option value="adv" {{ request('kelas_kata') == 'adv' ? 'selected' : '' }}>adv (Adverbia)</option>
            </select>

            <!-- Reset -->
            <a href="{{ route('admin.kamus') }}" class="btn btn-secondary">
                <i class="bx bx-reset"></i> Reset
            </a>
            <!-- Hapus Terpilih -->
            <button type="button" id="btnDeleteSelected" class="btn btn-danger">
                <i class="bx bx-trash me-1"></i> Hapus Terpilih
            </button>

            <!-- Bagian Kanan -->
            <div class="d-flex align-items-center gap-2 flex-shrink-0">

                <!-- Import Data Excel -->
                <button type="button" class="btn shadow-sm"
                    style="background-color:#1D6F42; color:white; border:none;"
                    data-bs-toggle="modal" data-bs-target="#importModal">
                    <i class="bx bxl-microsoft me-1"></i> Import Data Excel
                </button>

                <!-- Tambah Data -->
                <button type="button" class="btn btn-primary shadow-sm"
                    data-bs-toggle="modal" data-bs-target="#createModal">
                    <i class="bx bx-plus me-1"></i> Tambah Data
                </button>

            </div>

        </div>
    </form>
</div>