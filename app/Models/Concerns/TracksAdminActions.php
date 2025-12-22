<?php 

declare(strict_types=1);

namespace App\Models\Concerns;

use App\Models\AdminActionLog;
use App\Models\User;
use Illuminate\Database\Eloquent\Relations\HasMany;

trait TracksAdminActions
{
    public function adminActions(): HasMany
    {
        return $this->hasMany(AdminActionLog::class, 'subject_id');
    }
    
    public function registerAdminAction(): AdminActionLog
    {
        return $this->adminActions()->create(attributes: [

        ]);
    }
}