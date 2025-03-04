<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MaterialCopy extends Model
{
    use HasFactory;
    protected $table = 'material_copies';
    protected $primaryKey = 'copy_id';
    protected $fillable = [
        'material_id',
        'copy_number',
        'rfid',
        'accession_number',
        'call_number',
        'price',
        'vendor_id',
        'funding_source_id',
        'notes',
        'is_available',
        'is_archived'
    ];
    protected $casts = [
        'date_acquired' => 'date',
    ];

    protected $appends = [
        'status'
    ];

    public function getStatusAttribute(){
        if($this->is_available){
            return 'Available';
        } else {
            $latestBorrowedCopy = $this->borrowedCopies()->latest()->first();
            if ($latestBorrowedCopy && $latestBorrowedCopy->due_date < Carbon::now()) {
                return 'Overdue';
            }
            return 'Borrowed';
        }
    }

    public function material(){
        return $this->belongsTo(Material::class, 'material_id');
    }

    public function vendor(){
        return $this->belongsTo(Vendor::class, 'vendor_id');
    }

    public function fundingSource(){
        return $this->belongsTo(FundingSource::class, 'fund_id');
    }

    public function borrowedCopies(){
        return $this->hasMany(BorrowedMaterial::class, 'copy_id');
    }
}
