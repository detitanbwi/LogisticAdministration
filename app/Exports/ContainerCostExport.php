<?php

namespace App\Exports;

use App\Models\Container;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ContainerCostExport implements FromView, ShouldAutoSize, WithStyles
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
        return [];
    }
}
