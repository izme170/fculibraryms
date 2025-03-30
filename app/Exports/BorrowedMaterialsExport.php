<?php

namespace App\Exports;

use App\Models\BorrowedMaterial;
use Carbon\Carbon;
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
        $this->startDate = !empty($startDate) ? Carbon::parse($startDate)->startOfDay() : null;
        $this->endDate = !empty($endDate) ? Carbon::parse($endDate)->endOfDay() : null;
    }

    public function query()
    {
        return BorrowedMaterial::query()
            ->when($this->status === 'returned', fn($query) => $query->whereNotNull('returned'))
            ->when($this->status === 'borrowed', fn($query) => $query->whereNull('returned'))
            ->when($this->status === 'overdue', fn($query) => $query->whereNull('returned')->where('due_date', '<', now()))
            ->when(!empty($this->search), function ($query) {
                $query->whereHas('materialCopy.material', function ($query) {
                    $query->where('title', 'like', "%{$this->search}%");
                })->orWhereHas('patron', function ($query) {
                    $query->where('first_name', 'like', "%{$this->search}%")
                        ->orWhere('last_name', 'like', "%{$this->search}%");
                })->orWhereHas('user', function ($query) {
                    $query->where('first_name', 'like', "%{$this->search}%")
                        ->orWhere('last_name', 'like', "%{$this->search}%");
                });
            })
            ->when(!empty($this->startDate) && empty($this->endDate), fn($query) => $query->where('created_at', '>=', $this->startDate))
            ->when(empty($this->startDate) && !empty($this->endDate), fn($query) => $query->where('created_at', '<=', $this->endDate))
            ->when(!empty($this->startDate) && !empty($this->endDate), fn($query) => $query->whereBetween('created_at', [$this->startDate, $this->endDate]));
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
