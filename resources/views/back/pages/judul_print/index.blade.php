@extends('back.layouts.app')

@section('title', 'Judul Print')
@section('page_title', 'Master Data Judul Print')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.judul-print.index') }}">Judul Print</a></li>
@endsection

@section('content')
    <div class="d-flex align-items-center mb-4 flex-wrap gap-2">
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#tambahModal">
            <i class="feather-plus me-1"></i> Tambah Judul Print
        </button>
    </div>

    <x-back.datatable id="judulPrintTable" :ajax="route('admin.judul-print.index')" :header="['No', 'Nama Judul Print', 'Aksi']" :data="[
            'DT_RowIndex' => ['searchable' => false, 'orderable' => false],
            'nama',
            'action' => ['searchable' => false, 'orderable' => false, 'className' => 'text-end'],
        ]" />

    @push('modals')
        <!-- Modal Tambah -->
        <div class="modal fade" id="tambahModal" tabindex="-1" aria-labelledby="tambahModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form action="{{ route('admin.judul-print.store') }}" method="POST">
                        @csrf
                        <div class="modal-header">
                            <h5 class="modal-title" id="tambahModalLabel">Tambah Judul Print</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <x-back.text-input name="nama" label="Nama Judul Print" required />
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        @php
            // Ambil semua daftar untuk dirender modal edit-nya. Karena ini master data (relatif sedikit), tidak masalah merender semua
            $judulPrints = \App\Models\JudulPrint::all();
        @endphp

        @foreach ($judulPrints as $jp)
            <!-- Modal Edit -->
            <div class="modal fade" id="editModal{{ $jp->id }}" tabindex="-1" aria-labelledby="editModalLabel{{ $jp->id }}"
                aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <form action="{{ route('admin.judul-print.update', $jp->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="modal-header">
                                <h5 class="modal-title" id="editModalLabel{{ $jp->id }}">Edit Judul Print</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <x-back.text-input name="nama" label="Nama Judul Print" value="{{ $jp->nama }}" required />
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                                <button type="submit" class="btn btn-primary">Simpan</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        @endforeach
    @endpush
@endsection

@push('scripts')
    <script>
        $(document).on('click', '.delete-btn', function () {
            var id = $(this).data('id');
            Swal.fire({
                title: 'Apakah anda yakin?',
                text: 'Data judul print akan dihapus permanen!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal',
            }).then((result) => {
                if (result.value) {
                    $.ajax({
                        url: '{{ route('admin.judul-print.index') }}/' + id,
                        type: 'DELETE',
                        success: function (response) {
                            Swal.fire('Terhapus!', response.success, 'success');
                            $('#judulPrintTable').DataTable().ajax.reload();
                        },
                        error: function (xhr) {
                            var message = 'Terjadi kesalahan saat menghapus data.';
                            if (xhr.responseJSON && xhr.responseJSON.error) {
                                message = xhr.responseJSON.error;
                            }
                            Swal.fire('Gagal!', message, 'error');
                        },
                    });
                }
            });
        });
    </script>
@endpush