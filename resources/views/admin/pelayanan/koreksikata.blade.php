@extends('layouts.admin')

@section('content')
@php
$daftarAsalKamus = $daftarAsalKamus ?? [];
@endphp

<div class="container-fluid flex-grow-1 container-p-y">
    <div class="card shadow-sm border-0 rounded-3 mx-n4" style="margin-top: -30px;">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">
                <i class="bx bx-book-content me-2"></i> Daftar Pengajuan Koreksi Kata
            </h5>
        </div>

        <div class="card-body">
            {{-- 🔍 Filter dan Search --}}
            <form method="GET" action="{{ route('admin.pelayanan.koreksikata') }}" id="filterForm" class="row g-3 align-items-end mb-3">
                {{-- Cari Kata --}}
                <div class="col-md-4 d-flex align-items-end">
                    <div class="flex-grow-1 me-2">
                        <label class="form-label text-secondary fw-semibold">Cari Kata</label>
                        <input type="text" name="search" class="form-control" placeholder="Cari kata..." value="{{ request('search') }}">
                    </div>
                    <button type="submit" class="btn btn-primary mb-0" style="height: 38px;">
                        <i class="bx bx-search"></i>
                    </button>
                </div>

                {{-- Asal Kamus --}}
                <div class="col-md-3">
                    <label class="form-label text-secondary fw-semibold">Asal Kamus</label>
                    <select name="asal_kamus" class="form-select auto-submit">
                        <option value="">Semua Kamus</option>
                        @foreach($daftarAsalKamus as $kamus)
                        <option value="{{ $kamus }}" {{ request('asal_kamus') == $kamus ? 'selected' : '' }}>
                            {{ $kamus }}
                        </option>
                        @endforeach
                    </select>
                </div>

                {{-- Status --}}
                <div class="col-md-3">
                    <label class="form-label text-secondary fw-semibold">Status</label>
                    <select name="status" class="form-select auto-submit">
                        <option value="">Semua Status</option>
                        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="diterima" {{ request('status') == 'diterima' ? 'selected' : '' }}>Diterima</option>
                        <option value="ditolak" {{ request('status') == 'ditolak' ? 'selected' : '' }}>Ditolak</option>
                    </select>
                </div>

                {{-- Tombol Reset --}}
                <div class="col-md-2 d-flex justify-content-end">
                    <a href="{{ route('admin.pelayanan.koreksikata') }}" class="btn btn-secondary w-100">
                        <i class="bx bx-reset"></i> Reset
                    </a>
                </div>
            </form>

            {{-- 📋 Tabel Koreksi Kata --}}
            <div class="table-responsive">
                <table class="table table-striped align-middle">
                    <thead class="table-light text-center">
                        <tr>
                            <th>No</th>
                            <th>Asal Kamus</th>
                            <th>Kata</th>
                            <th>Bagian Dikoreksi</th>
                            <th>Nilai Baru</th>
                            <th>Nama Pengoreksi</th>
                            <th>Tanggal</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="text-center">
                        @forelse($koreksis as $item)
                        <tr id="row-{{ $item->id }}">
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $item->asal_kamus }}</td>
                            <td><span class="badge bg-label-primary">{{ strtoupper($item->kata) }}</span></td>
                            <td><span class="badge bg-info text-dark">{{ strtoupper($item->bagian_dikoreksi) }}</span></td>
                            <td>{{ $item->nilai_baru }}</td>
                            <td>{{ $item->nama_pengoreksi }}</td>
                            <td>{{ $item->created_at->format('d M Y') }}</td>
                            <td>
                                @if($item->status == 'pending')
                                <span class="badge bg-warning text-dark">Pending</span>
                                @elseif($item->status == 'diterima')
                                <span class="badge bg-success">Diterima</span>
                                @else
                                <span class="badge bg-danger">Ditolak</span>
                                @endif
                            </td>
                            <td class="d-flex gap-2 justify-content-center">
                                {{-- Tombol Detail Selalu Ada --}}
                                <button class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#detailModal{{ $item->id }}">
                                    <i class="bx bx-show-alt"></i>
                                </button>

                                {{-- Jika Pending → Tampilkan tombol Terima & Tolak --}}
                                @if($item->status == 'pending')
                                <button class="btn btn-sm btn-success btn-approve" data-id="{{ $item->id }}">
                                    <i class="bx bx-check"></i>
                                </button>
                                <button class="btn btn-sm btn-danger btn-reject" data-id="{{ $item->id }}">
                                    <i class="bx bx-x"></i>
                                </button>
                                @else
                                {{-- Jika Sudah Ditetapkan → Munculkan Hapus --}}
                                <button class="btn btn-sm btn-outline-danger btn-delete" data-id="{{ $item->id }}">
                                    <i class="bx bx-trash"></i>
                                </button>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="9" class="text-center text-muted">Belum ada data koreksi kata</td>
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

