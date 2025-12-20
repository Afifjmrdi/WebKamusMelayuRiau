{{-- resources/views/admin/datakamus/datatabel.blade.php --}}
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const filterForm = document.getElementById('filterForm');
        if (!filterForm) return;

        const searchInput = document.getElementById('searchInput');
        const asalSelect = document.getElementById('asalKamusSelect');
        const kelasSelect = document.getElementById('kelasKataSelect');

        let timer = null;
        const submitFilter = () => {
            const pageInput = filterForm.querySelector('input[name="page"]');
            if (pageInput) pageInput.value = 1;
            filterForm.submit();
        };

        if (searchInput) {
            searchInput.addEventListener('input', function() {
                clearTimeout(timer);
                timer = setTimeout(submitFilter, 500);
            });
        }

        if (asalSelect) asalSelect.addEventListener('change', submitFilter);
        if (kelasSelect) kelasSelect.addEventListener('change', submitFilter);
    });
</script>

<style>
    /* Header tabel */
    .table thead th {
        background: #f8fafc;
        font-size: 12px;
        text-transform: uppercase;
        letter-spacing: .04em;
        color: #475569;
        border-bottom: 1px solid #e5e7eb;
        vertical-align: middle;
    }

    /* Row hover lembut */
    .table tbody tr {
        transition: background-color .15s ease;
    }

    .table tbody tr:hover {
        background-color: #f9fafb;
    }

    /* Arti truncate cantik */
    .text-truncate-td {
        max-width: 320px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        cursor: help;
    }

    /* Badge kata */
    .badge-kata {
        background: #eef2ff;
        color: #4338ca;
        font-weight: 600;
        padding: 6px 10px;
        border-radius: 8px;
        font-size: 13px;
    }

    /* Badge kelas kata */
    .badge-kelas {
        background: #e0f2fe;
        color: #0369a1;
        font-weight: 600;
        padding: 5px 10px;
        border-radius: 999px;
        font-size: 12px;
    }

    /* Tombol aksi */
    .table .btn {
        padding: 4px 8px;
    }

    /* Checkbox lebih rapi */
    input[type="checkbox"] {
        cursor: pointer;
    }
</style>

{{-- TABLE --}}
<div class="table-responsive">
    <table class="table table-hover align-middle mb-0">
        <thead>
            <tr class="text-center">
                <th style="width:4%">
                    <input type="checkbox" id="selectAllCheckbox">
                </th>
                <th>Kata</th>
                <th>Suku Kata</th>
                <th>Kelas</th>
                <th class="text-start">Arti</th>
                <th>Asal Kamus</th>
                <th>Tanggal</th>
                <th>Aksi</th>
            </tr>
        </thead>

        <tbody>
            @forelse ($dataKamus as $item)
            <tr>
                <td class="text-center">
                    <input type="checkbox" class="rowCheckbox" value="{{ $item->id }}">
                </td>

                <td class="text-center">
                    <span class="badge-kata">
                        {{ ucfirst($item->kata) }}
                    </span>
                </td>

                <td class="text-center text-muted">
                    {{ $item->suku_kata ?? '-' }}
                </td>

                <td class="text-center">
                    <span class="badge-kelas">
                        {{ strtoupper($item->kelas_kata) }}
                    </span>
                </td>

                <td class="text-start text-truncate-td"
                    data-bs-toggle="tooltip"
                    title="{{ $item->arti }}">
                    {{ $item->arti }}
                </td>

                <td class="text-center">
                    {{ $item->asal_kamus }}
                </td>

                <td class="text-center text-muted">
                    {{ optional($item->created_at)->format('d M Y') }}
                </td>

                <td class="text-center">
                    <div class="d-inline-flex gap-1">

                        {{-- DETAIL --}}
                        <button class="btn btn-outline-primary btn-sm"
                            data-bs-toggle="modal"
                            data-bs-target="#detailModal{{ $item->id }}"
                            title="Detail">
                            <i class="bx bx-show-alt"></i>
                        </button>

                        {{-- EDIT --}}
                        <button class="btn btn-outline-warning btn-sm"
                            data-bs-toggle="modal"
                            data-bs-target="#editModal{{ $item->id }}"
                            title="Edit">
                            <i class="bx bx-edit"></i>
                        </button>

                        {{-- DELETE --}}
                        <form action="{{ route('admin.destroy', $item->id) }}"
                            method="POST"
                            class="delete-form d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                class="btn btn-outline-danger btn-sm"
                                title="Hapus">
                                <i class="bx bx-trash"></i>
                            </button>
                        </form>

                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="8" class="text-center text-muted py-4">
                    <i class="bx bx-info-circle me-1"></i>
                    Tidak ada data kamus
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
<!-- Modal Import Excel -->
<div class="modal fade" id="importModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg rounded-4">

            {{-- HEADER --}}
            <div class="modal-header border-0 px-4 py-3"
                style="background:#1D6F42;">
                <div>
                    <h5 class="fw-bold mb-0 text-white">
                        <i class="bx bxl-microsoft me-1"></i>
                        Import Data Kosakata
                    </h5>
                    <small class="text-white-50">
                        Upload → Import
                    </small>
                </div>
                <button type="button"
                    class="btn-close btn-close-white"
                    data-bs-dismiss="modal"></button>
            </div>

            {{-- FORM --}}
            <form id="importForm"
                action="{{ route('admin.kamus.import.preview') }}"
                method="POST"
                enctype="multipart/form-data">
                @csrf

                {{-- BODY --}}
                <div class="modal-body px-4 py-4" style="background:#f6f8f7;">
                    <div class="row g-4">

                        {{-- PANDUAN --}}
                        <div class="col-md-5">
                            <div class="p-4 rounded-4 bg-white border h-100">

                                <h6 class="fw-bold mb-3" style="color:#1D6F42;">
                                    <i class="bx bx-info-circle me-1"></i>
                                    Panduan Import
                                </h6>

                                <ul class="small text-muted ps-3 mb-3">
                                    <li>Format file: <b>.xlsx</b></li>
                                    <li>Baris pertama wajib header</li>
                                    <li>Data kosong akan ditolak</li>
                                </ul>

                                <div class="small text-muted mb-2">
                                    Kolom wajib:
                                </div>

                                <div class="d-flex flex-wrap gap-2 mb-4">
                                    <span class="badge bg-success">kata</span>
                                    <span class="badge bg-success">kelas_kata</span>
                                    <span class="badge bg-success">arti</span>
                                    <span class="badge bg-success">contoh</span>
                                    <span class="badge bg-success">asal_kamus</span>
                                    <span class="badge bg-success">suku_kata</span>
                                </div>

                                {{-- DOWNLOAD TEMPLATE --}}
                                <a href="{{ route('admin.kamus.template') }}"
                                    class="btn btn-outline-success w-100 rounded-3">
                                    <i class="bx bx-download me-1"></i>
                                    Download Template Import
                                </a>
                            </div>
                        </div>

                        {{-- UPLOAD --}}
                        <div class="col-md-7">
                            <div class="p-4 rounded-4 bg-white border h-100">

                                <h6 class="fw-bold mb-3" style="color:#1D6F42;">
                                    <i class="bx bx-upload me-1"></i>
                                    Upload File Excel
                                </h6>

                                <div class="p-4 rounded-4 text-center border border-2"
                                    style="border-style:dashed; border-color:#1D6F42;">

                                    <i class="bx bx-cloud-upload fs-1 mb-2"
                                        style="color:#1D6F42;"></i>

                                    <p class="fw-semibold mb-1">
                                        Drag & Drop file di sini
                                    </p>

                                    <p class="small text-muted mb-3">
                                        atau klik untuk memilih file
                                    </p>

                                    <input type="file"
                                        name="file"
                                        class="form-control rounded-3"
                                        accept=".xlsx"
                                        required>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

                {{-- FOOTER --}}
                <div class="modal-footer border-0 px-4 py-3"
                    style="background:#f6f8f7;">

                    <!-- {{-- PREVIEW --}}
                    <button type="submit"
                        class="btn btn-outline-success px-4 fw-semibold">
                        <i class="bx bx-show me-1"></i>
                        Preview Data
                    </button> -->

                    {{-- IMPORT LANGSUNG --}}
                    <button type="button"
                        class="btn text-white px-4 fw-semibold"
                        style="background:#1D6F42;"
                        onclick="submitImport()">
                        <i class="bx bx-check-circle me-1"></i>
                        Import Sekarang
                    </button>

                </div>

            </form>
        </div>
    </div>
