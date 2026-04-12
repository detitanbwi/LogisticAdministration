@extends('back.layouts.app')

@section('title', 'Kapal')

@section('page_title', 'Kapal')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.kapal.index') }}">Kapal</a></li>
@endsection

@section('content')
    <div class="row mb-4 align-items-center">
        <div class="col">
            <div class="input-group" style="max-width: 300px;">
                <span class="input-group-text"><i class="feather-calendar"></i></span>
                <input type="text" class="form-control dt-filter" name="daterange" id="kapalDaterange" value="{{ $daterange }}" readonly>
            </div>
        </div>
        <div class="col-auto">
            @can('create.kapal')
                <a href="{{ route('admin.kapal.create') }}" class="btn btn-primary">
                    <i class="feather-plus me-2"></i>
                    <span>Tambah Kapal</span>
                </a>
            @endcan
        </div>
    </div>

    <x-back.datatable id="kapalTable" :ajax="route('admin.kapal.index')" :header="['No', 'Nama Kapal', 'Jumlah Container', 'Jumlah Invoice', 'Aksi']" :data="[
        'DT_RowIndex' => ['searchable' => false, 'orderable' => false],
        'nama_kapal',
        'total_container' => ['searchable' => false, 'orderable' => true, 'className' => 'text-center'],
        'total_invoice' => ['searchable' => false, 'orderable' => true, 'className' => 'text-center'],
        'action' => ['searchable' => false, 'orderable' => false, 'className' => 'text-end'],
    ]" />
@endsection

@push('scripts')
    <script>
        $(function() {
            if ($('#kapalDaterange').length) {
                $('#kapalDaterange').daterangepicker({
                    autoUpdateInput: false,
                    locale: {
                        cancelLabel: 'Clear',
                        format: 'MM/DD/YYYY'
                    }
                });

                $('#kapalDaterange').on('apply.daterangepicker', function(ev, picker) {
                    $(this).val(picker.startDate.format('MM/DD/YYYY') + ' - ' + picker.endDate.format('MM/DD/YYYY'));
                    $('#kapalTable').DataTable().ajax.reload();
                });

                $('#kapalDaterange').on('cancel.daterangepicker', function(ev, picker) {
                    $(this).val('');
                    $('#kapalTable').DataTable().ajax.reload();
                });
            }
        });

        $(document).on('click', '.delete-btn', function() {
            var id = $(this).data('id');
            Swal.fire({
                title: 'Apakah anda yakin?',
                text: 'Data kapal akan dihapus permanen!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal',
            }).then((result) => {
                if (result.value) {
                    $.ajax({
                        url: '{{ route('admin.kapal.index') }}/' + id,
                        type: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(response) {
                            Swal.fire('Terhapus!', response.success, 'success');
                            $('#kapalTable').DataTable().ajax.reload();
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
