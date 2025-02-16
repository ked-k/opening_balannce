<?php

namespace App\Exports;

use App\Models\Finance\FmsTransaction;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class FmsTrxExport implements FromCollection, WithMapping, WithHeadings, WithStyles
{
    use Exportable;

    /**
     * @return \Illuminate\Support\Collection
     */
    public $count;

    public $exportIds;

    public function __construct(array $exportIds)
    {
        $this->count = 0;
        $this->exportIds = $exportIds;
    }

    public function collection()
    {
        return FmsTransaction::with(['createdBy', 'currency'])->whereIn('id', $this->exportIds)->latest()->get();
    }

    public function map($entry): array
    {
        $this->count++;

        return [
            $this->count,
            $entry->requestable->name ?? 'N/A',
            $entry->trx_no ?? 'N/A',
            $entry->trx_ref ?? 'N/A',
            $entry->trx_date ?? 'N/A',
            $entry->description ?? 'N/A',
            $entry->total_amount,
            $entry->rate,
            $entry->amount_local,
            $entry->currency->code ?? 'N/A',
            $entry->trx_type ?? 'N/A',
        ];
    }

    public function headings(): array
    {
        return [
            '#',
            'Unit',
            'Trx No',
            'Ref',
            'Date',
            'Memo',
            'Trx Amount',
            'Rate',
            'Base Amt',
            'Currency',
            'Type',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            // Style the first row as bold text.
            1 => ['font' => ['bold' => true]],
        ];
    }
}
