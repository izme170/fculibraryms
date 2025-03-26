<?php

namespace App\Exports;

use App\Models\BorrowedMaterial;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class BorrowedMaterialsExport implements FromQuery, WithHeadings, WithMapping
{
    protected $status;
    protected $search;
    protected $startDate;
    protected $endDate;

    public function __construct($status, $search, $startDate, $endDate)
    {
        $this->status = $status;
        $this->search = $search;
        $this->startDate = $startDate;
        $this->endDate = $endDate;
    }

    public function query()
    {
        return BorrowedMaterial::query()
            ->when($this->status === 'returned', fn($q) => $q->whereNotNull('returned'))
            ->when($this->status === 'borrowed', fn($q) => $q->whereNull('returned'))
            ->when($this->status === 'overdue', fn($q) => $q->whereNull('returned')->where('due_date', '<', now()))
            ->when(!empty($this->search), function ($q) {
                $q->whereHas('materialCopy.material', function ($q) {
                    $q->where('title', 'like', "%{$this->search}%");
                })->orWhereHas('patron', function ($q) {
                    $q->where('first_name', 'like', "%{$this->search}%")
                        ->orWhere('last_name', 'like', "%{$this->search}%");
                })->orWhereHas('user', function ($q) {
                    $q->where('first_name', 'like', "%{$this->search}%")
                        ->orWhere('last_name', 'like', "%{$this->search}%");
                });
            })
            ->when(!empty($this->startDate) && empty($this->endDate), fn($q) => $q->where('created_at', '>=', $this->startDate))
            ->when(empty($this->startDate) && !empty($this->endDate), fn($q) => $q->where('created_at', '<=', $this->endDate))
            ->when(!empty($this->startDate) && !empty($this->endDate), fn($q) => $q->whereBetween('created_at', [$this->startDate, $this->endDate]));
    }

    public function headings(): array
    {
        return [
            'Date',
            'Patron Name',
            'Material Type',
            'Material Title',
            'Due Date',
            'Returned At',
            'Fine',
            'Condition Before',
            'Condition After'
        ];
    }

    public function map($borrowedMaterial): array
    {
        return [
            $borrowedMaterial->created_at,
            $borrowedMaterial->patron ? $borrowedMaterial->patron->first_name . ' ' . $borrowedMaterial->patron->last_name : 'Unknown Patron',
            $borrowedMaterial->materialCopy->material->materialType->name,
            $borrowedMaterial->materialCopy->material->title ?? 'Unknown Material',
            $borrowedMaterial->due_date,
            $borrowedMaterial->returned ? $borrowedMaterial->returned->format('Y-m-d H:i:s') : 'Not Returned',
            $borrowedMaterial->fine,
            $borrowedMaterial->conditionBefore->name ?? 'Not Specified',
            $borrowedMaterial->conditionAfter->name ?? 'Not Specified'
        ];
    }
}
