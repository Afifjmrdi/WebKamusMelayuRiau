@extends('layouts.admin')

@section('content')
@php
$daftarAsalKamus = $daftarAsalKamus ?? [];
@endphp

<style>
    /* Toolbar */
    .toolbar-koreksi {
        background: #fff;
        border: 1px solid #e5e7eb;
        border-radius: 14px;
        padding: 14px 16px;
    }

    .toolbar-koreksi .form-control,
    .toolbar-koreksi .form-select {
        height: 42px;
        border-radius: 10px;
        font-size: 14px;
    }

    .toolbar-koreksi .btn {
        height: 42px;
        border-radius: 10px;
        font-weight: 500;
    }

    /* Table */
    .table-koreksi thead th {
        font-size: 13px;
        letter-spacing: .04em;
        text-transform: uppercase;
        color: #6b7280;
        background: #f9fafb;
        border-bottom: 1px solid #e5e7eb;
    }

    .table-koreksi tbody tr:hover {
        background: #f8fafc;
    }

    /* Badge status */
    .badge-status {
        padding: 6px 14px;
        font-size: 12px;
        border-radius: 999px;
        font-weight: 600;
    }

    /* Kata badge */
    .badge-kata {
        background: #eef2ff;
        color: #3730a3;
        font-weight: 600;
        letter-spacing: .03em;
    }

    /* Bagian koreksi badge */
    .badge-bagian {
        background: #e0f2fe;
        color: #075985;
        font-weight: 600;
    }

    /* Aksi button */
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

<div class="container-fluid flex-grow-1 container-p-y">
    <div class="card shadow-sm border-0 rounded-3 mx-n4" style="margin-top: -30px;">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">
                <i class="bx bx-book-content me-2"></i> Daftar Pengajuan Koreksi Kata
            </h5>
        </div>

        <div class="card-body">
            {{-- 🔍 Filter dan Search --}}
            <form method="GET"
                action="{{ route('admin.pelayanan.koreksikata') }}"
                id="filterForm"
                class="toolbar-koreksi d-flex flex-wrap justify-content-between align-items-center mb-4 gap-3">

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


                    {{-- Asal Kamus --}}
                    <select name="asal_kamus" class="form-select auto-submit" style="width:220px">
                        <option value="">Semua Kamus</option>
                        @foreach($daftarAsalKamus as $kamus)
                        <option value="{{ $kamus }}" {{ request('asal_kamus') == $kamus ? 'selected' : '' }}>
                            {{ $kamus }}
                        </option>
                        @endforeach
                    </select>

                    {{-- Status --}}
                    <select name="status" class="form-select auto-submit" style="width:180px">
                        <option value="">Semua Status</option>
                        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="diterima" {{ request('status') == 'diterima' ? 'selected' : '' }}>Diterima</option>
                        <option value="ditolak" {{ request('status') == 'ditolak' ? 'selected' : '' }}>Ditolak</option>
                    </select>

                    {{-- Reset --}}
                    <a href="{{ route('admin.pelayanan.koreksikata') }}"
                        class="btn btn-outline-secondary">
                        <i class="bx bx-reset"></i>
                    </a>
                </div>
            </form>

            {{-- 📋 Tabel Koreksi Kata --}}
            <div class="table-responsive">
                <table class="table table-hover align-middle table-koreksi">
                    <thead class="text-center">
                        <tr>
                            <th>No</th>
                            <th>Asal Kamus</th>
                            <th>Kata</th>
                            <th>Bagian Dikoreksi</th>
                            <th>Nilai Baru</th>
                            <th>Pengoreksi</th>
                            <th>Tanggal</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>

                    <tbody class="text-center">
                        @forelse($koreksis as $item)
                        <tr id="row-{{ $item->id }}">
                            <td>{{ $koreksis->firstItem() + $loop->index }}</td>

                            <td>{{ $item->asal_kamus }}</td>

                            <td>
                                <span class="badge badge-kata">
                                    {{ strtoupper($item->kata) }}
                                </span>
                            </td>

                            <td>
                                <span class="badge badge-bagian">
                                    {{ strtoupper(str_replace('_',' ', $item->bagian_dikoreksi)) }}
                                </span>
                            </td>

                            <td>{{ $item->nilai_baru }}</td>

                            <td>{{ $item->nama_pengoreksi }}</td>

                            <td>{{ $item->created_at->format('d M Y') }}</td>

                            <td>
                                @if($item->status === 'pending')
                                <span class="badge badge-status bg-warning text-dark">Pending</span>
                                @elseif($item->status === 'diterima')
                                <span class="badge badge-status bg-success">Diterima</span>
                                @else
                                <span class="badge badge-status bg-danger">Ditolak</span>
                                @endif
                            </td>

                            <td>
                                <div class="d-flex justify-content-center gap-2">

                                    <button class="btn btn-outline-primary btn-action"
                                        data-bs-toggle="modal"
                                        data-bs-target="#detailModal{{ $item->id }}">
                                        <i class="bx bx-show-alt"></i>
                                    </button>

                                    @if($item->status === 'pending')
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
                            <td colspan="9" class="text-center text-muted py-4">
                                <i class="bx bx-info-circle me-1"></i>
                                Belum ada data koreksi kata
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- 📄 Pagination --}}
            @include('admin.pagination')
        </div>
    </div>
