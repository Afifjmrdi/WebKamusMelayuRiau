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

{{-- TABLE --}}

<div class="table-responsive">
    <table class="table table-hover align-middle text-nowrap">
        <thead class="align-middle">
            <tr>
                <th style="width: 4%;">
                    <input type="checkbox" id="selectAllCheckbox">
                </th>
                <th class="text-center" style="width: 10%;">KATA</th>
                <th class="text-center" style="width: 12%;">SUKU KATA</th>
                <th class="text-center" style="width: 10%;">KELAS KATA</th>
                <th class="text-center" style="width: 25%;">ARTI</th>
                <th class="text-center" style="width: 15%;">ASAL KAMUS</th>
                <th class="text-center" style="width: 8%;">DITAMBAHKAN</th>
                <th class="text-center" style="width: 10%;">AKSI</th>
            </tr>
        </thead>
        <tbody>
            @if(isset($dataKamus) && $dataKamus->count() > 0)
            @foreach ($dataKamus as $item)
            <tr>
                <td class="text-center">
                    <input type="checkbox" class="rowCheckbox" value="{{ $item->id }}">
                </td>
                <td class="fw-semibold text-capitalize text-center">{{ $item->kata }}</td>
                <td class="text-center">{{ $item->suku_kata ?? '-' }}</td>
                <td class="text-center">{{ $item->kelas_kata }}</td>
                <td class="text-truncate-td" data-bs-toggle="tooltip" title="{{ $item->arti }}">
                    {{ $item->arti }}
                </td>
                <td class="text-center">{{ $item->asal_kamus }}</td>
                <td class="text-center">
                    {{ $item->created_at ? \Carbon\Carbon::parse($item->created_at)->format('d-m-Y') : '-' }}
                </td>
                <td class="text-center">
                    <div class="d-flex justify-content-center gap-2">
                        {{-- DETAIL --}}
                        <button type="button"
                            class="btn btn-sm btn-outline-primary"
                            data-bs-toggle="modal"
                            data-bs-target="#detailModal{{ $item->id }}"
                            aria-label="Detail {{ $item->kata }}">
                            <i class="bx bx-show-alt"></i>
                        </button>

                        {{-- EDIT --}}
                        <button type="button"
                            class="btn btn-sm btn-outline-warning"
                            data-bs-toggle="modal"
                            data-bs-target="#editModal{{ $item->id }}"
                            aria-label="Edit {{ $item->kata }}">
                            <i class="bx bx-edit"></i>
                        </button>

                        {{-- DELETE --}}
                        <form action="{{ route('admin.destroy', $item->id) }}" method="POST" class="delete-form d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-outline-danger" title="Hapus">
                                <i class="bx bx-trash"></i>
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
            @endforeach
            @else
            <tr>
                <td colspan="8" class="text-center text-muted py-3">
                    <i class="bx bx-info-circle"></i> Tidak ada data kamus.
                </td>
            </tr>
            @endif
        </tbody>
    </table>
</div>

<!-- Modal Import Excel -->
<div class="modal fade" id="importModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg rounded-4" style="backdrop-filter: blur(8px);">

            <!-- HEADER -->
            <div class="modal-header border-0" style="background:#ffffff; border-bottom:1px solid #e8e8e8;">
                <h4 class="modal-title fw-bold d-flex align-items-center" style="color:#1b5e20;">
                    <i class="bx bx-file-import me-2 fs-3"></i>
                    Import Data Kosakata
                </h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <form action="{{ route('admin.kamus.import') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="modal-body px-4 py-4" style="background:#fafafa;">

                    <div class="row gy-4">

                        <!-- LEFT BOX - Detail -->
                        <div class="col-md-5">
                            <div class="p-4 rounded-4 shadow-sm bg-white border" style="min-height: 100%;">

                                <h6 class="fw-bold mb-3" style="color:#2e7d32;">
                                    <i class="bx bx-info-circle me-1"></i>
                                    Panduan Import
                                </h6>

                                <p class="small text-muted">
                                    Tolong baca panduan penginputan datanya sebelum diinputkan agar data berhasil diimport.
                                </p>

                                <ul class="small text-muted ps-3">
                                    <li>File harus format .xlsx / .csv</li>
                                    <li>Batas ukuran: <b>200MB</b></li>
                                </ul>

                                <p class="small text-muted">
                                    Pastikan data yang ingin diimport memiliki <b>Header</b> seperti dibawah ini
                                    agar data berhasil diimport.
                                </p>

                                <ul class="small text-muted ps-3">
                                    <li>kata</li>
                                    <li>kelas_kata</li>
                                    <li>arti</li>
                                    <li>contoh</li>
                                    <li>asal_kamus</li>
                                    <li>suku_kata</li>
                                </ul>

                            </div>
                        </div>

                        <!-- RIGHT BOX - Upload -->
                        <div class="col-md-7">
                            <div class="p-4 rounded-4 shadow-sm bg-white border position-relative">

                                <h6 class="fw-bold mb-3" style="color:#2e7d32;">
                                    <i class="bx bx-upload me-1"></i>
                                    Upload File Excel / CSV
                                </h6>

                                <!-- DRAG & DROP STYLE -->
                                <div class="p-4 rounded-4 border border-2 border-dashed bg-white text-center"
                                    style="border-color:#b5d6b7; cursor:pointer;">

                                    <img src="https://cdn-icons-png.flaticon.com/512/732/732220.png"
                                        width="55" class="mb-3 opacity-75">

                                    <p class="mb-1 fw-semibold" style="color:#388e3c;">
                                        Drag & Drop file di sini
                                    </p>

                                    <p class="small text-muted mb-3">
                                        atau klik tombol di bawah
                                    </p>

                                    <input type="file" name="file" class="form-control rounded-3" required>
                                </div>

                            </div>
                        </div>

                    </div>

                </div>

                <!-- FOOTER -->
                <div class="modal-footer border-0 pb-4 px-4">

                    <button type="submit"
                        class="btn text-white rounded-3 px-4"
                        style="background:#2e7d32;">
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
</script>