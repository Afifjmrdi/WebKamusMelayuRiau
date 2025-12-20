@extends('layouts.admin')

@section('content')
<div class="card shadow-sm border-0">
    <div class="card-header bg-success text-white">
        <h5 class="mb-0">
            <i class="bx bx-table"></i> Preview Import Data Kosakata
        </h5>
    </div>

    <div class="card-body">

        {{-- ERROR VALIDASI --}}
        @if($failures->isNotEmpty())
        <div class="alert alert-danger">
            <strong>⚠️ Ditemukan kesalahan data:</strong>
            <ul class="mb-0">
                @foreach($failures as $failure)
                <li>
                    Baris {{ $failure->row() }} :
                    {{ implode(', ', $failure->errors()) }}
                </li>
                @endforeach
            </ul>
        </div>
        @endif

        {{-- TABEL PREVIEW --}}
        <div class="table-responsive">
            <table class="table table-bordered align-middle">
                <thead class="table-light text-center">
                    <tr>
                        <th>Kata</th>
                        <th>Kelas Kata</th>
                        <th>Arti</th>
                        <th>Contoh</th>
                        <th>Asal Kamus</th>
                        <th>Suku Kata</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($rows as $row)
                    <tr>
                        <td>{{ $row['kata'] ?? '-' }}</td>
                        <td>{{ $row['kelas_kata'] ?? '-' }}</td>
                        <td>{{ $row['arti'] ?? '-' }}</td>
                        <td>{{ $row['contoh'] ?? '-' }}</td>
                        <td>{{ $row['asal_kamus'] ?? '-' }}</td>
                        <td>{{ $row['suku_kata'] ?? '-' }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{-- AKSI --}}
        <div class="d-flex justify-content-end gap-2 mt-4">
            <a href="{{ route('admin.kamus') }}" class="btn btn-secondary">
                Batal
            </a>

            @if($failures->isEmpty())
            <form action="{{ route('admin.kamus.import') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="file_path"
                    value="{{ request()->file('file')->store('temp') }}">
                <button class="btn btn-success">
                    <i class="bx bx-check"></i> Import Sekarang
                </button>
            </form>
            @endif
        </div>

    </div>
</div>
@endsection