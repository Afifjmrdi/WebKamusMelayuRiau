<div class="modal fade" id="editModal{{ $item->id }}" tabindex="-1" aria-labelledby="editModalLabel{{ $item->id }}" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-light">
                <h5 class="modal-title" id="editModalLabel{{ $item->id }}">Edit Data: {{ $item->kata }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <form action="{{ route('admin.update', $item->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="modal-body">
                    <div class="row g-3">

                        <div class="col-md-6">
                            <label class="form-label">Kata</label>
                            <input type="text" name="kata" class="form-control" value="{{ $item->kata }}" required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Suku Kata</label>
                            <input type="text" name="suku_kata" class="form-control" value="{{ $item->suku_kata }}">
                        </div>

                        {{-- DROPDOWN KELAS KATA --}}
                        <div class="col-md-6">
                            <label class="form-label">Kelas Kata</label>
                            <select name="kelas_kata" class="form-select" required>
                                <option value="" disabled>Pilih Kelas Kata</option>
                                @foreach($kelasKataList as $kk)
                                <option value="{{ $kk }}" {{ $item->kelas_kata == $kk ? 'selected' : '' }}>
                                    {{ $kk }}
                                </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- DROPDOWN ASAL KAMUS --}}
                        <div class="col-md-6">
                            <label class="form-label">Asal Kamus</label>
                            <select name="asal_kamus" class="form-select" required>
                                <option value="" disabled>Pilih Asal Kamus</option>
                                @foreach($asalKamusList as $kamus)
                                <option value="{{ $kamus }}" {{ $item->asal_kamus == $kamus ? 'selected' : '' }}>
                                    {{ $kamus }}
                                </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-12">
                            <label class="form-label">Arti</label>
                            <textarea name="arti" class="form-control" rows="2" required>{{ $item->arti }}</textarea>
                        </div>

                        <div class="col-12">
                            <label class="form-label">Contoh</label>
                            <textarea name="contoh" class="form-control" rows="2">{{ $item->contoh }}</textarea>
                        </div>

                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>

            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        // 🗑️ Konfirmasi hapus pakai SweetAlert
        const deleteForms = document.querySelectorAll('form[method="POST"][onsubmit]');
        deleteForms.forEach(form => {
            form.addEventListener('submit', function(e) {
                e.preventDefault(); // cegah submit langsung

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
                        form.submit(); // lanjutkan hapus
                    }
                });
            });
        });

        // 💾 SweetAlert sukses edit data (berdasarkan flash session)
        @if(session('success'))
        Swal.fire({
            icon: 'success',
            title: 'Berhasil!',
            text: "{{ session('success') }}",
            showConfirmButton: false,
            timer: 1800
        });
        @endif

        // ⚠️ SweetAlert error (kalau ada error dari controller)
        @if(session('error'))
        Swal.fire({
            icon: 'error',
            title: 'Gagal!',
            text: "{{ session('error') }}",
            showConfirmButton: true
        });
        @endif
    });
</script>