<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Debug Kubikasi - SIMPARI</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        body { background-color: #f8f9fc; }
        .table > :not(caption) > * > * { padding: 0.75rem; vertical-align: middle; }
        .vol-web { background-color: #e8f4fd !important; }
        .vol-excel { background-color: #e8fdf2 !important; }
    </style>
</head>
<body>
    <div class="container py-5">
        <div class="row justify-content-center mb-4">
            <div class="col-lg-10 text-center">
                <h2 class="fw-bold text-dark">Debug Perhitungan Kubikasi</h2>
                <p class="text-muted">Halaman ini digunakan untuk membandingkan secara langsung logika perhitungan "Website" dengan "Excel".<br>Tidak terhubung dengan database.</p>
            </div>
        </div>

        <div class="card shadow-sm border-0 mb-4">
            <div class="card-body p-4">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover align-middle">
                        <thead class="table-dark text-center">
                            <tr>
                                <th width="5%">No</th>
                                <th width="12%">P (CM)</th>
                                <th width="12%">L (CM)</th>
                                <th width="12%">T (CM)</th>
                                <th width="10%">KOLI</th>
                                <th width="20%" class="bg-primary border-primary">LOGIKA WEB<br><small class="fw-normal">(Truncate 3 digit)</small></th>
                                <th width="20%" class="bg-success border-success">LOGIKA EXCEL<br><small class="fw-normal">(Raw Accumulation)</small></th>
                                <th width="9%">Aksi</th>
                            </tr>
                        </thead>
                        <tbody id="detail_container">
                            <!-- Rows will be added here -->
                        </tbody>
                        <tfoot class="table-light fw-bold text-center fs-5">
                            <tr>
                                <td colspan="4" class="text-end pe-3">TOTAL:</td>
                                <td id="total_koli">0</td>
                                <td id="total_volume_web" class="text-primary vol-web">0.000</td>
                                <td id="total_volume_excel" class="text-success vol-excel">0.000</td>
                                <td></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
                <div class="d-flex justify-content-between mt-3">
                    <div>
                        <button type="button" class="btn btn-outline-secondary btn-sm me-2" onclick="loadTestData()">Load Data Test (Contoh Gambar)</button>
                    </div>
                    <div>
                        <button type="button" class="btn btn-primary" onclick="addRow()">+ Tambah Baris</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="alert alert-primary border-0 shadow-sm">
                    <h5 class="fw-bold"><i class="bi bi-info-circle"></i> Kenapa Web Berbeda?</h5>
                    <p class="mb-0 small">
                        Logika website saat ini menggunakan metode <strong>Truncate (potong)</strong> ke 3 angka desimal untuk setiap baris, lalu <strong>menjumlahkan hasil yang sudah dipotong tersebut</strong>.<br><br>
                        Contoh: <code>57 x 25 x 43 / 1.000.000 = 0.061275</code><br>
                        Di web dipotong menjadi <code>0.061</code>. Ketika dijumlahkan semua baris, web menjumlahkan nilai <code>0.061 + 0.049 + ...</code>
                    </p>
                </div>
            </div>
            <div class="col-md-6">
                <div class="alert alert-success border-0 shadow-sm">
                    <h5 class="fw-bold"><i class="bi bi-info-circle"></i> Kenapa Excel Berbeda?</h5>
                    <p class="mb-0 small">
                        Logika Excel menggunakan nilai asli tanpa dipotong (floating point raw).<br><br>
                        Excel menjumlahkan secara utuh <code>0.061275 + 0.049896 + ...</code> lalu total akhirnya baru di-round / dibulatkan ke 3 desimal untuk ditampilkan. Inilah yang menyebabkan selisih pada total akhirnya.
                    </p>
                </div>
            </div>
        </div>
        
    </div>

    <script>
        // ==========================================
        // LOGIKA WEB (Sama persis dengan form.blade.php)
        // ==========================================
        function formatValTruncate(n, precision = 3) {
            if (n === null || n === undefined || n === '') return '0';
            let val = parseFloat(n);
            if (isNaN(val)) return '0';
            
            // Truncate by multiplying 10^precision, floor, then dividing back
            let factor = Math.pow(10, precision);
            let truncated = Math.floor(val * factor) / factor;
            
            let str = truncated.toFixed(precision);
            return str;
        }

        function parseCurrency(value) {
            if (!value) return 0;
            if (typeof value === 'number') return value;
            let clean = value.toString().replace(/\./g, '').replace(/,/g, '.');
            return parseFloat(clean) || 0;
        }

        // ==========================================
        // MAIN CALCULATE
        // ==========================================
        function calculate() {
            let totalKoli = 0;
            let totalJumlahWeb = 0;
            let totalJumlahExcel = 0; // Float murni akumulasi

            $('#detail_container tr').each(function() {
                const p = parseFloat($(this).find('.input-p').val()) || 0;
                const l = parseFloat($(this).find('.input-l').val()) || 0;
                const t = parseFloat($(this).find('.input-t').val()) || 0;
                const koli = parseFloat($(this).find('.input-koli').val()) || 0;

                // 1. LOGIKA WEB (Sesuai form.blade.php)
                let resultRaw = (p * l * t * koli) / 1000000;
                let volumeWebDisplayed = formatValTruncate(resultRaw, 3);
                $(this).find('.vol-web').text(volumeWebDisplayed);
                
                // Web menjumlahkan nilai yang SUDAH di truncate
                let truncatedRowVal = parseCurrency(volumeWebDisplayed);
                totalJumlahWeb += truncatedRowVal;

                // 2. LOGIKA EXCEL (Pure Float Accumulation)
                // Excel menampilkan pembulatan per baris (optional, tapi kita show exact/round)
                let volumeExcelDisplayed = resultRaw.toFixed(3); 
                $(this).find('.vol-excel').text(volumeExcelDisplayed);
                
                // Excel menjumlahkan nilai float murninya
                totalJumlahExcel += resultRaw;

                totalKoli += koli;
            });

            // Clean up floating point noise for Web just like in system
            totalJumlahWeb = Math.round(totalJumlahWeb * 1000) / 1000;

            $('#total_koli').text(totalKoli);
            
            // Total Web (Truncate dari nilai akumulasi yang truncate)
            $('#total_volume_web').text(formatValTruncate(totalJumlahWeb, 3));
            
            // Total Excel (Dibulatkan dari nilai akumulasi pure float)
            $('#total_volume_excel').text(totalJumlahExcel.toFixed(3));
        }

        let rowIndex = 0;
        function addRow(p = '', l = '', t = '', koli = 1) {
            rowIndex++;
            const html = `
                <tr>
                    <td class="text-center row-number">${rowIndex}</td>
                    <td><input type="number" class="form-control form-control-sm text-center input-p" placeholder="0" value="${p}" oninput="calculate()"></td>
                    <td><input type="number" class="form-control form-control-sm text-center input-l" placeholder="0" value="${l}" oninput="calculate()"></td>
                    <td><input type="number" class="form-control form-control-sm text-center input-t" placeholder="0" value="${t}" oninput="calculate()"></td>
                    <td><input type="number" class="form-control form-control-sm text-center input-koli" placeholder="0" value="${koli}" oninput="calculate()"></td>
                    <td class="text-center fw-bold text-primary vol-web">0.000</td>
                    <td class="text-center fw-bold text-success vol-excel">0.000</td>
                    <td class="text-center">
                        <button type="button" class="btn btn-sm btn-outline-danger" onclick="removeRow(this)">Hapus</button>
                    </td>
                </tr>
            `;
            $('#detail_container').append(html);
            updateRowNumbers();
            calculate();
        }

        function removeRow(btn) {
            if ($('#detail_container tr').length > 1) {
                $(btn).closest('tr').remove();
                updateRowNumbers();
                calculate();
            } else {
                alert("Minimal 1 baris harus tersisa");
            }
        }

        function updateRowNumbers() {
            $('#detail_container tr').each(function(index) {
                $(this).find('.row-number').text(index + 1);
            });
            rowIndex = $('#detail_container tr').length;
        }

        function loadTestData() {
            $('#detail_container').empty();
            const data = [
                {p: 57, l: 25, t: 43}, {p: 33, l: 42, t: 36}, {p: 50, l: 44, t: 27},
                {p: 36, l: 42, t: 49}, {p: 42, l: 36, t: 32}, {p: 62, l: 52, t: 37},
                {p: 42, l: 34, t: 67}, {p: 44, l: 31, t: 52}, {p: 34, l: 54, t: 34},
                {p: 42, l: 34, t: 55}, {p: 52, l: 59, t: 36}, {p: 39, l: 56, t: 40},
                {p: 32, l: 43, t: 67}, {p: 54, l: 36, t: 63}, {p: 44, l: 32, t: 56},
                {p: 42, l: 32, t: 68}, {p: 49, l: 37, t: 60}, {p: 34, l: 44, t: 44},
                {p: 34, l: 42, t: 67}, {p: 35, l: 40, t: 57}, {p: 35, l: 53, t: 42},
                {p: 42, l: 32, t: 33}, {p: 54, l: 37, t: 4}
            ];
            
            data.forEach(item => {
                addRow(item.p, item.l, item.t, 1);
            });
        }

        // Initialize with one row
        $(document).ready(function() {
            addRow();
        });
    </script>
</body>
</html>
