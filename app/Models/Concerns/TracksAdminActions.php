<?php 

declare(strict_types=1);

namespace App\Models\Concerns;

use App\Models\AdminActionLog;
use App\Models\User;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Auth;

trait TracksAdminActions
{
    public function adminActions(): HasMany
    {
        return $this->hasMany(AdminActionLog::class, 'subject_id');
    }
    
    public function registerAdminAction(string $action, string $description, ?int $causer = null): AdminActionLog
    {
        return $this->adminActions()->create(attributes: [
            'causer_id' => $causer ?? Auth::user()->getAuthIdentifier(),
            'action' => $action, 
            'description' => $description, 
            'ip_address' => request()->ip(), 
            'user_agent' => request()->userAgent()
        ]);
    }
}