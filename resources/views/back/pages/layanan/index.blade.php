@extends('back.layouts.app')

@section('title', 'Layanan')

@section('page_title', 'Layanan')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.layanan.index') }}">Layanan</a></li>
@endsection

@section('content')
    <div class="row mb-4 align-items-center">
        <div class="col">
            {{-- Optional: Add search or filter here if needed --}}
        </div>
        <div class="col-auto">
            @can('create.layanan')
                <a href="{{ route('admin.layanan.create') }}" class="btn btn-primary">
                    <i class="feather-plus me-2"></i>
                    <span>Tambah Layanan</span>
                </a>
            @endcan
        </div>
    </div>

    <x-back.datatable id="layananTable" :ajax="route('admin.layanan.index')" :header="['No', 'Nama Layanan', 'Aksi']" :data="[
        'DT_RowIndex' => ['searchable' => false, 'orderable' => false],
        'nama',
        'action' => ['searchable' => false, 'orderable' => false, 'className' => 'text-end'],
    ]" />
@endsection

@push('scripts')
    <script>
        $(document).on('click', '.delete-btn', function() {
            var id = $(this).data('id');
            Swal.fire({
                title: 'Apakah anda yakin?',
                text: 'Data layanan akan dihapus permanen!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal',
            }).then((result) => {
                if (result.value) {
                    $.ajax({
                        url: '{{ route('admin.layanan.index') }}/' + id,
                        type: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(response) {
                            Swal.fire('Terhapus!', response.success, 'success');
                            $('#layananTable').DataTable().ajax.reload();
                        },
                        error: function(xhr) {
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
