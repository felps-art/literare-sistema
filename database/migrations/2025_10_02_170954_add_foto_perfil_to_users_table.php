<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (!Schema::hasColumn('users', 'foto_perfil')) {
                $table->string('foto_perfil')->nullable()->after('image_profile');
            }
        });

        // Migrar dados existentes de image_profile para foto_perfil (se desejar manter consistência)
        if (Schema::hasColumn('users', 'image_profile')) {
            DB::table('users')
                ->whereNotNull('image_profile')
                ->whereNull('foto_perfil')
                ->update([
                    'foto_perfil' => DB::raw('image_profile')
                ]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (Schema::hasColumn('users', 'foto_perfil')) {
                $table->dropColumn('foto_perfil');
            }
        });
    }
};
