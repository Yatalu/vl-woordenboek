<?php

use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('admin_action_logs', static function (Blueprint $table): void {
            $table->id();
            $table->foreignIdFor(User::class, 'causer_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignIdFor(User::class, 'subject_id')->constrained()->cascadeOnDelete();
            $table->string('action');
            $table->text('description');
            $table->ipAddress();
            $table->text('user_agent');
            $table->timestamps();
        });
    }
};
