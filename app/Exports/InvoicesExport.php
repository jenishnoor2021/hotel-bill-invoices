<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use App\Models\Invoice;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class InvoicesExport implements FromView
{
    protected $invoices;

    public function __construct($invoices)
    {
        $this->invoices = $invoices;
    }

    public function view(): View
    {
        return view('admin.invoice.excel', [
            'invoices' => $this->invoices
        ]);
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        //
    }
}
