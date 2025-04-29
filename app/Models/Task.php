<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'due_date',
        'priority',
        'is_completed',
        'user_id'
    ];

    protected $casts = [
        'due_date' => 'date',
        'is_completed' => 'boolean'
    ];

    public function user():BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
