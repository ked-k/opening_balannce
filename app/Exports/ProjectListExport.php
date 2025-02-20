<?php

namespace App\Exports;

use App\Models\Finance\Project;
use App\Models\User;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithProperties;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ProjectListExport implements FromCollection, WithMapping, WithHeadings, WithStyles, WithProperties
{
    use Exportable;

    /**
     * @return \Illuminate\Support\Collection
     */
    public $count;

    public $userIds;

    public function __construct(array $userIds)
    {
        $this->count = 0;
        $this->userIds = $userIds;
    }

    public function properties(): array
    {
        return [
            'creator' => auth()->user()->fullName,
            'lastModifiedBy' => 'MERP',
            'title' => 'Users',
            'description' => 'Projects export',
            'subject' => 'Users export',
            'keywords' => 'MERP exports',
            'category' => 'MERP Exports',
            'manager' => 'MERP',
            'company' => 'MERP',
        ];
    }

    public function collection()
    {
        return Project::whereIn('id', $this->userIds)->orderBy('name', 'asc')->get();
    }

    public function map($project): array
    {
        $this->count++;

        return [
            $this->count,
            $project->name ?? '',
            $project->project_code ?? '',
            $project->project_category ?? null,
            $project->merp_amount ?? 0,
            $project->getCurrentBalance() ?? 0,
            $project->getCurrentBalance() + $project->merp_amount,
            $project->project_start_date,
            $project->project_end_date,
            $project->fa_percentage_fee,
            ucfirst($project->progress_status),
        ];
    }

    public function headings(): array
    {
        return [
            '#',
            'Name',
            'Code',
            'Category',
            'MERP Amount',
            'Current Balance',
            'Actual Balance',
            'Start Date',
            'End Date',
            'F&A %',
            'Status',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            // Style the first row as bold text.
            1 => ['font' => ['bold' => true]],
            // Format the second column (Price) as currency
            4 => [
                'numberFormat' => [
                    'formatCode' => NumberFormat::FORMAT_ACCOUNTING_USD, // USD Currency format
                ],
            ],
            // Format the third column (Quantity) as a number (no decimal places)
            5 => [
                'numberFormat' => [
                    'formatCode' => NumberFormat::FORMAT_ACCOUNTING_USD, // Plain number with no decimal
                ],
            ],
            // Format the fourth column (Total) as currency
            6 => [
                'numberFormat' => [
                    'formatCode' => NumberFormat::FORMAT_ACCOUNTING_USD, // USD Currency format
                ],
            ],
        ];
    }
}
