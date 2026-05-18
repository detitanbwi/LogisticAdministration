<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

class FinanceRecapExportV2 implements FromView, ShouldAutoSize, WithStyles, WithColumnFormatting
{
    protected $data;
    protected $filters;

    public function __construct(Collection $data, array $filters)
    {
        $this->data = $data;
        $this->filters = $filters;
    }

    public function view(): View
    {
        return view('back.pages.finance.excel_v2', [
            'finances' => $this->data,
            'filters' => $this->filters
        ]);
    }

    public function styles(Worksheet $sheet)
    {
        $sheet->getStyle($sheet->calculateWorksheetDimension())->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);

        $currentRow = 6;
        $redColor = new \PhpOffice\PhpSpreadsheet\Style\Color(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_RED);

        foreach ($this->data as $finance) {
            $inv = $finance->invoice;
            if (!$inv) {
                continue;
            }

            $rowCount = $inv->items && $inv->items->count() > 0 ? $inv->items->count() : 1;
            $endRow = $currentRow + $rowCount - 1;

            // Check Tanda Terima (Col AD)
            if (trim(strtoupper($inv->tanda_terima ?? '')) === 'PENGIRIM') {
                $sheet->getStyle("AD{$currentRow}:AD{$endRow}")->getFont()->setColor($redColor)->setBold(true);
            }
            // Check Masa Tunggakan (Col AL) - jika belum lunas
            if (!$finance->tgl_transfer) {
                $sheet->getStyle("AL{$currentRow}:AL{$endRow}")->getFont()->setColor($redColor)->setBold(true);
            }
            // Check Status Tahan/Serahkan (Col AM)
            if (trim(strtoupper($inv->status_pembayaran ?? '')) === 'TAHAN') {
                $sheet->getStyle("AM{$currentRow}:AM{$endRow}")->getFont()->setColor($redColor)->setBold(true);
            }

            $currentRow = $endRow + 1;
        }

        return [];
    }

    public function columnFormats(): array
    {
        return [
            'W' => '#,##0.###', // Jumlah
            'Y' => '#,##0', // Harga Satuan
            'Z' => '#,##0', // Subtotal
            'AA' => '#,##0', // DPP
            'AB' => '#,##0', // Biaya Tambahan
            'AC' => '#,##0', // Total Tagihan
        ];
    }
}
