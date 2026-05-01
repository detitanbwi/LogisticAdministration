<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;

class GenericArrayExport implements FromCollection, ShouldAutoSize, WithStyles, WithColumnFormatting
{
    protected $data;
    protected $headings;
    protected $title;
    protected $meta;

    public function __construct(array $data, array $headings, string $title = 'REKAPITULASI', array $meta = [])
    {
        $this->data = collect($data);
        $this->headings = $headings;
        $this->title = $title;
        $this->meta = $meta;
    }

    public function collection()
    {
        return $this->data;
    }

    public function styles(Worksheet $sheet)
    {
        $lastCol = $sheet->getHighestColumn();
        $lastRow = $sheet->getHighestRow();

        // Title styling
        $sheet->mergeCells("B1:{$lastCol}1");
        $sheet->getStyle('B1')->getFont()->setBold(true)->setSize(14);
        $sheet->getStyle('B1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        // Subtitle styling
        $sheet->mergeCells("B2:{$lastCol}2");
        $sheet->getStyle('B2')->getFont()->setBold(true)->setSize(11);
        $sheet->getStyle('B2')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        // Header styling (Row 4)
        $headerRange = "B4:{$lastCol}4";
        $sheet->getStyle($headerRange)->getFont()->setBold(true);
        $sheet->getStyle($headerRange)->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setRGB('FCE4D6');
        $sheet->getStyle($headerRange)->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);
        $sheet->getStyle($headerRange)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        // Content styling - Apply borders to EVERYTHING from B4 to End
        $fullRange = "B4:{$lastCol}{$lastRow}";
        $sheet->getStyle($fullRange)->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);
        $sheet->getStyle($fullRange)->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);

        // Auto-merge logic for grouped rows (rowspan replacement)
        // Merge starts from Column B (index 1) to Column V (index 21) or so
        $mergeCols = $this->meta['type'] == 'invoice' ? range('B', 'V') : range('B', 'U');
        
        // Remove NPWP columns from merge to keep row lines (H, L for Invoice; P, T for Finance)
        $skipCols = $this->meta['type'] == 'invoice' ? ['H', 'L'] : ['P', 'T'];
        $mergeCols = array_diff($mergeCols, $skipCols);

        // Add additional columns for Invoice (DPP, Additional Fee, Total, PKP, etc)
        if ($this->meta['type'] == 'invoice') {
            $mergeCols = array_merge($mergeCols, ['AA', 'AB', 'AC', 'AD', 'AE', 'AF']);
        } else {
             $mergeCols = array_merge($mergeCols, ['X', 'Y', 'Z', 'AA', 'AB', 'AC', 'AD', 'AE', 'AF']);
        }

        foreach ($mergeCols as $col) {
            $startRow = 5;
            for ($row = 6; $row <= $lastRow; $row++) {
                $cellValue = $sheet->getCell($col . $row)->getValue();
                
                // Stop merging if we hit summary rows
                // Look for labels in Column X (Invoice) or V (Finance)
                $labelCol = $this->meta['type'] == 'invoice' ? 'X' : 'V';
                $rowLabel = $sheet->getCell($labelCol . $row)->getValue();
                if (is_string($rowLabel) && (strpos($rowLabel, 'TOTAL') !== false || strpos($rowLabel, 'GRAND') !== false)) {
                     if ($row - 1 > $startRow) {
                        $sheet->mergeCells($col . $startRow . ':' . $col . ($row - 1));
                    }
                    break;
                }

                if ($cellValue !== null && $cellValue !== '') {
                    // Data found, merge previous block
                    if ($row - 1 > $startRow) {
                        $sheet->mergeCells($col . $startRow . ':' . $col . ($row - 1));
                    }
                    $startRow = $row;
                }
                
                // Final merge for last record
                if ($row == $lastRow && $row > $startRow) {
                     // Check if lastRow is data or summary
                     $lastRowLabel = $sheet->getCell($labelCol . $lastRow)->getValue();
                     if (!(is_string($lastRowLabel) && (strpos($lastRowLabel, 'TOTAL') !== false || strpos($lastRowLabel, 'GRAND') !== false))) {
                        $sheet->mergeCells($col . $startRow . ':' . $col . $row);
                     }
                }
            }
        }

        // Summary rows styling - Find rows with TOTAL or GRAND labels
        // Invoice: Label in X (index 23) or AB (index 27)
        // Finance: Label in V (index 21) or Z (index 25)
        for ($row = $lastRow; $row >= $lastRow - 5; $row--) {
             $label1 = $sheet->getCell(($this->meta['type'] == 'invoice' ? 'X' : 'V') . $row)->getValue();
             $label2 = $sheet->getCell(($this->meta['type'] == 'invoice' ? 'AB' : 'Z') . $row)->getValue();
             
             if ((is_string($label1) && (strpos($label1, 'TOTAL') !== false || strpos($label1, 'GRAND') !== false)) ||
                 (is_string($label2) && (strpos($label2, 'TOTAL') !== false || strpos($label2, 'GRAND') !== false))) {
                 
                 $sheet->getStyle("B{$row}:{$lastCol}{$row}")->getFont()->setBold(true);
                 $sheet->getStyle("B{$row}:{$lastCol}{$row}")->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setRGB('F2F2F2');
             }
        }

        return [];
    }

    public function columnFormats(): array
    {
        // Default number formats for common columns if needed
        return [];
    }
}
