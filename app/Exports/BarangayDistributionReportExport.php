<?php

namespace App\Exports;

use App\Models\BarangayDistribution;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Illuminate\Support\Collection;


class BarangayDistributionReportExport implements FromCollection, WithHeadings
{
    protected $reportData;
    protected $fromDate;
    protected $toDate;

    public function __construct($reportData, $fromDate, $toDate)
    {
        $this->reportData = $reportData;
        $this->fromDate = $fromDate;
        $this->toDate = $toDate;
    }

    public function collection()
    {
        return $this->reportData;
    }

    public function headings(): array
    {
        return [
            'ID',
            'barangay_id',
            'patient_id',
            'medicine_id',
            'stocks',
            'checkup_date',
            'diagnose',
            'Created At',
            'Updated At',
        ];
    }
}
