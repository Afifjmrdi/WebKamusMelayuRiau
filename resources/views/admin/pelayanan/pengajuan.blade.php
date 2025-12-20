@extends('layouts.admin')

@section('title', 'Data Pengajuan Kosakata')

@section('content')

<style>
    /* Toolbar */
    .toolbar-pengajuan {
        background: #fff;
        border: 1px solid #e5e7eb;
        border-radius: 14px;
        padding: 14px 16px;
    }

    .toolbar-pengajuan .form-control,
    .toolbar-pengajuan .form-select {
        height: 42px;
        border-radius: 10px;
        font-size: 14px;
    }

    .toolbar-pengajuan .btn {
        height: 42px;
        border-radius: 10px;
        font-weight: 500;
    }

    /* Table */
    .table-pengajuan thead th {
        font-size: 13px;
        letter-spacing: .04em;
        text-transform: uppercase;
        color: #6b7280;
        background: #f9fafb;
        border-bottom: 1px solid #e5e7eb;
    }

    .table-pengajuan tbody tr:hover {
        background: #f8fafc;
    }

    /* Badge */
    .badge-kata {
        background: #eef2ff;
        color: #3730a3;
        font-weight: 600;
        letter-spacing: .03em;
    }

    .badge-kelas {
        background: #e0f2fe;
        color: #075985;
        font-weight: 600;
    }

    .badge-status {
        padding: 6px 14px;
        font-size: 12px;
        border-radius: 999px;
        font-weight: 600;
    }

    /* Action button */
    .btn-action {
        width: 34px;
        height: 34px;
        padding: 0;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 8px;
    }
</style>

<div class="card shadow-sm border-0" style="margin-top: -3px;">
    {{-- Header --}}
    <div class="card-header bg-light d-flex justify-content-between align-items-center">
        <h5 class="mb-0"><i class="bx bx-book"></i> Pengajuan Kosakata Baru</h5>
    </div>

    {{-- Filter & Search --}}
    <div class="card-body">
        <form method="GET"
            action="{{ route('admin.pengajuan') }}"
            id="filterForm"
            class="toolbar-pengajuan d-flex flex-wrap justify-content-between align-items-center mb-4 gap-3">

            {{-- LEFT --}}
            <div class="d-flex flex-wrap align-items-center gap-2">
                {{-- Search --}}
                <div class="search-wrapper position-relative">
                    <i class="bx bx-search text-muted"
                        style="
                            position:absolute;
                            left:12px;
                            top:50%;
                            transform:translateY(-50%);
                            font-size:18px;
                            pointer-events:none;"></i>

                    <input type="text"
                        name="search"
                        value="{{ request('search') }}"
                        class="form-control ps-5"
                        style="width:260px"
                        placeholder="Cari kata...">
                </div>

                <select name="asal_kamus" class="form-select auto-submit" style="width:220px">
                    <option value="">Semua Kamus</option>
                    @foreach($daftarAsalKamus as $kamus)
                    <option value="{{ $kamus }}" {{ request('asal_kamus') == $kamus ? 'selected' : '' }}>
                        {{ $kamus }}
                    </option>
                    @endforeach
                </select>

                <select name="status" class="form-select auto-submit" style="width:180px">
                    <option value="">Semua Status</option>
                    <option value="menunggu" {{ request('status') == 'menunggu' ? 'selected' : '' }}>Pending</option>
                    <option value="diterima" {{ request('status') == 'diterima' ? 'selected' : '' }}>Diterima</option>
                    <option value="ditolak" {{ request('status') == 'ditolak' ? 'selected' : '' }}>Ditolak</option>
                </select>

                <a href="{{ route('admin.pengajuan') }}"
                    class="btn btn-outline-secondary">
                    <i class="bx bx-reset"></i>
                </a>
            </div>
        </form>
    </div>

    {{-- Tabel Pengajuan --}}
    <div class="table-responsive">
        <table class="table table-hover align-middle table-pengajuan">
            <thead class="text-center">
                <tr>
                    <th>No</th>
                    <th>Kamus Tujuan</th>
                    <th>Kata</th>
                    <th>Suku Kata</th>
                    <th>Kelas Kata</th>
                    <th>Arti</th>
                    <th>Pengaju</th>
                    <th>Tanggal</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>

            <tbody class="text-center">
                @forelse($data as $item)
                <tr id="row-{{ $item->id }}">
                    <td>{{ $loop->iteration + ($data->currentPage()-1) * $data->perPage() }}</td>

                    <td>{{ $item->asal_kamus }}</td>

                    <td>
                        <span class="badge badge-kata">
                            {{ strtoupper($item->kata) }}
                        </span>
                    </td>

                    <td>{{ $item->suku_kata ?? '-' }}</td>

                    <td>
                        <span class="badge badge-kelas">
                            {{ strtoupper($item->kelas_kata) }}
                        </span>
                    </td>

                    <td>{{ Str::limit($item->arti, 40) }}</td>

                    <td>{{ $item->asal_pengaju }}</td>

                    <td>{{ $item->created_at->format('d M Y') }}</td>

                    <td>
                        @if($item->status === 'diterima')
                        <span class="badge badge-status bg-success">Diterima</span>
                        @elseif($item->status === 'ditolak')
                        <span class="badge badge-status bg-danger">Ditolak</span>
                        @else
                        <span class="badge badge-status bg-warning text-dark">Pending</span>
                        @endif
                    </td>

                    <td>
                        <div class="d-flex justify-content-center gap-2">

                            <button class="btn btn-outline-primary btn-action btn-detail"
                                data-item='@json($item)'>
                                <i class="bx bx-show-alt"></i>
                            </button>

                            @if($item->status == 'menunggu' || empty($item->status))
                            <button class="btn btn-success btn-action btn-approve"
                                data-id="{{ $item->id }}">
                                <i class="bx bx-check"></i>
                            </button>

                            <button class="btn btn-danger btn-action btn-reject"
                                data-id="{{ $item->id }}">
                                <i class="bx bx-x"></i>
                            </button>
                            @else
                            <button class="btn btn-outline-danger btn-action btn-delete"
                                data-id="{{ $item->id }}">
                                <i class="bx bx-trash"></i>
                            </button>
                            @endif

                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="10" class="text-center text-muted py-4">
                        <i class="bx bx-info-circle me-1"></i>
                        Belum ada pengajuan kosakata.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Pagination --}}
    <div class="card-footer bg-white">
        @include('admin.pagination', ['paginator' => $data])
    </div>