{{-- 📘 Modal Detail --}}
@foreach($koreksis as $item)
<div class="modal fade" id="detailModal{{ $item->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0 shadow-lg">
            <div class="modal-header bg-light">
                <h5 class="modal-title fw-semibold text-dark">Detail Koreksi: {{ ucfirst($item->kata) }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <table class="table table-borderless">
                    <tr>
                        <th>Asal Kamus</th>
                        <td>{{ $item->asal_kamus }}</td>
                    </tr>
                    <tr>
                        <th>Kata</th>
                        <td>{{ $item->kata }}</td>
                    </tr>
                    <tr>
                        <th>Bagian Dikoreksi</th>
                        <td>{{ strtoupper($item->bagian_dikoreksi) }}</td>
                    </tr>
                    <tr>
                        <th>Nilai Baru</th>
                        <td>{{ $item->nilai_baru }}</td>
                    </tr>
                    <tr>
                        <th>Alasan</th>
                        <td>{{ $item->alasan ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th>Nama Pengoreksi</th>
                        <td>{{ $item->nama_pengoreksi }}</td>
                    </tr>
                    <tr>
                        <th>Email Pengoreksi</th>
                        <td>{{ $item->email_pengoreksi ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th>Tanggal</th>
                        <td>{{ $item->created_at->format('d M Y') }}</td>
                    </tr>
                    <tr>
                        <th>Status</th>
                        <td>
                            @if($item->status == 'pending')
                            <span class="badge bg-warning text-dark">Pending</span>
                            @elseif($item->status == 'diterima')
                            <span class="badge bg-success">Diterima</span>
                            @else
                            <span class="badge bg-danger">Ditolak</span>
                            @endif
                        </td>
                    </tr>
                </table>
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
        document.querySelectorAll('.auto-submit').forEach(s => s.addEventListener('change', () => document.getElementById('filterForm').submit()));

        // ✅ TERIMA
        document.querySelectorAll('.btn-approve').forEach(btn => {
            btn.addEventListener('click', function() {
                let id = this.dataset.id;
                Swal.fire({
                    title: 'Terima Koreksi Ini?',
                    text: 'Data kamus akan diperbarui sesuai nilai baru.',
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#16a34a',
                    confirmButtonText: 'Ya, Terima',
                    cancelButtonText: 'Batal'
                }).then(result => {
                    if (result.isConfirmed) {
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
                                row.querySelector('td:nth-child(8)').innerHTML = `<span class="badge bg-success">Diterima</span>`;
                                row.querySelector('td:nth-child(9)').innerHTML = `
                            <button class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#detailModal${id}">
                                <i class="bx bx-show-alt"></i>
                            </button>
                            <button class="btn btn-sm btn-outline-danger btn-delete" data-id="${id}">
                                <i class="bx bx-trash"></i>
                            </button>`;
                                initDelete();
                            });
                    }
                });
            });
        });

        // ❌ TOLAK
        document.querySelectorAll('.btn-reject').forEach(btn => {
            btn.addEventListener('click', function() {
                let id = this.dataset.id;
                Swal.fire({
                    title: 'Tolak Koreksi Ini?',
                    text: 'Status akan diubah menjadi Ditolak.',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#dc2626',
                    confirmButtonText: 'Ya, Tolak',
                    cancelButtonText: 'Batal'
                }).then(result => {
                    if (result.isConfirmed) {
                        fetch(`/admin/koreksi/${id}`, {
                                method: 'DELETE',
                                headers: {
                                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                }
                            })
                            .then(res => res.json())
                            .then(data => {
                                Swal.fire('Ditolak!', data.message, 'success');
                                const row = document.querySelector(`#row-${id}`);
                                row.querySelector('td:nth-child(8)').innerHTML = `<span class="badge bg-danger">Ditolak</span>`;
                                row.querySelector('td:nth-child(9)').innerHTML = `
                            <button class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#detailModal${id}">
                                <i class="bx bx-show-alt"></i>
                            </button>
                            <button class="btn btn-sm btn-outline-danger btn-delete" data-id="${id}">
                                <i class="bx bx-trash"></i>
                            </button>`;
                                initDelete();
                            });
                    }
                });
            });
        });

        // 🗑️ HAPUS
        function initDelete() {
            document.querySelectorAll('.btn-delete').forEach(btn => {
                btn.addEventListener('click', function() {
                    let id = this.dataset.id;
                    Swal.fire({
                        title: 'Hapus Data Ini?',
                        text: 'Data akan dihapus permanen dari daftar koreksi.',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#dc2626',
                        confirmButtonText: 'Ya, Hapus',
                        cancelButtonText: 'Batal'
                    }).then(result => {
                        if (result.isConfirmed) {
                            fetch(`/admin/koreksi/${id}/hapus`, {
                                    method: 'DELETE',
                                    headers: {
                                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                    }
                                })
                                .then(res => res.json())
                                .then(data => {
                                    Swal.fire('Terhapus!', data.message, 'success');
                                    document.querySelector(`#row-${id}`).remove();
                                });
                        }
                    });
                });
            });
        }
        initDelete();
    });
</script>
@endpush