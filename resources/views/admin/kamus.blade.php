@extends('layouts.admin')

@section('content')
<style>
    /* Hilangkan jarak bawah navbar */
    #layout-navbar {
        margin-bottom: 0 !important;
        padding-bottom: 0 !important;
    }

    .container-xxl.container-p-y {
        padding-top: 0 !important;
        margin-top: -1rem !important;
    }

    /* Card menempel rapi */
    .card {
        margin-top: 0 !important;
    }

    /* Style tabel rapi */
    .table th,
    .table td {
        vertical-align: middle !important;
        white-space: nowrap !important;
    }

    .table thead th {
        text-transform: uppercase;
        font-size: 0.85rem;
        letter-spacing: 0.5px;
        background-color: #f8f9fa;
        border-bottom: 2px solid #dee2e6;
    }

    .table td {
        font-size: 0.93rem;
    }

    /* Tooltip ellipsis */
    .text-truncate-td {
        max-width: 250px;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }

    .tooltip-inner {
        max-width: 400px;
        text-align: left;
    }

    /* Modal detail tampilan rapi tanpa scrollbar horizontal */
    .modal-detail {
        width: 100%;
        table-layout: fixed;
    }

    .modal-detail th,
    .modal-detail td {
        white-space: normal !important;
        word-wrap: break-word;
        word-break: break-word;
        vertical-align: top;
        padding: 6px 8px;
        font-size: 0.95rem;
    }

    .modal-dialog.modal-lg {
        max-width: 800px;
        /* Lebar modal aman */
    }

    .modal-body {
        overflow-x: hidden !important;
    }


    .pagination .page-link {
        padding: 4px 10px;
        font-size: 0.85rem;
    }

    select.form-select-sm {
        font-size: 0.85rem;
    }

    .table-responsive {
        overflow-x: auto;
    }
