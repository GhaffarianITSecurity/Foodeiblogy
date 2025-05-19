<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('full_name')->nullable()->after('last_name');
        });

        // Update existing records to combine first_name and last_name
        DB::table('users')
            ->whereNull('full_name')
            ->orderBy('id')
            ->each(function ($user) {
                $fullName = trim($user->first_name . ' ' . $user->last_name);
                DB::table('users')
                    ->where('id', $user->id)
                    ->update(['full_name' => $fullName]);
            });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('full_name');
        });
    }
};
