<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;
/**
 * @property int     $id            The unique identifier from the log entry.
 * @property ?int    $causer_id     The unique identifier from the user who performed the handling.
 * @property int     $subject_id    The unique identifier from the user that was impacted by tyhe handling.
 * @property string  $action        The action name that was performed on the system.
 * @property string  $description   The description of the logged handling in the user management. 
 * @property string  $ip_addrees    The ip_address from the user.
 * @property string  $user_agent    The user agent from the device where the handling is performed on. 
 * @property Carbon  $created_at    The unique timestamp that indicates when the handling is recorded. 
 * @property Carbon  $updated_at    The unique timestamp that indicates when the entry last was modified.
 * 
 * @property-read User $causer
 * 
 * @package App\Models 
 */
final class AdminActionLog extends Model
{
    /**
     * @var list<string>
     */
    protected $guarded = ['id'];

    public function causer(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
