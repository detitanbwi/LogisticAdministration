# Impact Analysis & Complexity Estimation - Change Requests

Berikut adalah analisis dampak beserta estimasi kompleksitas berdasarkan jumlah komponen yang terdampak:

## 1. Section overview Total pendapatan masuk ke RBAC bagian Dashboard
*(Agar bisa ditampilkan atau dihide untuk role tertentu)*

*   **Estimasi Kompleksitas**: **Rendah (300)**
*   **Berkas & Komponen Terdampak**:
    *   `database/seeders/RolePermissionSeeder.php`: Tambah permission baru.
    *   `resources/views/back/pages/dashboard/index.blade.php`: Penambahan direktif `@can`.
    *   `app/Http/Controllers/Back/DashboardController.php`: Filter data di level controller.

## 2. Rekapitulasi dan container cost masuk RBAC section Finance
*(Penyusunan ulang struktur hak akses agar berada di bawah kategori Finance)*

*   **Estimasi Kompleksitas**: **Sedang (600)**
*   **Berkas & Komponen Terdampak**:
    *   `database/seeders/RolePermissionSeeder.php`: Restrukturisasi namespace permission.
    *   `config/back_menus.php`: Update mapping `'can'` pada menu sidebar.
    *   `app/Http/Controllers/Back/FinanceController.php` & `ContainerCostController.php`: Update logic otorisasi.
    *   `routes/back.php`: Penyesuaian middleware route jika diperlukan.

## 3. Ganti format penanggalan menjadi (cth 12-Jan-2026)
*(Perubahan format tampilan tanggal secara global/laporan)*

*   **Estimasi Kompleksitas**: **Tinggi (800)**
*   **Berkas & Komponen Terdampak**:
    *   **Masif**: Perubahan pada hampir semua file View Laporan (`resources/views/back/pages/*/*.blade.php`).
    *   Perubahan format pada PDF, Excel Export, dan Tabel List (DataTables).
    *   Pengecekan manual pada setiap kolom tanggal untuk memastikan konsistensi format `d-M-Y`.

## 4. Perubahan warna pada semua Excel dan PDF
*(Logic pewarnaan berdasarkan nilai kolom Layanan dan Tanda Terima)*

*   **Estimasi Kompleksitas**: **Sedang (600)**
*   **Berkas & Komponen Terdampak**:
    *   **PDF & Excel Views**: Penambahan CSS inline/kondisional pada file reporting.
    *   `resources/views/back/pages/finance/print.blade.php` & `excel.blade.php`.
    *   Logic pengecekan string ("Tahan", "Pengirim") pada setiap baris data ekspor.

## 5. Bug Fix: Filter Status pada Rekap Invoice & Finance
*(Memperbaiki fungsi filter agar hasil yang ditampilkan sesuai dengan pilihan status)*

*   **Estimasi Kompleksitas**: **Rendah (0)**
*   **Berkas & Komponen Terdampak**:
    *   **`app/Http/Controllers/Back/InvoiceController.php`**: Perbaikan logic pada method `index()` dan `getFilteredInvoices()` untuk sinkronisasi antara input filter UI dengan kolom database (terutama perbedaan antara `status_pembayaran` dan `status_tagihan`).
    *   **`app/Http/Controllers/Back/FinanceController.php`**: Penyesuaian query filter status tagihan.
    *   **`resources/views/back/pages/invoice/index.blade.php` & `finance/index.blade.php`**: Penyesuaian nilai (*value*) pada elemen `<select>` filter agar konsisten dengan data di database.

---
**Total Estimasi Nilai: 2300**

