# Impact Analysis: Dimensi P, L, T & Fitur Stampel Invoice

Dokumen ini merinci cakupan perubahan yang diperlukan untuk mendukung perhitungan otomatis berdasarkan dimensi (Panjang, Lebar, Tinggi) dan fleksibilitas tampilan stampel pada invoice.

## 1. Perubahan UI (Selesai Tahap 1 & Tahap 2 Progres)
### A. Form Invoice
**File: `resources/views/back/pages/invoice/form.blade.php`**
- Penambahan input field `P`, `L`, dan `T` pada baris item invoice.
- Checkbox **"Tampilkan Stampel & Tandatangan"**.

### B. Tampilan Layar (DataTable / Browser)
**File: `resources/views/back/pages/invoice/index.blade.php`**
- **DITAMBAHKAN**: Kolom `P`, `L`, `T`, `Koli`, dan `Satuan`. Karena satu invoice bisa berisi banyak item, informasi ini akan ditampilkan dalam format list per item pada baris yang sama.
- **DIHILANGKAN**: Informasi detail `Harga Satuan` dan `Subtotal` item (hanya menyisakan Total Tagihan jika diperlukan, sesuai preferensi privasi/ringkasan logistik).

## 2. Dampak pada Output (Estimasi 11 File)
Perubahan ini akan mempengaruhi 11 file yang menghasilkan dokumen PDF (Print) dan Excel rekapitulasi:

### A. Dokumen Cetak (PDF / Print View)
| Nama File | Deskripsi Perubahan |
| :--- | :--- |
| `resources/views/back/pages/invoice/print.blade.php` | Menampilkan dimensi (P x L x T) di tabel barang & Logika @if untuk Stampel/TTD. |
| `resources/views/back/pages/finance/print.blade.php` | Menampilkan dimensi barang pada detail "Informasi Transaksi". |
| `resources/views/back/pages/invoice/index.blade.php` | Menambahkan kolom P, L, T pada tabel rekap di fungsi JS `printTable()`. |
| `resources/views/back/pages/finance/index.blade.php` | Menambahkan detail dimensi pada rekap pembayaran di fungsi JS `printTable()`. |
| `resources/views/back/pages/packing-list/print.blade.php` | Menampilkan detail dimensi lengkap untuk keperluan Surat Jalan. |
| `resources/views/back/pages/container-cost/print.blade.php` | Menampilkan summary dimensi jika diperlukan. |

### B. Dokumen Ekspor (Excel)
| Nama File | Deskripsi Perubahan |
| :--- | :--- |
| `resources/views/back/pages/invoice/excel.blade.php` | Menambahkan kolom P, L, T agar data volume/berat transparan di Excel. |
| `resources/views/back/pages/finance/excel.blade.php` | Menyertakan detail dimensi pada rekap pembayaran Excel. |
| `resources/views/back/pages/packing-list/excel.blade.php` | Detail dimensi per item barang. |
| `resources/views/back/pages/container-cost/excel.blade.php` | Summary dimensi. |
| `resources/views/back/pages/customer/excel.blade.php` | (Opsional) Jika riwayat transaksi customer menyertakan detail item. |

---

## 3. Aturan Khusus & Logika Tampilan
Untuk memastikan visual laporan tetap bersih dan sesuai kebutuhan operasional:
- **Kondisi Satuan 'Unit'**: Jika pilihan satuan adalah `Unit`, kolom `P`, `L`, dan `T` akan dikosongkan (`-`) karena tidak masuk dalam perhitungan volume/berat.
- **Kondisi Satuan 'Kg' / 'M3'**: Kolom `P`, `L`, dan `T` wajib diisi dan akan ditampilkan pada hasil cetak.
- **Visual Rekapitulasi (Index PDF/Excel)**:
  - **DITAMBAHKAN**: Kolom `P`, `L`, `T`, `Koli`, dan `Satuan`.
  - **DIHILANGKAN**: Kolom `Harga Satuan` dan `Subtotal` (agar fokus pada detail logistik, bukan harga).
- **Visual Invoice Satuan (Standard Print PDF)**:
  - Tetap menampilkan kolom `Harga Satuan` dan `Subtotal` (sebagai dokumen resmi penagihan).

## 4. Rencana Teknis Selanjutnya (Database)
Setelah review tampilan UI selesai, langkah berikutnya adalah persistensi data:
- **Migration**: Menambahkan kolom `p`, `l`, `t` (decimal) di tabel `invoice_items`.
- **Migration**: Menambahkan kolom `show_stamp` (boolean) di tabel `invoices`.
- **Controller**: Update `StoreInvoiceRequest` dan `InvoiceController` untuk menyimpan data baru ke database.

## 5. Resource Asset
Gambar PNG harus diletakkan di:
- `public/back/assets/images/stampel.png`
- `public/back/assets/images/tandatangan.png`

---
*Catatan: Dokumen `resources/views/back/pages/laporan/print.blade.php` dikecualikan sesuai arahan user.*
