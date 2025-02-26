<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FundingSource extends Model
{
    use HasFactory;
    protected $table = 'funding_sources';
    protected $primaryKey = 'fund_id';
    protected $fillable = [
        'name',
    ];
}
