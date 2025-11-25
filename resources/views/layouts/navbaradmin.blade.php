<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

<style>
    .swal2-container {
        z-index: 20000 !important;
    }
</style>

<nav class="layout-navbar container-xxl navbar navbar-expand-xl navbar-detached align-items-center bg-navbar-theme"
    id="layout-navbar">

    <div class="layout-menu-toggle navbar-nav align-items-xl-center me-3 me-xl-0 d-xl-none">
        <a class="nav-item nav-link px-0 me-xl-4" href="javascript:void(0)">
            <i class="bx bx-menu bx-sm"></i>
        </a>
    </div>

    <div class="navbar-nav-right d-flex align-items-center" id="navbar-collapse">

        <!-- 🧭 Breadcrumb Dinamis -->
        @php
        $pageName = '';
        $icon = '';

        if (Request::is('admin/dashboard')) {
        $pageName = 'Dashboard';
        $icon = 'fa-solid fa-chart-line';
        } elseif (Request::is('admin/kamus*')) {
        $pageName = 'Kamus';
        $icon = 'fa-solid fa-book';
        } elseif (Request::is('admin/pelayanan/pengajuan*')) {
        $pageName = 'Pengajuan';
        $icon = 'fa-solid fa-file-circle-check';
        } elseif (Request::is('admin/pelayanan/koreksikata*')) {
        $pageName = 'Koreksi Kata';
        $icon = 'fa-solid fa-pen-to-square';
        } else {
        $pageName = 'Halaman';
        $icon = 'fa-solid fa-layer-group';
        }
        @endphp

        <div class="navbar-nav align-items-center">
            <div class="nav-item d-flex align-items-center">
                <i class="{{ $icon }} text-secondary me-2 fs-5"></i>
                <span class="text-muted fw-medium me-1">Pages /</span>
                <span class="fw-semibold text-dark">{{ $pageName }}</span>
            </div>
        </div>
        <!-- /Breadcrumb Dinamis -->

        <ul class="navbar-nav flex-row align-items-center ms-auto">
            @php
            $admin = \App\Models\Admin::find(session('admin_id'));
            @endphp

            <li class="nav-item navbar-dropdown dropdown-user dropdown">
                <a class="nav-link dropdown-toggle hide-arrow" href="#" data-bs-toggle="dropdown">
                    <div class="avatar avatar-online">
                        <img src="{{ asset('assets/img/avatars/man.png') }}" alt class="w-px-40 h-auto rounded-circle" />
                    </div>
                </a>

                <ul class="dropdown-menu dropdown-menu-end">
                    <li>
                        <a class="dropdown-item" href="#">
                            <div class="d-flex">
                                <div class="flex-shrink-0 me-3">
                                    <div class="avatar avatar-online">
                                        <img src="{{ asset('assets/img/avatars/man.png') }}" alt class="w-px-40 h-auto rounded-circle" />
                                    </div>
                                </div>
                                <div class="flex-grow-1">
                                    <span class="fw-semibold d-block">{{ $admin->name ?? 'Admin' }}</span>
                                    <small class="text-muted">Admin</small>
                                </div>
                            </div>
                        </a>
                    </li>
                    <li>
                        <div class="dropdown-divider"></div>
                    </li>
                    <li>
                        <a class="dropdown-item" href="{{ route('admin.profile') }}" data-bs-toggle="modal" data-bs-target="#profileModal">
                            <i class="bx bx-user me-2"></i>
                            <span class="align-middle">Profil Saya</span>
                        </a>
                    </li>
                    @if(session('admin_is_superadmin'))
                    <li>
                        <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#addAdminModal">
                            <i class="bx bx-user-plus me-2"></i>
                            <span class="align-middle">Tambah Admin</span>
                        </a>
                    </li>
                    @endif

                    <li>
                        <div class="dropdown-divider"></div>
                    </li>
                    <li>
                        <a class="dropdown-item text-danger" href="{{ route('admin.logout') }}">
                            <i class="bx bx-power-off me-2"></i>
                            <span class="align-middle">Keluar</span>
                        </a>
                    </li>
                </ul>
            </li>
        </ul>
    </div>
</nav>


