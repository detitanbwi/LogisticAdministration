@extends('back.layouts.app')

@section('title', 'Customer')

@section('page_title', 'Customer')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.customer.index') }}">Customer</a></li>
@endsection

@section('content')
    <div class="d-flex justify-content-end mb-4">
        @can('create.customer')
            <a href="{{ route('admin.customer.create') }}" class="btn btn-primary">
                <i class="feather-plus me-2"></i>
                <span>Tambah Customer</span>
            </a>
        @endcan
    </div>

    <x-back.datatable id="customerTable" :ajax="route('admin.customer.index')" :header="['No', 'Nama', 'No HP', 'NPWP', 'PIC', 'Jabatan PIC', 'Alamat', 'Catatan', 'Aksi']" :data="[
        'DT_RowIndex' => ['searchable' => false, 'orderable' => false],
        'nama',
        'no_hp',
        'npwp',
        'pic',
        'jabatan_pic',
        'alamat',
        'catatan',
        'action' => ['searchable' => false, 'orderable' => false, 'className' => 'text-end'],
    ]" />
@endsection

@push('scripts')
    <script>
        $(document).on('click', '.delete-btn', function() {
            var id = $(this).data('id');
            Swal.fire({
                title: 'Apakah anda yakin?',
                text: 'Data customer akan dihapus permanen!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal',
            }).then((result) => {
                if (result.value) {
                    $.ajax({
                        url: '{{ route('admin.customer.index') }}/' + id,
                        type: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(response) {
                            Swal.fire('Terhapus!', response.success, 'success');
                            $('#customerTable').DataTable().ajax.reload();
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
