@extends('layouts.admin')

@section('title', 'Data Kamus Istilah')

@section('content')
<div class="container-xxl flex-grow-1 pt-0 pb-3 mt-n1">
    <div class="mx-n4">
        <div class="card shadow-sm border-0">
            {{-- HEADER --}}
            <div class="card-header bg-light d-flex justify-content-between align-items-center flex-wrap gap-3">
                <div class="d-flex align-items-center">
                    <i class="bx bx-book fs-4 text-primary me-2"></i>
                    <h5 class="mb-0">Data Kamus Istilah</h5>
                </div>
            </div>
            {{-- BODY --}}
            <div class="card-body">

                {{-- FILTER BAR (NONAKTIF – SAMA SEPERTI DATATABEL) --}}
                <style>
                    .toolbar {
                        background: #ffffff;
                        border: 1px solid #e5e7eb;
                        border-radius: 12px;
                        padding: 14px 16px;
                        margin-bottom: 16px;
                    }

                    .toolbar .form-control,
                    .toolbar .form-select,
                    .toolbar .btn {
                        height: 42px;
                        border-radius: 10px;
                        font-size: 14px;
                    }

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

                <form method="GET"
                    action="{{ route('admin.kamus-istilah.dataistilah') }}"
                    class="toolbar d-flex flex-wrap align-items-center justify-content-between gap-3">

                    {{-- LEFT --}}
                    <div class="d-flex flex-wrap align-items-center gap-2">

                        {{-- SEARCH --}}
                        <div class="search-wrapper">
                            <i class="bx bx-search"></i>
                            <input type="text"
                                name="search"
                                value="{{ request('search') }}"
                                class="form-control"
                                style="width:260px"
                                placeholder="Cari entri atau makna…">
                        </div>

                        {{-- FILTER KELAS KATA --}}
                        <select name="kelas_kata"
                            id="kelasKataSelect"
                            class="form-select"
                            style="width:180px">

                            <option value="">Semua Kelas Kata</option>

                            @foreach ($kelasKataList as $kelas)
                            <option value="{{ $kelas }}"
                                {{ request('kelas_kata') == $kelas ? 'selected' : '' }}>
                                {{ strtoupper($kelas) }}
                            </option>
                            @endforeach
                        </select>

                        {{-- RESET --}}
                        <a href="{{ route('admin.kamus-istilah.dataistilah') }}"
                            class="btn btn-outline-secondary">
                            <i class="bx bx-reset"></i>
                        </a>

                        {{-- DELETE SELECTED --}}
                        <button type="button"
                            id="btnBulkDelete"
                            class="btn btn-danger">
                            <i class="bx bx-trash me-1"></i>
                            Hapus
                        </button>
                    </div>
                    <div class="d-flex gap-2">
                        <button class="btn btn-primary shadow-sm"
                            data-bs-toggle="modal"
                            data-bs-target="#modalTambahIstilah">
                            <i class="bx bx-plus"></i> Tambah Data Istilah
                        </button>

                        <button class="btn btn-success"
                            data-bs-toggle="modal"
                            data-bs-target="#modalImportIstilah" style="background-color: #1D6F42; border-color: #1D6F42;">
                            <i class="bx bxl-microsoft"></i> Import Excel
                        </button>
                    </div>
                </form>

                {{-- TABLE --}}
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">

                        <thead class="table-light">
                            <tr class="text-center">
                                <th style="width:4%">
                                    <input type="checkbox" id="checkAll">
                                </th>
                                <th>ENTRI</th>
                                <th>KELAS</th>
                                <th class="text-start">MAKNA</th>
                                <th style="width:120px">AKSI</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse ($data as $item)
                            <tr>

                                {{-- CHECKBOX --}}
                                <td class="text-center">
                                    <input type="checkbox"
                                        class="row-check"
                                        value="{{ $item->id }}">
                                </td>

                                {{-- ENTRI --}}
                                <td class="text-center">
                                    <span class="badge bg-primary-subtle text-primary fw-semibold px-3 py-2 rounded-pill">
                                        {{ $item->entri }}
                                    </span>
                                </td>

                                {{-- KELAS --}}
                                <td class="text-center">
                                    <span class="badge bg-info-subtle text-info fw-semibold px-3 py-2 rounded-pill">
                                        {{ strtoupper($item->kelas_kata ?? '-') }}
                                    </span>
                                </td>

                                {{-- MAKNA --}}
                                <td class="text-start text-muted text-truncate"
                                    style="max-width:420px"
                                    title="{{ $item->makna_entri }}">
                                    {{ $item->makna_entri }}
                                </td>

                                {{-- AKSI --}}
                                <td class="text-center">
                                    <div class="d-inline-flex gap-1">

                                        <button class="btn btn-outline-primary btn-sm"
                                            onclick="showDetail(this)"

                                            data-entri="{{ $item->entri }}"
                                            data-lafal="{{ $item->lafal }}"
                                            data-kelas="{{ $item->kelas_kata }}"
                                            data-makna="{{ $item->makna_entri }}"

                                            data-kode="{{ $item->kode_entri }}"
                                            data-bahasa="{{ $item->bahasa_daerah }}"
                                            data-sumber="{{ $item->sumber }}"
                                            data-jenis="{{ $item->jenis }}"
                                            data-label="{{ $item->label_bahasa }}">


                                            <i class="bx bx-show"></i>
                                        </button>

                                        <button class="btn btn-outline-warning btn-sm"
                                            onclick="editData(this)"

                                            data-id="{{ $item->id }}"
                                            data-entri="{{ $item->entri }}"
                                            data-lafal="{{ $item->lafal }}"
                                            data-kelas="{{ $item->kelas_kata }}"
                                            data-makna="{{ $item->makna_entri }}"

                                            data-kode="{{ $item->kode_entri }}"
                                            data-bahasa="{{ $item->bahasa_daerah }}"
                                            data-sumber="{{ $item->sumber }}"
                                            data-jenis="{{ $item->jenis }}"
                                            data-label="{{ $item->label_bahasa }}">

                                            <i class="bx bx-edit"></i>
                                        </button>

                                        <button class="btn btn-outline-danger btn-sm"
                                            onclick="deleteData({{ $item->id }})"
                                            title="Hapus">
                                            <i class="bx bx-trash"></i>
                                        </button>

                                    </div>
                                </td>

                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="text-center text-muted py-4">
                                    <i class="bx bx-info-circle me-1"></i>
                                    Tidak ada data istilah
                                </td>
                            </tr>
                            @endforelse
                        </tbody>

                    </table>
                </div>

                {{-- PAGINATION --}}
                @include('admin.pagination', ['paginator' => $data])

            </div>
        </div>
    </div>
