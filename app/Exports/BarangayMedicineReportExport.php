<?php

namespace App\Exports;

use App\Models\BarangayMedicine;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Illuminate\Support\Collection;


class MedicineReportExport implements FromCollection, WithHeadings
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
            'generic_name',
            'brand_name',
            'category_id',
            'price',
            'stocks',
            'expiration_date',
            'Created At',
            'Updated At',
        ];
    }
}
