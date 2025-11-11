<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        if (Schema::hasTable('indikator_posyandu')) {
            return; // Guard: table already exists (created manually or by previous run)
        }

        Schema::create('indikator_posyandu', function (Blueprint $table) {
            $table->id();
            $table->string('kategori');
            $table->string('label');
            $table->string('metrik');
            $table->string('subkategori')->nullable();
            $table->integer('nilai')->nullable();
            $table->timestamps();
            $table->index(['kategori', 'label']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('indikator_posyandu');
    }
};
