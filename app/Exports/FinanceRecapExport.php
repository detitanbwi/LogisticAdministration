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

class FinanceRecapExport implements FromView, ShouldAutoSize, WithStyles, WithColumnFormatting
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
        return view('back.pages.finance.excel', [
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

            // Check Tanda Terima (Col AC)
            if (trim(strtoupper($inv->tanda_terima ?? '')) === 'PENGIRIM') {
                $sheet->getStyle("AC{$currentRow}:AC{$endRow}")->getFont()->setColor($redColor)->setBold(true);
            }
            // Check Masa Tunggakan (Col AK) - jika belum lunas
            if (!$finance->tgl_transfer) {
                $sheet->getStyle("AK{$currentRow}:AK{$endRow}")->getFont()->setColor($redColor)->setBold(true);
            }
            // Check Status Tahan/Serahkan (Col AL)
            if (trim(strtoupper($inv->status_pembayaran ?? '')) === 'TAHAN') {
                $sheet->getStyle("AL{$currentRow}:AL{$endRow}")->getFont()->setColor($redColor)->setBold(true);
            }

            $currentRow = $endRow + 1;
        }

        return [];
    }

    public function columnFormats(): array
    {
        return [
            'V' => '#,##0.###', // Jumlah
            'X' => '#,##0', // Harga Satuan
            'Y' => '#,##0', // Subtotal
            'Z' => '#,##0', // DPP
            'AB' => '#,##0', // Total Tagihan
        ];
    }
}
