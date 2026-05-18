<?php

namespace App\Exports;

use App\Models\Container;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ContainerCostExport implements FromView, ShouldAutoSize, WithStyles, WithColumnFormatting
{
    protected $container;

    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    public function view(): View
    {
        return view('back.pages.container-cost.excel', [
            'container' => $this->container,
            'isExport' => true
        ]);
    }

    public function styles(Worksheet $sheet)
    {
        $sheet->setShowGridlines(false);
        $sheet->getStyle($sheet->calculateWorksheetDimension())->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
        return [];
    }

    public function columnFormats(): array
    {
        return [
            'K' => '#,##0.###', // Jumlah
            'M' => '#,##0', // Harga Satuan
            'N' => '#,##0', // Subtotal
            'O' => '#,##0', // DPP
            'P' => '#,##0', // Biaya Tambahan
            'Q' => '#,##0', // Total Tagihan
        ];
    }
}
