{{-- 📘 Modal Detail --}}
<div class="modal fade" id="detailModal{{ $item->id }}" tabindex="-1" aria-labelledby="detailModalLabel{{ $item->id }}" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            {{-- Header --}}
            <div class="modal-header bg-light">
                <h5 class="modal-title fw-semibold" id="detailModalLabel{{ $item->id }}">
                    Detail Kata: {{ $item->kata }}
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            {{-- Body --}}
            <div class="modal-body">
                <table class="table table-borderless align-middle">
                    <tr>
                        <th style="width:180px;" class="text-secondary">Kata</th>
                        <td class="fw-semibold text-dark">{{ $item->kata }}</td>
                    </tr>
                    <tr>
                        <th class="text-secondary">Suku Kata</th>
                        <td>{{ $item->suku_kata ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th class="text-secondary">Kelas Kata</th>
                        <td><span class="badge bg-info text-dark px-3 py-2">{{ $item->kelas_kata }}</span></td>
                    </tr>
                    <tr>
                        <th class="text-secondary">Arti</th>
                        <td class="text-wrap align-top">
                            <div class="p-3 bg-light border rounded small"
                                style="white-space: normal; word-break: break-word; overflow-wrap: break-word; line-height: 1.6;">
                                {{ $item->arti }}
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <th class="text-secondary">Contoh</th>
                        <td>
                            @if ($item->contoh)
                            <blockquote class="blockquote mb-0 ps-3 border-start border-3 border-primary">
                                <small class="text-muted fst-italic text-wrap">“{{ $item->contoh }}”</small>
                            </blockquote>
                            @else
                            -
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th class="text-secondary">Asal Kamus</th>
                        <td><span class="badge bg-secondary px-3 py-2">{{ $item->asal_kamus }}</span></td>
                    </tr>
                    <tr>
                        <th class="text-secondary">Ditambahkan</th>
                        <td>{{ $item->created_at ? \Carbon\Carbon::parse($item->created_at)->format('d-m-Y') : '-' }}</td>
                    </tr>
                </table>
            </div>

            {{-- Footer --}}
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    Tutup
                </button>
            </div>
        </div>
    </div>
</div>