@php
// Deteksi variabel paginator yang dikirim dari controller
$paginator = $paginator ?? $dataKamus ?? $koreksis ?? null;
@endphp

@if($paginator instanceof \Illuminate\Pagination\LengthAwarePaginator)
<div class="d-flex justify-content-center mt-3 mb-4">
    <div class="d-flex flex-wrap justify-content-between align-items-center w-100 px-4" style="max-width: 1100px; gap: 1rem;">

        {{-- Select Jumlah Per Halaman --}}
        <div class="flex-shrink-0">
            <select class="form-select shadow-sm"
                onchange="window.location=this.value"
                style="font-size: 1rem; border-radius: 6px; width: 130px; height: 44px;">
                @foreach ([10, 25, 50, 100] as $size)
                <option value="{{ $paginator->url(1) }}&per_page={{ $size }}"
                    {{ $paginator->perPage() == $size ? 'selected' : '' }}>
                    {{ $size }} / page
                </option>
                @endforeach
            </select>
        </div>

        {{-- Info Jumlah Data --}}
        <div class="text-secondary fw-medium text-center flex-grow-1" style="font-size: 1rem;">
            Showing
            <span class="fw-semibold">{{ $paginator->firstItem() }}</span>
            to
            <span class="fw-semibold">{{ $paginator->lastItem() }}</span>
            of
            <span class="fw-semibold">{{ $paginator->total() }}</span>
            results
        </div>

        {{-- Pagination --}}
        <nav class="flex-shrink-0">
            <ul class="pagination mb-0" style="gap: 6px;">

                {{-- Previous --}}
                @if ($paginator->onFirstPage())
                <li class="page-item disabled">
                    <span class="page-link text-muted fw-semibold"
                        style="font-size: 1rem; width: 44px; height: 44px; display: flex; align-items: center; justify-content: center; border-radius: 6px;">
                        ‹
                    </span>
                </li>
                @else
                <li class="page-item">
                    <a class="page-link fw-semibold"
                        href="{{ $paginator->previousPageUrl() }}"
                        style="font-size: 1rem; width: 44px; height: 44px; display: flex; align-items: center; justify-content: center; border-radius: 6px;">
                        ‹
                    </a>
                </li>
                @endif

                {{-- Pages --}}
                @foreach ($paginator->getUrlRange(
                max(1, $paginator->currentPage() - 2),
                min($paginator->lastPage(), $paginator->currentPage() + 2)
                ) as $page => $url)
                @if ($page == $paginator->currentPage())
                <li class="page-item active">
                    <span class="page-link fw-bold shadow-sm"
                        style="font-size: 1rem; width: 44px; height: 44px; display: flex; align-items: center; justify-content: center; border-radius: 6px; background-color: #6366f1; border: none;">
                        {{ $page }}
                    </span>
                </li>
                @else
                <li class="page-item">
                    <a class="page-link fw-semibold"
                        href="{{ $url }}"
                        style="font-size: 1rem; width: 44px; height: 44px; display: flex; align-items: center; justify-content: center; border-radius: 6px;">
                        {{ $page }}
                    </a>
                </li>
                @endif
                @endforeach

                {{-- Next --}}
                @if ($paginator->hasMorePages())
                <li class="page-item">
                    <a class="page-link fw-semibold"
                        href="{{ $paginator->nextPageUrl() }}"
                        style="font-size: 1rem; width: 44px; height: 44px; display: flex; align-items: center; justify-content: center; border-radius: 6px;">
                        ›
                    </a>
                </li>
                @else
                <li class="page-item disabled">
                    <span class="page-link text-muted fw-semibold"
                        style="font-size: 1rem; width: 44px; height: 44px; display: flex; align-items: center; justify-content: center; border-radius: 6px;">
                        ›
                    </span>
                </li>
                @endif

            </ul>
        </nav>
    </div>
</div>
@endif