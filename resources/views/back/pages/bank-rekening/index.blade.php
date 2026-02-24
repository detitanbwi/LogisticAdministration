@extends('back.layouts.app')

@section('title', 'Rekening Bank')

@section('page_title', 'Rekening Bank')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.bank-rekening.index') }}">Rekening Bank</a></li>
@endsection

@section('content')
    <div class="d-flex justify-content-end mb-4">
        @can('create.rekening_bank')
            <a href="{{ route('admin.bank-rekening.create') }}" class="btn btn-primary">
                <i class="feather-plus me-2"></i>
                <span>Tambah Rekening</span>
            </a>
        @endcan
    </div>

    <x-back.datatable id="bankRekeningTable" :ajax="route('admin.bank-rekening.index')" :header="['No', 'Nama Bank', 'No Rekening', 'Nama Pemilik', 'Saldo', 'Aksi']" :data="[
        'DT_RowIndex' => ['searchable' => false, 'orderable' => false],
        'nama_bank',
        'no_rekening',
        'nama_pemilik',
        'saldo',
        'action' => ['searchable' => false, 'orderable' => false, 'className' => 'text-end'],
    ]" />
@endsection

@push('scripts')
    <script>
        $(document).on('click', '.delete-btn', function() {
            var id = $(this).data('id');
            Swal.fire({
                title: 'Apakah anda yakin?',
                text: 'Data rekening bank akan dihapus permanen!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal',
            }).then((result) => {
                if (result.value) {
                    $.ajax({
                        url: '{{ route('admin.bank-rekening.index') }}/' + id,
                        type: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(response) {
                            Swal.fire('Terhapus!', response.success, 'success');
                            $('#bankRekeningTable').DataTable().ajax.reload();
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