</div>

{{-- ================= MODAL DETAIL ================= --}}
<div class="modal fade" id="detailModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">

        <div class="modal-content">

            {{-- HEADER --}}
            <div class="modal-header bg-primary-subtle">
                <h5 class="modal-title text-primary fw-semibold">
                    <i class="bx bx-show-alt me-1"></i> Detail Istilah
                </h5>
                <button type="button"
                    class="btn-close"
                    data-bs-dismiss="modal"
                    aria-label="Close"></button>
            </div>

            {{-- BODY --}}
            <div class="modal-body">

                {{-- INFORMASI UTAMA --}}
                <div class="row g-3 mb-3">

                    <div class="col-md-6">
                        <div class="small text-secondary">Entri</div>
                        <div class="fw-semibold fs-6" id="d_entri">-</div>
                    </div>

                    <div class="col-md-6">
                        <div class="small text-secondary">Lafal</div>
                        <div class="fw-semibold fs-6" id="d_lafal">-</div>
                    </div>

                    <div class="col-md-6">
                        <div class="small text-secondary">Kelas Kata</div>
                        <div class="fw-semibold fs-6 text-uppercase" id="d_kelas">-</div>
                    </div>

                </div>

                <hr>

                {{-- MAKNA --}}
                <div class="mb-4">
                    <div class="small text-secondary mb-1">Makna</div>
                    <div id="d_makna"
                        class="text-muted"
                        style="white-space: pre-line;">
                        -
                    </div>
                </div>

                <hr>

                {{-- INFORMASI TAMBAHAN --}}
                <h6 class="fw-semibold text-secondary mb-3">
                    Informasi Tambahan
                </h6>

                <div class="row g-3 small">

                    <div class="col-md-6">
                        <div class="text-secondary">Kode Entri</div>
                        <div class="fw-medium" id="d_kode">-</div>
                    </div>

                    <div class="col-md-6">
                        <div class="text-secondary">Bahasa Daerah</div>
                        <div class="fw-medium" id="d_bahasa">-</div>
                    </div>

                    <div class="col-md-6">
                        <div class="text-secondary">Sumber</div>
                        <div class="fw-medium" id="d_sumber">-</div>
                    </div>

                    <div class="col-md-6">
                        <div class="text-secondary">Jenis</div>
                        <div class="fw-medium" id="d_jenis">-</div>
                    </div>

                    <div class="col-12">
                        <div class="text-secondary">Label Bahasa</div>
                        <div class="fw-medium" id="d_label">-</div>
                    </div>

                </div>

            </div>

            {{-- FOOTER --}}
            <div class="modal-footer bg-light">
                <button type="button"
                    class="btn btn-secondary"
                    data-bs-dismiss="modal">
                    Tutup
                </button>
            </div>

        </div>
    </div>
