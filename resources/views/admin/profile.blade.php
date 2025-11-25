<style>
    .modal-backdrop.show {
        opacity: 0.5 !important;
    }

    .modal {
        z-index: 20000 !important;
    }
</style>

<!-- Modal Profil Admin -->
<div class="modal fade" id="profileModal" tabindex="-1" aria-labelledby="profileModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg rounded-4">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title fw-semibold d-flex align-items-center" id="profileModalLabel">
                    <i class="bx bx-user-circle fs-3 me-2"></i> Profil Admin
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body p-4">
                <div class="text-center mb-4">
                    <img src="{{ asset('assets/img/avatars/man.png') }}"
                        class="rounded-circle shadow-sm mb-3"
                        width="100" height="100" alt="Foto Admin">
                    <h5 class="fw-bold mb-0">{{ $admin->name }}</h5>
                    <p class="text-muted mb-0">Administrator</p>
                </div>

                <hr>

                <div class="row mb-3">
                    <div class="col-md-4 fw-semibold text-muted">Nama Lengkap</div>
                    <div class="col-md-8">{{ $admin->name }}</div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-4 fw-semibold text-muted">Username</div>
                    <div class="col-md-8">{{ $admin->username }}</div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-4 fw-semibold text-muted">Email</div>
                    <div class="col-md-8">{{ $admin->email }}</div>
                </div>
            </div>

            <div class="modal-footer d-flex justify-content-between">
                <a href="{{ route('admin.logout') }}" class="btn btn-danger">
                    <i class="bx bx-power-off me-1"></i> Log Out
                </a>
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                    <i class="bx bx-x me-1"></i> Tutup
                </button>
            </div>
        </div>
    </div>
</div>