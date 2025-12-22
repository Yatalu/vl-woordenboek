<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

final class AdminActionLog extends Model
{
    /**
     * @var list<string>
     */
    protected $fillable = ['id'];

    public function causer(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
