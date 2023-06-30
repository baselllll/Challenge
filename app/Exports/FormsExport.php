<?php

namespace App\Exports;

use App\Models\FormBuilder;
use Maatwebsite\Excel\Concerns\FromCollection;

class FormsExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return FormBuilder::all();
    }
}
