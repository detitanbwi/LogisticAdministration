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
                                                <x-back.select2 label="Tujuan" name="tujuan_id" id="inline_tujuan_id" :options="App\Models\Tujuan::pluck('nama_tujuan', 'id')->toArray()" placeholder="Pilih Tujuan" createOptionForm="#collapseTujuan" toggleType="collapse" />

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
                                                <x-back.text-input name="catatan" label="Catatan Container" placeholder="Tulis catatan (opsional)" />
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
                                <x-back.textarea label="Catatan" name="catatan_muntahan" rows="3"
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
                            <x-back.select2 label="Tanda Terima" name="tanda_terima" :options="['SCJ' => 'SCJ', 'Pengirim' => 'Pengirim']" :selected="$invoice->tanda_terima ?? 'SCJ'" />
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
                url: '{{ route('admin.container.store') }}',
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
            // 1. Get raw value, remove non-numeric chars except comma
            let value = input.value;

            // Allow only digits and comma
            let clean = value.replace(/[^\d,]/g, '');

            // Split by comma to handle decimals
            let parts = clean.split(',');

            // Format integer part (parts[0]) with dots
            parts[0] = parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, ".");

            // Reassemble
            // Limit decimal parts to 1 comma
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
            // Remove dots, replace comma with dot
            // 10.000,50 -> 10000.50
            let clean = value.replace(/\./g, '').replace(/,/g, '.');
            return parseFloat(clean) || 0;
        }

        let itemIndex = 0;
        const initialItems = @json(old('items', isset($invoice) && $invoice->items ? $invoice->items : []));

        if (initialItems.length > 0) {
            initialItems.forEach(item => {
                addItemRow(item);
            });
        } else {
            addItem(); // Add one empty row by default
        }

        function addItem() {
            addItemRow({});
        }

        function addItemRow(data) {
            const rowId = itemIndex++;
            const jenisBarang = data.jenis_barang || '';
            const koli = data.koli || '';

            // Data might come from DB (float) or Old Input (string, possibly formatted or not?)
            // If from DB: 10000.00 (float/string)
            // If from Old: "10000" (clean because we submit clean)

            let jumlah = data.jumlah || 0;
            let hargaSatuan = data.harga_satuan || 0;
            let subtotal = data.subtotal || 0;

            // Format for display
            // If it's a number, format it: 10000 -> 10.000
            // If it has decimal: 10000.5 -> 10.000,5

            const formatVal = (n) => {
                if (!n) return '';
                let parts = n.toString().split('.');
                parts[0] = parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, ".");
                return parts.join(',');
            };

            const jumlahDisplay = formatVal(jumlah);
            const hargaSatuanDisplay = formatVal(hargaSatuan);

            const satuan = data.satuan || 'Unit';

            // We need to ensure subtotal is calculated correctly if data is present
            if (jumlah && hargaSatuan) {
                subtotal = parseFloat(jumlah) * parseFloat(hargaSatuan);
            }

            const html = `
                <div class="row align-items-end gx-2 gy-3 mb-3 pb-3 border-bottom item-row" id="row_${rowId}">
                    <div class="col-md-3">
                        <label class="form-label fs-12 mb-1 text-muted">Jenis Barang</label>
                        <input type="text" class="form-control" name="items[${rowId}][jenis_barang]" value="${jenisBarang}" required placeholder="Contoh: Kayu Jati">
                    </div>
                    <div class="col-md-1 col-4">
                        <label class="form-label fs-12 mb-1 text-muted">Koli</label>
                        <input type="number" class="form-control" name="items[${rowId}][koli]" value="${koli}" required placeholder="1">
                    </div>
                    <div class="col-md-1 col-4">
                        <label class="form-label fs-12 mb-1 text-muted">Jumlah</label>
                        <input type="text" class="form-control qty-input" value="${jumlahDisplay}" required oninput="handleInput(this, ${rowId})" placeholder="0">
                        <input type="hidden" name="items[${rowId}][jumlah]" id="jumlah_hidden_${rowId}" value="${jumlah}">
                    </div>
                    <div class="col-md-1 col-4">
                        <label class="form-label fs-12 mb-1 text-muted">Satuan</label>
                        <select class="form-select" name="items[${rowId}][satuan]" required>
                            <option value="M3" ${satuan === 'M3' ? 'selected' : ''}>M3</option>
                            <option value="Kg" ${satuan === 'Kg' ? 'selected' : ''}>Kg</option>
                            <option value="Unit" ${satuan === 'Unit' ? 'selected' : ''}>Unit</option>
                        </select>
                    </div>
                    <div class="col-md-3 col-10">
                        <label class="form-label fs-12 mb-1 text-muted">Harga Satuan</label>
                        <div class="input-group">
                            <span class="input-group-text px-2">Rp</span>
                            <input type="text" class="form-control price-input" value="${hargaSatuanDisplay}" required oninput="handleInput(this, ${rowId})" placeholder="0">
                        </div>
                        <input type="hidden" name="items[${rowId}][harga_satuan]" id="harga_satuan_hidden_${rowId}" value="${hargaSatuan}">
                    </div>
                    <div class="col-md-2 col-12 mt-3 mt-md-0">
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
                </div>
            `;

            $('#itemContainer').append(html);
        }

        function handleInput(element, rowId) {
            // Format the visible input
            formatCurrencyInput(element);

            // Calculate and update hidden inputs
            calculateSubtotal(rowId);
        }

        function removeRow(id) {
            $(`#row_${id}`).remove();
            calculateTotal();
        }

        function calculateSubtotal(id) {
            const row = $(`#row_${id}`);

            // Get visible values
            const qtyDisplay = row.find('.qty-input').val();
            const priceDisplay = row.find('.price-input').val();

            // Parse to Float for calculation
            const qty = parseCurrency(qtyDisplay);
            const price = parseCurrency(priceDisplay);

            // Update Hidden Inputs (Clean Values)
            $(`#jumlah_hidden_${id}`).val(qty);
            $(`#harga_satuan_hidden_${id}`).val(price);

            const subtotal = qty * price;

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

            const pkpStatus = $('#pkp_status').val();
            let ppn = 0;
            if (pkpStatus === 'PKP') {
                ppn = totalDPP * 0.011;
            }

            const grandTotal = totalDPP + ppn;

            $('#totalDPP').text(new Intl.NumberFormat('id-ID').format(totalDPP));
            $('#totalPPN').text(new Intl.NumberFormat('id-ID').format(ppn));
            $('#grandTotal').text(new Intl.NumberFormat('id-ID').format(grandTotal));
        }
    </script>
@endpush