</div>

{{-- 📘 Modal Detail Pengajuan Kosakata --}}
<div class="modal fade" id="detailModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0 shadow rounded-3">

            {{-- Header --}}
            <div class="modal-header border-0 px-4 py-4 align-items-start">
                <div>
                    <h6 class="fw-bold mb-0">Detail Pengajuan Kosakata</h6>
                    <small class="text-muted">Informasi kosakata yang diajukan</small>
                </div>
                <button type="button"
                    class="btn-close mt-6"
                    data-bs-dismiss="modal">
                </button>
            </div>

            {{-- Body --}}
            <div class="modal-body px-4 py-3">

                {{-- Status --}}
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div>
                        <div class="text-muted small">Status</div>
                        <span id="detailStatus"
                            class="badge rounded-pill px-3 py-2"></span>
                    </div>

                    <div class="text-end">
                        <div class="text-muted small">Tanggal</div>
                        <div class="fw-semibold" id="detailTanggal"></div>
                    </div>
                </div>

                {{-- Kamus --}}
                <div class="mb-3">
                    <div class="text-muted small">Kamus Tujuan</div>
                    <div class="fw-semibold" id="detailAsalKamus"></div>
                </div>

                {{-- Kosakata --}}
                <div class="border rounded-3 p-3 mb-3 bg-light">
                    <div class="row g-3 align-items-center">
                        <div class="col-md-4">
                            <div class="text-muted small">Kata</div>
                            <div class="fw-bold fs-5" id="detailKata"></div>
                        </div>

                        <div class="col-md-4">
                            <div class="text-muted small">Suku Kata</div>
                            <div class="fw-semibold" id="detailSukukata"></div>
                        </div>

                        <div class="col-md-4 text-md-end">
                            <div class="text-muted small">Kelas Kata</div>
                            <span id="detailKelas"
                                class="badge bg-info text-dark px-3 py-2"></span>
                        </div>
                    </div>
                </div>

                {{-- Arti & Contoh --}}
                <div class="row g-3 mb-3">
                    <div class="col-md-6">
                        <div class="text-muted small">Arti</div>
                        <div class="border rounded-3 p-2 bg-white small"
                            id="detailArti"></div>
                    </div>

                    <div class="col-md-6">
                        <div class="text-muted small">Contoh</div>
                        <div class="border rounded-3 p-2 bg-white fst-italic small"
                            id="detailContoh"></div>
                    </div>
                </div>

                {{-- Alasan --}}
                <div class="mb-3">
                    <div class="text-muted small">Alasan Pengajuan</div>
                    <div class="border rounded-3 p-2 bg-white small"
                        id="detailAlasan"></div>
                </div>

                {{-- Pengaju --}}
                <div class="row g-3">
                    <div class="col-md-6">
                        <div class="text-muted small">Nama Pengaju</div>
                        <div class="fw-semibold" id="detailPengaju"></div>
                    </div>

                    <div class="col-md-6">
                        <div class="text-muted small">Email Pengaju</div>
                        <div class="fw-semibold" id="detailEmail"></div>
                    </div>
                </div>

            </div>

            {{-- Footer --}}
            <div class="modal-footer border-0 px-4 py-2">
                <button type="button"
                    class="btn btn-secondary px-4"
                    data-bs-dismiss="modal">
                    Tutup
                </button>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Auto-submit ketika dropdown berubah
        document.querySelectorAll('.auto-submit').forEach(select => {
            select.addEventListener('change', function() {
                document.getElementById('filterForm').submit();
            });
        });
    });


    // Approve button
    document.querySelectorAll('.btn-approve').forEach(btn => {
        btn.addEventListener('click', function() {
            const id = this.dataset.id;
            Swal.fire({
                title: 'Terima Pengajuan?',
                text: "Kata ini akan dimasukkan ke dalam kamus!",
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Ya, Terima',
                cancelButtonText: 'Batal',
                confirmButtonColor: '#28a745',
                cancelButtonColor: '#6c757d'
            }).then(result => {
                if (result.isConfirmed) {
                    fetch(`/admin/pengajuan/${id}/approve`, {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                            }
                        }).then(res => res.json())
                        .then(data => Swal.fire('Berhasil!', data.message, 'success').then(() => location.reload()))
                        .catch(() => Swal.fire('Error!', 'Terjadi kesalahan.', 'error'));
                }
            });
        });
    });

    // Reject button
    document.querySelectorAll('.btn-reject').forEach(btn => {
        btn.addEventListener('click', function() {
            const id = this.dataset.id;
            Swal.fire({
                title: 'Tolak Pengajuan?',
                text: "Data pengajuan ini akan ditolak.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Ya, Tolak',
                cancelButtonText: 'Batal',
                confirmButtonColor: '#dc3545',
                cancelButtonColor: '#6c757d'
            }).then(result => {
                if (result.isConfirmed) {
                    fetch(`/admin/pengajuan/${id}`, {
                            method: 'DELETE',
                            headers: {
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                            }
                        }).then(res => res.json())
                        .then(data => Swal.fire('Ditolak!', data.message, 'success').then(() => location.reload()))
                        .catch(() => Swal.fire('Error!', 'Terjadi kesalahan.', 'error'));
                }
            });
        });
    });

    // Detail button
    document.querySelectorAll('.btn-detail').forEach(btn => {
        btn.addEventListener('click', function() {
            const item = JSON.parse(this.dataset.item);
            document.getElementById('detailAsalKamus').innerText = item.asal_kamus;
            document.getElementById('detailKata').innerText = item.kata;
            document.getElementById('detailSukukata').innerText = item.suku_kata;
            document.getElementById('detailKelas').innerText = item.kelas_kata;
            document.getElementById('detailArti').innerText = item.arti;
            document.getElementById('detailContoh').innerText = item.contoh ?? '-';
            document.getElementById('detailPengaju').innerText = item.asal_pengaju;
            document.getElementById('detailEmail').innerText = item.email_pengaju ?? '-';
            document.getElementById('detailAlasan').innerText = item.alasan_pengajuan;
            const statusEl = document.getElementById('detailStatus');

            let status = item.status ?? 'menunggu';
            let label = 'Pending';
            let badgeClass = 'bg-warning text-dark';

            if (status === 'diterima') {
                label = 'Diterima';
                badgeClass = 'bg-success';
            } else if (status === 'ditolak') {
                label = 'Ditolak';
                badgeClass = 'bg-danger';
            }

            statusEl.className = `badge px-3 py-2 rounded-pill ${badgeClass}`;
            statusEl.innerText = label;

            document.getElementById('detailTanggal').innerText = new Date(item.created_at).toLocaleString();
            new bootstrap.Modal(document.getElementById('detailModal')).show();
        });
    });

    // 🗑️ Hapus Pengajuan dengan SweetAlert
    document.querySelectorAll('.btn-delete').forEach(btn => {
        btn.addEventListener('click', function() {
            let id = this.dataset.id;

            Swal.fire({
                title: 'Yakin ingin menghapus?',
                text: 'Data ini akan hilang permanen.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc2626',
                cancelButtonColor: '#6b7280',
                confirmButtonText: 'Ya, hapus',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {

                    // Kirim request delete
                    fetch(`/admin/pengajuan/${id}/hapus`, {
                            method: 'DELETE',
                            headers: {
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                            }
                        })
                        .then(res => res.json())
                        .then(data => {

                            // SweetAlert sukses
                            Swal.fire({
                                icon: 'success',
                                title: 'Berhasil dihapus',
                                text: 'Data pengajuan sudah dibersihkan.',
                                confirmButtonColor: '#4f46e5'
                            });

                            // Hapus baris dari tabel tanpa reload
                            document.getElementById(`row-${id}`).remove();
                        })
                        .catch(() => {
                            Swal.fire({
                                icon: 'error',
                                title: 'Gagal menghapus',
                                text: 'Terjadi kesalahan.',
                                confirmButtonColor: '#dc2626'
                            });
                        });
                }
            });
        });
    });
</script>
@endsection