<!-- 🌸 Modal Profil Admin -->
<div class="modal fade" id="profileModal" tabindex="-1" aria-labelledby="profileModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md">
        <div class="modal-content border-0 shadow-lg rounded-4 overflow-visible">
            <!-- Header -->
            <div class="modal-header border-0 bg-gradient-to-r from-indigo-500 to-blue-500 text-white py-3 position-relative rounded-top-4">
                <h5 class="modal-title fw-semibold" id="profileModalLabel">
                    <i class="bx bx-user-circle me-2"></i> Profil Admin
                </h5>
                <!-- tombol close dikoreksi -->
                <button type="button" class="btn-close position-absolute top-0 end-0 mt-3 me-3"
                    data-bs-dismiss="modal" aria-label="Close"
                    style="filter: invert(1) brightness(200%); opacity: 0.9;"></button>
            </div>

            <!-- Body -->
            <div class="modal-body text-center px-4 py-4 bg-white">
                <div class="position-relative d-inline-block mb-3">
                    <img src="{{ asset('assets/img/avatars/man.png') }}"
                        class="rounded-circle shadow-lg border border-3 border-white"
                        width="110" height="110" alt="Foto Admin">
                </div>

                <h5 class="fw-bold mb-0 text-dark">{{ $admin->name ?? 'Administrator' }}</h5>
                <p class="text-muted small mb-3">Administrator</p>

                <hr class="my-3">

                <div class="text-start px-2">
                    <p class="mb-2"><i class="bx bx-id-card me-2 text-primary"></i> <strong>Nama Lengkap:</strong> {{ $admin->name ?? '-' }}</p>
                    <p class="mb-2"><i class="bx bx-user me-2 text-primary"></i> <strong>Username:</strong> {{ $admin->username ?? '-' }}</p>
                    <p class="mb-0"><i class="bx bx-envelope me-2 text-primary"></i> <strong>Email:</strong> {{ $admin->email ?? '-' }}</p>
                </div>
            </div>

            <!-- Footer -->
            <div class="modal-footer border-0 d-flex justify-content-between px-4 pb-4 bg-white rounded-bottom-4">
                <a href="{{ route('admin.logout') }}" class="btn btn-danger rounded-3 px-3">
                    <i class="bx bx-power-off me-1"></i> Keluar
                </a>
            </div>
        </div>
    </div>
</div>

<style>
    #profileModal .modal-content {
        animation: fadeInUp 0.4s ease;
    }

    @keyframes fadeInUp {
        from {
            transform: translateY(25px);
            opacity: 0;
        }

        to {
            transform: translateY(0);
            opacity: 1;
        }
    }
</style>

<!-- Modal -->
<div class="modal fade custom-modal" id="addAdminModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-4 shadow-lg position-relative modal-animate">

            <!-- Close Button -->
            <button type="button" class="custom-close-btn" data-bs-dismiss="modal">
                ✕
            </button>

            <!-- Modal Header -->
            <div class="px-4 pt-4 pb-2 text-center">
                <h4 class="fw-bold text-dark">Tambah Admin Baru</h4>
            </div>

            <!-- Modal Body -->
            <div class="px-4 pb-4">
                <form action="{{ route('pending.store') }}" method="POST">
                    @csrf

                    <!-- Nama -->
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Nama Admin <span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-control rounded-3" required placeholder="Masukkan nama admin...">
                    </div>

                    <!-- Username -->
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Username <span class="text-danger">*</span></label>
                        <input type="text" name="username" class="form-control rounded-3" required placeholder="Masukkan username admin...">
                    </div>

                    <!-- Email -->
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Email <span class="text-danger">*</span></label>
                        <input type="email" name="email" class="form-control rounded-3" required placeholder="Masukkan email admin...">
                    </div>

                    <!-- Password -->
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Password <span class="text-danger">*</span></label>
                        <input type="password" name="password" class="form-control rounded-3" required placeholder="Masukkan password...">
                    </div>

                    <!-- Tombol -->
                    <div class="d-flex justify-content-end gap-2 mt-4">
                        <button type="button" class="btn btn-light border rounded-3 px-4" data-bs-dismiss="modal">
                            Batal
                        </button>
                        <button type="submit" class="btn btn-primary rounded-3 px-4">
                            Simpan
                        </button>
                    </div>

                </form>
            </div>

        </div>
    </div>
</div>
<style>
    /* Tombol close cantik */
    .custom-close-btn {
        position: absolute;
        top: 14px;
        right: 14px;
        background: #ffffff;
        border: none;
        border-radius: 10px;
        width: 34px;
        height: 34px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 18px;
        color: #555;
        box-shadow: 0 3px 8px rgba(0, 0, 0, 0.18);
        cursor: pointer;
        z-index: 20;
        transition: 0.2s ease;
    }

    .custom-close-btn:hover {
        background: #f2f2f2;
        transform: scale(1.05);
    }

    /* Animasi slide-down */
    .modal-animate {
        transform: translateY(-25px);
        opacity: 0;
        transition: all 0.35s ease;
    }

    .modal.show .modal-animate {
        transform: translateY(0);
        opacity: 1;
    }
</style>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@if(session('success'))
<script>
    Swal.fire({
        icon: 'success',
        title: 'Berhasil!',
        text: "{{ session('success') }}",
        confirmButtonColor: '#15088bff'
    });
</script>
@endif

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

@if(session('success'))
<script>
    Swal.fire({
        icon: 'success',
        title: 'Berhasil!',
        text: "{{ session('success') }}",
        confirmButtonColor: '#15088bff'
    });
</script>
@endif

@if(session('error'))
<script>
    Swal.fire({
        icon: 'error',
        title: 'Gagal!',
        text: "{{ session('error') }}",
        confirmButtonColor: '#d33'
    });
</script>
@endif

@if ($errors->any())
<script>
    Swal.fire({
        icon: 'error',
        title: 'Oops...',
        html: `{!! implode('<br>', $errors->all()) !!}`,
        confirmButtonColor: '#d33'
    });
</script>
@endif