</style>
<meta name="csrf-token" content="{{ csrf_token() }}">
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="mx-n4">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-light d-flex justify-content-between align-items-center flex-wrap gap-3">
                <div class="d-flex align-items-center">
                    <i class="bx bx-book fs-4 text-primary me-2"></i>
                    <h5 class="mb-0">Data Kamus</h5>
                </div>
            </div>

            {{-- Form Filter & Tambah Data --}}
            @include('admin.create')

            {{-- 📋 Data Tabel --}}
            <div class="px-3">
                @include('admin.datakamus.datatabel')
            </div>

            {{-- 📄 Pagination --}}
            @include('admin.pagination')
            <style>
                /* Perapian tampilan modal form */
                #createModal .modal-body {
                    padding: 1.5rem 2rem !important;
                    background-color: #fdfdfd;
                }

                #createModal form label {
                    font-weight: 600;
                    margin-bottom: 0.25rem;
                    display: block;
                    color: #374151;
                    font-size: 0.9rem;
                }

                #createModal form input,
                #createModal form select,
                #createModal form textarea {
                    width: 100%;
                    border: 1px solid #d1d5db;
                    border-radius: 0.2rem;
                    padding: 0.55rem 0.75rem;
                    background-color: #f9fafb;
                    font-size: 0.9rem;
                    transition: all 0.2s ease-in-out;
                }

                #createModal form input:focus,
                #createModal form select:focus,
                #createModal form textarea:focus {
                    border-color: #6366f1;
                    box-shadow: 0 0 0 2px rgba(99, 102, 241, 0.1);
                    background-color: #fff;
                    outline: none;
                }

                /* Grid form dua kolom lebih rapat */
                #createModal .grid {
                    display: grid;
                    grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
                    gap: 0.6rem;
                }

                /* Tombol bawah form */
                #createModal .modal-footer-btns {
                    display: flex;
                    justify-content: flex-end;
                    gap: 0.5rem;
                    margin-top: 1rem;
                }

                #createModal button {
                    font-weight: 500;
                    border: none;
                    font-size: 0.9rem;
                }

                #createModal .btn-cancel {
                    background: #e5e7eb;
                    color: #374151;
                    padding: 0.5rem 1rem;
                    border-radius: 0.2rem;
                }

                #createModal .btn-cancel:hover {
                    background: #d1d5db;
                }

                #createModal .btn-save {
                    background: #4f46e5;
                    color: white;
                    padding: 0.5rem 1rem;
                    border-radius: 0.2rem;
                }

                #createModal .btn-save:hover {
                    background: #4338ca;
                }

                /* Modal tetap sejajar rapi */
                .modal-dialog-centered {
                    display: flex;
                    align-items: center;
                    min-height: calc(100% - 1rem);
                }
            </style>


            {{-- 🆕 Modal Tambah Data Kamus --}}
            <div class="modal fade" id="createModal" tabindex="-1" aria-labelledby="createModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg modal-dialog-centered">
                    <div class="modal-content rounded-3 shadow-lg">
                        <div class="modal-header bg-indigo-600 text-white">
                            <h5 class="modal-title fw-bold" id="createModalLabel">📝 Tambah Data Kamus Baru</h5>
                            <button type="button" class="btn-close bg-white" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>

                        <div class="modal-body p-6">
                            <form id="formTambahKamus" action="{{ route('admin.kamus.store') }}" method="POST">
                                @csrf

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">

                                    <!-- Asal Kamus -->
                                    <div class="md:col-span-2">
                                        <label class="block font-semibold mb-2 text-gray-700">Asal Kamus <span class="text-red-500">*</span></label>
                                        <select id="asal_kamus" name="asal_kamus"
                                            class="w-full p-3 rounded-xl border border-gray-300 bg-gray-50 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                                            <option value="">Pilih kamus tujuan</option>
                                            <option value="Kamus Indonesia - Kuantan Singingi">Kamus Indonesia - Kuantan Singingi</option>
                                            <option value="Kamus Indonesia - Indragiri Hulu">Kamus Indonesia - Indragiri Hulu</option>
                                            <option value="Kamus Indonesia - Melayu Siak">Kamus Indonesia - Melayu Siak</option>
                                            <option value="Kamus Indonesia - Rokan Hilir">Kamus Indonesia - Rokan Hilir</option>
                                        </select>
                                    </div>

                                    <!-- Kata -->
                                    <div>
                                        <label class="block font-semibold mb-2 text-gray-700">Kata <span class="text-red-500">*</span></label>
                                        <input type="text" id="kata" name="kata"
                                            class="w-full p-3 rounded-xl border border-gray-300 bg-gray-50 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                                            placeholder="Masukkan kata baru...">
                                    </div>

                                    <!-- Kelas Kata -->
                                    <div>
                                        <label class="block font-semibold mb-2 text-gray-700">Kelas Kata <span class="text-red-500">*</span></label>
                                        <select id="kelas_kata" name="kelas_kata"
                                            class="w-full p-3 rounded-xl border border-gray-300 bg-gray-50 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                                            <option value="">Pilih kelas kata</option>
                                            <option value="Nomina (Kata Benda)">Nomina (Kata Benda)</option>
                                            <option value="Verba (Kata Kerja)">Verba (Kata Kerja)</option>
                                            <option value="Adjektiva (Kata Sifat)">Adjektiva (Kata Sifat)</option>
                                            <option value="Adverbia (Kata Keterangan)">Adverbia (Kata Keterangan)</option>
                                            <option value="Pronomina (Kata Ganti)">Pronomina (Kata Ganti)</option>
                                            <option value="Numeralia (Kata Bilangan)">Numeralia (Kata Bilangan)</option>
                                            <option value="Preposisi (Kata Depan)">Preposisi (Kata Depan)</option>
                                            <option value="Konjungsi (Kata Penghubung)">Konjungsi (Kata Penghubung)</option>
                                            <option value="Interjeksi (Kata Seru)">Interjeksi (Kata Seru)</option>
                                            <option value="Partikel">Partikel</option>
                                        </select>
                                    </div>

                                    <!-- Arti -->
                                    <div class="md:col-span-2">
                                        <label class="block font-semibold mb-2 text-gray-700">Arti <span class="text-red-500">*</span></label>
                                        <textarea id="arti" name="arti" rows="2"
                                            class="w-full p-3 rounded-xl border border-gray-300 bg-gray-50 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                                            placeholder="Tuliskan arti kata..."></textarea>
                                    </div>

                                    <!-- Contoh & Suku Kata -->
                                    <div>
                                        <label class="block font-semibold mb-2 text-gray-700">Contoh Kalimat (Opsional)</label>
                                        <textarea id="contoh" name="contoh" rows="2"
                                            class="w-full p-3 rounded-xl border border-gray-300 bg-gray-50 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                                            placeholder="Tuliskan contoh penggunaan kata..."></textarea>
                                    </div>

                                    <div>
                                        <label class="block font-semibold mb-2 text-gray-700">Suku Kata (Opsional)</label>
                                        <input type="text" id="suku_kata" name="suku_kata"
                                            class="w-full p-3 rounded-xl border border-gray-300 bg-gray-50 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                                            placeholder="Pisahkan dengan tanda hubung, contoh: ba-hasa">
                                    </div>
                                </div>

                                <!-- Tombol -->
                                <div class="flex justify-end gap-3 mt-6">
                                    <div class="modal-footer-btns">
                                        <button type="button" class="btn-cancel" data-bs-dismiss="modal">Batal</button>
                                        <button type="submit" class="btn-save">Simpan Data</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End Modal Create -->
        </div>
    </div>
