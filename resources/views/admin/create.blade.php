<style>
    .btn-kamus {
        height: 42px !important;
        display: flex;
        align-items: center;
    }
</style>

<style>
    /* Toolbar */
    .toolbar {
        background: #ffffff;
        border: 1px solid #e5e7eb;
        border-radius: 12px;
        padding: 14px 16px;
    }

    .toolbar .form-control,
    .toolbar .form-select {
        height: 42px;
        border-radius: 10px;
        font-size: 14px;
    }

    .toolbar .btn {
        height: 42px;
        border-radius: 10px;
        font-weight: 500;
        white-space: nowrap;
    }

    .toolbar .btn-danger {
        background: #ef4444;
        border: none;
    }

    .toolbar .btn-danger:hover {
        background: #dc2626;
    }

    .btn-excel {
        background: #1D6F42;
        color: #fff;
        border: none;
    }

    .btn-excel:hover {
        background: #166534;
        color: #fff;
    }

    /* Input search icon feel */
    .search-wrapper {
        position: relative;
    }

    .search-wrapper i {
        position: absolute;
        left: 12px;
        top: 50%;
        transform: translateY(-50%);
        color: #9ca3af;
    }

    .search-wrapper input {
        padding-left: 36px;
    }
</style>


<div class="card-body">
    <form method="GET"
          action="{{ route('admin.kamus') }}"
          id="filterForm"
          class="toolbar d-flex flex-wrap align-items-center justify-content-between gap-3">

        <input type="hidden" name="page" value="{{ request('page', 1) }}">

        {{-- LEFT SIDE --}}
        <div class="d-flex flex-wrap align-items-center gap-2">

            {{-- SEARCH --}}
            <div class="search-wrapper">
                <i class="bx bx-search"></i>
                <input type="text"
                       name="search"
                       id="searchInput"
                       value="{{ request('search') }}"
                       class="form-control"
                       style="width: 260px;"
                       placeholder="Cari kata atau arti...">
            </div>

            {{-- FILTER ASAL KAMUS --}}
            <select id="asalKamusSelect"
                    name="asal_kamus"
                    class="form-select"
                    style="width: 220px;">
                <option value="">Semua Kamus</option>
                @foreach(($asalKamusList ?? $daftarAsalKamus) as $asal)
                    <option value="{{ $asal }}"
                        {{ request('asal_kamus') == $asal ? 'selected' : '' }}>
                        {{ $asal }}
                    </option>
                @endforeach
            </select>

            {{-- FILTER KELAS KATA --}}
            <select name="kelas_kata"
                    id="kelasKataSelect"
                    class="form-select"
                    style="width: 180px;">
                <option value="">Semua Kelas</option>
                <option value="n" {{ request('kelas_kata') == 'n' ? 'selected' : '' }}>Nomina (n)</option>
                <option value="v" {{ request('kelas_kata') == 'v' ? 'selected' : '' }}>Verba (v)</option>
                <option value="a" {{ request('kelas_kata') == 'a' ? 'selected' : '' }}>Adjektiva (a)</option>
                <option value="adv" {{ request('kelas_kata') == 'adv' ? 'selected' : '' }}>Adverbia (adv)</option>
            </select>

            {{-- RESET --}}
            <a href="{{ route('admin.kamus') }}"
               class="btn btn-outline-secondary">
                <i class="bx bx-reset"></i>
            </a>

            {{-- DELETE SELECTED --}}
            <button type="button"
                    id="btnDeleteSelected"
                    class="btn btn-danger">
                <i class="bx bx-trash me-1"></i>
                Hapus
            </button>
        </div>

        {{-- RIGHT SIDE --}}
        <div class="d-flex align-items-center gap-2">

            {{-- IMPORT --}}
            <button type="button"
                    class="btn btn-excel shadow-sm"
                    data-bs-toggle="modal"
                    data-bs-target="#importModal">
                <i class="bx bxl-microsoft me-1"></i>
                Import Excel
            </button>

            {{-- TAMBAH --}}
            <button type="button"
                    class="btn btn-primary shadow-sm"
                    data-bs-toggle="modal"
                    data-bs-target="#createModal">
                <i class="bx bx-plus me-1"></i>
                Tambah Data Kamus
            </button>

        </div>
    </form>
</div>
