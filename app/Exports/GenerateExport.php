<?php

namespace App\Exports;

use App\Models\Generate;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class GenerateExport implements FromCollection, WithHeadings, WithMapping
{
    protected $date;
    /**
     * @return \Illuminate\Support\Collection
     */

    public function __construct($date)
    {
        $this->date = $date;

    }

    public function collection()
    {
        return Generate::where('event_date', $this->date)->orderBy('id', 'desc')->get();
    }

    public function map($row): array
    {
        $fields = [
            $row->id,
            $row->event_date,
            $row->random_no,
            $row->name,
            $row->mobile,
        ];
        return $fields;
    }

    public function headings(): array
    {
        return [
            'id',
            'Date',
            'Random no',
            'Name',
            'Mobile no',
        ];
    }
}