</div>


{{-- ================= MODAL EDIT ================= --}}
<div class="modal fade" id="editModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">

        <form id="editForm" class="modal-content">

            {{-- HEADER --}}
            <div class="modal-header bg-warning-subtle">
                <h5 class="modal-title text-warning fw-semibold">
                    <i class="bx bx-edit me-1"></i> Edit Istilah
                </h5>
                <button type="button"
                    class="btn-close"
                    data-bs-dismiss="modal"
                    aria-label="Close"></button>
            </div>

            {{-- BODY --}}
            <div class="modal-body">

                <input type="hidden" id="edit_id">

                {{-- BAGIAN UTAMA --}}
                <div class="row g-3 mb-3">

                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Entri</label>
                        <input type="text"
                            id="edit_entri"
                            class="form-control">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Lafal</label>
                        <input type="text"
                            id="edit_lafal"
                            class="form-control">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Kelas Kata</label>
                        <input type="text"
                            id="edit_kelas"
                            class="form-control">
                    </div>

                </div>

                <div class="mb-4">
                    <label class="form-label fw-semibold">Makna</label>
                    <textarea id="edit_makna"
                        rows="4"
                        class="form-control"></textarea>
                </div>

                <hr>

                {{-- INFORMASI TAMBAHAN --}}
                <h6 class="fw-semibold text-secondary mb-3">
                    Informasi Tambahan
                </h6>

                <div class="row g-3">

                    <div class="col-md-6">
                        <label class="form-label">Kode Entri</label>
                        <input id="edit_kode" class="form-control">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Bahasa Daerah</label>
                        <input id="edit_bahasa" class="form-control">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Sumber</label>
                        <input id="edit_sumber" class="form-control">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Jenis</label>
                        <input id="edit_jenis" class="form-control">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Label Bahasa</label>
                        <input id="edit_label" class="form-control">
                    </div>

                </div>

            </div>

            {{-- FOOTER --}}
            <div class="modal-footer bg-light">
                <button type="button"
                    class="btn btn-secondary"
                    data-bs-dismiss="modal">
                    Batal
                </button>

                <button type="submit"
                    class="btn btn-warning">
                    <i class="bx bx-save me-1"></i> Simpan Perubahan
                </button>
            </div>

        </form>
    </div>
</div>


