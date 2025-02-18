<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class FmsTrxCombinedExport implements FromView, WithStyles
{
    public $count;

    public $combinedTransactions;
    public $ledger_account;
    public function __construct($combinedTransactions, $ledger_account)
    {
        $this->count = 0;
        $this->combinedTransactions = $combinedTransactions;
        $this->ledger_account = $ledger_account;
    }
    public function view(): View
    {
        return view('livewire.finance.export-combined', [
            'combinedTransactions' => $this->combinedTransactions, 'ledger_account' => $this->ledger_account,
            // Pass any other necessary data
        ]);
    }
    public function styles(Worksheet $sheet)
    {
        return [
            // Apply styles to specific cells or ranges
            'A1:I1' => [
                'font' => [
                    'bold' => true,
                    'size' => 11,
                    'color' => ['rgb' => 'F3F3F3'],
                ],
                'fill' => [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    'startColor' => ['rgb' => '107C41'], //  background
                ],
                'alignment' => [
                    'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                ],
            ],
            // Apply styles to a range of cells
            'A2:G10' => [
                'border' => [
                    'bottom' => ['style' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN],
                ],
            ],
        ];
    }
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        //
    }
}
