<?php

namespace App\Exports;

use App\Models\PatronLogin;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class PatronLoginsExport implements FromQuery, WithHeadings, WithMapping
{
    protected $search;
    protected $startDate;
    protected $endDate;

    public function __construct($search, $startDate, $endDate)
    {
        $this->search = $search;
        $this->startDate = !empty($startDate) ? Carbon::parse($startDate)->startOfDay() : null;
        $this->endDate = !empty($endDate) ? Carbon::parse($endDate)->endOfDay() : null;
    }

    public function query()
    {
        return PatronLogin::query()
        ->when(!empty($this->search), function($query){
            $query->whereHas('patron', function($query){
                $query->where('first_name', 'like', "%{$this->search}%")
                ->orWhere('last_name', 'like', "%{$this->search}%");
            })->orWhereHas('marketer', function($query){
                $query->where('name', 'like', "%{$this->search}%");
            })->orWhereHas('purpose', function($query){
                $query->where('purpose', 'like', "%{$this->search}%");
            });
        })->when(!empty($this->startDate) && empty($this->endDate), fn($q) => $q->where('login_at', '>=', $this->startDate))
        ->when(empty($this->startDate) && !empty($this->endDate), fn($q) => $q->where('login_at', '<=', $this->endDate))
        ->when(!empty($this->startDate) && !empty($this->endDate), fn($q) => $q->whereBetween('login_at', [$this->startDate, $this->endDate]));
    }

    public function headings(): array
    {
        return [
            'Patron Name',
            'Purpose',
            'Marketer',
            'Login',
            'Logout'
        ];
    }

    public function map($patronLogin): array{
        return [
            $patronLogin->patron->fullname,
            $patronLogin->purpose->purpose ?? 'Not specified',
            $patronLogin->marketer->name ?? 'Not specified',
            $patronLogin->login_at,
            $patronLogin->logout_at
        ];
    }
}
