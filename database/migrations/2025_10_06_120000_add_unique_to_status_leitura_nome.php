<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void
    {
        // Remove duplicados mantendo apenas o primeiro id de cada nome
        $duplicados = DB::table('status_leitura')
            ->select('nome')
            ->groupBy('nome')
            ->havingRaw('COUNT(*) > 1')
            ->pluck('nome');

        foreach ($duplicados as $nome) {
            $ids = DB::table('status_leitura')->where('nome', $nome)->orderBy('id')->pluck('id');
            $idsParaExcluir = $ids->slice(1); // todos menos o primeiro
            if ($idsParaExcluir->isNotEmpty()) {
                DB::table('status_leitura')->whereIn('id', $idsParaExcluir)->delete();
            }
        }

        Schema::table('status_leitura', function (Blueprint $table) {
            if (!Schema::hasColumn('status_leitura', 'nome')) return; // proteção
            $table->unique('nome');
        });
    }

    public function down(): void
    {
        Schema::table('status_leitura', function (Blueprint $table) {
            $table->dropUnique(['nome']);
        });
    }
};