</div>

{{-- 📘 Modal Detail Koreksi --}}
@foreach($koreksis as $item)
<div class="modal fade" id="detailModal{{ $item->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0 shadow rounded-3">

            {{-- Header --}}
            <div class="modal-header border-0 px-4 py-4 align-items-start">
                <div>
                    <h6 class="fw-bold mb-0">Detail Koreksi Kata</h6>
                    <small class="text-muted">
                        Kata dikoreksi:
                        <span class="fw-semibold text-dark">
                            {{ strtoupper($item->kata) }}
                        </span>
                    </small>
                </div>
                <button type="button"
                    class="btn-close mt-6"
                    data-bs-dismiss="modal">
                </button>
            </div>

            {{-- Body --}}
            <div class="modal-body px-4 py-3">

                {{-- Status + Tanggal --}}
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div>
                        <div class="text-muted small">Status Koreksi</div>
                        @if($item->status === 'pending')
                        <span class="badge bg-warning text-dark rounded-pill px-3 py-2">Pending</span>
                        @elseif($item->status === 'diterima')
                        <span class="badge bg-success rounded-pill px-3 py-2">Diterima</span>
                        @else
                        <span class="badge bg-danger rounded-pill px-3 py-2">Ditolak</span>
                        @endif
                    </div>

                    <div class="text-end">
                        <div class="text-muted small">Tanggal</div>
                        <div class="fw-semibold">
                            {{ $item->created_at->format('d M Y') }}
                        </div>
                    </div>
                </div>

                {{-- Informasi Kamus --}}
                <div class="mb-3">
                    <div class="text-muted small">Asal Kamus</div>
                    <div class="fw-semibold">{{ $item->asal_kamus }}</div>
                </div>

                {{-- Highlight Bagian Dikoreksi --}}
                <div class="border rounded-3 p-3 mb-3 bg-light">
                    <div class="row g-3 align-items-center">

                        <div class="col-md-4">
                            <div class="text-muted small">Bagian Dikoreksi</div>
                            <span class="badge bg-info text-dark px-3 py-2">
                                {{ strtoupper(str_replace('_',' ', $item->bagian_dikoreksi)) }}
                            </span>
                        </div>

                        <div class="col-md-8">
                            <div class="text-muted small">Nilai Baru (Usulan)</div>
                            <div class="fw-semibold fs-6">
                                {{ $item->nilai_baru }}
                            </div>
                        </div>

                    </div>

                    <small class="text-muted fst-italic d-block mt-2">
                        * Bagian di atas menunjukkan kolom kamus yang diminta untuk diperbaiki
                    </small>
                </div>

                {{-- Alasan --}}
                <div class="mb-3">
                    <div class="text-muted small">Alasan Koreksi</div>
                    <div class="border rounded-3 p-2 bg-white small">
                        {{ $item->alasan ?? '-' }}
                    </div>
                </div>

                {{-- Pengoreksi --}}
                <div class="row g-3">
                    <div class="col-md-6">
                        <div class="text-muted small">Nama Pengoreksi</div>
                        <div class="fw-semibold">{{ $item->nama_pengoreksi }}</div>
                    </div>

                    <div class="col-md-6">
                        <div class="text-muted small">Email Pengoreksi</div>
                        <div class="fw-semibold">
                            {{ $item->email_pengoreksi ?? '-' }}
                        </div>
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
@endforeach