{{-- ================= MODAL IMPORT EXCEL ================= --}}
<div class="modal fade" id="modalImportIstilah" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg rounded-4">

            {{-- HEADER --}}
            <div class="modal-header border-0 px-4 py-3"
                style="background:#1D6F42;">
                <div>
                    <h5 class="fw-bold mb-0 text-white">
                        <i class="bx bxl-microsoft me-1"></i>
                        Import Data Istilah
                    </h5>
                    <small class="text-white-50">
                        Upload → Import
                    </small>
                </div>
                <button type="button"
                    class="btn-close btn-close-white"
                    data-bs-dismiss="modal"></button>
            </div>

            <form method="POST"
                action="{{ route('admin.kamus-istilah.import') }}"
                enctype="multipart/form-data">
                @csrf

                <div class="modal-body px-4 py-4">
                    <div class="row g-4">

                        {{-- LEFT --}}
                        <div class="col-md-5">
                            <div class="border rounded-4 p-4 h-100">

                                <h6 class="fw-bold mb-3" style="color:#1f8f55;">
                                    <i class="bx bx-info-circle me-1"></i>
                                    Panduan Import
                                </h6>

                                <ul class="text-muted small mb-3">
                                    <li>Format file: <strong>.xlsx</strong></li>
                                    <li>Baris pertama wajib header</li>
                                    <li>Data kosong akan ditolak</li>
                                </ul>

                                <p class="small fw-semibold mb-2">Kolom wajib:</p>

                                <div class="d-flex flex-wrap gap-2 mb-4">
                                    @foreach ([
                                    'kode_entri','bahasa_daerah','sumber',
                                    'entri','jenis','lafal',
                                    'kelas_kata','label_bahasa','makna_entri'
                                    ] as $col)
                                    <span class="badge text-white"
                                        style="background:#22c55e;">
                                        {{ $col }}
                                    </span>
                                    @endforeach
                                </div>

                                <a href="{{ route('admin.kamus-istilah.template') }}"
                                    class="btn btn-outline-success w-100">
                                    <i class="bx bx-download me-1"></i>
                                    Download Template
                                </a>
                            </div>
                        </div>

                        {{-- RIGHT --}}
                        <div class="col-md-7">
                            <div class="border rounded-4 p-4 h-100 text-center">

                                <h6 class="fw-bold mb-3 text-start"
                                    style="color:#1f8f55;">
                                    <i class="bx bx-upload me-1"></i>
                                    Upload File Excel
                                </h6>

                                <label for="fileImport"
                                    class="w-100 rounded-4 p-5
                                              d-flex flex-column
                                              align-items-center
                                              justify-content-center
                                              cursor-pointer"
                                    style="border:2px dashed #22c55e;">

                                    <i class="bx bx-cloud-upload fs-1 mb-2"
                                        style="color:#22c55e;"></i>

                                    <p class="mb-1 fw-semibold">
                                        Drag & Drop file di sini
                                    </p>
                                    <small class="text-muted">
                                        atau klik untuk memilih file
                                    </small>

                                    <input type="file"
                                        id="fileImport"
                                        name="file"
                                        accept=".xlsx,.xls"
                                        class="d-none"
                                        required>

                                    <small class="text-muted d-block mt-3">
                                        Format didukung: .xlsx
                                    </small>
                            </div>
                        </div>

                    </div>
                </div>

                {{-- FOOTER --}}
                <div class="modal-footer bg-light px-4 py-3">
                    <button type="submit"
                        class="btn text-white"
                        style="background:#1D6F42;">
                        <i class="bx bx-check-circle me-1"></i>
                        Import Sekarang
                    </button>
                </div>
            </form>

        </div>
    </div>
</div>


