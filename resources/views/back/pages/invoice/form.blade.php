@extends('back.layouts.app')

@section('title', isset($invoice) ? 'Edit Invoice' : 'Buat Invoice')
@section('page_title', isset($invoice) ? 'Edit Invoice' : 'Buat Invoice')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.invoice.index') }}">Invoice</a></li>
    <li class="breadcrumb-item active">{{ isset($invoice) ? 'Edit' : 'Buat Baru' }}</li>
@endsection

@section('content')
    <form action="{{ isset($invoice) ? route('admin.invoice.update', $invoice->id) : route('admin.invoice.store') }}"
        method="POST" id="invoiceForm">
        @csrf
        @if (isset($invoice))
            @method('PUT')
        @endif

        <div class="row">
            <!-- Left Column: Invoice Info -->
            <div class="col-md-8">
                <!-- Data Invoice -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Informasi Dasar</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <x-back.text-input label="No Invoice" name="no_invoice" :value="$invoice->no_invoice ?? null"
                                    placeholder="Masukkan No Invoice" hint="Masukkan nomor invoice secara manual" />
                            </div>

                        </div>
                    </div>
                </div>

                <!-- Data Pengirim & Penerima -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Pengirim & Penerima</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <x-back.select2 label="Pengirim" name="pengirim_id" :options="$customers
        ->mapWithKeys(fn($item) => [$item->id => $item->nama . ' (' . $item->no_hp . ')'])
        ->toArray()" :selected="$invoice->pengirim_id ?? null"
                                    placeholder="Pilih Pengirim" createOptionForm="#collapseCustomer" toggleType="collapse" />
                            </div>

                            <div class="col-md-6">
                                <x-back.select2 label="Penerima" name="penerima_id" :options="$customers
        ->mapWithKeys(fn($item) => [$item->id => $item->nama . ' (' . $item->no_hp . ')'])
        ->toArray()" :selected="$invoice->penerima_id ?? null"
                                    placeholder="Pilih Penerima" createOptionForm="#collapseCustomer" toggleType="collapse" />
                            </div>

                            <div class="col-12">
                                <x-back.select2 label="Up (Contact Person)" name="up" :options="$customers
        ->mapWithKeys(fn($item) => [$item->id => $item->nama . ' (' . $item->no_hp . ')'])
        ->toArray()"
                                    :selected="$invoice->up ?? null" placeholder="Pilih Up" createOptionForm="#collapseCustomer" toggleType="collapse" />
                            </div>

                            <!-- Form Tambah Customer Inline -->
                            <div class="col-12 collapse mt-3" id="collapseCustomer">
                                <div class="card card-body bg-light border-0 shadow-sm">
                                    <h6 class="mb-3">Tambah Customer Baru</h6>
                                    <div id="customerForm">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <x-back.text-input name="nama" label="Nama Customer" placeholder="Masukkan Nama Customer" />
                                            </div>
                                            <div class="col-md-4">
                                                <x-back.text-input name="no_hp" label="No HP/WA" placeholder="Masukkan Nomor HP" />
                                            </div>
                                            <div class="col-md-4">
                                                <x-back.text-input name="alamat" label="Alamat" placeholder="Masukkan Alamat" />
                                            </div>
                                            <div class="col-12 d-flex justify-content-end gap-2 mt-3">
                                                <button type="button" class="btn btn-sm btn-secondary" onclick="$('#collapseCustomer').collapse('hide')">Batal</button>
                                                <button type="button" class="btn btn-sm btn-primary" onclick="saveCustomer()">Simpan</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Status & Dokumen Operations -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Detail Operasional & Dokumen</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <x-back.text-input type="date" label="Tanggal Masuk" name="tgl_masuk"
                                    :value="isset($invoice) && $invoice->tgl_masuk
        ? $invoice->tgl_masuk->format('Y-m-d')
        : ''" />
                            </div>

                            <div class="col-md-6 mb-3">
                                <x-back.select2 label="Contr/Seal" name="container_id" :options="$containers->mapWithKeys(function($c) {
                                    $kapal = $c->kapal ? $c->kapal->nama_kapal : '-';
                                    $asal = $c->asal ? $c->asal->nama_tujuan : '-';
                                    $tujuan = $c->tujuan ? $c->tujuan->nama_tujuan : '-';
                                    return [$c->id => $c->nomor_container . ' (' . $kapal . ' | ' . $asal . ' -> ' . $tujuan . ')'];
                                })->toArray()" :selected="$invoice->container_id ?? null"
                                    placeholder="Pilih Contr/Seal" createOptionForm="#collapseContainer" toggleType="collapse" />
                            </div>

                            <!-- Inline Container Form -->
                            <div class="col-12 collapse mt-2 mb-3" id="collapseContainer">
                                <div class="card card-body bg-light border-0 shadow-sm">
                                    <h6 class="mb-3">Tambah Contr/Seal Baru</h6>
                                    <div id="containerForm">
                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <x-back.text-input name="nomor_container" label="Nomor Contr/Seal" placeholder="Masukkan Nomor Container / Seal" />
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <x-back.select2 label="Kapal" name="kapal_id" id="inline_kapal_id" :options="App\Models\Kapal::pluck('nama_kapal', 'id')->toArray()" placeholder="Pilih Kapal" createOptionForm="#collapseKapal" toggleType="collapse" />

                                                <div class="collapse mt-2" id="collapseKapal">
                                                    <div class="p-2 border rounded bg-white">
                                                        <x-back.text-input name="new_nama_kapal" id="new_nama_kapal" label="Nama Kapal Baru" placeholder="Nama Kapal" />
                                                        <div class="d-flex justify-content-end gap-2 mt-2">
                                                            <button type="button" class="btn btn-sm btn-secondary" onclick="$('#collapseKapal').collapse('hide')">Batal</button>
                                                            <button type="button" class="btn btn-sm btn-primary" onclick="saveKapalInline()">Simpan Kapal</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <x-back.select2 label="Pelabuhan Asal" name="asal_id" id="inline_asal_id" :options="App\Models\Tujuan::pluck('nama_tujuan', 'id')->toArray()" placeholder="Pilih Asal" createOptionForm="#collapseTujuan" toggleType="collapse" />
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <x-back.select2 label="Pelabuhan Tujuan" name="tujuan_id" id="inline_tujuan_id" :options="App\Models\Tujuan::pluck('nama_tujuan', 'id')->toArray()" placeholder="Pilih Tujuan" createOptionForm="#collapseTujuan" toggleType="collapse" />

                                                <div class="collapse mt-2" id="collapseTujuan">
                                                    <div class="p-2 border rounded bg-white">
                                                        <x-back.text-input name="new_nama_tujuan" id="new_nama_tujuan" label="Nama Tujuan Baru" placeholder="Nama Tujuan" />
                                                        <div class="d-flex justify-content-end gap-2 mt-2">
                                                            <button type="button" class="btn btn-sm btn-secondary" onclick="$('#collapseTujuan').collapse('hide')">Batal</button>
                                                            <button type="button" class="btn btn-sm btn-primary" onclick="saveTujuanInline()">Simpan Tujuan</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <x-back.text-input type="date" name="etd" label="ETD (Estimasi Berangkat)" />
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <x-back.text-input type="date" name="eta" label="ETA (Estimasi Tiba)" />
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <x-back.select2 label="Tipe Kontainer" name="tipe_kontainer" :options="['20FT' => '20FT', '40FT' => '40FT', '40HC' => '40HC', '45HC' => '45HC']" />
                                            </div>
                                            <div class="col-12 mb-3">
                                                <x-back.text-input name="catatan" label="Catatan Container - Packing list" placeholder="Tulis catatan (opsional)" />
                                            </div>
                                            <div class="col-12 d-flex justify-content-end gap-2 mt-2">
                                                <button type="button" class="btn btn-sm btn-secondary" onclick="$('#collapseContainer').collapse('hide')">Batal</button>
                                                <button type="button" class="btn btn-sm btn-primary" onclick="saveContainer()">Simpan Container</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- End Inline Container Form -->

                            <div class="col-md-12 mb-3">
                                <x-back.textarea label="Catatan Invoice - Barang" name="catatan_muntahan" rows="3"
                                    placeholder=""
                                    :value="$invoice->catatan_muntahan ?? null" />
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <!-- Right Column: Settings -->
            <div class="col-md-4">
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Detail Pengiriman</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <x-back.select2 label="Status PKP" name="pkp_status" :options="['Non PKP' => 'Non PKP', 'PKP' => 'PKP']" :selected="$invoice->pkp_status ?? 'Non PKP'"
                                onchange="calculateTotal()" id="pkp_status" />
                        </div>

                        <div class="mb-3">
                            <x-back.select2 label="Metode Pengiriman" name="metode" :options="['FCL' => 'FCL', 'LCL' => 'LCL', 'Break Bulk' => 'Break Bulk']" :selected="$invoice->metode ?? 'FCL'" />
                        </div>

                        <div class="mb-3">
                            <x-back.select2 label="Layanan" name="layanan" :options="[
        'Door to Door' => 'DOOR TO DOOR',
        'CY to CY' => 'CY TO CY',
        'CY to Door' => 'CY TO DOOR',
        'Door to CY' => 'DOOR TO CY',
        'Port to Port' => 'PORT TO PORT',
    ]" :selected="$invoice->layanan ?? 'DOOR TO DOOR'" />
                        </div>

                        <div class="mb-3">
                            <x-back.select2 label="Daerah Tujuan" name="tujuan_daerah_id" id="tujuan_daerah_id"
                                :options="$tujuanDaerahs->pluck('nama', 'id')->toArray()"
                                :selected="old('tujuan_daerah_id', $invoice->tujuan_daerah_id ?? null)"
                                placeholder="Pilih Daerah Tujuan"
                                createOptionForm="#collapseTujuanDaerah" toggleType="collapse" />
                        </div>

                        <!-- Inline Tujuan Daerah Form -->
                        <div class="collapse mb-3" id="collapseTujuanDaerah">
                            <div class="card card-body bg-light border-0 shadow-sm py-3">
                                <h6 class="fw-bold mb-3">Tambah Daerah Tujuan Baru</h6>
                                <div class="mb-3">
                                    <x-back.text-input name="new_tujuan_daerah" id="new_tujuan_daerah" label="Nama Daerah" placeholder="Masukkan Nama Daerah" />
                                </div>
                                <div class="d-flex justify-content-end gap-2">
                                    <button type="button" class="btn btn-sm btn-secondary px-3" onclick="$('#collapseTujuanDaerah').collapse('hide')">Batal</button>
                                    <button type="button" class="btn btn-sm btn-primary px-3" onclick="saveTujuanDaerah()">Simpan</button>
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <x-back.select2 label="Tanda Terima" name="tanda_terima" :options="['SCJ' => 'SCJ', 'Pengirim' => 'Pengirim']" :selected="$invoice->tanda_terima ?? 'SCJ'" />
                        </div>

                        <div class="mb-0">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" name="show_stamp" id="show_stamp" value="1" {{ isset($invoice) && $invoice->show_stamp ? 'checked' : '' }}>
                                <label class="form-check-label fw-bold cursor-pointer" for="show_stamp">
                                    Tampilkan Stampel & Tandatangan
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Invoice Items -->
            <div class="col-md-12 mb-4">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0">Item Invoice</h5>
                        <button type="button" class="btn btn-sm btn-success" onclick="addItem()">
                            <i class="feather-plus me-1"></i> Tambah Item
                        </button>
                    </div>
                    <div class="card-body p-0">
                        <div class="p-4 border-bottom">
                            <div id="itemContainer">
                                {{-- Rows will be populated by JS --}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Additional Fees -->
            <div class="col-md-12 mb-4">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0">Biaya Tambahan (Opsional)</h5>
                        <button type="button" class="btn btn-sm btn-secondary" onclick="addFee()">
                            <i class="feather-plus me-1"></i> Tambah Biaya
                        </button>
                    </div>
                    <div class="card-body p-0">
                        <div class="p-4 border-bottom">
                            <div id="feeContainer">
                                {{-- Fee rows will be populated by JS --}}
                            </div>
                        </div>

                        <div class="p-4 d-flex justify-content-end bg-light col-12 ms-0 mt-0">
                            <div style="min-width: 250px;">
                                <div class="d-flex justify-content-between mb-2">
                                    <span class="fw-medium text-muted">Total DPP</span>
                                    <span class="fw-bold" id="totalDPP">0</span>
                                </div>
                                <div class="d-flex justify-content-between mb-2">
                                    <span class="fw-medium text-muted">PKP (1.1%)</span>
                                    <span class="fw-bold" id="totalPPN">0</span>
                                </div>
                                <div class="d-flex justify-content-between mb-2">
                                    <span class="fw-medium text-muted">Total Biaya Tambahan</span>
                                    <span class="fw-bold" id="totalFee">0</span>
                                </div>
                                <hr>
                                <div class="d-flex justify-content-between">
                                    <span class="fw-bold text-dark">Grand Total</span>
                                    <span class="fw-bold text-dark fs-5" id="grandTotal">0</span>
                                </div>
                            </div>
                        </div>
                        @error('items')
                            <div class="text-danger p-2">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="col-12 d-flex justify-content-end gap-2 mb-5">
                <a href="{{ route('admin.invoice.index') }}" class="btn btn-secondary">Batal</a>
                <button type="button" class="btn btn-info" onclick="previewInvoice()">
                    <i class="feather-eye me-1"></i> Preview
                </button>
                <button type="submit" class="btn btn-primary">Simpan
                    Invoice</button>
            </div>
        </div>
    </form>
@endsection

@push('modals')
    <!-- Modals skipped for brevity -->
@endpush

@push('scripts')
    <script>
        $(document).ready(function() {
            // Initial calculation
            calculateTotal();

            // Bind change event manually for Select2
            $('#pkp_status').on('change', function() {
                calculateTotal();
            });

            // Matikan tombol enter untuk submit form otomatis
            $(window).keydown(function(event){
                if(event.keyCode == 13) {
                    event.preventDefault();
                    return false;
                }
            });

            // Prevent double submission only if not previewing
            $('#invoiceForm').on('submit', function(e) {
                var form = $(this);
                if (form.attr('target') === '_blank') {
                    return true; // Let the preview open without disabling button
                }

                var btn = form.find('button[type="submit"]');
                if (btn.data('submitted')) {
                    return false; // Prevent multiple submits
                }
                btn.data('submitted', true);
                btn.prop('disabled', true);
                btn.html('<i class="spinner-border spinner-border-sm me-2"></i>Menyimpan...');
            });
        });

        function previewInvoice() {
            const form = $('#invoiceForm');
            if (!form[0].checkValidity()) {
                form[0].reportValidity();
                return;
            }

            const originalAction = form.attr('action');

            form.attr('action', '{{ route('admin.invoice.preview') }}');
            form.attr('target', '_blank');
            form.submit();

            // Restore action and target immediately
            setTimeout(function() {
                form.attr('action', originalAction);
                form.removeAttr('target');
            }, 500);
        }

        // --- Ajax Save Functions ---
        function clearFormErrors(form) {
            form.find('.is-invalid').removeClass('is-invalid');
            form.find('.invalid-feedback').remove();
        }

        function showFormErrors(form, errors) {
            clearFormErrors(form);
            $.each(errors, function(field, messages) {
                const input = form.find('[name="' + field + '"]');
                input.addClass('is-invalid');
                input.after('<div class="invalid-feedback">' + messages[0] + '</div>');
            });
        }

        function saveCustomer() {
            const form = $('#customerForm');
            const data = form.find(':input').serialize();
            $.ajax({
                url: '{{ route('admin.customer.store') }}',
                method: 'POST',
                data: data + '&_token={{ csrf_token() }}',
                success: function(response) {
                    $('#collapseCustomer').collapse('hide');
                    form.find('input, textarea').val('');
                    const newText = response.nama + ' (' + response.no_hp + ')';
                    const newOption1 = new Option(newText, response.id, false, false);
                    const newOption2 = new Option(newText, response.id, false, false);
                    const newOption3 = new Option(newText, response.id, false, false);
                    $('#pengirim_id').append(newOption1).trigger('change');
                    $('#penerima_id').append(newOption2).trigger('change');
                    $('#up').append(newOption3).trigger('change');
                    Swal.fire('Berhasil', 'Data customer berhasil ditambahkan', 'success');
                },
                error: function(xhr) {
                    Swal.fire('Error', 'Gagal menyimpan data.', 'error');
                }
            });
        }

        function saveContainer() {
            const form = $('#containerForm');
            const data = form.find(':input').serialize();
            $.ajax({
                url: '{{ route('admin.packing-list.store') }}',
                method: 'POST',
                data: data + '&_token={{ csrf_token() }}',
                success: function(response) {
                    $('#collapseContainer').collapse('hide');
                    form.find('input, select, textarea').val('').trigger('change');
                    const asaltxt = $('#inline_asal_id option:selected').text() || '-';
                    const tujuantxt = $('#inline_tujuan_id option:selected').text() || '-';
                    const kapaltxt = $('#inline_kapal_id option:selected').text() || '-';
                    const newOption = new Option((response.nomor_container || response.name) + ' (' + kapaltxt + ' | ' + asaltxt + ' -> ' + tujuantxt + ')', response.id, false, false);
                    $('#container_id').append(newOption).trigger('change');
                    Swal.fire('Berhasil', 'Data Contr/Seal berhasil ditambahkan', 'success');
                },
                error: function(xhr) {
                    Swal.fire('Error', 'Gagal menyimpan data container.', 'error');
                }
            });
        }

        function saveKapalInline() {
            const nama = $('#new_nama_kapal').val();
            if (!nama) return;
            $.ajax({
                url: '{{ route('admin.kapal.store') }}',
                method: 'POST',
                data: { nama_kapal: nama, _token: '{{ csrf_token() }}' },
                success: function(response) {
                    $('#collapseKapal').collapse('hide');
                    $('#new_nama_kapal').val('');
                    const newHtml = `<option value="${response.id}" selected>${response.nama_kapal}</option>`;
                    $('#inline_kapal_id').append(newHtml).trigger('change');
                    Swal.fire('Berhasil', 'Data kapal ditambahkan', 'success');
                },
                error: function(xhr) {
                    Swal.fire('Error', 'Gagal menyimpan data kapal.', 'error');
                }
            });
        }

        function saveTujuanInline() {
            const nama = $('#new_nama_tujuan').val();
            if (!nama) return;
            $.ajax({
                url: '{{ route('admin.tujuan.store') }}',
                method: 'POST',
                data: { nama_tujuan: nama, _token: '{{ csrf_token() }}' },
                success: function(response) {
                    $('#collapseTujuan').collapse('hide');
                    $('#new_nama_tujuan').val('');
                    const newHtml = `<option value="${response.id}" selected>${response.nama_tujuan}</option>`;
                    $('#inline_asal_id').append(newHtml);
                    $('#inline_tujuan_id').append(newHtml).trigger('change');
                    Swal.fire('Berhasil', 'Data lokasi tujuan ditambahkan', 'success');
                },
                error: function(xhr) {
                    Swal.fire('Error', 'Gagal menyimpan data lokasi.', 'error');
                }
            });
        }

        function saveTujuanDaerah() {
            var nama = $('#new_tujuan_daerah').val();
            if (!nama) {
                Swal.fire('Error', 'Nama Daerah wajib diisi', 'error');
                return;
            }
            $.ajax({
                url: '{{ route("admin.tujuan-daerah.store") }}',
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    nama: nama
                },
                success: function(res) {
                    var $select = $('#tujuan_daerah_id');
                    var newOption = new Option(res.nama, res.id, true, true);
                    $select.append(newOption).trigger('change');
                    $('#new_tujuan_daerah').val('');
                    $('#collapseTujuanDaerah').collapse('hide');
                    Swal.fire('Berhasil', 'Daerah Tujuan berhasil ditambahkan', 'success');
                },
                error: function(xhr) {
                    var message = 'Gagal menambahkan Daerah Tujuan.';
                    if (xhr.responseJSON && xhr.responseJSON.errors) {
                        message = Object.values(xhr.responseJSON.errors).flat().join('\n');
                    }
                    Swal.fire('Error', message, 'error');
                }
            });
        }



        // --- Item Logic ---

        // Helper to format number with thousand separator (dot)
        function formatNumber(n) {
            // Check if n is valid number
            if (n === '' || n === null || n === undefined) return '';
            // Convert to string and split decimal
            let parts = n.toString().split('.');
            // Format integer part
            parts[0] = parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, ".");
            // Join with comma if decimal exists (user view)
            // But wait, the standard input for decimal in ID is comma?
            // Let's assume input uses comma for decimal, or just dot?
            // The request says "thousand separator".

            // Let's stick to standard behavior:
            // Input value: 10000 -> 10.000
            // Input value: 10000.50 -> 10.000,50

            // However, solving the decimal separator in a text input is tricky without a library.
            // Let's simplify: replace dot with comma for display.

            return parts.join(','); // This might be simplistic if n already has dots
        }

        // We need a robust formatter that handles raw typing
        function formatCurrencyInput(input) {
            let value = input.value;
            let clean = value.replace(/[^\d,]/g, '');
            let parts = clean.split(',');
            parts[0] = parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, ".");
            if (parts.length > 2) {
                clean = parts[0] + ',' + parts.slice(1).join('');
            } else {
                clean = parts.join(',');
            }
            input.value = clean;
            return clean;
        }

        function formatDecimalInput(input) {
            let value = input.value;
            // Allow digits, comma, and one dot for thousand separator (though usually qty doesn't need dots)
            // But we follow the same style: comma for decimal
            let clean = value.replace(/[^\d,]/g, '');
            let parts = clean.split(',');
            if (parts.length > 2) {
                clean = parts[0] + ',' + parts.slice(1).join('');
            } else {
                clean = parts.join(',');
            }
            input.value = clean;
            return clean;
        }

        function parseCurrency(value) {
            if (!value) return 0;
            if (typeof value === 'number') return value;
            let clean = value.toString().replace(/\./g, '').replace(/,/g, '.');
            return parseFloat(clean) || 0;
        }

        let itemIndex = 0;
        let feeIndex = 0;
        const initialItems = @json(old('items', isset($invoice) && $invoice->items ? $invoice->items : []));
        const initialFees = @json(old('additional_fees', isset($invoice) && $invoice->additionalFees ? $invoice->additionalFees : []));

        if (initialItems.length > 0) {
            initialItems.forEach(item => {
                const rowId = addItemRow(item);
                calculateSubtotal(rowId);
            });
        } else {
            addItem();
        }

        if (initialFees && initialFees.length > 0) {
            initialFees.forEach(fee => {
                addFeeRow(fee);
            });
        }
        
        calculateTotal();

        function togglePLT(rowId) {
            const row = $(`#row_${rowId}`);
            const satuan = row.find('select[name*="[satuan]"]').val();
            const subTableWrapper = row.find('.sub-table-wrapper');
            const koliInput = row.find('.koli-input');
            const qtyInput = row.find('.qty-input');
            
            if (satuan === 'M3' || satuan === 'Kg') {
                subTableWrapper.removeClass('d-none');
                row.find('.table-responsive').removeClass('d-none');
                row.find(`.toggle-icon-${rowId}`).css('transform', 'rotate(0deg)');
                // Ensure at least one detail row exists
                if ($(`#detail_container_${rowId}`).children().length === 0) {
                    // Try to migrate data from parent if exists
                    const p = row.data('p-old') || 0;
                    const l = row.data('l-old') || 0;
                    const t = row.data('t-old') || 0;
                    const k = row.find('.koli-input').val() || 0;
                    addDetailRow(rowId, {p: p, l: l, t: t, koli: k});
                }
                // Parent Koli & Qty become calculated but still editable as fallback?
                // User said "Koli dan Jumlah... itulah yang ditampilkan", usually we want to prevent manual edit if subtable exists, 
                // but for now let's keep them editable as requested in brainstorming.
            } else {
                subTableWrapper.addClass('d-none');
                // If Unit, usually Jumlah = 0 as requested
                if (satuan === 'Unit') {
                    row.find('.qty-input').val('0');
                    $(`#jumlah_hidden_${rowId}`).val(0);
                    calculateSubtotal(rowId);
                }
            }
            calculateTotal();
        }

        function addDetailRow(rowId, data = {}) {
            const container = $(`#detail_container_${rowId}`);
            const detailIndex = container.children().length;
            const p = data.p || 0;
            const l = data.l || 0;
            const t = data.t || 0;
            const koli = data.koli || 0;
            const jumlah = data.jumlah || 0;

            const html = `
                <tr class="detail-row">
                    <td class="text-center align-middle detail-no">${detailIndex + 1}</td>
                    <td><input type="number" step="0.1" class="form-control form-control-sm det-p" name="items[${rowId}][details][${detailIndex}][p]" value="${p}" placeholder="0" oninput="calculateSubTotalDetail(${rowId})"></td>
                    <td><input type="number" step="0.1" class="form-control form-control-sm det-l" name="items[${rowId}][details][${detailIndex}][l]" value="${l}" placeholder="0" oninput="calculateSubTotalDetail(${rowId})"></td>
                    <td><input type="number" step="0.1" class="form-control form-control-sm det-t" name="items[${rowId}][details][${detailIndex}][t]" value="${t}" placeholder="0" oninput="calculateSubTotalDetail(${rowId})"></td>
                    <td><input type="number" class="form-control form-control-sm det-koli" name="items[${rowId}][details][${detailIndex}][koli]" value="${koli}" placeholder="0" oninput="calculateSubTotalDetail(${rowId})"></td>
                    <td><input type="text" class="form-control form-control-sm font-monospace det-jumlah bg-light" name="items[${rowId}][details][${detailIndex}][jumlah]" value="${formatVal(jumlah, 3)}" readonly></td>
                    <td class="text-center">
                        <div class="btn-group btn-group-sm">
                            <button type="button" class="btn btn-soft-success btn-icon" onclick="addDetailRow(${rowId})"><i class="feather-plus"></i></button>
                            <button type="button" class="btn btn-soft-danger btn-icon" onclick="removeDetailRow(this, ${rowId})"><i class="feather-trash-2"></i></button>
                        </div>
                    </td>
                </tr>
            `;
            container.append(html);
            updateDetailNumbers(rowId);
            calculateSubTotalDetail(rowId);
        }

        function removeDetailRow(btn, rowId) {
            const container = $(`#detail_container_${rowId}`);
            if (container.children().length > 1) {
                $(btn).closest('tr').remove();
                updateDetailNumbers(rowId);
                // No auto calculate parent here as per feedback, only when Kalkulasi is clicked
            } else {
                Swal.fire('Info', 'Minimal harus ada 1 baris rincian', 'info');
            }
        }

        function updateDetailNumbers(rowId) {
            $(`#detail_container_${rowId} .detail-row`).each(function(index) {
                $(this).find('.detail-no').text(index + 1);
                // Update input names index to keep them sequential for Laravel
                $(this).find('.det-p').attr('name', `items[${rowId}][details][${index}][p]`);
                $(this).find('.det-l').attr('name', `items[${rowId}][details][${index}][l]`);
                $(this).find('.det-t').attr('name', `items[${rowId}][details][${index}][t]`);
                $(this).find('.det-koli').attr('name', `items[${rowId}][details][${index}][koli]`);
                $(this).find('.det-jumlah').attr('name', `items[${rowId}][details][${index}][jumlah]`);
            });
        }

        function calculateSubTotalDetail(rowId) {
            const satuan = $(`#row_${rowId}`).find('select[name*="[satuan]"]').val();
            $(`#detail_container_${rowId} .detail-row`).each(function() {
                const p = parseFloat($(this).find('.det-p').val()) || 0;
                const l = parseFloat($(this).find('.det-l').val()) || 0;
                const t = parseFloat($(this).find('.det-t').val()) || 0;
                const koli = parseFloat($(this).find('.det-koli').val()) || 0;

                let result = 0;
                if (satuan === 'M3') {
                    result = (p * l * t * koli) / 1000000;
                } else if (satuan === 'Kg') {
                    result = (p * l * t * koli) / 4000;
                }
                
                // Store raw value with high precision in a data attribute
                $(this).find('.det-jumlah').data('raw-value', result);
                // Truncate to 3 decimal places without rounding for display
                $(this).find('.det-jumlah').val(formatValTruncate(result, 3));
            });
            updateSubTableSummary(rowId);
        }

        function updateSubTableSummary(rowId) {
            const row = $(`#row_${rowId}`);
            let totalKoli = 0;
            let totalJumlah = 0;

            $(`#detail_container_${rowId} .detail-row`).each(function() {
                const koli = parseFloat($(this).find('.det-koli').val()) || 0;
                // Use the raw value if available to avoid cumulative rounding errors
                const rawVal = $(this).find('.det-jumlah').data('raw-value');
                const jumlah = rawVal !== undefined ? parseFloat(rawVal) : (parseCurrency($(this).find('.det-jumlah').val()) || 0);
                
                totalKoli += koli;
                totalJumlah += jumlah;
            });

            row.find('.total-koli-sub').text(totalKoli);
            row.find('.total-jumlah-sub').text(formatValTruncate(totalJumlah, 3));
            row.find('.total-jumlah-sub').data('raw-value', totalJumlah);

            return { totalKoli, totalJumlah };
        }

        function kalkulasiItem(rowId) {
            const summary = updateSubTableSummary(rowId);
            const row = $(`#row_${rowId}`);

            // Sync to parent
            row.find('.koli-input').val(summary.totalKoli);
            // Use 3 decimals truncated for display
            row.find('.qty-input').val(formatValTruncate(summary.totalJumlah, 3));
            $(`#jumlah_hidden_${rowId}`).val(summary.totalJumlah.toFixed(4));

            calculateSubtotal(rowId);
        }

        function toggleMinimizeVolume(rowId) {
            const row = $(`#row_${rowId}`);
            const table = row.find('.table-responsive');
            const icon = row.find(`.toggle-icon-${rowId}`);
            
            table.toggleClass('d-none');
            if (table.hasClass('d-none')) {
                icon.css('transform', 'rotate(-90deg)');
            } else {
                icon.css('transform', 'rotate(0deg)');
            }
        }

        function addItem() {
            addItemRow({});
        }

        function formatVal(n, precision = null) {
            if (n === null || n === undefined || n === '') return '0';
            let val = parseFloat(n);
            if (isNaN(val)) return '0';
            
            let str = precision !== null ? val.toFixed(precision) : val.toString();
            let parts = str.split('.');
            parts[0] = parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, ".");
            return parts.join(',');
        }

        // Helper to format number with truncation (no rounding)
        function formatValTruncate(n, precision = 3) {
            if (n === null || n === undefined || n === '') return '0';
            let val = parseFloat(n);
            if (isNaN(val)) return '0';
            
            // Truncate by multiplying 10^precision, floor, then dividing back
            let factor = Math.pow(10, precision);
            let truncated = Math.floor(val * factor) / factor;
            
            let str = truncated.toFixed(precision);
            let parts = str.split('.');
            parts[0] = parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, ".");
            return parts.join(',');
        }

        function addItemRow(data) {
            const rowId = itemIndex++;
            const jenisBarang = data.jenis_barang || '';
            const koli = data.koli || '';
            
            // Legacy data support
            const p = data.p || 0;
            const l = data.l || 0;
            const t = data.t || 0;

            let jumlah = data.jumlah || 0;
            let hargaSatuan = data.harga_satuan || 0;
            let subtotal = data.subtotal || 0;

            const jumlahDisplay = formatVal(jumlah, 3);
            const hargaSatuanDisplay = formatVal(hargaSatuan);

            const satuan = data.satuan || 'Unit';

            // We need to ensure subtotal is calculated correctly if data is present
            if (jumlah && hargaSatuan && !subtotal) {
                subtotal = parseFloat(jumlah) * parseFloat(hargaSatuan);
            }

            const html = `
                <div class="row align-items-end gx-2 gy-3 mb-3 pb-3 border-bottom item-row" id="row_${rowId}" 
                    data-p-old="${data.p || 0}" data-l-old="${data.l || 0}" data-t-old="${data.t || 0}">
                    <div class="col-md-3 jenis-group">
                        <label class="form-label fs-12 mb-1 text-muted">Jenis Barang</label>
                        <input type="text" class="form-control" name="items[${rowId}][jenis_barang]" value="${jenisBarang}" required placeholder="Contoh: Kayu Jati">
                    </div>
                    <div class="col-md-1 koli-group">
                        <label class="form-label fs-12 mb-1 text-muted">Koli</label>
                        <input type="number" class="form-control koli-input" name="items[${rowId}][koli]" value="${koli}" required placeholder="1" oninput="handleInput(this, ${rowId})">
                    </div>

                    <div class="col-md-2 jumlah-group">
                        <label class="form-label fs-12 mb-1 text-muted">Jumlah (M3/Kg)</label>
                        <input type="text" class="form-control qty-input font-monospace" value="${jumlahDisplay}" required oninput="handleInput(this, ${rowId})" placeholder="0">
                        <input type="hidden" name="items[${rowId}][jumlah]" id="jumlah_hidden_${rowId}" value="${jumlah}">
                    </div>

                    <div class="col-md-1 satuan-group">
                        <label class="form-label fs-12 mb-1 text-muted">Satuan</label>
                        <select class="form-select" name="items[${rowId}][satuan]" required onchange="togglePLT(${rowId})">
                            <option value="M3" ${satuan === 'M3' ? 'selected' : ''}>M3</option>
                            <option value="Kg" ${satuan === 'Kg' ? 'selected' : ''}>Kg</option>
                            <option value="Unit" ${satuan === 'Unit' ? 'selected' : ''}>Unit</option>
                        </select>
                    </div>

                    <div class="col-md-2 price-group">
                        <label class="form-label fs-12 mb-1 text-muted">Harga Satuan</label>
                        <div class="input-group">
                            <span class="input-group-text px-2">Rp</span>
                            <input type="text" class="form-control price-input" value="${hargaSatuanDisplay}" required oninput="handleInput(this, ${rowId})" placeholder="0">
                        </div>
                        <input type="hidden" name="items[${rowId}][harga_satuan]" id="harga_satuan_hidden_${rowId}" value="${hargaSatuan}">
                    </div>
                    <div class="col-md-2 mt-3 mt-md-0">
                        <label class="form-label fs-12 mb-1 text-muted d-block text-md-end">Subtotal</label>
                        <input type="hidden" name="items[${rowId}][subtotal]" id="subtotal_input_${rowId}" value="${subtotal}">
                        <div class="input-group">
                            <span class="input-group-text px-2 bg-light border-dashed">Rp</span>
                            <input type="text" class="form-control bg-light border-dashed fw-bold text-end" id="subtotal_display_${rowId}" value="${new Intl.NumberFormat('id-ID').format(subtotal)}" readonly>
                        </div>
                    </div>
                    <div class="col-md-1 col-2 text-md-center text-end">
                        <label class="form-label fs-12 mb-1 text-muted d-none d-md-block">&nbsp;</label>
                        <button type="button" class="btn btn-soft-danger btn-icon" onclick="removeRow(${rowId})">
                            <i class="feather-trash-2"></i>
                        </button>
                    </div>

                    <!-- Sub Table Container -->
                    <div class="col-12 sub-table-wrapper d-none mt-2">
                        <div class="p-2 border border-dashed rounded bg-light cursor-pointer d-flex align-items-center mb-2" onclick="toggleMinimizeVolume(${rowId})">
                            <i class="feather-chevron-down me-2 toggle-icon-${rowId}" style="transition: transform 0.2s;"></i>
                            <div class="bg-soft-success text-success rounded-1 p-1 me-2 d-flex align-items-center justify-content-center">
                                <i class="feather-grid" style="width: 14px; height: 14px;"></i>
                            </div>
                            <span class="fw-bold fs-11 text-dark text-uppercase tracking-wider">Rincian Volume</span>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-sm table-bordered mb-0">
                                <thead class="bg-light fs-11">
                                    <tr>
                                        <th class="text-center" style="width: 50px;">No</th>
                                        <th class="text-center">P (cm)</th>
                                        <th class="text-center">L (cm)</th>
                                        <th class="text-center">T (cm)</th>
                                        <th class="text-center">Koli</th>
                                        <th class="text-center">Jumlah (m3/kg)</th>
                                        <th class="text-center" style="width: 100px;">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody id="detail_container_${rowId}">
                                    <!-- Detail rows -->
                                </tbody>
                                <tfoot class="bg-light fw-bold fs-11">
                                    <tr>
                                        <td colspan="4" class="text-end">Summary</td>
                                        <td class="text-center"><span class="total-koli-sub">0</span></td>
                                        <td class="text-center"><span class="total-jumlah-sub">0</span></td>
                                        <td class="text-center">
                                            <button type="button" class="btn btn-xs btn-primary py-0 px-2" onclick="kalkulasiItem(${rowId})">Kalkulasi</button>
                                        </td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            `;

            $('#itemContainer').append(html);
            // Populate details if they exist
            if (data.details && data.details.length > 0) {
                data.details.forEach(detail => {
                    addDetailRow(rowId, detail);
                });
            }
            
            togglePLT(rowId); // Set initial state (will add 1 empty row via togglePLT if no details)

            return rowId;
        }

        function handleInput(element, rowId) {
            if ($(element).hasClass('qty-input')) {
                formatDecimalInput(element);
            } else if ($(element).hasClass('price-input')) {
                formatCurrencyInput(element);
            }
            // For koli-input (number type), we don't need additional formatting
            calculateSubtotal(rowId);
        }

        function handleFeeInput(element, feeId) {
            formatCurrencyInput(element);
            
            const row = $(`#fee_${feeId}`);
            const priceDisplay = row.find('.fee-price-input').val();
            const price = parseCurrency(priceDisplay);
            $(`#fee_harga_hidden_${feeId}`).val(price);

            calculateTotal();
        }

        function addFee() {
            addFeeRow({});
        }

        function addFeeRow(data) {
            const rowId = feeIndex++;
            const nama = data.nama || '';
            let harga = data.harga || 0;
            
            const formatVal = (n) => {
                if (!n) return '';
                let parts = n.toString().split('.');
                parts[0] = parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, ".");
                return parts.join(',');
            };
            
            const html = `
                <div class="row align-items-end gx-2 gy-3 mb-3 pb-3 border-bottom fee-row" id="fee_${rowId}">
                    <div class="col-md-6">
                        <label class="form-label fs-12 mb-1 text-muted">Nama Biaya (Misal: Jasa Forklift)</label>
                        <input type="text" class="form-control" name="additional_fees[${rowId}][nama]" value="${nama}" placeholder="Contoh: Forklift">
                    </div>
                    <div class="col-md-5">
                        <label class="form-label fs-12 mb-1 text-muted">Harga</label>
                        <div class="input-group">
                            <span class="input-group-text px-2">Rp</span>
                            <input type="text" class="form-control fee-price-input" value="${formatVal(harga)}" oninput="handleFeeInput(this, ${rowId})" placeholder="0">
                        </div>
                        <input type="hidden" name="additional_fees[${rowId}][harga]" id="fee_harga_hidden_${rowId}" value="${harga}" class="fee-hidden-price">
                    </div>
                    <div class="col-md-1 text-end">
                        <label class="form-label fs-12 mb-1 text-muted d-none d-md-block">&nbsp;</label>
                        <button type="button" class="btn btn-soft-danger btn-icon" onclick="removeFeeRow(${rowId})">
                            <i class="feather-trash-2"></i>
                        </button>
                    </div>
                </div>
            `;
            $('#feeContainer').append(html);
        }

        function removeFeeRow(id) {
            $(`#fee_${id}`).remove();
            calculateTotal();
        }

        function removeRow(id) {
            $(`#row_${id}`).remove();
            calculateTotal();
        }

        function calculateSubtotal(id) {
            const row = $(`#row_${id}`);
            if (row.length === 0) return;

            const satuan = row.find('select[name*="[satuan]"]').val();
            const koliVal = parseFloat(row.find('.koli-input').val()) || 0;
            
            // Sync Jumlah if Unit to 0
            if (satuan === 'Unit') {
                row.find('.qty-input').val('0');
            }

            const qtyDisplay = row.find('.qty-input').val();
            const priceDisplay = row.find('.price-input').val();

            const qty = parseCurrency(qtyDisplay);
            const price = parseCurrency(priceDisplay);

            $(`#jumlah_hidden_${id}`).val(qty);
            $(`#harga_satuan_hidden_${id}`).val(price);

            let rawSubtotal = 0;
            if (satuan === 'Unit') {
                rawSubtotal = koliVal * price;
            } else {
                rawSubtotal = qty * price;
            }
            const subtotal = rawSubtotal;

            $(`#subtotal_input_${id}`).val(subtotal);
            $(`#subtotal_display_${id}`).val(new Intl.NumberFormat('id-ID').format(subtotal));

            calculateTotal();
        }

        function calculateTotal() {
            let totalDPP = 0;
            $('#itemContainer .item-row').each(function() {
                const subtotal = parseFloat($(this).find('input[name*="[subtotal]"]').val()) || 0;
                totalDPP += subtotal;
            });

            let totalFees = 0;
            $('#feeContainer .fee-row').each(function() {
                const feePrice = parseFloat($(this).find('.fee-hidden-price').val()) || 0;
                totalFees += feePrice;
            });

            const pkpStatus = $('#pkp_status').val();
            let ppn = 0;
            const totalDasar = totalDPP + totalFees;
            if (pkpStatus === 'PKP') {
                // PKP dihitung dari (total Barang + total Tambahan)
                ppn = totalDasar * 0.011;
            }

            const grandTotal = totalDasar + ppn;

            $('#totalDPP').text(new Intl.NumberFormat('id-ID').format(totalDPP));
            $('#totalPPN').text(new Intl.NumberFormat('id-ID').format(ppn));
            $('#totalFee').text(new Intl.NumberFormat('id-ID').format(totalFees));
            $('#grandTotal').text(new Intl.NumberFormat('id-ID').format(grandTotal));
        }
    </script>
@endpush
