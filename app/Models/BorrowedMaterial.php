<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BorrowedMaterial extends Model
{
    use HasFactory;
    protected $table = 'borrowed_materials';
    protected $primaryKey = 'borrow_id';
    protected $fillable = [
        'copy_id',
        'patron_id',
        'user_id',
        'due_date',
        'returned',
        'fine',
        'condition_before',
        'condition_after'
    ];

    protected $casts = [
        'returned' => 'datetime'
    ];

    protected $appends = [
        'fine'
    ];

    public function getFineAttribute()
    {
        if (!is_null($this->attributes['fine'])) {
            return $this->attributes['fine'];
        }

        $dueDate = Carbon::parse($this->due_date);
        $now = Carbon::now();

        if ($now->greaterThan($dueDate)) {
            $hoursLate = $dueDate->diffInHours($now, false);
            return (int)$hoursLate * 5; // 5 units per hour
        }

        return 0;
    }

    public function materialCopy()
    {
        return $this->belongsTo(MaterialCopy::class, 'copy_id');
    }

    public function patron()
    {
        return $this->belongsTo(Patron::class, 'patron_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function conditionBefore()
    {
        return $this->belongsTo(Condition::class, 'condition_before', 'condition_id');
    }

    public function conditionAfter()
    {
        return $this->belongsTo(Condition::class, 'condition_after', 'condition_id');
    }
}
