<?php

namespace App\Exports;

use App\Models\BarangayPati;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Illuminate\Support\Collection;


class BarangayPatientReportExport implements FromCollection, WithHeadings
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
            'first_name',
            'last_name',
            'birthdate',
            'age',
            'gender',
            'Created At',
            'Updated At',
        ];
    }
}
