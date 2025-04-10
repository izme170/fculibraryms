<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class UnreturnedMaterialsExport implements FromView
{
    protected $unreturnedMaterials;

    public function __construct($unreturnedMaterials)
    {
        $this->unreturnedMaterials = $unreturnedMaterials;
    }

    public function view(): View
    {
        return view('exports.unreturned_materials', [
            'unreturned_materials' => $this->unreturnedMaterials,
        ]);
    }
}