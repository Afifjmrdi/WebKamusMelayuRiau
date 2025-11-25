@extends('layouts.admin')

@section('title', 'Data Pengajuan Kosakata')

@section('content')
<div class="card shadow-sm border-0" style="margin-top: -3px;">

    {{-- Header --}}
    <div class="card-header bg-light d-flex justify-content-between align-items-center">
        <h5 class="mb-0"><i class="bx bx-book"></i> Pengajuan Kosakata Baru</h5>
    </div>

    {{-- Filter & Search --}}
    <div class="card-body">

        <form method="GET" action="{{ route('admin.pengajuan') }}" id="filterForm" class="row g-3 align-items-end mb-3">

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
                    <option value="menunggu" {{ request('status') == 'menunggu' ? 'selected' : '' }}>Pending</option>
                    <option value="diterima" {{ request('status') == 'diterima' ? 'selected' : '' }}>Diterima</option>
                    <option value="ditolak" {{ request('status') == 'ditolak' ? 'selected' : '' }}>Ditolak</option>
                </select>
            </div>

            {{-- Tombol Reset sejajar kanan --}}
            <div class="col-md-2 d-flex justify-content-end">
                <a href="{{ route('admin.pengajuan') }}" class="btn btn-secondary w-100">
                    <i class="bx bx-reset"></i> Reset
                </a>
            </div>

        </form>
    </div>


    {{-- Tabel Pengajuan --}}
    <div class="table-responsive">
        <table class="table table-striped align-middle">
            <thead class="table-light text-center">
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
                        <span class="badge bg-label-primary">
                            {{ strtoupper($item->kata) }}
                        </span>
                    </td>

                    <td>{{ $item->suku_kata ?? '-' }}</td>

                    <td>
                        <span class="badge bg-info text-dark">
                            {{ strtoupper($item->kelas_kata) }}
                        </span>
                    </td>

                    <td>{{ Str::limit($item->arti, 40) }}</td>

                    <td>{{ $item->asal_pengaju }}</td>

                    <td>{{ $item->created_at->format('d M Y') }}</td>

                    <td>
                        @if($item->status === 'diterima')
                        <span class="badge bg-success">Diterima</span>
                        @elseif($item->status === 'ditolak')
                        <span class="badge bg-danger">Ditolak</span>
                        @else
                        <span class="badge bg-warning text-dark">Pending</span>
                        @endif
                    </td>

                    <td class="d-flex gap-2 justify-content-center">
                        {{-- Tombol Detail --}}
                        <button class="btn btn-sm btn-outline-primary btn-detail" data-bs-toggle="modal"
                            data-item='@json($item)'>
                            <i class="bx bx-show-alt"></i>
                        </button>

                        @if($item->status == 'menunggu' || empty($item->status))
                        {{-- Tombol Terima --}}
                        <button class="btn btn-sm btn-success btn-approve" data-id="{{ $item->id }}">
                            <i class="bx bx-check"></i>
                        </button>

                        {{-- Tombol Tolak --}}
                        <button class="btn btn-sm btn-danger btn-reject" data-id="{{ $item->id }}">
                            <i class="bx bx-x"></i>
                        </button>
                        @else
                        {{-- Hapus (kalau status sudah final) --}}
                        <button class="btn btn-sm btn-outline-danger btn-delete" data-id="{{ $item->id }}">
                            <i class="bx bx-trash"></i>
                        </button>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="10" class="text-center text-muted py-3">
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

<style>
    /* Turunkan posisi modal sedikit dari atas layar */
    .modal-dialog {
        margin-top: 90px !important;
    }
</style>

{{-- Modal Detail --}}
<div class="modal fade" id="detailModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Detail Pengajuan Kosakata</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <table class="table table-borderless">
                    <tr>
                        <th>Kamus Tujuan</th>
                        <td id="detailAsalKamus"></td>
                    </tr>
                    <tr>
                        <th>Kata</th>
                        <td id="detailKata"></td>
                    </tr>
                    <tr>
                        <th>Suku Kata</th>
                        <td id="detailSukukata"></td>
                    </tr>
                    <tr>
                        <th>Kelas Kata</th>
                        <td id="detailKelas"></td>
                    </tr>
                    <tr>
                        <th>Arti</th>
                        <td id="detailArti"></td>
                    </tr>
                    <tr>
                        <th>Contoh</th>
                        <td id="detailContoh"></td>
                    </tr>
                    <tr>
                        <th>Pengaju</th>
                        <td id="detailPengaju"></td>
                    </tr>
                    <tr>
                        <th>Email</th>
                        <td id="detailEmail"></td>
                    </tr>
                    <tr>
                        <th>Alasan</th>
                        <td id="detailAlasan"></td>
                    </tr>
                    <tr>
                        <th>Status</th>
                        <td id="detailStatus"></td>
                    </tr>
                    <tr>
                        <th>Tanggal</th>
                        <td id="detailTanggal"></td>
                    </tr>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
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
            document.getElementById('detailStatus').innerText = item.status ?? 'menunggu';
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