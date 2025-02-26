<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BorrowedBook extends Model
{
    use HasFactory;
    protected $table = 'borrowed_books';
    protected $primaryKey = 'borrow_id';
    protected $fillable = [
        'copy_id',
        'patron_id',
        'user_id',
        'due_date',
        'returned',
        'fine',
        'remark_id'
    ];

    protected $casts = [
        'returned' => 'datetime'
    ];

    protected $appends = [
        'fine'
    ];

    public function getFineAttribute()
    {
        if ($this->returned) {
            return 0;
        }

        $dueDate = Carbon::parse($this->due_date);
        $now = Carbon::now();

        if ($now->greaterThan($dueDate)) {
            $hoursLate = $dueDate->diffInHours($now, false);
            return (int)$hoursLate * 5; // 5 units per hour
        }

        return 0;
    }

    public function bookCopy()
    {
        return $this->belongsTo(BookCopy::class, 'copy_id');
    }

    public function patron()
    {
        return $this->belongsTo(Patron::class, 'patron_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function remark()
    {
        return $this->belongsTo(Remark::class, 'remark_id');
    }
}
