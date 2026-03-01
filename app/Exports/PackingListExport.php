<?php

namespace App\Exports;

use App\Models\Container;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class PackingListExport implements FromView, ShouldAutoSize, WithStyles
{
    protected $container;

    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    public function view(): View
    {
        return view('back.pages.packing-list.excel', [
            'container' => $this->container,
            'isExport' => true
        ]);
    }

    public function styles(Worksheet $sheet)
    {
        // Simple styles as most design will be in blade, but we can enforce some basics
        // Hide the print buttons
        // Unfortunately laravel excel might output the button html as text if not hidden correctly.
        // It's better to create a specific export blade view, but we can rely on the existing one adjusting it slightly or just returning the same view.

        return [
            // Style the first row as bold text.
            // 1    => ['font' => ['bold' => true]],
        ];
    }
}