@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {

        // Auto submit filter
        document.querySelectorAll('.auto-submit').forEach(el => {
            el.addEventListener('change', () => {
                document.getElementById('filterForm').submit();
            });
        });

        /* =====================================================
         *  TERIMA KOREKSI
         * ===================================================== */
        document.querySelectorAll('.btn-approve').forEach(btn => {
            btn.addEventListener('click', function() {
                const id = this.dataset.id;

                Swal.fire({
                    title: 'Terima Koreksi Ini?',
                    text: 'Data kamus akan diperbarui sesuai nilai baru.',
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#16a34a',
                    confirmButtonText: 'Ya, Terima',
                    cancelButtonText: 'Batal'
                }).then(result => {
                    if (!result.isConfirmed) return;

                    fetch(`/admin/koreksi/${id}/approve`, {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            }
                        })
                        .then(res => res.json())
                        .then(data => {
                            Swal.fire('Berhasil!', data.message, 'success');

                            const row = document.querySelector(`#row-${id}`);
                            row.querySelector('td:nth-child(8)').innerHTML =
                                `<span class="badge bg-success">Diterima</span>`;

                            row.querySelector('td:nth-child(9)').innerHTML = `
                        <div class="d-inline-flex gap-2">
                            <button class="btn btn-sm btn-outline-primary"
                                data-bs-toggle="modal"
                                data-bs-target="#detailModal${id}">
                                <i class="bx bx-show-alt"></i>
                            </button>
                            <button class="btn btn-sm btn-outline-danger btn-delete"
                                data-id="${id}">
                                <i class="bx bx-trash"></i>
                            </button>
                        </div>
                    `;

                            initDelete();
                        });
                });
            });
        });

        /* =====================================================
         *  TOLAK KOREKSI (REJECT)
         * ===================================================== */
        document.querySelectorAll('.btn-reject').forEach(btn => {
            btn.addEventListener('click', function() {
                const id = this.dataset.id;

                Swal.fire({
                    title: 'Tolak Koreksi Ini?',
                    text: 'Status akan diubah menjadi Ditolak.',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#dc2626',
                    confirmButtonText: 'Ya, Tolak',
                    cancelButtonText: 'Batal'
                }).then(result => {
                    if (!result.isConfirmed) return;

                    fetch(`/admin/koreksi/${id}/reject`, {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            }
                        })
                        .then(res => res.json())
                        .then(data => {
                            Swal.fire('Ditolak!', data.message, 'success');

                            const row = document.querySelector(`#row-${id}`);
                            row.querySelector('td:nth-child(8)').innerHTML =
                                `<span class="badge bg-danger">Ditolak</span>`;

                            row.querySelector('td:nth-child(9)').innerHTML = `
                        <div class="d-inline-flex gap-2">
                            <button class="btn btn-sm btn-outline-primary"
                                data-bs-toggle="modal"
                                data-bs-target="#detailModal${id}">
                                <i class="bx bx-show-alt"></i>
                            </button>
                            <button class="btn btn-sm btn-outline-danger btn-delete"
                                data-id="${id}">
                                <i class="bx bx-trash"></i>
                            </button>
                        </div>
                    `;

                            initDelete();
                        });
                });
            });
        });

        /* =====================================================
         *  HAPUS PERMANEN
         * ===================================================== */
        function initDelete() {
            document.querySelectorAll('.btn-delete').forEach(btn => {
                btn.onclick = function() {
                    const id = this.dataset.id;

                    Swal.fire({
                        title: 'Hapus Data Ini?',
                        text: 'Data akan dihapus permanen dari daftar koreksi.',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#dc2626',
                        confirmButtonText: 'Ya, Hapus',
                        cancelButtonText: 'Batal'
                    }).then(result => {
                        if (!result.isConfirmed) return;

                        fetch(`/admin/koreksi/${id}/hapus`, {
                                method: 'DELETE',
                                headers: {
                                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                }
                            })
                            .then(res => res.json())
                            .then(data => {
                                Swal.fire('Terhapus!', data.message, 'success');
                                document.querySelector(`#row-${id}`)?.remove();
                            });
                    });
                };
            });
        }

        // Init delete on load
        initDelete();
    });
</script>

@endpush