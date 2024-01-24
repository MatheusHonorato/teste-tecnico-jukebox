<?php

declare(strict_types=1);

namespace App\Models;

use App\Interfaces\TaskInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Task extends Model implements TaskInterface
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'user_id',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
