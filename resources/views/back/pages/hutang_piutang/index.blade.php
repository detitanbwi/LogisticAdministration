@extends('back.layouts.app')

@section('title', $type)

@section('page_title', $type)

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="#">Keuangan</a></li>
    <li class="breadcrumb-item"><a href="#">Hutang & Piutang</a></li>
    <li class="breadcrumb-item active">{{ $type }}</li>
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">Catatan {{ $type }}</h5>
                    @if (auth()->user()->can('create.' . strtolower($type)))
                        <button type="button" class="btn btn-primary" onclick="addModal()">
                            <i class="feather-plus me-2"></i> Tambah {{ $type }}
                        </button>
                    @endif
                </div>
                <div class="card-body">
                    <x-back.datatable id="dataTable" :ajax="$type === 'Hutang' ? route('admin.hutang.index') : route('admin.piutang.index')" :header="['No', 'Kode', 'Tanggal', 'Keterangan', 'Nominal', 'Opsi']" :data="[
                        'DT_RowIndex' => ['searchable' => false, 'orderable' => false],
                        'kode',
                        'tanggal',
                        'keterangan',
                        'nominal',
                        'action' => ['searchable' => false, 'orderable' => false, 'className' => 'text-end'],
                    ]" />
                </div>
            </div>
        </div>
    </div>
@endsection

@push('modals')
    <div class="modal fade" id="formModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTitle">Tambah {{ $type }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="dataForm">
                        <input type="hidden" name="jenis" value="{{ $type }}">
                        <input type="hidden" name="id" id="data_id">

                        <div class="mb-3">
                            <label class="form-label">Tanggal <span class="text-danger">*</span></label>
                            <input type="date" class="form-control" name="tanggal" id="tanggal" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Nominal <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="nominal_display" id="nominal_display"
                                placeholder="Masukkan Nominal .." required>
                            <input type="hidden" name="nominal" id="nominal">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Keterangan</label>
                            <textarea class="form-control" name="keterangan" id="keterangan" rows="4" placeholder="Masukkan Keterangan"></textarea>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    <button type="button" class="btn btn-primary" onclick="saveData()">Simpan</button>
                </div>
            </div>
        </div>
    </div>
@endpush

@push('scripts')
    <script>
        let isEdit = false;

        function addModal() {
            isEdit = false;
            $('#dataForm')[0].reset();
            $('#data_id').val('');
            $('#modalTitle').text('Tambah {{ $type }}');
            // Set default date to today
            document.getElementById('tanggal').valueAsDate = new Date();
            $('#formModal').modal('show');
        }

        $(document).on('click', '.edit-btn', function() {
            isEdit = true;
            $('#data_id').val($(this).data('id'));
            $('#tanggal').val($(this).data('tanggal'));

            var nominal = $(this).data('nominal').toString();
            // Assuming data is rounded integer or format without decimals
            nominal = nominal.split('.')[0];
            $('#nominal').val(nominal);
            $('#nominal_display').val(formatNumber(nominal));

            $('#keterangan').val($(this).data('keterangan'));

            $('#modalTitle').text('Edit {{ $type }}');
            $('#formModal').modal('show');
        });

        function saveData() {
            const form = $('#dataForm');
            if (!form[0].checkValidity()) {
                form[0].reportValidity();
                return;
            }

            const data = form.serialize();
            let saveUrl = '{{ route('admin.hutang-piutang.store') }}';
            let method = 'POST';

            if (isEdit) {
                const id = $('#data_id').val();
                saveUrl = '{{ url('admin/hutang-piutang') }}/' + id;
                method = 'PUT';
            }

            $.ajax({
                url: saveUrl,
                method: method,
                data: data + '&_token={{ csrf_token() }}',
                success: function(response) {
                    $('#formModal').modal('hide');
                    $('#dataTable').DataTable().ajax.reload();
                    Swal.fire('Berhasil', 'Data berhasil ' + (isEdit ? 'diperbarui' : 'disimpan'), 'success');
                },
                error: function(xhr) {
                    Swal.fire('Error', 'Gagal menyimpan data.', 'error');
                }
            });
        }

        $(document).on('click', '.delete-btn', function() {
            var id = $(this).data('id');
            Swal.fire({
                title: 'Apakah anda yakin?',
                text: 'Data akan dihapus permanen!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal',
            }).then((result) => {
                if (result.value) {
                    $.ajax({
                        url: '{{ url('admin/hutang-piutang') }}/' + id,
                        type: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(response) {
                            Swal.fire('Terhapus!', response.success, 'success');
                            $('#dataTable').DataTable().ajax.reload();
                        },
                        error: function(xhr) {
                            Swal.fire('Gagal!', 'Terjadi kesalahan saat menghapus data.',
                                'error');
                        },
                    });
                }
            });
        });

        // Helper to format number with thousand separator (dot)
        function formatNumber(angka) {
            var number_string = angka.replace(/[^,\d]/g, '').toString(),
                split = number_string.split(','),
                sisa = split[0].length % 3,
                rupiah = split[0].substr(0, sisa),
                ribuan = split[0].substr(sisa).match(/\d{3}/gi);

            if (ribuan) {
                separator = sisa ? '.' : '';
                rupiah += separator + ribuan.join('.');
            }

            rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
            return rupiah;
        }

        $('#nominal_display').on('keyup', function() {
            var val = $(this).val();
            var formatted = formatNumber(val);
            $(this).val(formatted);
            var numeric = formatted.replace(/\./g, '').replace(/,/g, '.');
            $('#nominal').val(numeric);
        });
    </script>
@endpush