{{-- ================= MODAL TAMBAH ISTILAH ================= --}}
<div class="modal fade" id="modalTambahIstilah" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <form method="POST"
            action="{{ route('admin.kamus-istilah.store') }}"
            class="modal-content">
            @csrf

            <div class="modal-header">
                <h5 class="modal-title text-primary">
                    <i class="bx bx-plus-circle me-1"></i> Tambah Istilah
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body row g-3">

                <div class="col-md-6">
                    <label class="form-label">Kode Entri</label>
                    <input type="text" name="kode_entri" class="form-control">
                </div>

                <div class="col-md-6">
                    <label class="form-label">Bahasa Daerah</label>
                    <input type="text" name="bahasa_daerah" class="form-control">
                </div>

                <div class="col-md-6">
                    <label class="form-label">Sumber</label>
                    <input type="text" name="sumber" class="form-control">
                </div>

                <div class="col-md-6">
                    <label class="form-label">Jenis</label>
                    <input type="text" name="jenis" class="form-control">
                </div>

                <div class="col-md-6">
                    <label class="form-label">Entri <span class="text-danger">*</span></label>
                    <input type="text" name="entri" class="form-control" required>
                </div>

                <div class="col-md-6">
                    <label class="form-label">Lafal</label>
                    <input type="text" name="lafal" class="form-control">
                </div>

                <div class="col-md-6">
                    <label class="form-label">Kelas Kata</label>
                    <select name="kelas_kata" class="form-select">
                        <option value="">Pilih Kelas Kata</option>

                        <option value="n">Nomina (n)</option>
                        <option value="v">Verba (v)</option>
                        <option value="adj">Adjektiva (adj)</option>
                        <option value="adv">Adverbia (adv)</option>
                        <option value="pron">Pronomina (pron)</option>
                        <option value="num">Numeralia (num)</option>
                        <option value="prep">Preposisi (prep)</option>
                        <option value="konj">Konjungsi (konj)</option>
                        <option value="interj">Interjeksi (interj)</option>
                        <option value="part">Partikel (part)</option>
                    </select>
                </div>

                <div class="col-md-6">
                    <label class="form-label">Label Bahasa</label>
                    <select name="kelas_kata" class="form-select">
                        <option value="">Pilih Label Bahasa</option>
                        <option value="Ri">Ri</option>
                    </select>
                </div>

                <div class="col-12">
                    <label class="form-label">Makna Entri <span class="text-danger">*</span></label>
                    <textarea name="makna_entri" rows="4" class="form-control" required></textarea>
                </div>

            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    Batal
                </button>
                <button type="submit" class="btn btn-primary">
                    <i class="bx bx-save me-1"></i> Simpan
                </button>
            </div>
        </form>
    </div>
</div>


