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
