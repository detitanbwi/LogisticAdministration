# Hasil Analisis Dampak: Penambahan Field P, L, T (Final & Komprehensif)

Dokumen ini merangkum SEMUA area yang terdampak oleh penambahan dimensi (Panjang, Lebar, Tinggi) demi keakuratan estimasi biaya pengembangan.

## 1. Lingkup Arsitektur Inti (Core)
- **Database**: Migrasi kolom `panjang`, `lebar`, `tinggi` pada tabel `invoice_items`.
- **Model**: Update [InvoiceItem.php](file:///d:/xampp/htdocs/invoice-kapal-main/app/Models/InvoiceItem.php) ($fillable & cast).
- **Validation**: Update [StoreInvoiceRequest](file:///d:/xampp/htdocs/invoice-kapal-main/app/Http/Requests/Back/StoreInvoiceRequest.php#7-48) & `UpdateInvoiceRequest` (Rule: P, L, T wajib jika satuan != 'Unit').
- **Backend**: Update [InvoiceController.php](file:///d:/xampp/htdocs/invoice-kapal-main/app/Http/Controllers/Back/InvoiceController.php) pada logic [store](file:///d:/xampp/htdocs/invoice-kapal-main/app/Http/Controllers/Back/ContainerCostController.php#78-118) & [update](file:///d:/xampp/htdocs/invoice-kapal-main/app/Http/Controllers/Back/CustomerController.php#90-96) (Auto calculate `jumlah = P * L * T * koli`).
- **UI Form**: Update [invoice/form.blade.php](file:///d:/xampp/htdocs/invoice-kapal-main/resources/views/back/pages/invoice/form.blade.php) (JS calculation & visibility toggles).

## 2. Lingkup Pelaporan Invoice & Finance
- **Print**: [invoice/print.blade.php](file:///d:/xampp/htdocs/invoice-kapal-main/resources/views/back/pages/invoice/print.blade.php) (Tambah kolom P, L, T di tabel item).
- **Excel**: 
    - [invoice/excel.blade.php](file:///d:/xampp/htdocs/invoice-kapal-main/resources/views/back/pages/invoice/excel.blade.php) (Update kolom rekap harian).
    - [finance/excel.blade.php](file:///d:/xampp/htdocs/invoice-kapal-main/resources/views/back/pages/finance/excel.blade.php) (Update kolom rekap finance).

## 3. Lingkup Manifest & Operasional (Container)
Area ini menarik data dari [InvoiceItem](file:///d:/xampp/htdocs/invoice-kapal-main/app/Models/InvoiceItem.php#8-33), sehingga template outputnya juga harus disesuaikan.

### Packing List (Manifest Container)
Data dimensi sangat krusial di manifest untuk verifikasi volume barang dalam kontainer.
- **[resources/views/back/pages/packing-list/print.blade.php](file:///d:/xampp/htdocs/invoice-kapal-main/resources/views/back/pages/packing-list/print.blade.php)**: Penambahan kolom P, L, T pada baris item per invoice.
- **[resources/views/back/pages/packing-list/excel.blade.php](file:///d:/xampp/htdocs/invoice-kapal-main/resources/views/back/pages/packing-list/excel.blade.php)**: Penambahan kolom P, L, T agar admin bisa mengolah data volume total di Excel.

### Container Cost (Laporan Pembayaran)
Membantu verifikasi perhitungan subtotal barang yang menjadi dasar tagihan.
- **[resources/views/back/pages/container-cost/print.blade.php](file:///d:/xampp/htdocs/invoice-kapal-main/resources/views/back/pages/container-cost/print.blade.php)**: Penambahan kolom P, L, T pada breakdown invoice.
- **[resources/views/back/pages/container-cost/excel.blade.php](file:///d:/xampp/htdocs/invoice-kapal-main/resources/views/back/pages/container-cost/excel.blade.php)**: Penambahan kolom P, L, T untuk rekonsiliasi data biaya operasional vs volume barang.

---

> [!IMPORTANT]
> **Summary Dampak**: Terdapat total **12+ file** yang perlu dimodifikasi (3 Controller/Request, 2 Database/Model, 7 View Blade). Perubahan ini akan memengaruhi hampir seluruh alur administrasi barang dari input hingga laporan laba/rugi kontainer.