<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {

        /* ===============================
           ELEMENTS
        ================================ */
        const toolbarForm = document.querySelector('.toolbar');
        const searchInput = document.querySelector('input[name="search"]');
        const kelasSelect = document.querySelector('select[name="kelas_kata"]');

        const checkAll = document.getElementById('checkAll');
        const btnBulkDelete = document.getElementById('btnBulkDelete');

        let debounceTimer = null;

        /* ===============================
           STOP FORM SUBMIT (WAJIB)
        ================================ */
        if (toolbarForm) {
            toolbarForm.addEventListener('submit', e => e.preventDefault());
            toolbarForm.addEventListener('keydown', e => {
                if (e.key === 'Enter') e.preventDefault();
            });
        }

        /* ===============================
           AUTO FILTER (SERVER SIDE)
        ================================ */
        function applyFilter() {
            const params = new URLSearchParams();

            if (searchInput && searchInput.value.trim() !== '') {
                params.set('search', searchInput.value.trim());
            }

            if (kelasSelect && kelasSelect.value !== '') {
                params.set('kelas_kata', kelasSelect.value);
            }

            // reset pagination
            params.delete('page');

            window.location.href = `?${params.toString()}`;
        }

        /* 🔍 SEARCH REALTIME (DEBOUNCE) */
        if (searchInput) {
            searchInput.addEventListener('input', function() {
                clearTimeout(debounceTimer);
                debounceTimer = setTimeout(applyFilter, 400);
            });
        }

        /* 🔽 FILTER SELECT REALTIME */
        if (kelasSelect) {
            kelasSelect.addEventListener('change', applyFilter);
        }

        /* ===============================
           CHECKBOX & BULK STATE
        ================================ */
        function getRowChecks() {
            return document.querySelectorAll('.row-check');
        }

        function toggleBulkButton() {
            const anyChecked = [...getRowChecks()].some(cb => cb.checked);
            if (btnBulkDelete) btnBulkDelete.disabled = !anyChecked;
        }

        if (checkAll) {
            checkAll.addEventListener('change', () => {
                getRowChecks().forEach(cb => cb.checked = checkAll.checked);
                toggleBulkButton();
            });
        }

        document.addEventListener('change', e => {
            if (e.target.classList.contains('row-check')) {
                toggleBulkButton();
            }
        });

        /* ===============================
           BULK DELETE (SWEETALERT)
        ================================ */
        if (btnBulkDelete) {
            btnBulkDelete.addEventListener('click', () => {

                const ids = [...getRowChecks()]
                    .filter(cb => cb.checked)
                    .map(cb => cb.value);

                if (!ids.length) return;

                Swal.fire({
                    title: 'Hapus data terpilih?',
                    text: `${ids.length} data akan dihapus permanen`,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: 'Ya, hapus'
                }).then(result => {
                    if (!result.isConfirmed) return;

                    fetch(`{{ route('admin.kamus-istilah.bulk-delete') }}`, {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                'Content-Type': 'application/json'
                            },
                            body: JSON.stringify({
                                ids
                            })
                        })
                        .then(res => res.json())
                        .then(() => {
                            Swal.fire('Berhasil', 'Data terpilih dihapus', 'success')
                                .then(() => location.reload());
                        });
                });
            });
        }

    });

    /* ===============================
       MODAL DETAIL (GLOBAL)
    =============================== */
    window.showDetail = function(btn) {
        document.getElementById('d_entri').innerText = btn.dataset.entri ?? '-';
        document.getElementById('d_lafal').innerText = btn.dataset.lafal ?? '-';
        document.getElementById('d_kelas').innerText = btn.dataset.kelas ?? '-';
        document.getElementById('d_makna').innerText = btn.dataset.makna ?? '-';
        document.getElementById('d_kode').innerText = btn.dataset.kode ?? '-';
        document.getElementById('d_bahasa').innerText = btn.dataset.bahasa ?? '-';
        document.getElementById('d_sumber').innerText = btn.dataset.sumber ?? '-';
        document.getElementById('d_jenis').innerText = btn.dataset.jenis ?? '-';
        document.getElementById('d_label').innerText = btn.dataset.label ?? '-';

        bootstrap.Modal.getOrCreateInstance(
            document.getElementById('detailModal')
        ).show();
    };


    /* ===============================
       MODAL EDIT (GLOBAL)
    =============================== */
    window.editData = function(btn) {
        document.getElementById('edit_id').value = btn.dataset.id;
        document.getElementById('edit_entri').value = btn.dataset.entri ?? '';
        document.getElementById('edit_lafal').value = btn.dataset.lafal ?? '';
        document.getElementById('edit_kelas').value = btn.dataset.kelas ?? '';
        document.getElementById('edit_makna').value = btn.dataset.makna ?? '';

        document.getElementById('edit_kode').value = btn.dataset.kode ?? '';
        document.getElementById('edit_bahasa').value = btn.dataset.bahasa ?? '';
        document.getElementById('edit_sumber').value = btn.dataset.sumber ?? '';
        document.getElementById('edit_jenis').value = btn.dataset.jenis ?? '';
        document.getElementById('edit_label').value = btn.dataset.label ?? '';

        bootstrap.Modal.getOrCreateInstance(
            document.getElementById('editModal')
        ).show();
    };

    /* ===============================
       SUBMIT EDIT
    =============================== */
    document.getElementById('editForm')?.addEventListener('submit', function(e) {
        e.preventDefault();

        fetch(`/admin/kamus-istilah/${edit_id.value}`, {
                method: 'PUT',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    entri: edit_entri.value,
                    lafal: edit_lafal.value,
                    kelas_kata: edit_kelas.value,
                    makna_entri: edit_makna.value,
                    kode_entri: edit_kode.value,
                    bahasa_daerah: edit_bahasa.value,
                    sumber: edit_sumber.value,
                    jenis: edit_jenis.value,
                    label_bahasa: edit_label.value
                })

            })
            .then(res => res.json())
            .then(() => {
                Swal.fire('Berhasil', 'Data berhasil diperbarui', 'success')
                    .then(() => location.reload());
            });
    });

    /* ===============================
       DELETE SINGLE
    =============================== */
    window.deleteData = function(id) {
        Swal.fire({
            title: 'Yakin hapus data ini?',
            text: 'Data tidak bisa dikembalikan',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Ya, hapus'
        }).then(result => {
            if (!result.isConfirmed) return;

            fetch(`/admin/kamus-istilah/${id}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                })
                .then(res => res.json())
                .then(() => {
                    Swal.fire('Berhasil', 'Data berhasil dihapus', 'success')
                        .then(() => location.reload());
                });
        });
    };
</script>

<script>
    document.getElementById('fileImport').addEventListener('change', function() {
        const fileName = this.files[0]?.name;
        if (fileName) {
            this.closest('label').querySelector('small').innerText = fileName;
        }
    });
</script>

@endsection