</div>

@foreach ($dataKamus as $item)
@includeIf('admin.modaldetail', ['item' => $item])
@includeIf('admin.modaledit', ['item' => $item])
@endforeach

{{-- Enable tooltip + handle delete confirmation --}}

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Tooltip
        document.querySelectorAll('[data-bs-toggle="tooltip"]').forEach(el => {
            new bootstrap.Tooltip(el);
        });

        // Delete single
        document.querySelectorAll('.delete-form').forEach(form => {
            form.addEventListener('submit', function(e) {
                e.preventDefault();
                Swal.fire({
                    title: 'Yakin hapus data ini?',
                    text: "Data yang dihapus tidak bisa dikembalikan.",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: 'Ya, hapus!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) form.submit();
                });
            });
        });

        // Checkbox select all
        const selectAll = document.getElementById('selectAllCheckbox');
        const rowCheckboxes = document.querySelectorAll('.rowCheckbox');

        if (selectAll) {
            selectAll.addEventListener('change', function() {
                rowCheckboxes.forEach(cb => cb.checked = selectAll.checked);
            });
        }

        rowCheckboxes.forEach(cb => {
            cb.addEventListener('change', function() {
                if (selectAll) selectAll.checked = [...rowCheckboxes].every(c => c.checked);
            });
        });

        // Hapus banyak
        document.getElementById('btnDeleteSelected').addEventListener('click', function() {
            const selectedIds = [...rowCheckboxes].filter(cb => cb.checked).map(cb => cb.value);
            if (selectedIds.length === 0) {
                Swal.fire('Oops!', 'Pilih minimal 1 data untuk dihapus.', 'warning');
                return;
            }

            Swal.fire({
                title: 'Hapus data terpilih?',
                text: `Anda akan menghapus ${selectedIds.length} data kosakata.`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal'
            }).then(result => {
                if (result.isConfirmed) {
                    fetch("{{ route('admin.kamus.bulkDestroy') }}", {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                'Content-Type': 'application/json',
                                'Accept': 'application/json'
                            },
                            body: JSON.stringify({
                                ids: selectedIds
                            })
                        })
                        .then(res => res.json())
                        .then(data => {
                            Swal.fire({
                                title: 'Berhasil!',
                                text: data.message ?? 'Data berhasil dihapus.',
                                icon: 'success',
                                timer: 1200,
                                showConfirmButton: false
                            });

                            // Hapus baris table
                            selectedIds.forEach(id => {
                                const row = document.querySelector(`.rowCheckbox[value="${id}"]`)?.closest('tr');
                                if (row) row.remove();
                            });
                        })
                        .catch(err => {
                            Swal.fire('Gagal!', 'Terjadi kesalahan saat menghapus data.', 'error');
                        });
                }
            });
        });
    });

    function submitImport() {
        const form = document.getElementById('importForm');
        form.action = "{{ route('admin.kamus.import') }}";
        form.submit();
    }
</script>