</div>
</div>

@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const formTambah = document.getElementById("formTambahKamus");

        if (formTambah) {
            formTambah.addEventListener("submit", function(e) {
                e.preventDefault();

                const formData = new FormData(formTambah);

                fetch(formTambah.action, {
                        method: "POST",
                        headers: {
                            "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content,
                        },
                        body: formData
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            Swal.fire({
                                icon: "success",
                                title: "Berhasil!",
                                text: data.message,
                                showConfirmButton: false,
                                timer: 1500
                            });

                            // Tutup modal
                            const modal = bootstrap.Modal.getInstance(document.getElementById("createModal"));
                            modal.hide();

                            // Reset form
                            formTambah.reset();

                            // Reload tabel setelah 1,5 detik
                            setTimeout(() => window.location.reload(), 1500);
                        } else {
                            Swal.fire({
                                icon: "error",
                                title: "Gagal!",
                                text: "Terjadi kesalahan saat menambah data."
                            });
                        }
                    })
                    .catch(error => {
                        console.error(error);
                        Swal.fire({
                            icon: "error",
                            title: "Gagal!",
                            text: "Terjadi kesalahan koneksi ke server."
                        });
                    });
            });
        }
    });
</script>


<script>
    document.addEventListener("DOMContentLoaded", function() {
        // 🗑️ Konfirmasi hapus pakai SweetAlert
        const deleteForms = document.querySelectorAll('.delete-form');
        deleteForms.forEach(form => {
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
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            });
        });

        // 💾 Notifikasi sukses
        @if(session('success'))
        Swal.fire({
            icon: 'success',
            title: 'Berhasil!',
            text: "{{ session('success') }}",
            showConfirmButton: false,
            timer: 1800
        });
        @endif

        // ⚠️ Notifikasi error
        @if(session('error'))
        Swal.fire({
            icon: 'error',
            title: 'Gagal!',
            text: "{{ session('error') }}",
            showConfirmButton: true
        });
        @endif
    });

    document.addEventListener("DOMContentLoaded", function() {
        // Tombol DETAIL
        document.querySelectorAll(".btn-detail").forEach(btn => {
            btn.addEventListener("click", function() {
                const id = this.dataset.id;
                const modal = document.getElementById("detailModal" + id);

                if (!modal) {
                    console.error("Modal detail tidak ditemukan: " + id);
                    return;
                }

                const bsModal = new bootstrap.Modal(modal);
                bsModal.show();
            });
        });
    });

    document.addEventListener("DOMContentLoaded", function() {
        // Tombol EDIT
        document.querySelectorAll(".btn-edit").forEach(btn => {
            btn.addEventListener("click", function() {
                const id = this.dataset.id;
                const modal = document.getElementById("editModal" + id);

                if (!modal) {
                    console.error("Modal edit tidak ditemukan: " + id);
                    return;
                }

                const bsModal = new bootstrap.Modal(modal);
                bsModal.show();
            });
        });
    });
</script>
@endpush